<?php

namespace grazio\spotlights;

/**
 * news module definition class
 */
class Admin extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'grazio\spotlights\admin\controllers';

    public $defaultRoute = 'spotlights';

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
                'label' => 'Spotlights',
                'icon' => 'camera-retro',
                'items' => [
                    ['label' => 'Group', 'icon' => 'folder-o', 'url' => ['/spotlights/spotlights-group', 'is_deleted' => 0]],
                    ['label' => 'Slice', 'icon' => 'image', 'url' => ['/spotlights/spotlights-slice', 'is_deleted' => 0]],
                ]
            ]

        ];
    }
}
