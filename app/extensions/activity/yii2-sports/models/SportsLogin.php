<?php

namespace activity\sports\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%sports_login}}".
 *
 * @property integer $record_id
 * @property string $record_user
 * @property integer $record_time
 * @property integer $created_at
 * @property integer $updated_at
 */
class SportsLogin extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sports_login}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['record_time', 'created_at', 'updated_at'], 'integer'],
            [['record_user'], 'string', 'max' => 100],
        ];
    }

    public function behaviors()
    {
        return [

            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at','record_time'],
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
            'record_id' => 'Record ID',
            'record_user' => 'Record User',
            'record_time' => 'Record Time',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
