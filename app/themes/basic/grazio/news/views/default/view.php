<?php

use yii\helpers\Html;

$this->title = X::title('志愿动态');

$getArr = Yii::$app->request->get('category_id',1);
?>

<div class="container-fluid">
    <div class="container">

        <div class="row">
            <div class="col-sm-3 col-xs-12 news-right pull-right">
                <h3>志愿动态</h3>
                <ul>
                    <?php foreach ($category as $value) : ?>
                        <li class="<?= $getArr == $value->category_id ? 'active' : ''?>"><?= Html::a($value->category_name, ['/news','category_id' => $value->category_id]) ?></li>
                    <?php endforeach; ?>
                </ul>
                <div class="volunteer-register">
                    <?= Html::a(Html::img($this->theme->getAssetUrl('images/volunteer-register-img.png'), ['alt' => '', 'class' => 'img-responsive center-block']), ['/main/default/signup'], ['target' => '_blank']) ?>
                </div>
            </div>
            <div class="col-sm-9 col-xs-12 pull-left">
                <ol class="breadcrumb">
                    <span>当前位置：</span>
                    <li><?= Html::a('首页',['/'])?></li>
                    <li><?= Html::a('志愿动态',['/news'])?></li>
                    <li class="active"><?= $model->category->category_name?></li>
                </ol>
                <div class="news-inside">
                    <h3><span class="news-inside-time pull-left"><?= date('Y.m.d',$model->created_at)?></span><?= $model->title?></h3>
                    <div class="training-inside-text">
                        <?= $model->content->content?>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
