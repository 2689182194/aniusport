<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use grazio\adminlte\widgets\ActiveForm;
use grazio\news\models\NewsCategory;

/* @var $this yii\web\View */
/* @var $model app\modules\spotlights\models\SpotlightsGroup */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="panel-body spotlights-group-form">
    <?php $form = ActiveForm::begin([
        'type' => $model->isNewRecord, 'boxOptions' => ['header' => $model->isNewRecord ? '添加分类 ' : '编辑分类']
    ]); ?>

    <?= $form->field($model, 'category_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category_desc')->textarea(['row' => 3]) ?>

    <?php $arr = NewsCategory::parents() ?>

    <?= $form->field($model, 'parent_id')->dropDownList($arr, ['prompt' => '请选择父类新闻'])->label('新闻分类') ?>

    <?= $form->field($model, 'status')->dropDownList(ArrayHelper::getColumn($model->status(), 'name')) ?>

    <?= $form->field($model, 'sort')->textInput(['maxlength' => true]) ?>
    <?= \grazio\seo\widgets\SeoInputGroup::widget(['model' => $model, 'form' => $form]) ?>
    <hr/>
    <div class="text-right">
        <?= Html::submitButton($model->isNewRecord ? '保存' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>

        <?php if($model->is_deleted == 0):?>
        <?= $model->isNewRecord? '' : Html::a('删除', ['delete', 'id' => $model->category_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '是否删除？',
                'method' => 'post',
            ],
        ]) ?>
            <?php else:?>
            <?= $model->isNewRecord? '' : Html::a('恢复', ['restore', 'id' => $model->category_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => '是否恢复？',
                    'method' => 'post',
                ],
            ]) ?>
<?php endif;?>

        <?php ActiveForm::end(); ?>

    </div>
