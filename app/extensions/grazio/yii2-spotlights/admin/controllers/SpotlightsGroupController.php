<?php

namespace grazio\spotlights\admin\controllers;

use app\components\Hash;
use Yii;
use grazio\core\components\AdminController;
use grazio\spotlights\models\SpotlightsGroup;
use grazio\spotlights\models\SpotlightsSlice;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii2tech\ar\softdelete\SoftDeleteBehavior;

/**
 * Default controller for the `spotlights` module
 */
class SpotlightsGroupController extends AdminController
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
     * Lists all SpotlightsGroup models.
     * @return mixed
     */
    public function actionIndex($is_deleted = 0)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => SpotlightsGroup::find()->where(['is_deleted' => $is_deleted]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Creates a new SpotlightsGroup model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SpotlightsGroup();
        $model->group_hash_id = Hash::encryption();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('success', "添加成功！");
            return $this->redirect(['index', 'is_deleted' => 0]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing SpotlightsGroup model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('修改成功');
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
     * Deletes an existing SpotlightsGroup model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        //查找该分类下是否存在内容，存在则不允许删除，不存在则允许删除
        $spolit = SpotlightsSlice::find()->where(['group_id' => $id])->andWhere(['is_deleted' => 0])->all();
        if (!empty($spolit)) {
            echo "<script>alert('此分类下存在内容，请先删除内容');location.href='index?is_deleted=0'</script>";
            die;
        }
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
     * Finds the SpotlightsGroup model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SpotlightsGroup the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SpotlightsGroup::find()->where(['group_id' => $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
