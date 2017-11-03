<?php

namespace grazio\news\models;

use Yii;
use grazio\system\models\Admin;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii2tech\ar\softdelete\SoftDeleteBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tbl_news_category".
 *
 * @property integer $category_id
 * @property integer $parent_id
 * @property string $category_name
 * @property string $category_desc
 * @property string $status
 * @property integer $sort
 * @property integer $created_at
 * @property integer $update_at
 * @property integer $update_by
 * @property integer $is_deleted
 * @property integer $deleted_at
 * @property integer $deleted_by
 */
class NewsCategory extends \yii\db\ActiveRecord
{
    const STATUS_DRAFT = 'DRAFT';

    const STATUS_PUBLISHED = 'PUBLISHED';

    /**
     * @inheritdoc
     */
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

            [
                'class' => BlameableBehavior::className(),
            ],

            [

                'class' => SoftDeleteBehavior::className(),
                'softDeleteAttributeValues' => [
                    'is_deleted' => true,
                ],
            ],
            [
                'class' => '\grazio\seo\behaviors\SeoMetaBehavior',
                'seoRoute' => '/news/default/index'
            ]
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
        $this->deleted_at = 0; // log the deletion date
        return true;
    }
    /**
     * @return string
     */
    public static function status()
    {
        return [

            self::STATUS_DRAFT => ['name' => '草稿', 'htmlClass' => 'label-info'],

            self::STATUS_PUBLISHED => ['name' => '发表', 'htmlClass' => ' label-success'],

        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%news_category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_name', 'status'], 'required'],
            [['category_name'], 'unique', 'filter' => ['is_deleted' => 0]],
            ['sort', 'default', 'value' => 99],
            ['parent_id', 'default', 'value' => 0],
            [['parent_id', 'sort', 'created_at', 'updated_at', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'created_by'], 'integer'],
            [['category_desc', 'status'], 'string'],
            [['category_name'], 'string', 'max' => 50],
            [['seoTitle', 'seoKeywords', 'seoDescription', 'seoRobots'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'category_id' => 'id',
            'parent_id' => '父类id',
            'category_name' => '名称',
            'category_desc' => '描述',
            'status' => '状态',
            'sort' => '排序',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
            'created_by'=>'上传用户',
            'updated_by' => '修改用户',
            'is_deleted' => '是否删除',
            'deleted_at' => '删除时间',
            'deleted_by' => '删除人',
        ];
    }

    public static function Parents()
    {
        $result = self::find()
            ->where(['is_deleted' => 0])
            ->all();
        $newArray = ArrayHelper::map($result, 'category_id', 'category_name');
        $array = ['无'];
        $category = ArrayHelper::merge($array,$newArray);

        return $category;
    }

    public static function Announce()
    {
        return NewsCategory::find()->select(['category_id'])->where(['=','category_name','通知公告'])->one();
    }
    public function getNews()
    {
        return $this->hasMany(News::className(), ['category_id' => 'category_id']);
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
