<?php

namespace activity\sports\models;

use yii;
use yii\web\IdentityInterface;

class User extends SportsUser implements IdentityInterface
{


    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::find()->where(['openid' => $id])->one();
    }


    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->openid;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }


    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->setAttribute('authKey', \Yii::$app->security->generateRandomString());
            }
            return true;
        }
        return false;
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
    }

    /**
     * 约定参数校验
     * @param $identification
     * @return string
     * @throws yii\base\Exception
     */
    public static function Identification($identification)
    {

        $result = Yii::$app->redis->get($identification);   //读取redis缓存
        $result = unserialize($result);
//        echo $identification;
//        \X::result($result);
//        echo $result['title'];
//        echo "<br/>";
//        return $result['unquie_user'];
        if ($identification == $result['title']) {
//            echo 1;die;
            return $result['unquie_user'];
        } else {
//            echo 2;die;
            throw new yii\base\Exception('登录失效');
        }
    }
}