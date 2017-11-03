<?php
/**
 * Created by PhpStorm.
 * User: ezsky
 * Date: 16/5/29
 * Time: 上午12:22
 *
 *  public function behaviors()
 * {
 *      return [
 *          'file' => [
 *              'class' => UploadFileBehavior::className(),
 *              'attributeName' => 'picture',
 *              'savePath' => '@webroot/uploads',
 *              'generateNewName' => true,
 *              'protectOldValue' => true,
 *          ],
 *      ];
 * }
 */


namespace grazio\image\behaviors;

use Yii;
use grazio\image\models\ImageModel;
use yii\base\Behavior;
use yii\base\ErrorException;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

class UploadImageBehavior extends Behavior
{
    /**
     * @var string|callable path or alias to the directory in which to save files
     * or anonymous function returns directory path
     */
    public $savePath = '@uploadsPath';

    /** @var string model file field name */
    public $attributes = '';

    /**
     * @var bool|callable generate a new unique name for the file
     * set true (@see self::generateFileName()) or anonymous function takes the old file name and returns a new name
     */
    public $generateNewName = true;
    /** @var bool erase protection the old value of the model attribute if the form returns empty string */
    public $protectOldValue = true;

    public $imageSourceType = '';
    public $imageSize = [];
    public $maxUploadSize = '';
    public $imageModel;
    public $value;
    private $events = [
        ActiveRecord::EVENT_BEFORE_INSERT => 'beforeInsert',
        ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeUpdate',
        ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete',
        ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate',
    ];

    public function events()
    {
        return $this->events;
    }

    public function init()
    {

        if ($this->savePath instanceof \Closure) {
            $this->savePath = call_user_func($this->savePath);
        }
        $this->savePath = Yii::getAlias($this->savePath);

        $this->attributes = array_fill_keys(array_keys($this->events), $this->attributes);


    }

    protected function getValue($event)
    {
        if ($this->value instanceof Closure || is_array($this->value) && is_callable($this->value)) {
            return call_user_func($this->value, $event);
        }

        return $this->value;
    }

    protected function getImageModel()
    {
        $image_id = $this->value;
        $this->imageModel = ($image_id !== '') ? ImageModel::findOne($image_id) : new ImageModel();
    }

    public function beforeValidate($event)
    {
        /** @var ActiveRecord $model */

        if (!empty($this->attributes[$event->name])) {
            $attributes = (array)$this->attributes[$event->name];
            foreach ($attributes as $attribute) {
                if (is_string($attribute)) {
                    if ($file = UploadedFile::getInstance($this->owner, $attribute)) {
                        $this->owner->setAttribute($attribute, $file);
                    }
                }
            }
        }

    }

    public function beforeInsert($event)
    {
        if (!empty($this->attributes[$event->name])) {
            $attributes = (array)$this->attributes[$event->name];
            foreach ($attributes as $attribute) {
                if (is_string($attribute)) {
                    $this->loadFile($attribute);
                }
            }
        }
    }

    public function beforeUpdate($event)
    {
        /** @var ActiveRecord $model */
        $model = $this->owner;


        if (!empty($this->attributes[$event->name])) {
            $attributes = (array)$this->attributes[$event->name];
            foreach ($attributes as $attribute) {
                if (is_string($attribute)) {
                    if ($model->getAttribute($attribute) !== '') {
                        $this->loadFile($attribute);
                    } else {
                        $model->setAttributes([$attribute => $model->getOldAttribute($attribute)]);
                    }

                }
            }
        }
    }

    public function beforeDelete($event)
    {
        /** @var ActiveRecord $model */
        $model = $this->owner;


        if (!empty($this->attributes[$event->name])) {
            $attributes = (array)$this->attributes[$event->name];
            foreach ($attributes as $attribute) {
                if (is_string($attribute)) {
                    if ($model->getAttribute($attribute) !== '') {
                        $this->deleteFile($attribute);

                    } else {
                        $model->setAttributes([$attribute => $model->getOldAttribute($attribute)]);
                    }

                }
            }
        }

    }

    protected function loadFile($attribute)
    {
        // delete the old version if it necessary
//        $this->deleteFile();
        /** @var ActiveRecord $model */
        /** @var UploadedFile $file */

        Yii::info($attribute, 'upload');
        $model = $this->owner;
        if ($file = UploadedFile::getInstance($model, $attribute)) {
            $model->setAttribute($attribute, $file);
        }

        $file = $model->getAttribute($attribute);
        if (!($file instanceof UploadedFile)) {
            return;
        }
        $imageId = $model->getOldAttribute($attribute);
        $this->imageModel = (!empty($imageId)) ? ImageModel::findOne($imageId) : new ImageModel();

        $fileName = $file->name;
        if (!is_dir($this->savePath)) {
            mkdir($this->savePath, 0755, true);
        }
        if ($this->generateNewName !== false) {
            $fileName = $this->generateNewName instanceof \Closure ?
                call_user_func($this->generateNewName, $fileName) :
                $this->generateFileName($file);
            $file->name = $fileName;
        }
        $fileSaveLocalPath = $this->savePath . DIRECTORY_SEPARATOR . $fileName;
        if ($file->saveAs($fileSaveLocalPath) !== false) {
            $this->imageModel->local_path = $fileName;
            $this->imageModel->image_source_type = $model->formName() . ':' . $attribute;
            //$this->imageModel->image_source_id = $model->id;
            if ($this->imageModel->save() !== false) {
//                $uploadYun = Yii::$app->stmmp->upload(file_get_contents($fileSaveLocalPath), $fileName);
//                $this->imageModel->url = $uploadYun;
                $this->imageModel->save();
                $model->setAttributes([$attribute => $this->imageModel->image_id]);
            }
        } else {
            throw new ErrorException('图片上传失败');
        }


    }

    protected function deleteFile($attribute)
    {
        $model = $this->owner;
        $imageId = $model->getOldAttribute($attribute);
        $this->imageModel = (!empty($imageId)) ? ImageModel::findOne($imageId) : false;

        /** @var ActiveRecord $model */
        if ($this->imageModel == false || (!$oldFileName = $this->imageModel->local_path)) {
            return;
        }
        $filePath = $this->savePath . DIRECTORY_SEPARATOR . $oldFileName;
        if (is_file($filePath)) {
            unlink($filePath);
        }
    }

    protected function generateFileName(UploadedFile $file)
    {
        return Yii::$app->security->generateRandomString() . '.' . $file->getExtension();
    }
}