<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "suppler".
 *
 * @property int $id
 * @property string $name
 * @property string $phone
 * @property string|null $phone_two
 * @property string|null $comment
 * @property string|null $created
 * @property string|null $updated
 * @property float|null $balans
 * @property float|null $debt
 * @property float|null $credit
 * @property int|null $status
 *
 * @property Come[] $comes
 */
class Suppler extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'suppler';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'phone'], 'required'],
            [['created', 'updated'], 'safe'],
            [['balans', 'debt', 'credit'], 'number'],
            [['status'], 'integer'],
            [['name', 'phone', 'phone_two', 'comment'], 'string', 'max' => 255],
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
            'phone' => 'Telefon',
            'phone_two' => 'Qo`shimcha tel',
            'comment' => 'Izoh',
            'created' => 'Kiritildi',
            'updated' => 'O`zgartirildi',
            'balans' => 'Balans',
            'debt' => 'To`lov',
            'credit' => 'Qarz',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Comes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComes()
    {
        return $this->hasMany(Come::class, ['suppler_id' => 'id']);
    }
}
