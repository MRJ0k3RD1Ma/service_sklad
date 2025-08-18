<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Transaction;

/**
 * TransactionSearch represents the model behind the search form of `common\models\Transaction`.
 */
class TransactionSearch extends Transaction
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'price', 'client_id', 'payment_id', 'verify_id', 'status', 'is_approved', 'wallet_id'], 'integer'],
            [['uuid', 'state', 'created', 'updated', 'merchant_trans_id'], 'safe'],
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
        $query = Transaction::find()->orderBy(['id' => SORT_DESC]);

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
            'price' => $this->price,
            'client_id' => $this->client_id,
            'payment_id' => $this->payment_id,
            'verify_id' => $this->verify_id,
            'status' => $this->status,
            'created' => $this->created,
            'updated' => $this->updated,
            'is_approved' => $this->is_approved,
            'wallet_id' => $this->wallet_id,
        ]);

        $query->andFilterWhere(['like', 'uuid', $this->uuid])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'merchant_trans_id', $this->merchant_trans_id]);

        return $dataProvider;
    }
}
