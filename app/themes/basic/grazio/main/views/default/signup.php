<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model clcnzyz\member\models\Member */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\themes\basic\grazio\main\SignAsset;

SignAsset::register($this);

$this->title = X::title('注册');
?>

    <div class="container-fluid login-bg">
        <div class="container">
            <div class="signup-bg clearfix">
                <div class="text-center entry-main-signup">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#"><span>个人注册</span></a></li>
                        <li><?= Html::a('团体注册', ['team']) ?></li>
                    </ul>
                    <br/>
                    <div class="signup">
                        <div class="signup-tabs">
                            <?php
                            $form = ActiveForm::begin([
                                'enableClientValidation' => true,//开启客户端验证，生成js
                                'enableAjaxValidation' => true,
                                'id' => 'sign-form',
                                'options' => ['class' => 'form-horizontal'],
                                'fieldConfig' => [
                                    'template' => "{label}\n<div class=\"col-sm-9 signup-z-index\">{input}</div>\n<div class=\"col-sm-offset-3 col-sm-6\">{error}\n{hint}</div>",
                                    'labelOptions' => ['class' => 'col-sm-3 control-label'],
                                ],
                            ]);
                            ?>
                            <div class="form-group col-sm-12 entry-main-number">
                                <?= $form->field($model, 'number')->textInput(['placeholder' => '志愿者编号'])->label('志愿者编号：') ?>
                                <p class="entry-main-number-a"><span
                                            class="glyphicon glyphicon-info-sign"></span><?= Html::a('如何获取志愿者编号？', ['/main/default/register'], ['target' => '_blank']) ?>
                                </p>


                            </div>
                            <div class="form-group col-sm-12">
                                <?= $form->field($model, 'username')->textInput(['placeholder' => '真实姓名请与证件上保持一致'])->label('真实姓名：') ?>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group col-sm-12">
                                <?= $form->field($model, 'password')->passwordInput(['placeholder' => '请输入6位以上字符'])->label('密码：') ?>
                            </div>
                            <div class="form-group col-sm-12">
                                <?= $form->field($model, 'confirmpwd')->passwordInput(['placeholder' => '请再次输入密码'])->label('确认密码：') ?>
                            </div>
                            <div class="form-group col-sm-12">
                                <?= $form->field($model, 'email')->textInput(['placeholder' => '审核信息、密码找回及项目信息将以邮件通知'])->label('邮箱：') ?>
                            </div>
                            <div class="form-group col-sm-12">
                                <?= $form->field($model, 'confirmemail')->textInput(['placeholder' => '请再次输入电子邮箱地址'])->label('确认邮箱：') ?>
                            </div>
                            <div class="form-group col-sm-12 signup-sex">
                                <?= $form->field($model, 'gender')->radioList([1 => '男', 0 => '女'])->label('性别：') ?>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group col-sm-12">
                                <?= $form->field($model, 'card_id')->textInput(['placeholder' => '请输入有效身份证号码'])->label('身份证号：') ?>
                            </div>
                            <div class="form-group col-sm-12">
                                <?= $form->field($model, 'school')->textInput(['placeholder' => '填写所在学校或单位名称'])->label('学校/单位：') ?>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group col-sm-12">
                                <?= $form->field($model, 'phone')->textInput(['placeholder' => '请认真填写手机号码'])->label('手机号：') ?>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-sm-12">
                                <p class="signup-text">
                                    我愿意成为一名光荣的志愿者。我承诺：尽己所能，不计报酬，帮助他人，服务社会，践行志愿精神，传播先进文化，为社会进步贡献力量。</p>
                            </div>
                            <div class="form-group col-sm-6 signup-style">
                                <div class="form-group col-sm-6 signup-style">
                                    <div class="form-group field-signupform-check required">
                                        <div class="col-sm-9" style="padding:0;">
                                            <input type="hidden" value="0" name="Member[check]">
                                            <div id="signupform-check">
                                                <div class="checkbox" style="white-space:nowrap">
                                                    <label style="float:none;">
                                                        <input id="member-check" type="checkbox" value="1"
                                                               name="Member[check]">
                                                        我已阅读并同意
                                                    </label>
                                                    <a data-toggle="modal" data-target="#myModal">
                                                        《首图志愿者协议》
                                                    </a>
                                                </div>
                                                <div class="choose" style="display: none">请先同意此协议！</div>
                                                <!-- Modal -->
                                                <div class="modal fade" id="myModal" tabindex="-1" role="dialog"
                                                     aria-labelledby="myModalLabel">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close" style="width: auto;"><span
                                                                            aria-hidden="true">&times;</span></button>
                                                                <h4 class="modal-title" id="myModalLabel">
                                                                    首都图书馆志愿者注册协议</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>
                                                                    本网站及与本网站链接的网站，仅提供志愿者、志愿服务团体、志愿服务机构及其它与此相关联之志愿服务项目。志愿者、志愿服务团体、志愿服务机构以及因
                                                                    其它任何目的进入本网站的访问者接受本协议书条款，注册成为志愿北京网站会员，并遵守本协议所述之条款使用本网站所提供之服务。如果您不接受本声明之条
                                                                    款，请勿使用本网站。接受本声明之条款，您将遵守本协议之规定。</p>

                                                                <p>1.信息的发布</p>

                                                                <p>·不得发布任何违反有关法律规定信息；</p>
                                                                <p>·不得发布任何与本网站志愿服务目的不适之信息；</p>
                                                                <p>·不得发布任何不完整、虚假的信息；</p>
                                                                <p>·用户对所发布的信息承担完全责任。</p>

                                                                <p> 2.信息的使用</p>

                                                                <p>·志愿服务团体、志愿服务机构仅可就志愿服务目的使用志愿者之个人信息；</p>
                                                                <p>·志愿者仅可因参加某志愿服务项目，使用志愿服务团体、志愿服务机构发布之项目招募信息；</p>
                                                                <p>·本网站提供的其它信息，仅与其相应内容有关的目的而被使用；</p>
                                                                <p>·不得将任何本网站的信息用作任何商业目的。</p>

                                                                <p>3.信息的公开</p>

                                                                <p>
                                                                    在本网站所登录的任何信息，均有可能被任何本网站的访问者浏览，也可能被错误使用。本网站对此将不予承担任何责任。</p>

                                                                <p>4.信息的准确性</p>

                                                                <p>
                                                                    任何在本网站发布的信息，均必须符合合法、准确、及时、完整的原则。但本网站将不能保证所有由第三方提供的信息，或本网站自行采集的信息完全准确。使用
                                                                    者了解，对这些信息的使用，需要经过进一步核实。本网站对访问者未经自行核实误用本网站信息造成的任何损失不予承担任何责任。</p>

                                                                <p>5.信息更改与删除</p>

                                                                <p>
                                                                    除了信息的发布者外，任何访问者不得更改或删除他人发布的任何信息。本网站有权根据其判断保留修改或删除任何不适信息之权利。</p>

                                                                <p>6.版权、商标权</p>

                                                                <p>
                                                                    本网站的图形、图像、文字及其程序等均属志愿北京网站之版权，受商标法及相关知识产权法律保护，未经志愿北京网站书面许可，任何人不得下载、复制、再使用。在本网发布信息之商标，归其相应的商标所有权人，受商标法保护。</p>

                                                                <p>7、注册信息使用</p>

                                                                <p>
                                                                    注册会员所提供的个人信息将会被志愿北京网站统计、汇总，在我们的严格管理下，为志愿北京网站的合作者提供依据。志愿北京网站会不定期地通过注册会员留下的电子邮件、电话或通信地址同该会员保持联系。</p>

                                                                <p>
                                                                    志愿北京网站承诺：在未经访问者授权同意的情况下，志愿北京网站不会将访问者的个人资料泄露给第三方。但以下情况除外。</p>
                                                                <p>·根据执法单位之要求或为公共之目的向相关单位提供个人资料；</p>
                                                                <p>·由于您将用户密码告知他人或与他人共享注册帐户，由此导致的任何个人资料泄露；</p>
                                                                <p>
                                                                    ·由于计算机2000年问题、黑客攻击、计算机病毒侵入或发作、因政府管制而造成的暂时性关闭等影响网络正常经营之不可抗力而造成的个人资料泄露、丢失、被盗用或被窜改等；</p>
                                                                <p>·由于与志愿北京网站链接的其它网站所造成之个人资料泄露及由此而导致的任何法律争议和后果；</p>
                                                                <p>·为免除访问者在生命、身体或财产方面之急迫危险。</p>

                                                                <p>8.自责</p>

                                                                <p>
                                                                    所有使用本网站的用户，对使用本网站信息和在本网站发布信息的被使用，承担完全责任。本网站对任何因使用本网站而产生的第三方之间的纠纷，不负任何责任。</p>

                                                                <p>9.服务终止</p>

                                                                <p>本网站有权在预先通知或不予通知的情况下终止任何免费服务。</p>

                                                                <p>10.争议处理</p>

                                                                <p>本网站因正常的系统维护、系统升级，或者因网络拥塞而导致网站不能访问，本网站不承担任何责任。</p>

                                                                <p>11.免责条款</p>

                                                                <p>
                                                                    本网并无随时监视此网址，但保留对其实施实时监视的权利。对于他方输入的，不是本网发布的材料，本网概不负任何法律责任。对于其他网址链接在本网址的内容，本网概不负法律责任。</p>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button"
                                                                        class="btn btn-default center-block"
                                                                        data-dismiss="modal">同意此协议
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <?= Html::submitButton('注册', ['class' => 'btn btn-default entry-btn', 'type' => 'submit']) ?>


                        </div>
                        <div class="clearfix"></div>
                        <?php ActiveForm::end(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
