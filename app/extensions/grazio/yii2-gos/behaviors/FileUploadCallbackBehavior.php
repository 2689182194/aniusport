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


class FileUploadCallbackBehavior extends Behavior
{

    public $deleteFile = true;
    public $recognitionFile = true;
    public $filesAttribute = 'attachment';
    public $fileItemModelClass = '\grazio\gos\models\FileItemModel';
    private $fileItemModel;

    /**
     * 给$fileItemModel赋值,并设置为指定的格式
     * @return object
     */
    private function ensureFileItemModel()
    {
        if (!is_a($this->fileItemModel, $this->fileItemModelClass)) {
            $this->fileItemModel = Instance::ensure($this->fileItemModelClass);
        }

        return $this->fileItemModel;
    }

    /**
     * 修改gos_item中的来源id(source_id)
     */
    private function recognitionFiles()
    {
        $owner = $this->owner;
        $fileItemModel = $this->ensureFileItemModel();
        $fileItemModel::updateAll(['source_id' => $owner->id], ['id' => explode(',', $owner->getAttribute($this->filesAttribute))]);
    }

    /**
     * 修改sandbox表中的attachment属性
     */
    private function syncFiles()
    {
        $owner = $this->owner;
        $fileItemModel = $this->ensureFileItemModel();
        $models = $fileItemModel->find()->where(['id' => explode(',', $owner->getAttribute($this->filesAttribute))])->all();
        if ($models !== null) {
            $attributes = [$this->filesAttribute => implode(',', ArrayHelper::getColumn($models, 'id'))];
            $owner->updateAttributes($attributes);
        }
    }

    /**
     * 删除gos_item表中的数据
     */
    private function deleteFiles()
    {
        $owner = $this->owner;
        $fileItemModel = $this->ensureFileItemModel();
        $fileItemModel::deleteAll(['id' => explode(',', $owner->getAttribute($this->filesAttribute))]);
    }
    // Events:

    /**
     * Declares events and the corresponding event handler methods.
     * @return array events (array keys) and the corresponding event handler methods (array values).
     */
    public function events()
    {
        return [
            BaseActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            BaseActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
            BaseActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
        ];
    }

    /**
     * This event raises after owner saved.
     * It saves uploaded file if it exists.
     * @param \yii\base\Event $event event instance.
     */
    public function afterSave($event)
    {
        $this->syncFiles();
        if ($this->recognitionFile) {
            $this->recognitionFiles();
        }
    }

    /**
     * This event raises after owner deleted.
     * It deletes related file.
     * @param \yii\base\Event $event event instance.
     */
    public function afterDelete($event)
    {
        if ($this->deleteFile) {
            $this->deleteFiles();
        }

    }
}