<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "client_type".
 *
 * @property int $id
 * @property string $name
 *
 * @property Client[] $clients
 */
class ClientType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            ['status','integer'],
            [['register_id','modify_id'],'integer'],
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
            'register_id' => 'Register',
            'modify_id' => 'O`zgartirdi',
        ];
    }

    /**
     * Gets query for [[Clients]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClients()
    {
        return $this->hasMany(Client::class, ['type_id' => 'id']);
    }

    public function getRegister(){
        return $this->hasOne(User::className(), ['id' => 'register_id']);
    }

    public function getModify(){
        return $this->hasOne(User::className(), ['id' => 'modify_id']);
    }
}
