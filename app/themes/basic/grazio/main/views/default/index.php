<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\web\View;
use grazio\image\helpers\ImageHelper;

$this->title = X::title("首页");
?>
    <div class="container">
        <div class="home-focus">
            <div class="col-lg-8 col-md-8 col-sm-8 home-focus-banner">
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <?php foreach ($spotlightsSlice as $key => $valueSlice) : ?>
                            <li data-target="#carousel-example-generic" data-slide-to="<?= $key ?>"
                                class="<?= $key == 0 ? 'active' : '' ?>"></li>
                        <?php endforeach; ?>
                    </ol>
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                        <?php foreach ($spotlightsSlice as $key => $valueSlice) : ?>
                            <div class="item <?= $key == 0 ? 'active' : '' ?>">
                                <a href="<?= $valueSlice->link; ?>"
                                   target="_blank">
                                    <?= Html::img(ImageHelper::src($valueSlice->file), ['alt' => '', 'class' => 'img-responsive']) ?></a>
                                <div class="carousel-caption">
                                    <a href="<?= $valueSlice->link ?>"><?= $valueSlice->title ?></a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 home-focus-notice">
                <h3>通知公告<?= Html::a('更多', ['/news'], ['class' => 'pull-right title-a', 'target' => '_blank']) ?></h3>
                <ul>
                    <?php if ($news): ?>
                        <?php
                        foreach ($news as $valueNotice):
                            ?>
                            <li><?= Html::a($valueNotice->title, ['/news/default/view', 'id' => $valueNotice->news_id], ['target' => '_blank']) ?>
                                <span class="pull-right text-right"><?= date('m.d', $valueNotice->created_at) ?></span>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
                <div class="volunteer-register">
                    <?= Html::a(Html::img($this->theme->getAssetUrl('images/volunteer-register-img.png'), ['alt' => '如何成为首图志愿者', 'class' => 'img-responsive center-block']), ['/main/default/register'], ['target' => '_blank']) ?>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="home-case home-volunteer">
            <h2>志愿项目<?= Html::a('更多', ['/project'], ['class' => 'pull-right title-a', 'target' => '_blank']) ?></h2>
            <div class="clearfix"></div>
            <div id="carousel-example-generic-text" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators hidden-xs">
                    <li data-target="#carousel-example-generic-text" data-slide-to="0" class="active"></li>
                    <li data-target="#carousel-example-generic-text" data-slide-to="1"></li>
                    <li data-target="#carousel-example-generic-text" data-slide-to="2"></li>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner home-case-item" role="listbox">
                    <div class="item active">
                        <?php foreach ($project as $key => $valueProject): ?>
                        <?php if ($key % 3 == 0 && $key != 0): ?>
                    </div>
                    <div class="item">
                        <?php endif; ?>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="volunteer-program">
                                <?php $photo = explode(',', $valueProject->images) ?>
                                <?= Html::a(Html::img('@web/uploads/project/' . $photo[0], ['alt' => '', 'class' => 'img-responsive center-block']), ['/project/default/view', 'id' => $valueProject->id], ['target' => '_blank']) ?>
                                <div class="volunteer-program-text">
                                    <h5><?= $valueProject->title ?></h5>

                                    <p class="home-02-text"><?= mb_substr(strip_tags($valueProject->intro), 0, 65, 'utf-8') . '…' . Html::a('浏览详情', ['/project/view', 'id' => $valueProject->id]) ?></p>

                                    <p><span>招募人数：</span><?= $valueProject->number ?>人</p>
                                    <p>
                                        <span>年龄：</span><?= $valueProject->age_end == 0 ? $valueProject->age_start . '周岁及以上' : $valueProject->age_start . '~' . $valueProject->age_end ?>
                                    </p>
                                    <p><span>性别：</span><?php
                                        $list = ['女', '男', '不限'];
                                        echo $list[$valueProject->gender]
                                        ?></p>
                                    <p>
                                        <span>时间：</span><?= date('Y年m月d日', strtotime($valueProject->recruit_start)) . '~' . date('Y年m月d日', strtotime($valueProject->recruit_end)) ?>
                                    </p>

                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>
            <div class="home-main-05">
                <h2 class="">志愿风采<?= Html::a('更多', ['/mien'], ['class' => 'pull-right title-a']) ?></h2>
                <div class="text-center home-main-05-text">

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#profile1" aria-controls="profile1" role="tab"
                                                                  data-toggle="tab">星光风采</a></li>
                        <li role="presentation"><a href="#settings" aria-controls="settings" role="tab"
                                                   data-toggle="tab">优秀个人</a></li>
                        <li role="presentation"><a href="#set" aria-controls="set" role="tab" data-toggle="tab">优秀团队</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="profile1">
                            <div id="container">
                                <?php
                                $p = 0;
                                foreach ($mien as $valueProfile):
                                    ?>
                                    <?php if ($valueProfile->step == 'star' && $p < 4): $p++ ?>
                                    <div class="hone-05-img col-sm-3 item">
                                        <div id="masonry-bg">
                                            <?= Html::a(Html::img('@web/uploads/mien/' . $valueProfile->image, ['alt' => '', 'class' => 'img-responsive']), ['/mien/default/view', 'id' => $valueProfile->id], ['target' => '_blank']) ?>
                                            <p class="text-left"><?= mb_substr(strip_tags($valueProfile->content), 0, 80, 'utf8') ?></p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="settings" style="padding:0 15px;">

                            <?php
                            $s = 0;
                            foreach ($mien as $valueSettings):
                                ?>
                                <?php if ($valueSettings->step == 'person' && $s < 20): $s++ ?>
                                <div class="hone-05-img hone-05-img-02"><?= Html::a(Html::img('@web/uploads/mien/' . $valueSettings->image, ['alt' => '', 'class' => 'img-responsive']), ['/mien/default/view', 'id' => $valueSettings->id], ['target' => '_blank']) ?>
                                    <p class="text-center"><?= $valueSettings->title ?></p></div>
                            <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="set">
                            <?php
                            $set = 0;
                            foreach ($mien as $valueSet):
                                ?>
                                <?php if ($valueSet->step == 'team' && $set < 10): $set++ ?>
                                <div class="hone-05-img hone-05-img-03 col-xs-6"><?= Html::a(Html::img('@web/uploads/mien/' . $valueSet->image, ['alt' => '', 'class' => 'img-responsive']), ['/mien/default/view', 'id' => $valueSet->id], ['target' => '_blank']) ?>
                                    <p class="text-left"><?= $valueSet->title ?></p></div>
                            <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>

                </div>


            </div>
            <div class="clearfix"></div>

            <div class="home-main-03">
                <h2 class="">
                    志愿动态<?= Html::a('更多', ['/news'], ['class' => 'pull-right title-a', 'target' => '_blank']) ?></h2>
                <?php foreach ($category_news as $k => $v): ?>
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <div class="home-03-title"><?= $v['category_name'] ?></div>
                        <ul class="home-03-ul">
                            <?php
                            foreach ($v['news'] as $valueScrap):
                                ?>

                                <li><?= Html::a($valueScrap->title, ['/news/default/view', 'id' => $valueScrap->news_id], ['target' => '_blank']) ?>
                                    <span class="pull-right text-right"><?= date('m.d', $valueScrap->created_at) ?></span>
                                </li>

                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endforeach; ?>

            </div>
            <div class="clearfix"></div>
        </div>
    </div>
<?php
$css = <<<DOF
    .item {   
  float: left;  
} 
DOF;


$js = <<<EOF
        
        window.onload = function(){
　　 if($(window).width()< 768){
      $("#carousel-example-generic-text").carousel('pause');         
   }  
}    
EOF;

$this->registerCss($css);
$this->registerJs($js);
