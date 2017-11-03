<?php

use yii\helpers\Html;
use grazio\adminlte\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model grazio\seo\models\SeoMetaModel */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Seo Meta', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seo-meta-model-view">


    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'entity',
            'model',
            'route',
            'title',
            'keywords:ntext',
            'description:ntext',
            'robots',
        ],
    ]) ?>

</div>
