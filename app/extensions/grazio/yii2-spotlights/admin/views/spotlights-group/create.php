<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\spotlights\models\SpotlightsGroup */

$this->title = '添加焦点图分组';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '焦点图分组'), 'url' => ['index', 'is_deleted' => 0]];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>
