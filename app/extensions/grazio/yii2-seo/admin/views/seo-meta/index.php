<?php

use yii\helpers\Html;
use grazio\adminlte\widgets\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel grazio\seo\models\SeoMetaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Seo Meta';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seo-meta-model-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Seo Meta', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'entity',
            'route',
            'title',
             'keywords:ntext',
             'description:ntext',
             'robots',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
