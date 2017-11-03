<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model grazio\gos\models\MediaItemModel */

$this->title = 'Update Media Item Model: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Media Item Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="media-item-model-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
