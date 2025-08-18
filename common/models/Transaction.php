<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "transaction".
 *
 * @property int $id
 * @property string|null $uuid
 * @property int $price
 * @property int $client_id
 * @property int|null $payment_id
 * @property int|null $verify_id
 * @property string|null $state
 * @property int|null $status
 * @property string|null $created
 * @property string|null $updated
 * @property string|null $merchant_trans_id
 */
class Transaction extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const STATE_PREPARE = 'PREPARE';
    const STATE_PAY = 'PAY';
    const STATE_VERIFY = 'VERIFY';
    const STATE_CHECK = 'CHECK';
    const STATE_DONE = 'DONE';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transaction';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uuid', 'payment_id', 'verify_id', 'merchant_trans_id'], 'default', 'value' => null],
            [['state'], 'default', 'value' => 'PREPARE'],
            [['status'], 'default', 'value' => 1],
            [['price', 'client_id','wallet_id'], 'required'],
            [['price', 'client_id', 'payment_id', 'verify_id', 'status','wallet_id'], 'integer'],
            [['state'], 'string'],
            [['created', 'updated'], 'safe'],
            [['uuid', 'merchant_trans_id'], 'string', 'max' => 255],
            ['state', 'in', 'range' => array_keys(self::optsState())],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uuid' => 'Uuid',
            'price' => 'Summa',
            'client_id' => 'Mijoz',
            'payment_id' => 'Operatsiya ID',
            'verify_id' => 'Tasdiqladi',
            'state' => 'Holati',
            'status' => 'Status',
            'created' => 'Yaratildi',
            'updated' => 'O`zgartirldi',
            'merchant_trans_id' => 'Merchant Trans ID',
            'wallet_id'=>'Wallet'
        ];
    }

    public function getWallet(){
        return $this->hasOne(Wallet::className(), ['id' => 'wallet_id']);
    }

    /**
     * column state ENUM value labels
     * @return string[]
     */
    public static function optsState()
    {
        return [
            self::STATE_PREPARE => 'PREPARE',
            self::STATE_PAY => 'PAY',
            self::STATE_VERIFY => 'VERIFY',
            self::STATE_CHECK => 'CHECK',
            self::STATE_DONE => 'DONE',
        ];
    }

    /**
     * @return string
     */
    public function displayState()
    {
        return self::optsState()[$this->state];
    }

    public function getClient(){
        return $this->hasOne(Client::className(), ['id' => 'client_id']);
    }
    /**
     * @return bool
     */
    public function isStatePrepare()
    {
        return $this->state === self::STATE_PREPARE;
    }

    public function setStateToPrepare()
    {
        $this->state = self::STATE_PREPARE;
    }

    /**
     * @return bool
     */
    public function isStatePay()
    {
        return $this->state === self::STATE_PAY;
    }

    public function setStateToPay()
    {
        $this->state = self::STATE_PAY;
    }

    /**
     * @return bool
     */
    public function isStateVerify()
    {
        return $this->state === self::STATE_VERIFY;
    }

    public function setStateToVerify()
    {
        $this->state = self::STATE_VERIFY;
    }

    /**
     * @return bool
     */
    public function isStateCheck()
    {
        return $this->state === self::STATE_CHECK;
    }

    public function setStateToCheck()
    {
        $this->state = self::STATE_CHECK;
    }

    /**
     * @return bool
     */
    public function isStateDone()
    {
        return $this->state === self::STATE_DONE;
    }

    public function setStateToDone()
    {
        $this->state = self::STATE_DONE;
    }
}
