<?php

namespace PbbgIo\TitanFramework\Commands;

use App\User;
use Carbon\Carbon;
use Carbon\Laravel\ServiceProvider;
use GuzzleHttp\Client;
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
        $setting->value = $this->getRemoteVersion();
        $setting->save();
    }

    /**
     * Get the latest version of the software that's available
     *
     * @return string
     */
    private function getRemoteVersion(): string {

        $http = new Client();
        $res = $http->get('https://titan.pbbg.io/api/version')->getBody()->getContents();
        $res = json_decode($res);
        return $res->version;
    }

    /**
     * Get extensions from a remote source
     *
     * @todo Grab them remotely then cache them
     * @throws \Exception
     */
    private function getExtensions(): void
    {

        $http = new Client();
        $res = $http->get('https://titan.pbbg.io/api/extensions')->getBody()->getContents();
        $extensions = json_decode($res);

        $this->schema['date'] = new Carbon();
        $this->schema['extensions'] = $extensions;
    }
}
