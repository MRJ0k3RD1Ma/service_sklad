<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "payout".
 *
 * @property int $id
 * @property int $client_id
 * @property string $code
 * @property int $wallet_id
 * @property int $card_id
 * @property string|null $state
 * @property string|null $description
 * @property int|null $approved_id
 * @property double $price
 * @property int|null $status
 * @property string|null $created
 * @property string|null $updated
 *
 * @property User $approved
 * @property Card $card
 * @property Client $client
 * @property Wallet $wallet
 */
class Payout extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const STATE_NEW = 'NEW';
    const STATE_PAYOUTED = 'PAYOUTED';
    const STATE_CANCELLED = 'CANCELLED';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payout';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'approved_id'], 'default', 'value' => null],
            [['state'], 'default', 'value' => 'NEW'],
            [['status'], 'default', 'value' => 1],
            [['client_id', 'code', 'wallet_id', 'card_id'], 'required'],
            [['client_id', 'wallet_id', 'card_id', 'approved_id', 'status'], 'integer'],
            [['state', 'description'], 'string'],
            [['created', 'updated'], 'safe'],
            ['price','number'],
            [['code'], 'string', 'max' => 255],
            ['state', 'in', 'range' => array_keys(self::optsState())],
            [['approved_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['approved_id' => 'id']],
            [['card_id'], 'exist', 'skipOnError' => true, 'targetClass' => Card::class, 'targetAttribute' => ['card_id' => 'id']],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::class, 'targetAttribute' => ['client_id' => 'id']],
            [['wallet_id'], 'exist', 'skipOnError' => true, 'targetClass' => Wallet::class, 'targetAttribute' => ['wallet_id' => 'id']],
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
            'code' => 'Code',
            'wallet_id' => 'Wallet',
            'card_id' => 'Karta',
            'state' => 'Holat',
            'description' => 'Izoh',
            'approved_id' => 'Tasdiqlovchi',
            'status' => 'Status',
            'created' => 'Kiritildi',
            'updated' => 'O`zgartirish',
            'price'=>'Summa'
        ];
    }

    /**
     * Gets query for [[Approved]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getApproved()
    {
        return $this->hasOne(User::class, ['id' => 'approved_id']);
    }

    /**
     * Gets query for [[Card]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCard()
    {
        return $this->hasOne(Card::class, ['id' => 'card_id']);
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
     * Gets query for [[Wallet]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWallet()
    {
        return $this->hasOne(Wallet::class, ['id' => 'wallet_id']);
    }


    /**
     * column state ENUM value labels
     * @return string[]
     */
    public static function optsState()
    {
        return [
            self::STATE_NEW => 'NEW',
            self::STATE_PAYOUTED => 'PAYOUTED',
            self::STATE_CANCELLED => 'CANCELLED',
        ];
    }

    /**
     * @return string
     */
    public function displayState()
    {
        return self::optsState()[$this->state];
    }

    /**
     * @return bool
     */
    public function isStateNew()
    {
        return $this->state === self::STATE_NEW;
    }

    public function setStateToNew()
    {
        $this->state = self::STATE_NEW;
    }

    /**
     * @return bool
     */
    public function isStatePayouted()
    {
        return $this->state === self::STATE_PAYOUTED;
    }

    public function setStateToPayouted()
    {
        $this->state = self::STATE_PAYOUTED;
    }

    /**
     * @return bool
     */
    public function isStateCancelled()
    {
        return $this->state === self::STATE_CANCELLED;
    }

    public function setStateToCancelled()
    {
        $this->state = self::STATE_CANCELLED;
    }
}
