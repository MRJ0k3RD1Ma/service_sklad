<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "forniture_service_history".
 *
 * @property int $id
 * @property int $service_id
 * @property int $user_id
 * @property string|null $created
 * @property string|null $old_state
 * @property string|null $state
 */
class FornitureServiceHistory extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const OLD_STATE_NEW = 'NEW';
    const OLD_STATE_CALC = 'CALC';
    const OLD_STATE_RUNNING = 'RUNNING';
    const OLD_STATE_DONE = 'DONE';
    const OLD_STATE_COMPLETED = 'COMPLETED';
    const STATE_NEW = 'NEW';
    const STATE_CALC = 'CALC';
    const STATE_RUNNING = 'RUNNING';
    const STATE_DONE = 'DONE';
    const STATE_COMPLETED = 'COMPLETED';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'forniture_service_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['state'], 'default', 'value' => 'NEW'],
            [['service_id', 'user_id'], 'required'],
            [['service_id', 'user_id'], 'integer'],
            [['created'], 'safe'],
            [['old_state', 'state'], 'string'],
            ['old_state', 'in', 'range' => array_keys(self::optsOldState())],
            ['state', 'in', 'range' => array_keys(self::optsState())],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'service_id' => 'Service ID',
            'user_id' => 'User ID',
            'created' => 'Created',
            'old_state' => 'Old State',
            'state' => 'State',
        ];
    }


    /**
     * column old_state ENUM value labels
     * @return string[]
     */
    public static function optsOldState()
    {
        return [
            self::OLD_STATE_NEW => 'NEW',
            self::OLD_STATE_CALC => 'CALC',
            self::OLD_STATE_RUNNING => 'RUNNING',
            self::OLD_STATE_DONE => 'DONE',
            self::OLD_STATE_COMPLETED => 'COMPLETED',
        ];
    }

    /**
     * column state ENUM value labels
     * @return string[]
     */
    public static function optsState()
    {
        return [
            self::STATE_NEW => 'NEW',
            self::STATE_CALC => 'CALC',
            self::STATE_RUNNING => 'RUNNING',
            self::STATE_DONE => 'DONE',
            self::STATE_COMPLETED => 'COMPLETED',
        ];
    }

    /**
     * @return string
     */
    public function displayOldState()
    {
        return self::optsOldState()[$this->old_state];
    }

    /**
     * @return bool
     */
    public function isOldStateNew()
    {
        return $this->old_state === self::OLD_STATE_NEW;
    }

    public function setOldStateToNew()
    {
        $this->old_state = self::OLD_STATE_NEW;
    }

    /**
     * @return bool
     */
    public function isOldStateCalc()
    {
        return $this->old_state === self::OLD_STATE_CALC;
    }

    public function setOldStateToCalc()
    {
        $this->old_state = self::OLD_STATE_CALC;
    }

    /**
     * @return bool
     */
    public function isOldStateRunning()
    {
        return $this->old_state === self::OLD_STATE_RUNNING;
    }

    public function setOldStateToRunning()
    {
        $this->old_state = self::OLD_STATE_RUNNING;
    }

    /**
     * @return bool
     */
    public function isOldStateDone()
    {
        return $this->old_state === self::OLD_STATE_DONE;
    }

    public function setOldStateToDone()
    {
        $this->old_state = self::OLD_STATE_DONE;
    }

    /**
     * @return bool
     */
    public function isOldStateCompleted()
    {
        return $this->old_state === self::OLD_STATE_COMPLETED;
    }

    public function setOldStateToCompleted()
    {
        $this->old_state = self::OLD_STATE_COMPLETED;
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
    public function isStateCalc()
    {
        return $this->state === self::STATE_CALC;
    }

    public function setStateToCalc()
    {
        $this->state = self::STATE_CALC;
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
    public function isStateDone()
    {
        return $this->state === self::STATE_DONE;
    }

    public function setStateToDone()
    {
        $this->state = self::STATE_DONE;
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
}
