<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "md_service_sklad.sale".
 *
 * @property int $id
 * @property string|null $date
 * @property string|null $code
 * @property int|null $code_id
 * @property int $client_id
 * @property int $product_id
 * @property float|null $price
 * @property float|null $debt
 * @property float|null $credit
 * @property int $worker_id
 * @property string|null $state
 * @property string|null $created
 * @property string|null $updated
 * @property int|null $register_id
 * @property int|null $modify_id
 * @property int|null $status
 * @property float|null $volume
 * @property float|null $volume_estimated
 * @property string|null $address
 *
 * @property Client $client
 * @property Product $product
 * @property Worker $worker
 * @property User $register
 * @property User $modify
 */
class Sale extends ActiveRecord
{
    public const STATE_NEW     = 'NEW';
    public const STATE_RUNNING = 'RUNNING';
    public const STATE_DONE    = 'DONE';

    public static function tableName()
    {
        return 'sale';
    }

    public function rules()
    {
        return [
            [['client_id', 'product_id', 'worker_id'], 'required'],
            [['client_id', 'product_id', 'worker_id', 'code_id', 'register_id', 'modify_id', 'status'], 'integer'],
            [['price', 'debt', 'credit', 'volume', 'volume_estimated'], 'number'],
            [['date', 'created', 'updated'], 'safe'],
            [['code', 'address'], 'string', 'max' => 255],
            ['state', 'in', 'range' => [self::STATE_NEW, self::STATE_RUNNING, self::STATE_DONE]],

            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::class, 'targetAttribute' => ['client_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
            [['worker_id'], 'exist', 'skipOnError' => true, 'targetClass' => Worker::class, 'targetAttribute' => ['worker_id' => 'id']],
            [['register_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['register_id' => 'id']],
            [['modify_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['modify_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Sana',
            'code' => 'Kod',
            'code_id' => 'Kod ID',
            'client_id' => 'Mijoz',
            'product_id' => 'Xizmat',
            'price' => 'Narx',
            'debt' => 'Qarz',
            'credit' => 'Kredit',
            'worker_id' => 'Xodim',
            'state' => 'Holat',
            'created' => 'Kiritildi',
            'updated' => 'O`zgartirildi',
            'register_id' => 'Kiritdi',
            'modify_id' => 'O`zgartirdi',
            'status' => 'Status',
            'volume' => 'Real Hajm',
            'volume_estimated' => 'Taxminiy hajm',
            'address' => 'Manzil',
        ];
    }

    public static function getStateList(): array
    {
        return [
            self::STATE_NEW => 'NEW',
            self::STATE_RUNNING => 'RUNNING',
            self::STATE_DONE => 'DONE',
        ];
    }

    public function getClient()
    {
        return $this->hasOne(Client::class, ['id' => 'client_id']);
    }

    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    public function getWorker()
    {
        return $this->hasOne(Worker::class, ['id' => 'worker_id']);
    }

    public function getRegister()
    {
        return $this->hasOne(User::class, ['id' => 'register_id']);
    }

    public function getModify()
    {
        return $this->hasOne(User::class, ['id' => 'modify_id']);
    }
}
