<?php
namespace app\components\exchange;

use DOMDocument;
use DOMElement;
use DOMText;
use Yii;
use yii\base\Event;
use yii\base\Component;
use yii\web\HttpException;
use yii\base\InvalidParamException;

/**
 * 微信SDK操作基类
 *
 * @package callmez\wechat\sdk
 */
abstract class BaseApiRequest extends Component
{

    /**
     * 数据缓存前缀
     * @var string
     */
    public $cachePrefix = 'cache_http_exchange';

    /**
     * @var MessageCrypt
     */
    private $_messageCrypt;

    /**
     * 返回错误码
     * @var array
     */
    public $lastError;

    const EVENT_AFTER_JS_API_TICKET_UPDATE = 'afterJsApiTicketUpdate';
    /**
     * @var array
     */
    private $_jsApiTicket;

    /**
     * 创建消息加密类
     * @return mixed
     */
    abstract protected function createMessageCrypt();

    /**
     * 设置消息加密处理类
     * @return MessageCrypt
     */
    public function getMessageCrypt()
    {
        if ($this->_messageCrypt === null) {
            $this->setMessageCrypt($this->createMessageCrypt());
        }
        return $this->_messageCrypt;
    }

    /**
     * 设置消息加密处理类
     * @param MessageCrypt $messageCrypt
     */
    public function setMessageCrypt(MessageCrypt $messageCrypt)
    {
        $this->_messageCrypt = $messageCrypt;
    }

    /**
     * 加密XML数据
     * @param string $xml 加密的XML
     * @param string $timestamp 加密时间戳
     * @param string $nonce 加密随机串
     * @return string|bool
     */
    public function encryptXml($xml, $timestamp, $nonce)
    {
        $errorCode = $this->getMessageCrypt()->encryptMsg($xml, $timestamp, $nonce, $xml);
        if ($errorCode) {
            $this->lastError = [
                'errcode' => $errorCode,
                'errmsg' => 'XML数据加密失败!'
            ];
            return false;
        }
        return $xml;
    }

    /**
     * 解密XML数据
     * @param string $xml 解密的XML
     * @param string $messageSignature 加密签名
     * @param string $timestamp 加密时间戳
     * @param string $nonce 加密随机串
     * @return string|bool
     */
    public function decryptXml($xml, $messageSignature, $timestamp, $nonce)
    {
        $errorCode = $this->getMessageCrypt()->decryptMsg($messageSignature, $timestamp, $nonce, $xml, $xml);
        if ($errorCode) {
            $this->lastError = [
                'errcode' => $errorCode,
                'errmsg' => 'XML数据解密失败!'
            ];
            return false;
        }
        return $xml;
    }

    /**
     * 创建微信格式的XML
     * @param array $data
     * @param null $charset
     * @return string
     */
    public function xml(array $data, $charset = null)
    {
        $dom = new DOMDocument('1.0', $charset === null ? Yii::$app->charset : $charset);
        $root = new DOMElement('xml');
        $dom->appendChild($root);
        $this->buildXml($root, $data);
        $xml = $dom->saveXML();
        return trim(substr($xml, strpos($xml, '?>') + 2));
    }

    /**
     * @see yii\web\XmlResponseFormatter::buildXml()
     */
    protected function buildXml($element, $data)
    {
        if (is_object($data)) {
            $child = new DOMElement(StringHelper::basename(get_class($data)));
            $element->appendChild($child);
            if ($data instanceof Arrayable) {
                $this->buildXml($child, $data->toArray());
            } else {
                $array = [];
                foreach ($data as $name => $value) {
                    $array[$name] = $value;
                }
                $this->buildXml($child, $array);
            }
        } elseif (is_array($data)) {
            foreach ($data as $name => $value) {
                if (is_int($name) && is_object($value)) {
                    $this->buildXml($element, $value);
                } elseif (is_array($value) || is_object($value)) {
                    $child = new DOMElement(is_int($name) ? $this->itemTag : $name);
                    $element->appendChild($child);
                    $this->buildXml($child, $value);
                } else {
                    $child = new DOMElement(is_int($name) ? $this->itemTag : $name);
                    $element->appendChild($child);
                    $child->appendChild(new DOMText((string)$value));
                }
            }
        } else {
            $element->appendChild(new DOMText((string)$data));
        }
    }

    /**
     * 微信数据缓存基本键值
     * @param $name
     * @return string
     */
    abstract protected function getCacheKey($name);

    /**
     * 缓存微信数据
     * @param $name
     * @param $value
     * @param null $duration
     * @return bool
     */
    protected function setCache($name, $value, $duration = null)
    {
        $duration === null && $duration = $this->cacheTime;
        return Yii::$app->cache->set($this->getCacheKey($name), $value, $duration);
    }

