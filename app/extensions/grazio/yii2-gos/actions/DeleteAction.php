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
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\helpers\Json;
use yii\web\Response;

class DeleteAction extends Action
{
    public function init()
    {
        parent::init();
        $this->controller->enableCsrfValidation = false;
    }

    public function run($id)
    {
        $model = $this->findModel($id);
        $name = $model->file_name;

        if ($model->delete()) {
            $result = [
                'files' => [
                    [
                        $name => true,
                    ],
                ],
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