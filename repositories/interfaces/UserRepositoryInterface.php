<?php

namespace app\repositories\interfaces;

use app\models\User;

interface UserRepositoryInterface
{
    /**
     * Find a user by ID
     *
     * @param int $id
     * @return User|null
     */
    public function findById(int $id): ?User;

    /**
     * Find a user by email
     *
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User;

    /**
     * Find a user by password reset token
     *
     * @param string $token
     * @return User|null
     */
    public function findByPasswordResetToken(string $token): ?User;

    /**
     * Save user model
     *
     * @param User $user
     * @return bool
     */
    public function save(User $user): bool;
}
