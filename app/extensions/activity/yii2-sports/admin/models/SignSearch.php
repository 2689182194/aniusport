<?php

namespace activity\sports\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use activity\sports\models\SportsSign;

/**
 * SignSearch represents the model behind the search form about `activity\sports\models\SportsSign`.
 */
class SignSearch extends SportsSign
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sign_id', 'sign_day', 'sign_time', 'created_at', 'updated_at'], 'integer'],
            [['sign_user'], 'safe'],
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
        $query = SportsSign::find()->joinWith('user')->orderBy(['sign_time'=>SORT_DESC]);

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
            'sign_id' => $this->sign_id,
            'sign_day' => $this->sign_day,
            'sign_time' => $this->sign_time,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'nickname', $this->sign_user]);
        return $dataProvider;
    }
}
