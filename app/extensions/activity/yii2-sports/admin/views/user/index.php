<?php

use yii\helpers\Html;
use grazio\adminlte\widgets\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel activity\sports\admin\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '注册用户';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sports-user-index">
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'nickname',
            [
                'class' => '\grazio\adminlte\widgets\StatusColumn',
                'status' => \activity\sports\models\SportsUser::status(),
                'attribute' => 'gender'
            ],
            [
                'label' => '图像',
                'format' => 'Html',
                'value' => function ($model) {
                    return Html::img($model->avatarUrl, ['width' => 80]);
                }
            ],
            // 'avatarUrl:ntext',
            // 'country',
            // 'province',
            // 'ip',
            // 'city',
             'badge',
             'scores',
             'created_at:datetime',
             'updated_at:datetime',

        ],
    ]); ?>
</div>
