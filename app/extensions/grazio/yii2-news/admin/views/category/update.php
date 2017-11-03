<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\spotlights\models\SpotlightsGroup */

$this->title = '志愿动态分类修改';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '志愿动态'), 'url' => ['index', 'is_deleted' => 0]];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>
