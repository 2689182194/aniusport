<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model activity\anniu\models\GroupUser */

$this->title = '修改用户分组: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Group Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="group-user-update">

    <?= $this->render('_form', [
        'model' => $model,
        'group' => $group,
        'user' => $user
    ]) ?>

</div>
