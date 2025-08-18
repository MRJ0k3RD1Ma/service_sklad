<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sale".
 *
 * @property int $id
 * @property int|null $user_id
 * @property float|null $price
 * @property int|null $status
 * @property int|null $code_id
 * @property string|null $created
 * @property string|null $type
 * @property string|null $code
 * @property string|null $updated
 * @property float|null $credit
 * @property float|null $debt
 *
 * @property SaleCredit $saleCredit
 * @property User $user
 */
class Sale extends \yii\db\ActiveRecord
{
    public $creditor,$call_date_loc,$call_date;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sale';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'status','code_id'], 'integer'],
            [['price', 'credit', 'debt'], 'number'],
            [['created', 'updated','code','type'], 'safe'],
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
            'user_id' => 'Sotuvchi',
            'code' => 'Chek',
            'call_date_loc' => 'To`lov sanasi',
            'price' => 'Umumiy narx',
            'status' => 'Status',
            'created' => 'Sotildi',
            'updated' => 'O`zgartirildi',
            'credit' => 'Qarz',
            'debt' => 'To`lov',
            'type' => 'Turi',
        ];
    }

    /**
     * Gets query for [[SaleCredit]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSaleCredit()
    {
        return $this->hasOne(SaleCredit::class, ['sale_id' => 'id']);
    }

    public function getProduct(){
        return $this->hasMany(SaleProduct::class, ['sale_id' => 'id']);
    }

    public function getVisit()
    {
        return $this->hasOne(Visit::class, ['id' => 'sale_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getSaleClient(){
        return $this->hasMany(SaleClient::class, ['sale_id' => 'id']);
    }

    public function getClient(){
        return $this->hasMany(Client::class, ['id' => 'client_id'])
            ->via('saleClient');
    }
}
