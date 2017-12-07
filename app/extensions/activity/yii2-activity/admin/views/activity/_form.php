<?php

use yii\helpers\Html;
use grazio\adminlte\widgets\ActiveForm;
use activity\activity\models\ActivityGroup;
use grazio\image\widgets\ImageInput;
use kartik\datetime\DateTimePicker;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model activity\activity\models\SportsActivity */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sports-activity-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype' => 'multipart/form-data'
        ],
        'type' => $model->isNewRecord, 'boxOptions' => ['header' => $model->isNewRecord ? '添加活动 ' : '修改活动']
    ]); ?>

    <?= $form->field($model, 'group_id')->dropDownList(ActivityGroup::Group(), ['prompt' => '请选择所属活动分类'])->label('所属活动分类') ?>
    <?= $form->field($model, 'activity_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'file')->widget(ImageInput::className(), [
        'hintFileSize' => '500KB',
        'hintImageSize' => '400px*400px',
        'hintExtensions' => 'png,jpg',
    ]) ?>

    <?= $form->field($model, 'start_time')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => ''],
        'pluginOptions' => [
            'autoclose' => true
        ]
    ]);
    ?>

    <?= $form->field($model, 'end_time')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => ''],
        'pluginOptions' => [
            'autoclose' => true
        ]
    ]);
    ?>
    <?= $form->field($model, 'status')->dropDownList(ArrayHelper::getColumn($model->flag(), 'name')) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
