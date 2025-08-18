<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "setting".
 *
 * @property int $id
 * @property int|null $is_logo
 * @property string|null $logo
 * @property string|null $name
 * @property string|null $phone
 * @property string|null $address
 * @property string|null $qr_url
 * @property int|null $logo_size
 * @property int|null $balans
 * @property string|null $date_start
 * @property string|null $date_end
 * @property int|null $status
 * @property string|null $created
 * @property string|null $updated
 */
class Setting extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'setting';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['logo', 'name', 'phone', 'address', 'qr_url', 'date_start', 'date_end', 'created', 'updated'], 'default', 'value' => null],
            [['balans'], 'default', 'value' => 0],
            [['status'], 'default', 'value' => 1],
            [['is_logo',  'balans', 'status','logo_size'], 'integer'],
            [['date_start', 'date_end', 'created', 'updated'], 'safe'],
            [['logo', 'name', 'phone', 'address', 'qr_url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_logo' => 'Chekga Logo chiqarish',
            'logo' => 'Logo',
            'logo_size' => 'Logo hajmi(foizda)',
            'name' => 'Tashkilot nomi',
            'phone' => 'Telefon',
            'address' => 'Manzil',
            'qr_url' => 'Qr Url',
            'balans' => 'Balans',
            'date_start' => 'Date Start',
            'date_end' => 'Date End',
            'status' => 'Status',
            'created' => 'Kiritildi',
            'updated' => 'O`zgartirldi',
        ];
    }

}
