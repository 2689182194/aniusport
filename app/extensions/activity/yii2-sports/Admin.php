<?php

namespace activity\sports;

/**
 * news module definition class
 */
class Admin extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'activity\sports\admin\controllers';

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
                'label' => '用户管理',
                'icon' => 'folder-o',
                'items' => [
                    ['label' => '组管理', 'icon' => 'folder-o', 'url' => ['/anniu/group']],
                    ['label' => '用户管理', 'icon' => 'bullhorn', 'url' => ['/anniu/group-user']],
                ]
            ]
        ];
    }
}
