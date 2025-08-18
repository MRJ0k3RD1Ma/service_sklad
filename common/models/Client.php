<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "client".
 *
 * @property int $id
 * @property string $name
 * @property string $chat_id
 * @property int|null $status
 * @property string|null $created
 * @property string|null $updated
 *
 * @property Wallet[] $wallets
 */
class Client extends \yii\db\ActiveRecord
{

    public $deposit, $payout;
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
            [['status'], 'default', 'value' => 1],
            [['name', 'chat_id'], 'required'],
            [['status'], 'integer'],
            [['created', 'updated','deposit','payout'], 'safe'],
            [['name', 'chat_id'], 'string', 'max' => 255],
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
            'chat_id' => 'Chat ID',
            'status' => 'Status',
            'created' => 'Ro`yhatga olindi',
            'updated' => 'O`zgartirildi',
        ];
    }

    /**
     * Gets query for [[Wallets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWallets()
    {
        return $this->hasMany(Wallet::class, ['client_id' => 'id']);
    }

}
