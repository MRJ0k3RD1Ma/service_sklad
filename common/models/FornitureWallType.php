<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "forniture_wall_type".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $status
 * @property string|null $created
 * @property string|null $updated
 *
 * @property FornitureService[] $fornitureServices
 */
class FornitureWallType extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'forniture_wall_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 1],
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
            'name' => 'Devor turi nomi',
            'status' => 'Status',
            'created' => 'Kiritildi',
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
        return $this->hasMany(FornitureService::class, ['wall_type_id' => 'id']);
    }

}
