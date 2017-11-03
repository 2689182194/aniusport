<?php

return [
    'params' => require(dirname(__DIR__) . '/etc/params.' . YII_ENV . '.php'),
    'components' => [

        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=volunteer',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8mb4',
            'tablePrefix' => 'clcn_',
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
    'aliases' => [
        '@grazio/core' => '@app/extensions/grazio/yii2-core',
        '@grazio/main' => '@app/extensions/grazio/yii2-main',
        '@grazio/admin' => '@app/extensions/grazio/yii2-admin',
        '@grazio/system' => '@app/extensions/grazio/yii2-system',
        '@grazio/news' => '@app/extensions/grazio/yii2-news/migrations',
        '@grazio/seo' => '@app/extensions/grazio/yii2-seo/migrations',
        '@grazio/sandbox' => '@app/extensions/grazio/yii2-sandbox/migrations',
        '@grazio/spotlights' => '@app/extensions/grazio/yii2-spotlights/migrations',
        '@grazio/image' => '@app/extensions/grazio/yii2-image',
        '@grazio/adminlte' => '@app/extensions/grazio/yii2-adminlte',
        '@clcnzyz/project' => '@app/extensions/clcn-zyz/yii2-project/migrations',
        '@clcnzyz/mien' => '@app/extensions/clcn-zyz/yii2-mien/migrations',
        '@clcnzyz/train' => '@app/extensions/clcn-zyz/yii2-train/migrations',
        '@clcnzyz/member' => '@app/extensions/clcn-zyz/yii2-member/migrations',
        '@clcnzyz/apply' => '@app/extensions/clcn-zyz/yii2-apply/migrations',
        '@clcnzyz/talk' => '@app/extensions/clcn-zyz/yii2-talk/migrations',
        '@clcnzyz/contact' => '@app/extensions/clcn-zyz/yii2-contact/migrations',
    ],
];