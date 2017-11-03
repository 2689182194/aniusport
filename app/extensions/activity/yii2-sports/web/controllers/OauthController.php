<?php
/**
 * Created by PhpStorm.
 * User: Miinno-10
 * Date: 2017/8/30
 * Time: 12:18
 */

namespace activity\sports\web\controllers;


use activity\sports\models\SportsUser;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;


use activity\anniu\models\User;

class OauthController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex($forword, $data)
    {
        $openId = $data->openid = base64_decode($data['openid']);
        if (empty($openId)) {
            $model = new SportsUser();
            $model->load($data['userInfo'], '');
            $model->save();
        }
        $user = User::findIdentity($openId);
        if (empty($user)) {
            $user = new User();
            $user->openid = $openId;
            $user->ip = Yii::$app->request->userIP;
            $user->save();
        }
        Yii::$app->user->logout();

        Yii::$app->user->login($user, 7200);

        return $this->redirect(urldecode($forword));


    }


}