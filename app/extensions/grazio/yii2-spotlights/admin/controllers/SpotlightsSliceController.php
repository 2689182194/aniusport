<?php

namespace grazio\spotlights\admin\controllers;

use app\components\Hash;
use Yii;
use grazio\core\components\AdminController;
use grazio\spotlights\models\SpotlightsSlice;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii2tech\ar\softdelete\SoftDeleteBehavior;

/**
 * Default controller for the `spotlights` module
 */
class SpotlightsSliceController extends AdminController
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all SpotlightsSlice models.
     * @return mixed
     */
    public function actionIndex($is_deleted = 0)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => SpotlightsSlice::find()->where(['is_deleted' => $is_deleted]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SpotlightsSlice model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        if($model->flag == 0){
            $result = ['name' => '隐藏', 'htmlClass' => 'label-info'];
        }else{
            $result = ['name' => '显示', 'htmlClass' => 'label-success'];
        }

        return $this->render('view', [
            'model' => $model,
            'result'=>$result,
        ]);
    }

    /**
     * Creates a new SpotlightsSlice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SpotlightsSlice();
        $model->slice_hash_id = Hash::encryption();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'is_deleted' => 0]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing SpotlightsSlice model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
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
     * Deletes an existing SpotlightsSlice model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {

        $model = $this->findModel($id);
        $model->on(SoftDeleteBehavior::EVENT_BEFORE_SOFT_DELETE, function ($event) {
            $event->isValid = true;
        });
        $model->softDelete();
        \Yii::$app->getSession()->setFlash('success', "删除成功！");

        return $this->redirect(['index', 'is_deleted' => 0]);

    }

    /**
     * 数据回收
     * @param $id
     * @return \yii\web\Response
     */
    public function actionRestore($id)
    {
        $model = $this->findModel($id);
        $model->restore();
        Yii::$app->getSession()->setFlash('回收成功');
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
        if (($model = SpotlightsSlice::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
