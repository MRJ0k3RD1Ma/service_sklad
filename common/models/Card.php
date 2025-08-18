<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "card".
 *
 * @property int $id
 * @property int $client_id
 * @property string $number
 * @property int $expire_month
 * @property int $expire_date
 * @property int|null $status
 * @property string|null $created
 * @property string|null $updated
 */
class Card extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'card';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'default', 'value' => 1],
            [['client_id', 'number',], 'required'],
            [['client_id', 'expire_month', 'expire_date', 'status'], 'integer'],
            [['created', 'updated'], 'safe'],
            [['number'], 'string', 'max' => 255],
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
            'number' => 'Karta raqami',
            'expire_month' => 'Expire Month',
            'expire_date' => 'Expire Date',
            'status' => 'Status',
            'created' => 'Kiritildi',
            'updated' => 'O`zgartirildi',
        ];
    }

    public function getClient(){
        return $this->hasOne(Client::className(), ['id' => 'client_id']);
    }

}
