<?php

namespace activity\question\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%sports_questions}}".
 *
 * @property integer $id
 * @property string $openid
 * @property string $phone
 * @property string $question
 * @property string $answer
 * @property integer $weight
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Questions extends \yii\db\ActiveRecord
{
    const STATUS_SHOW = 1;

    const STATUS_HIDDEN = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sports_questions}}';
    }

    public function fields()
    {
        return [
            'question',
            'answer',
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
     * @return string
     */
    public static function status()
    {
        return [

            self::STATUS_HIDDEN => ['name' => '隐藏', 'htmlClass' => 'label-info'],

            self::STATUS_SHOW => ['name' => '显示', 'htmlClass' => ' label-success'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phone', 'question'], 'required', 'message' => '{attribute}不能为空'],
            [['question', 'answer'], 'string'],
            ['phone', 'match', 'pattern' => '/^1[3|4|5|7|8][0-9]{9}$/', 'message' => '手机号码格式不正确'],
            [['weight', 'status', 'created_at', 'updated_at'], 'integer'],
            [['openid'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 12],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'openid' => 'Openid',
            'phone' => '手机号',
            'question' => '问题',
            'answer' => '答案',
            'weight' => '排序',
            'status' => '状态',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
        ];
    }
}
