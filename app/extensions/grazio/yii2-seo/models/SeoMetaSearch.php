<?php

namespace grazio\seo\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use grazio\seo\models\SeoMetaModel;

/**
 * SeoMetaSearch represents the model behind the search form about `grazio\seo\models\SeoMetaModel`.
 */
class SeoMetaSearch extends SeoMetaModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'entity'], 'integer'],
            [['model', 'route', 'title', 'keywords', 'description', 'robots'], 'safe'],
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
        $query = SeoMetaModel::find();

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
            'entity' => $this->entity,
        ]);

        $query->andFilterWhere(['like', 'model', $this->model])
            ->andFilterWhere(['like', 'route', $this->route])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'keywords', $this->keywords])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'robots', $this->robots]);

        return $dataProvider;
    }
}
