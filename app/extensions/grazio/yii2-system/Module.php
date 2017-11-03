<?php

namespace grazio\system;

/**
 * system module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'grazio\system\controllers';

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
                'label' => 'System Manager',
                'icon' => 'cog',
                'items' => [
                    ['label' => 'Administrator', 'icon' => 'users', 'url' => ['/system/administrator']],
                    ['label' => 'Admin Auth Log', 'icon' => 'sign-in', 'url' => ['/system/admin-auth-log']],
                    ['label' => 'Maintenance', 'icon' => 'wrench', 'url' => ['/system/maintenance']]
                ]
            ]

        ];
    }
}
