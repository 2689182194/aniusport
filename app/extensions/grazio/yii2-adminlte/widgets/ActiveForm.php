<?php
/**
 * Created by PhpStorm.
 * User: ezsky
 * Date: 2017/4/19
 * Time: 下午7:59
 */

namespace grazio\adminlte\widgets;


use yii\helpers\ArrayHelper;

class ActiveForm extends \yii\widgets\ActiveForm
{
    public $boxOptions = false;
    public $type = false;

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        $type = $this->type ? Box::TYPE_SUCCESS : Box::TYPE_PRIMARY;
        Box::begin(ArrayHelper::merge(['type' => $type], $this->boxOptions));

    }

    public function run()
    {
        parent::run(); // TODO: Change the autogenerated stub
        Box::end();
    }
}