<?php

namespace common\models;

use Yii;
/**
 * This is the model class for table "goods".
 *
 * @property int $id
 * @property string|null $type 1-mahsulot 2-xizmat
 * @property string|null $name
 * @property string|null $barcode
 * @property int|null $group_id
 * @property int|null $unit_id
 * @property string|null $image
 * @property int|null $status
 * @property string|null $created
 * @property string|null $updated
 * @property float|null $come
 * @property float|null $sale
 * @property float|null $remainder
 * @property float|null $price
 * @property float|null $price_come
 * @property int $barcode_id
 *
 * @property CodeProduct[] $codeProducts
 * @property GoodsGroup $group
 * @property GoodsUnit $unit
 */
class Goods extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'goods';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type'], 'string'],
            [['group_id', 'unit_id', 'status','barcode_id'], 'integer'],
            [['created', 'updated'], 'safe'],
            [['name','group_id','unit_id','price','price_come'],'required'],
            [['come', 'sale', 'remainder','price','price_come','remainder_first'], 'number'],
            [['name', 'barcode', 'image','price_type'], 'string', 'max' => 255],
            [['price_type'], 'in', 'range' => ['SUM', 'RATE']], // This is the enum validation
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => GoodsGroup::class, 'targetAttribute' => ['group_id' => 'id']],
            [['unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => GoodsUnit::class, 'targetAttribute' => ['unit_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Mahsulot/xizmat',
            'name' => 'Nomi',
            'barcode' => 'Barcode',
            'group_id' => 'Turi',
            'unit_id' => 'Birligi',
            'image' => 'Rasmi',
            'status' => 'Status',
            'created' => 'Kiritildi',
            'updated' => 'O`zgartirildi',
            'come' => 'Kelgan',
            'sale' => 'Sotilgan',
            'remainder' => 'Qoldiq',
            'price' => 'Sotilish narxi',
            'barcode_id' => 'Barkod ketmaketligi',
            'price_come' => 'Kelish narxi',
            'price_type'=>'Sotuv turi',
            'remainder_first'=>'Skladdagi birinchi qoldiq',
        ];
    }

    /**
     * Gets query for [[CodeProducts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCodeProducts()
    {
        return $this->hasMany(CodeProduct::class, ['goods_id' => 'id']);
    }

    /**
     * Gets query for [[Group]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(GoodsGroup::class, ['id' => 'group_id']);
    }

    /**
     * Gets query for [[Unit]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUnit()
    {
        return $this->hasOne(GoodsUnit::class, ['id' => 'unit_id']);
    }


}
