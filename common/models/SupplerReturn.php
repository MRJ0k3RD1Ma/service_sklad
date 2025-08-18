<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "suppler_return".
 *
 * @property int $id
 * @property string $date
 * @property string|null $code
 * @property int $code_id
 * @property string $nakladnoy
 * @property int $suppler_id
 * @property float $price
 * @property string|null $comment
 * @property int $register_id
 * @property int|null $status
 * @property string|null $created
 * @property string|null $updated
 *
 * @property User $register
 * @property Suppler $suppler
 * @property SupplerReturnProduct[] $supplerReturnProducts
 */
class SupplerReturn extends \yii\db\ActiveRecord
{
    public $suppler_name,$suppler_phone,$pro;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'suppler_return';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'code_id','suppler_id', 'price', 'register_id'], 'required'],
            [['date', 'created', 'updated','pro'], 'safe'],
            [['code_id', 'suppler_id', 'register_id', 'status'], 'integer'],
            [['price'], 'number'],
            [['comment'], 'string'],
            [['code', 'nakladnoy','suppler_name','suppler_phone'], 'string', 'max' => 255],
            [['register_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['register_id' => 'id']],
            [['suppler_id'], 'exist', 'skipOnError' => true, 'targetClass' => Suppler::class, 'targetAttribute' => ['suppler_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Sana',
            'code' => 'Kod',
            'code_id' => 'Code ID',
            'nakladnoy' => 'Nakladnoy',
            'suppler_id' => 'Yetkazuvchi',
            'price' => 'Narxi',
            'comment' => 'Izoh',
            'register_id' => 'Kiritdi',
            'status' => 'Status',
            'created' => 'Kiritldi',
            'updated' => 'O`zgaritirildi',
            'suppler_name'=>'Yetkazuvchi nomi',
            'suppler_phone'=>'Telefon',
        ];
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
     * Gets query for [[Suppler]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSuppler()
    {
        return $this->hasOne(Suppler::class, ['id' => 'suppler_id']);
    }

    /**
     * Gets query for [[SupplerReturnProducts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSupplerReturnProducts()
    {
        return $this->hasMany(SupplerReturnProduct::class, ['come_id' => 'id']);
    }
}
