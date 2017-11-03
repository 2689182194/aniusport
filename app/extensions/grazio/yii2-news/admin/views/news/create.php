<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\spotlights\models\SpotlightsSlice */

$this->title = '添加志愿动态';
$this->params['breadcrumbs'][] = ['label' => '志愿动态', 'url' => ['index', 'is_deleted' => 0]];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', [
    'model' => $model,
    'contentModel' => $contentModel,
    'imageModel' => $imageModel,
]) ?>

