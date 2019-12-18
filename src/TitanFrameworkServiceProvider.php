<?php

namespace PbbgIo\TitanFramework;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use PbbgIo\TitanFramework\Commands\MakeExtension;
use PbbgIo\TitanFramework\Commands\RefreshExtensionsCache;
use PbbgIo\TitanFramework\Commands\InstallTitan;
use PbbgIo\TitanFramework\Commands\PublishTitanResources;
use PbbgIo\TitanFramework\Commands\SuperAdmin;
use PbbgIo\TitanFramework\Commands\UpdateTitan;
use PbbgIo\TitanFramework\Models\Settings;
use PbbgIo\TitanFramework\Observers\StatObserver;

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
            MakeExtension::class,
        ]);

        $this->publishes([
//            __DIR__ . '/../resources/views' =>  resource_path('views/vendor/titan'),
            __DIR__ . '/../resources/sass' => resource_path('sass'),
            __DIR__ . '/../resources/js' => resource_path('js'),
        ], 'titan');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'titan');

        $extensions = resolve('extensions');

        foreach ($extensions as $ext) {

            $realNameSpace = $ext->namespace;
            $folderPath = \Str::kebab($ext->namespace);
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

        \Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });

        \View::composer(['titan::game.*', 'titan::layouts.game'], function ($view) {
            $character = \Auth::user()->character;
            $view->with('character', $character);
        });

        Stat::observe(StatObserver::class);
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
            } catch (\Exception $exception) {
            }

            return $ext;
        });

        $this->app->singleton('menu', function () {
            $menu = Menu::with('items')->whereEnabled(true)->get();
            return $menu;
        });

        $this->app->singleton('settings', function () {
            return Settings::all();
        });

        $this->mergeConfigFrom(
            __DIR__ . '/../config/titan.php', 'titan'
        );

    }
}
