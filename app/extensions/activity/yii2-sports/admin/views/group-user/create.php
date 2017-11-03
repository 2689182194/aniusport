<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model activity\anniu\models\GroupUser */

$this->title = '用户分组';
$this->params['breadcrumbs'][] = ['label' => 'Group Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-user-create">


    <?= $this->render('_form', [
        'model' => $model,
        'group' => $group,
        'user' => $user
    ]) ?>

</div>
