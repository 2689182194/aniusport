<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = X::title('登录');

?>

<div class="container-fluid login-bg">
    <div class="container">
        <div class="text-center entry-main">
            <p class="entry-p">您需要通过《志愿北京》的用户实名认证，并取得了志愿者编号后才可进行登录</p>
            <?php
            $form = ActiveForm::begin([
                        'id' => 'login-form',
                        'options' => ['class' => 'form-horizontal'],
                        'fieldConfig' => [
                            'template' => "{label}\n<div class=\"col-lg-12\">{input}</div>\n<div class=\"\">{error}</div>",
                            'labelOptions' => ['class' => 'col-lg-1 control-label'],
                        ],
            ]);
            ?>
            <div class="form-group entry-login">
                <?= $form->field($model, 'username')->textInput(['placeholder'=>'邮箱 / 志愿者编号 / 身份证号码'])->label(false) ?>
            </div>
            <div class="form-group entry-login">
                <?= $form->field($model, 'password')->passwordInput(['placeholder'=>'密码'])->label(false) ?>
            </div>
            <div class="form-group entry-login">
                <?= Html::submitButton('登录', ['class' => 'btn btn-default entry-btn', 'type' => 'submit']) ?>
            </div>
            <p class="entry-pass"><?= Html::a('忘记密码？',['get-pwd'])?></p>
            <div class="form-group">
               <?= Html::a('还不是志愿者？现在去注册', ['/main/default/signup'],['class'=>'btn btn-default entry-register']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<?php

$image = $this->theme->getAssetUrl('images/login-bg.png');
$image = str_replace('\\','/',$image);

$css = <<<DOF
        body{
         background-image: url('{$image}');
 	background-position: center top;
 	background-repeat: no-repeat;
   }
           .form-group.entry-login{
         margin-left:0;
         margin-right:0;
   }
DOF;
$this->registerCss($css);
