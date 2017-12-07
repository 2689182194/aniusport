<?php

use yii\helpers\Html;
use grazio\adminlte\widgets\DetailView;
use grazio\image\helpers\ImageHelper;

/* @var $this yii\web\View */
/* @var $model activity\activity\models\SportsActivity */

$this->title = $model->activity_id;
$this->params['breadcrumbs'][] = ['label' => 'Sports Activities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sports-activity-view">

    <p>
        <?= Html::a('修改', ['update', 'id' => $model->activity_id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->activity_id], [
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
                'attribute' => 'status',
                'format' => 'html',
                'value' => function ($model) {
                    return \activity\activity\models\SportsActivity::flag()[$model->status]['name'];
                },
            ],
            'start_time:datetime',
            'end_time:datetime',
        ],
    ]) ?>

</div>
