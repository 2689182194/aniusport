<?php

use yii\widgets\ActiveForm;
use yii\captcha\Captcha;

$this->title = X::title('找回密码');
$flashes = Yii::$app->session->getAllFlashes();
$key = key($flashes);
?>
<div class="getpwd">
    <h3 class="text-center">找回密码</h3>
    <hr />
    <div class="intro text-center">
        请填写您在注册时用的身份证号，提交成功后会有一封邮件发送到这个身份证号对应的邮箱中，请注意查收。
    </div>

    <div class="inps text-center">
        <?php $form = ActiveForm::begin(); ?>
        <div class="form-group col-sm-12">
            <?= $form->field($model, 'card_id')->textInput(['placeholder' => '身份证号'])->label(false) ?>
        </div>
        <div class="clearfix"></div>


        <!--<br /><font size="-1" color="#aaa">找回密码邮件会发送到注册时填写的邮箱</font>-->
        <div class="form-group inps-pass col-sm-6 col-xs-6">
            <?= $form->field($model, 'verifyCode')->textInput(['placeholder' => '验证码'])->label(false) ?>
        </div>
        <?=
        $form->field($model, 'verifyCodeImage')->widget(Captcha::className(), [
            'template' => "{image}",
            'imageOptions' => ['alt' => '验证码'],
            'captchaAction' => '/main/default/captcha',
        ])->label(false);
        ?>
        <div class="clearfix"></div>
        <button class="btn btn-default" id="sub" type="submit" >提交</button>
        <?php ActiveForm::end(); ?>
        <div class="modal fade">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        邮件已发送到您注册时的邮箱里，请注意查收！
                        <button type="button" class="close" style="width: auto;"><span aria-hidden="true">&times;</span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>
</div>

<?php
$url = yii\helpers\Url::to(['validate-pwd']);

$js = <<<EOF
        
    if('{$key}' == 'success'){
        $(".modal").show();
        $(".modal").css("opacity","1");
    }
    $(".close").click(function(){
        window.location.href='http://stzyz.clcn.net.cn/'
   })
        
    $("#sub").click(function(){
        var card = $("#member-card_id").val();
        if(!/(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/.test(card)) {
            alert("身份证号不合法！");
        }
//            else{        
//            time(60);
//            $.post('{$url}',{card:card},function(data){
//                if(data == 'success'){
//                    alert("邮件已发送到您注册时填写的邮箱里，请注意查收！")
//                }
//            })
//        }        
    })
    function time(wait) {
        if (wait == 0) {
            $("#sub").removeAttr("disabled");
            $("#sub").html("重新获取");
            wait = 60;
        } else {
            $("#sub").attr("disabled", true);
            $("#sub").html(wait + "秒后可重新获取");
            wait--;
            setTimeout(function () {
                time(wait);
            },
                    1000);
        }
    }
        
EOF;
$this->registerJs($js);

$css = <<<DOF
    .modal{
         background-color:rgba(0,0,0,0.5);
        padding-top:15%;
        font-size: 1.6em;
        height: 200px;
        line-height: 170px;
   }
    .getpwd{
        border:1px solid #ccc;
        max-width:500px;
        margin:50px auto;
        padding:40px 0;
        background:#fff;
        border-radius:10px
    }
    .inps{
        margin:20px auto 0;
        width:70%;
    }
    .intro{
        max-width:300px;
        margin:0 auto
    }
    .inps input{
        height:34px;
        margin:0 auto;
    } 
        .inps-pass input{
   }
    #sub{
        width:50%;;
        margin:0 auto;
        background-color:#484a7d;
        color:#fff;
    }
        .field-member-verifycodeimage img{
       height:34px;         
   }
        
DOF;
$this->registerCss($css);
