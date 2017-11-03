<?php
/**
 * Created by PhpStorm.
 * User: ezsky
 * Date: 2016/11/1
 * Time: 下午6:54
 */

namespace app\components;


use Yii;
use yii\base\Component;


class Aliases extends Component

{
    public $aliases = [];

    public function init()
    {
        foreach ($this->aliases as $alias => $path) {
            Yii::setAlias($alias, $path);
        }
    }
}