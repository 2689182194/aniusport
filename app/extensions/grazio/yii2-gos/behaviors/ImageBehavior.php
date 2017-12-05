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


class ImageBehavior extends Behavior
{

    public $deleteFile = true;
    public $recognitionFile = true;
    public $filesAttribute = 'image';
    public $fileItemModelClass = '\grazio\gos\models\ImageItemModel';
    private $fileItemModel;

    private function ensureFileItemModel()
    {
        if (!is_a($this->fileItemModel, $this->fileItemModelClass)) {
            $this->fileItemModel = Instance::ensure($this->fileItemModelClass);
        }

        return $this->fileItemModel;
    }

    public function getImage()
    {
        $owner = $this->owner;
        $fileItemModel = $this->ensureFileItemModel();
        $models = $fileItemModel->find()->where(['id' => $owner->getAttribute($this->filesAttribute)])->one();
        return $models;
    }

}