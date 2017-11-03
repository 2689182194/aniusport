<?php

use yii\helpers\Html;

$this->title = X::title('如何在志愿背景平台注册首都图书馆文化志愿者');
?>

<div class="container-fluid">
    <div class="container register">
        <h2>如何在志愿北京平台注册首都图书馆文化志愿者</h2>
        <div class="register-text">
            <h3>一、在志愿北京网站注册成为文化志愿者</h3>
            <p>（1）登录志愿北京网站 <a href="http://www.bv2008.cn" title="志愿北京官网" target="_blank">http://www.bv2008.cn</a>，选择“志愿者注册”</p>
            <?= Html::img($this->theme->getAssetUrl('images/register-01.jpg'), ['alt' => '', 'class' => 'img-responsive center-block']) ?>
        </div>
        <div class="register-text">
            <p>（2）填写帐号信息</p>
            <?= Html::img($this->theme->getAssetUrl('images/register-02.jpg'), ['alt' => '', 'class' => 'img-responsive center-block']) ?>
        </div>
        <div class="register-text">
            <p>（3）填写个人基本信息</p>
            <?= Html::img($this->theme->getAssetUrl('images/register-03.jpg'), ['alt' => '', 'class' => 'img-responsive center-block']) ?>
        </div>
        <div class="register-text">
            <p>（4）选择专业服务方向和领域</p>
            <?= Html::img($this->theme->getAssetUrl('images/register-04.jpg'), ['alt' => '', 'class' => 'img-responsive center-block']) ?>
        </div>
        <div class="register-text">
            <p>（5）检查信息无误后，申请成为实名注册志愿者</p>
            <?= Html::img($this->theme->getAssetUrl('images/register-05.jpg'), ['alt' => '', 'class' => 'img-responsive center-block']) ?>
        </div>
        <div class="register-text register-border">
            <p>（6）出现以下信息，完成志愿者注册环节</p>
            <?= Html::img($this->theme->getAssetUrl('images/register-06.jpg'), ['alt' => '', 'class' => 'img-responsive center-block']) ?>
        </div>
        <h2>选择加入“北京市文化志愿者服务中心首都图书馆分中心”</h2>
        <div class="register-text">
            <p>（1）在“志愿团队”中，以“首都图书馆”为关键词进行检索</p>
            <?= Html::img($this->theme->getAssetUrl('images/register-07.jpg'), ['alt' => '', 'class' => 'img-responsive center-block']) ?>
        </div>
        <div class="register-text">
            <p>（2）找到该团队，点击“我要加入”</p>
            <?= Html::img($this->theme->getAssetUrl('images/register-08.jpg'), ['alt' => '', 'class' => 'img-responsive center-block']) ?>
        </div>
        <div class="register-text register-border">
            <p>（3）出现以下信息，结束团队加入”</p>
            <?= Html::img($this->theme->getAssetUrl('images/register-09.jpg'), ['alt' => '', 'class' => 'img-responsive center-block']) ?>
        </div>
        <h2>填写首都图书馆文化志愿者登记表（个人）</h2>
        <div class="register-text register-border register-btn">
            <?= Html::img($this->theme->getAssetUrl('images/register-10.jpg'), ['alt' => '', 'class' => 'img-responsive center-block']) ?>

            <div class="pull-left text-center">
                <a href="http://www.bv2008.cn/app/user/register.php" target="_blank"><?= Html::button('志愿者注册', ['class' => 'btn btn-default register-btn-left']) ?></a>
            </div>
            <div class="pull-left text-center">
                <a href="http://www.bv2008.cn/app/user/register.php?type=org" target="_blank"><?= Html::button('志愿者团体注册', ['class' => 'btn btn-default register-btn-right']) ?></a>
            </div>

        </div>
    </div>
</div>

