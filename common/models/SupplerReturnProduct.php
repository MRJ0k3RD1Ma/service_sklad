<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "suppler_return_product".
 *
 * @property int $id
 * @property int $goods_id
 * @property int $come_id
 * @property float|null $cnt
 * @property float|null $price
 * @property float|null $cnt_price
 *
 * @property SupplerReturn $come
 * @property Goods $goods
 */
class SupplerReturnProduct extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'suppler_return_product';
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
            [['come_id'], 'exist', 'skipOnError' => true, 'targetClass' => SupplerReturn::class, 'targetAttribute' => ['come_id' => 'id']],
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
            'goods_id' => 'Goods ID',
            'come_id' => 'Come ID',
            'cnt' => 'Cnt',
            'price' => 'Price',
            'cnt_price' => 'Cnt Price',
        ];
    }

    /**
     * Gets query for [[Come]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCome()
    {
        return $this->hasOne(SupplerReturn::class, ['id' => 'come_id']);
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
