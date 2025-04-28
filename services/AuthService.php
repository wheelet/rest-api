<?php

namespace app\services;

use app\models\User;
use app\services\interfaces\AuthServiceInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Yii;

/**
 * Service for handling authentication and JWT tokens
 */
class AuthService implements AuthServiceInterface
{
    /**
     * @var string JWT secret key
     */
    private string $secretKey;

    /**
     * @var int Token expiration time in seconds
     */
    private int $expirationTime;

    /**
     * AuthService constructor.
     */
    public function __construct()
    {
        $this->secretKey = Yii::$app->params['jwtSecretKey'];
        $this->expirationTime = Yii::$app->params['jwtExpirationTime'];
    }

    /**
     * @inheritdoc
     */
    public function generateToken(User $user): array
    {
        $currentTime = time();
        $expirationTime = $currentTime + $this->expirationTime;

        $payload = [
            'iss' => 'api',
            'aud' => 'api-client',
            'iat' => $currentTime,
            'exp' => $expirationTime,
            'sub' => (string)$user->id,
        ];

        $token = JWT::encode($payload, $this->secretKey, 'HS256');

        return [
            'token' => $token,
            'expires_at' => $expirationTime,
        ];
    }

    /**
     * @inheritdoc
     */
    public function validateToken(string $token): ?User
    {
        try {
            $decoded = JWT::decode($token, new Key($this->secretKey, 'HS256'));

            if (!isset($decoded->sub)) {
                return null;
            }

            return User::findIdentity($decoded->sub);
        } catch (\Exception $e) {
            Yii::error('Token validation error: ' . $e->getMessage());
            return null;
        }
    }
}
