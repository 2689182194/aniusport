<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = X::title("志愿动态");

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
                    <?= Html::a(Html::img($this->theme->getAssetUrl('images/volunteer-register-img.png'), ['alt' => '如何成为首图志愿者', 'class' => 'img-responsive center-block']), ['/main/default/signup'], ['target' => '_blank']) ?>
                </div>
            </div>
            <div class="col-sm-9 col-xs-12 pull-left">
                <ol class="breadcrumb">
                    <span>当前位置：</span>
                    <li><?= Html::a('首页',['/'])?></li>
                    <li class="active"><?= !empty($category_name->category_name) ? $category_name->category_name : '' ?></li>
                </ol>
                <?php foreach ($dataProvider as $value) : ?>
                    <div class="news-left">
                        <h4><?= Html::a($value->title, ['/news/default/view', 'id' => $value->news_id],['target'=>'_blank']) ?></h4>
                        <span class="glyphicon glyphicon-calendar"> <?= date('Y.m.d',$value->created_at)?></span>
                        <div class="clearfix"></div>
                        <?= Html::a(Html::img('@web/news/'.is_array($value->image) ? '' : $value->image, ['alt' => '', 'class' => 'col-sm-4 img-responsive','style' => empty($value->image) ? 'display:none' : '']), ['/news/default/view', 'id' => $value->news_id],['target'=>'_blank']) ?>
                        <div class="<?= empty($value->image) ? 'col-sm-12' : 'col-sm-8'?> news-left-text">
                            <p><?= mb_substr(strip_tags($value->content->content), 0,160,'utf8')?></p>
                            <?= Html::a('阅读更多',['/news/default/view', 'id' => $value->news_id],['class'=>'pull-right'])?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

