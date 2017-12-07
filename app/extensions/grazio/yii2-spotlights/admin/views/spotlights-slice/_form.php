<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use grazio\spotlights\models\SpotlightsGroup;
use grazio\adminlte\widgets\ActiveForm;
use grazio\image\widgets\ImageInputAsset;
use grazio\image\widgets\ImageInput;

/* @var $this yii\web\View */
/* @var $model app\modules\spotlights\models\SpotlightsSlice */
/* @var $form yii\widgets\ActiveForm */


?>

<div class="panel-body">
    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype' => 'multipart/form-data'
        ],
        'type' => $model->isNewRecord, 'boxOptions' => ['header' => $model->isNewRecord ? '添加焦点图 ' : '编辑焦点图']
    ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['row' => 3]) ?>

    <?= $form->field($model, 'banner')->widget(ImageInput::className(), [
        'hintFileSize' => '500KB',
        'hintImageSize' => '400px*400px',
        'hintExtensions' => 'png,jpg',
    ]) ?>

    <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList(ArrayHelper::getColumn($model->status(), 'name')) ?>

    <?= $form->field($model, 'weight')->textInput() ?>

    <?php $arr = SpotlightsGroup::Group() ?>
    <?= $form->field($model, 'flag')->radioList([1=>'显示',0=>'隐藏']) ?>

    <?= $form->field($model, 'group_id')->dropDownList($arr, ['prompt' => '请选择所属焦点图'])->label('所属焦点图') ?>

    <hr/>
    <div class="text-right">
        <?= Html::submitButton('<i  class=" icon-floppy-disk"></i> ' . ($model->isNewRecord ? ' 保 存 ' : ' 修改 '), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
        <?php if ($model->is_deleted == 0): ?>
            <?= $model->isNewRecord ? '' : Html::a('<i  class=" icon-bin"></i>' . ' 删 除 ', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => '是否删除？',
                    'method' => 'post',
                ],
            ]) ?>
        <?php else: ?>
            <?= $model->isNewRecord ? '' : Html::a('<i  class=" icon-bin"></i>' . ' 恢复 ', ['restore', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => '是否恢复？',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif; ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
