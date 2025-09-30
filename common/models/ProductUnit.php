<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "md_service_sklad.product_unit".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $status
 * @property string|null $created
 * @property string|null $updated
 * @property int|null $register_id
 * @property int|null $modify_id
 *
 * @property User $register
 * @property User $modify
 */
class ProductUnit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_unit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'register_id', 'modify_id'], 'integer'],
            [['created', 'updated'], 'safe'],
            [['name'],'required'],

            [['name'], 'string', 'max' => 255],
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
            'id' => 'ID',
            'name' => 'Nomi',
            'status' => 'Status',
            'created' => 'Kiritildi',
            'updated' => 'O‘zgartirildi',
            'register_id' => 'Kiritdi',
            'modify_id' => 'O‘zgartirdi',
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
