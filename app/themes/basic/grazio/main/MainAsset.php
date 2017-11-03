<?php

namespace app\themes\basic\grazio\main;

use Yii;
use yii\web\AssetBundle;


class MainAsset extends AssetBundle
{
    public $css = [
        'css/team.css',
    ];
    public $js = [
        'js/team.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];

    public function init()
    {
        $this->sourcePath = dirname(__FILE__) . '/assets';

        parent::init();
    }

}

