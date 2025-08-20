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
 * @property string|null $image
 * @property int|null $status
 * @property string|null $created
 * @property string|null $updated
 * @property float|null $price
 *
 * @property GoodsGroup $group
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
            [['group_id', 'status',], 'integer'],
            [['created', 'updated'], 'safe'],
            [['name','group_id','price',],'required'],
            [['price',], 'number'],
            [['name', 'barcode', 'image','price_type'], 'string', 'max' => 255],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => GoodsGroup::class, 'targetAttribute' => ['group_id' => 'id']],
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
            'group_id' => 'Turi',
            'image' => 'Rasmi',
            'status' => 'Status',
            'created' => 'Kiritildi',
            'updated' => 'O`zgartirildi',
            'price' => 'Sotilish narxi',
        ];
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


    public function getRegister()
    {
        return $this->hasOne(User::class, ['id' => 'register_id']);
    }

    public function getModify(){
        return $this->hasOne(User::class, ['id' => 'modify_id']);
    }

}
