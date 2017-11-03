<?php
/**
 * Created by PhpStorm.
 * User: Miinno-10
 * Date: 2017/5/25
 * Time: 11:58
 */
namespace app\themes\basic\grazio\news;

use Yii;
use yii\web\AssetBundle;


class NewsAsset extends AssetBundle
{
    public $css = [

    ];
    public $js = [

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

