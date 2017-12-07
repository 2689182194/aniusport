<?php

use yii\helpers\Html;
use grazio\adminlte\widgets\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel activity\activity\models\GroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '活动分类';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activity-group-index">

    <p>
        <?= Html::a('添加活动分类', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'group_name',
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
