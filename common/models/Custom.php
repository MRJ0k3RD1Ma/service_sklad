<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "custom".
 *
 * @property int $id
 * @property string|null $key
 * @property int $type_id
 * @property string|null $name
 * @property string|null $value
 * @property string|null $value_type
 * @property string|null $value_elements
 *
 * @property CustomType $type
 */
class Custom extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'custom';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['key', 'name', 'value', 'value_type', 'value_elements'], 'default', 'value' => null],
            [['type_id'], 'integer'],
            [['value_elements'], 'string'],
            [['key', 'name', 'value', 'value_type'], 'string', 'max' => 255],
            [['key'], 'unique'],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => CustomType::class, 'targetAttribute' => ['type_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key' => 'Key',
            'type_id' => 'Type ID',
            'name' => 'Name',
            'value' => 'Value',
            'value_type' => 'Value Type',
            'value_elements' => 'Value Elements',
        ];
    }

    /**
     * Gets query for [[Type]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(CustomType::class, ['id' => 'type_id']);
    }

}
