<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\spotlights\models\SpotlightsSlice */

$this->title = '志愿动态修改';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '志愿动态'), 'url' => ['index', 'is_deleted' => 0]];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', [
    'model' => $model,
    'contentModel' => $contentModel,
    'imageModel' => $imageModel
]) ?>
