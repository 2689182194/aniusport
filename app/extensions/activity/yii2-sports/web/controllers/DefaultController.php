<?php
/**
 * Created by PhpStorm.
 * User: Miinno-10
 * Date: 2017/9/1
 * Time: 11:16
 */
namespace activity\sports\web\controllers;


use activity\sports\models\SportsConfig;
use activity\sports\models\SportsSign;
use activity\sports\models\User;
use Yii;
use yii\base\Exception;
use yii\helpers\Json;
use yii\web\Controller;
use activity\sports\models\SportsUser;
use activity\sports\models\SportsLogin;
use activity\sports\models\SportsScores;

class DefaultController extends Controller
{
    public $enableCsrfValidation = false;

//    public function beforeAction($action)
//    {
//        $result = $action->id;
//        $cache = Yii::$app->cache;
//        if ($result == 'user-info') {
//            $data = Yii::$app->request->get();
//            $openId = isset($data['openid']) ? $data['openid'] : '';
//            $openId = base64_decode($openId);
//            SportsUser::Register($data, $openId);
//            // 将 $data 存放到缓存供下次使用
//            $cache->set('username', $data, 3600 * 24);
//        }
//        return parent::beforeAction($action);
//    }

    /**
     * 保留用户信息
     */
    public function actionUserInfo()
    {
        $data = Yii::$app->request->get();
        $identification = $data['identification'];
        $openId = IdentifyController::Identification($identification);
        SportsUser::Register($data, $openId);
        //判断是否是当日首次进入
        $todayBegin = strtotime(date('Y-m-d') . " 00:00:00");
        $todayEnd = strtotime(date('Y-m-d') . " 23:59:59");
        $firstLogin = SportsLogin::find()->Where(['between', 'record_time', $todayBegin, $todayEnd])->andWhere(['record_user' => $openId])->one();
        if (empty($firstLogin)) {
            $model = new SportsLogin();
            $model->record_user = $openId;
            $model->save();
        }
        $result = [
            'code' => 0,
            'firstLogin' => $firstLogin ? 1 : 0,
        ];

        return Json::encode($result);
    }

    /**
     * 用户首次进入领取固定积分
     * 0-增加
     * portsScores::STATUS_Daily -首次进入
     * @return array|string
     */
    public function actionSettlement()
    {
        $request = Yii::$app->request;
        if ($request->isGet) {
            $data = $request->get();
            $js_result = SportsScores::RecodeScores($data, SportsScores::STATUS_INCREASE, SportsScores::RULES_DAILY);
            //更新用户表中对应的用户积分
            SportsUser::UpdateScores($data, SportsScores::STATUS_INCREASE);
            if ($js_result) {
                $result = [
                    'code' => 0,
                    'desc' => '添加成功',
                ];
            } else {
                $result = [
                    'code' => 1,
                    'desc' => '添加失败',
                ];
            }

        } else {
            $result = [
                'code' => 1,
                'desc' => '请求方式错误',
            ];
        }
        $result = Json::encode($result);

        return $result;
    }


    /**
     * 判断今日是否进行签到,未签记录签到
     * @return array|string
     * @throws Exception
     */
    public function actionSign()
    {
        $request = Yii::$app->request;
        if ($request->isGet) {
            $data = $request->get();
            $identification = $data['identification'];
            $openId = IdentifyController::Identification($identification);
            //判断今日是否签到
            $todayBegin = strtotime(date('Y-m-d') . " 00:00:00");
            $todayEnd = strtotime(date('Y-m-d') . " 23:59:59");
            $firstSign = SportsSign::IsSign($todayBegin, $todayEnd, $openId);
            if (empty($firstSign)) {
                //判断昨天是否签到，记录连续签到天数
                $beforeBegin = strtotime("-1 day 00:00:00");
                $beforeEnd = strtotime("-1 day 23:59:59");
                $beforeSign = SportsSign::IsSign($beforeBegin, $beforeEnd, $openId);
                $signDay = $beforeSign ? ($beforeSign->sign_day) + 1 : 1;
                $trans = Yii::$app->db->beginTransaction();
                try {
                    //积分记录表进行签到积分记录
                    $recordScores = SportsScores::RecodeScores($data, SportsScores::STATUS_INCREASE, SportsScores::RULES_SIGN);
                    //更新用户表中对应的用户积分
                    $updateScores = SportsUser::UpdateScores($data, SportsScores::STATUS_INCREASE);
                    //签到表进行记录
                    $signRecord = SportsSign::SignRecord($openId, $signDay);
                    if ($recordScores && $updateScores && $signRecord) {
                        //事务提交
                        $trans->commit();
                        $result = [
                            'code' => 0,
                            'desc' => '签到成功',
                        ];
                    } else {
                        $result = [
                            'code' => 1,
                            'desc' => '签到失败',
                        ];
                    }
                } catch (Exception $e) {
                    $trans->rollBack();
                    throw new Exception(print_r($e->errors));
                }

            } else {
                $result = [
                    'code' => 2,
                    'desc' => '今日已经签过',
                ];
            }

        } else {
            $result = [
                'code' => 1,
                'desc' => '请求方式错误',
            ];
        }
        $result = Json::encode($result);

        return $result;
    }

    /**
     * 当月签到历史记录
     * @param string $identification 约定参数
     * @return string
     */
    public function actionSignHistory($identification = '')
    {
        $openId = IdentifyController::Identification($identification);

        $first_day = strtotime(date('Y-m-01', strtotime(date("Y-m-d"))));
        $last_day = strtotime(date('Y-m-t 00:00:00'));
        $history = SportsSign::History($first_day, $last_day, $openId);
        $result = Json::encode($history);

        return $result;
    }

    /**
     * 奖项配置中奖的概率一级中奖等级配置
     */
    public function actionLottery()
    {
        $prize_arr = SportsConfig::PrizeConfig();

        foreach ($prize_arr as $key => $val) {
            $arr[$val['id']] = $val['chance'];
        }
        $rid = $this->Winning($arr); //根据概率获取奖项id

        $res['yes'] = $prize_arr[$rid - 1]['praisename']; //中奖项
        unset($prize_arr[$rid - 1]); //将中奖项从数组中剔除，剩下未中奖项
        shuffle($prize_arr); //打乱数组顺序
        for ($i = 0; $i < count($prize_arr); $i++) {
            $pr[] = $prize_arr[$i]['praisename'];
        }
        $res['no'] = $pr;   // 除了中奖外的其他数据

        return json_encode($res);
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
    public function Winning($pro_arr)
    {
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