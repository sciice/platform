<?php

namespace Platform\Tests;

use Platform\Model\Platform;

class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->withFactories(__DIR__.'/factories');
        $this->withHeader('X-Requested-With', 'XMLHttpRequest');
    }

    /**
     * {@inheritdoc}
     */
    protected function getPackageProviders($app)
    {
        return [
            \Platform\Providers\SciiceServiceProvider::class,
            \Spatie\Permission\PermissionServiceProvider::class,
            \Tymon\JWTAuth\Providers\LaravelServiceProvider::class,
            \Intervention\Image\ImageServiceProvider::class,
            \QCod\ImageUp\ImageUpServiceProvider::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getPackageAliases($app)
    {
        return [
            'Sciice' => \Platform\Facades\Sciice::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function resolveApplicationCore($app)
    {
        parent::resolveApplicationCore($app);
        $app->detectEnvironment(function () {
            return 'testing';
        });
    }

    /**
     * {@inheritdoc}
     */
    protected function getEnvironmentSetUp($app)
    {
        $config = $app->get('config');
        $config->set('app.key', 'base64:yk+bUVuZa1p86Dqjk9OjVK2R1pm6XHxC6xEKFq8utH0=');
        $config->set('jwt.secret', 'ZLwqeaKcVh3iZgeAGgZFfavhb6GtLVl5');
        $config->set('database.default', 'testing');
        $config->set('database.connections.testing', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function getApplicationTimezone($app)
    {
        return 'Asia/Shanghai';
    }

    /**
     * Generate a test account data.
     *
     * @param array $data
     *
     * @return mixed
     */
    protected function generate_account_data(array $data = [])
    {
        return Platform::create(array_merge([
            'name'     => 'admin',
            'username' => 'admin',
            'password' => 'admin',
            'email'    => 'admin@admin.com',
            'mobile'   => '13030303030',
        ], $data));
    }

    /**
     * Generate a test access token.
     *
     * @return array
     */
    protected function generate_new_account_access_token()
    {
        $this->generate_account_data();

        $data = $this->postJson('/admin/login', [
            'username' => 'admin',
            'password' => 'admin',
        ]);

        return ['Authorization' => $data->original['token_type'].' '.$data->original['access_token']];
    }
}
