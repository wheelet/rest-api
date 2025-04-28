<?php

declare(strict_types=1);

namespace app\dto\requests;

use app\dto\BaseDto;

final class PasswordRecoverRequest extends BaseDto
{
    /**
     * @var string Email
     */
    public string $email = '';
}
