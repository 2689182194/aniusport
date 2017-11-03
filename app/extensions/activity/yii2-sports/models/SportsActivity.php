<?php

namespace activity\sports\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%sports_activity}}".
 *
 * @property integer $activity_id
 * @property string $activity_name
 * @property integer $created_at
 * @property integer $updated_at
 */
class SportsActivity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sports_activity}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'integer'],
            [['activity_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'activity_id' => 'Activity ID',
            'activity_name' => 'Activity Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public static function Active()
    {
        $active = static::find()->select(['activity_id', 'activity_name'])->asArray()->all();
        return ArrayHelper::map($active, 'activity_id', 'activity_name');

    }
}
