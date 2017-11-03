<?php
/**
 * Created by PhpStorm.
 * User: ezsky
 * Date: 2017/4/23
 * Time: 下午12:54
 */

namespace grazio\yii2tech\filestorage\qiniu;

use yii\base\InvalidConfigException;
use yii2tech\filestorage\BaseStorage;
use Qiniu\Auth;


/**
 * Storage introduces the file storage based on
 * Qiniu Storage Service .
 *
 * In order to use this storage you need to install [qiniu/php-sdk](https://github.com/qiniu/php-sdk) version: 7.x.x:
 *
 * ```
 * composer require qiniu/php-sdk
 * ```
 *
 * Configuration example:
 *
 * ```php
 * 'fileStorage' => [
 *     'class' => 'grazio\yii2tech\filestorage\qiniu\Storage',
 *     'accessKey' => 'Access_Key',
 *     'secretKey' => 'Secret_Key',
 *     'buckets' => [
 *         'Bucket Name'=>[
 *             'baseUrl' => 'Url',
 *         ]
 *     ]
 * ]
 * ```
 *
 * @see Bucket
 * @see https://github.com/qiniu/php-sdk
 * @see https://developer.qiniu.com/kodo/sdk/1241/php
 *
 * @property Auth $qiNiu instance of the qiniu client auth.
 * @method Bucket getBucket($bucketName)
 *
 * @author Susheng Yang <ezsky@grazio.org>
 * @since 1.0
 */
class Storage extends BaseStorage
{
    /**
     * @inheritdoc
     */
    public $bucketClassName = 'grazio\yii2tech\filestorage\qiniu\Bucket';

    /**
     * @var string 七牛访问秘钥Key
     */
    public $accessKey;
    /**
     * @var string 七牛访问秘钥Secret
     */
    public $secretKey;
    /**
     * @var string 七牛存储Bucket
     */
    public $_buckets;
    /**
     * @var bool 是否私有空间, 默认公开空间
     */
    public $isPrivate = false;

    private $_qiNiu;


    public function setQiNiu($qiNiu)
    {
        if (!is_object($qiNiu)) {
            throw new InvalidConfigException('"' . get_class($this) . '::Auth" should be an object!');
        }
        $this->_qiNiu = $qiNiu;
    }

    /**
     * @return Auth qiniu client auth instance.
     */
    public function getQiNiu()
    {
        if (!is_object($this->_qiNiu)) {
            $this->_qiNiu = $this->createQiNiu();
        }
        return $this->_qiNiu;
    }

    /**
     * Initializes the instance of the  qiniu.
     * @return Auth qiniu client auth  instance.
     */
    protected function createQiNiu()
    {
        return new Auth($this->accessKey, $this->secretKey);
    }
}