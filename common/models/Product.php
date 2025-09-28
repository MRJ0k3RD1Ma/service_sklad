<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "md_service_sklad.product".
 *
 * @property int $id
 * @property string|null $type  1-mahsulot 2-xizmat
 * @property string|null $name
 * @property int|null $group_id
 * @property int|null $unit_id
 * @property string|null $image
 * @property int|null $status
 * @property string|null $created
 * @property string|null $updated
 * @property float|null $price
 * @property int|null $register_id
 * @property int|null $modify_id
 * @property float|null $min_volume
 * @property float|null $volume_price
 *
 * @property ProductGroup $group
 * @property ProductUnit $unit
 * @property User $register
 * @property User $modify
 */
class Product extends \yii\db\ActiveRecord
{
    const TYPE_SERVICE = 'SERVICE';
    const TYPE_PRODUCT = 'PRODUCT';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'md_service_sklad.product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['group_id', 'unit_id', 'status', 'register_id', 'modify_id'], 'integer'],
            [['created', 'updated'], 'safe'],
            [['group_id','unit_id','price','name','price_worker'],'required'],
            [['price', 'min_volume', 'volume_price','price_worker'], 'number'],
            [['type'], 'in', 'range' => [self::TYPE_SERVICE, self::TYPE_PRODUCT]],
            [['name', 'image'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Turi',
            'name' => 'Nomi',
            'group_id' => 'Guruhi',
            'unit_id' => 'Birligi',
            'image' => 'Rasm',
            'status' => 'Holati',
            'created' => 'Kiritildi',
            'updated' => 'O`zgartirildi',
            'price' => 'Birlik narxi',
            'price_worker' => 'Brigadirga birlik narxi',
            'register_id' => 'Kiritdi',
            'modify_id' => 'O`zgartirdi',
            'min_volume' => 'Minimal hajm',
            'volume_price' => 'Minimal narx',
        ];
    }

    /**
     * Gets query for [[Group]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(ProductGroup::class, ['id' => 'group_id']);
    }

    /**
     * Gets query for [[Unit]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUnit()
    {
        return $this->hasOne(ProductUnit::class, ['id' => 'unit_id']);
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
