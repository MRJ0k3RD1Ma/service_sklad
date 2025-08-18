<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Paid;

/**
 * PaidSearch represents the model behind the search form of `common\models\Paid`.
 */
class PaidSearch extends Paid
{
    /**
     * {@inheritdoc}
     */

    public $period_end, $period_start;

    public function rules()
    {
        return [
            [['id', 'sale_id', 'payment_id', 'status', 'register_id', 'modify_id'], 'integer'],
            [['price'], 'number'],
            [['date','period_end','period_start', 'created', 'updated', 'type'], 'safe'],
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
        $query = Paid::find()->orderBy(['id'=>SORT_DESC]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);
        if($this->period_start){
            $query->andFilterWhere(['>=', 'date', $this->period_start]);
        }
        if($this->period_end){
            $query->andFilterWhere(['<=', 'date', $this->period_end]);
        }
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        if($this->status == null){
            $query->andWhere(['status' => 1]);
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'sale_id' => $this->sale_id,
            'price' => $this->price,
            'payment_id' => $this->payment_id,
            'date' => $this->date,
            'status' => $this->status,
            'created' => $this->created,
            'updated' => $this->updated,
            'register_id' => $this->register_id,
            'modify_id' => $this->modify_id,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type]);

        return $dataProvider;
    }
}
