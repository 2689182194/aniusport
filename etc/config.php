<?php
// Uncomment to enable debug mode. Recommended for development.
defined('YII_DEBUG') or define('YII_DEBUG', true);
// Uncomment to enable dev environment. Recommended for development
defined('YII_ENV') or define('YII_ENV', 'dev');
// zh_CN.UTF-8 => 中文,  en_US.UTF-8 => English
setlocale(LC_ALL, 'zh_CN.UTF-8');
putenv('LC_ALL=zh_CN.UTF-8');


return require(dirname(__DIR__) . '/etc/config.' . YII_ENV . '.php');
