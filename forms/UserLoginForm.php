<?php

declare(strict_types=1);

namespace app\forms;

use yii\base\Model;

/**
 * Форма входу користувача
 */
final class UserLoginForm extends Model
{
    /**
     * @var string Email
     */
    public string $email = '';

    /**
     * @var string User's password
     */
    public string $password = '';

    /**
     * @inheritdoc
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [['email', 'password'], 'required'],
            ['email', 'email'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * @inheritdoc
     * @return array<string, string>
     */
    public function attributeLabels(): array
    {
        return [
            'email' => 'Email',
            'password' => 'Password',
        ];
    }
}
