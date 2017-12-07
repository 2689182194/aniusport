<?php

use yii\helpers\Html;
use grazio\adminlte\widgets\DetailView;
use grazio\image\helpers\ImageHelper;
/* @var $this yii\web\View */
/* @var $model app\models\Slide */

$this->title = '焦点图详情';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '焦点图'), 'url' => ['index', 'is_deleted' => 0]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="slide-view">
    <p>
        <?= Html::a(Yii::t('app', '修改'), ['update', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
        <?= $model->is_deleted == 0 ? Html::a(Yii::t('app', '删除'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', '你确定要删除吗?'),
                'method' => 'post',
            ],
        ]) : Html::a(Yii::t('app', '恢复'), ['restore', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', '你确定要恢复吗?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'title',
            [
                'attribute' => 'group_id',
                'value' => function ($model) {
                    return !empty($model->group) ? $model->group->name : '';
                }
            ],
            [
                'label' => '焦点图',
                'format' => 'Html',
                'headerOptions' => ['width' => '250'],
                'value' => function ($model) {
                    return Html::img(ImageHelper::src($model->banner), ['width' =>80]);
                }
            ],
            [
                'value' => "<span class='label " . $result['htmlClass'] . "'>" . $result['name'] . "</span>",
                'attribute' => 'flag',
                'format' => 'html',
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
            'updated_at:date'
        ],
    ]) ?>

</div>
