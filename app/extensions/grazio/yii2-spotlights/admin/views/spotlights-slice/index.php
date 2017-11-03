<?php

use yii\helpers\Html;
use grazio\adminlte\widgets\grid\GridView;
use grazio\spotlights\models\SpotlightsSlice;
use grazio\image\helpers\ImageHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '焦点图';
$this->params['breadcrumbs'][] = $this->title;
?>

    <div class="form-horizontal spotlights-slice-index">
        <p>
            <?= Html::a(' 添 加 ', ['create'], ['class' => 'btn btn-success']) ?>
            <?= Html::a('回收数据列表', ['index?is_deleted=1'], ['class' => 'btn btn-success']) ?>
        </p>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'title',
                [
                    'class' => '\grazio\adminlte\widgets\StatusColumn',
                    'status' => SpotlightsSlice::status(),
                    'attribute' => 'status'
                ],
                [
                    'attribute' => 'group_id',
                    'value' => function ($model) {
                        return !empty($model->group) ? $model->group->name : '';
                    }
                ],
                [
                    'attribute' => 'banner',
                    'format' => 'Html',
                    'headerOptions' => ['width' => '250'],
                    'value' => function ($model) {
                        return Html::img(ImageHelper::src($model->banner), ['width' =>80]);
                    }
                ],
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
                    'status' => SpotlightsSlice::flag(),
                    'attribute' => 'flag',
                    'header' => '是否显示'
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

