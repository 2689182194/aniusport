<?php

namespace activity\anniu\models;

use Yii;

/**
 * This is the model class for table "{{%weixin_user}}".
 *
 * @property string $openid
 * @property string $wx_username
 * @property integer $wx_sex
 * @property string $wx_country
 * @property string $wx_province
 * @property string $wx_city
 * @property string $wx_avatar
 * @property integer $wx_subscribe
 * @property string $wx_access_token
 * @property integer $wx_expires
 * @property string $ip
 * @property string $created_at
 * @property string $realname
 * @property string $mobile
 * @property string $address
 * @property integer $d1_times
 * @property integer $d1_status
 * @property integer $d1_pid
 * @property integer $d2_times
 * @property integer $d2_status
 * @property integer $d2_pid
 * @property integer $d3_times
 * @property integer $d3_status
 * @property integer $d3_pid
 * @property integer $d4_times
 * @property integer $d4_status
 * @property integer $d4_pid
 * @property integer $d5_times
 * @property integer $d5_status
 * @property integer $d5_pid
 * @property integer $d6_times
 * @property integer $d6_status
 * @property integer $d6_pid
 * @property integer $d7_times
 * @property integer $d7_status
 * @property integer $d7_pid
 */
class WeixinUser extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%anniuwenzhen_weixin_user}}';
    }

    public static function getDb()
    {
        return Yii::$app->get('db1');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['openid','ip'], 'required'],
            [['created_at','authKey'], 'safe'],
            [['mobile'], 'string', 'max' => 11],
            [['address'], 'string', 'max' => 255],
            [['openid'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'openid' => 'Openid',
            'wx_username' => 'Wx Username',
            'wx_sex' => 'Wx Sex',
            'wx_country' => 'Wx Country',
            'wx_province' => 'Wx Province',
            'wx_city' => 'Wx City',
            'wx_avatar' => 'Wx Avatar',
            'wx_subscribe' => 'Wx Subscribe',
            'wx_access_token' => 'Wx Access Token',
            'wx_expires' => 'Wx Expires',
            'ip' => 'Ip',
            'created_at' => 'Created At',
            'realname' => 'Realname',
            'mobile' => 'Mobile',
            'address' => 'Address',
            'd1_status' => 'D1 Status',
            'd1_pid' => 'D1 Pid',
            'd2_status' => 'D2 Status',
            'd2_pid' => 'D2 Pid',
            'd3_status' => 'D3 Status',
            'd3_pid' => 'D3 Pid',
            'd4_status' => 'D4 Status',
            'd4_pid' => 'D4 Pid',
            'd5_status' => 'D5 Status',
            'd5_pid' => 'D5 Pid',
            'd6_status' => 'D6 Status',
            'd6_pid' => 'D6 Pid',
            'd7_status' => 'D7 Status',
            'd7_pid' => 'D7 Pid',
        ];
    }

    public function getPhoto(){
        return $this->hasOne(Photo::className(),['openid'=>'openid']);
    }

}
