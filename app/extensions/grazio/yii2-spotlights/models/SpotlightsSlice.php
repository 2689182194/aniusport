<?php

namespace grazio\spotlights\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii2tech\ar\softdelete\SoftDeleteBehavior;
use clcnst\search\behaviors\SearchIndexBehavior;
use grazio\system\models\Admin;

/**
 * This is the model class for table "{{%spotlights_slice}}".
 *
 * @property integer $id
 * @property integer $group_id
 * @property string $title
 * @property string $description
 * @property string $file
 * @property string $link
 * @property integer $type
 * @property string $status
 * @property integer $weight
 * @property integer $begin_at
 * @property integer $end_at
 * @property integer $deleted_at
 * @property integer $created_at
 */
class SpotlightsSlice extends ActiveRecord
{
    const STATUS_DRAFT = 'DRAFT';
//    const STATUS_DELETED = 'DELETED';
    const STATUS_POSTED = 'POSTED';
    const STATUS_OFFLINE = 'OFFLINE';

    const FLAG_NO_SHOW = 0;
    const FLAG_SHOW = 1;

    const TYPE_EXTERNAL = 'EXTERNAL';
    const TYPE_INTERNAL = 'INTERNAL';

    public function behaviors()
    {
        return [

            [
                'class' => \grazio\image\behaviors\UploadImageBehavior::className(),
                'attributes' => ['file', 'banner']
            ],
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at', 'begin_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],

            [
                'class' => BlameableBehavior::className(),

            ],

            [
                'class' => SoftDeleteBehavior::className(),
                'softDeleteAttributeValues' => [
                    'is_deleted' => true,
                ],
            ],
        ];
    }

    public function beforeSoftDelete()
    {
        $uid = Yii::$app->user->id;
        $this->deleted_by = $uid;
        $this->deleted_at = time(); // log the deletion date
        return true;
    }

    public function beforeRestore()
    {
        $this->deleted_by = 0;
        $this->deleted_at = 0;
        return true;
    }

    /**
     * @return string
     */
    public static function status()
    {
        return [

            self::STATUS_POSTED => ['name' => '发布', 'htmlClass' => 'label-success'],
//            self::STATUS_OFFLINE => ['name' => '待定', 'htmlClass' => ' label-danger'],
            self::STATUS_DRAFT => ['name' => '草稿', 'htmlClass' => 'label-info']
        ];
    }

    public static function flag()
    {
        return [

            self::FLAG_NO_SHOW => ['name' => '隐藏', 'htmlClass' => 'label-info'],
            self::FLAG_SHOW => ['name' => '显示', 'htmlClass' => 'label-success']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%spotlights_slice}}';
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['new'] = ['banner', 'group_id', 'title', 'flag', 'status', 'description', 'file', 'link', 'type', 'weight'];
        $scenarios['update'] = ['group_id', 'title', 'flag', 'status', 'description', 'file', 'link', 'type', 'weight'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_id'], 'required'],
            [['group_id', 'begin_at', 'end_at', 'deleted_at', 'created_at', 'updated_at', 'created_by', 'updated_by', 'deleted_by', 'is_deleted', 'flag'], 'integer'],
            [['status', 'slice_hash_id', 'description'], 'string'],
            [['end_at', 'weight', 'flag'], 'default', 'value' => 0],
            ['description', 'default', 'value' => ''],
            [['title', 'link'], 'string', 'max' => 200],
            [['file', 'banner'], 'image', 'extensions' => 'png, jpg',
                'minWidth' => 64, 'maxWidth' => 1920,
                'minHeight' => 64, 'maxHeight' => 1080,
                'maxSize' => 800 * 1024,
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
            'id' => 'ID',
            'group_id' => '分组',
            'title' => '标题',
            'description' => '摘要',
            'banner' => 'banner图',
            'file' => '图片',
            'link' => '链接地址',
            'type' => '站内／站外',
            'status' => '状态',
            'weight' => '排序',
            'begin_at' => '开始时间',
            'end_at' => '结束时间',
            'flag' => '是否显示',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
            'created_by' => '上传用户',
            'updated_by' => '修改用户',
            'is_deleted' => '是否删除，0-否；1-是',
            'deleted_by' => '删除人',
            'deleted_at' => '删除时间',
        ];
    }

    public function getGroup()
    {
        return $this->hasOne(SpotlightsGroup::className(), ['group_id' => 'group_id']);
    }

    public function getAdmin()
    {
        return $this->hasOne(Admin::className(), ['id' => 'created_by']);
    }

    public function getUpdateAdmin()
    {
        return $this->hasOne(Admin::className(), ['id' => 'updated_by']);
    }
}
