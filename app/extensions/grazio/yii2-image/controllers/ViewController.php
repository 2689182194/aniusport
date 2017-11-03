<?php

namespace grazio\image\controllers;

use yii\web\Controller;

/**
 * Default controller for the `image` module
 */
class ViewController extends Controller
{
    public function actions()
    {
        return [
            'src' => [
                'class' => \grazio\image\actions\ImageAction::className(),
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
