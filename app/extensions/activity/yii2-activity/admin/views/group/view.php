<?php

use yii\helpers\Html;
use grazio\adminlte\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model activity\activity\models\ActivityGroup */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Activity Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activity-group-view">
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
            'group_name',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
