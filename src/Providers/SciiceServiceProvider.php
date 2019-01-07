<?php

namespace Platform\Providers;

use Platform\Foundation\Sciice;
use Platform\Middleware\Authorize;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Platform\Console\PlatformInstallConsole;

class SciiceServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->registeredPublish();
        }

        $this->registeredServiceMenu();
        $this->registeredResources();
        $this->registeredProvider();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('sciice', function () {
            return new Sciice();
        });

        $this->registeredMiddleware();

        $this->commands([
            PlatformInstallConsole::class,
        ]);
    }

    /**
     * Register resources.
     *
     * @return void
     */
    private function registeredResources()
    {
        if (! $this->app->configurationIsCached()) {
            $this->mergeConfigFrom(__DIR__.'/../../config/config.php', 'admin');
            Sciice::mergeConfigFrom(__DIR__.'/../../config/auth.php', 'auth');
        }

        $this->loadTranslationsFrom(__DIR__.'/../../resources/lang', 'admin');
        $this->loadJsonTranslationsFrom(resource_path('lang/vendor/admin'));
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        $this->registeredRoute();
    }

    /**
     * Register service menu.
     *
     * @return void
     */
    private function registeredServiceMenu()
    {
        Sciice::registeredMenuBar(require __DIR__.'/../../config/menu.php');
    }

    /**
     * Register a routes.
     *
     * @return void
     */
    private function registeredRoute()
    {
        Route::group($this->configurationRouter(), function () {
            $this->loadRoutesFrom(__DIR__.'/../../routes/api.php');
        });
    }

    /**
     * Routes configuration.
     *
     * @return array
     */
    private function configurationRouter()
    {
        return [
            'namespace' => 'Platform\Controller',
            'as' => 'admin.',
            'prefix' => config('admin.path'),
            'middleware' => config('admin.middleware'),
        ];
    }

    /**
     * Register publish.
     *
     * @return void
     */
    private function registeredPublish()
    {
        $this->publishes([
            __DIR__.'/../../config/config.php' => config_path('admin.php'),
        ], 'admin-config');

        $this->publishes([
            __DIR__.'/../../resources/lang' => resource_path('lang/vendor/admin'),
        ], 'admin-lang');

        $this->publishes([
            __DIR__.'/../../database/migrations' => database_path('migrations'),
        ], 'admin-migrations');
    }

    /**
     * Register provider.
     *
     * @return void
     */
    private function registeredProvider()
    {
        $this->app->register(EventServiceProvider::class);
        $this->app->register(ValidationServiceProvider::class);
        $this->app->register(MacroServiceProvider::class);
    }

    /**
     * Register middleware.
     *
     * @return void
     */
    private function registeredMiddleware()
    {
        $this->app['router']->aliasMiddleware('authorize', Authorize::class);
        $this->app['router']->aliasMiddleware('refresh', RefreshAccessToken::class);
    }
}
