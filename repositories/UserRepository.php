<?php

declare(strict_types=1);

namespace app\repositories;

use app\models\User;
use app\repositories\interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    /**
     * Find a user by ID
     *
     * @param int $id
     * @return User|null
     */
    public function findById(int $id): ?User
    {
        return User::findOne($id);
    }

    /**
     * Find a user by email
     *
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User
    {
        return User::findOne(['email' => $email, 'status' => User::STATUS_ACTIVE]);
    }

    /**
     * Find a user by password reset token
     *
     * @param string $token
     * @return User|null
     */
    public function findByPasswordResetToken(string $token): ?User
    {
        if (!User::isPasswordResetTokenValid($token)) {
            return null;
        }

        return User::findOne([
            'password_reset_token' => $token,
            'status' => User::STATUS_ACTIVE,
        ]);
    }

    /**
     * Save user model
     *
     * @param User $user
     * @return bool
     */
    public function save(User $user): bool
    {
        return $user->save();
    }
}
