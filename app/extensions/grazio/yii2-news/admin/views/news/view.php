<?php

use yii\helpers\Html;
use grazio\adminlte\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Slide */

$this->title = '志愿动态详情';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '志愿动态'), 'url' => ['index', 'is_deleted' => 0]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="slide-view">

    <p>
        <?= Html::a(Yii::t('app', '修改'), ['update', 'id' => $model->news_id], ['class' => 'btn btn-success']) ?>

        <?= $model->is_deleted == 0 ? Html::a(Yii::t('app', '删除'), ['delete', 'id' => $model->news_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', '你确定要删除吗?'),
                'method' => 'post',
            ],
        ]) : Html::a(Yii::t('app', '恢复'), ['restore', 'id' => $model->news_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', '你确定要恢复吗?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'news_id',
            'title',
            [
                'attribute' => 'category_id',
                'value' => function ($dataProvider) {
                    return !empty($dataProvider->category) ? $dataProvider->category->category_name : '';
                }
            ],
            [
                'label' => '内容',
                'value' => function ($model) {
                    if ($model->content) {

                        $result = mb_strlen(strip_tags(str_replace('&nbsp;', '', $model->content->content), 'UTF8'));
                        if ($result >= 80) {

                            return mb_substr(strip_tags(str_replace('&nbsp;', '', $model->content->content)), 0, 80, 'utf8') . '……';
                        } else {

                            return strip_tags(str_replace('&nbsp;', '', $model->content->content));
                        }
                    } else {
                        return '';
                    }

                }
            ],
            [
                'attribute' => 'created_by',
                'value' => function ($model) {
                    return !empty($model->admin) ? $model->admin->username : '';
                }
            ],
            [
                'attribute' => 'updated_by',
                'value' => function ($model) {
                    return !empty($model->updateAdmin) ? $model->updateAdmin->username : '';
                }
            ],
            'created_at:date',
            'updated_at:date'
        ],
    ]) ?>

</div>
