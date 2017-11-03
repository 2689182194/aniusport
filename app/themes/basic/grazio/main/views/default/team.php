<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model clcnzyz\member\models\Member  clcnzyz\member\models\Profile*/

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\themes\basic\grazio\main\MainAsset;

MainAsset::register($this);
$this->title = X::title('注册');
?>

    <div class="container-fluid login-bg">
        <div class="container">
            <div class="signup-bg clearfix">
                <div class="text-center entry-main-signup">
                    <ul class="nav nav-tabs">
                        <li><?= Html::a('个人注册', ['signup']) ?></li>
                        <li class="active"><a href="javascript:void(0);"><span>团体注册</span></a></li>
                    </ul>
                    <br/>
                    <div class="signup">
                        <div class="signup-tabs">
                            <?php
                            $formProfile = ActiveForm::begin([
                                'id' => 'profile-form',
                                'options' => ['class' => 'form-horizontal'],
                                'fieldConfig' => [
                                    'template' => "{label}\n<div class=\"col-sm-9 signup-z-index\">{input}</div>\n<div class=\"col-sm-offset-3 col-sm-6\">{error}\n{hint}</div>",
                                    'labelOptions' => ['class' => 'col-sm-3 control-label'],
                                ],
                            ]);
                            ?>
                            <div class="form-group col-sm-6">
                                <?= $formProfile->field($model, 'team', ['enableAjaxValidation' => true])->textInput(['placeholder' => '请正确填写团队名称'])->label('团队名称：') ?>
                            </div>
                            <div class="clearfix"></div>
                            <p class="signup-title">领队信息</p>
                            <hr/>
                            <div class="form-group col-sm-6">
                                <?= $formProfile->field($model, 'number', ['enableAjaxValidation' => true])->textInput(['placeholder' => '请输入15位志愿者编号'])->label('志愿者编号：') ?>
                            </div>
                            <div class="form-group col-sm-6">
                                <?= $formProfile->field($model, 'username', ['enableAjaxValidation' => true])->textInput(['placeholder' => '真实姓名请与证件上保持一致'])->label('真实姓名：') ?>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group col-sm-6">
                                <?= $formProfile->field($model, 'password', ['enableAjaxValidation' => true])->passwordInput(['placeholder' => '请输入6位以上字符'])->label('密码：') ?>
                            </div>
                            <div class="form-group col-sm-6">
                                <?= $formProfile->field($model, 'confirmpwd', ['enableAjaxValidation' => true])->passwordInput(['placeholder' => '请再次输入密码'])->label('确认密码：') ?>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group col-sm-6">
                                <?= $formProfile->field($model, 'email', ['enableAjaxValidation' => true])->textInput(['placeholder' => '审核信息将以邮件通知'])->label('邮箱：') ?>
                            </div>
                            <div class="form-group col-sm-6">
                                <?= $formProfile->field($model, 'confirmemail')->textInput(['placeholder' => '请再次输入电子邮箱地址'])->label('确认邮箱：') ?>
                            </div>
                            <div class="form-group col-sm-6 signup-sex">
                                <?= $formProfile->field($model, 'gender', ['enableAjaxValidation' => true])->radioList([1 => '男', 0 => '女'])->label('性别：') ?>
                            </div>
                            <div class="form-group col-sm-6">
                                <?= $formProfile->field($model, 'card_id', ['enableAjaxValidation' => true])->textInput(['placeholder' => '请输入有效身份证号码'])->label('身份证号码：') ?>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group col-sm-6">
                                <?= $formProfile->field($model, 'phone', ['enableAjaxValidation' => true])->textInput(['placeholder' => '请认真填写手机号码'])->label('手机号码：') ?>
                            </div>
                            <div class="clearfix"></div>
                            <p class="signup-title">成员信息（团队成员不得少于10人）</p>
                            <hr/>
                            <div class="member-signup">
                                <input type="hidden" class="numinps" value="10">
                                <?php for ($i = 0; $i < 10; $i++): ?>
                                    <div class="signup-member">
                                        <span class="num"><?= $i + 1 ?></span>
                                        <div class="form-group col-sm-6">
                                            <?= $formProfile->field($modelProfile, 'number[]')->textInput(['placeholder' => '志愿者编号'])->label('志愿者编号：') ?>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <?= $formProfile->field($modelProfile, 'name[]')->textInput(['placeholder' => '姓名'])->label('姓名：') ?>
                                        </div>
                                        <div class="clearfix"></div>
                                        <hr/>
                                    </div>
                                <?php endfor; ?>
                            </div>
                            <div class="form-group">
                                <button type="button" id="add" class="btn btn-default">添加</button>
                            </div>
                            <div class="form-group">
                                <?= Html::submitButton('注册', ['class' => 'btn btn-default entry-btn', 'type' => 'submit']) ?>
                            </div>

                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
