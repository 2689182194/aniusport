<?php
/**
 * Created by PhpStorm.
 * User: ezsky
 * Date: 2017/4/17
 * Time: 下午10:24
 */

namespace grazio\seo;

class Package extends \grazio\core\package\Package
{
    public $name = 'seo';

    public function getWebModule()
    {
        return false;
    }

    public  function getAdminModule()
    {
        return [
            $this->name => [
                'class' => Module::className()
            ],
        ];
    }

    public function getApiModule()
    {
        return false;
    }

}