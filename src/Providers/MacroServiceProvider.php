<?php

/*
 * style: fix StyleCI.
 */

namespace Platform\Providers;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class MacroServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function register()
    {
        Collection::make(glob(__DIR__.'/../Collection/*.php'))
            ->mapWithKeys(function ($path) {
                return [$path => pathinfo($path, PATHINFO_FILENAME)];
            })->reject(function ($macro) {
                return Collection::hasMacro($macro);
            })->each(function ($macro, $path) {
                require_once $path;
            });
    }
}
