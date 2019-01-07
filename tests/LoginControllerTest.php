<?php

namespace Platform\Tests;

class LoginControllerTest extends TestCase
{
    /**
     * @var string
     */
    private $login = '/admin/login';

    /**
     * @var string
     */
    private $logout = '/admin/logout';

    /**
     * 多字段 username 登录成功
     */
    public function test_login_it_attempt_username_success()
    {
        $this->generate_account_data();

        $response = $this->postJson($this->login, [
            'username' => 'admin',
            'password' => 'admin',
        ]);

        $response->assertStatus(200);
    }

    /**
     * 多字段 email 登录成功
     */
    public function test_login_it_attempt_email_success()
    {
        $this->generate_account_data();

        $response = $this->postJson($this->login, [
            'username' => 'admin@admin.com',
            'password' => 'admin',
        ]);

        $response->assertStatus(200);
    }

    /**
     * 多字段 mobile 登录成功
     */
    public function test_login_it_attempt_mobile_success()
    {
        $this->generate_account_data();

        $response = $this->postJson($this->login, [
            'username' => '13030303030',
            'password' => 'admin',
        ]);

        $response->assertStatus(200);
    }

    /**
     * 数据不匹配，登录失败
     */
    public function test_login_it_failed()
    {
        $this->generate_account_data();

        $response = $this->postJson($this->login, [
            'username' => 'admin',
            'password' => '1234566',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('username');
    }

    /**
     * 登录失败次数超过设定
     */
    public function test_login_it_throttle()
    {
        $this->generate_account_data();

        $response = null;

        for ($i = 0; $i <= 6; $i++) {
            $response = $this->postJson($this->login, [
                'username' => 'admin',
                'password' => '123456',
            ]);
        }

        $response->assertStatus(429);
        $response->assertJsonValidationErrors('username');
    }

    /**
     * 未登录
     */
    public function test_logout_it_unauthorized()
    {
        $this->generate_account_data();

        $response = $this->postJson($this->logout);

        $response->assertStatus(401);
    }

    /**
     * 成功退出系统
     */
    public function test_login_it_logout_success()
    {
        $this->generate_account_data();

        $data = $this->postJson($this->login, [
            'username' => '13030303030',
            'password' => 'admin',
        ]);

        $response = $this->postJson($this->logout, [], [
            'Authorization' => $data->original['token_type'].' '.$data->original['access_token'],
        ]);

        $response->assertStatus(200);
    }
}
