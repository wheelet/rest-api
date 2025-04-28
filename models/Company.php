<?php

declare(strict_types=1);

namespace app\models;

use yii\base\InvalidConfigException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use yii\db\BaseActiveRecord;
use yii\db\Expression;

/**
 * Company model
 *
 * @property int $id
 * @property string $title
 * @property string $phone
 * @property string $description
 * @property \DateTimeImmutable $created_at
 * @property \DateTimeImmutable $updated_at
 */
final class Company extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%company}}';
    }

    /**
     * {@inheritdoc}
     * @return array<string, mixed>
     */
    public function behaviors(): array
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    BaseActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     * @return array<array<mixed>>
     */
    public function rules(): array
    {
        return [
            [['title', 'phone'], 'required'],
            [['title'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 15],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     * @return array<string, string>
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'phone' => 'Phone',
            'description' => 'Description',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Get users associated with this company
     *
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getUsers(): ActiveQuery
    {
        return $this->hasMany(User::class, ['id' => 'user_id'])
            ->viaTable('{{%user_company}}', ['company_id' => 'id']);
    }

    /**
     * Factory method that encapsulates invariants for creating a Company entity.
     */
    public static function create(string $title, string $phone, string $description = ''): self
    {
        $model = new self();
        $model->title = $title;
        $model->phone = $phone;
        $model->description = $description;

        return $model;
    }
}
