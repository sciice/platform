<?php

/*
 * style: fix StyleCI.
 */

use Illuminate\Support\Collection;

Collection::macro('filterMenu', function ($authorize, $field = 'authorize', $children = 'children') {
    return $this->filter(function ($item) use ($authorize, $field, $children) {
        return isset($item[$children]);
    })->map(function ($value) use ($authorize, $field, $children) {
        $value[$children] = collect($value[$children])->filter(function ($item) use ($authorize, $field) {
            if (isset($item[$field])) {
                return in_array($item[$field], $authorize, true);
            }

            return $item;
        })->toArray();

        return $value;
    })->filter(function ($item) use ($children) {
        return count($item[$children]);
    });
});
