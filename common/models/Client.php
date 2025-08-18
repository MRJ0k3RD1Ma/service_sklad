<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "client".
 *
 * @property int $id
 * @property string $name
 * @property string|null $phone
 * @property string|null $phone_two
 * @property int $type_id
 * @property string|null $comment
 * @property float|null $balans
 * @property float|null $credit
 * @property float|null $debt
 * @property int|null $status
 * @property string|null $created
 * @property string|null $updated
 *
 * @property SaleCredit[] $saleCredits
 * @property ClientCar[] $cars
 * @property ClientType $type
 */
class Client extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'type_id'], 'required'],
            [['type_id', 'status'], 'integer'],
            [['balans', 'credit', 'debt'], 'number'],
            [['created', 'updated'], 'safe'],
            [['name', 'phone', 'phone_two', 'comment','image'], 'string', 'max' => 255],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ClientType::class, 'targetAttribute' => ['type_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Nomi',
            'phone' => 'Telefon',
            'image' => 'Rasm',
            'phone_two' => 'Qo`shimcha tel',
            'type_id' => 'Turi',
            'comment' => 'Izoh',
            'balans' => 'Balans',
            'credit' => 'Qarz',
            'debt' => 'To`lov',
            'status' => 'Status',
            'created' => 'Kiritildi',
            'updated' => 'O`zgartirildi',
        ];
    }

    /**
     * Gets query for [[SaleCredits]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSaleCredits()
    {
        return $this->hasMany(SaleCredit::class, ['client_id' => 'id']);
    }

    public function getCars()
    {
        return $this->hasMany(ClientCar::class,['client_id'=>'id']);
    }

    /**
     * Gets query for [[Type]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(ClientType::class, ['id' => 'type_id']);
    }
}
