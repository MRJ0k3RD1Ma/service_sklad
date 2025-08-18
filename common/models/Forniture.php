<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "forniture".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $status
 * @property string|null $created
 * @property string|null $updated
 *
 * @property FornitureService[] $fornitureServices
 */
class Forniture extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'forniture';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'status'], 'default', 'value' => null],
            [['status'], 'integer'],
            [['created', 'updated'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Buyurtma nomi',
            'status' => 'Status',
            'created' => 'Yaratildi',
            'updated' => 'O`zgartirildi',
        ];
    }

    /**
     * Gets query for [[FornitureServices]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFornitureServices()
    {
        return $this->hasMany(FornitureService::class, ['forniture_id' => 'id']);
    }

}
