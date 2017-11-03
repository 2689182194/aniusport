<?php

namespace grazio\main\models;

use Yii;

/**
 * This is the model class for table "{{%getpwd_token}}".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $token
 * @property integer $create_at
 */
class Getpwd extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%getpwd_token}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'token', 'created_at'], 'required'],
            [['id', 'uid', 'created_at'], 'integer'],
            [['token'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'uid' => Yii::t('app', '用户ID'),
            'token' => Yii::t('app', '验证码'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }
}
