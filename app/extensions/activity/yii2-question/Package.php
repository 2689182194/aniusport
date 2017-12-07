<?php
/**
 * Created by PhpStorm.
 * User: ezsky
 * Date: 2017/7/19
 * Time: 下午10:24
 */

namespace activity\question;

class Package extends \grazio\core\package\Package
{

    public $name = 'question';

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