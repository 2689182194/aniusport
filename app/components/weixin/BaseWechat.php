<?php
namespace app\components\weixin;

use DOMDocument;
use DOMElement;
use DOMText;
use Yii;
use yii\base\Component;

/**
 * 微信SDK操作基类
 *
 * @package callmez\wechat\sdk
 */
abstract class BaseWechat extends Component
{



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
                    $child->appendChild(new DOMText((string) $value));
                }
            }
        } else {
            $element->appendChild(new DOMText((string) $data));
        }
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
        return $this->parseHttpRequest(function($url) {
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
        return $this->parseHttpRequest(function($url, $postOptions) {
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
        return $this->parseHttpRequest(function($url, $postOptions) {
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
            ] + (stripos($url, "https://") !== false ? [
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1 // 微信官方屏蔽了ssl2和ssl3, 启用更高级的ssl
            ] : []) + $options;

        $curl = curl_init();
        curl_setopt_array($curl, $options);
        $content = curl_exec($curl);
        $status = curl_getinfo($curl);
        curl_close($curl);
        if (isset($status['http_code']) && $status['http_code'] == 200) {
            return json_decode($content, true) ?: false; // 正常加载应该是只返回json字符串
        }
        Yii::error([
            'result' => $content,
            'status' => $status
        ],  __METHOD__);
        return false;
    }

}
