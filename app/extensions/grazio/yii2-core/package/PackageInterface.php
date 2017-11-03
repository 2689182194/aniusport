<?php

/**
 * Created by PhpStorm.
 * User: ezsky
 * Date: 2017/4/17
 * Time: 下午10:16
 */

namespace grazio\core\package;

interface PackageInterface
{
    public function getWebModule();

    public function getApiModule();

    public function getAdminModule();

}