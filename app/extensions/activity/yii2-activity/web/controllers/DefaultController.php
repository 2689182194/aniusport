<?php
/**
 * Created by PhpStorm.
 * User: Miinno-10
 * Date: 2017/12/6
 * Time: 14:10
 */

namespace activity\activity\web\controllers;

use activity\activity\models\ActivityGroup;
use activity\activity\models\SportsActivity;
use yii\rest\Controller;

class DefaultController extends Controller
{
    /**
     * 活动列表展示
     * @return ActivityGroup[]|array|\yii\db\ActiveRecord[]
     */
    public function actionIndex()
    {
        $activity = ActivityGroup::find()->select(['id','group_name'])->asArray()->all();
        foreach ($activity as $k => $v) {
            $activity[$k]['activity_list'] = SportsActivity::find()->where(['group_id' => $v['id']])->all();
        }

        return $activity;
    }
}