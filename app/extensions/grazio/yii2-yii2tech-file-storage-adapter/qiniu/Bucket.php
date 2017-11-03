<?php
/**
 * Created by PhpStorm.
 * User: ezsky
 * Date: 2017/4/23
 * Time: 下午1:06
 */

namespace grazio\yii2tech\filestorage\qiniu;

use yii2tech\filestorage\BucketSubDirTemplate;
use yii\base\InvalidConfigException;
use yii\log\Logger;
use Qiniu\Storage\BucketManager;
use Qiniu\Storage\UploadManager;
use Qiniu\Storage\ResumeUploader;
use Yii;

class Bucket extends BucketSubDirTemplate
{
    private $auth;
    /**
     * @var string 基本访问域名
     */
    private $_baseUrl;

    /**
     * @inheritdoc
     */
    public function setBaseUrl($baseUrl)
    {
        if (is_string($baseUrl)) {
            $baseUrl = Yii::getAlias($baseUrl);
        }
        $this->_baseUrl = $baseUrl;
    }

    /**
     * @inheritdoc
     */
    public function getBaseUrl()
    {
        return $this->_baseUrl;
    }

    public function init()
    {
        parent::init();
        $this->auth = $this->getStorage()->getQiNiu();
    }

    private $_bucketManager;

    /**
     * @return \Qiniu\Storage\BucketManager
     */
    public function getBucketManager()
    {
        if ($this->_bucketManager === null) {
            $this->setBucketManager(new BucketManager($this->auth));
        }
        return $this->_bucketManager;
    }

    /**
     * @param \Qiniu\Storage\BucketManager $bucketManager
     */
    public function setBucketManager(BucketManager $bucketManager)
    {
        $this->_bucketManager = $bucketManager;
    }

    private $_uploadManager;

    /**
     * @return \Qiniu\Storage\UploadManager
     */
    public function getUploadManager()
    {
        if ($this->_uploadManager === null) {
            $this->setUploadManager(new UploadManager());
        }
        return $this->_uploadManager;
    }

    /**
     * @param \Qiniu\Storage\UploadManager $uploadManager
     */
    public function setUploadManager(UploadManager $uploadManager)
    {
        $this->_uploadManager = $uploadManager;
    }

    /**
     * @param null $key
     * @param int $expires
     * @param null $policy
     * @param bool|true $strictPolicy
     * @return string
     */
    public function getUploadToken($key = null, $expires = 3600, $policy = null, $strictPolicy = true)
    {
        return $this->auth->uploadToken($this->name, $key, $expires, $policy, $strictPolicy);
    }

    /**
     * Returns the full internal file name, including
     * path resolved from {@link QsFileStorageBucketSubDirTemplate::fileSubDirTemplate}.
     * @param string $fileName - name of the file.
     * @return string full name of the file.
     */
    public function getFullFileName($fileName)
    {
        return $this->getFileNameWithSubDir($fileName);
    }

    /**
     * @inheritdoc
     */
    public function create()
    {
//        $this->log('bucket has been created with URL name "' . $this->getUrlName() . '"');
        return true;
    }

    /**
     * @inheritdoc
     */
    public function destroy()
    {
        $this->clearInternalCache();
//        $this->log('bucket has been destroyed with URL name "' . $this->getUrlName() . '"');
        return true;
    }

    /**
     * @inheritdoc
     */
    public function exists()
    {
        $buckets = $this->getBucketManager()->buckets();
        $this->log($buckets[0]);
        $this->log($this->name);
        return in_array($this->name, $buckets[0]) ? true : false;
    }

    /**
     * @inheritdoc
     */
    public function saveFileContent($fileName, $content)
    {
        if (!$this->exists()) {
            throw new InvalidConfigException('不存在的bucket');
        }
        $fileName = $this->getFullFileName($fileName);
        $key = $fileName;

        // 调用 UploadManager 的 putFile 方法进行文件的上传。
        list($ret, $err) = $this->getUploadManager()->put($this->getUploadToken(), $key, $content);
        if ($err !== null) {
            $result = false;
            $this->log("unable to save file '{$fileName}':" . print_r($err, 1) . "!", Logger::LEVEL_ERROR);
        } else {
            $result = true;
            $this->log("file '{$fileName}' has been saved");
        }
        return $result;
    }

