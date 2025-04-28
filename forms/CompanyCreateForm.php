<?php

declare(strict_types=1);

namespace app\forms;

use yii\base\Model;

class CompanyCreateForm extends Model
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

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['title', 'phone'], 'required'],
            [['title'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 1000],
            [['description'], 'default', 'value' => null],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'title' => 'Company Title',
            'phone' => 'Phone Number',
            'description' => 'Description',
        ];
    }
}
