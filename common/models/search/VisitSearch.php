<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Visit;

/* @var $state_param int*/
/**
 * VisitSearch represents the model behind the search form of `common\models\Visit`.
 */
class VisitSearch extends Visit
{
    public $state_param;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'state_param','client_id', 'car_id','is_print', 'register_id', 'modify_id', 'status'], 'integer'],
            [['date', 'created', 'updated', 'state','car_number','client_name','client_phone'], 'safe'],
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
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Visit::find()->select(['visit.*'])
            ->innerJoin('client_car','client_car.id = visit.car_id')
            ->innerJoin('client','client.id = visit.client_id')
            ->orderBy(['id'=>SORT_DESC]);

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

        if($this->state_param == 1){
           $query->andWhere('visit.state = "NEW" or visit.state = "RUNNING"');
        }else{
            if($this->state){
                $query->andWhere(['visit.state'=>$this->state]);
            }
        }
        if($this->status == null){
            $this->status  = 1;
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'visit.id' => $this->id,
            'visit.client_id' => $this->client_id,
            'visit.car_id' => $this->car_id,
            'visit.date' => $this->date,
            'visit.price' => $this->price,
            'visit.debt' => $this->debt,
            'visit.credit' => $this->credit,
            'visit.register_id' => $this->register_id,
            'visit.modify_id' => $this->modify_id,
            'visit.status' => $this->status,
            'visit.created' => $this->created,
            'visit.updated' => $this->updated,
        ]);
        $query->andFilterWhere(['like', 'client_car.number', $this->car_number])
            ->andFilterWhere(['like', 'client.name', $this->client_name])
            ->andFilterWhere(['like', 'client.phone', $this->client_phone]);
        return $dataProvider;
    }
}
