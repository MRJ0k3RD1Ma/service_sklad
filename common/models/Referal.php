<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "referal".
 *
 * @property int $id
 * @property string $name
 * @property string $phone
 * @property string|null $phone_ads
 * @property string|null $ads
 * @property int $group_id
 * @property int $price_type
 * @property float $price
 * @property int|null $status
 * @property string|null $created
 * @property string|null $updated
 */
class Referal extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'referal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['phone_ads', 'ads'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 1],
            [['name', 'phone', 'group_id', 'price_type', 'price'], 'required'],
            [['ads'], 'string'],
            [['group_id', 'price_type', 'status'], 'integer'],
            [['price'], 'number'],
            [['created', 'updated'], 'safe'],
            [['name', 'phone', 'phone_ads'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'phone' => 'Phone',
            'phone_ads' => 'Phone Ads',
            'ads' => 'Ads',
            'group_id' => 'Group ID',
            'price_type' => 'Price Type',
            'price' => 'Price',
            'status' => 'Status',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }

}
