<?php

use yii\helpers\Html;
use grazio\adminlte\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model activity\anniu\models\GroupUser */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Group Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-user-view">

    <p>
        <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '你确定要删除吗?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [

                'label' => '组名',
                'format' => 'html',
                'value' => function ($model) {
                    if (!$model->group) {
                        return;
                    }
                    return $model->group->group_name;
                }
            ],

            [

                'label' => '用户',
                'format' => 'html',
                'value' => function ($model) {
                    if (!$model->user) {
                        return;
                    }
                    return $model->user->username;
                }
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
