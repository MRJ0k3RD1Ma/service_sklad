<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "goods".
 *
 * @property int $id
 * @property string|null $type
 * @property string|null $name
 * @property int|null $group_id
 * @property string|null $image
 * @property int|null $status
 * @property string|null $created
 * @property string|null $updated
 * @property float|null $price
 * @property int|null $register_id
 * @property int|null $modify_id
 *
 * @property ProductGroup $group
 */
class Product extends ActiveRecord
{
    public static function tableName()
    {
        return 'product';
    }

    public function rules()
    {
        return [
            [['group_id', 'status', 'register_id', 'modify_id'], 'integer'],
            [['price'], 'number'],
            [['created', 'updated'], 'safe'],
            [['type'], 'in', 'range' => ['SERVICE', 'PRODUCT']],
            [['name', 'image'], 'string', 'max' => 255],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductGroup::class, 'targetAttribute' => ['group_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Turi',
            'name' => 'Nomi',
            'group_id' => 'Guruhi',
            'image' => 'Rasm',
            'price' => 'Narxi',
            'status' => 'Status',
            'created' => 'Kiritildi',
            'updated' => 'O`zgartirildi',
            'register_id' => 'Kiritdi',
            'modify_id' => 'O`zgartirdi',
        ];
    }

    /**
     * Relation: GoodsGroup
     */
    public function getGroup()
    {
        return $this->hasOne(ProductGroup::class, ['id' => 'group_id']);
    }
}
