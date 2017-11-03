<?php
/**
 * Created by PhpStorm.
 * User: Miinno-10
 * Date: 2017/5/2
 * Time: 10:58
 */

namespace grazio\news\admin\controllers;

use grazio\news\models\News;
use Yii;
use grazio\core\components\AdminController;
use yii2tech\ar\softdelete\SoftDeleteBehavior;
use grazio\news\models\NewsCategory;
use yii\data\ActiveDataProvider;

class CategoryController extends AdminController
{
    /**
     * 新闻分类列表展示
     * @return string
     */
    public function actionIndex($is_deleted = 0)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => NewsCategory::find()->where(['is_deleted' => $is_deleted]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 新闻分类添加
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {

        $model = new NewsCategory();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect(['index', 'is_deleted' => 0]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * 新闻分类编辑
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect(['index', 'is_deleted' => 0]);

        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }

    }
    /**
     * Displays a single Slide model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $model = $this->findModel($id);
        if($model->status == 'DRAFT'){
            $result = ['name' => '草稿', 'htmlClass' => 'label-info'];
        }else{
            $result = ['name' => '发表', 'htmlClass' => 'label-success'];
        }

        return $this->render('view', [
            'model' => $model,
            'result'=>$result,
        ]);
    }

    /**
     * 新闻分类删除
     * @param $id
     * @return \yii\web\Response
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        //查找该分类下是否存在内容，存在则不允许删除，不存在则允许删除
        $news = News::find()->where(['category_id' => $id])->all();
        if (!empty($news)) {
            echo "<script>alert('此分类下存在内容，请先删除内容');location.href='index?is_deleted=0'</script>";
            die;
        }

        $model->on(SoftDeleteBehavior::EVENT_BEFORE_SOFT_DELETE, function ($event) {
            $event->isValid = true;
        });
        $model->softDelete();

        return $this->redirect(['index', 'is_deleted' => 0]);
    }

    /**
     * 新闻分类回收
     * @param $id
     * @return \yii\web\Response
     */
    public function actionRestore($id)
    {

        $model = $this->findModel($id);
        $model->on(SoftDeleteBehavior::EVENT_BEFORE_RESTORE, function ($event) {
            $event->isValid = true;
        });
        $model->restore();
        return $this->redirect(['index', 'is_deleted' => 1]);
    }

    /**
     * Finds the SpotlightsSlice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return SpotlightsSlice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = NewsCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}