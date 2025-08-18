<?php

namespace frontend\modules\cp\controllers;

use common\models\Custom;
use common\models\Goods;
use Yii;
use yii\web\Controller;
use Picqer\Barcode\BarcodeGeneratorPNG;
use kartik\mpdf\Pdf;

class BarcodeController extends Controller
{
    public function actionGenerate14($code)
    {

        $generator = new BarcodeGeneratorPNG();
        $barcode = $generator->getBarcode($code, $generator::TYPE_ITF_14); // EAN-14 ishlash uchun TYPE_EAN_13 ni qo‘llang

        // Fayl nomi va yo'li
    $fileName = Yii::getAlias('@webroot') . '/uploads/barcode/' . $code . '.png';
    file_put_contents($fileName, $barcode);

    return Yii::$app->response->sendFile($fileName);
    }
    public function actionGenerate13($code)
    {

        $generator = new BarcodeGeneratorPNG();
        $barcode = $generator->getBarcode($code, $generator::TYPE_EAN_13); // EAN-14 ishlash uchun TYPE_EAN_13 ni qo‘llang

        // Fayl nomi va yo'li
    $fileName = Yii::getAlias('@webroot') . '/uploads/barcode/' . $code . '.png';
    file_put_contents($fileName, $barcode);

    return Yii::$app->response->sendFile($fileName);
    }


    public function actionPdfgen($id)
    {
        if($model = Goods::findOne($id)){
            if (strlen($model->barcode) == 13) {
                $fileName = Yii::getAlias('@webroot') . '/uploads/barcode/' . $model->barcode . '.png';
                if (!file_exists($fileName)) {
                    Yii::$app->runAction('cp/barcode/generate13', ['code' => $model->barcode]);
                }
            } else {
                $fileName = Yii::getAlias('@webroot') . '/uploads/barcode/' . $model->barcode . '.png';
                if (!file_exists($fileName)) {
                    Yii::$app->runAction('cp/barcode/generate14', ['code' => $model->barcode]);
                }
            }

            $url = Yii::getAlias('@web') . '/uploads/barcode/' . $model->barcode . '.png';
            $setting = Custom::findOne(['key'=>'barcode-paper-size']);
            return $this->renderAjax('_'.$setting->value, [
                'model' => $model,
                'url' => $url
            ]);
        }

        return "Bunday mahsulot topilmadi";
    }


}

