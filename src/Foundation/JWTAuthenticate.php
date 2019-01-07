<?php

namespace Platform\Foundation;

use Platform\Events\Login;
use Platform\Events\Logout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\ThrottlesLogins;

trait JWTAuthenticate
{
    use ThrottlesLogins;

    /**
     * @var string
     */
    protected $accessToken;

    /**
     * Handle a login request to the application.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response|mixed
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function logout(Request $request)
    {
        $guard = $this->guard();

        $this->guard()->logout();

        event(new Logout($guard, $guard->user()));

        return $this->loggedOut($request);
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        return collect(config('admin.attempt'))->contains(function ($value) use ($request) {
            return $this->accessToken = $this->guard()->attempt([
                $value => $request->input($this->username()),
                'password' => $request->input('password'),
            ]);
        });
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        event(new Login($this->guard(), $this->guard()->user(), $this->accessToken));

        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user());
    }

    /**
     * @param Request $request
     * @param $user
     *
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        //
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        //
    }

    /**
     * Get the failed login response instance.
     *
     * @param Request $request
     * @return mixed
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'username';
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }
}
