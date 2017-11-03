<?php

$config = [
    'id' => 'grazio',
    'name' => '听问诊',
    'basePath' => dirname(__DIR__),
    'runtimePath' => dirname(dirname(__DIR__)) . '/runtime',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'timeZone' => 'Asia/Shanghai',
    'language' => 'zh-CN',
    'bootstrap' => [
        'log',
        [
            'class' => 'app\components\Aliases',
            'aliases' => require(dirname(dirname(__DIR__)) . '/etc/aliases.' . YII_ENV . '.php'),
        ]
    ],
    'defaultRoute' => 'main',
    'extensions' => include(dirname(dirname(__DIR__)) . '/vendor/yiisoft/extensions.php'),
    'components' => [
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => 'localhost',
            'port' => 6379,
            'database' => 0,
        ],
        'assetManager' => [
            'linkAssets' => true,
            'appendTimestamp' => true,
        ],
        'urlManager' => [
            // 路由路径化
            'enablePrettyUrl' => true,
            // 隐藏入口脚本
            'showScriptName' => false,
            // 假后缀
//            'suffix' => '.html',
            //路径规则
            'rules' => [
               // "" => "main/default/index",
            ],
        ],
        'view' => [
            'theme' => [
                'class' => 'app\components\Theme',
                'basePath' => '@app/themes/basic',
                'baseUrl' => '@web',
                'pathMap' => [
                    '@app/views' => '@app/themes/basic',
                    '@app/modules' => '@app/themes/basic/modules',
                    '@app/widgets' => '@app/themes/basic/widgets',
                ],
            ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
                'text/json' => 'yii\web\JsonParser',
            ],
            'cookieValidationKey' => 'iinn',
            'csrfParam' => '__csrf_user',
        ],

//        'session' => [
//            'class' => 'yii\web\DbSession',
//            'sessionTable' => '{{%session}}',
//        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
//        'user' => [
//            'identityClass' => 'activity\anniu\models\User',
//            'enableAutoLogin' => true,
//            'loginUrl' => ['main/default/login'],
//            'identityCookie' => ['name' => '__user_identity', 'httpOnly' => true],
//            'idParam' => '__user'
//        ],
        'user' => [
            'identityClass' => 'activity\sports\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['main/default/login'],
            'identityCookie' => ['name' => '__user_identity', 'httpOnly' => true],
            'idParam' => '__user'
        ],

        'exchange' => [
            'class' => 'app\components\exchange\Exchange',
            'instance' => 1,
        ],
        'errorHandler' => [
            'errorAction' => 'main/default/error',
        ],
        'mail' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info'],
                ],
            ],
        ],
        'i18n' => [
            'translations' => [
                'yii2tech-admin' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@yii2tech/admin/messages',
                ],
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    //'forceTranslation' => true,
                ],
            ],
        ],
//        'fileStorage' => [
//            'class' => 'yii2tech\filestorage\local\Storage',
//            'basePath' => '@webroot/statics',
//            'baseUrl' => '@web/statics',
//            'filePermission' => 0777,
//            'buckets' => [
//                'item' => [
//                    'baseSubPath' => 'item',
//                ],
//            ]
//        ],
        'fileStorage' => [
            'class' => 'grazio\yii2tech\filestorage\qiniu\Storage',
            'accessKey' => 'jcy6V_lDx0uTxFXVJDk3Nc-aa3S6aCHSlj0zBy8o',
            'secretKey' => 'n2lqrsaf3onA4StzoYI0h6IE64j4ykiq07sgMUxQ',
            'buckets' => [
                'grazio' => [
                    'baseUrl' => 'http://ooumsa09x.bkt.clouddn.com',
                ]
            ]
        ]
    ],
    'modules' => [
        'main' => [
            'class' => 'grazio\main\Module',
        ],
        'admin' => [
            'class' => 'grazio\admin\Module',
        ],
        'news' => [
            'class' => 'grazio\news\Module',
        ],
        'gos' => [
            'class' => 'grazio\gos\Module',
        ],
        'anniu' => [
            'class' => 'activity\anniu\Module',
        ],
        'sports' => [
            'class' => 'activity\sports\Module',
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
