<?php

/*
 * style: fix StyleCI.
 */

namespace Platform\Model;

use Illuminate\Database\Eloquent\Builder;

class Role extends \Spatie\Permission\Models\Role
{
    /**
     * @param Builder $query
     * @param string $guard
     *
     * @return Builder
     */
    public function scopeGrouping(Builder $query, string $guard = 'admin')
    {
        return $query->where('guard_name', $guard);
    }
}
