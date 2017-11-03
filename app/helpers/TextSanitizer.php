<?php
/**
 * Created by PhpStorm.
 * User: ezsky
 * Date: 2016/11/8
 * Time: 上午12:26
 */

namespace app\helpers;


class TextSanitizer
{
    public static function ClearHtml($content)
    {
        $content = preg_replace("/<a[^>]*>/i", "", $content);
        $content = preg_replace("/<\/a>/i", "", $content);
        $content = preg_replace("/<div[^>]*>/i", "", $content);
        $content = preg_replace("/<\/div>/i", "", $content);
        $content = preg_replace("/<span[^>]*>/i", "", $content);
        $content = preg_replace("/<\/span>/i", "", $content);
        $content = preg_replace("/<!--[^>]*-->/i", "", $content);//注释内容
        $content = preg_replace("/style=.+?['|\"]/i", '', $content);//去除样式
        $content = preg_replace(" /class=.+?['|\"]/i", '', $content);//去除样式
        $content = preg_replace("/id=.+?[' | \"]/i", '', $content);//去除样式
        $content = preg_replace("/lang=.+?['|\"]/i", '', $content);//去除样式
        $content = preg_replace(" / width=.+?['|\"]/i", '', $content);//去除样式
        $content = preg_replace("/height=.+?[' | \"]/i", '', $content);//去除样式
        $content = preg_replace("/border=.+?['|\"]/i", '', $content);//去除样式
        $content = preg_replace(" / face=.+?['|\"]/i", '', $content);//去除样式
        $content = preg_replace("/face=.+?[' | \"]/", '', $content);//去除样式只允许小写正则匹配没有带 i 参数
        return $content;
    }
}