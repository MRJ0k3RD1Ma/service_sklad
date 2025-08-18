<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sale_credit".
 *
 * @property int $sale_id
 * @property float $price
 * @property int $client_id
 * @property int $user_id
 * @property int|null $status
 * @property int|null $state
 * @property string|null $created
 * @property string|null $updated
 * @property string|null $ads
 * @property string|null $call_date
 *
 * @property Client $client
 * @property Sale $sale
 * @property User $user
 */
class SaleCredit extends \yii\db\ActiveRecord
{
    public $states = [
            1=>'Aloqaga chiqilmagan',
            2=>'Qayta aloqaga chiqish kerak',
            3=>'Javob bermadi',
            4=>'To`lov qilib yakunlagan',
        ];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sale_credit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sale_id', 'client_id', 'user_id','call_date'], 'required'],
            [['sale_id', 'client_id', 'user_id', 'status','state'], 'integer'],
            [['price'], 'number'],
            [['created', 'updated','call_date','ads'], 'safe'],
            [['sale_id'], 'unique'],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::class, 'targetAttribute' => ['client_id' => 'id']],
            [['sale_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sale::class, 'targetAttribute' => ['sale_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'sale_id' => 'Sale ID',
            'price' => 'Narxi',
            'call_date' => 'To`lov sanasi',
            'client_id' => 'Mijoz',
            'user_id' => 'User ID',
            'status' => 'Status',
            'created' => 'Created',
            'updated' => 'Updated',
            'state' => 'state',
            'ads' => 'Izoh',
        ];
    }



    public function getStatetext(){
        return $this->states[$this->state];
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
     * Gets query for [[Sale]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSale()
    {
        return $this->hasOne(Sale::class, ['id' => 'sale_id']);
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
}
