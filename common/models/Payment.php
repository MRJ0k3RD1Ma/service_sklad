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
            [['created','updated'],'safe'],
            [['status','register_id','modify_id'],'integer'],
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
            'created' => 'Kiritildi',
            'updated' => 'O`zgartirildi',
            'status' => 'Status',
            'register_id' => 'Register',
            'modify_id' => 'O`zgartirdi',
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

    public function getRegister()
    {
        return $this->hasOne(User::class, ['id' => 'register_id']);
    }

    public function getModify(){
        return $this->hasOne(User::class, ['id' => 'modify_id']);
    }

}
