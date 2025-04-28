<?php

declare(strict_types=1);

namespace app\dto\requests;

use app\dto\BaseDto;

final class PasswordResetRequest extends BaseDto
{
    /**
     * @var string Rесет token
     */
    public string $token = '';

    /**
     * @var string New password
     */
    public string $password = '';
}
