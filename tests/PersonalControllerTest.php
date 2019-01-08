<?php

namespace Platform\Tests;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PersonalControllerTest extends TestCase
{
    /**
     * 测试头像上传是否成功
     */
    public function test_personal_it_upload_avatar_success()
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->image('avatar.png');

        $response = $this->postJson('/admin/personal/avatar', [
            'avatar' => $file,
        ], $this->generate_new_account_access_token());

        $response->assertOk();

        $this->assertNotNull($response->original['avatar']);

        Storage::disk('public')->assertExists('avatar/'.$file->hashName());
    }

    /**
     * 测试头像验证规则是否正常
     */
    public function test_personal_it_upload_avatar_size_failed()
    {
        $file = UploadedFile::fake()->image('avatar.png')->size(3000);

        $response = $this->postJson('/admin/personal/avatar', [
            'avatar' => $file,
        ], $this->generate_new_account_access_token());

        $response->assertStatus(422);
    }

    /**
     * 测试更新个人信息是否成功
     */
    public function test_personal_it_update_user_info_success()
    {
        $response = $this->postJson('/admin/personal/account', [
            'name' => 'test',
            'username' => 'test',
            'email' => 'test@i.com',
            'mobile' => '13000000000',
        ], $this->generate_new_account_access_token());

        $response->assertOk();

        $this->assertEquals('test', $response->original['name']);

        $this->assertEquals('test@i.com', $response->original['email']);

        $this->assertEquals('13000000000', $response->original['mobile']);

        $this->assertEquals('admin', $response->original['username']);
    }

    /**
     * 未登录.
     */
    public function test_personal_it_unauthorized()
    {
        $this->generate_account_data();

        $response = $this->postJson('/admin/personal/account', [
            'name' => 'test',
            'username' => 'test',
            'email' => 'test@i.com',
            'mobile' => '13000000000',
        ]);

        $response->assertStatus(401);
    }
}
