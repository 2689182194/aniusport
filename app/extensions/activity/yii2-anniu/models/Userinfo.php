<?php

namespace activity\anniu\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%userinfo}}".
 *
 * @property integer $id
 * @property string $username
 * @property string $nation
 * @property string $phone
 * @property integer $age
 * @property string $bloodtype
 * @property string $medicalhistory
 * @property string $familymedicalhistory
 * @property string $consultdirection
 * @property string $openid
 * @property integer $created_at
 */
class Userinfo extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%anniuwenzhen_userinfo}}';
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
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
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
            [['openid', 'username', 'phone', 'consultdirection'], 'required','message'=>'{attribute}不能为空'],
            [['phone'], 'unique','message'=>'{attribute}已经存在不能重复使用'],
            [['age', 'created_at'], 'integer'],
            [['username', 'nation', 'openid'], 'string', 'max' => 100],
            ['age', 'default', 'value' => 0],
            [['phone'], 'string', 'max' => 15],
            [['bloodtype'], 'string', 'max' => 50],
            [['medicalhistory', 'familymedicalhistory', 'consultdirection'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '姓名',
            'nation' => '民族',
            'phone' => '电话',
            'age' => '年龄',
            'bloodtype' => '血型',
            'medicalhistory' => '病史',
            'familymedicalhistory' => '家族病史',
            'consultdirection' => '咨询方向',
            'openid' => '微信号',
            'created_at' => '创建时间',
        ];
    }

    public static function User()
    {
        return ArrayHelper::map(static::find()->all(), 'id', 'username');

    }
}
