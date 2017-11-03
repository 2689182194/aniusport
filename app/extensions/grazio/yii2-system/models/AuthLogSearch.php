<?php
/**
 * @link https://github.com/yii2tech
 * @copyright Copyright (c) 2015 Yii2tech
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */

namespace grazio\system\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * AuthLogSearch is a base filter model with the auth log listings.
 *
 * @author Paul Klimov <pklimov@quartsoft.com>
 * @package app\models\backend
 */
abstract class AuthLogSearch extends Model
{
    public $id;
    public $duration;
    public $error;
    public $cookie_based;
    public $ip;
    public $host;
    public $url;
    public $user_agent;
    public $username;

    /**
     * @var string name of the attribute, which should be used to reference for the user entity.
     * Note: such attribute must be present in actual search model class!
     */
    protected $userReferenceAttribute;
    /**
     * @var string name of the ActiveRecord class, which is used to store actual user records.
     */
    protected $userClass;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'duration', $this->userReferenceAttribute], 'integer'],
            [['username', 'error'], 'string'],
            [['cookie_based'], 'boolean'],
            [['ip', 'host', 'url', 'user_agent'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => Yii::t('common', 'Date'),
            'cookie_based' => Yii::t('auth', 'Cookie Based'),
            'duration' => Yii::t('auth', 'Duration'),
            'error' => Yii::t('yii', 'Error'),
            'ip' => Yii::t('common', 'IP Address'),
            'host' => Yii::t('common', 'Host'),
            'url' => 'URL',
            'user_agent' => Yii::t('auth', 'UserAgent'),
            'username' => Yii::t('user', 'Username'),
        ];
    }

    /**
     * Return the list of auth error labels.
     * @return array auth error labels (name => label)
     */
    public function authErrorLabels()
    {
        return [
            'password' => Yii::t('auth', 'Incorrect password.'),
        ];
    }

    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = $this->createQuery();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'cookie_based' => $this->cookie_based,
            'duration' => $this->duration,
            $this->userReferenceAttribute => $this->{$this->userReferenceAttribute},
        ]);

        if (!empty($this->error)) {
            if ($this->error === '-') {
                $query->andWhere(['error' => null]);
            } else {
                $query->andFilterWhere(['error' => $this->error]);
            }
        }

        if (!empty($this->username)) {
            /* @var $className \yii\db\ActiveRecord */
            $className = $this->userClass;
            $userIds = $className::find()
                ->select(['id'])
                ->andWhere(['like', 'username', $this->username])
                ->column();
            $query->andWhere(['in', $this->userReferenceAttribute, $userIds]);
        }

        $query->andFilterWhere(['like', 'ip', $this->ip])
            ->andFilterWhere(['like', 'host', $this->host])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'user_agent', $this->user_agent]);

        return $dataProvider;
    }

    /**
     * Creates an ActiveQuery for the records search.
     * @return \yii\db\ActiveQuery query instance.
     */
    abstract protected function createQuery();
}