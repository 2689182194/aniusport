<?php

namespace activity\activity\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use activity\activity\models\SportsActivity;

/**
 * ActivitySearch represents the model behind the search form about `activity\activity\models\SportsActivity`.
 */
class ActivitySearch extends SportsActivity
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['activity_id', 'group_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['activity_name', 'file','start_time','end_time'], 'safe'],
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
        $query = SportsActivity::find()->with('group');

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
            'activity_id' => $this->activity_id,
            'group_id' => $this->group_id,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'activity_name', $this->activity_name])
            ->andFilterWhere(['like', 'file', $this->file]);

        return $dataProvider;

        return $dataProvider;
    }
}
