<div class="crowd-order">
    <input type="hidden" name="way" value="" />
    <div class="way text-center">
        出错了！⊙﹏⊙，<span id='secs'></span>秒后将进入<a href='<?= \yii\helpers\Url::to(['/main/default/index']) ?>'> 志愿者首页</a>；
    </div>
</div>

<?php

$url = \yii\helpers\Url::to(['/main/default/index']);
$background = Yii::getAlias('@web/images/false.png');

$css = <<<DOF
        body {
            background-color: #F0F0F0;
        }

        .way{        
            line-height: 500px;
            padding-left: 110px;
            background:url({$background}) no-repeat #FFF;      
            background-size: 100px 100px;
            background-position: 350px 200px
        }
        
DOF;

$this->registerCss($css);

$js = <<<EOF
        $(document).ready(function () {
            time(5);
        });
        function time(wait) {

            if (wait == 0) {
                window.location.href = "{$url}";
            } else {
                $("#secs").html(wait);
                wait--;
                setTimeout(function () {
                    time(wait);
                },
                        1000);
            }
        }
        
EOF;

$this->registerJs($js);

