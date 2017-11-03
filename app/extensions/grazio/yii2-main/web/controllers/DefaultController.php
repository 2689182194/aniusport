<?php

namespace grazio\main\web\controllers;

use Yii;
use grazio\core\components\WebController;
use yii\web\NotFoundHttpException;


class DefaultController extends WebController
{

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        echo 111;die;
    }
}
