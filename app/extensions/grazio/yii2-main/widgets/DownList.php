<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/8/14
 * Time: 13:07
 */
namespace grazio\main\widgets;

use Yii;
use yii\base\Widget;
use clcnst\resources\models\SourceContentModel;

class DownList extends Widget
{
    public function run()
    {
        parent::run();
        $resources = SourceContentModel::find()->limit(11)->all();

        return $resources;
    }
}