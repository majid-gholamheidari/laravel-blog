<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Interfaces\AuthRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    private AuthRepositoryInterface $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    /**
     * Login with username/email and password.
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $loginCredentials = $request->only(['username', 'password']);
        $user = $this->authRepository->login($loginCredentials);
        if (!$user) {
            return $this->response([], 422, 'Invalid credentials! try again.', false);
        }
        $data = [
            'username' => $user->username,
            'email' => $user->email,
            'token' => $user->createToken('new_login_token')->accessToken,
            'email_verified' => $user->email_verified_at != null ? true : false
        ];
        return $this->response($data, 200, "Welcome back.", true);
    }

    /**
     * Register with username, email and password.
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $registerCredentials = $request->only(['username', 'email', 'password']);
        $user = $this->authRepository->register($registerCredentials);
        $data = [
            'username' => $user->username,
            'email' => $user->email,
            'token' => $user->createToken('new_user_token')->accessToken,
            'email_verified' => $user->email_verified_at != null ? true : false
        ];
        return $this->response($data, 200, "Welcome $user->username.", true);
    }

    /**
     * Logout specific user within Bearer token.
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $user = $request->user('api');
        $this->authRepository->logout($user);
        return $this->response([], 200, 'You have successfully logged out.');
    }
}
