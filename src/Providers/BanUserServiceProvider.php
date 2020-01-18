<?php
namespace PbbgIo\Titan\Providers;

use PbbgIo\Titan\Http\Middleware\PlayableNotBannedMiddleware;
use PbbgIo\Titan\Support\BanUser;
use Illuminate\Support\ServiceProvider;

class BanUserServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerConfig();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        app()->bind(BanUser::class, function() {
            return new BanUser();
        });
        $this->loadMiddleware();
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../.../Config/ban.php' => config_path('banuser.php'),
        ]);
        $this->mergeConfigFrom(
            __DIR__.'/../../Config/ban.php', 'banuser'
        );
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [BanUser::class];
    }

    private function loadMiddleware()
    {
//        app('router')->aliasMiddleware('playable_not_banned', PlayableNotBannedMiddleware::class);
        app('router')->pushMiddlewareToGroup('auth', PlayableNotBannedMiddleware::class);
    }
}
