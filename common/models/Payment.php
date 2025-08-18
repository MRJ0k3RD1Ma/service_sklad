<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "payment".
 *
 * @property int $id
 * @property string|null $name
 *
 * @property Paid[] $pas
 */
class Payment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Turi',
        ];
    }

    /**
     * Gets query for [[Pas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPaid()
    {
        return $this->hasMany(Paid::class, ['payment_id' => 'id']);
    }
}
