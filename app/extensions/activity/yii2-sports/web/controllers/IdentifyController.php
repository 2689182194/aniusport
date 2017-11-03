<?php
/**
 * Created by PhpStorm.
 * User: Miinno-10
 * Date: 2017/9/4
 * Time: 18:31
 */

namespace activity\sports\web\controllers;

use activity\sports\models\SportsActivity;
use activity\sports\models\SportsSign;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use activity\decrypt\sdk\WXBizDataCrypt;
use yii\web\NotFoundHttpException;

class IdentifyController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * 获取openid和运动数据同时判断用户是否是当日首次进入
     * @param $appid 小程序唯一标识
     * @param $secret 小程序的 app secret
     * @param $code 登录时获取的 code
     * @param $grant_type 填写为 authorization_code
     * @param $encryptedData string 加密的用户数据
     * @param $iv string 与用户数据一同返回的初始向量
     * @return array|string
     */
    public function actionIndex($appid, $secret, $code, $grant_type, $encryptedData, $iv)
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
            //通过会话密钥session_key 获取解密的运动数据
            $pc = new WXBizDataCrypt($appid, $js_result['session_key']);
            $errCode = $pc->decryptData($encryptedData, $iv, $data);
            //identification用于与小程序做登录校验
            $identification = [
                'title' => $js_result['session_key'] . $js_result['openid'],  //数据
                'expire_time' => time() + 3600 * 24, //这里设置24小时过期
                'unquie_user' => $js_result['openid'],
            ];
            $session = Yii::$app->session;
            $session['identification'] = $identification;

//            $cache = Yii::$app->cache;
//            $cache->set('identification', $identification);
//
//            $session = $cache->get('identification');

            //判断今日是否签到
            $todayBegin = strtotime(date('Y-m-d') . " 00:00:00");
            $todayEnd = strtotime(date('Y-m-d') . " 23:59:59");
            $firstSign = SportsSign::IsSign($todayBegin, $todayEnd, $js_result['openid']);

            if ($errCode == 0) {
                $result = [
                    'code' => 0,
                    'openid' => $js_result['openid'],
                    'identification' => $session['identification']['title'],
//                    'identification' => $session['title'],
                    'stepInfoList' => $data,
                    'firstSign' => $firstSign ? 1 : 0,
                ];
            } else {
                $result = [
                    'code' => $errCode,
                ];
            }
        }
        $result = Json::encode($result);

        return $result;

    }

    /**
     * curl 接口请求
     * @param $getUrl 接口地址
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function ApiCurl($getUrl)
    {
        if (empty($getUrl)) {
            throw new NotFoundHttpException('请求地址不能为空');
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $getUrl);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //禁止服务器端校验SSL
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $js_result = curl_exec($ch);
        //通过判断输出错误
        if ($js_result == false) {
            echo curl_error($ch);
        } else {
            return $js_result;
        }
    }

    /**
     * 约定参数
     * @param $identification
     * @return string
     */
    public static function Identification($identification)
    {
//        echo $identification;die;
//        $cache = Yii::$app->cache;
//
//        $session = $cache->get('identification');
//        \X::result($session);
//
//        if ($session['title'] == $identification) {
//            $openId = $session['unquie_user'];
//        }
        $openId = substr($identification, 24);
        //\X::result($openId);die;
        return $openId;
    }
}