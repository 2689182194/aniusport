<?php

namespace app\themes\basic;

use Yii;
use yii\web\AssetBundle;


class ThemeAsset extends AssetBundle
{
    public $css = [
        'css/site.css',
        'css/unite-gallery.css',
        'css/style.css'
    ];

    public $js = [
        'js/bootstrap.min.js',
        'js/js.js',
        'js/masonry.pkgd.js',
        [
            '//cdn.bootcss.com/jquery/1.12.4/jquery.min.js',
            'condition' => 'lt IE 9',
            'position' => \yii\web\View::POS_HEAD
        ],
        [
            '//cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js',
            'condition' => 'lt IE 9',
            'position' => \yii\web\View::POS_HEAD
        ],
        [
            '//cdn.bootcss.com/respond.js/1.4.2/respond.min.js',
            'condition' => 'lt IE 9',
            'position' => \yii\web\View::POS_HEAD
        ],
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    public function init()
    {
        $this->sourcePath = Yii::$app->view->theme->getBasePath() . '/assets';
        parent::init();
    }

}

