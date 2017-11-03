<?php

namespace activity\sports\models;

use activity\sports\web\controllers\IdentifyController;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%sports_scores}}".
 *
 * @property integer $score_id
 * @property string $user_id
 * @property integer $score_status
 * @property integer $score_rules
 * @property integer $score_value
 * @property integer $score_time
 * @property integer $created_at
 * @property integer $updated_at
 */
class SportsScores extends \yii\db\ActiveRecord
{
    const RULES_DAILY = 'Daily';//用户首次登录

    const RULES_SIGN = 'Sign';//签到记录

    const STATUS_INCREASE = 0;

    const STATUS_DECREASE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sports_scores}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at', 'score_time'],
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
            [['user_id', 'score_value'], 'required', 'message' => '{attribute}不能为空'],
            [['score_status', 'score_value', 'score_time', 'created_at', 'updated_at'], 'integer'],
            [['user_id', 'score_rules'], 'string', 'max' => 100],
        ];
    }

    public static function status()
    {
        //todo
        return [

            self::RULES_SIGN => ['name' => '签到', 'htmlClass' => 'label-info'],

            self::RULES_DAILY => ['name' => '首次登录', 'htmlClass' => ' label-success'],

            self::STATUS_INCREASE => ['name' => '+'],

            self::STATUS_DECREASE => ['name' => '-']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'score_id' => 'Score ID',
            'user_id' => '用户',
            'score_status' => 'Score Status',
            'score_rules' => 'Score Rules',
            'score_value' => '积分',
            'score_time' => 'Score Time',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * 添加积分记录
     * @param $data 数组，包含当前登录用户与要更新的积分
     * @param $status 积分状态0-增加；1-消耗
     * @param string $score_rules 积分获得途径
     * @return bool
     */
    public static function RecodeScores($data, $status, $score_rules = '')
    {
        $score_rules = isset($data['score_rules']) ? $data['score_rules'] : $score_rules;
        $model = new SportsScores();
        $identification = $data['identification'];
        $openId = IdentifyController::Identification($identification);
        $model->score_status = $status;
        $model->user_id = $openId;
        $model->score_value = $data['score'];
        $model->score_rules = $score_rules;
        return $model->save() ? true : false;
    }

    /**
     * 积分记录
     * @param string $user 用户
     * @return array|ActiveRecord[]
     */
    public static function ScoreRecord($user = 'oZJcc0WwhZWuLFfeN-ETjLOwvcxI')
    {
        $data = static::find()->select(['score_status','score_rules','score_value','score_time'])->where(['user_id' => $user])->all();

        $status = static::status();

        foreach ($data as $k => $v) {
            $data[$k]['score_rules'] = $status[$v->score_rules]['name'];
            $data[$k]['score_status'] = $status[$v->score_status]['name'];
            $data[$k]['score_time'] = date('Y-m-d H:i:s',$v->score_time);
        }

        return $data;
    }
}
