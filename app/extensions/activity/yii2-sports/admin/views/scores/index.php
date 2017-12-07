<?php

use yii\helpers\Html;
use grazio\adminlte\widgets\grid\GridView;
use activity\sports\models\SportsScores;
/* @var $this yii\web\View */
/* @var $searchModel activity\sports\models\ScoresSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '丸记录';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sports-scores-index">

    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'score_id',
            [
                'attribute' => 'user_id',
                'value' => function ($model) {
                    return !empty($model->user) ? $model->user->nickname : '';
                }
            ],
            [
                'attribute' => 'score_status',
                'format' => 'html',
                'value' => function ($model) {
                    return SportsScores::status()[$model->score_status]['status'];
                },
            ],
            [
                'attribute' => 'score_rules',
                'format' => 'html',
                'value' => function ($model) {
                    return SportsScores::status()[$model->score_rules]['name'];
                },
            ],
            'score_value',
             'score_time:datetime',
            // 'created_at',
            // 'updated_at',
        ],
    ]); ?>
</div>
