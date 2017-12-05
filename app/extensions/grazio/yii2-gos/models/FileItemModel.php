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
class FileItemModel extends GosItemModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {

        $rules = [
            ['file', 'file', 'mimeTypes' => [
                'application/pdf',
                'application/vnd.ms-powerpoint',
                'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/zip',
                'image/jpeg', 'image/pjpeg', 'image/png', 'image/gif'
            ],
                'skipOnEmpty' => !$this->isNewRecord
            ],
        ];

        return ArrayHelper::merge(parent::rules(), $rules);
    }


    public function behaviors()
    {
        return [
            'file' => [
                'class' => FileBehavior::className(),
                'fileStorageBucket' => 'files',
                'subDirTemplate' => '{^^pk}/{^pk}',
                'fileExtensionAttribute' => 'file_extension',
                'fileVersionAttribute' => 'file_version',
            ],
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $attributes = [
            'hash' => md5($this->getFileFullName())
        ];
        $this->updateAttributes($attributes);
        return true;
    }
}
