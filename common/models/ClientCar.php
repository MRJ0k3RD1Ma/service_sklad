<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "client_car".
 *
 * @property int $id
 * @property int $client_id
 * @property string $model
 * @property string $number
 * @property int $run
 * @property string|null $call_date
 * @property string|null $ads
 * @property int|null $status
 * @property string|null $created
 * @property string|null $updated
 * @property string|null $last_visit
 */
class ClientCar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client_car';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_id', 'model', 'number', 'run'], 'required'],
            [['client_id', 'run', 'status'], 'integer'],
            [['call_date', 'created', 'updated', 'last_visit'], 'safe'],
            [['ads'], 'string'],
            [['model', 'number'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_id' => 'Mijoz',
            'model' => 'Model',
            'number' => 'Raqami',
            'run' => 'Пробег',
            'call_date' => 'Telefon qilish sanasi',
            'ads' => 'Izoh',
            'status' => 'Status',
            'created' => 'Created',
            'updated' => 'Updated',
            'last_visit' => 'So`ngi tashrif',
        ];
    }

    public function getClient(){
        return $this->hasOne(Client::class, ['id' => 'client_id']);
    }
}
