<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "paid_client".
 *
 * @property int $client_id
 * @property int $paid_id
 */
class PaidClient extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'paid_client';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_id', 'paid_id'], 'required'],
            [['client_id', 'paid_id'], 'integer'],
            [['client_id', 'paid_id'], 'unique', 'targetAttribute' => ['client_id', 'paid_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'client_id' => 'Client ID',
            'paid_id' => 'Paid ID',
        ];
    }
}
