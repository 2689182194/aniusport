<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model grazio\seo\models\SeoMetaModel */

$this->title = 'Create Seo Meta';
$this->params['breadcrumbs'][] = ['label' => 'Seo Meta', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seo-meta-model-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
