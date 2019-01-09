<?php

namespace Platform\Tests;

use Platform\Tests\Support\AuthorizeUserTraitTest;

class PermissionControllerTest extends TestCase
{
    use AuthorizeUserTraitTest;

    /**
     * @var string
     */
    private $url = '/admin/auth';

    /**
     * 测试权限列表是否获取成功.
     */
    public function test_permission_it_index_success()
    {
        $this->generate_test_permission_data();

        $response = $this->getJson($this->url, $this->generate_super_role_user());

        $this->assertEquals(1, $response->original->count());
        $response->assertOk();
    }

    /**
     * 测试权限添加是否成功.
     */
    public function test_permission_it_store_success()
    {
        $response = $this->postJson($this->url, [
            'name'     => 'test',
            'title'    => 'test',
            'grouping' => 'test',
            'parent'   => 0,
        ], $this->generate_super_role_user());

        $response->assertOk()->assertJsonFragment(['id' => 1, 'name' => 'test', 'message' => '操作成功']);
    }

    /**
     * 测试权限信息更新是否成功.
     */
    public function test_permission_it_update_success()
    {
        $this->generate_test_permission_data();

        $response = $this->patchJson($this->url.'/1', [
            'name'     => 'permission',
            'title'    => 'permission',
            'grouping' => 'test',
            'parent'   => 0,
        ], $this->generate_super_role_user());

        $response->assertOk()->assertJsonFragment(['id' => 1, 'name' => 'permission', 'message' => '操作成功']);
    }

    /**
     * 测试获取权限信息.
     */
    public function test_permission_it_show_success()
    {
        $this->generate_test_permission_data();

        $response = $this->getJson($this->url.'/1', $this->generate_super_role_user());

        $response->assertOk()->assertJsonFragment(['id' => 1, 'name' => 'test']);
    }

    /**
     * 测试是否成功删除权限.
     */
    public function test_permission_it_delete_success()
    {
        $this->generate_test_permission_data();

        $response = $this->deleteJson($this->url.'/1', $this->generate_super_role_user());

        $this->assertTrue($response->original->isEmpty());
        $response->assertOk()->assertJsonFragment(['message' => '操作成功']);
    }

    /**
     * 但存在子权限时不允许删除.
     */
    public function test_permission_it_delete_failed()
    {
        $this->generate_test_permission_data();

        $result = $this->postJson($this->url, [
            'name'     => 'permission',
            'title'    => 'permission',
            'grouping' => 'admin',
            'parent'   => 1,
        ], $this->generate_super_role_user());

        $this->assertEquals(2, $result->original->count());
        $result->assertOk();

        $response = $this->deleteJson($this->url.'/1', $this->get_login_user());

        $response->assertStatus(403)->assertJsonFragment(['message' => '请先删除子权限']);
    }

    /**
     * 测试是否有权限操作.
     */
    public function test_permission_un_authorize()
    {
        $response = $this->getJson($this->url, $this->generate_new_account_access_token());

        $response->assertStatus(403);
    }
}
