<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SupplerPaid;

/**
 * SupplerPaidSearch represents the model behind the search form of `common\models\SupplerPaid`.
 */
class SupplerPaidSearch extends SupplerPaid
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'suppler_id', 'payment_id', 'status', 'register_id', 'modify_id'], 'integer'],
            [['date', 'created', 'updated'], 'safe'],
            [['price'], 'number'],
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
        $query = SupplerPaid::find()->orderBy(['id'=>SORT_DESC]);

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
        if($this->status == null){
            $this->status  = 1;
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'suppler_id' => $this->suppler_id,
            'date' => $this->date,
            'price' => $this->price,
            'payment_id' => $this->payment_id,
            'status' => $this->status,
            'register_id' => $this->register_id,
            'modify_id' => $this->modify_id,
            'created' => $this->created,
            'updated' => $this->updated,
        ]);

        return $dataProvider;
    }
}
