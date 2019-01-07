<?php

use Illuminate\Support\Collection;

/*
 * @param string $field
 * @param string $filter
 * @param string $id
 *
 * @return \Illuminate\Support\Collection
 */
Collection::macro('filterTree', function ($field = 'children', $filter = 'parent', $id = 'id'): Collection {
    $tree = [];
    $map = [];

    $data = $this->toArray();

    foreach ($data as $item) {
        $map[$item[$id]] = $item;
    }

    foreach ($data as $item) {
        if (isset($map[$item[$filter]]) && $map[$item[$filter]]) {
            $map[$item[$filter]][$field][] = &$map[$item[$id]];
        } else {
            $tree[] = &$map[$item[$id]];
        }
    }

    return new Collection($tree);
});
