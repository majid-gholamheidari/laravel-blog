<?php

namespace App\Repositories;

use App\Interfaces\AuthRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthRepository implements AuthRepositoryInterface
{

    /**
     * Login user with credentials array contains: username or email and password.
     * @param array $loginCredentials
     * @return mixed
     */
    public function login(array $loginCredentials)
    {
        $usernameAttempt = Auth::attempt([
                'username' => $loginCredentials['username'],
                'password' => $loginCredentials['password']
            ]);
        $emailAttempt = Auth::attempt([
                'email' => $loginCredentials['username'],
                'password' => $loginCredentials['password']
            ]);
        if ($usernameAttempt || $emailAttempt) {
            return User::where('email', $loginCredentials['username'])->orWhere('username', $loginCredentials['username'])->first();
        }
        return false;
    }

    /**
     * Register new user with credentials array contains: username, email and password.
     * @param array $registerCredentials
     * @return mixed
     */
    public function register(array $registerCredentials)
    {
        return User::create([
            'username' => $registerCredentials['username'],
            'email' => $registerCredentials['email'],
            'password' => Hash::make($registerCredentials['password']),
        ]);
    }

    /**
     * Logout specific user.
     * @param User $user
     * @return bool
     */
    public function logout(User $user)
    {
        return $user->token()->revoke();
    }
}
