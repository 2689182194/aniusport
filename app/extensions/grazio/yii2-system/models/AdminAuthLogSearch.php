<?php

namespace grazio\system\models;

use Yii;

/**
 * AdminAuthLogSearch represents the model behind the search form about `app\models\db\AdminAuthLog`.
 */
class AdminAuthLogSearch extends AuthLogSearch
{
    public $admin_id;

    /**
     * @inheritdoc
     */
    protected $userReferenceAttribute = 'admin_id';
    /**
     * @inheritdoc
     */
    protected $userClass = 'grazio\admin\models\Admin';


    /**
     * @inheritdoc
     */
    protected function createQuery()
    {
        return AdminAuthLog::find()->with(['admin']);
    }
}
