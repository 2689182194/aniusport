<?php

namespace grazio\news\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii2tech\ar\softdelete\SoftDeleteBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%news_content}}".
 *
 * @property integer $content_id
 * @property integer $news_id
 * @property string $category_name
 * @property string $content
 * @property integer $created_at
 * @property integer $deleted_at
 */
class NewsContent extends \yii\db\ActiveRecord
{
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
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%news_content}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'required'],
            [['news_id', 'created_at', 'deleted_at'], 'integer'],
            [['content'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'content_id' => '内容id',
            'news_id' => '新闻id',
            'content' => '内容',
            'created_at' => '创建时间',
            'deleted_at' => '删除时间',
        ];
    }
}
