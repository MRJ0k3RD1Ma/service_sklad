<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "wallet".
 *
 * @property int $id
 * @property int $client_id
 * @property string $number
 * @property string $valyuta
 * @property string|null $name
 * @property int|null $status
 * @property string|null $created
 * @property string|null $updated
 *
 * @property Client $client
 */
class Wallet extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wallet';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 1],
            [['client_id', 'number', 'valyuta'], 'required'],
            [['client_id', 'status'], 'integer'],
            [['created', 'updated'], 'safe'],
            [['number', 'valyuta', 'name'], 'string', 'max' => 255],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::class, 'targetAttribute' => ['client_id' => 'id']],
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
            'number' => 'Wallet',
            'valyuta' => 'Valyuta',
            'name' => 'Nomi',
            'status' => 'Status',
            'created' => 'Kiritildi',
            'updated' => 'O`zgartirildi',
        ];
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

}
