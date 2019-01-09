<?php

namespace Platform\Tests;

use Platform\Tests\Support\AuthorizeUserTraitTest;

class PlatformControllerTest extends TestCase
{
    use AuthorizeUserTraitTest;

    /**
     * @var string
     */
    private $url = '/admin/account';

    /**
     * 测试是否能获取到用户列表.
     */
    public function test_account_it_index_success()
    {
        $response = $this->getJson($this->url, $this->generate_super_role_user());

        $response->assertOk()->assertJsonCount(3);
        $this->assertEquals(1, $response->original->count());
    }

    /**
     * 测试是否成功添加用户.
     */
    public function test_account_it_store_success()
    {
        $response = $this->postJson($this->url, [
            'name'     => 'test',
            'username' => 'test',
            'email'    => 'test@test.com',
            'password' => '12345',
            'role'     => 1,
        ], $this->generate_super_role_user());

        $this->assertEquals(2, $response->original->count());
        $response->assertOk()
            ->assertJsonCount(4)
            ->assertJsonFragment(['message' => '操作成功', 'roleId' => 1, 'username' => 'test']);
    }

    /**
     * 测试是否更新成功
     */
    public function test_account_it_update_success()
    {
        $result = $this->postJson($this->url, [
            'name'     => 'test',
            'username' => 'test',
            'email'    => 'test@test.com',
            'password' => '12345',
            'role'     => 1,
        ], $this->generate_super_role_user());

        $result->assertOk();

        $response = $this->patchJson($this->url.'/2', [
            'name'     => 'test2',
            'username' => 'test2',
            'email'    => 'test@i.com',
            'mobile'   => '13030303000',
            'role'     => 1,
        ], $this->get_login_user());

        $response->assertOk();
        $this->assertEquals('2', $response->original[1]['id']);
        $this->assertEquals('test', $response->original[1]['username']);
        $this->assertEquals('13030303000', $response->original[1]['mobile']);
        $this->assertEquals(1, $response->original[1]['roles'][0]['id']);
    }

    /**
     * 测试是否成功获取用户信息.
     */
    public function test_account_it_show_success()
    {
        $response = $this->getJson($this->url.'/1', $this->generate_super_role_user());

        $response->assertOk()->assertJsonFragment(['username' => 'admin', 'roleId'=>1]);
    }

    /**
     * 测试是否成功删除用户信息.
     */
    public function test_account_it_delete_success()
    {
        $result = $this->postJson($this->url, [
            'name'     => 'test',
            'username' => 'test',
            'email'    => 'test@test.com',
            'password' => '12345',
            'role'     => 1,
        ], $this->generate_super_role_user());

        $this->assertEquals(2, $result->original->count());
        $result->assertOk();

        $response = $this->deleteJson($this->url.'/2', $this->get_login_user());
        $this->assertEquals(1, $response->original->count());
        $response->assertOk();
    }

    /**
     * 测试超级管理是否不能删除.
     */
    public function test_account_it_delete_failed()
    {
        $response = $this->deleteJson($this->url.'/1', $this->generate_super_role_user());

        $response->assertStatus(403)->assertJsonFragment(['message' => '该账号不允许删除']);
    }
}
