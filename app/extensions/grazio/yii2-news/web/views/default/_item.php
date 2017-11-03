<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

?>


<?= Html::a($model->title, ['view', 'news_id' => $model->news_id]) ?>

<?= Html::tag('p', '发布时间: ' . date('Y-m-d', $model->publish_time)) ?>
<?php foreach ($model->image as $k => $v): ?>
    <?= Html::img(Yii::getAlias('@uploadsUrl/news/' . $v->image_url)) ?>
<?php endforeach; ?>
<?= Html::tag('p', $model->summary) ?>
