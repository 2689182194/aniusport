<?php

namespace activity\sports\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;

/**
 * This is the model class for table "{{%sports_user}}".
 *
 * @property integer $id
 * @property string $openid
 * @property string $nickname
 * @property integer $gender
 * @property string $avatarUrl
 * @property string $country
 * @property string $province
 * @property string $city
 * @property integer $scores
 * @property integer $created_at
 * @property integer $updated_at
 */
class SportsUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sports_user}}';
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
            [['gender', 'scores', 'created_at', 'updated_at','badge'], 'integer'],
            [['avatarUrl'], 'string'],
            [['ip'], 'string', 'max' => 15],
            [['authKey', 'openid', 'nickname', 'country', 'province', 'city'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'authKey' => 'Auth Key',
            'openid' => 'Openid',
            'nickname' => 'Nickname',
            'gender' => 'Gender',
            'avatarUrl' => 'Avatar Url',
            'country' => 'Country',
            'province' => 'Province',
            'ip' => 'Ip',
            'city' => 'City',
            'badge' =>'Badge',
            'scores' => 'Scores',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * 查找该用户是否已经存在
     * @param $openId
     * @return SportsUser|array|null|ActiveRecord
     */
    public static function UserInfo($openId)
    {
        return static::find()->where(['openid' => $openId])->one();
    }

    /**保留用户信息
     * @param $data
     * @param $openId
     * @return int
     */
    public static function Register($data, $openId)
    {

        $userInfo = User::findIdentity($openId);
        if (empty($userInfo)) {
            $model = new SportsUser();
            $data = Json::decode($data['userInfo'], true);
            $model->avatarUrl = $data['avatarUrl'];
            $model->nickname = $data['nickName'];
            $model->gender = $data['gender'];
            $model->country = $data['country'];
            $model->province = $data['province'];
            $model->city = $data['city'];
            $model->openid = $openId;
            $model->ip = Yii::$app->request->userIP;
            $model->save();
        }
        $user = User::findIdentity($openId);
        if (empty($user)) {
            $user = new User();
            $user->openid = $openId;
            $user->ip = Yii::$app->request->userIP;
            $user->save();
        }
        Yii::$app->user->logout();

        Yii::$app->user->login($user, 7200);

    }

    /**
     * 更新用户表中的用户积分记录
     * @param $data 数组，包含当前登录用户与要更新的积分
     * @param $status 积分状态0-增加；1-消耗
     * @return bool
     */
    public static function UpdateScores($data, $status)
    {
        $identification = $data['identification'];
        $openId = substr($identification, 24);
        $userInfo = User::findIdentity($openId);
        if ($status == 0) {
            $userInfo->scores = ($userInfo->scores) + $data['score'];
        } else {
            $userInfo->scores = ($userInfo->scores) - $data['score'];
        }
        return $userInfo->save() ? true : false;
    }
}
