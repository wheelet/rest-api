<?php

declare(strict_types=1);

namespace app\dto\responses;

use app\dto\BaseDto;

final class AuthTokenResponse extends BaseDto
{
    /**
     * @var string Access token
     */
    public string $token = '';

    /**
     * @var int Token expiration timestamp
     */
    public int $expires_at = 0;

    /**
     * @var UserResponse User information
     */
    public UserResponse $user;

    /**
     * Create an AuthTokenResponse
     *
     * @param string $token JWT token
     * @param int $expiresAt Token expiration timestamp
     * @param UserResponse $userResponse User response DTO
     * @return self
     */
    public static function create(string $token, int $expiresAt, UserResponse $userResponse): self
    {
        $response = new self();
        $response->token = $token;
        $response->expires_at = $expiresAt;
        $response->user = $userResponse;
        return $response;
    }
}
