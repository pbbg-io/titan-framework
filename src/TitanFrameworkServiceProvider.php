<?php

namespace PbbgIo\Titan;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use PbbgIo\Titan\Commands\MakeExtension;
use PbbgIo\Titan\Commands\RefreshExtensionsCache;
use PbbgIo\Titan\Commands\InstallTitan;
use PbbgIo\Titan\Commands\PublishTitanResources;
use PbbgIo\Titan\Commands\SuperAdmin;
use PbbgIo\Titan\Commands\UpdateTitan;
use PbbgIo\Titan\Models\Settings;
use PbbgIo\Titan\Observers\StatObserver;

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
