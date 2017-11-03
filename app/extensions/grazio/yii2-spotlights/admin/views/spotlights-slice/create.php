<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\spotlights\models\SpotlightsSlice */

$this->title = '添加焦点图';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '焦点图'), 'url' => ['index', 'is_deleted' => 0]];
$this->params['breadcrumbs'][] = $this->title;
?>


<?= $this->render('_form', [
    'model' => $model,
]) ?>
