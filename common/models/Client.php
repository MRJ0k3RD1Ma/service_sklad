<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "client".
 *
 * @property int $id
 * @property string $image
 * @property int|null $type_id
 * @property string $name
 * @property string|null $phone
 * @property string|null $phone_two
 * @property string|null $comment
 * @property float|null $balance
 * @property int|null $status
 * @property string|null $created
 * @property string|null $updated
 * @property int|null $register_id
 * @property int|null $modify_id
 *
 * @property User $register
 * @property User $modify
 * @property ClientType $type
 */
class Client extends ActiveRecord
{
    public static function tableName()
    {
        return 'client';
    }

    public function rules()
    {
        return [
            [['name','phone'], 'required'],
            [['type_id', 'status', 'register_id', 'modify_id'], 'integer'],
            [['balance'], 'number'],
            [['created', 'updated'], 'safe'],
            [['image', 'name', 'phone', 'phone_two', 'comment'], 'string', 'max' => 255],
            [['register_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['register_id' => 'id']],
            [['modify_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['modify_id' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ClientType::class, 'targetAttribute' => ['type_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image' => 'Rasm',
            'type_id' => 'Mijoz turi',
            'name' => 'Ism / Nomi',
            'phone' => 'Telefon raqam',
            'phone_two' => 'Qo‘shimcha telefon',
            'comment' => 'Izoh',
            'balance' => 'Balans',
            'status' => 'Status',
            'created' => 'Kiritildi',
            'updated' => 'O`zgartirildi',
            'register_id' => 'Kiritdi',
            'modify_id' => 'O`zgartirdi',
        ];
    }

    public function getRegister()
    {
        return $this->hasOne(User::class, ['id' => 'register_id']);
    }

    public function getModify()
    {
        return $this->hasOne(User::class, ['id' => 'modify_id']);
    }

    public function getType()
    {
        return $this->hasOne(ClientType::class, ['id' => 'type_id']);
    }
}
