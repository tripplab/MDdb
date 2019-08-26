<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Password;
use Auth;
use Config;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth;

class AuthController extends Controller
{

    /**
     * Create a new AuthController instance.
     */
    public function __construct()
    {
        $this->middleware('jwt.auth', []);
    }
    /**
     * Log the user in.
     *
     * @param LoginRequest $request
     * @param JWTAuth      $JWTAuth
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request, JWTAuth $JWTAuth)
    {
        $credentials = $request->only(['email', 'password']);

        try {
            $token = Auth::guard()->attempt($credentials);

            if (! $token) {
                throw new AccessDeniedHttpException();
            }
        } catch (JWTException $e) {
            Log::error($e->message());

            throw new HttpException(500);
        }

        $role_id = Auth::guard()->user()->hasRoles()->pluck('id');
        //$permissions = Permission::join('permission_has_role', 'permissions.id', 'permission_has_role.permission_id')->where('permission_has_role.role_id', $role_id)->get();

        return response()
            ->json([
                'status' => 'ok',
                'token' => $token,
                'user' => Auth::guard()->user(),
                'role' => Auth::guard()->user()->hasRoles()->get(),
                'permissions' => null,
                'expires_in' => Auth::guard()->factory()->getTTL() * 120,
            ]);
    }

    public function signUp(Request $request, JWTAuth $JWTAuth)
    {
        $user = new User($request->all());
        if (! $user->save()) {
            throw new HttpException(500);
        }

        if (! Config::get('boilerplate.sign_up.release_token')) {
            return response()->json([
                'status' => 'ok',
            ], 201);
        }

        $token = $JWTAuth->fromUser($user);

        return response()->json([
            'status' => 'ok',
            'token' => $token,
        ], 201);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::guard()->logout();

        return response()
            ->json(['message' => 'Successfully logged out']);
    }

    public function sendResetEmail(ForgotPasswordRequest $request)
    {
        $user = User::where('email', '=', $request->get('email'))->first();

        if (! $user) {
            throw new NotFoundHttpException();
        }

        $broker = $this->getPasswordBroker();
        $sendingResponse = $broker->sendResetLink($request->only('email'));

        if (Password::RESET_LINK_SENT !== $sendingResponse) {
            throw new HttpException(500);
        }

        return response()->json([
            'status' => 'ok',
        ], 200);
    }

     public function resetPassword(Request $request, JWTAuth $JWTAuth)
    {
        $response = $this->broker()->reset(
            $this->credentials($request), function ($user, $password) {
                $this->reset($user, $password);
            }
        );

        if (Password::PASSWORD_RESET !== $response) {
            throw new HttpException(500);
        }

        if (! Config::get('boilerplate.reset_password.release_token')) {
            return response()->json([
                'status' => 'ok',
            ]);
        }

        $user = User::where('email', '=', $request->get('email'))->first();

        return response()->json([
            'status' => 'ok',
            'token' => $JWTAuth->fromUser($user),
        ]);
    }

    /**
     * Get the password reset credentials from the request.
     *
     * @param ResetPasswordRequest $request
     *
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );
    }

    /**
     * Reset the given user's password.
     *
     * @param \Illuminate\Contracts\Auth\CanResetPassword $user
     * @param string                                      $password
     */
    protected function reset($user, $password)
    {
        $user->password = $password;
        $user->save();
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    private function getPasswordBroker()
    {
        return Password::broker();
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $token = Auth::guard()->refresh();

        return response()->json([
            'status' => 'ok',
            'token' => $token,
            'expires_in' => Auth::guard()->factory()->getTTL() * 60,
        ]);
    }

}
