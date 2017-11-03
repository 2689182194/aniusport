<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model grazio\seo\models\SeoMetaModel */

$this->title = 'Update Seo Meta: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Seo Meta', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="seo-meta-model-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
