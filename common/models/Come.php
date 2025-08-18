<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "come".
 *
 * @property int $id
 * @property string $date
 * @property int $suppler_id
 * @property float $price
 * @property string|null $comment
 * @property string $nakladnoy
 * @property int $register_id
 * @property int|null $status
 * @property int|null $code_id
 * @property string|null $code
 * @property string|null $created
 * @property string|null $updated
 *
 * @property ComeProduct[] $comeProducts
 * @property User $register
 * @property Suppler $suppler
 */
class Come extends \yii\db\ActiveRecord
{
    public $suppler_name,$suppler_phone,$pro;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'come';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'suppler_id', 'price', 'register_id'], 'required'],
            [['date', 'created', 'updated','pro'], 'safe'],
            [['suppler_id', 'register_id', 'status','code_id'], 'integer'],
            [['price'], 'number'],
            [['comment','suppler_name','suppler_phone','nakladnoy','code'], 'string'],
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
            'suppler_name' => 'Yetkazuvchi',
            'suppler_phone' => 'Yetkazuvchi tel',
            'suppler_id' => 'Yetkazib beruvchi',
            'price' => 'Umumiy narx',
            'comment' => 'Izoh',
            'register_id' => 'Register',
            'nakladnoy' => 'Nakladnoy',
            'status' => 'Status',
            'created' => 'Kiritildi',
            'updated' => 'O`zgartirildi',
        ];
    }

    /**
     * Gets query for [[CodeProducts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComeProducts()
    {
        return $this->hasMany(ComeProduct::class, ['come_id' => 'id']);
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
}
