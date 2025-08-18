<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Sale;

/**
 * SaleSearch represents the model behind the search form of `common\models\Sale`.
 */
class SaleCreditSearch extends Sale
{
    public $period_start, $period_end;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'status', 'code_id'], 'integer'],
            [['price', 'credit', 'debt'], 'number'],
            [['created', 'updated', 'code','type','period_start','period_end'], 'safe'],
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
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {

        $query = Sale::find()
            ->select(['sale.*','sale_credit.client_id as creditor','sale_credit.call_date'])
            ->innerJoin('sale_credit','sale_credit.sale_id = sale.id')
            ->select(['sale.*'])
            ->orderBy(['sale.id'=>SORT_DESC]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if($this->period_start){
            $query->andFilterWhere(['>=', 'date(sale_credit.call_date)', $this->period_start]);
        }
        if($this->period_end){
            $query->andFilterWhere(['<=', 'date(sale_credit.call_date)', $this->period_end]);
        }
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        if($this->status == null){
            $this->status  = 1;
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'sale.id' => $this->id,
            'sale.user_id' => $this->user_id,
            'sale.price' => $this->price,
            'sale.status' => $this->status,
            'sale.created' => $this->created,
            'sale.updated' => $this->updated,
            'sale.credit' => $this->credit,
            'sale.debt' => $this->debt,
            'sale.code_id' => $this->code_id,
        ]);

        $query->andFilterWhere(['like', 'sale.code', $this->code]);

        return $dataProvider;
    }
}

