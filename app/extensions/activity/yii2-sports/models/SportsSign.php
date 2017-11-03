<?php

namespace activity\sports\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%sports_sign}}".
 *
 * @property integer $sign_id
 * @property integer $sign_day
 * @property integer $sign_time
 * @property integer $created_at
 * @property integer $updated_at
 */
class SportsSign extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sports_sign}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['sign_time', 'updated_at', 'created_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
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
            [['sign_day', 'sign_time', 'created_at', 'updated_at'], 'integer'],
            [['sign_user'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sign_id' => 'Sign ID',
            'sign_day' => 'Sign Day',
            'sign_time' => 'Sign Time',
            'sign_user' => 'Sign User',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
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

    /**
     * 记录当天签到和连续签到日期
     * @param $openId 签到用户
     * @param $signDay 连续签到天数
     * @return bool
     */
    public static function SignRecord($openId, $signDay)
    {
        $model = new SportsSign();
        $model->sign_day = $signDay;
        $model->sign_user = $openId;
        return $model->save() ? true : false;
    }

    /**
     * 查询签到历史
     * @param $first_day 本月初凌晨00:00:00
     * @param $last_day 本月末凌晨00:00:00
     * @param $openId 签到用户
     * @return array
     */
    public static function History($first_day, $last_day, $openId)
    {
        $history = static::find()->Where(['between', 'sign_time', $first_day, $last_day])->andWhere(['sign_user' => $openId])->orderBy(['sign_time' => SORT_DESC])->all();
        if ($history) {
            foreach ($history as $k => $v) {
                $history[$k]['sign_time'] = date('d', $v->sign_time);
                $data[] = $history[$k]['sign_time'];
            }
            $result = [
                'sign_date' => $data,
                'sign_day' => $history[0]['sign_day'],
            ];

        } else {
            //查找当月的上一个月的最后一天是否进行签到
            $Month_day = strtotime(date('Y-m-t', strtotime('-1 month')) . ' 00:00:00');
            $lastMonth_day = strtotime(date('Y-m-t', strtotime('-1 month')) . ' 23:59:59');
            $last_record = static::IsSign($Month_day, $lastMonth_day, $openId);
            $result = [
                'sign_date' => '',
                'sign_day' => $last_record ? $last_record->sign_day : ''
            ];
        }

        return $result;
    }
}
