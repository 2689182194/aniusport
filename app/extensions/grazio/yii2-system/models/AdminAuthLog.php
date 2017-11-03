<?php

namespace grazio\system\models;

use Yii;

/**
 * This is the model class for table "AdminAuthLog".
 *
 * @property integer $id
 * @property integer $date
 * @property boolean $cookieBased
 * @property integer $duration
 * @property string $error
 * @property string $ip
 * @property string $host
 * @property string $url
 * @property string $userAgent
 * @property integer $adminId
 *
 * @property Admin $admin
 */
class AdminAuthLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin_auth_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date', 'duration', 'admin_id'], 'integer'],
            [['cookie_based'], 'boolean'],
            [['error', 'ip', 'host', 'url', 'user_agent'], 'string', 'max' => 255],
            [['admin_id'], 'exist', 'skipOnError' => true, 'targetClass' => Admin::className(), 'targetAttribute' => ['admin_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => Yii::t('common', 'Date'),
            'cookie_based' => Yii::t('auth', 'Cookie Based'),
            'duration' => Yii::t('auth', 'Duration'),
            'error' => Yii::t('yii', 'Error'),
            'ip' => Yii::t('common', 'IP Address'),
            'host' => Yii::t('common', 'Host'),
            'url' => 'URL',
            'user_agent' => Yii::t('auth', 'UserAgent'),
            'admin_id' => Yii::t('admin', 'Administrator'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdmin()
    {
        return $this->hasOne(Admin::className(), ['id' => 'admin_id']);
    }
}