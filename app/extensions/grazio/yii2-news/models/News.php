<?php

namespace grazio\news\models;

use Yii;
use grazio\system\models\Admin;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii2tech\ar\softdelete\SoftDeleteBehavior;

/**
 * This is the model class for table "{{%news}}".
 *
 * @property integer $news_id
 * @property integer $category_id
 * @property string $title
 * @property string $subtitle
 * @property string $summary
 * @property string $keywords
 * @property string $author
 * @property string $artist
 * @property string $source
 * @property string $label
 * @property string $source_link
 * @property string $status
 * @property string $type
 * @property integer $headline
 * @property integer $publish_id
 * @property integer $publish_time
 * @property integer $read_times
 * @property integer $comment_times
 * @property integer $created_at
 * @property integer $update_at
 * @property integer $update_by
 * @property integer $is_deleted
 * @property integer $deleted_at
 * @property integer $deleted_by
 */
class News extends \yii\db\ActiveRecord
{
    const STATUS_DRAFT = 'DRAFT';

    const STATUS_PUBLISHED = 'PUBLISHED';

    const TYPE_TEXT = 'TEXT';

    const TYPE_GALLERY = 'GALLERY';

    const TYPE_VIDEO = 'VIDEO';

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

            self::STATUS_PUBLISHED => ['name' => '发表', 'htmlClass' => ' label-success'],

        ];
    }

    public static function type()
    {
        return
            [
                self::TYPE_TEXT => ['name' => '文本', 'htmlClass' => 'label-primary'],
                self::TYPE_GALLERY => ['name' => '画廊', 'htmlClass' => 'label-primary'],
                self::TYPE_VIDEO => ['name' => '视频', 'htmlClass' => 'label-primary'],
            ];

    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%news}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['publish_time', 'category_id', 'title', 'subtitle', 'summary'], 'required'],
            [['category_id', 'headline', 'publish_id', 'read_times', 'comment_times', 'created_at', 'created_by', 'updated_at', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by'], 'integer'],
            [['summary', 'artist', 'status', 'type'], 'string'],
            [['title', 'keywords', 'author'], 'string', 'max' => 100],
            [['subtitle', 'source', 'label', 'source_link'], 'string', 'max' => 255],
            [['seoTitle', 'seoKeywords', 'seoDescription', 'seoRobots'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'news_id' => 'id',
            'category_id' => '分类',
            'title' => '标题',
            'subtitle' => '副标题',
            'summary' => '摘要',
            'keywords' => '关键字',
            'author' => '作者',
            'artist' => '艺术家',
            'source' => '来源',
            'label' => '标签',
            'source_link' => '原链接',
            'status' => '状态',
            'type' => '类型',
            'headline' => '是否是头条',
            'publish_id' => '发布者id',
            'publish_time' => '发布时间',
            'read_times' => '被阅读次数',
            'comment_times' => '被评论次数',
            'created_at' => '创建时间',
            'created_by' => '上传用户',
            'updated_at' => '修改时间',
            'updated_by' => '修改用户',
            'is_deleted' => '是否删除',
            'deleted_at' => '删除时间',
            'deleted_by' => '删除人',
        ];
    }

    public function getCategory()
    {
        return $this->hasOne(NewsCategory::className(), ['category_id' => 'category_id']);
    }

    public static function NewsData($category_id)
    {
        return News::find()->where(['category_id' => $category_id])->orderBy('publish_time DESC')->limit(6)->all();
    }

    public function getContent()
    {
        return $this->hasOne(NewsContent::className(), ['news_id' => 'news_id']);
    }

    public function getImage()
    {
        return $this->hasMany(NewsImage::className(), ['news_id' => 'news_id']);
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
