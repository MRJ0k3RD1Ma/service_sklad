<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "product_group".
 *
 * @property int $id
 * @property string $name
 * @property int|null $status
 * @property string|null $image
 * @property string $type
 * @property string|null $created
 * @property string|null $updated
 * @property int|null $register_id
 * @property int|null $modify_id
 */
class ProductGroup extends ActiveRecord
{
    public static function tableName()
    {
        return 'product_group';
    }

    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            [['status', 'register_id', 'modify_id'], 'integer'],
            [['created', 'updated'], 'safe'],
            [['type'], 'in', 'range' => ['SERVICE', 'PRODUCT']],
            [['name', 'image'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Nomi',
            'image' => 'Rasm',
            'type' => 'Turi',
            'status' => 'Status',
            'created' => 'Kiritildi',
            'updated' => 'O`zgartirildi',
            'register_id' => 'Kiritdi',
            'modify_id' => 'O`zgartirdi',
        ];
    }
}
