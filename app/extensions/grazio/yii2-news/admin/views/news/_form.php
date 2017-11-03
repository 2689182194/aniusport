<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use grazio\adminlte\widgets\ActiveForm;
use grazio\news\models\NewsCategory;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\modules\spotlights\models\SpotlightsSlice */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="panel-body">
    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype' => 'multipart/form-data'
        ],
        'type' => $model->isNewRecord, 'boxOptions' => ['header' => $model->isNewRecord ? '添加志愿动态 ' : '编辑志愿动态']
    ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'subtitle')->textInput(['maxlength' => true]) ?>

    <?= '<label>发布时间</label>' ?>;
    <?= DatePicker::widget([
        'model' => $model,
        'name' => 'News[publish_time]',
        'options' => ['placeholder' => ''],
        'value' => $model->isNewRecord ? date('Y-m-d', time()) : date('Y-m-d', $model->publish_time),
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd',
            'todayHighlight' => true
        ]
    ]); ?>

    <?= $form->field($model, 'summary')->textarea(['row' => 3]) ?>

    <?= $form->field($model, 'keywords')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'author')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'source')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'source_link')->textInput() ?>


    <?= $form->field($contentModel, 'content')->label(false)->widget('grazio\ueditor\UEditor',
        [
            'clientOptions' => [
                'serverUrl' => Url::to(['upload']),
                //编辑区域大小
                'initialFrameHeight' => '300',
            ]]
    )->label('内容') ?>
    <?= Html::tag('span','',['id'=>'content_error'])?><br/>

    <?= $form->field($imageModel, 'image_url[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>

    <?= $form->field($model, 'status')->dropDownList(ArrayHelper::getColumn($model->status(), 'name')) ?>

    <?= $form->field($model, 'type')->dropDownList(ArrayHelper::getColumn($model->type(), 'name')) ?>

    <?php $array = array(
        '0' => '否',
        '1' => '是'
    );
    ?>
    <?= $form->field($model, 'headline')->dropDownList($array) ?>


    <?php $arr = NewsCategory::parents() ?>
    <?php unset($arr[0]) ?>

    <?= $form->field($model, 'category_id')->dropDownList($arr, ['prompt' => '请选择分类名称'])->label('分类名称') ?>
    <?= \grazio\seo\widgets\SeoInputGroup::widget(['model' => $model, 'form' => $form]) ?>
    <hr/>
    <div class="text-right">
        <?= Html::submitButton('<i  class=" icon-floppy-disk"></i> ' . ($model->isNewRecord ? ' 保 存 ' : ' 修改 '), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
        <?php if ($model->is_deleted == 0): ?>
            <?= $model->isNewRecord ? '' : Html::a('<i  class=" icon-bin"></i>' . ' 删 除 ', ['delete', 'id' => $model->news_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => '是否删除？',
                    'method' => 'post',
                ],
            ]) ?>
        <?php else: ?>
            <?= $model->isNewRecord ? '' : Html::a('<i  class=" icon-bin"></i>' . ' 恢复 ', ['restore', 'id' => $model->news_id], [
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
<?php
$js = <<<EOF
 $("#w0").submit(function(){
       var ue = UE.getEditor('newscontent-content');
       var check = ue.hasContents();
       if(check){
            $("#content_error").text('');
            return true;
       }else{
          $("#content_error").text('内容不能为空');
          $("#content_error").css("color","red");
           return false;
       }
    })
        
EOF;

$this->registerJs($js);