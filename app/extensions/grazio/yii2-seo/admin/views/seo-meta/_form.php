<?php

use yii\helpers\Html;
use grazio\adminlte\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model grazio\seo\models\SeoMetaModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="seo-meta-model-form">

    <?php $form = ActiveForm::begin(['type' => $model->isNewRecord, 'boxOptions' => ['header' => $model->isNewRecord ? '添加 ' : '编辑']]); ?>

    <?= $form->field($model, 'route')->textInput(['maxlength' => true]) ?>

    <?= \grazio\seo\widgets\SeoInputGroup::widget(['model' => $model, 'form' => $form]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
