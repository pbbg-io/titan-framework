<?php

namespace PbbgIo\TitanFramework\Commands;

use Carbon\Carbon;
use Carbon\Laravel\ServiceProvider;
use Illuminate\Console\Command;
use PbbgIo\TitanFramework\Models\Settings;

class RefreshExtensionsCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'titan:extension:flush';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Flush the caches of Titan extensions';

    private $schema = [];

    /**
     * Create a new command instance.
     *
     * @return void
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(): void
    {
        $this->getExtensions();
        \Storage::disk('local')->put('extensions.json', json_encode($this->schema));
        $this->info("Extensions have been reloaded");

        $setting = Settings::firstOrNew([
            'key'   =>  'remote_version'
        ]);
        $setting->value = '1.0.0';
        $setting->save();


    }

    private function getExtensions(): void
    {

        $extensions = [
            [
                'name' => 'Hello World',
                'description' => 'Hello World provides a very basic example of what an extension can do',
                'version' => '1.0.0',
                'author' => [
                    'name' => 'Ian',
                    'email' => 'ian@pbbg.io'
                ],
                'slug' => 'hello-world',
                'rating' => '4.0',
                'ratings' => 20,
                'installs' => 3237
            ],
            [
                'name' => 'Test World',
                'description' => 'Test World provides a very basic example of what an extension can do',
                'version' => '1.0.0',
                'author' => [
                    'name' => 'Ian',
                    'email' => 'ian@pbbg.io'
                ],
                'slug' => 'test-world',
                'rating' => '3.0',
                'ratings' => 174,
                'installs' => 1474
            ],
        ];

        $this->schema['date'] = new Carbon();
        $this->schema['extensions'] = $extensions;
    }
}
