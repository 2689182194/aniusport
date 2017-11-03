<?php

namespace activity\sports\models;

use Yii;

/**
 * This is the model class for table "{{%sports_config}}".
 *
 * @property integer $id
 * @property string $praisefeild
 * @property string $praisename
 * @property string $min
 * @property string $max
 * @property string $praisecontent
 * @property integer $praisenumber
 * @property string $praiseimage
 * @property integer $chance
 */
class SportsConfig extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sports_config}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['praisefeild', 'praisename', 'min', 'max', 'praisecontent', 'praisenumber', 'chance'], 'required'],
            [['praisecontent'], 'string'],
            [['praisenumber', 'chance'], 'integer'],
            [['praisefeild'], 'string', 'max' => 10],
            [['praisename'], 'string', 'max' => 20],
            [['min', 'max'], 'string', 'max' => 100],
            [['praiseimage'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'praisefeild' => 'Praisefeild',
            'praisename' => 'Praisename',
            'min' => 'Min',
            'max' => 'Max',
            'praisecontent' => 'Praisecontent',
            'praisenumber' => 'Praisenumber',
            'praiseimage' => 'Praiseimage',
            'chance' => 'Chance',
        ];
    }

    public static function PrizeConfig()
    {
        return static::find()->asArray()->all();
    }
}
