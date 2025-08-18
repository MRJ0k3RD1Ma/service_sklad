<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "forniture_service".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $client_id
 * @property int|null $code_id
 * @property string|null $code
 * @property string|null $duedate
 * @property string|null $address
 * @property string|null $phone
 * @property int|null $wall_type_id
 * @property int|null $forniture_id
 * @property float|null $price
 * @property float|null $debt
 * @property float|null $credit
 * @property int|null $register_id
 * @property int|null $modify_id
 * @property string|null $created
 * @property string|null $updated
 * @property int|null $status
 * @property int|null $saled_by_id
 * @property int|null $referal_id
 * @property string|null $ads
 *
 * @property Client $client
 * @property Forniture $forniture
 * @property User $modify
 * @property User $register
 * @property User $saledBy
 * @property User $user
 * @property FornitureWallType $wallType
 */
class FornitureService extends \yii\db\ActiveRecord
{

    public $client_name, $client_phone,$payment_id,$worker_list;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'forniture_service';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'client_id', 'address', 'phone', 'wall_type_id', 'forniture_id', 'price', 'debt', 'credit', 'register_id', 'modify_id', 'saled_by_id', 'referal_id', 'ads'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 1],
            [['user_id', 'client_id', 'wall_type_id','payment_id','sale_id', 'forniture_id', 'register_id', 'modify_id', 'status', 'saled_by_id', 'referal_id','code_id'], 'integer'],
            [['price', 'debt', 'credit','price_agreed'], 'number'],
            [['created', 'updated','code','duedate','worker_list'], 'safe'],
            [['ads'], 'string'],
            [['address', 'phone','client_name','client_phone'], 'string', 'max' => 255],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::class, 'targetAttribute' => ['client_id' => 'id']],
            [['forniture_id'], 'exist', 'skipOnError' => true, 'targetClass' => Forniture::class, 'targetAttribute' => ['forniture_id' => 'id']],
            [['modify_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['modify_id' => 'id']],
            [['register_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['register_id' => 'id']],
            [['saled_by_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['saled_by_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['wall_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => FornitureWallType::class, 'targetAttribute' => ['wall_type_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Register',
            'duedate' => 'Bajarish muddati',
            'payment_id' => 'To`lov turi',
            'code'=>'Shartnoma raqami',
            'client_id' => 'Mijoz',
            'client_name' => 'Mijoz',
            'client_phone' => 'Telefon',
            'address' => 'Manzil',
            'phone' => 'Qo`shimcha telefon',
            'wall_type_id' => 'Devor turi',
            'forniture_id' => 'Buyurtma turi',
            'price' => 'Narxi',
            'price_agreed' => 'Kelishilgan narx',
            'worker_list' => 'Ustalar',
            'debt' => 'To`langan',
            'credit' => 'Qarz',
            'register_id' => 'Register',
            'modify_id' => 'O`zgartiruvchi',
            'created' => 'Kiritildi',
            'updated' => 'O`zgartirildi',
            'status' => 'Status',
            'saled_by_id' => 'Sotuvchi',
            'referal_id' => 'Referal',
            'ads' => 'Izoh',
        ];
    }

    /**
     * Gets query for [[Client]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Client::class, ['id' => 'client_id']);
    }

    /**
     * Gets query for [[Forniture]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getForniture()
    {
        return $this->hasOne(Forniture::class, ['id' => 'forniture_id']);
    }

    public function getCntWorker()
    {
        return $this->getWorkers()->count();
    }


    /**
     * Gets query for [[Modify]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getModify()
    {
        return $this->hasOne(User::class, ['id' => 'modify_id']);
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
     * Gets query for [[SaledBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSaledBy()
    {
        return $this->hasOne(User::class, ['id' => 'saled_by_id']);
    }

    public function getSale()
    {
        return $this->hasOne(Sale::class, ['id' => 'sale_id']);
    }

    public function getFornitureProducts()
    {
        return $this->hasMany(SaleProduct::class, ['sale_id' => 'sale_id']);
    }
    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Gets query for [[WallType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWallType()
    {
        return $this->hasOne(FornitureWallType::class, ['id' => 'wall_type_id']);
    }

    public function getWorkers(){
        return $this->hasMany(FornitureServiceWorker::class, ['service_id' => 'id']);
    }
}
