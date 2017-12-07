<?php

use yii\helpers\Html;
use grazio\adminlte\widgets\grid\GridView;
use grazio\image\helpers\ImageHelper;

/* @var $this yii\web\View */
/* @var $searchModel activity\activity\models\ActivitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '活动';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sports-activity-index">

    <p>
        <?= Html::a('添加活动', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'activity_id',
            [
                'attribute' => 'group_id',
                'value' => function ($model) {
                    return !empty($model->group) ? $model->group->group_name : '';
                }
            ],
            'activity_name',
            [
                'attribute' => 'file',
                'format' => 'Html',
                'headerOptions' => ['width' => '250'],
                'value' => function ($model) {
                    return Html::img(ImageHelper::src($model->file), ['width' =>80]);
                }
            ],

            [
                'class' => '\grazio\adminlte\widgets\StatusColumn',
                'status' => \activity\activity\models\SportsActivity::flag(),
                'attribute' => 'status',
                'header' => '是否显示'
            ],
            'start_time:datetime',
            'end_time:datetime',
            [
                'header' => '操作',
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{view}',
                'headerOptions' => ['width' => 50],
            ],
        ],
    ]); ?>
</div>
