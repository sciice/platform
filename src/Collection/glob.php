<?php

use Illuminate\Support\Collection;

/*
 * @see https://github.com/spatie/laravel-collection-macros#glob
 */
Collection::macro('glob', function (string $pattern, int $flags = 0): Collection {
    return Collection::make(glob($pattern, $flags));
});
