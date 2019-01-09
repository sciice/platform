<?php

namespace Platform\Model;

use Illuminate\Database\Eloquent\Builder;

class Permission extends \Spatie\Permission\Models\Permission
{
    /**
     * @param Builder $query
     * @param string $grouping
     *
     * @return Builder
     */
    public function scopeGrouping(Builder $query, $grouping = 'admin')
    {
        return $query->where('grouping', $grouping);
    }

    /**
     * @param Builder $query
     * @param string $guard
     *
     * @return Builder
     */
    public function scopeGuardName(Builder $query, $guard = 'admin')
    {
        return $query->where('guard_name', $guard);
    }
}
