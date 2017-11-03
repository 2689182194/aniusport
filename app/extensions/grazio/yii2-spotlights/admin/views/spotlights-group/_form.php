<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use grazio\adminlte\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\spotlights\models\SpotlightsGroup */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-lg-6">
<?php $form = ActiveForm::begin(['type' => $model->isNewRecord, 'boxOptions' => ['header' => $model->isNewRecord ? '添加焦点图分组 ' : '编辑焦点图分组']]); ?>

<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'description')->textarea(['row' => 3]) ?>

<?= $form->field($model, 'status')->dropDownList(ArrayHelper::getColumn($model->status(), 'name')) ?>
<hr/>
<div class="text-right">
    <?= Html::submitButton($model->isNewRecord ? '保存' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>

    <?php if ($model->is_deleted == 0): ?>
        <?= $model->isNewRecord ? '' : Html::a('<i  class=" icon-bin"></i>' . ' 删 除 ', ['delete', 'id' => $model->group_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '是否删除？',
                'method' => 'post',
            ],
        ]) ?>
    <?php else: ?>
        <?= $model->isNewRecord ? '' : Html::a('<i  class=" icon-bin"></i>' . ' 恢复 ', ['restore', 'id' => $model->group_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '是否恢复？',
                'method' => 'post',
            ],
        ]) ?>
    <?php endif; ?>
    <?php ActiveForm::end(); ?>


</div>
</div>