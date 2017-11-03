<?php
/**
 * Created by PhpStorm.
 * User: Miinno-10
 * Date: 2017/7/19
 * Time: 15:37
 */
namespace activity\decrypt\sdk;


class WXBizDataCrypt
{
    private $appid;
    private $sessionKey;

    /**
     * 构造函数
     * @param $sessionKey string 用户在小程序登录后获取的会话密钥
     * @param $appid string 小程序的appid
     */
    public function __construct($appid, $sessionKey)
    {
        $this->sessionKey = $sessionKey;
        $this->appid = $appid;
    }


    /**
     * 检验数据的真实性，并且获取解密后的明文.
     * @param $encryptedData string 加密的用户数据
     * @param $iv string 与用户数据一同返回的初始向量
     * @param $data string 解密后的原文
     *
     * @return int 成功0，失败返回对应的错误码
     */
    public function decryptData($encryptedData, $iv, &$data)
    {
        $error_code = new ErrorCode();
        if (strlen($this->sessionKey) != 24) {
            return $error_code::$IllegalAesKey;
        }

        $aesKey = base64_decode($this->sessionKey);

        if (strlen($iv) != 24) {
            return $error_code::$IllegalIv;
        }

        $aesIV = base64_decode($iv);

        $aesCipher = base64_decode($encryptedData);

        $pc = new Prpcrypt($aesKey);

        $result = $pc->decrypt($aesCipher, $aesIV);

        if ($result[0] != 0) {
            return $result[0];
        }

        $dataObj = json_decode($result[1]);

        if ($dataObj == NULL) {
            return $error_code::$IllegalBuffer;
        }

        if ($dataObj->watermark->appid != $this->appid) {
            return $error_code::$IllegalBuffer;
        }
        $data = $result[1];
        return $error_code::$OK;
    }
}