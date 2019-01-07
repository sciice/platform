<?php

/*
 * style: fix StyleCI.
 */

use Illuminate\Support\Collection;

/*
 * @see https://github.com/spatie/laravel-collection-macros#sectionby
 */
Collection::macro('sectionBy', function ($key, bool $preserveKeys = false, $sectionKey = 0, $itemsKey = 1): Collection {
    $sectionNameRetriever = $this->valueRetriever($key);
    $results = new Collection();
    foreach ($this->items as $key => $value) {
        $sectionName = $sectionNameRetriever($value);
        if (! $results->last() || $results->last()->get($sectionKey) !== $sectionName) {
            $results->push(new Collection([
                $sectionKey => $sectionName,
                $itemsKey => new Collection(),
            ]));
        }
        $results->last()->get($itemsKey)->offsetSet($preserveKeys ? $key : null, $value);
    }

    return $results;
});
