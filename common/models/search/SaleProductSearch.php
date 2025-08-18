<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SaleProduct;

/**
 * SaleProductSearch represents the model behind the search form of `common\models\SaleProduct`.
 */
class SaleProductSearch extends SaleProduct
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'sale_id', 'product_id', 'user_id'], 'integer'],
            [['price', 'cnt', 'cnt_price'], 'number'],
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
        $query = SaleProduct::find()->select(['sale_product.*'])
        ->innerJoin('sale','sale.id = sale_product.sale_id and sale.status = 1')
            ->orderBy(['sale.created' => SORT_DESC]);
        ;

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
            'sale_id' => $this->sale_id,
            'product_id' => $this->product_id,
            'user_id' => $this->user_id,
            'price' => $this->price,
            'cnt' => $this->cnt,
            'cnt_price' => $this->cnt_price,
        ]);

        return $dataProvider;
    }
}
