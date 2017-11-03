<?php

namespace grazio\system\controllers;

use yii2tech\admin\CrudController;
use yii\helpers\ArrayHelper;
use yii2tech\admin\behaviors\ContextModelControlBehavior;

/**
 * AdminAuthLogController implements the CRUD actions for [[grazio\system\models\AdminAuthLog]] model.
 * @see grazio\system\models\AdminAuthLog
 */
class AdminAuthLogController extends CrudController
{
    /**
     * @inheritdoc
     */
    public $modelClass = 'grazio\system\models\AdminAuthLog';
    /**
     * @inheritdoc
     */
    public $searchModelClass = 'grazio\system\models\AdminAuthLogSearch';
    /**
     * Contexts configuration
     * @see ContextModelControlBehavior::contexts
     */
    public $contexts = [
        // Specify actual contexts :
        'admin' => [
            'class' => 'grazio\system\models\Admin',
            'attribute' => 'admin_id',
            'controller' => 'admin',
            'required' => false,
        ],
    ];


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                'model' => [
                    'class' => ContextModelControlBehavior::className(),
                    'contexts' => $this->contexts
                ]
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        unset($actions['update']);
        return $actions;
    }
}
