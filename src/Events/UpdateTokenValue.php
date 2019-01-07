<?php

/*
 * style: fix StyleCI.
 */

namespace Platform\Events;

use Illuminate\Queue\SerializesModels;

class UpdateTokenValue
{
    use SerializesModels;

    /**
     * @var string
     */
    public $accessToken;

    /**
     * @var \Illuminate\Contracts\Auth\Authenticatable
     */
    public $user;

    /**
     * UpdateTokenValue constructor.
     *
     * @param string $accessToken
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     *
     * @return void
     */
    public function __construct($accessToken, $user)
    {
        $this->accessToken = $accessToken;
        $this->user = $user;
    }
}
