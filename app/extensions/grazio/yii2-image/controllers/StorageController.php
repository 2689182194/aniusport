<?php

namespace grazio\image\controllers;

use yii\web\Controller;

/**
 * Default controller for the `image` module
 */
class StorageController extends Controller
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
    public function actionFile($src = '')
    {
        if (!empty($src) && file_exists(\Yii::getAlias('@uploadsPath/' . $src))) {
            return $this->redirect(\Yii::getAlias('@uploadsUrl' . $src));
        }
        return;
    }
}
