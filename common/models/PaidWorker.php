<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "paid_worker".
 *
 * @property int $id
 * @property int|null $worker_id
 * @property string|null $date
 * @property float|null $price
 * @property string|null $description
 * @property int|null $payment_id
 * @property int|null $status
 * @property string|null $created
 * @property string|null $updated
 * @property int|null $register_id
 * @property int|null $modify_id
 * @property int|null $sale_id
 *
 * @property Worker $worker
 * @property Payment $payment
 * @property Sale $sale
 * @property User $register
 * @property User $modify
 */
class PaidWorker extends ActiveRecord
{
    public static function tableName()
    {
        return 'paid_worker';
    }

    public function rules()
    {
        return [
            [['worker_id', 'payment_id', 'status', 'register_id', 'modify_id', 'sale_id'], 'integer'],
            [['date', 'created', 'updated'], 'safe'],
            [['price'], 'number'],
            [['price','worker_id','payment_id','date'],'required'],
            [['description'], 'string'],
            [['worker_id'], 'exist', 'skipOnError' => true, 'targetClass' => Worker::class, 'targetAttribute' => ['worker_id' => 'id']],
            [['payment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Payment::class, 'targetAttribute' => ['payment_id' => 'id']],
            [['sale_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sale::class, 'targetAttribute' => ['sale_id' => 'id']],
            [['register_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['register_id' => 'id']],
            [['modify_id'], 'exist', 'skipOnError' => true, 'targetClass' => Worker::class, 'targetAttribute' => ['modify_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'worker_id' => 'Xodim',
            'date' => 'Sana',
            'price' => 'Summasi',
            'description' => 'Izoh',
            'payment_id' => 'To‘lov turi',
            'status' => 'Status',
            'created' => 'Kiritildi',
            'updated' => 'O`zgartirildi',
            'register_id' => 'Kiritdi',
            'modify_id' => 'O`zgartirdi',
            'sale_id' => 'Savdo',
        ];
    }

    public function getWorker()
    {
        return $this->hasOne(Worker::class, ['id' => 'worker_id']);
    }

    public function getPayment()
    {
        return $this->hasOne(Payment::class, ['id' => 'payment_id']);
    }

    public function getSale()
    {
        return $this->hasOne(Sale::class, ['id' => 'sale_id']);
    }

    public function getRegister()
    {
        return $this->hasOne(User::class, ['id' => 'register_id']);
    }

    public function getModify()
    {
        return $this->hasOne(Worker::class, ['id' => 'modify_id']);
    }
}
