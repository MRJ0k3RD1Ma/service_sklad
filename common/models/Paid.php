<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "paid".
 *
 * @property int $id
 * @property int|null $sale_id
 * @property float $price
 * @property int $payment_id
 * @property string|null $date
 * @property int|null $status
 * @property string|null $created
 * @property string|null $updated
 * @property int|null $register_id
 * @property int|null $modify_id
 * @property string|null $type
 *
 * @property User $modify
 * @property Payment $payment
 * @property User $register
 * @property Sale $sale
 */
class Paid extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'paid';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sale_id', 'payment_id', 'status', 'register_id', 'modify_id'], 'integer'],
            [['price', 'payment_id'], 'required'],
            [['price'], 'number'],
            [['date', 'created', 'updated'], 'safe'],
            [['type'], 'string'],
            [['modify_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['modify_id' => 'id']],
            [['payment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Payment::class, 'targetAttribute' => ['payment_id' => 'id']],
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
            'sale_id' => 'Sotuv',
            'price' => 'Summa',
            'payment_id' => 'To`lov turi',
            'date' => 'Sana',
            'status' => 'Status',
            'created' => 'Kiritildi',
            'updated' => 'O`zgartirildi',
            'register_id' => 'Kiritdi',
            'modify_id' => 'O`zgartirdi',
            'type' => 'Turi',
        ];
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
     * Gets query for [[Payment]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPayment()
    {
        return $this->hasOne(Payment::class, ['id' => 'payment_id']);
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

    public function getPaidClient()
    {
        return $this->hasMany(PaidClient::class, ['paid_id' => 'id']);
    }

    public function getClient()
    {
        return $this->hasMany(Client::class, ['id' => 'client_id'])->viaTable('paid_client', ['paid_id' => 'id']);
    }

    public static function getYearlyData($year){

        $query = self::find()
            ->select(['MONTH(date) as month', 'SUM(price) as total'])
            ->where(['YEAR(date)' => $year])
            ->groupBy(['MONTH(date)'])
            ->asArray()
            ->all();

        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $data[$i] = 0; // Initialize all months to 0
        }

        foreach ($query as $row) {
            $data[$row['month']] = (float)$row['total']; // Assign the total to the corresponding month
        }

        return array_values($data);
    }

//    public function getYearlyData($year){
//
//        $query = self::find()
//            ->select(["DATE(date) as day", "SUM(price) as total"])
//            ->where(["YEAR(date)" => $year])
//            ->groupBy(["DATE(date)"])
//            ->asArray()
//            ->all();
//
//        $data = [];
//        $start = new \DateTime("$year-01-01");
//        $end = new \DateTime("$year-12-31");
//
//        while ($start <= $end) {
//            $data[$start->format('Y-m-d')] = 0;
//            $start->modify('+1 day');
//        }
//
//        foreach ($query as $row) {
//            $data[$row['day']] = (float)$row['total'];
//        }
//
//        $result = [];
//        foreach ($data as $day => $total) {
//            $result[] = [
//                'x' => $day,
//                'y' => $total
//            ];
//        }
//
//        return $result;
//    }

    public static function getMonths(){
        return array_values([
            1 => 'Yanvar',
            2 => 'Fevral',
            3 => 'Mart',
            4 => 'Aprel',
            5 => 'May',
            6 => 'Iyun',
            7 => 'Iyul',
            8 => 'Avgust',
            9 => 'Sentabr',
            10 => 'Oktabr',
            11 => 'Noyabr',
            12 => 'Dekabr'
        ]);
    }

    public function getTopProductsData(){

        $saleProducts = SaleProduct::find()->select(['sale_product.*','round(sum(sale_product.cnt)) as topcount'])
            ->innerJoin('sale', 'sale.id = sale_product.sale_id and sale.status = 1')
            ->andFilterWhere(['like','sale.created',date('Y-m-')])
            ->groupBy(['sale_product.product_id'])
            ->orderBy(['topcount' => SORT_DESC])
            ->limit(20)->all();

        $data = [];
        foreach ($saleProducts as $item){
            $data[] = [
                'x'=>$item->product->name,
                'y'=>$item->topcount,
                't'=>$item->product_id,
                'f'=>$item->product->unit->name
            ];
        }
        return $data;
    }
}