    /**
     * 获取微信缓存数据
     * @param $name
     * @return mixed
     */
    protected function getCache($name)
    {
        return Yii::$app->cache->get($this->getCacheKey($name));
    }

    /**
     * Api url 组装
     * @param $url
     * @param array $options
     * @return string
     */
    protected function httpBuildQuery($url, array $options)
    {

        if (!empty($options)) {
            $url .= (stripos($url, '?') === null ? '&' : '?') . http_build_query($options);
        }

        return $url;
    }

    /**
     * Http Get 请求
     * @param $url
     * @param array $options
     * @return mixed
     */
    public function httpGet($url, array $options = [])
    {

        Yii::info([
            'url' => $url,
            'options' => $options
        ], __METHOD__);

        Yii::info($this->httpBuildQuery($url, $options), __METHOD__);

        return $this->parseHttpRequest(function ($url) {
            return $this->http($url);
        }, $this->httpBuildQuery($url, $options));
    }

    /**
     * Http Post 请求
     * @param $url
     * @param array $postOptions
     * @param array $options
     * @return mixed
     */
    public function httpPost($url, array $postOptions, array $options = [])
    {
        Yii::info([
            'url' => $url,
            'postOptions' => $postOptions,
            'options' => $options
        ], __METHOD__);
        return $this->parseHttpRequest(function ($url, $postOptions) {
            return $this->http($url, [
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $postOptions
            ]);
        }, $this->httpBuildQuery($url, $options), $postOptions);
    }

    /**
     * Http Raw数据 Post 请求
     * @param $url
     * @param $postOptions
     * @param array $options
     * @return mixed
     */
    public function httpRaw($url, $postOptions, array $options = [])
    {
        Yii::info([
            'url' => $url,
            'postOptions' => $postOptions,
            'options' => $options
        ], __METHOD__);
        return $this->parseHttpRequest(function ($url, $postOptions) {
            return $this->http($url, [
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => is_array($postOptions) ? json_encode($postOptions, JSON_UNESCAPED_UNICODE) : $postOptions
            ]);
        }, $this->httpBuildQuery($url, $options), $postOptions);
    }

    /**
     * 解析微信请求响应内容
     * @param callable $callable Http请求主体函数
     * @param string $url Api地址
     * @param array|string|null $postOptions Api地址一般所需要的post参数
     * @return array|bool
     */
    abstract public function parseHttpRequest(callable $callable, $url, $postOptions = null);

    /**
     * Http基础库 使用该库请求微信服务器
     * @param $url
     * @param array $options
     * @return bool|mixed
     */
    protected function http($url, $options = [])
    {

        $options = [
                CURLOPT_URL => $url,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_CONNECTTIMEOUT => 30,
                CURLOPT_RETURNTRANSFER => true,
            ] + $options;

        $curl = curl_init();
        curl_setopt_array($curl, $options);
        $content = curl_exec($curl);
        $status = curl_getinfo($curl);
        curl_close($curl);
        if (isset($status['http_code']) && $status['http_code'] == 200) {
            return json_decode($content, true) ?: $content; // 正常加载应该是只返回json字符串
        }
        Yii::error([
            'result' => $content,
            'status' => $status
        ], __METHOD__);
        return false;
    }

    /**
     * 上传文件请使用该类来解决curl版本兼容问题
     * @param $filePath
     * @return \CURLFile|string
     */
    protected function uploadFile($filePath)
    {
        // php 5.5将抛弃@写法,引用CURLFile类来实现 @see http://segmentfault.com/a/1190000000725185
        return class_exists('\CURLFile') ? new \CURLFile($filePath) : '@' . $filePath;
    }

    /**
     * 获取js api ticket
     * 超时后会自动重新获取JsApiTicket并触发self::EVENT_AFTER_JS_API_TICKET_UPDATE事件
     * @param bool $force 是否强制获取
     * @return mixed
     * @throws HttpException
     */
    public function getJsApiTicket($force = false)
    {
        $time = time(); // 为了更精确控制.取当前时间计算
        if ($this->_jsApiTicket === null || $this->_jsApiTicket['expire'] < $time || $force) {
            $result = $this->_jsApiTicket === null && !$force ? $this->getCache('js_api_ticket', false) : false;
            if ($result === false) {
                if (!($result = $this->requestJsApiTicket())) {
                    throw new HttpException(500, 'Fail to get jsapi_ticket from wechat server.');
                }
                $this->trigger(self::EVENT_AFTER_JS_API_TICKET_UPDATE, new Event(['data' => $result]));
                $this->setCache('js_api_ticket', $result, $result['expire'] - $time);
            }
            $this->setJsApiTicket($result);
        }
        return $this->_jsApiTicket;
    }

    /**
     * 设置JsApiTicket
     * @param array $jsApiTicket
     */
    public function setJsApiTicket(array $jsApiTicket)
    {
        $this->_jsApiTicket = $jsApiTicket;
    }
}
