<?php

namespace app\services\interfaces;

use app\models\User;

/**
 * Interface for authentication service
 */
interface AuthServiceInterface
{
    /**
     * Generate a JWT token for a user
     *
     * @param User $user The user to generate a token for
     * @return array Token data with the token and expiration timestamp
     */
    public function generateToken(User $user): array;

    /**
     * Validate a JWT token
     *
     * @param string $token The JWT token to validate
     * @return User|null The authenticated user or null if invalid
     */
    public function validateToken(string $token): ?User;
}
