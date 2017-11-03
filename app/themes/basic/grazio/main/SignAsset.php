<?php
/**
 * Created by PhpStorm.
 * User: Miinno-10
 * Date: 2017/7/24
 * Time: 14:00
 */

namespace app\themes\basic\grazio\main;

use yii\web\AssetBundle;

class SignAsset extends AssetBundle
{
    public $css = [
        'css/team.css',
    ];
    public $js = [
        'js/sign.js',
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