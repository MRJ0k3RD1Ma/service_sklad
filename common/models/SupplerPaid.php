<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "suppler_paid".
 *
 * @property int $id
 * @property int $suppler_id
 * @property string|null $date
 * @property float $price
 * @property int $payment_id
 * @property int|null $status
 * @property int|null $register_id
 * @property int|null $modify_id
 * @property string|null $created
 * @property string|null $updated
 *
 * @property User $modify
 * @property Payment $payment
 * @property User $register
 * @property Suppler $suppler
 */
class SupplerPaid extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'suppler_paid';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['suppler_id', 'price', 'payment_id'], 'required'],
            [['suppler_id', 'payment_id', 'status', 'register_id', 'modify_id'], 'integer'],
            [['date', 'created', 'updated'], 'safe'],
            [['price'], 'number'],
            [['modify_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['modify_id' => 'id']],
            [['payment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Payment::class, 'targetAttribute' => ['payment_id' => 'id']],
            [['register_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['register_id' => 'id']],
            [['suppler_id'], 'exist', 'skipOnError' => true, 'targetClass' => Suppler::class, 'targetAttribute' => ['suppler_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'suppler_id' => 'Yetkazuvchi',
            'date' => 'Sana',
            'price' => 'Summa',
            'payment_id' => 'To`lov turi',
            'status' => 'Status',
            'register_id' => 'To`lov qildi',
            'modify_id' => 'O`zgartirdi',
            'created' => 'Kiritildi',
            'updated' => 'O`zgartirildi',
        ];
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

    /**
     * Gets query for [[Payment]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPayment()
    {
        return $this->hasOne(Payment::class, ['id' => 'payment_id']);
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

    /**
     * Gets query for [[Suppler]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSuppler()
    {
        return $this->hasOne(Suppler::class, ['id' => 'suppler_id']);
    }
}
