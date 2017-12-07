<?php
/**
 * Created by PhpStorm.
 * User: Miinno-10
 * Date: 2017/11/1
 * Time: 16:46
 */

namespace activity\sports\web\controllers;

use Yii;
use activity\sports\models\SportsScores;
use activity\sports\models\User;
use yii\helpers\Json;
use yii\rest\Controller;

class MyController extends Controller
{
    /*    public function beforeAction($action)
        {
            echo Yii::$app->controller->id . Yii::$app->controller->action->id;die;
    //        if (Yii::$app->controller->id . Yii::$app->controller->action->id == 'index') {
    //
    //        }
        }*/

    /**
     * 徽章和积分总数查询
     * 有关用户的积分记录
     * @param string $identification 约定参数
     * @return array
     */
    public function actionScoreRecord($identification = '')
    {
        //$openid = IdentifyController::Identification($identification);
        $openid = User::Identification($identification);
        //$openid = 'oZJcc0WwhZWuLFfeN-ETjLOwvcxI';
        $userData = User::findIdentity($openid);
        if ($userData) {
            $total['badge'] = $userData->badge;
            $total['scores'] = $userData->scores;
        }
        $data = SportsScores::ScoreRecord($openid);

        $result = [
            'total' => isset($total) ? $total : '',
            'data' => $data
        ];

        return $result;

        //return Json::encode($result);
    }
}