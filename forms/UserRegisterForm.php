<?php

declare(strict_types=1);

namespace app\forms;

use yii\base\Model;

final class UserRegisterForm extends Model
{
    /**
     * @var string First name of the user
     */
    public string $first_name = '';

    /**
     * @var string Surname name of the user
     */
    public string $last_name = '';

    /**
     * @var string Email address of the user
     */
    public string $email = '';

    /**
     * @var string Password of the user
     */
    public string $password = '';

    /**
     * @var string|null Number of the user
     */
    public ?string $phone = null;

    /**
     * @inheritdoc
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [['first_name', 'last_name', 'email', 'password'], 'required'],
            ['email', 'email'],
            ['phone', 'string', 'max' => 20],
            ['password', 'string', 'min' => 6],
            [['first_name', 'last_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     * @return array<string, string>
     */
    public function attributeLabels(): array
    {
        return [
            'first_name' => 'First Name',
            'last_name' => 'Surname',
            'email' => 'Email',
            'password' => 'Password',
            'phone' => 'phone',
        ];
    }
}
