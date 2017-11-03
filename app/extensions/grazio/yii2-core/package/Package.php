<?php
/**
 * Created by PhpStorm.
 * User: ezsky
 * Date: 2017/4/17
 * Time: 下午10:46
 */

namespace grazio\core\package;

use yii\base\Component;

abstract class Package extends Component implements PackageInterface
{
    public $name;
    public $web;
    public $api;
    public $admin;
    public $adminModuleClass;

}