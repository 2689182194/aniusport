<?php
/**
 * Created by PhpStorm.
 * User: Miinno-10
 * Date: 2017/9/4
 * Time: 11:40
 */

namespace activity\anniu\web\controllers;

use yii\web\Controller;
use activity\anniu\models\GroupUser;
use activity\anniu\models\Group;
use yii\helpers\Json;

class ListController extends Controller
{
    /**
     * 问诊阶段用户查询
     * @return string
     */
    public function actionIndex()
    {
        $group = Group::find()->asArray()->all();
        foreach ($group as $k => $v) {
            $group[$k]['user_list'] = GroupUser::find()->where(['group_id' => $v['group_id']])->with('user')->asArray()->all();
        }

        return Json::encode($group);
    }

}