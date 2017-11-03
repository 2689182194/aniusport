<?php

use yii\helpers\Html;
use grazio\adminlte\widgets\grid\GridView;
use grazio\news\models\NewsCategory;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '志愿动态';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="form-horizontal about-honor-index spotlights-group-index">

    <p>
        <?= Html::a(' 添 加 ', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('回收数据列表', ['index?is_deleted=1'], ['class' => 'btn btn-success resore_all']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'category_id',
            'category_name',
            'category_desc',
            [
                'class' => '\grazio\adminlte\widgets\StatusColumn',
                'status' => NewsCategory::status(),
                'attribute' => 'status'
            ],
            [
                'attribute' => 'created_by',
                'value' => function ($model) {
                    return !empty($model->admin) ? $model->admin->username : '';
                }
            ],
            [
                'attribute' => 'updated_by',
                'value' => function ($model) {
                    return !empty($model->updateAdmin) ? $model->updateAdmin->username : '';
                }
            ],
            'created_at:date',
            [
                'header' => '操作',
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{view}',
                'headerOptions' => ['width' => '50'],
            ],
        ],
    ]); ?>
</div>
