<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use grazio\gos\widgets\FileUploadUI;

/* @var $this yii\web\View */
/* @var $model grazio\gos\models\Test */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="test-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= FileUploadUI::widget([
        'model' => $model,
        'attribute' => 'attachment',
        'loadExistingFiles' => ['/gos/file/fetch'],
        'url' => ['/gos/file/upload','source_owner'=>'test','source_form'=>$model->formName(),'source_attribute'=>'attachment'], // your url, this is just for demo purposes,
        'options' => [
            'id' => 'gos-file-upload-input',
            'accept' => '*'
        ],
        'fieldOptions' => [
            'name' => 'gos-file-upload-input',
        ],
        'clientOptions' => [
            'dataType' => 'json',
            'paramName' => 'file',
            'maxFileSize' => 2000000,
            'formData' => '{}',
        ],
        // Also, you can specify jQuery-File-Upload events
        // see: https://github.com/blueimp/jQuery-File-Upload/wiki/Options#processing-callback-options
        'clientEvents' => [
        ],
    ]); ?>
    <?= \grazio\seo\widgets\SeoInputGroup::widget(['model'=>$model,'form'=>$form])?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
