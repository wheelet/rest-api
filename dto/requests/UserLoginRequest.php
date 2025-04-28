<?php

declare(strict_types=1);

namespace app\dto\requests;

use app\dto\BaseDto;

final class UserLoginRequest extends BaseDto
{
    /**
     * @var string User's email address
     */
    public string $email = '';

    /**
     * @var string User's password
     */
    public string $password = '';
}
