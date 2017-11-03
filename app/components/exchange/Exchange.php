<?php
/**
 * Created by PhpStorm.
 * User: ezsky
 * Date: 16/5/3
 * Time: 上午12:04
 */
namespace app\components\exchange;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;


/**
 *
 */
class Exchange extends BaseApiRequest
{
    /**
     * 接口基本地址
     */
    const API_BASE_URL = 'http://exchange.sindcorp.net/wechat';
    /**
     * 数据缓存前缀
     * @var string
     */
    public $cachePrefix = 'cache_http_exchange';
    /**
     * 公众号平台标示
     */

    public $instance = 1;

    /**
     * 公众号appId
     * @var string
     */
    public $appId;
    /**
     * 公众号appSecret
     * @var string
     */
    public $appSecret;
    /**
     * 公众号接口验证token,可由您来设定. 并填写在微信公众平台->开发者中心
     * @var string
     */
    public $token;
    /**
     * 公众号消息加密键值
     * @var string
     */
    public $encodingAesKey;

    /**
     * @inheritdoc
     * @throws InvalidConfigException
     */
    public function init()
    {

    }

    /**
     * 获取缓存键值
     * @param $name
     * @return string
     */
    protected function getCacheKey($name)
    {
        return $this->cachePrefix . '_' . $this->instance . '_' . $name;
    }

    /**
     * 增加接口基本链接
     * @inheritdoc
     */
    protected function httpBuildQuery($url, array $options)
    {
        if (stripos($url, 'http://') === false && stripos($url, 'https://') === false) {
            $url = self::API_BASE_URL . $url;
        }
        return parent::httpBuildQuery($url, $options);
    }

    /**
     * @inheritdoc
     * @param
     */
    public function parseHttpRequest(callable $callable, $url, $postOptions = null, $force = true)
    {

        $result = call_user_func_array($callable, [$url, $postOptions]);
        return $result;
    }

    /**
     * 创建消息加密类
     * @return object
     */
    protected function createMessageCrypt()
    {
        return Yii::createObject(MessageCrypt::className(), [$this->token, $this->encodingAesKey, $this->appId]);
    }




    /* =================== 基础接口 =================== */


    /**
     * 显性授权接口地址
     */
    const OAUTH_PREFIX = '/auth';

    /**
     * 显性授权
     * @param string $redirect 项目名
     * @param string $redirect 回调地址
     * @return bool|string
     * @throws \yii\web\HttpException
     */
    public function getOauthUrl($redirect)
    {

        return $this->httpBuildQuery(self::OAUTH_PREFIX, [
            'instance' => $this->instance,
            'redirect' => $redirect,
        ]);

    }

    /**
     * .获取粉丝信息接口
     */
    const GET_USER_INFO_PREFIX = '/api/user-info';

    /**
     * 粉丝信息
     * @param string $openId OPENID
     * @return bool|string
     * @throws \yii\web\HttpException
     */
    public function getUserInfo($openId)
    {
        $result = $this->httpGet(self::GET_USER_INFO_PREFIX, [
            'instance' => $this->instance,
            'openId' => $openId,
        ]);

        return $result;
    }

    /**
     * 生成二维码
     * @param string $type QR_SCENE | QR_LIMIT_SCENE
     * @param string $app 使用二维码的应用
     * @param string $expire_seconds 过期时间
     * @param string $reply json 回复内容
     * @return bool|array ticket
     * @throws \yii\web\HttpException
     */

    const GET_QRCODE_CREATE_PREFIX = '/api/create-qrcode';

    public function generateQrcode($app, $type, $expire_seconds, $reply)
    {

        $result = $this->httpPost(self::GET_QRCODE_CREATE_PREFIX,
            [
                'type' => $type,
                'app' => $app,
                'expire_seconds' => $expire_seconds,
                'reply' => $reply,

            ],
            [
                'instance' => $this->instance,
            ]);
        return $result;
    }

    /**
     * 通过ticket换取二维码
     * @param string $ticket
     * @return bool|array image url
     * @throws \yii\web\HttpException
     */

    const GET_SHOW_QRCODE_PREFIX = '/api/show-qrcode';

    public function showQrcode($ticket)
    {

        $result = $this->httpBuildQuery(self::GET_SHOW_QRCODE_PREFIX,
            [
                'instance' => $this->instance,
                'ticket' => $ticket,
            ]
        );
        return $result;
    }


    /**
     * 获取ticket
     * @return bool|array
     * @throws \yii\web\HttpException
     */

    const GET_JSAPI_TICKET_PREFIX = '/api/jsapi-ticket';

    public function requestJsApiTicket()
    {

        $result = $this->httpGet(self::GET_JSAPI_TICKET_PREFIX,
            [
                'instance' => $this->instance,
            ]
        );
        return !isset($result['code']) ? $result : false;

    }


    /**
     * 生成js 必需的config
     * 只需在视图文件输出JS代码:
     *  wx.config(<?= json_encode($wehcat->jsApiConfig()) ?>); // 默认全权限
     *  wx.config(<?= json_encode($wehcat->jsApiConfig([ // 只允许使用分享到朋友圈功能
     *      'jsApiList' => [
     *          'onMenuShareTimeline'
     *      ]
     *  ])) ?>);
     * @param array $config
     * @return array
     * @throws HttpException
     */
    public function jsApiConfig(array $config = [])
    {
        $_config = $this->getJsApiTicket();
        $data = [
            'jsapi_ticket' => $_config['ticket'],
            'noncestr' => Yii::$app->security->generateRandomString(16),
            'timestamp' => $_SERVER['REQUEST_TIME'],
            'url' => explode('#', Yii::$app->request->getAbsoluteUrl())[0]
        ];
        return array_merge([
            'debug' => YII_DEBUG,
            'appId' => $_config['appId'],
            'timestamp' => $data['timestamp'],
            'nonceStr' => $data['noncestr'],
            'signature' => sha1(urldecode(http_build_query($data))),
            'jsApiList' => [
                'checkJsApi',
                'onMenuShareTimeline',
                'onMenuShareAppMessage',
                'onMenuShareQQ',
                'onMenuShareWeibo',
                'hideMenuItems',
                'showMenuItems',
                'hideAllNonBaseMenuItem',
                'showAllNonBaseMenuItem',
                'translateVoice',
                'startRecord',
                'stopRecord',
                'onRecordEnd',
                'playVoice',
                'pauseVoice',
                'stopVoice',
                'uploadVoice',
                'downloadVoice',
                'chooseImage',
                'previewImage',
                'uploadImage',
                'downloadImage',
                'getNetworkType',
                'openLocation',
                'getLocation',
                'hideOptionMenu',
                'showOptionMenu',
                'closeWindow',
                'scanQRCode',
                'chooseWXPay',
                'openProductSpecificView',
                'addCard',
                'chooseCard',
                'openCard'
            ]
        ], $config);
    }

}