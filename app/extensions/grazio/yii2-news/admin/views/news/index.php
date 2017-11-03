<?php

use yii\helpers\Html;
use grazio\adminlte\widgets\grid\GridView;
use grazio\news\models\News;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '志愿动态';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="form-horizontal spotlights-slice-index">
    <p>
        <?= Html::a(' 添 加 ', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(' 回收数据列表 ', ['index?is_deleted=1'], ['class' => 'btn btn-success']) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "{items}\n{pager}",
        'columns' => [
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
            [
                'header' => '操作',
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{view}',
                'headerOptions' => ['width' => '50'],
            ],
        ],
    ]);
    ?>
</div>
