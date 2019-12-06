<?php

namespace PbbgIo\TitanFramework;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use PbbgIo\TitanFramework\Commands\RefreshExtensionsCache;
use PbbgIo\TitanFramework\Commands\InstallTitan;
use PbbgIo\TitanFramework\Commands\PublishTitanResources;
use PbbgIo\TitanFramework\Commands\SuperAdmin;
use PbbgIo\TitanFramework\Commands\UpdateTitan;
use PbbgIo\TitanFramework\Models\Settings;

class TitanFrameworkServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->loadRoutesFrom(__DIR__ . '/routes.php');

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->commands([
            InstallTitan::class,
            PublishTitanResources::class,
            UpdateTitan::class,
            RefreshExtensionsCache::class,
            SuperAdmin::class,
        ]);

        $this->publishes([
//            __DIR__ . '/../resources/views' =>  resource_path('views/vendor/titan'),
            __DIR__ . '/../resources/sass' => resource_path('sass'),
            __DIR__ . '/../resources/js' => resource_path('js'),
        ], 'titan');


        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'titan');


        $extensions = resolve('extensions');

        foreach($extensions as $ext) {
            $author = Str::studly($ext->author);
            $name = Str::studly($ext->name);

            $authorLower = Str::kebab($author);
            $nameLower = Str::kebab($ext->name);

            $serviceProvider = "\Extensions\\{$author}\\{$name}\\ServiceProvider";
            $serviceProviderPath = base_path("extensions/{$authorLower}/{$nameLower}/ServiceProvider.php");

            if(file_exists($serviceProviderPath))
            {
                $this->app->register($serviceProvider);
            }
            else
                Log::warning("Trying to load {$serviceProvider} {$serviceProviderPath} but failed");
        }

        \Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->singleton('extensions', function () {

            $ext = collect();

            try {
                $ext = Extensions::all();
            } catch (\Exception $exception) {}

            return $ext;
        });

        $this->app->singleton('settings', function() {
            return Settings::all();
        });

        $this->mergeConfigFrom(
            __DIR__ . '/../config/titan.php', 'titan'
        );

    }
}
