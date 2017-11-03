<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = !empty($model->title) ? $model->title . '新闻' : '';
?>

<h2><?= $model->title ?></h2>
<span class="news_time">发布时间：<?= date('Y-m-d', $model->publish_time) ?></span>

<p>
    摘要：<?= $model->summary ?>
</p>

<p>
    内容：<?= $model->content->content ?>
</p>

<?php if (!empty($model->image)): ?>
    图片:
    <?php foreach ($model->image as $k => $v): ?>
        <?= Html::img(Yii::getAlias('@uploadsUrl/news/' . $v->image_url)) ?></p>
    <?php endforeach; ?>
<?php endif; ?>
