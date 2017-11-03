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
use yii\web\Controller;

class MyController extends Controller
{
    /*    public function beforeAction($action)
        {
            echo Yii::$app->controller->id . Yii::$app->controller->action->id;die;
    //        if (Yii::$app->controller->id . Yii::$app->controller->action->id == 'index') {
    //
    //        }
        }*/

    public function actionIndex()
    {
        $openid = 'oZJcc0WwhZWuLFfeN-ETjLOwvcxI';

        $userData = User::findIdentity($openid);
        $data['badge'] = $userData->badge;
        $data['scores'] = $userData->scores;

        return Json::encode($data);
    }

    /**
     * 徽章和积分总数查询
     * 有关用户的积分记录
     * @return string
     */
    public function actionScoreRecord($identification = '')
    {
        $cache = Yii::$app->cache;

        $session = $cache->get('identification');
        \X::result($session);die;
//        $openid = IdentifyController::Identification($identification);
        $openid = 'oZJcc0WwhZWuLFfeN-ETjLOwvcxI';
        $userData = User::findIdentity($openid);

        $total['badge'] = $userData->badge;
        $total['scores'] = $userData->scores;

        $data = SportsScores::ScoreRecord($openid);

        $result = [
            'total' => $total,
            'data' => $data
        ];

        return Json::encode($result);
    }
}