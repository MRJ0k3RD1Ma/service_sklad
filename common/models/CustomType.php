<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "custom_type".
 *
 * @property int $id
 * @property string $name
 *
 * @property Custom[] $customs
 */
class CustomType extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'custom_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
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
            'name' => 'Sozlama nomi',
        ];
    }

    /**
     * Gets query for [[Customs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCustoms()
    {
        return $this->hasMany(Custom::class, ['type_id' => 'id']);
    }

}
