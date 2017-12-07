<?php

namespace activity\activity\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%sports_activity_group}}".
 *
 * @property integer $id
 * @property string $group_name
 * @property integer $created_at
 * @property integer $updated_at
 */
class ActivityGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sports_activity_group}}';
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

    public function fields()
    {
        return [
            'group_name'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['group_name', 'unique', 'message' => '{attribute}已经存在'],
            ['group_name', 'required', 'message' => '{attribute}不能为空'],
            [['created_at', 'updated_at'], 'integer'],
            [['group_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'group_name' => '分类名称',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
        ];
    }
    /**
     * 查找所有的分组焦点图
     * @return mixed
     */
    public static function Group()
    {
        $data = self::find()->all();
        return ArrayHelper::map($data, 'id', 'group_name');
    }
}
