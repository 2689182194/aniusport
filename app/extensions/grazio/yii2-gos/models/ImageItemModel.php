<?php

namespace grazio\gos\web\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii2tech\ar\file\ImageFileBehavior;

/**
 * This is the model class for table "media_item".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $fileExtension
 * @property integer $fileVersion
 */
class ImageItemModel extends GosItemModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {

        $rules = [
            ['file', 'file', 'mimeTypes' => ['image/jpeg', 'image/pjpeg', 'image/png', 'image/gif'], 'skipOnEmpty' => !$this->isNewRecord],
        ];

        return ArrayHelper::merge(parent::rules(), $rules);
    }


    public function behaviors()
    {
        return [
            'file' => [
                'class' => ImageFileBehavior::className(),
                'fileStorageBucket' => 'images',
                'fileExtensionAttribute' => 'file_extension',
                'fileVersionAttribute' => 'file_version',
                'fileTransformations' => [
                    'origin', // no resize
                    'main' => [800, 600], // width = 800px, height = 600px
                    'thumbnail' => [100, 80], // width = 100px, height = 80px
                ],
            ],
        ];
    }
}
