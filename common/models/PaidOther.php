<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "paid_other".
 *
 * @property int $id
 * @property string|null $type
 * @property int|null $group_id
 * @property string|null $description
 * @property string|null $paid_date
 * @property int|null $payment_id
 * @property float|null $price
 * @property int|null $status
 * @property string|null $created
 * @property string|null $updated
 * @property int|null $register_id
 * @property int|null $modify_id
 *
 * @property PaidOtherGroup $group
 * @property Payment $payment
 * @property User $register
 * @property User $modify
 */
class PaidOther extends ActiveRecord
{
    public static function tableName()
    {
        return 'paid_other';
    }

    public function rules()
    {
        return [
            [['group_id', 'payment_id', 'status', 'register_id', 'modify_id'], 'integer'],
            [['description'], 'string'],
            [['paid_date', 'created', 'updated'], 'safe'],
            [['price'], 'number'],
            [['type'], 'in', 'range' => ['INCOME', 'OUTCOME']],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => PaidOtherGroup::class, 'targetAttribute' => ['group_id' => 'id']],
            [['payment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Payment::class, 'targetAttribute' => ['payment_id' => 'id']],
            [['register_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['register_id' => 'id']],
            [['modify_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['modify_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Turi (Kirim/Chiqim)',
            'group_id' => 'Guruh',
            'description' => 'Izoh',
            'paid_date' => 'To‘lov sanasi',
            'payment_id' => 'To‘lov turi',
            'price' => 'Summasi',
            'status' => 'Status',
            'created' => 'Kiritildi',
            'updated' => 'O`zgartirildi',
            'register_id' => 'Kiritdi',
            'modify_id' => 'O`zgartirdi',
        ];
    }

    public function getGroup()
    {
        return $this->hasOne(PaidOtherGroup::class, ['id' => 'group_id']);
    }

    public function getPayment()
    {
        return $this->hasOne(Payment::class, ['id' => 'payment_id']);
    }

    public function getRegister()
    {
        return $this->hasOne(User::class, ['id' => 'register_id']);
    }

    public function getModify()
    {
        return $this->hasOne(User::class, ['id' => 'modify_id']);
    }
}
