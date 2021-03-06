<?php

namespace Platform\Tests;

use Platform\Tests\Support\AuthorizeUserTraitTest;

class RoleControllerTest extends TestCase
{
    use AuthorizeUserTraitTest;

    /**
     * @var string
     */
    private $url = '/admin/role';

    /**
     * 成功获取角色列表.
     */
    public function test_role_it_index_success()
    {
        $response = $this->getJson($this->url, $this->generate_super_role_user());

        $response->assertOk()->assertJsonMissing(['message'])->assertJsonFragment([
            'name'  => 'test',
            'title' => 'test',
        ]);
    }

    /**
     * 成功创建一条角色组信息.
     */
    public function test_role_it_store_success()
    {
        $response = $this->postJson($this->url, [
            'name'  => 'store-test',
            'title' => 'store-test',
        ], $this->generate_super_role_user());

        $this->assertEquals(2, count($response->original));
        $response->assertOk()->assertJsonFragment([
            'message' => '操作成功',
            'id'      => 1,
            'name'    => 'store-test',
        ]);
    }

    /**
     * 成功更新角色信息.
     */
    public function test_role_it_update_success()
    {
        $response = $this->patchJson($this->url.'/1', [
            'name'  => 'super',
            'title' => 'super',
        ], $this->generate_super_role_user());

        $response->assertOk()->assertJsonFragment([
            'message' => '操作成功',
            'id'      => 1,
            'name'    => 'super',
            'title'   => 'super',
        ]);
    }

    /**
     * 成功获取一条角色信息.
     */
    public function test_role_it_show_success()
    {
        $response = $this->getJson($this->url.'/1', $this->generate_super_role_user());

        $response->assertOk()->assertJsonMissing(['message'])->assertJsonFragment([
            'id'        => 1,
            'name'      => 'test',
            'title'     => 'test',
            'authorize' => [],
        ]);
    }

    /**
     * 成功删除角色数据.
     */
    public function test_role_it_delete_success()
    {
        $result = $this->postJson($this->url, [
            'name'  => 'store-test',
            'title' => 'store-test',
        ], $this->generate_super_role_user());

        $this->assertEquals(2, count($result->original));
        $result->assertOk()->assertJsonFragment(['id' => 2]);

        $response = $this->deleteJson($this->url.'/2', $this->get_login_user());

        $this->assertEquals(1, count($response->original));
        $response->assertOk()->assertJsonMissing(['id' => 2]);
    }

    /**
     * 测试权限同步是否正常.
     */
    public function test_role_add_authorize()
    {
        $authorize = $this->postJson('/admin/auth', [
            'name'     => 'admin.role.index',
            'title'    => 'role index',
            'grouping' => 'admin',
            'parent'   => 0,
        ], $this->generate_super_role_user());
        $this->assertEquals(1, $authorize->original[0]['id']);
        $authorize->assertOk();

        $authorize = $this->postJson('/admin/auth', [
            'name'     => 'admin.role.update',
            'title'    => 'role update',
            'grouping' => 'admin',
            'parent'   => 0,
        ], $this->get_login_user());
        $this->assertEquals(2, $authorize->original[1]['id']);
        $authorize->assertOk();

        $role = $this->postJson($this->url, [
            'name'      => 'store-test',
            'title'     => 'store-test',
            'authorize' => [1, 2],
        ], $this->get_login_user());
        $this->assertEquals(2, $role->original[1]['id']);
        $role->assertOk();

        $account = $this->postJson('/admin/account', [
            'name'     => 'test',
            'username' => 'test',
            'email'    => 'test@test.com',
            'password' => '12345',
            'role'     => 2,
        ], $this->get_login_user());
        $account->assertOk();

        $user = $this->postJson('/admin/login', [
            'username' => 'test',
            'password' => '12345',
        ]);
        $user->assertOk();

        $header     = ['Authorization' => $user->original['token_type'].' '.$user->original['access_token']];
        $canIndex   = $this->getJson($this->url, $header);
        $canIndex->assertOk();

        $canShow = $this->getJson($this->url.'/2', $header);
        $canShow->assertOk();

        $notCan = $this->getJson('/admin/account', $header);
        $notCan->assertStatus(403);
    }

    /**
     * 测试是否有权限操作.
     */
    public function test_role_un_authorize()
    {
        $response = $this->getJson($this->url, $this->generate_new_account_access_token());

        $response->assertStatus(403);
    }
}
