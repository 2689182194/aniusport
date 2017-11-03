<?php

namespace grazio\news\models;

use Yii;
use yii\helpers\FileHelper;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii2tech\ar\softdelete\SoftDeleteBehavior;

/**
 * This is the model class for table "{{%news_image}}".
 *
 * @property integer $image_id
 * @property integer $news_id
 * @property string $image_url
 * @property integer $created_at
 */
class NewsImage extends \yii\db\ActiveRecord
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
        return '{{%news_image}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['news_id', 'created_at'], 'integer'],
            [['image_url'], 'file', 'extensions' => 'png, jpg', 'maxFiles' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'image_id' => 'Image ID',
            'news_id' => 'News ID',
            'image_url' => '图片',
            'imageFile' => '图片上传',
            'created_at' => '上传时间',
        ];
    }

    public function upload()
    {
        /* $filename ->上传之后转化的文件名 */
        /* $savePath -> 定义保存路径 */
        $savePath = date('Y-m', time());
        $uploadsPath = \Yii::getAlias('@uploadsPath/news/' . DIRECTORY_SEPARATOR . $savePath);
        FileHelper::createDirectory($uploadsPath);
        foreach ($this->image_url as $file) {
            $filename = Yii::$app->getSecurity()->generateRandomString() . '.' . $file->extension;
            $file->saveAs($uploadsPath . DIRECTORY_SEPARATOR . $filename);
            $array[]['image_url'] = $savePath . '/' . $filename;
        }
        return $array;

    }

    public function getNews()
    {
        return $this->hasMany(News::className(), ['news_id' => 'news_id']);
    }
}
