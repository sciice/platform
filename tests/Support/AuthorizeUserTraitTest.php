<?php

namespace Platform\Tests\Support;

use Platform\Model\Role;

trait AuthorizeUserTraitTest
{
    /**
     * @return array
     */
    protected function generate_super_role_user()
    {
        $user = $this->generate_account_data();
        $user->assignRole($this->generate_test_role_data());

        $data = $this->postJson('/admin/login', [
            'username' => 'admin',
            'password' => 'admin',
        ]);

        return ['Authorization' => $data->original['token_type'].' '.$data->original['access_token']];
    }

    /**
     * @return array
     */
    protected function get_login_user()
    {
        $data = $this->postJson('/admin/login', [
            'username' => 'admin',
            'password' => 'admin',
        ]);

        return ['Authorization' => $data->original['token_type'].' '.$data->original['access_token']];
    }

    /**
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent\Model|Role
     */
    protected function generate_test_role_data(array $data = [])
    {
        return Role::create(array_merge([
            'name' => 'test',
            'title' => 'test',
            'guard_name' => 'admin',
        ], $data));
    }
}