MCP Project Use Yii 2 Basic Project Template
============================================

--通过SVN检出代码，部署到生产环境。
Svn：http://svnadmin.miinno.net/repos/net_ecnap_www
Username: 
Password:


DIRECTORY STRUCTURE
-------------------

~~~
app/
    - assets/             contains assets definition
    - commands/           contains console commands (controllers)
    - components/         组件库
    - config/             contains application configurations
        -- web.php        应用配置文件
    - controllers/        contains Web controller classes
    - mail/               contains view files for e-mails
    - models/             contains model classes
    - views/              contains view files for the Web application
    - themes/
        -- basic/
        -- flat/
    - helpers/
    - widgets/
    - modules/            功能模块
        -- admin/
        -- weixin/
        -- api/
etc/                数据库配置文件需要修改
vendor/             contains dependent 3rd-party packages
runtime/            contains files generated during runtime
tests/              contains various tests for the basic application
web/                contains the entry script and Web resources
- index.php         上线需要修改debug模式以及运行环境表示
- ignore.zip        解压到当前目录 (里面又两个目录 assets 和 statics)
mcp.sql             表结构
mcp_data.sql        带测试数据的表结构
ignore.zip          配置文件,库文件,运行时目录等
~~~

REQUIREMENTS
------------

The minimum requirement by this project template that your Web server supports PHP 5.6.0.


INSTALLATION
------------

### Install from an Subversion

1. 从SVN上检出代码
2. 解压`ignore.zip` 文件到当前目录
3. 解压`web/ignore.zip` 文件到当前目录
4. 修改配置文件,请打开环境中的rewrite_module.


可以通过类似下面 URL访问:

~~~
http://localhost/cn_net_bplisn_www/web/
~~~



CONFIGURATION
-------------

### 数据库

修改配置文件 `etc/db.php` 为生产环境配置,例如:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=cn_net_bplisn_www',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
    'tablePrefix' => 'tbl_',
    'enableSchemaCache' => true,
    'schemaCacheDuration' => 3600,
    'schemaCache' => 'cache',
];
```

