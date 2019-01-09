<?php

namespace Platform\Tests;

use Platform\Events\Login;
use Illuminate\Support\Facades\Event;
use Platform\Events\Logout;
use Platform\Tests\Support\AuthorizeUserTraitTest;

class EventTest extends TestCase
{
    use AuthorizeUserTraitTest;

    public function test_login_it_event()
    {
        $this->generate_account_data();

        Event::fake();

        $this->postJson('/admin/login', [
           'username' => 'admin',
           'password' => 'admin',
        ]);

        Event::assertDispatched(Login::class, function ($e) {
            return $e->user->username === 'admin';
        });

        Event::assertDispatched(Login::class, 1);
    }

    public function test_logout_it_event()
    {
        $this->generate_account_data();

        Event::fake();

        $this->postJson('/admin/logout', [], $this->get_login_user());

        Event::assertDispatched(Logout::class, function ($e) {
            return $e->user->username === 'admin';
        });

        Event::assertDispatched(Logout::class, 1);
    }
}
