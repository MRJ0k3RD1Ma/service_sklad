<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\FornitureService;

/**
 * FornitureServiceSearch represents the model behind the search form of `common\models\FornitureService`.
 */
class FornitureServiceSearch extends FornitureService
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'client_id', 'wall_type_id', 'forniture_id', 'register_id', 'modify_id', 'status', 'saled_by_id', 'referal_id'], 'integer'],
            [['address', 'phone', 'created', 'updated', 'ads'], 'safe'],
            [['price', 'debt', 'credit'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
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
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = FornitureService::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'client_id' => $this->client_id,
            'wall_type_id' => $this->wall_type_id,
            'forniture_id' => $this->forniture_id,
            'price' => $this->price,
            'debt' => $this->debt,
            'credit' => $this->credit,
            'register_id' => $this->register_id,
            'modify_id' => $this->modify_id,
            'created' => $this->created,
            'updated' => $this->updated,
            'status' => $this->status,
            'saled_by_id' => $this->saled_by_id,
            'referal_id' => $this->referal_id,
        ]);

        $query->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'ads', $this->ads]);

        return $dataProvider;
    }
}
