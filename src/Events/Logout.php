<?php

namespace Platform\Events;

use Illuminate\Queue\SerializesModels;

class Logout
{
    use SerializesModels;

    /**
     * @var string
     */
    public $guard;

    /**
     * @var \Illuminate\Contracts\Auth\Authenticatable
     */
    public $user;

    /**
     * Logout constructor.
     * @param string $guard
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     *
     * @return void
     */
    public function __construct($guard, $user)
    {
        $this->guard = $guard;
        $this->user = $user;
    }
}
