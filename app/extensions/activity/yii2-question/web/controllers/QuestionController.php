<?php
/**
 * Created by PhpStorm.
 * User: Miinno-10
 * Date: 2017/12/5
 * Time: 14:44
 */

namespace activity\question\web\controllers;

use activity\question\models\Questions;
use yii\rest\Controller;
use Yii;

class QuestionController extends Controller
{
    /**
     * 提交问题接口
     * @return array
     */
    public function actionCreate()
    {
        //接收值
        $request = Yii::$app->request;
        $model = new Questions();
        if ($request->isGet) {
            if ($model->load($request->get(), '') && $model->save()) {
                $result = [
                    'code' => 0,
                    'desc' => '添加成功',
                ];
            } else {
                $result = [
                    'code' => 1,
                    'desc' => $model->getErrors(),
                ];
            }
        } else {
            $result = [
                'code' => 1,
                'desc' => '请求方式错误',
            ];
        }

        return $result;
    }

    /**
     * 问题列表接口
     * @return array|\yii\db\ActiveRecord[]
     */
    public function actionIndex()
    {
        $data = Questions::find()->where(['<>', 'answer', ''])->andWhere(['status' => Questions::STATUS_SHOW])->all();
        return $data;
    }
}