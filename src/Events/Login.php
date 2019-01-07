<?php

namespace Platform\Events;

use Illuminate\Queue\SerializesModels;

class Login
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
     * @var string
     */
    public $accessToken;

    /**
     * Login constructor.
     * @param string $guard
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @param string $accessToken
     *
     * @return void
     */
    public function __construct($guard, $user, $accessToken)
    {
        $this->guard = $guard;
        $this->user = $user;
        $this->accessToken = $accessToken;
    }
}
