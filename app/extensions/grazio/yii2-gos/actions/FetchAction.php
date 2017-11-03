<?php
/**
 * Created by PhpStorm.
 * User: ezsky
 * Date: 2017/4/21
 * Time: 上午12:33
 */

namespace grazio\gos\actions;

use grazio\gos\models\FileItemModel;
use yii\base\Action;
use Yii;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\helpers\Json;
use yii\web\Response;

class FetchAction extends Action
{
    public function init()
    {
        parent::init();
        $this->controller->enableCsrfValidation = false;
    }

    public function run($ids = null)
    {
        if(empty($ids)){
            return;
        }
        $ids = explode(',', $ids);
        $models = FileItemModel::find()->where(['id' => $ids])->all();
        if ($models !== null) {
            foreach ($models as $model) {
                $file[] = [
                    'id' => $model->id,
                    'name' => $model->file_name,
                   'size' => $model->file_size,
                    'url' => $model->getFileUrl(),
//                        'thumbnailUrl' => $path,
                    'deleteUrl' => Url::to(['delete', 'id' => $model->id]),
                    'deleteType' => 'POST',
                ];
            }
            $result = [
                'files' => $file
            ];
        } else {
            $result = [
                'files' => [

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