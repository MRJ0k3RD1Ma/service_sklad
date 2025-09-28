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
            [['date', 'code', 'state', 'created', 'updated', 'address','client_name'], 'safe'],
            [['price', 'debt', 'credit', 'volume', 'volume_estimated','price_worker','total_price_worker'], 'number'],
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
        $query = Sale::find()->select(['sale.*'])
            ->innerJoin('client','client.id = sale.client_id')
            ->orderBy(['sale.id'=>SORT_DESC]);

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
            'sale.id' => $this->id,
            'sale.date' => $this->date,
            'sale.code_id' => $this->code_id,
            'sale.client_id' => $this->client_id,
            'sale.product_id' => $this->product_id,
            'sale.price' => $this->price,
            'sale.debt' => $this->debt,
            'sale.credit' => $this->credit,
            'sale.price_worker' => $this->price_worker,
            'sale.worker_id' => $this->worker_id,
            'sale.created' => $this->created,
            'sale.updated' => $this->updated,
            'sale.register_id' => $this->register_id,
            'sale.modify_id' => $this->modify_id,
            'sale.status' => $this->status,
            'sale.volume' => $this->volume,
            'sale.volume_estimated' => $this->volume_estimated,
            'sale.state'=>$this->state,
        ]);

        $query->andFilterWhere(['like', 'sale.code', $this->code])
            ->andFilterWhere(['like', 'client.name', $this->client_name])
            ->andFilterWhere(['like', 'sale.address', $this->address]);

        return $dataProvider;
    }
}
