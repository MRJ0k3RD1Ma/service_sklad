<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Sale;

/**
 * SaleSearch represents the model behind the search form of `common\models\Sale`.
 */
class SaleSearch extends Sale
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'code_id', 'client_id', 'product_id', 'worker_id', 'register_id', 'modify_id', 'status'], 'integer'],
            [['date', 'code', 'state', 'created', 'updated', 'address'], 'safe'],
            [['price', 'debt', 'credit', 'volume', 'volume_estimated'], 'number'],
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
        $query = Sale::find()->orderBy(['id'=>SORT_DESC]);

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
        if($this->status == null){
            $this->status = 1;
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'date' => $this->date,
            'code_id' => $this->code_id,
            'client_id' => $this->client_id,
            'product_id' => $this->product_id,
            'price' => $this->price,
            'debt' => $this->debt,
            'credit' => $this->credit,
            'worker_id' => $this->worker_id,
            'created' => $this->created,
            'updated' => $this->updated,
            'register_id' => $this->register_id,
            'modify_id' => $this->modify_id,
            'status' => $this->status,
            'volume' => $this->volume,
            'volume_estimated' => $this->volume_estimated,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'address', $this->address]);

        return $dataProvider;
    }
}
