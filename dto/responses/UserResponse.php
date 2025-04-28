<?php

declare(strict_types=1);

namespace app\dto\responses;

use app\dto\BaseDto;
use app\models\User;

/**
 * DTO for user response data
 */
final class UserResponse extends BaseDto
{
    /**
     * @var int User ID
     */
    public int $id = 0;

    /**
     * @var string User's first name
     */
    public string $first_name = '';

    /**
     * @var string User's last name
     */
    public string $last_name = '';

    /**
     * @var string User's email address
     */
    public string $email = '';

    /**
     * @var string|null User's phone number
     */
    public ?string $phone = null;

    /**
     * Create a UserResponse from a User model
     *
     * @param User $user The user model
     * @return self The response DTO
     */
    public static function fromEntity(User $user): self
    {
        $response = new self();
        $response->id = $user->id;
        $response->first_name = $user->first_name;
        $response->last_name = $user->last_name;
        $response->email = $user->email;
        $response->phone = $user->phone;
        return $response;
    }
}
