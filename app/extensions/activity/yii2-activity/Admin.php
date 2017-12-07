<?php

namespace activity\activity;

/**
 * news module definition class
 */
class Admin extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'activity\activity\admin\controllers';

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
                'label' => '活动管理',
                'icon' => 'folder-o',
                'items' => [
                    ['label' => '活动分类', 'icon' => 'folder-o', 'url' => ['/activity/group']],
                    ['label' => '活动', 'icon' => 'bullhorn', 'url' => ['/activity/activity']],
                ]
            ]
        ];
    }
}
