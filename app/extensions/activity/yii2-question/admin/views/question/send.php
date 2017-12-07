<?php

use yii\helpers\Html;
use grazio\adminlte\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Aplay */

$this->title = '回复';
?>
<div class="aplay-update">
    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype' => 'multipart/form-data'
        ],
        'type' => $model->isNewRecord, 'boxOptions' => ['header' => $model->isNewRecord ? '发送邮件' : '']
    ]); ?>

    <?= $form->field($model, 'answer')->textarea() ?>


    <div class="form-group">
        <?= Html::submitButton('发送', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


