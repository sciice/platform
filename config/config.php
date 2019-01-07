<?php

return [
    // 后台地址
    'path' => 'admin',

    // 全局中间件
    'middleware' => ['api'],

    // 登录字段
    'attempt' => ['username', 'mobile', 'email'],
];
