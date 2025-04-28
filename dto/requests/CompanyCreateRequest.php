<?php

declare(strict_types=1);

namespace app\dto\requests;

use app\dto\BaseDto;


class CompanyCreateRequest extends BaseDto
{
    /**
     * @var string Company title
     */
    public string $title = '';

    /**
     * @var string Company phone
     */
    public string $phone = '';

    /**
     * @var string|null Company description
     */
    public ?string $description = null;
}
