<?php
/**
 * Created by PhpStorm.
 * User: ezsky
 * Date: 2017/5/3
 * Time: 上午10:14
 */

namespace grazio\system\actions;


use yii\base\Action;
use Yii;
use grazio\system\models\LoginForm;

class LoginAction extends Action
{
    /**
     * @var string name of the view, which should be rendered
     */
    public $view = 'login';

    public function run()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->controller->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->controller->goBack();
        } else {
            return $this->controller->render($this->view,  [
                'model' => $model,
            ]);
        }
    }
}