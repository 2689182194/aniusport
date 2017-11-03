<?php
$local = require(__DIR__.'/../etc/config.php');

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/../app/config/bootstrap.php');

$config = require(__DIR__ . '/../app/config/web.php');

$config = yii\helpers\ArrayHelper::merge($config, $local);

(new yii\web\Application($config))->run();
