<?php

declare(strict_types=1);

namespace app\dto\requests;

use app\dto\BaseDto;

final class UserRegisterRequest extends BaseDto
{
    /**
     * @var string User's first name
     */
    public string $firstName = '';

    /**
     * @var string User's last name
     */
    public string $lastName = '';

    /**
     * @var string User's email address
     */
    public string $email = '';

    /**
     * @var string User's password
     */
    public string $password = '';

    /**
     * @var string|null User's phone number
     */
    public ?string $phone = null;

    /**
     * Map data from a Model to this DTO
     * Override to handle snake_case to camelCase conversion
     *
     * @param \yii\base\Model $model Model to map data from
     */
    protected function mapFromModel(\yii\base\Model $model): void
    {
        $attributes = $model->getAttributes();

        if (isset($attributes['first_name'])) {
            $this->firstName = $attributes['first_name'];
        }

        if (isset($attributes['last_name'])) {
            $this->lastName = $attributes['last_name'];
        }

        foreach (['email', 'password', 'phone'] as $attribute) {
            if (isset($attributes[$attribute])) {
                $this->$attribute = $attributes[$attribute];
            }
        }
    }
}
