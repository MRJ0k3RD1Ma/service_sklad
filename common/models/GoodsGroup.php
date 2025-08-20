<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "goods_group".
 *
 * @property int $id
 * @property string $name
 * @property int|null $status
 * @property string|null $image
 *
 * @property Goods[] $goods
 */
class GoodsGroup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'goods_group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['status'], 'integer'],
            [['register_id','modify_id'],'integer'],
            [['name', 'image','type',], 'string', 'max' => 255],
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
            'image' => 'Rasm',
            'register_id' => 'Register',
            'modify_id' => 'O`zgartirdi',
        ];
    }

    /**
     * Gets query for [[Goods]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGoods()
    {
        return $this->hasMany(Goods::class, ['group_id' => 'id']);
    }
    public function getRegister()
    {
        return $this->hasOne(User::class, ['id' => 'register_id']);
    }

    public function getModify(){
        return $this->hasOne(User::class, ['id' => 'modify_id']);
    }
}
