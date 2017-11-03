<?php

use yii\helpers\Html;

$this->title = '常见问题';
?>

<div class="container-fluid">
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="#">当前位置：首页</a></li>
            <li class="active">志愿项目</li>
        </ol>
        <div class="help-main">
            <!--            <div class="text-center">
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">全部</a></li>
                                <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">项目</a></li>
                                <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">项目</a></li>
                                <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">项目</a></li>
                            </ul>
                        </div>-->
            <div class="tab-content help-main-text">
                <div role="tabpanel" class="tab-pane active" id="home">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingOne">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        <span class="text-center">1</span>如何成为首都图书馆文化志愿者？
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">
                                    <p>1自愿报名；2成功注册“志愿北京”并加入首图团体（志愿北京登录：http://www.bv2008.cn/)；3参加基础培训并通过志愿者考核；4正式成为首都图书馆文化志愿者。</p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingTwo">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        <span class="text-center">2</span>志愿者服务流程是什么？
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                <div class="panel-body">
                                    <a href="http://stzyz.clcn.net.cn/train/view?id=32">http://stzyz.clcn.net.cn/train/view?id=32</a>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingThree">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        <span class="text-center">3</span>未满18岁的未成年人能否报名成为首图文化志愿者？
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                <div class="panel-body">
                                    <p>根据《北京市志愿者管理办法(试行)》，申请成为注册志愿者需具备以下基本条件：1热心社会公益事业，具有“奉献、友爱、互助、进步”的志愿服务精神；2年满十四周岁以上(14至18周岁还需监护人同意）；3特殊岗位有未满14周岁的未成年人参与志愿服务，建议由监护人陪同参与志愿服务；4具备参加志愿服务所需要的基本能力和身体素质；5品行端正，遵守国家法律法规和志愿者组织的相关规定；</p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="heading4">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                        <span class="text-center">4</span>在首都图书馆做志愿需要参加面试吗？
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading4">
                                <div class="panel-body">
                                    <p>申请成为志愿者不需参加面试。但具体报名参加志愿项目时，志愿项目需要对志愿者有技能或才艺要求，这时候就需要面试。</p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="heading5">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse5" aria-expanded="false" aria-controls="collapse5">
                                        <span class="text-center">5</span>成为首图文化志愿者有什么义务？
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse5" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading5">
                                <div class="panel-body">
                                    <p>1服从志愿工作组织安排；2熟练掌握志愿岗位工作技能和相关知识；3认真履行志愿工作，预约成功，不爽约；4在从事志愿服务过程中，爱岗敬业，不离岗、不串岗，不与读者和工作人员发生冲突；5如实做好志愿服务时长记录工作。</p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="heading6">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse6" aria-expanded="false" aria-controls="collapse6">
                                        <span class="text-center">6</span>我想参加首图的志愿者活动，我看一般都是的大中学生，我是42岁的中年人，原来一直教书，现在赋闲在家，不知道适合不适合？
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse6" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading6">
                                <div class="panel-body">
                                    <p>没问题，我们欢迎身体健康，能够乐于助人的所有人士。如果您方便可以直接去首图A座一层的志愿者之家现场报名。</p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="heading7">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse7" aria-expanded="false" aria-controls="collapse7">
                                        <span class="text-center">7</span>像我这个年龄（42岁）的志愿者参加活动一般都去做什么？
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse7" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading7">
                                <div class="panel-body">
                                    <p>您可以做自助借还书、图书交换、心阅书香等。如果有时间请您去现场咨询下志愿者管理老师。</p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="heading8">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse8" aria-expanded="false" aria-controls="collapse8">
                                        <span class="text-center">8</span>去参加志愿服务需要准备什么？身份证？
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse8" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading8">
                                <div class="panel-body">
                                    <p>需要填写报名表，可以现场咨询志愿者管理老师。</p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="heading9">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse9" aria-expanded="false" aria-controls="collapse9">
                                        <span class="text-center">9</span>老师你好，寒暑假有安排志愿服务吗？什么时间去合适呢？
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse9" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading9">
                                <div class="panel-body">
                                    <p>请咨询联系电话：67358115转1204。</p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="heading10">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse10" aria-expanded="false" aria-controls="collapse10">
                                        <span class="text-center">10</span>您好我想问一下周六可以去首图做志愿么？
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse10" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading10">
                                <div class="panel-body">
                                    <p>可以，要先参加基础培训，之后进行服务预约。</p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="heading011">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse011" aria-expanded="false" aria-controls="collapse011">
                                        <span class="text-center">11</span>是在网上报名么？我看网上有很多报名的项目，我之前也没去过志愿服务也不知道。
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse011" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading011">
                                <div class="panel-body">
                                    <p>您需要先填表报名，请到群文件中下载首图志愿者报名表，填写完成后发到邮箱：whzyfe@clcn.net.cn；等待志愿者管理老师审核后，电话通知大家面试培训事项。</p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="heading11">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse11" aria-expanded="false" aria-controls="collapse11">
                                        <span class="text-center">12</span>老师，您好，我们想预约图书馆的志愿服务是必须先招固定的志愿者，然后报名，上交给老师之后然后才能预约活动吗？
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse11" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading11">
                                <div class="panel-body">
                                    <p>请先报名首图文化志愿者，填写报名表，填写完成后发到邮箱：whzyfe@clcn.net.cn，审核通过，并参加培训后才能预约志愿服务活动。</p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="heading12">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse12" aria-expanded="false" aria-controls="collapse12">
                                        <span class="text-center">13</span>由于我没有参加过读书会活动，所以，想向您请教一下，志愿者在读书会中主要负责什么？
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse12" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading12">
                                <div class="panel-body">
                                    <p>是对志愿者的奖励，可以参加首图讲坛的活动。</p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="heading13">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse13" aria-expanded="false" aria-controls="collapse13">
                                        <span class="text-center">14</span>老师您好，我是刚刚从加拿大回来的留学生，之前在首图做过志愿者，想问问最近有什么项目可以参加吗？
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse13" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading13">
                                <div class="panel-body">
                                    <p>请咨询联系电话：67358115转1204。 </p> 
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="heading14">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse14" aria-expanded="false" aria-controls="collapse14">
                                        <span class="text-center">15</span>首都图书馆文化志愿者在首都图书馆可享哪些福利？</p>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse14" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading14">
                                <div class="panel-body">
                                    <p>1全天服务的志愿者提供工作午餐；2定期组织志愿者沙龙、座谈和交流分享会；3组织志愿者参与首图特色活动；4获得“志愿北京”志愿服务时长；5年度总结表彰和评优。</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="profile">

                </div>
                <div role="tabpanel" class="tab-pane" id="messages">

                </div>
                <div role="tabpanel" class="tab-pane" id="settings">

                </div>
            </div>
            <!--            <nav class="text-center">
                            <ul class="pagination">
                                <li>
                                    <a href="#" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <li><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#">5</a></li>
                                <li>
                                    <a href="#" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>-->
        </div>
    </div>
</div>
