grazio\seo
==========
seo manager

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist grazio/yii2-seo "*"
```

or add

```
"grazio/yii2-seo": "*"
```

to the require section of your `composer.json` file.


Usage
-----
###需要使用seo可以引用seo模块具体引用如下
for example：
#####（1）表单页面引入SeoInputGroup小部件,代码如下
```php
    <?= \grazio\seo\widgets\SeoInputGroup::widget(['model' => $model, 'form' => $form]) ?>

```
###小部件内容包含
>标题

>关键字

>内容

>蜘蛛授权

#####（2）当前模型页面引入封装的SeoMetaBehavior
通过SeoMetaBehavior添加数据到seo_meta数据表
```php
 public function behaviors()
    {
        return [
        
            [
                'class' => '\grazio\seo\behaviors\SeoMetaBehavior',
                'seoRoute' => '/news/default/index'
            ]
        ];
    }
    
```
class为引入的SeoMetaBehavior的文件路径

seoRoute为前台对应的显示的页面路由
```php
    public function rules()
    {
        return [
            [['seoTitle', 'seoKeywords', 'seoDescription', 'seoRobots'], 'safe'],
        ];
    }
```