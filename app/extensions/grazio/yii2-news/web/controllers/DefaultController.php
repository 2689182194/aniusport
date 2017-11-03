<?php

namespace grazio\news\web\controllers;

use grazio\core\components\WebController;
use grazio\news\models\News;
use grazio\news\models\NewsCategory;
use yii\data\ActiveDataProvider;

/**
 * Default controller for the `news` module
 */
class DefaultController extends WebController
{
    /**
     * 获取所有的新闻分类
     * @return string
     */
    public function category()
    {
        $category = NewsCategory::find()->select(['category_id', 'category_name'])->orderBy('sort DESC')->where(['is_deleted' => 0])->all();

        return $category;
    }

    /**
     * 通过新闻分类取新闻列表
     * @param $category_id int 分类id
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex($category_id = 1)
    {
        $category = $this->category();

        $category_name = NewsCategory::find()->select(['category_name'])->where(['category_id'=>$category_id])->One();

        $dataProvider = new ActiveDataProvider([
            'query' => News::find()
                ->where(['is_deleted' => 0])
                ->andWhere(['status' => 'PUBLISHED'])
                ->andWhere(['category_id' => $category_id])
                ->orderBy('publish_time DESC'),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider->getModels(),
            'category' => $category,
            'category_name' => $category_name
        ]);

    }

    /**
     * 新闻详情
     * @param $news_id int 新闻id
     * @return string
     */
    public function actionView($id)
    {
        $news_id = !empty($id) ? $id : '';

        $detailData = News::find()->where(['news_id' => $news_id])->with('category')->with('content')->with('image')->one();

        $category = $this->category();

        return $this->render('view', [
            'model' => $detailData,
            'category' => $category,
        ]);
    }
}
