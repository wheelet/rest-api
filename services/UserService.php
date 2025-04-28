<?php

namespace app\services;

use app\dto\requests\PasswordRecoverRequest;
use app\dto\requests\PasswordResetRequest;
use app\dto\requests\UserLoginRequest;
use app\dto\requests\UserRegisterRequest;
use app\models\User;
use app\repositories\interfaces\UserRepositoryInterface;
use app\services\interfaces\AuthServiceInterface;
use app\services\interfaces\UserServiceInterface;
use yii\base\Exception;

class UserService implements UserServiceInterface
{

    /**
     * UserService constructor.
     *
     * @param UserRepositoryInterface $userRepository
     * @param AuthServiceInterface $authService
     */
    public function __construct(public UserRepositoryInterface $userRepository, public AuthServiceInterface $authService)
    {
    }

    /**
     * Save user data
     *
     * @param UserRegisterRequest $request
     * @return User|null
     * @throws Exception
     */
    public function register(UserRegisterRequest $request): ?User
    {
        $user = new User();
        $user->first_name = $request->firstName;
        $user->last_name = $request->lastName;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->setPassword($request->password);
        $user->generateAuthKey();
        $user->status = User::STATUS_ACTIVE;

        if ($this->userRepository->save($user)) {
            return $user;
        }

        return null;
    }

    /**
     * Authenticate user with email and password
     *
     * @param UserLoginRequest $request
     * @return array|null Return token data or null if authentication fails
     */
    public function login(UserLoginRequest $request): ?array
    {
        $user = $this->userRepository->findByEmail($request->email);

        if (empty($user) || !$user->validatePassword($request->password)) {
            return null;
        }

        $token = $this->authService->generateToken($user);

        return [
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
            ],
        ];
    }

    /**
     * Request password recovery
     *
     * @param PasswordRecoverRequest $request
     * @return bool
     * @throws Exception
     */
    public function requestPasswordReset(PasswordRecoverRequest $request): bool
    {
        $user = $this->userRepository->findByEmail($request->email);

        if ($user === null) {
            return false;
        }

        $user->generatePasswordResetToken();
        if (!$this->userRepository->save($user)) {
            return false;
        }

        // Here you would send an email with the token
        // This is just a placeholder for the actual email sending logic
        // $this->sendPasswordResetEmail($user);

        return true;
    }

    /**
     * Reset password with token
     *
     * @param PasswordResetRequest $request
     * @return bool
     * @throws Exception
     */
    public function resetPassword(PasswordResetRequest $request): bool
    {
        $user = $this->userRepository->findByPasswordResetToken($request->token);

        if (empty($user)) {
            return false;
        }

        $user->setPassword($request->password);
        $user->removePasswordResetToken();

        return $this->userRepository->save($user);
    }

    /**
     * Get user by ID
     *
     * @param int $id
     * @return User|null
     */
    public function getUserById(int $id): ?User
    {
        return $this->userRepository->findById($id);
    }
}
