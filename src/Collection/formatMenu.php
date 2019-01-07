<?php

/*
 * style: fix StyleCI.
 */

use Illuminate\Support\Collection;

Collection::macro('formatMenu', function ($children = 'children') {
    return $this->map(function ($list) use ($children) {
        $list['path'] = str_start($list['path'], '/');
        $list[$children] = collect($list[$children])->map(function ($item) use ($list) {
            $item['path'] = str_start("{$list['path']}/{$item['path']}", '/');

            return $item;
        })->toArray();

        return $list;
    });
});
