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
                'label' => '注册用户',
                'icon' => 'folder-o',
                'url' => ['/sports/user'],
            ],
            [
                'label' => '签到历史',
                'icon' => 'folder-o',
                'url' => ['/sports/sign'],
            ],
            [
                'label' => '丸记录',
                'icon' => 'folder-o',
                'url' => ['/sports/scores'],
            ],
            [
                'label' => '签到活动',
                'icon' => 'folder-o',
                'items' => [
                    ['label' => '组管理', 'icon' => 'folder-o', 'url' => ['/anniu/group']],
                    ['label' => '用户管理', 'icon' => 'bullhorn', 'url' => ['/anniu/group-user']],
                ]
            ],
        ];
    }
}
