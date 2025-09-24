<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PaidWorker;

/**
 * PaidWorkerSearch represents the model behind the search form of `common\models\PaidWorker`.
 */
class PaidWorkerSearch extends PaidWorker
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'worker_id', 'payment_id', 'status', 'register_id', 'modify_id', 'sale_id'], 'integer'],
            [['date', 'description', 'created', 'updated'], 'safe'],
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
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = PaidWorker::find()->orderBy(['id'=>SORT_DESC]);

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
            'worker_id' => $this->worker_id,
            'date' => $this->date,
            'price' => $this->price,
            'payment_id' => $this->payment_id,
            'status' => $this->status,
            'created' => $this->created,
            'updated' => $this->updated,
            'register_id' => $this->register_id,
            'modify_id' => $this->modify_id,
            'sale_id' => $this->sale_id,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
