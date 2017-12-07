<?php

use yii\helpers\Html;
use grazio\adminlte\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model activity\activity\models\ActivityGroup */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="activity-group-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype' => 'multipart/form-data'
        ],
        'type' => $model->isNewRecord, 'boxOptions' => ['header' => $model->isNewRecord ? '添加活动分类 ' : '修改活动分类']
    ]); ?>

    <?= $form->field($model, 'group_name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
