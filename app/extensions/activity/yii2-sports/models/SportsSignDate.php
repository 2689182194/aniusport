<?php

namespace activity\sports\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%sports_sign_date}}".
 *
 * @property integer $id
 * @property string $sign_user
 * @property integer $sign_date
 * @property integer $created_at
 * @property integer $updated_at
 */
class SportsSignDate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sports_sign_date}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['sign_time', 'updated_at', 'created_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at', 'sign_time'],
                ],
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sign_user'], 'required'],
            [['sign_time', 'created_at', 'updated_at','sign_day'], 'integer'],
            [['sign_user'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sign_user' => '签到用户',
            'sign_time' => '签到日期',
            'sign_day' => '连续签到日期',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
        ];
    }

    /**
     * 记录当天签到
     * @param $openId 签到用户
     * @param $signDay 连续签到天数
     * @return bool
     */
    public static function SignRecord($openId,$signDay)
    {
        $model = static::findOne($openId);
        if (empty($model)) {
            $model = new SportsSignDate();
        }
        $model->sign_user = $openId;
        $model->sign_day = $signDay;
        return $model->save() ? true : false;
    }

    /**
     * 记录固定的时间段内是否进行签到
     * @param $todayBegin 开始时间
     * @param $todayEnd 结束时间
     * @param $openId 当前登录人
     * @return SportsSign|array|null|string|ActiveRecord
     */
    public static function IsSign($todayBegin, $todayEnd, $openId)
    {
        $result = static::find()->Where(['between', 'sign_time', $todayBegin, $todayEnd])->andWhere(['sign_user' => $openId])->one();
        return $result ? $result : '';
    }

}
