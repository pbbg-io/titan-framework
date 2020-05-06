<?php

namespace PbbgIo\Titan\Commands;

use App\User;
use Carbon\Carbon;
use Carbon\Laravel\ServiceProvider;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use PbbgIo\Titan\Extensions;
use PbbgIo\Titan\Models\Settings;

class RefreshExtensionsCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'titan:flush';

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
     * @return void
     */
    public function handle(): void
    {
        $this->getExtensions();
    }

    /**
     * Get extensions from a remote source
     *
     * @throws \Exception
     * @todo Grab them remotely then cache them
     */
    private function getExtensions(): void
    {

        $localExtensionFiles = glob(base_path('extensions/*/*/composer.json'));
        $localExtensions = collect();

        foreach ($localExtensionFiles as $file) {
            $composer = json_decode(file_get_contents($file));

            if (!$composer) {
                continue;
            }

            $nameEx = explode('/', $composer->name);
            $author = $nameEx[0];
            $packageName = $nameEx[1];

            $slug = \Str::kebab(str_replace('\\', '', $composer->extra->titan->namespace));

            if ($exists = $localExtensions->firstWhere('slug', $slug)) {
                $this->info("Found existing extension {$exists['name']}");
            } else {

                $temp = collect();
                $temp->put('name', $composer->extra->titan->name);
                $temp->put('description', $composer->description);
                $temp->put('version', '1.0.0');
                $temp->put('authors', $composer->authors);
                $temp->put('slug', $slug);
                $temp->put('rating', '4.0');
                $temp->put('ratings', 20);
                $temp->put('installs', 3237);
                $temp->put('local', true);
                $temp->put('enabled', false);
                $temp->put('namespace', $composer->extra->titan->namespace);
                $localExtensions[] = $temp;

                $this->info("Found new extension {$composer->extra->titan->name}");
            }
        }


        cache()->put('local_extensions', json_encode($localExtensions));
        $this->info('Local extension cache refreshed');


        try {

            $http = new Client([
                'timeout' => 3
            ]);
            $res = $http->get('https://titan.pbbg.io/api/extensions')->getBody()->getContents();
            $extensions = json_decode($res);

            $this->schema['date'] = new Carbon();
            $this->schema['remote_extensions'] = $extensions;
            $this->schema['local_extensions'] = $localExtensions;

            cache()->put('remote_extensions', json_encode($extensions));

            \Storage::disk('local')->set('extensions.json', json_encode($this->schema));
            $this->info("Extensions have been reloaded");
        } catch (\Exception $exception) {
            $this->warn("Unable to retrieve remote extension cache, falling back to previous version");
        }
    }
}
