<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "md_service_sklad.worker".
 *
 * @property int $id
 * @property string $name
 * @property string|null $phone
 * @property string|null $description
 * @property string|null $image
 * @property int|null $status
 * @property string|null $created
 * @property string|null $updated
 * @property int|null $register_id
 * @property int|null $modify_id
 * @property float|null $balance
 *
 * @property User $register
 * @property User $modify
 */
class Worker extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'worker';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description'], 'string'],
            [['status', 'register_id', 'modify_id'], 'integer'],
            [['created', 'updated'], 'safe'],
            [['balance'], 'number'],
            [['name', 'phone', 'image'], 'string', 'max' => 255],
            [['register_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['register_id' => 'id']],
            [['modify_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['modify_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'name'        => 'Ism Familiya',
            'phone'       => 'Telefon',
            'description' => 'Izoh',
            'image'       => 'Rasm',
            'status'      => 'Holati',
            'created'     => 'Kiritildi',
            'updated'     => 'O‘zgartirildi',
            'register_id' => 'Kiritdi',
            'modify_id'   => 'O`zgartirdi',
            'balance'     => 'Balans',
        ];
    }

    /**
     * Gets query for [[Register]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegister()
    {
        return $this->hasOne(User::class, ['id' => 'register_id']);
    }

    /**
     * Gets query for [[Modify]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getModify()
    {
        return $this->hasOne(User::class, ['id' => 'modify_id']);
    }
}
