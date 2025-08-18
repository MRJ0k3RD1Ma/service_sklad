<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Suppler;

/**
 * SupplerSearch represents the model behind the search form of `common\models\Suppler`.
 */
class SupplerSearch extends Suppler
{
    /**
     * {@inheritdoc}
     */
    public $type;
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['name', 'phone', 'phone_two', 'comment', 'created', 'updated'], 'safe'],
            [['balans', 'debt', 'credit'], 'number'],
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
        $query = Suppler::find()->orderBy(['id' => SORT_DESC]);
        if($this->type == 'debt'){
            $query->andWhere(['>','balans',0]);
        }
        if($this->type == 'credit'){
            $query->andWhere(['<','balans',0]);
        }
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
            'created' => $this->created,
            'updated' => $this->updated,
            'balans' => $this->balans,
            'debt' => $this->debt,
            'credit' => $this->credit,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'phone_two', $this->phone_two])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
