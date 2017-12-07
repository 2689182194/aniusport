<?php
/**
 * Created by PhpStorm.
 * User: Miinno
 * Date: 16/5/5
 * Time: 下午11:18
 */

namespace activity\sports\web\BL;

use Yii;
use activity\sports\models\SportsConfig;
use yii\base\Object;

class Lottery extends Object
{
    /**
     * 抽奖翻牌子
     * @return mixed
     */
    static public function run()
    {
        $_prize_arr = Yii::$app->cache->get('config');
        if ($_prize_arr == false) {
            $_prize_arr = SportsConfig::find()->select(['id','praisename','praisecontent','praiseimage','chance'])
                ->asArray()->all();
            Yii::$app->cache->set('config', $_prize_arr, 3600 * 24);
        }

        foreach ($_prize_arr as $key => $val) {
            $arr[$val['id']] = $val['chance'];
        }
        //根据概率获取奖项id
        $rid = self::getRand($arr);
        $res['yes'] = self::getBad($rid); //中奖项
        foreach($_prize_arr as $key => $value ) {
            if($rid == $value['id']){
                unset($_prize_arr[$key]);
            }
            $url = Yii::getAlias('@uploadsUrl/'.$value['praiseimage']);
            $_prize_arr[$key]['praiseimage'] = Yii::$app->urlManager->hostInfo.$url;
            unset($_prize_arr[$key]['chance']);
        }
        shuffle($_prize_arr); //打乱数组顺序
        $res['no'] = $_prize_arr;

        return $res;
    }

    /**
     * 计算中奖概率
     * @param $proArr
     * @return int|string
     */
    static private function getRand($proArr)
    {
        $result = '';

        //概率数组的总概率精度
        $proSum = array_sum($proArr);

        //概率数组循环
        foreach ($proArr as $key => $proCur) {
            $randNum = mt_rand(1, $proSum);
            if ($randNum <= $proCur) {
                $result = $key;
                break;
            } else {
                $proSum -= $proCur;
            }
        }
        unset ($proArr);

        return $result;
    }

    /**
     * 获取奖品详情
     * @param $id
     * @return array
     */
    static public function getBad($id)
    {
        $model = Yii::$app->cache->get('bad');

        if ($model == false) {
            $model = SportsConfig::findOne($id);
            Yii::$app->cache->set('bad', $model, 3600);
        }

        return $model->toArray();
    }
}