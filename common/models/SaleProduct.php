<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sale_product".
 *
 * @property int $id
 * @property int $sale_id
 * @property int $product_id
 * @property int $user_id
 * @property float $price
 * @property float $cnt
 * @property float $cnt_price
 */
class SaleProduct extends \yii\db\ActiveRecord
{
    public $topcount;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sale_product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sale_id', 'product_id', 'user_id', 'price', 'cnt', 'cnt_price'], 'required'],
            [['sale_id', 'product_id', 'user_id'], 'integer'],
            [['price', 'cnt', 'cnt_price'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sale_id' => 'Chek raqami',
            'product_id' => 'Mahsulot nomi',
            'user_id' => 'Sotuvchi',
            'price' => 'Narxi',
            'cnt' => 'Soni',
            'cnt_price' => 'Umumiy narxi',
        ];
    }

    public function getProduct(){
        return $this->hasOne(Goods::className(), ['id' => 'product_id']);
    }

    public function getUser(){
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getSale(){
        return $this->hasOne(Sale::className(), ['id' => 'sale_id']);
    }


    public static function getYearlyData($year,$id)
    {
        $query = self::find()
            ->select(['MONTH(sale.created) as month', 'ROUND(SUM(sale_product.cnt),1) as total'])
            ->innerJoin('sale','sale.id = sale_product.sale_id and sale.status = 1')
            ->where(['YEAR(sale.created)' => $year,'sale_product.product_id'=>$id])
            ->groupBy(['MONTH(sale.created)'])
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

}
