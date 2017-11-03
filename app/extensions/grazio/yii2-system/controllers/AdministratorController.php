<?php

namespace grazio\system\controllers;

use yii\helpers\ArrayHelper;
use yii2tech\admin\CrudController;

/**
 * AdminController implements the CRUD actions for [[app\models\db\Admin]] model.
 * @see app\models\db\Admin
 */
class AdministratorController extends CrudController
{
    /**
     * @inheritdoc
     */
    public $modelClass = 'grazio\system\models\Admin';
    /**
     * @inheritdoc
     */
    public $searchModelClass = 'grazio\system\models\AdminSearch';


    /**
     * @inheritdoc
     */
    public function actions()
    {
        return ArrayHelper::merge(
            parent::actions(),
            [
                'delete' => [
                    'class' => 'yii2tech\admin\actions\SafeDelete',
                ],
                'restore' => [
                    'class' => 'yii2tech\admin\actions\Restore',
                ],
                'suspend' => [
                    'class' => 'yii2tech\admin\actions\Callback',
                    'callback' => 'suspend'
                ],
                'activate' => [
                    'class' => 'yii2tech\admin\actions\Callback',
                    'callback' => 'activate'
                ],
            ]
        );
    }
}
