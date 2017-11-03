<?php
/**
 * Created by PhpStorm.
 * User: Miinno-10
 * Date: 2017/5/2
 * Time: 15:22
 */

namespace grazio\news\admin\controllers;

use Yii;
use grazio\core\components\AdminController;
use yii\data\ActiveDataProvider;
use grazio\news\models\News;
use grazio\news\models\NewsContent;
use grazio\news\models\NewsImage;
use yii2tech\ar\softdelete\SoftDeleteBehavior;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class NewsController extends AdminController
{
    public function actions()
    {
        return [
            'upload' => [
                'class' => 'grazio\ueditor\UEditorAction',
                'config' => [
                    "imageUrlPrefix" => Yii::getAlias('@web'),//图片访问路径前缀
                    "imagePathFormat" => "/image/{yyyy}{mm}{dd}/{time}{rand:6}" //上传保存路径
                ],
            ]
        ];
    }

    /**
     * 新闻列表展示
     * @return string
     */
    public function actionIndex($is_deleted = 0)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => News::find()
                ->where(['is_deleted' => $is_deleted])
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 新闻添加
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionCreate()
    {

        $model = new News();
        $contentModel = new NewsContent();
        $imageModel = new NewsImage();

        if ($model->load(Yii::$app->request->post())) {

            $model->publish_time = strtotime($model->publish_time);

            $imageModel->image_url = UploadedFile::getInstances($imageModel, 'image_url');

            //开启事务
            $trans = Yii::$app->db->beginTransaction();
            try {

                //新闻表数据添加
                if ($model->save()) {
                    $news_id = $model->attributes['news_id'];
                }
                //新闻内容表数据添加
                $contentModel->news_id = $news_id;
                $contentModel->load(Yii::$app->request->post());
                $contentModel->save();
                //新闻图片表数据添加
                if ($imageModel->image_url) {
                    $result = $imageModel->upload();
                    foreach ($result as $k => $v) {
                        $result[$k]['news_id'] = $news_id;
                    }
                    foreach ($result as $item) {
                        $imageModel = new NewsImage();
                        $imageModel->attributes = $item;
                        $imageModel->save();
                    }
                }
                //事务提交
                $trans->commit();
                \Yii::$app->getSession()->setFlash('success', "保存成功！");
                return $this->redirect(['index', 'is_deleted' => 0]);
                //事务回滚
            } catch (Exception $e) {
                $trans->rollBack();
                throw new NotFoundHttpException(print_r($model->errors));
            }

        } else {
            return $this->render('create', [
                'model' => $model,
                'contentModel' => $contentModel,
                'imageModel' => $imageModel
            ]);
        }
    }

    /**
     * 新闻修改
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $contentModel = $this->ContentModel($id);
        if ($contentModel === null) {
            $contentModel = new NewsContent();
        }
        $imageModel = new NewsImage();

        if ($model->load(Yii::$app->request->post())) {

            $model->publish_time = strtotime($model->publish_time);

            $imageModel->image_url = UploadedFile::getInstances($imageModel, 'image_url');

            //开启事务
            $trans = Yii::$app->db->beginTransaction();
            try {
                //新闻表数据修改
                $model->save();
                //新闻内容表数据修改
                $contentModel->news_id = $id;
                $contentModel->load(Yii::$app->request->post());
                $contentModel->save();
                //新闻图片表数据添加
                if ($imageModel->image_url) {

                    if ($this->ImageModel($id)) {
                        $this->UnlinkImage($id);
                        NewsImage::deleteAll('news_id = :news_id', [':news_id' => $id]);
                    }

                    $result = $imageModel->upload();
                    foreach ($result as $k => $v) {
                        $result[$k]['news_id'] = $id;
                    }
                    foreach ($result as $item) {
                        $imageModel = new NewsImage();
                        $imageModel->attributes = $item;
                        $imageModel->save();
                    }
                }
                //事务提交
                $trans->commit();
                \Yii::$app->getSession()->setFlash('success', "修改成功！");

                return $this->redirect(['index', 'is_deleted' => 0]);
                //事务回滚
            } catch (Exception $e) {
                $trans->rollBack();
                throw new NotFoundHttpException(print_r($model->errors));
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'contentModel' => $contentModel,
                'imageModel' => $imageModel
            ]);
        }

    }

    /**
     * Displays a single Slide model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

        $model = News::find()
            ->where(['news_id' => $id])
            ->with('content')
            ->with('category')
            ->one();

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * 新闻删除
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $contentModel = $this->ContentModel($id);

        //开启事务
        $trans = Yii::$app->db->beginTransaction();
        try {
            //新闻表数据删除
            $model->on(SoftDeleteBehavior::EVENT_BEFORE_SOFT_DELETE, function ($event) {
                $event->isValid = true;
            });
            $model->softDelete();

            //新闻内容表数据删除

            $contentModel->on(SoftDeleteBehavior::EVENT_BEFORE_SOFT_DELETE, function ($event) {
                $event->isValid = true;
            });
            $contentModel->softDelete();

            //删除新闻图片表
            $ImageResult = $this->ImageModel($id);
            if ($ImageResult) {
                NewsImage::updateAll(['is_deleted' => 1, 'deleted_at' => time(), 'deleted_by' => Yii::$app->user->id], 'news_id = :news_id', [':news_id' => $id]);
            }
            //事务提交
            $trans->commit();

            return $this->redirect(['index', 'is_deleted' => 0]);

            //事务回滚
        } catch (Exception $e) {
            $trans->rollBack();
            throw new NotFoundHttpException(print_r($model->errors));
        }

    }

    /**
     * 新闻列表内容回收
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionRestore($id)
    {

        $model = $this->findModel($id);
        $contentModel = $this->ContentModel($id);

        //开启事务
        $trans = Yii::$app->db->beginTransaction();
        try {
            //新闻表数据删除
            $model->on(SoftDeleteBehavior::EVENT_BEFORE_RESTORE, function ($event) {
                $event->isValid = true;
            });
            $model->restore();

            //新闻内容表数据删除

            $contentModel->on(SoftDeleteBehavior::EVENT_BEFORE_RESTORE, function ($event) {
                $event->isValid = true;
            });
            $contentModel->restore();
            //删除新闻图片表
            $ImageResult = $this->ImageModel($id);
            if ($ImageResult) {
                NewsImage::updateAll(['is_deleted' => 0, 'deleted_at' => 0, 'deleted_by' => 0], 'news_id = :news_id', [':news_id' => $id]);
            }
            //事务提交
            $trans->commit();

            return $this->redirect(['index', 'is_deleted' => 1]);

            //事务回滚
        } catch (Exception $e) {
            $trans->rollBack();
            throw new NotFoundHttpException(print_r($model->errors));
        }
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
        if (($model = News::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * 查找新闻对应的内容
     * @param $news_id
     * @return array|null|\yii\db\ActiveRecord
     */
    protected function ContentModel($news_id)
    {
        $contentModel = NewsContent::find()->where(['news_id' => $news_id])->one();

        return $contentModel;
    }

    /**查找新闻对应的图片
     * @param $news_id
     * @return array|\yii\db\ActiveRecord[]
     */
    protected function ImageModel($news_id)
    {
        return NewsImage::find()->where(['news_id' => $news_id])->asArray()->all();
    }

    /**
     * 删除新闻图片
     * @param $news_id
     * @return bool
     */
    protected function UnlinkImage($news_id)
    {
        $ImageData = $this->ImageModel($news_id);
        foreach ($ImageData as $k => $v) {

            if (file_exists(Yii::getAlias('@uploadsPath/news/' . $v['image_url']))) {
                unlink(Yii::getAlias('@uploadsPath/news/' . $v['image_url']));
            }

        }
        return true;
    }
}