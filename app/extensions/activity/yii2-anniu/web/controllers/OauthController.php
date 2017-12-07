<?php
/**
 * Created by PhpStorm.
 * User: Miinno-10
 * Date: 2017/8/30
 * Time: 12:18
 */

namespace activity\anniu\web\controllers;


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
    public function actionIndex($open_id = '',$forword)
    {
        $openId = $open_id;
        if (YII_ENV_DEV) {
            $openId = 'o_P7SwLw3vgSa9dhkgHMDiaDskqk';
        }
        if (empty($openId)) {
            return $this->redirect(Yii::$app->exchange->getOauthUrl(urlencode(Url::current(['forword'=>$forword], true))));
        } else {

            $userInfo = Yii::$app->exchange->getUserInfo($openId);

            if (isset($userInfo['open_id'])) {
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
            return $this->redirect(['oauth/index']);

        }
    }


}