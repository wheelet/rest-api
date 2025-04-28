<?php

declare(strict_types=1);

namespace app\forms;

use yii\base\Model;

final class PasswordResetForm extends Model
{
    /**
     * @var string Token for password reset
     */
    public string $token = '';

    /**
     * @var string New password
     */
    public string $password = '';

    /**
     * @inheritdoc
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [['token', 'password'], 'required'],
            ['token', 'string'],
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
            'token' => 'Token',
            'password' => 'New Password',
        ];
    }
}
