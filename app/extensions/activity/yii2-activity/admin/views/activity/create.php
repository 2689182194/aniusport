<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model activity\activity\models\SportsActivity */

$this->title = 'Create Sports Activity';
$this->params['breadcrumbs'][] = ['label' => 'Sports Activities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sports-activity-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
