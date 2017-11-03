<?php
namespace app\components\weixin;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\InvalidParamException;

/**
 * 微信公众号操作SDK
 * 注:部分功能因API的整体和功能性, 拆分为单独的类调用请查看compoents/mp文件夹
 * @package calmez\wechat\sdk
 */
class SendRedPack extends BaseWechat
{
    /**
     * 微信接口基本地址
     */
    const BASE_URL = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';


    public $appId;
    public $mchId;
    public $signKey;
    public $sendName;
    public $clientIp;
    protected $data;
    protected $sendData;

    /**
     * @inheritdoc
     * @throws InvalidConfigException
     */
    public function init()
    {


        $this->appId = Yii::$app->wechat->appId;
    }


    /**
     * 增加微信基本链接
     * @inheritdoc
     */
    protected function httpBuildQuery($url, array $options)
    {
        if (stripos($url, 'http://') === false && stripos($url, 'https://') === false) {
            $url = self::WECHAT_BASE_URL . $url;
        }
        return parent::httpBuildQuery($url, $options);
    }

    /**
     * @inheritdoc
     * @param bool $force 是否强制获取access_token, 该设置会在access_token使用错误时, 是否再获取一次access_token并再重新提交请求
     */
    public function parseHttpRequest(callable $callable, $url, $postOptions = null, $force = true)
    {
        $result = call_user_func_array($callable, [$url, $postOptions]);

        return $result;
    }

    //发红包

    public function buildRedPack($openid, $total_amount, $act_name, $wishing, $remark, $billNo = false)
    {
        $billNo = ($billNo != false) ? $billNo : $this->mchId . date('YmdHis') . rand(1000, 9999);
        $this->data = [

            'nonce_str' => $this->great_rand(),
            'mch_billno' => $billNo,
            'mch_id' => $this->mchId,
            'wxappid' => $this->appId,
            'send_name' => $this->sendName,
            're_openid' => $openid,
            'total_amount' => $total_amount,
            'total_num' => 1,
            'client_ip' => $this->clientIp,
            'act_name' => $act_name,//活劢名称
            'wishing' => $wishing,//红包祝福
            'remark' => $remark,//备注信息
        ];
        $this->data['sign'] = $this->get_sign();
        $this->sendData = $this->xml($this->data);
        return $billNo;
    }

    public function send()
    {

//        return $this->http(self::BASE_URL, [
//            CURLOPT_POST => true,
//            CURLOPT_POSTFIELDS => $this->sendData,
//            CURLOPT_SSLCERT => Yii::getAlias('@app/config/cert/apiclient_cert.pem'),
//            CURLOPT_SSLKEY => Yii::getAlias('@app/config/cert/apiclient_key.pem'),
//            CURLOPT_CAINFO => Yii::getAlias('@app/config/cert/rootca.pem')
//        ]);

        $ch = curl_init();
        //超时时间
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //这里设置代理，如果有的话
        curl_setopt($ch, CURLOPT_URL, self::BASE_URL);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        //cert 与 key 分别属于两个.pem文件
        curl_setopt($ch, CURLOPT_SSLCERT, Yii::getAlias('@etc/cert/apiclient_cert.pem'));
        curl_setopt($ch, CURLOPT_SSLKEY, Yii::getAlias('@etc/cert/apiclient_key.pem'));
        curl_setopt($ch, CURLOPT_CAINFO, Yii::getAlias('@etc/cert/rootca.pem'));

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->sendData);
        $data = curl_exec($ch);

        if ($data) {
            curl_close($ch);
            return $data;
        } else {
            $error = curl_errno($ch);
            echo "call faild, errorCode:$error\n";
            curl_close($ch);
            return false;
        }

    }

    function formatQueryParaMap($paraMap, $urlencode)
    {
        $buff = "";
        ksort($paraMap);
        foreach ($paraMap as $k => $v) {
            if ($v && "sign" != $k) {
                if ($urlencode) {
                    $v = urlencode($v);
                }
                $buff .= "$k=$v&";
            }
        }
        if (strlen($buff) > 0) {
            $reqPar = substr($buff, 0, strlen($buff) - 1);
        }
        return $reqPar;
    }

    protected function get_sign()
    {
        if (empty($this->signKey)) {
            die('密钥不能为空');
        }
//        if (!$this->check_sign_parameters()) {
//            die('生成签名参数缺失');
//        }
        ksort($this->data);
        $unSignParaString = $this->formatQueryParaMap($this->data, false);
        return $this->encode($unSignParaString, $this->signKey);
    }

    protected function encode($content, $key)
    {
        if (!$content) {
            die('签名内容不能为空');
        }
        $signStr = "$content&key=$key";
        return strtoupper(md5($signStr));
    }

    /**
     * 检查生成签名参数
     */
    protected function check_sign_parameters()
    {
        if ($this->parameters["nonce_str"] &&
            $this->parameters["mch_billno"] &&
            $this->parameters["mch_id"] &&
            $this->parameters["wxappid"] &&
            $this->parameters["send_name"] &&
            $this->parameters["re_openid"] &&
            $this->parameters["total_amount"] &&
//            $this->parameters["max_value"] &&
//            $this->parameters["min_value"] &&
            $this->parameters["total_num"] &&
            $this->parameters["wishing"] &&
//            $this->parameters["client_ip"] &&
            $this->parameters["act_name"] &&
            $this->parameters["remark"]
        ) {
            return true;
        }
        return false;
    }

    /**
     * 生成随机数
     */
    public function great_rand()
    {
        $t1 = '';
        $str = '1234567890abcdefghijklmnopqrstuvwxyz';
        for ($i = 0; $i < 30; $i++) {
            $j = rand(0, 35);
            $t1 .= $str[$j];
        }
        return $t1;
    }
}