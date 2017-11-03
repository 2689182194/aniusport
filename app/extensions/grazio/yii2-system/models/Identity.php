<?php
/**
 * @link https://github.com/yii2tech
 * @copyright Copyright (c) 2015 Yii2tech
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */

namespace grazio\system\models;

use grazio\core\validators\PasswordValidator;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii2tech\ar\softdelete\SoftDeleteBehavior;
use yii2tech\authlog\AuthLogIdentityBehavior;

/**
 * Identity is a base class for identity models.
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property boolean $isActive whether identity is active
 * @property boolean $isDeleted whether identity is marked as deleted
 * @property boolean $isSuspended whether identity is suspended
 *
 * @property IdentityStatus $status
 *
 * @property integer $lastLoginDate
 * @property integer $preLastLoginDate
 *
 * @method integer|boolean softDelete()
 * @method integer|boolean safeDelete()
 * @method integer|boolean restore()
 *
 * @author Paul Klimov <pklimov@quartsoft.com>
 * @package app\models\db
 */
abstract class Identity extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 1;
    const STATUS_PENDING = 5;
    const STATUS_SUSPENDED = 7;
    const STATUS_ACTIVE = 10;

    /**
     * @var string new identity password
     */
    public $password;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
            ],
            'softDelete' => [
                'class' => SoftDeleteBehavior::className(),
                'softDeleteAttributeValues' => [
                    'status_id' => self::STATUS_DELETED,
                    'updated_at' => function () {
                        return time();
                    },
                ],
                'restoreAttributeValues' => [
                    'status_id' => self::STATUS_ACTIVE,
                    'updated_at' => function () {
                        return time();
                    },
                ],
            ],
            'authLog' => [
                'class' => AuthLogIdentityBehavior::className(),
                'defaultAuthLogData' => function ($model) {
                    return [
                        'ip' => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null,
                        'host' => isset($_SERVER['REMOTE_ADDR']) ? @gethostbyaddr($_SERVER['REMOTE_ADDR']) : null,
                        'url' => $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
                        'userAgent' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null,
                    ];
                },
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email'], 'filter', 'filter' => 'trim'],
            [['username', 'email'], 'unique'],
            ['email', 'required'],
            ['username', 'required', 'except' => 'create'],
            ['password', 'required', 'on' => 'create'],
            ['password', PasswordValidator::className()],
            ['email', 'email'],
            ['status_id', 'default', 'value' => self::STATUS_PENDING],
            ['status_id', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_PENDING, self::STATUS_DELETED]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('user', 'Username'),
            'email' => Yii::t('user', 'Email'),
            'created_at' => Yii::t('user', 'Created at'),
            'updated_at' => Yii::t('user', 'Updated at'),
            'status_id' => Yii::t('common', 'Status'),
            'password' => Yii::t('auth', 'Password'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if ($insert) {
            if (empty($this->password) && empty($this->password_hash)) {
                $this->password = $this->generatePassword();
            }
            if (empty($this->username)) {
                $this->username = $this->email;
            }
            if (!isset($this->auth_key)) {
                $this->generateAuthKey();
            }
            if (!isset($this->status_id)) {
                $this->status_id = self::STATUS_ACTIVE;
            }
        }

        if (!empty($this->password)) {
            $this->password_hash = Yii::$app->security->generatePasswordHash($this->password);
        }

        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     * @return IdentityQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new IdentityQuery(get_called_class());
    }

    // Identity Logic :

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status_id' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by login name (username or email)
     *
     * @param string $loginName
     * @return static|null
     */
    public static function findByLoginName($loginName)
    {
        return static::find()->where(['username' => $loginName])->orWhere(['email' => $loginName])->one();
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'passwordResetToken' => $token,
            'statusId' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['identity.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * @return boolean whether identity is active
     */
    public function getIsActive()
    {
        return $this->status_id === self::STATUS_ACTIVE;
    }

    /**
     * @return boolean whether identity is marked as deleted
     */
    public function getIsDeleted()
    {
        return $this->status_id === self::STATUS_DELETED;
    }

    /**
     * @return boolean whether identity is suspended
     */
    public function getIsSuspended()
    {
        return $this->status_id === self::STATUS_SUSPENDED;
    }

    /**
     * Generates random password.
     * @return string random password.
     */
    public static function generatePassword()
    {
        return Yii::$app->security->generateRandomString(8);
    }

    // Relations :

    /**
     * @return \yii\db\ActiveQuery relation query
     */
    public function getStatus()
    {
        return self::statusList()[$this->status_id]['name'];
    }

    public static function statusList()
    {
        return [
            Self::STATUS_ACTIVE => [
                'id'=> Self::STATUS_ACTIVE ,
                'name' => Yii::t('status', 'Active')
            ],
            Self::STATUS_SUSPENDED => [
                'id'=> Self::STATUS_SUSPENDED ,
                'name' => Yii::t('status', 'Suspended')
            ],
            Self::STATUS_PENDING => [
                'id'=> Self::STATUS_PENDING ,
                'name' => Yii::t('status', 'Pending')
            ],
            Self::STATUS_DELETED => [
                'id'=> Self::STATUS_DELETED ,
                'name' => Yii::t('status', 'Deleted')
            ],
        ];
    }

    // Logic :

    /**
     * Activates user account.
     * @return boolean success.
     */
    public function activate()
    {
        if ($this->isActive) {
            return true;
        }
        $this->status_id = self::STATUS_ACTIVE;
        $this->generateAuthKey();
        return $this->save(false);
    }

    /**
     * Suspends this account.
     * @return boolean success.
     */
    public function suspend()
    {
        if ($this->status_id !== self::STATUS_ACTIVE) {
            return false;
        }
        return $this->updateAttributes(['status_id' => self::STATUS_SUSPENDED]) > 0;
    }

    /**
     * Sends email notification about account been suspended.
     * @return boolean success.
     */
    abstract public function sendSuspendEmail();
}