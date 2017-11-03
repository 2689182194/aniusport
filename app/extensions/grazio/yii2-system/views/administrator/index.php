<?php

use grazio\adminlte\widgets\grid\GridView;
use yii2tech\admin\grid\ActionColumn;
use yii\helpers\ArrayHelper;
use yii2tech\admin\grid\DeleteStatusColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\models\backend\AdminSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('admin', 'Administrators');
$this->params['breadcrumbs'][] = $this->title;
$this->params['contextMenuItems'] = [
    ['create']
];

?>

<?= GridView::widget([
    'boxOptions' => ['header' => '管理员'],
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        'id',
        'username',
        'email:email',
        [
            'class' => DeleteStatusColumn::className(),
            'attribute' => 'status_id',
            'filter' => ArrayHelper::map(\grazio\system\models\Identity::statusList(), 'id', 'name'),
            'value' => function ($data) {
                return $data->status;
            },
        ],
        [
            'attribute' => 'created_at',
            'format' => 'date',
            'filter' => false,
        ],
        [
            'attribute' => 'updated_at',
            'format' => 'date',
            'filter' => false,
        ],

        ['class' => ActionColumn::className()],
    ],
]); ?>
