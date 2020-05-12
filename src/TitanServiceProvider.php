<?php

namespace PbbgIo\Titan;

use Esemve\Hook\Facades\Hook;
use Esemve\Hook\HookServiceProvider;
use Illuminate\Support\Facades\Log;
use PbbgIo\Titan\Providers\TitanServiceProvider as ServiceProvider;
use PbbgIo\Titan\Commands\MakeExtension;
use PbbgIo\Titan\Commands\RefreshExtensionsCache;
use PbbgIo\Titan\Commands\InstallTitan;
use PbbgIo\Titan\Commands\PublishTitanResources;
use PbbgIo\Titan\Commands\SuperAdmin;
use PbbgIo\Titan\Commands\UpdateTitan;
use PbbgIo\Titan\Models\Settings;
use PbbgIo\Titan\Observers\StatObserver;
use PbbgIo\Titan\Providers\BanUserServiceProvider;
use PbbgIo\Titan\Providers\ExtensionServiceProvider;

class TitanServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        $this->loadRoutesFrom(__DIR__ . '/routes.php');

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'titan');

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

        \Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });

        \View::composer(['titan::game.*', 'titan::layouts.game'], function ($view) {
            $character = \Auth::user()->character;
            $view->with('character', $character);
        });

        Stat::observe(StatObserver::class);

        $this->app->register(ExtensionServiceProvider::class);

        $this->app->register(BanUserServiceProvider::class);

    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        parent::register();

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
