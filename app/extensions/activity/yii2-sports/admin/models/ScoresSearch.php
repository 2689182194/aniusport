<?php

namespace activity\sports\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use activity\sports\models\SportsScores;

/**
 * ScoresSearch represents the model behind the search form about `activity\sports\models\SportsScores`.
 */
class ScoresSearch extends SportsScores
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['score_id', 'score_status', 'score_value', 'score_time', 'created_at', 'updated_at'], 'integer'],
            [['user_id', 'score_rules'], 'safe'],
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
        $query = SportsScores::find()->joinWith('user')->orderBy(['score_time'=>SORT_DESC]);

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
            'score_id' => $this->score_id,
            'score_status' => $this->score_status,
            'score_value' => $this->score_value,
            'score_time' => $this->score_time,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'nickname', trim($this->user_id)])
            ->andFilterWhere(['like', 'score_rules', $this->score_rules]);

        return $dataProvider;
    }
}
