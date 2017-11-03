<?php
/**
 * Created by PhpStorm.
 * User: Miinno-10
 * Date: 2017/8/4
 * Time: 15:57
 */

namespace grazio\news\web\controllers;

use grazio\news\models\Point;
use Yii;
use grazio\core\components\WebController;
use yii\helpers\Json;

class PointController extends WebController
{
    /**
     * 新闻动态点赞
     * @param $news_id
     * @return string
     */
    public function actionIndex($news_id = 1)
    {
        if (!is_numeric($news_id) || empty($news_id)) {
            $result = [
                'code' => 1,
                'errorDesc' => '请选择点赞动态',
            ];

            return Json::encode($result);
        }
        $ip = Yii::$app->request->userIP;
        $point = Point::find()->where(['ip' => $ip])->andWhere(['news_id' => $news_id])->One();
        if ($point) {
            $result = [
                'code' => 1,
            ];
            $re = $point->delete();
            if ($re) {
                $result = [
                    'code' => 2,
                    'errorDesc' => '取消成功',
                ];
            }

        } else {
            $model = new Point();
            $model->news_id = $news_id;
            $model->ip = $ip;
            $model->point_num = 1;
            $model->save();
            $sum = Point::find()->where(['news_id' => $news_id])->count();
            $result = [
                'code' => 0,
                'errorDesc' => $sum
            ];
        }

        return Json::encode($result);
    }
}