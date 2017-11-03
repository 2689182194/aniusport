<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model activity\anniu\models\Group */

$this->title = '添加分组';
$this->params['breadcrumbs'][] = ['label' => 'Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
