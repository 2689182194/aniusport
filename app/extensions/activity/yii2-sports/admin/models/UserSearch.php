<?php

namespace activity\sports\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use activity\sports\models\SportsUser;

/**
 * UserSearch represents the model behind the search form about `activity\sports\models\SportsUser`.
 */
class UserSearch extends SportsUser
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'gender', 'badge', 'scores', 'created_at', 'updated_at'], 'integer'],
            [['authKey', 'openid', 'nickname', 'avatarUrl', 'country', 'province', 'ip', 'city'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = SportsUser::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'gender' => $this->gender,
            'badge' => $this->badge,
            'scores' => $this->scores,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'authKey', $this->authKey])
            ->andFilterWhere(['like', 'openid', $this->openid])
            ->andFilterWhere(['like', 'nickname', $this->nickname])
            ->andFilterWhere(['like', 'avatarUrl', $this->avatarUrl])
            ->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', 'province', $this->province])
            ->andFilterWhere(['like', 'ip', $this->ip])
            ->andFilterWhere(['like', 'city', $this->city]);

        return $dataProvider;
    }
}
