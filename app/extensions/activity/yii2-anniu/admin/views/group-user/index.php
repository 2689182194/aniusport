<?php

use yii\helpers\Html;
use grazio\adminlte\widgets\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel activity\anniu\modelsGroupUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-user-index">


    <p>
        <?= Html::a('添加用户', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

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
            [
                'header' => '操作',
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{view}',
                'headerOptions' => ['width' => 50],
            ],
        ],
    ]); ?>
</div>
