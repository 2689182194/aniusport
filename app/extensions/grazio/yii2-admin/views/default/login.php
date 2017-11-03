<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = Yii::t('admin', 'Login');
$this->params['breadcrumbs'][] = $this->title;
$this->title = 'Sign In';

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>

<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>Grazio</b> CMP</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your business</p>

        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
        <?= $form
            ->field($model, 'username', $fieldOptions1)
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('username')]) ?>

        <?= $form
            ->field($model, 'password', $fieldOptions2)
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>


        <?php if ($model->isVerifyRobotRequired) : ?>
            <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                'captchaAction'=>'default/captcha',
                'template' => '{image}{input}',
            ]) ?>
        <?php endif; ?>
        <div class="row">
            <div class="col-xs-8">
                <?php if (Yii::$app->user->enableAutoLogin) : ?>
                    <?= $form->field($model, 'rememberMe')->checkbox() ?>
                <?php endif; ?>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <?= Html::submitButton('Sign in', ['class' => 'btn btn-success btn-block btn-flat', 'name' => 'login-button']) ?>
            </div>
            <!-- /.col -->
        </div>

        <?php ActiveForm::end(); ?>

        <a href="#">I forgot my password</a><br>

    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->
