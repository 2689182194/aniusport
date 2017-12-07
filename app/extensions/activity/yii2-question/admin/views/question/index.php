<?php

use yii\helpers\Html;
use grazio\adminlte\widgets\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel activity\question\models\QuestionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '问题列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="questions-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'phone',
            'question:ntext',
            'answer:ntext',
             'weight',
            [
            'class' => '\grazio\adminlte\widgets\StatusColumn',
            'status' => \activity\question\models\Questions::status(),
            'attribute' => 'status'
        ],
        'created_at:datetime',
        // 'updated_at',
            [
                'header' => '操作',
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{view}{audit}',
                'headerOptions' => ['width' => 100],
                'buttons' => [
                    'audit' => function ($url, $model) {
                        return '&nbsp;&nbsp;' . Html::a('', ['send', 'id' => $model->id], ['class' => 'glyphicon glyphicon-envelope', 'style' => 'cursor:pointer']);
                    }
                ]
            ],

        ],
    ]); ?>
</div>
