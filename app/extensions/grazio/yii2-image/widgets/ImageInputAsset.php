<?php


namespace grazio\image\widgets;


class ImageInputAsset extends \yii\web\AssetBundle
{
    public function init()
    {
        $this->sourcePath = __DIR__ . '/assets';

        $this->css = [
            'css/style.css',
        ];

        $this->js = [
            'js/preview.image.js',
        ];
        $this->depends = [
            'yii\web\JqueryAsset',
        ];
        parent::init();
    }
}
