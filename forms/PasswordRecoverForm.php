<?php

declare(strict_types=1);

namespace app\forms;

use yii\base\Model;

final class PasswordRecoverForm extends Model
{
    /**
     * @var string Email
     */
    public string $email = '';

    /**
     * @inheritdoc
     * @return array<array<mixed>>
     */
    public function rules(): array
    {
        return [
            ['email', 'required'],
            ['email', 'email'],
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
        ];
    }
}
