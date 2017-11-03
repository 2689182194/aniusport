<?php

use yii\bootstrap\Html;
use grazio\adminlte\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\db\Admin */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
    <div class="col-lg-6">

        <?php $form = ActiveForm::begin(['type' => $model->isNewRecord, 'boxOptions' => ['header' => $model->isNewRecord ? '添加管理员' : '编辑管理员']]); ?>

        <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'status_id')->dropDownList(ArrayHelper::map(\grazio\system\models\Identity::statusList(), 'id', 'name')) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('yii', 'Create') : Yii::t('yii', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
