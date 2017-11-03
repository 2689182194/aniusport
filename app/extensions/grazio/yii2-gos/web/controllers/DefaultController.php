<?php

namespace grazio\gos\web\controllers;

use grazio\core\components\WebController;

/**
 * Default controller for the `gos` module
 */
class DefaultController extends WebController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
