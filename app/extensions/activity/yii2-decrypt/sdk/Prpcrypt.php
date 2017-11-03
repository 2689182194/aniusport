<?php
/**
 * Created by PhpStorm.
 * User: Miinno-10
 * Date: 2017/7/19
 * Time: 14:57
 */
namespace activity\decrypt\sdk;


/**
 * Prpcrypt class
 *
 *
 */
class Prpcrypt
{
    public $key;

    public function __construct($k)
    {
        $this->key = $k;
    }

    /**
     * 对密文进行解密
     * @param string $aesCipher 需要解密的密文
     * @param string $aesIV 解密的初始向量
     * @return string 解密得到的明文
     */
    public function decrypt($aesCipher, $aesIV)
    {
        $error_code = new ErrorCode();
        try {

            $module = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');

            mcrypt_generic_init($module, $this->key, $aesIV);

            //解密
            $decrypted = mdecrypt_generic($module, $aesCipher);
            mcrypt_generic_deinit($module);
            mcrypt_module_close($module);
        } catch (Exception $e) {

            return array($error_code::$IllegalBuffer, null);
        }


        try {
            //去除补位字符
            $pkc_encoder = new PKESEncode();

            $result = $pkc_encoder->decode($decrypted);

        } catch (Exception $e) {

            return array($error_code::$IllegalBuffer, null);
        }
        return array(0, $result);
    }
}