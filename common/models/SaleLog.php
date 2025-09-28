<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sale_log".
 *
 * @property int $id
 * @property int|null $sale_id
 * @property int|null $register_id
 * @property string|null $state
 * @property string|null $created
 *
 * @property User $register
 * @property Sale $sale
 */
class SaleLog extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const STATE_NEW = 'NEW';
    const STATE_RUNNING = 'RUNNING';
    const STATE_UPDATED = 'UPDATED';
    const STATE_COMPLETED = 'COMPLETED';
    const STATE_CANCELLED = 'CANCELLED';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sale_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sale_id', 'register_id'], 'default', 'value' => null],
            [['state'], 'default', 'value' => 'NEW'],
            [['sale_id', 'register_id'], 'integer'],
            [['state'], 'string'],
            [['created'], 'safe'],
            ['state', 'in', 'range' => array_keys(self::optsState())],
            [['register_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['register_id' => 'id']],
            [['sale_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sale::class, 'targetAttribute' => ['sale_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sale_id' => 'Sale ID',
            'register_id' => 'Register ID',
            'state' => 'State',
            'created' => 'Created',
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
     * Gets query for [[Sale]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSale()
    {
        return $this->hasOne(Sale::class, ['id' => 'sale_id']);
    }


    /**
     * column state ENUM value labels
     * @return string[]
     */
    public static function optsState()
    {
        return [
            self::STATE_NEW => 'NEW',
            self::STATE_RUNNING => 'RUNNING',
            self::STATE_UPDATED => 'UPDATED',
            self::STATE_COMPLETED => 'COMPLETED',
            self::STATE_CANCELLED => 'CANCELLED',
        ];
    }

    /**
     * @return string
     */
    public function displayState()
    {
        return self::optsState()[$this->state];
    }

    /**
     * @return bool
     */
    public function isStateNew()
    {
        return $this->state === self::STATE_NEW;
    }

    public function setStateToNew()
    {
        $this->state = self::STATE_NEW;
    }

    /**
     * @return bool
     */
    public function isStateRunning()
    {
        return $this->state === self::STATE_RUNNING;
    }

    public function setStateToRunning()
    {
        $this->state = self::STATE_RUNNING;
    }

    /**
     * @return bool
     */
    public function isStateUpdated()
    {
        return $this->state === self::STATE_UPDATED;
    }

    public function setStateToUpdated()
    {
        $this->state = self::STATE_UPDATED;
    }

    /**
     * @return bool
     */
    public function isStateCompleted()
    {
        return $this->state === self::STATE_COMPLETED;
    }

    public function setStateToCompleted()
    {
        $this->state = self::STATE_COMPLETED;
    }

    /**
     * @return bool
     */
    public function isStateCancelled()
    {
        return $this->state === self::STATE_CANCELLED;
    }

    public function setStateToCancelled()
    {
        $this->state = self::STATE_CANCELLED;
    }
}
