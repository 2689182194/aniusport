<?php

namespace grazio\gos\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii2tech\ar\file\FileBehavior;

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
                'class' => FileBehavior::className(),
                'fileStorageBucket' => 'images',
                'subDirTemplate' => '{^^pk}/{^pk}/{pk}',
                'fileExtensionAttribute' => 'file_extension',
                'fileVersionAttribute' => 'file_version',
            ],
        ];
    }
}
