<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model grazio\gos\models\MediaItemModel */

$this->title = 'Create Media Item Model';
$this->params['breadcrumbs'][] = ['label' => 'Media Item Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="media-item-model-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
