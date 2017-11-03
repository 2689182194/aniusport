<?php

namespace app\components;

use Yii;

class Theme extends \yii\base\Theme
{
    public function getAssetUrl($path)
    {
        $am = Yii::$app->getAssetManager();
        $_url = $am->getPublishedUrl($this->basePath . '/assets/');
        return $_url  .'/'. ltrim($path, '/');
    }
}
