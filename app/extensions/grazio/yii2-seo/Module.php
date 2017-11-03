<?php

namespace grazio\seo;

/**
 * seo module definition class
 */
class Module extends \yii\base\Module
{
    public $defaultRoute = 'seo-meta';
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'grazio\seo\admin\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

    public static function menu()
    {
        return [
            [
                'label' => 'SEO',
                'icon' => 'anchor',
                'items' => [
                    ['label' => 'META', 'icon' => 'bookmark-o', 'url' => ['/seo/seo-meta']],
//                    ['label' => 'Slice', 'icon' => 'image', 'url' => ['/seo/seo-url']],
                ]
            ]

        ];
    }
}
