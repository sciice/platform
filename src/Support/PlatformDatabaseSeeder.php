<?php

namespace Platform\Support;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PlatformDatabaseSeeder extends Seeder
{
    /**
     * @var array
     */
    protected $authorize = [];

    /**
     * @var array
     */
    protected $rule = [];

    /**
     * @var string
     */
    protected $grouping;

    /**
     * @var object
     */
    private $parent;

    /**
     * @var string
     */
    private $name = 'admin';

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->authorize as $key => $value) {
            foreach ($this->rule as $rule => $item) {
                if ($rule === 'index') {
                    $this->parent = Permission::create([
                        'name' => "$this->name.$key.$rule",
                        'title' => $value.$item,
                        'grouping' => $this->grouping,
                        'guard_name' => $this->name,
                    ]);
                } else {
                    Permission::create([
                        'name' => "$this->name.$key.$rule",
                        'title' => $item,
                        'grouping' => $this->grouping,
                        'guard_name' => $this->name,
                        'parent' => $this->parent->id,
                    ]);
                }
            }
        }
    }
}
