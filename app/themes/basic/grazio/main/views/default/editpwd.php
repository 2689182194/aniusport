<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = X::title('密码重置');
?>
<div class="member-editpwd">
    <h3 class="text-center">密码重置</h3>
    <hr />
    <div class="member-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'username')->textInput(['readonly' => true]) ?>

        <?= $form->field($model, 'newPassword')->passwordInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'rePassword')->passwordInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', '保存'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>

<?php
$css = <<<DOF
    .member-editpwd{
        border:1px solid #ccc;
        width:500px;
        margin:50px auto;   
        padding:20px 0;
        border-radius:10px
    }
    .member-form{
        margin:0 auto
    }
    .member-form button{
        width:100%
    }
        
DOF;
$this->registerCss($css);

$js = <<<EOF
    $("#w0").submit(function(e){
        var newPwd = $("#member-newpassword").val();
        var rePwd = $("#member-repassword").val();
        if(newPwd != rePwd){            
            e.preventDefault();
            $("#member-repassword").parent().removeClass("has-success");
            $("#member-repassword").parent().addClass("has-error");
            $("#member-repassword").siblings(".help-block").html("两次输入不一致！");
        }
    });
        
        
EOF;
$this->registerJs($js);

