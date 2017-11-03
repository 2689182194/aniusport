<?php
/**
 * Created by PhpStorm.
 * User: ezsky
 * Date: 2017/7/19
 * Time: 下午10:24
 */

namespace activity\anniu;

class Package extends \grazio\core\package\Package
{

    public $name = 'anniu';

    public function getWebModule()
    {
        return [
            $this->name => [
                'class' => Module::className()
            ],
        ];
    }

    public  function getAdminModule()
    {
        return [
            $this->name => [
                'class' => Admin::className()
            ],
        ];
    }

    public function getApiModule()
    {
        return false;
    }

}