    /**
     * @inheritdoc
     */
    public function getFileContent($fileName)
    {
        if (!$this->exists()) {
            throw new InvalidConfigException('不存在的bucket');
        }
        $url = $this->auth->privateDownloadUrl($this->getFileUrl($fileName));
        $stream = fopen($url, 'r');
        if (!$stream) {
            return false;
        }
        $fileContent = stream_get_contents($stream);
        fclose($stream);
        unset($stream);
        return $fileContent;
    }

    /**
     * @inheritdoc
     */
    public function deleteFile($fileName)
    {
        if (!$this->exists()) {
            throw new InvalidConfigException('不存在的bucket');
        }
        //删除$bucket 中的文件 $key
        $err = $this->getBucketManager()->delete($this->name, $fileName);
        if ($err !== null) {
            $this->log("unable to delete file '{$fileName}':" . $err . "!", Logger::LEVEL_ERROR);
            $result = false;
        } else {
            $this->log("file '{$fileName}' has been deleted");
            $result = true;
        }
        return $result;
    }

    /**
     * @inheritdoc
     */
    public function fileExists($fileName)
    {
        if (!$this->exists()) {
            throw new InvalidConfigException('不存在的bucket');
        }
        list($ret, $err) = $this->getBucketManager()->stat($this->name, $fileName);
        if ($err !== null) {
            return false;
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public function copyFileIn($srcFileName, $fileName)
    {
        $fileContent = file_get_contents($srcFileName);
        return $this->saveFileContent($fileName, $fileContent);
    }

    /**
     * @inheritdoc
     */
    public function copyFileOut($fileName, $destFileName)
    {
        $fileContent = $this->getFileContent($fileName);
        $bytesWritten = file_put_contents($destFileName, $fileContent);
        return ($bytesWritten > 0);
    }

    /**
     * @inheritdoc
     */
    public function copyFileInternal($srcFile, $destFile)
    {
        if (!$this->exists()) {
            throw new InvalidConfigException('不存在的bucket');
        }

        $bucket = $this->name;
        $err = $this->getBucketManager()->move($bucket, $srcFile, $bucket, $destFile);

        if ($err !== null) {
            $this->log("Unable to copy file from '{$srcFile}' to {$destFile}:" . $err . "!", Logger::LEVEL_ERROR);
            $result = false;
        } else {
            $this->log("file '{$srcFile}' has been copied to {$destFile} ");
            $result = true;
        }
        return $result;
    }

    /**
     * @inheritdoc
     */
    public function moveFileIn($srcFileName, $fileName)
    {
        return ($this->copyFileIn($srcFileName, $fileName) && unlink($srcFileName));
    }

    /**
     * @inheritdoc
     */
    public function moveFileOut($fileName, $destFileName)
    {
        $result = $this->copyFileOut($fileName, $destFileName);
        if ($result) {
            $result = $result && $this->deleteFile($fileName);
        }
        return $result;
    }

    /**
     * @inheritdoc
     */
    public function moveFileInternal($srcFile, $destFile)
    {
        $bucket = $this->name;
        $err = $this->getBucketManager()->move($bucket, $srcFile, $bucket, $destFile);

        if ($err !== null) {
            $this->log("Unable to move file from '{$srcFile}' to {$destFile}:" . $err . "!", Logger::LEVEL_ERROR);
            $result = false;
        } else {
            $this->log("file '{$srcFile}' has been moved to {$destFile} ");
            $result = true;
        }
        return $result;
    }

    /**
     * @inheritdoc
     */
    public function getFileUrl($fileName)
    {
        $baseUrl = $this->getBaseUrl();
        // todo confirm function
        if (is_array($baseUrl)) {
            $url = $baseUrl;
            $url['filename'] = $fileName;
            return Url::to($url);
        }

        return $this->composeFileUrl($baseUrl, $fileName);
    }

    /**
     * @inheritdoc
     */
    protected function composeFileUrl($baseUrl, $fileName)
    {
        if ($baseUrl === null) {
            if (!$this->exists()) {
                throw new InvalidConfigException('不存在的bucket');
            }
            $fileName = $this->getFullFileName($fileName);

        }
        return $baseUrl . '/' . $fileName;;
    }

    /**
     * @inheritdoc
     */
    public function openFile($fileName, $mode, $context = null)
    {
        //todo Processing of the large files

    }
}