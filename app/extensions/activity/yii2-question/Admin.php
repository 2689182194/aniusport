<?php

namespace activity\question;

/**
 * news module definition class
 */
class Admin extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'activity\question\admin\controllers';

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
                'label' => '问题管理',
                'icon' => 'folder-o',
                'url'=>['/question/question'],
            ]
        ];
    }
}
