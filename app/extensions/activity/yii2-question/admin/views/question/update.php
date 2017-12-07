<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model activity\question\models\Questions */

$this->title = '修改问题: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Questions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="questions-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
