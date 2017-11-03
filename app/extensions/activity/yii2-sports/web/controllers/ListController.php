<?php
/**
 * Created by PhpStorm.
 * User: Miinno-10
 * Date: 2017/9/4
 * Time: 11:40
 */

namespace activity\anniu\web\controllers;

use yii\web\Controller;
use activity\anniu\models\GroupUser;
use activity\anniu\models\Group;
use yii\helpers\Json;

class ListController extends Controller
{
    /**
     * 问诊阶段用户查询
     * @return string
     */
    public function actionIndex()
    {
        $group = Group::find()->asArray()->all();
        foreach ($group as $k => $v) {
            $group[$k]['user_list'] = GroupUser::find()->where(['group_id' => $v['group_id']])->with('user')->asArray()->all();
        }

        return Json::encode($group);
    }

    /**
     * 奖项配置中奖的概率一级中奖等级配置
     */
    public function actionCeshi()
    {
        $prize_arr = array(
            '0' => array('id' => 1, 'prize' => '平板电脑', 'v' => 1),
            '1' => array('id' => 2, 'prize' => '数码相机', 'v' => 5),
            '2' => array('id' => 3, 'prize' => '音箱设备', 'v' => 10),
            '3' => array('id' => 4, 'prize' => '4G优盘', 'v' => 12),
            '4' => array('id' => 5, 'prize' => '10Q币', 'v' => 22),
            '5' => array('id' => 6, 'prize' => '下次没准就能中哦', 'v' => 50),
        );
        foreach ($prize_arr as $key => $val) {
            $arr[$val['id']] = $val['v'];
         /*   $arr = Array
            (
                [1] => 1,
                [2] => 5,
                [3] => 10,
                [4] => 12,
                [5] => 22,
                [6] => 50,
            );*/
        }

        $rid = $this->Lists($arr); //根据概率获取奖项id
        $res['yes'] = $prize_arr[$rid - 1]['prize']; //中奖项
        unset($prize_arr[$rid - 1]); //将中奖项从数组中剔除，剩下未中奖项
        shuffle($prize_arr); //打乱数组顺序
        for ($i = 0; $i < count($prize_arr); $i++) {
            $pr[] = $prize_arr[$i]['prize'];
        }
        $res['no'] = $pr;   // 除了中奖外的其他数据
        \X::result($res);die;
        echo json_encode($res);
    }


    /**
     * 随机算法 计算中奖率
     *
     * @param array 需要随机的一维数组
     *              ['10', '20', '30']
     *
     * @return str 返回数组中的一个值
     *             10
     */
    public function Lists($pro_arr)
    {
        /*      $pro_arr = Array
              (
                  [0] => 10,
                  [1] => 20,
                  [2] => 30,
              );*/
        $result = '';
        // 概率数组的总概率精度
        $pro_sum = array_sum($pro_arr);//60

        // 概率数组循环
        foreach ($pro_arr as $key => $pro_cur) {
            $rand_num = mt_rand(1, $pro_sum);//生成1-60的随机数，mt_rand(min,max)

            if ($rand_num <= $pro_cur) {//如果生成的随机数小于等于10,20,30的值
                $result = $key;//则result等于0,1,2的key值
                break;
            } else {
                $pro_sum -= $pro_cur;//60-=10,20,30
            }
        }

        unset ($pro_arr);
        return $result;
    }
}