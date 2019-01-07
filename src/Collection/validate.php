<?php

use Illuminate\Support\Collection;

/*
 * @see https://github.com/spatie/laravel-collection-macros#validate
 */
Collection::macro('validate', function ($callback): bool {
    if (is_string($callback) || is_array($callback)) {
        $validationRule = $callback;
        $callback = function ($item) use ($validationRule) {
            if (! is_array($item)) {
                $item = ['default' => $item];
            }
            if (! is_array($validationRule)) {
                $validationRule = ['default' => $validationRule];
            }

            return app('validator')->make($item, $validationRule)->passes();
        };
    }
    foreach ($this->items as $item) {
        if (! $callback($item)) {
            return false;
        }
    }

    return true;
});
