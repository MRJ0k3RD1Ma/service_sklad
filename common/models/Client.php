<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "md_service_sklad.client".
 *
 * @property int $id
 * @property string $image
 * @property int|null $type_id
 * @property string $name
 * @property string|null $phone
 * @property string|null $phone_two
 * @property string|null $comment
 * @property float|null $balance
 * @property float|null $credit
 * @property float|null $debt
 * @property int|null $status
 * @property string|null $created
 * @property string|null $updated
 * @property int|null $register_id
 * @property int|null $modify_id
 *
 * @property ClientType $type
 */
class Client extends ActiveRecord
{
    public static function tableName()
    {
        // Schema + jadval nomi
        return 'client';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['type_id', 'status', 'register_id', 'modify_id'], 'integer'],
            [['balance', 'credit', 'debt'], 'number'],
            [['created', 'updated'], 'safe'],
            [['image', 'name', 'phone', 'phone_two', 'comment'], 'string', 'max' => 255],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ClientType::class, 'targetAttribute' => ['type_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image' => 'Image',
            'type_id' => 'Client Type',
            'name' => 'Name',
            'phone' => 'Phone',
            'phone_two' => 'Phone Two',
            'comment' => 'Comment',
            'balance' => 'Balance',
            'credit' => 'Credit',
            'debt' => 'Debt',
            'status' => 'Status',
            'created' => 'Created At',
            'updated' => 'Updated At',
            'register_id' => 'Register ID',
            'modify_id' => 'Modify ID',
        ];
    }

    /**
     * Relation: ClientType
     */
    public function getType()
    {
        return $this->hasOne(ClientType::class, ['id' => 'type_id']);
    }
}
