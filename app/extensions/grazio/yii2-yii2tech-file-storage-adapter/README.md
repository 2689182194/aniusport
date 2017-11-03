yii2-yii2tech-file-storage-adapter
==================================
yii2-yii2tech-file-storage-adapter

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist grazio/yii2-yii2tech-file-storage-adapter "*"
```

or add

```
"grazio/yii2-yii2tech-file-storage-adapter": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
'fileStorage' => [
     'class' => 'grazio\yii2tech\filestorage\qiniu\Storage',
     'accessKey' => 'Access_Key',
     'secretKey' => 'Secret_Key',
     'buckets' => [
         'Bucket Name'=>[
             'baseUrl' => 'Url',
         ]
     ]
 ]
```