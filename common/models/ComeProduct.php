<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "come_product".
 *
 * @property int $id
 * @property int $goods_id
 * @property int $come_id
 * @property float|null $cnt
 * @property float|null $price
 * @property float|null $cnt_price
 *
 * @property Come $come
 * @property Goods $goods
 */
class ComeProduct extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $ostatka,$name;
    public static function tableName()
    {
        return 'come_product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'goods_id', 'come_id'], 'required'],
            [['id', 'goods_id', 'come_id'], 'integer'],
            [['cnt', 'price', 'cnt_price'], 'number'],
            [['id', 'goods_id', 'come_id'], 'unique', 'targetAttribute' => ['id', 'goods_id', 'come_id']],
            [['come_id'], 'exist', 'skipOnError' => true, 'targetClass' => Come::class, 'targetAttribute' => ['come_id' => 'id']],
            [['goods_id'], 'exist', 'skipOnError' => true, 'targetClass' => Goods::class, 'targetAttribute' => ['goods_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'goods_id' => 'Nomi',
            'name' => 'Nomi',
            'come_id' => 'Come ID',
            'cnt' => 'Soni',
            'price' => 'Narxi',
            'cnt_price' => 'Umumiy narxi',
            'ostatka' => 'Qoldiq',
        ];
    }

    /**
     * Gets query for [[Come]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCome()
    {
        return $this->hasOne(Come::class, ['id' => 'come_id']);
    }



    /**
     * Gets query for [[Goods]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGoods()
    {
        return $this->hasOne(Goods::class, ['id' => 'goods_id']);
    }
}
