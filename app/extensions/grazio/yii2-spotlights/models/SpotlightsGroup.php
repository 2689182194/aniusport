<?php

namespace grazio\spotlights\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii2tech\ar\softdelete\SoftDeleteBehavior;
use clcnst\search\behaviors\SearchIndexBehavior;
use grazio\system\models\Admin;

/**
 * This is the model class for table "{{%spotlights_group}}".
 *
 * @property integer $group_id
 * @property string $name
 * @property string $description
 * @property string $status
 * @property integer $created_at
 * @property integer $deleted_at
 */
class SpotlightsGroup extends ActiveRecord
{
    const STATUS_DRAFT = 'DRAFT';

    const STATUS_POSTED = 'POSTED';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => SearchIndexBehavior::className(),
                'key' => 'group_id',
                'route' => '',
                'title' => 'name',
                'summary' => 'description',
                'indexText' => function ($model) {
                    $text[] = $model->name;
                    $text[] = $model->description;
                    return implode(',', $text);
                },
            ],
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
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

            self::STATUS_DRAFT => ['name' => '草稿', 'htmlClass' => 'label-info'],

            self::STATUS_POSTED => ['name' => '发表', 'htmlClass' => ' label-success'],

        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%spotlights_group}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'string'],
            [['created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_by', 'deleted_at'], 'integer'],
            [['name','group_hash_id'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'group_id' => 'Group ID',
            'name' => '名称',
            'description' => '备注',
            'status' => '状态',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'created_by' => '上传用户',
            'updated_by' => '修改用户',
            'is_deleted' => '是否删除，0-否；1-是',
            'deleted_by' => '删除人',
            'deleted_at' => '删除时间',
        ];
    }

    /**
     * 查找所有的分组焦点图
     * @return mixed
     */
    public static function Group()
    {
        $data = SpotlightsGroup::find()->where(['is_deleted' => 0])
            ->all();
        return ArrayHelper::map($data, 'group_id', 'name');
    }

    public function getAdmin()
    {
        return $this->hasOne(Admin::className(),['id'=>'created_by']);
    }
    public function getUpdateAdmin()
    {
        return $this->hasOne(Admin::className(),['id'=>'updated_by']);
    }
}
