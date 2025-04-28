<?php

declare(strict_types=1);

namespace app\models;

use Yii;
use yii\base\Exception;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use yii\db\BaseActiveRecord;
use yii\db\Expression;
use yii\web\IdentityInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

/**
 * User model
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password_hash
 * @property string $phone
 * @property string $auth_key
 * @property string|null $password_reset_token
 * @property int $status
 * @property \DateTimeImmutable $created_at
 * @property \DateTimeImmutable $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    public const STATUS_DELETED = 0;
    public const STATUS_INACTIVE = 9;
    public const STATUS_ACTIVE = 10;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%user}}';
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
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
            [['first_name', 'last_name', 'email', 'phone'], 'required'],
            ['email', 'email'],
            ['email', 'unique'],
            ['phone', 'string', 'min' => 10, 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     * @param int|string $id
     * @return self|null
     */
    public static function findIdentity($id): ?self
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     * @param string $token
     * @param string|null $type
     * @return self|null
     */
    public static function findIdentityByAccessToken($token, $type = null): ?self
    {
        try {
            $jwtSecretKey = \Yii::$app->params['jwtSecretKey'];

            $decoded = JWT::decode($token, new Key($jwtSecretKey, 'HS256'));

            if (!isset($decoded->sub)) {
                \Yii::error('JWT Token validation error: subject (sub) not set');
                return null;
            }

            return static::findIdentity($decoded->sub);
        } catch (\Firebase\JWT\ExpiredException $e) {
            \Yii::error('JWT Token expired: ' . $e->getMessage());
        } catch (\Firebase\JWT\SignatureInvalidException $e) {
            \Yii::error('JWT Token signature invalid: ' . $e->getMessage());
        } catch (\Exception $e) {
            \Yii::error('JWT Token validation error: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return self|null
     */
    public static function findByEmail(string $email): ?self
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return self|null
     */
    public static function findByPasswordResetToken(string $token): ?self
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid(string $token): bool
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): int
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey(): string
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey): bool
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword(string $password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     * @return void
     * @throws Exception
     */
    public function setPassword(string $password): void
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     * @return void
     * @throws Exception
     */
    public function generateAuthKey(): void
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     * @return void
     * @throws Exception
     */
    public function generatePasswordResetToken(): void
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     * @return void
     */
    public function removePasswordResetToken(): void
    {
        $this->password_reset_token = null;
    }

    /**
     * Get companies associated with this user
     *
     * @return ActiveQuery
     */
    public function getCompanies(): ActiveQuery
    {
        return $this->hasMany(Company::class, ['id' => 'company_id'])
            ->viaTable('{{%user_company}}', ['user_id' => 'id']);
    }
}
