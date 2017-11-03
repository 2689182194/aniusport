<?php

namespace grazio\news;

/**
 * news module definition class
 */
class Admin extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'grazio\news\admin\controllers';

    public $defaultRoute = 'news';

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
                'label' => 'News',
                'icon' => 'newspaper-o',
                'items' => [
                    ['label' => 'Categories', 'icon' => 'folder-o', 'url' => ['/news/category','is_deleted'=>0]],
                    ['label' => 'News', 'icon' => 'bullhorn', 'url' => ['/news/news','is_deleted'=>0]],
                ]
            ]

        ];
    }
}
