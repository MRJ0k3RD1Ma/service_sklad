<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "visit".
 *
 * @property int $id
 * @property int|null $client_id
 * @property int|null $car_id
 * @property string|null $date
 * @property float|null $price
 * @property float|null $debt
 * @property float|null $credit
 * @property int|null $register_id
 * @property int|null $modify_id
 * @property int|null $status
 * @property int|null $sale_id
 * @property string|null $created
 * @property string|null $updated
 *
 * @property ClientCar $car
 * @property Client $client
 * @property User $modify
 * @property User $register
 * @property User $sale
 */
class Visit extends \yii\db\ActiveRecord
{
    public $client_name,$client_phone,$car_model,$car_number,$car_run,$call_date,$ads,$image;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'visit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_id', 'car_id','sale_id','is_print', 'register_id', 'modify_id', 'status','user_id'], 'integer'],
            [['date', 'created', 'updated','client_name','client_phone','car_model','car_number','car_run','call_date','ads','image','state'], 'safe'],
            [['price', 'debt', 'credit'], 'number'],
            [['car_id'], 'exist', 'skipOnError' => true, 'targetClass' => ClientCar::class, 'targetAttribute' => ['car_id' => 'id']],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::class, 'targetAttribute' => ['client_id' => 'id']],
            [['modify_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['modify_id' => 'id']],
            [['register_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['register_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
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
            'car_id' => 'Mashina',
            'date' => 'Sana',
            'image' => 'Rasm',
            'price' => 'Umumiy narx',
            'debt' => 'To`landi',
            'credit' => 'Qarz',
            'register_id' => 'Kiritdi',
            'modify_id' => 'O`zgartirdi',
            'status' => 'Status',
            'created' => 'Kiritildi',
            'updated' => 'O`zgartirildi',
            'sale_id' => 'Sotuv',
            'client_name' => 'Mijoz ismi',
            'state' => 'State',
            'client_phone' => 'Mijoz telefoni',
            'car_model' => 'Mashina Modeli',
            'car_number' => 'Mashina Raqami',
            'car_run' => 'Пробег',
            'user_id' => 'Ta`mirlovchi usta',
            'call_date' => 'Keyingi telefon qilish sanasi',
            'ads' => 'Izoh',
            'is_print' => 'Yopilganmi?',
        ];
    }

    /**
     * Gets query for [[Car]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCar()
    {
        return $this->hasOne(ClientCar::class, ['id' => 'car_id']);
    }

    public function getSale()
    {
        return $this->hasOne(Sale::class,['id'=>'sale_id']);
    }

    /**
     * Gets query for [[Client]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Client::class, ['id' => 'client_id']);
    }

    /**
     * Gets query for [[Modify]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getModify()
    {
        return $this->hasOne(User::class, ['id' => 'modify_id']);
    }

    public function getVisitProducts()
    {
        return $this->hasMany(SaleProduct::class, ['sale_id' => 'sale_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
    /**
     * Gets query for [[Register]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegister()
    {
        return $this->hasOne(User::class, ['id' => 'register_id']);
    }
}

