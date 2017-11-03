<?php

use yii\helpers\Html;
use grazio\adminlte\widgets\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel activity\anniu\models\GroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '分组管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-index">

    <p>
        <?= Html::a('添加分组', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'group_id',
            'group_name',
            'start_at:datetime',
            'end_at:datetime',
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
