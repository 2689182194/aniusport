<?php

namespace grazio\image\actions;


use grazio\image\models\ImageModel;
use Yii;
use yii\base\Action;
use yii\base\InvalidConfigException;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;


/**
 * Action for sortable Yii2 GridView widget.
 *
 * For example:
 *
 * ```php
 * public function actions()
 * {
 *    return [
 *       'image' => [
 *          'class' => ImageInputAction::className(),
 *       ],
 *   ];
 * }
 * ```
 *
 */
class ImageAction extends Action
{

    public function run($hash)
    {
        $model = ImageModel::findOne($hash);
        $imageUrl = Yii::getAlias('@uploadsUrl/' . $model->local_path);
        if (YII_ENV_PROD) {
            $imageUrl = !empty($model->url) ? $model->url : $imageUrl;
        }
        return Yii::$app->controller->redirect($imageUrl);

    }
}
