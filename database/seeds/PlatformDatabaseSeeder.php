<?php

use Platform\Support\PlatformDatabaseSeeder as Seeder;

class PlatformDatabaseSeeder extends Seeder
{
    /**
     * @var array
     */
    protected $authorize = ['admin' => '用户', 'role' => '角色', 'auth' => '权限'];

    /**
     * @var array
     */
    protected $rule = ['index' => '管理', 'store' => '创建', 'update' => '更新', 'destroy' => '删除'];

    /**
     * @var string
     */
    protected $grouping = 'admin';
}
