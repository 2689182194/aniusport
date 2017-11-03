<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel grazio\gos\models\MeidaItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Media Item Models';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="media-item-model-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Media Item Model', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'description:ntext',
            'file_extension',
            'file_version',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
