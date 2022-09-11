<?php
namespace App\Interfaces;

use App\Models\User;

interface AuthRepositoryInterface
{
    /**
     * Login user with credentials array contains: username or email and password.
     * @param array $loginCredentials
     * @return mixed
     */
    public function login(array $loginCredentials);

    /**
     * Register new user with credentials array contains: username, email and password.
     * @param array $registerCredentials
     * @return mixed
     */
    public function register(array $registerCredentials);

    /**
     * Logout specific user.
     * @param User $user
     * @return bool
     */
    public function logout(User $user);
}
