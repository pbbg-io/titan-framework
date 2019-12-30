<?php

namespace PbbgIo\TitanFramework\Commands;

use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use PbbgIo\TitanFramework\Cronjobs;
use PbbgIo\TitanFramework\Models\Settings;
use Spatie\Permission\Models\Role;

class InstallTitan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'titan:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Titan Game Engine';

    private $config = [];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->config = collect();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(): void
    {
        $this->sendBanner("First up are some technical questions, like setting up your database");
        $this->askTechnicalQuestions();
        $this->sendBanner("Next up are a few details about the game");
        $this->askGameQuestions();
        $this->sendBanner("Almost done now, just need some details to set you up an admin account");
        $this->askUserQuestions();
        $this->saveConfig();
        $this->installCrons();
        $this->runCommands();
        $this->sendBanner([
            "Installation Configuration Complete!"
        ]);
        $this->sendBanner([
            "You can run your game via the following command",
            "php artisan serve"
        ]);
    }

    public function sendBanner($banner): void
    {

        $output = [];
        $maxLength = 0;

        if (is_array($banner)) {
            foreach ($banner as $line) {
                $maxLength = (Str::length($line) + 12 > $maxLength + 12) ? (Str::length($line) + 12) : ($maxLength + 12);
                $output[] = $line;
            }
        } else {
            $output[] = $banner;
            $maxLength = Str::length($banner) + 12;
        }

        $this->comment(str_repeat('=', $maxLength));
        $this->comment("*" . str_repeat(' ', ($maxLength - 2)) . "*");
        foreach ($output as $message) {
            $this->comment("|     " . $message . '     |');
        }
        $this->comment("*" . str_repeat(' ', ($maxLength - 2)) . "*");
        $this->comment(str_repeat('=', $maxLength));

    }

    private function askConfigQuestion($key, $question, $secret = false): void
    {
        while (!isset($this->config[$key]) || $this->config[$key] === null) {
            if ($secret) {
                $this->config[$key] = $this->secret($question);
            } else {
                $this->config[$key] = $this->ask($question);
            }
        }
    }

    private function askTechnicalQuestions(): void
    {
        $this->askConfigQuestion('db.host', 'What is your database hostname?');
        $this->askConfigQuestion('db.username', 'What is your database username?');
        $this->askConfigQuestion('db.password', 'What is your database password?', true);
        $this->askConfigQuestion('db.database', 'What is your database name?');

        try {
            $this->setupDatabase();
            $this->saveEnv();
            \DB::connection()->getPdo();
        } catch (\Exception $exception) {
            $this->config['db.host'] = null;
            $this->config['db.username'] = null;
            $this->config['db.password'] = null;
            $this->config['db.database'] = null;
            $this->warn("Incorrect database details entered");
            $this->error("Your database isn't setup");
            $this->error($exception);
            $this->askTechnicalQuestions();
        }


        $this->sendBanner([
            'Database Host: ' . $this->config['db.host'],
            'Database Username: ' . $this->config['db.username'],
            'Database Password: ' . $this->config['db.password'],
            'Database Name: ' . $this->config['db.database'],
        ]);

        $this->info("Database Connection Established");

        if (!$this->confirm("Are the above details correct?")) {
            $this->config['db.host'] = null;
            $this->config['db.username'] = null;
            $this->config['db.password'] = null;
            $this->config['db.database'] = null;
            $this->askTechnicalQuestions();
        }
    }

    private function askGameQuestions(): void
    {
        $this->askConfigQuestion('game.name', 'What is your game name?');
        $this->askConfigQuestion('game.owner', 'Who is the game owner?');
        $this->askConfigQuestion('game.description', 'What is the game description?');

        $this->sendBanner([
            'Game name: ' . $this->config['game.name'],
            'Game owner: ' . $this->config['game.owner'],
            'Game description: ' . $this->config['game.description'],
        ]);

        if (!$this->confirm("Are the above details correct?")) {
            $this->config['game.name'] = null;
            $this->config['game.owner'] = null;
            $this->config['game.description'] = null;
            $this->askGameQuestions();
        }
    }

    private function askUserQuestions(): void
    {
        $this->askConfigQuestion('admin.username', 'What will be your username?');
        $this->askConfigQuestion('admin.password', 'What will be your password?', true);
        $this->askConfigQuestion('admin.email', 'Finally, what is your email?');

        $this->sendBanner([
            'Admin Username: ' . $this->config['admin.username'],
            'Admin Password: ' . $this->config['admin.password'],
            'Admin Email: ' . $this->config['admin.email'],
        ]);

        if (!$this->confirm("Are the above details correct?")) {
            $this->config['admin.username'] = null;
            $this->config['admin.password'] = null;
            $this->config['admin.email'] = null;
            $this->askGameQuestions();
        }
    }

    private function saveEnv(): void
    {
        $this->setEnvironmentValue('DB_HOST', $this->config['db.host']);
        $this->setEnvironmentValue('DB_USERNAME', $this->config['db.username']);
        $this->setEnvironmentValue('DB_PASSWORD', $this->config['db.password']);
        $this->setEnvironmentValue('DB_DATABASE', $this->config['db.database']);

    }

    private function saveConfig(): void
    {
        $this->setEnvironmentValue("APP_NAME", $this->config['game.name']);

        \Artisan::call('migrate:fresh');

        \Artisan::call('db:seed --class=AreaSeeder');
        \Artisan::call('db:seed --class=MenuSeeder');
        \Artisan::call('db:seed --class=StatSeeder');
        \Artisan::call('db:seed --class=PermissionSeeder');

        $user = new User();
        $user->name = $this->config['admin.username'];
        $user->password = bcrypt($this->config['admin.password']);
        $user->email = $this->config['admin.email'];
        $user->email_verified_at = new Carbon();
        $user->save();

        $role = new Role();
        $role->name = 'Super Admin';
        $role->save();

        $user->assignRole($role);

        Settings::create([
            'key' => 'game.owner',
            'value' => $this->config['game.owner']
        ]);

        Settings::create([
            'key' => 'game.description',
            'value' => $this->config['game.description']
        ]);

    }

    private function setupDatabase(): void
    {
        \DB::purge('mysql');
        config()->set('database.connections.mysql.host', $this->config['db.host']);
        config()->set('database.connections.mysql.database', $this->config['db.database']);
        config()->set('database.connections.mysql.username', $this->config['db.username']);
        config()->set('database.connections.mysql.password', $this->config['db.password']);

    }

    private function installCrons(): void {
        $cron = new Cronjobs();
        $cron->command = 'titan:extension:flush';
        $cron->cron = "0 0 * * *";
        $cron->enabled = true;
        $cron->save();
    }

    private function runCommands(): void {
        $this->call(RefreshExtensionsCache::class);
    }

    public function setEnvironmentValue($envKey, $envValue): void
    {
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);
        $env = [];

        $tempEnv = explode("\n", $str);

        foreach($tempEnv as $key)
        {
            $keyExplode = explode('=', $key);

            if($keyExplode[0] === '')
                continue;

            $env[$keyExplode[0]] = $keyExplode[1] ?? '';
        }

        $env[$envKey] = $envValue;

        $envFileString = '';

        foreach($env as $key => $value)
        {
            if (stripos($value, ' ') !== false && (!Str::startsWith($value, '"') && !Str::endsWith($value, '"'))) {
                $value = "\"{$value}\"";
            }
            $envFileString .= "{$key}={$value}\n";
        }

        $handle = fopen($envFile, 'w');
        fwrite($handle, $envFileString);
        fclose($handle);
    }
}
