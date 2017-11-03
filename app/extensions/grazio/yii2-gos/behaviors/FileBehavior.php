<?php

/**
 * Created by PhpStorm.
 * User: ezsky
 * Date: 2017/4/26
 * Time: 上午2:07
 */

namespace grazio\gos\behaviors;

use Yii;
use yii\base\Behavior;
use yii\base\UnknownPropertyException;
use yii\db\BaseActiveRecord;
use yii\di\Instance;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;


class FileBehavior extends Behavior
{

    public $deleteFile = true;
    public $recognitionFile = true;
    public $filesAttribute = 'attachment';
    public $fileItemModelClass = '\grazio\gos\models\FileItemModel';
    private $fileItemModel;

    private function ensureFileItemModel()
    {
        if (!is_a($this->fileItemModel, $this->fileItemModelClass)) {
            $this->fileItemModel = Instance::ensure($this->fileItemModelClass);
        }

        return $this->fileItemModel;
    }

    public function getUploadFiles()
    {
        $owner = $this->owner;
        $fileItemModel = $this->ensureFileItemModel();
        $models = $fileItemModel->find()->where(['id' => explode(',', $owner->getAttribute($this->filesAttribute))])->all();
        return $models;
    }

}