<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ClientCar;

/**
 * ClientCarSearch represents the model behind the search form of `common\models\ClientCar`.
 */
class ClientCarSearch extends ClientCar
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'client_id', 'run', 'status'], 'integer'],
            [['model', 'number', 'call_date', 'ads', 'created', 'updated', 'last_visit'], 'safe'],
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
        $query = ClientCar::find()->orderBy(['id' => SORT_DESC]);

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
            $query->andWhere(['status'=>1]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'client_id' => $this->client_id,
            'run' => $this->run,
            'call_date' => $this->call_date,
            'status' => $this->status,
            'created' => $this->created,
            'updated' => $this->updated,
            'last_visit' => $this->last_visit,
        ]);

        $query->andFilterWhere(['like', 'model', $this->model])
            ->andFilterWhere(['like', 'number', $this->number])
            ->andFilterWhere(['like', 'ads', $this->ads]);

        return $dataProvider;
    }
}
