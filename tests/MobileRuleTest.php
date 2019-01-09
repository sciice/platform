<?php

namespace Platform\Tests;

class MobileRuleTest extends TestCase
{
    private $url = '/admin/personal/account';

    /**
     * 长度错误.
     */
    public function test_mobile_it_len_failed()
    {
        $response = $this->postJson($this->url, [
            'name'     => 'test',
            'username' => 'test',
            'email'    => 'test@i.com',
            'mobile'   => '1300000000',
        ], $this->generate_new_account_access_token());

        $response->assertStatus(422)->assertJsonValidationErrors('mobile');
    }

    /**
     * 规则错误.
     */
    public function test_mobile_it_rule_failed()
    {
        $response = $this->postJson($this->url, [
            'name'     => 'test',
            'username' => 'test',
            'email'    => 'test@i.com',
            'mobile'   => '12000000000',
        ], $this->generate_new_account_access_token());

        $response->assertStatus(422)->assertJsonValidationErrors('mobile');
    }
}
