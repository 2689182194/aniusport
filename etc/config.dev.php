<?php

return [
    'params' => require(dirname(__DIR__) . '/etc/params.' . YII_ENV . '.php'),
    'components' => [


        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=tingwenzhen',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8mb4',
            'tablePrefix' => 'tbl_',
            'enableSchemaCache' => YII_ENV !== 'dev',
            'schemaCacheDuration' => 3600,
            'schemaCache' => 'cache',
        ],


        'mail' => [
            'transport' => [
                'host' => 'smtp.163.com',     # smtp 发件地址
                'username' => 'liujia2813@163.com',  # smtp 发件用户名
                'password' => 'liujia281350',       # smtp 发件人的密码
                'port' => 25,                      # smtp 端口
                'encryption' => 'tls',                    # smtp 协议
            ],
            'messageConfig' => [
                'charset' => 'UTF-8',
                'from' => [
                    'liujia2813@163.com' => 'Miinno',
                ],  # smtp 发件用户名(须与mail.transport.username一致)
            ],
        ],
        'wechat' => [
            'class' => 'callmez\wechat\sdk\MpWechat',
            'appId' => 'wxeda58a5a23c2f2d7',
            'appSecret' => '76c970ce9a09a8306d02bec978e7128d',
//            'appId' => 'wxb0e3247774dc4f1c',
//            'appSecret' => '8b9f9c69b4dcd18b4313f4360dfbe42c',
            'token' => 'anniu',
            'encodingAesKey' => 'Q85QGeYlYuMpkgLwa7VwBmOwwoPLXnUL2dDlXCfY3vy'
        ],

    ],
    'extensions' => [
        'grazio/yii2-ueditor' => [
            'name' => 'grazio/yii2-ueditor',
            'version' => '1.0.0.0',
            'alias' => [
                '@grazio/ueditor' => '@app/extensions/grazio/yii2-ueditor',
            ]
        ],
        'grazio/yii2-system' => [
            'name' => 'grazio/yii2-system',
            'version' => '1.0.0.0',
            'alias' => [
                '@grazio/system' => '@app/extensions/grazio/yii2-system',
            ]
        ],
        'grazio/yii2-image' => [
            'name' => 'grazio/yii2-image',
            'version' => '1.0.0.0',
            'alias' => [
                '@grazio/image' => '@app/extensions/grazio/yii2-image',
            ]
        ],
        'grazio/yii2-seo' => [
            'name' => 'grazio/yii2-seo',
            'version' => '1.0.0.0',
            'alias' => [
                '@grazio/seo' => '@app/extensions/grazio/yii2-seo',
            ]
        ],
        'activity/yii2-anniu' => [
            'name' => 'activity/yii2-anniu',
            'version' => '1.0.0.0',
            'alias' => [
                '@activity/anniu' => '@app/extensions/activity/yii2-anniu',
            ]
        ],
        'activity/yii2-decrypt' => [
            'name' => 'activity/yii2-decrypt',
            'version' => '1.0.0.0',
            'alias' => [
                '@activity/decrypt' => '@app/extensions/activity/yii2-decrypt',
            ]
        ],
        'activity/yii2-sports' => [
            'name' => 'activity/yii2-sports',
            'version' => '1.0.0.0',
            'alias' => [
                '@activity/sports' => '@app/extensions/activity/yii2-sports',
            ]
        ],
    ],
    'aliases' => [
        '@grazio/core' => '@app/extensions/grazio/yii2-core',
        '@grazio/main' => '@app/extensions/grazio/yii2-main',
        '@grazio/admin' => '@app/extensions/grazio/yii2-admin',
        '@grazio/system' => '@app/extensions/grazio/yii2-system',
        '@grazio/news' => '@app/extensions/grazio/yii2-news',
        '@grazio/adminlte' => '@app/extensions/grazio/yii2-adminlte',
        '@grazio/yii2tech/filestorage' => '@app/extensions/grazio/yii2-yii2tech-file-storage-adapter',
    ],
    'modules' => [

        'debug' => [
            'class' => 'yii\debug\Module',
            'allowedIPs' => ['*']
        ]
    ],

];