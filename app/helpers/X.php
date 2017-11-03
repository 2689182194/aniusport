<?php

use yii\helpers\Html;

/**
 * Created by PhpStorm.
 * User: ezsky
 * Date: 15/5/6
 * Time: 上午2:28
 */
class X
{
    /**
     * Function to format array or object use nested style
     */
    static function result($msg, $exit = 0 ,$title = '')
    {
        echo '<div class="resultMsg">';
        if ($title != '') {
            echo '<strong>' . $title . '</strong><br />';
        }
        if (is_array($msg) || is_object($msg)) {
            echo "<div><pre>";
            print_r($msg);
            echo "</pre></div>";
        } else {
            echo "<div>{$msg}</div>";
        }
        echo '</div>';

        if ($exit){
            exit;
        }
    }

    /**
     * web site title generator
     * @param mixed $text
     * @param string $separator default '_'
     * @return string Returns a string in reverse order
     */

    static function title($text, $separator = '_')
    {
        $str = '';

        if (is_array($text)) {
            $str .= implode($separator, $text) . $separator;
        }

        if (is_string($text) && !empty($text)) {
            $str .= $text . $separator;
        }

        return Html::encode($str . Yii::$app->name);

    }

    /**
     * gets list of name of directories inside a directory
     */
    static function getDirListAsArray($dirname)
    {
        $ignored = array('cvs', '_darcs', '.svn','__MACXOS');
        $list = array();

        if (substr($dirname, -1) != '/') {
            $dirname .= '/';
        }

        if ($handle = opendir($dirname)) {
            while ($file = readdir($handle)) {
                if (substr($file, 0, 1) == '.' || in_array(strtolower($file), $ignored)) continue;
                if (is_dir($dirname . $file)) {
                    $list[$file] = $file;
                }
            }
            closedir($handle);
            asort($list);
            reset($list);
        }
        return $list;
    }

    /**************************************************************
     *
     *  使用特定function对数组中所有元素做处理
     *  @param  string  &$array     要处理的字符串
     *  @param  string  $function   要执行的函数
     *  @return boolean $apply_to_keys_also     是否也应用到key上
     *  @access public
     *
     *************************************************************/
    static public function arrayRecursive(&$array, $function, $apply_to_keys_also = false)
    {
        static $recursive_counter = 0;
        if (++$recursive_counter > 1000) {
            die('possible deep recursion attack');
        }
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                self::arrayRecursive($array[$key], $function, $apply_to_keys_also);
            } else {
                $array[$key] = $function($value);
            }

            if ($apply_to_keys_also && is_string($key)) {
                $new_key = $function($key);
                if ($new_key != $key) {
                    $array[$new_key] = $array[$key];
                    unset($array[$key]);
                }
            }
        }
        $recursive_counter--;
    }

    /**************************************************************
     *
     *  将数组转换为JSON字符串（兼容中文）
     *  @param  array   $array      要转换的数组
     *  @return string      转换得到的json字符串
     *  @access public
     *
     *************************************************************/
    static public function encodeJSON($array) {
        self::arrayRecursive($array, 'urlencode', true);
        $json = json_encode($array);
        return urldecode($json);
    }

}