<?php
/**
 * Created by PhpStorm.
 * User: 飒雅
 * Date: 2016/10/25
 * Time: 16:27
 */
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = '新闻资讯';
?>
<!--新闻资讯-->


<?php
echo yii\widgets\ListView::widget([
    'dataProvider' => $dataProvider,
    'layout' => '{items} {pager}',
    'itemView' => '_item',//子视图
]);
?>

