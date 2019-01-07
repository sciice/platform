<?php

/*
 * style: fix StyleCI.
 */

return [
    'guards' => [
        'admin' => [
            'driver' => 'jwt',
            'provider' => 'admin',
        ],
    ],

    'providers' => [
        'admin' => [
            'driver' => 'eloquent',
            'model' => \Platform\Model\Platform::class,
        ],
    ],
];
