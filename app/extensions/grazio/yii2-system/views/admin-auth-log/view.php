<?php

use yii\bootstrap\Html;
use grazio\adminlte\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model grazio\system\models\AdminAuthLog */
/* @var $controller grazio\system\controllers\AdminAuthLogController|yii2tech\admin\behaviors\ContextModelControlBehavior */

$controller = $this->context;
$contextUrlParams = $controller->getContextQueryParams();

$this->title = $model->admin->username . ' ' . Yii::$app->formatter->asDatetime($model->date);
foreach ($controller->getContextModels() as $name => $contextModel) {
    $this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'Administrators'), 'url' => $controller->getContextUrl($name)];
    $this->params['breadcrumbs'][] = ['label' => $contextModel->username, 'url' => $controller->getContextModelUrl($name)];
}
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'Administrator Auth Logs'), 'url' => array_merge(['index'], $contextUrlParams)];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-8">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'admin_id',
                'format' => 'raw',
                'value' => Html::a(Html::encode($model->admin->username), ['/admin/view', 'id' => $model->admin->id]),
            ],
            'date:datetime',
            'cookie_based:boolean',
            'duration',
            [
                'attribute' => 'error',
                'value' => $model->error === null ? '-' : $model->error,
            ],
            'ip',
            'host',
            'url:url',
            'user_agent',
        ],
    ]) ?>
    </div>
</div>