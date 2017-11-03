<?php

namespace grazio\gos\web\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * MeidaItemSearch represents the model behind the search form about `grazio\gos\models\MediaItemModel`.
 */
class ImageItemSearch extends ImageItemModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'fileVersion'], 'integer'],
            [['name', 'description', 'fileExtension'], 'safe'],
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
        $query = ImageItemModel::find();

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
            'fileVersion' => $this->fileVersion,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'fileExtension', $this->fileExtension]);

        return $dataProvider;
    }
}
