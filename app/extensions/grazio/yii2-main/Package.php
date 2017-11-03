<?php
/**
 * Created by PhpStorm.
 * User: ezsky
 * Date: 2017/4/17
 * Time: 下午10:24
 */

namespace grazio\main;

class Package extends \grazio\core\package\Package
{
    public $name = 'main';

    public function getWebModule()
    {
        return [
            $this->name => [
                'class' => Module::className()
            ],
        ];

    }

    public function getAdminModule()
    {
        return false;
    }

    public function getApiModule()
    {
        return false;
    }

}