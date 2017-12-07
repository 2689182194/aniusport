<?php

/**
 * Created by PhpStorm.
 * User: Miinno-10
 * Date: 2017/12/5
 * Time: 16:42
 */
namespace grazio\spotlights\web\controllers;

use grazio\spotlights\models\SpotlightsGroup;
use grazio\spotlights\models\SpotlightsSlice;
use yii\rest\Controller;

class DefaultController extends Controller
{
    /**
     * 活动轮播图
     * @return array|SpotlightsSlice[]|\yii\db\ActiveRecord[]
     */
    public function actionIndex()
    {
        $group = SpotlightsGroup::find()->orderBy(['group_id' => SORT_DESC])->one();
        if ($group) {
            $models = SpotlightsSlice::find()
                ->where(['group_id' => $group->group_id])
                ->andWhere(['status' => SpotlightsSlice::STATUS_POSTED])
                ->andWhere(['flag' => SpotlightsSlice::FLAG_SHOW])
                ->andWhere(['is_deleted' => 0])
                ->andWhere(['<>','banner',''])
                ->orderBy('weight ASC')
                ->all();
        }
        return $models;
    }
}