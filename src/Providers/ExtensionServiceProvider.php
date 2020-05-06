<?php

namespace PbbgIo\Titan\Providers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use PbbgIo\Titan\Commands\MakeExtension;
use PbbgIo\Titan\Commands\RefreshExtensionsCache;
use PbbgIo\Titan\Commands\InstallTitan;
use PbbgIo\Titan\Commands\PublishTitanResources;
use PbbgIo\Titan\Commands\SuperAdmin;
use PbbgIo\Titan\Commands\UpdateTitan;
use PbbgIo\Titan\Extensions;
use PbbgIo\Titan\Helpers\Extensions as ExtensionCache;
use PbbgIo\Titan\Models\Settings;
use PbbgIo\Titan\Observers\StatObserver;

class ExtensionServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $extensions = resolve('extensions')->getCache();

        foreach ($extensions as $ext) {

            if(!$ext['enabled'])
                continue;

            $realNameSpace = $ext['namespace'];
            $folderPath = \Str::kebab($ext['namespace']);
            $folderPath = str_replace(['\\-', '\\'], '/', $folderPath);

            $serviceProvider = "{$realNameSpace}\\ServiceProvider";
            $serviceProviderPath = base_path("{$folderPath}/ServiceProvider.php");

            if (file_exists($serviceProviderPath)) {
                include_once $serviceProviderPath;
                $this->app->register($serviceProvider);
            } else {
                Log::warning("Trying to load {$serviceProvider} {$serviceProviderPath} but failed");
            }
        }
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->singleton('extensions', function () {
            return new ExtensionCache();
        });
    }
}
