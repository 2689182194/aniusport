<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model activity\activity\models\ActivityGroup */

$this->title = 'Create Activity Group';
$this->params['breadcrumbs'][] = ['label' => 'Activity Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activity-group-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
