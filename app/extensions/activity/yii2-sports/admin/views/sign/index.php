<?php

use yii\helpers\Html;
use grazio\adminlte\widgets\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel activity\sports\admin\models\SignSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '打卡签到历史';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sports-sign-index">

    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'sign_id',
            [
                'attribute' => 'sign_user',
                'value' => function ($model) {
                    return !empty($model->user) ? $model->user->nickname : '';
                }
            ],
            'sign_time:datetime',
            'sign_day',
        ],
    ]); ?>
</div>
