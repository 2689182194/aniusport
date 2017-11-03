<?php

namespace grazio\sandbox\models;

use Yii;

/**
 * This is the model class for table "test".
 *
 * @property integer $id
 * @property string $title
 * @property integer $attachment
 */
class SandboxModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sandbox}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title', 'attachment'], 'string', 'max' => 255],
            [['seoTitle','seoKeywords', 'seoDescription','seoRobots'], 'safe'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'attachment' => 'Attachment',
        ];
    }

    public function behaviors()
    {
        return [
            'fileUploadCallback' => [
                'class' => '\grazio\gos\behaviors\FileUploadCallbackBehavior'
            ],
            'seo' => [
                'class' => '\grazio\seo\behaviors\SeoMetaBehavior',
                'seoRoute'=>'/sandbox/test/view'
            ]
        ];
    }
}
