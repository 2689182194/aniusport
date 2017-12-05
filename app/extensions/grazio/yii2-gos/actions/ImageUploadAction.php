<?php
/**
 * Created by PhpStorm.
 * User: ezsky
 * Date: 2017/4/21
 * Time: 上午12:33
 */

namespace grazio\gos\actions;

use grazio\gos\models\FileItemModel;
use grazio\gos\models\ImageItemModel;
use yii\base\Action;
use Yii;
use yii\base\Exception;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\helpers\Json;
use yii\web\Response;

class ImageUploadAction extends Action
{
    public function init()
    {
        parent::init();
        $this->controller->enableCsrfValidation = false;
    }

    public function run($id = null, $source_owner = '', $source_form = '', $source_attribute = '', $source_id = 0)
    {
        $model = empty($id) ? new ImageItemModel() : $this->findModel($id);

        $model->file = UploadedFile::getInstanceByName('file');
        $model->name = $model->file->getBaseName();
        $model->file_name = $model->file->getBaseName() . '.' . $model->file->getExtension();
        $model->file_size = (string)$model->file->size;
        $model->source_owner = $source_owner;
        $model->source_form = $source_form;
        $model->source_attribute = $source_attribute;
        $model->source_id = $source_id;
        if ($model->validate() && $model->save()) {
            $result = [
                'files' => [
                    [
                        'id' => $model->id,
                        'name' => $model->file_name,
                        'size' => $model->file_size,
                        'url' => $model->getFileUrl(),
//                        'thumbnailUrl' => $path,
                        'deleteUrl' => Url::to(['delete', 'id' => $model->id]),
                        'deleteType' => 'POST',
                    ],
                ]
            ];
        } else {
            Yii::error($model->errors);
            $result = [
                'files' => [
                    [
                        'name' => $model->file->name,
                        'size' => $model->file->size,
                        'error' => $model->errors['file'][0]
                    ],
                ]
            ];
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        return $result;
    }

    protected function findModel($id)
    {
        if (($model = FileItemModel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}