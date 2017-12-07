<?php

namespace activity\sports\admin\controllers;

use Yii;
use activity\sports\models\SportsSign;
use activity\sports\admin\models\SignSearch;
use grazio\core\components\AdminController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SignController implements the CRUD actions for SportsSign model.
 */
class SignController extends AdminController
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
     * Lists all SportsSign models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SignSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
