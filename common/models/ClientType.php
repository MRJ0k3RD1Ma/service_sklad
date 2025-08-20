<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "client_type".
 *
 * @property int $id
 * @property string $name
 * @property int|null $status
 * @property string|null $created
 * @property string|null $updated
 * @property int|null $register_id
 * @property int|null $modify_id
 */
class ClientType extends ActiveRecord
{
    public static function tableName()
    {
        return 'client_type';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['status', 'register_id', 'modify_id'], 'integer'],
            [['created', 'updated'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'status' => 'Status',
            'created' => 'Created At',
            'updated' => 'Updated At',
            'register_id' => 'Register ID',
            'modify_id' => 'Modify ID',
        ];
    }
}
