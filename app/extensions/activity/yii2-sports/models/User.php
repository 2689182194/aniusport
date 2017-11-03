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
        return static::find()->where(['openid'=>$id])->one();
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

}