<?php
/**
 * Created by PhpStorm.
 * User: Miinno-10
 * Date: 2017/9/4
 * Time: 18:31
 */

namespace activity\anniu\web\controllers;

use Yii;
use yii\helpers\Json;
use yii\web\Controller;

class IdentifyController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * 获取openid
     * @param $appid 小程序唯一标识
     * @param $secret 小程序的 app secret
     * @param $code 登录时获取的 code
     * @param $grant_type 填写为 authorization_code
     * @return array|string
     */
    public function actionIndex($appid, $secret, $code, $grant_type)
    {
        //微信获取appid接口地址
        $wxApi = isset(Yii::$app->params['wxApi']) ? Yii::$app->params['wxApi'] : '';
        $getUrl = $wxApi . '?appid=' . $appid . '&secret=' . $secret . '&js_code=' . $code . '&grant_type=' . $grant_type;

        $js_result = $this->ApiCurl($getUrl);//获取到用户唯一标识openid和会话密钥session_key
        $js_result = Json::decode($js_result, true);
        $error_code = isset($js_result['errcode']) ? $js_result['errcode'] : '';
        if ($error_code) {
            $result = [
                'code' => $js_result['errcode'],
                'errMsg' => $js_result['errmsg']
            ];
        } else {
            $result = [
                'code' => 0,
                'openid' => $js_result['openid'],
//                'unionid' => $js_result['unionid'],
            ];
        }
        $result = Json::encode($result);

        return $result;

    }

    /**
     * curl 接口请求
     * @param $getUrl 接口地址
     * @return mixed
     */
    public function ApiCurl($getUrl)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $getUrl);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //禁止服务器端校验SSL
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $js_result = curl_exec($ch);
        if ($js_result == false) {
            echo curl_error($ch);
        } else {
            return $js_result;
        }
    }
}