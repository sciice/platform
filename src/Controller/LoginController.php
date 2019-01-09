<?php

namespace Platform\Controller;

use Illuminate\Http\Request;
use Platform\Foundation\JWTAuthenticate;

class LoginController extends Controller
{
    use JWTAuthenticate;

    /**
     * LoginController constructor.
     */
    public function __construct()
    {
        $this->middleware('login:admin')->except('login');
    }

    /**
     * @param Request $request
     * @param $user
     * @return \Illuminate\Http\JsonResponse
     */
    protected function authenticated(Request $request, $user)
    {
        return response()->json([
            'message'      => __('登录成功'),
            'access_token' => $this->accessToken,
            'token_type'   => 'bearer',
            'expires_in'   => $this->guard()->factory()->getTTL() * 60,
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    protected function loggedOut(Request $request)
    {
        return $this->response(__('退出成功'));
    }
}
