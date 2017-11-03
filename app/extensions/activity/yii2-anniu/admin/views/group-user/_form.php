<?php

use yii\helpers\Html;
use grazio\adminlte\widgets\ActiveForm;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model activity\anniu\models\GroupUser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="group-user-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype' => 'multipart/form-data'
        ],
        'type' => $model->isNewRecord, 'boxOptions' => ['header' => $model->isNewRecord ? '添加用户 ' : '修改用户']
    ]); ?>

    <?= $form->field($model, 'group_id')->widget(Select2::classname(), [
        'data' => $group,
        'language' => 'de',
        'options' => ['placeholder' => '请选择组名'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);?>
    <?= $form->field($model, 'user_id')->widget(Select2::classname(), [
        'data' => $user,
        'language' => 'de',
        'options' => ['placeholder' => '请选择用户名'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
