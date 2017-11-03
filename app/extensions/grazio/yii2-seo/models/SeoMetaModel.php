<?php

namespace grazio\seo\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%seo_meta}}".
 *
 * @property integer $id
 * @property integer $entity
 * @property string $model
 * @property string $route
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property string $robots
 */
class SeoMetaModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%seo_meta}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['route'], 'required'],
            [['entity'], 'integer'],
            [['seoKeywords', 'seoDescription'], 'string'],
            [['model', 'route'], 'string', 'max' => 255],
            [['seoTitle'], 'string', 'max' => 255],
            [['seoRobots'], 'string', 'max' => 100],
            [['entity', 'model', 'route'], 'unique', 'targetAttribute' => ['entity', 'model', 'route'], 'message' => 'META索引不能重复'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'entity' => '数据ID',
            'model' => '数据模型类',
            'route' => '路由',
            'seoTitle' => '标题',
            'seoKeywords' => '关键字',
            'seoDescription' => '描述',
            'seoRobots' => '蜘蛛授权',
        ];
    }

    /**
     * 允许抓取本页，允许跟踪链接
     */
    const ROBOTS_ACCESS_INDEX_FOLLOW = ['label' => '允许抓取本页，允许跟踪链接', 'value' => 'index,follow'];
    /**
     * 允许抓取本页，但禁止跟踪链接
     */
    const ROBOTS_ACCESS_INDEX_NOFOLLOW = ['label' => '允许抓取本页，但禁止跟踪链接', 'value' => 'index,nofollow'];
    /**
     * 禁止抓取本页，但允许跟踪链接
     */
    const ROBOTS_ACCESS_NOINDEX_FOLLOW = ['label' => '禁止抓取本页，但允许跟踪链接', 'value' => 'noindex,follow'];
    /**
     * 禁止抓取本页，同时禁止跟踪本页中的链接
     */
    const ROBOTS_ACCESS_NOINDEX_NOFOLLOW = ['label' => '禁止抓取本页，同时禁止跟踪本页中的链接', 'value' => 'noindex,nofollow'];

    public function getRobotAccess()
    {
        $list = [
            self::ROBOTS_ACCESS_INDEX_FOLLOW,
            self::ROBOTS_ACCESS_INDEX_NOFOLLOW,
            self::ROBOTS_ACCESS_NOINDEX_FOLLOW,
            self::ROBOTS_ACCESS_NOINDEX_NOFOLLOW
        ];

        return ArrayHelper::map($list, 'value', 'label');
    }

    public $seoTitle = '';
    public $seoKeywords = '';
    public $seoDescription = '';
    public $seoRobots = '';

    public function beforeSave($insert)
    {
        parent::beforeSave($insert);
        $this->title = $this->seoTitle;
        $this->keywords = $this->seoKeywords;
        $this->description = $this->seoDescription;
        $this->robots = $this->seoRobots;
        return true;
    }
}
