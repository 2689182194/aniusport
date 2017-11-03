<?php

namespace activity\anniu\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "{{%group_user}}".
 *
 * @property integer $id
 * @property integer $group_id
 * @property integer $user_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class GroupUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%group_user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_id', 'user_id'], 'required'],
            [['group_id', 'user_id', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    public function behaviors()
    {
        return [

            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'group_id' => '组名',
            'user_id' => '用户名',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
        ];
    }

    public function getGroup()
    {
        return $this->hasOne(Group::className(), ['group_id' => 'group_id']);
    }

    public function getUser()
    {
        return $this->hasOne(Userinfo::className(), ['id' => 'user_id']);
    }
}
