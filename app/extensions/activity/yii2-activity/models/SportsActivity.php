<?php

namespace activity\activity\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use grazio\image\helpers\ImageHelper;

/**
 * This is the model class for table "{{%sports_activity}}".
 *
 * @property integer $activity_id
 * @property integer $group_id
 * @property string $activity_name
 * @property integer $created_at
 * @property integer $updated_at
 */
class SportsActivity extends \yii\db\ActiveRecord
{
    const FLAG_NO_SHOW = 0;
    const FLAG_SHOW = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sports_activity}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => \grazio\image\behaviors\UploadImageBehavior::className(),
                'attributes' => ['file']
            ],
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],

        ];
    }

    public static function flag()
    {
        return [

            self::FLAG_NO_SHOW => ['name' => '隐藏', 'htmlClass' => 'label-info'],
            self::FLAG_SHOW => ['name' => '显示', 'htmlClass' => 'label-success']
        ];
    }

    public function fields()
    {
        $extra = [
            'banner' => function ($model) {
                return $model->file ?  Yii::$app->params['image_link'] . ImageHelper::src($model->file) : '';
            },
            'start_time',
            'end_time',
            'activity_name'
        ];

        return $extra;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_id', 'activity_name', 'start_time', 'end_time'], 'required', 'message' => '{attribute}不能为空'],
            ['activity_name', 'unique', 'message' => '{attribute}的值已经存在'],
            ['end_time', 'compare', 'compareAttribute' => 'start_time', 'operator' => '>=', 'message' => '结束时间必须大于开始时间'],
            [['group_id', 'created_at', 'updated_at'], 'integer'],
            [['activity_name'], 'string', 'max' => 255],
            [['file'], 'image', 'extensions' => 'png, jpg',
//                'minWidth' => 64, 'maxWidth' => 1920,
//                'minHeight' => 64, 'maxHeight' => 1080,
//                'maxSize' => 800 * 1024,
                'enableClientValidation' => true,
                'tooBig' => '上传文件不能大于{formattedLimit}'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'activity_id' => 'id',
            'group_id' => '活动分类',
            'activity_name' => '活动名称',
            'file' => '活动图片',
            'status' => '状态',
            'start_time' => '活动开始时间',
            'end_time' => '活动结束时间',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
        ];
    }

    public function getGroup()
    {
        return $this->hasOne(ActivityGroup::className(), ['id' => 'group_id']);
    }
}
