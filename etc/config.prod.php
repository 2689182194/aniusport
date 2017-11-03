<?php

return [
    'params' => require(dirname(__DIR__) . '/etc/params.' . YII_ENV . '.php'),
    'components' => [

        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=192.168.100.112;dbname=cn_net_clcn_szzyzl',
            'username' => 'szzy',
            'password' => 'vueKy2huyJs7myra',
            'charset' => 'utf8',
            'tablePrefix' => 'iinn_',
            'enableSchemaCache' => YII_ENV !== 'dev',
            'schemaCacheDuration' => 3600,
            'schemaCache' => 'cache',
        ],

        'mail' => [
            'transport' => [
                'host' => 'smtp.exmail.qq.com',     # smtp 发件地址
                'username' => 'service@miinno.com',  # smtp 发件用户名
                'password' => '',       # smtp 发件人的密码
                'port' => 965,                      # smtp 端口
                'encryption' => 'ssl',                    # smtp 协议
            ],
            'messageConfig' => [
                'charset' => 'UTF-8',
                'from' => [
                    'service@miinno.com' => 'Miinno',
                ],  # smtp 发件用户名(须与mail.transport.username一致)
            ],
        ],


    ],
    'modules' => [
        'debug' => [
            'class' => 'yii\debug\Module',
            'allowedIPs' => ['*']
        ]
    ]
];


