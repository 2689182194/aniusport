<?php

use yii\helpers\Html;
use grazio\adminlte\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model activity\question\models\Questions */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="questions-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype' => 'multipart/form-data'
        ],
        'type' => $model->isNewRecord, 'boxOptions' => ['header' => $model->isNewRecord ? '添加问题 ' : '编辑问题']
    ]); ?>

    <?= $form->field($model, 'phone')->text() ?>

    <?= $form->field($model, 'question')->text() ?>

    <?= $form->field($model, 'answer')->text() ?>

    <?= $form->field($model, 'weight')->textInput() ?>
    <?= $form->field($model, 'status')->dropDownList(ArrayHelper::getColumn($model->status(), 'name')) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
