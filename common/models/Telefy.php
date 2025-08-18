<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "telefy".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $chat_id
 * @property int|null $status
 * @property string|null $created
 * @property string|null $updated
 */
class Telefy extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'telefy';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'chat_id'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 1],
            [['status'], 'integer'],
            [['created', 'updated'], 'safe'],
            [['name', 'chat_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'chat_id' => 'Chat ID',
            'status' => 'Status',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }

}
