<?php

namespace app\services\interfaces;

use app\dto\requests\PasswordRecoverRequest;
use app\dto\requests\PasswordResetRequest;
use app\dto\requests\UserLoginRequest;
use app\dto\requests\UserRegisterRequest;
use app\models\User;

/**
 * Interface for user service operations
 */
interface UserServiceInterface
{
    /**
     * Register a new user
     *
     * @param UserRegisterRequest $request DTO with registration data
     * @return User|null
     */
    public function register(UserRegisterRequest $request): ?User;

    /**
     * Authenticate user with email and password
     *
     * @param UserLoginRequest $request DTO with login data
     * @return array|null Return token data or null if authentication fails
     */
    public function login(UserLoginRequest $request): ?array;

    /**
     * Request password recovery
     *
     * @param PasswordRecoverRequest $request DTO with email
     * @return bool
     */
    public function requestPasswordReset(PasswordRecoverRequest $request): bool;

    /**
     * Reset password with token
     *
     * @param PasswordResetRequest $request DTO with token and new password
     * @return bool
     */
    public function resetPassword(PasswordResetRequest $request): bool;

    /**
     * Get user by ID
     *
     * @param int $id
     * @return User|null
     */
    public function getUserById(int $id): ?User;
}
