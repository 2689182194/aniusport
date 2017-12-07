<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model activity\activity\models\ActivityGroup */

$this->title = '修改活动分类: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Activity Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="activity-group-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
