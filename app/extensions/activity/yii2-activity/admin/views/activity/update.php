<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model activity\activity\models\SportsActivity */

$this->title = '修改活动: ' . $model->activity_id;
$this->params['breadcrumbs'][] = ['label' => 'Sports Activities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->activity_id, 'url' => ['view', 'id' => $model->activity_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sports-activity-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
