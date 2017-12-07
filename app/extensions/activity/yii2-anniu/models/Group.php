<?php

namespace activity\anniu\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%group}}".
 *
 * @property integer $group_id
 * @property string $group_name
 * @property integer $start_at
 * @property integer $end_at
 * @property integer $created_at
 * @property integer $updated_at
 */
class Group extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%anniuwenzhen_group}}';
    }
    public static function getDb()
    {
        return Yii::$app->get('db1');
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
    public function rules()
    {
        return [
            [['group_name', 'start_at', 'end_at'], 'required', 'message' => '{attribute}不能为空'],
            ['end_at', 'compare', 'compareAttribute' => 'start_at', 'operator' => '>=', 'message' => '结束时间必须大于开始时间'],
            [['group_name'], 'unique', 'message' => '{attribute}已存在不能重复使用'],
            [['created_at', 'updated_at'], 'integer'],
            [['group_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'group_id' => 'id',
            'group_name' => '组名',
            'start_at' => '开始时间',
            'end_at' => '结束时间',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
        ];
    }

    public static function Group()
    {
        return ArrayHelper::map(static::find()->all(), 'group_id', 'group_name');

    }
}
