<?php

namespace frontend\modules\cp\controllers;

use common\models\Client;
use common\models\Paid;
use common\models\Setting;
use common\models\Suppler;
use frontend\components\Common;
use yii\web\Controller;
use Yii;
use yii\web\Response;

/**
 * Default controller for the `cp` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex($year = null)
    {
        if(!$year){
            $year = date('Y');
            $month_number = date('m');
        }else{
            $month_number = 1;
        }
        return $this->render('index',[
            'year' => $year,
            'month_number'=>$month_number,
        ]);
    }

    public function actionDaily($year, $month)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $year = (int)$year;
        $month = (int)$month;

        $query = Paid::find()
            ->select(["DATE(date) as day", "SUM(price) as total"])
            ->where(["YEAR(date)" => $year, "MONTH(date)" => $month])
            ->groupBy(["DATE(date)"])
            ->asArray()
            ->all();

        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $data = [];
        for ($d = 1; $d <= $daysInMonth; $d++) {
            $dateStr = sprintf('%04d-%02d-%02d', $year, $month, $d);
            $data[$dateStr] = 0;
        }

        foreach ($query as $row) {
            $data[$row['day']] = (float)$row['total'];
        }

        $result = [];
        foreach ($data as $day => $total) {
            $result[] = ['x' => $day, 'y' => $total];
        }

        return $result;
    }


    public function actionYearly($year)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return \common\models\Paid::getYearlyData($year);
    }


    public function actionSetting(){
        if($model = Setting::findOne(1)){
            if($model->load(\Yii::$app->request->post())){
                if($model->is_logo){
                    if($model->logo = \yii\web\UploadedFile::getInstance($model, 'logo')){
                        $name = microtime(true).'.'.$model->logo->extension;
                        if(!file_exists(Yii::$app->basePath.'/web/upload/logo')){
                            mkdir(Yii::$app->basePath.'/web/upload/logo', 0777, true);
                        }
                        $model->logo->saveAs(Yii::$app->basePath.'/web/upload/logo/'.$name);
                        $model->logo = $name;
                    }else{
                        $model->is_logo = 0;
                    }
                }else{
                    $model->logo = '';
                }
                if($model->save()){
                    \Yii::$app->session->setFlash('success', 'Sozlamalar saqlandi');
                    return $this->redirect(['setting']);
                }else{
                    \Yii::$app->session->setFlash('error', 'Xatolik yuz berdi');
                }

                return $this->redirect(['setting']);
            }
        }else{
            $model = new Setting();
            $model->id = 1;
            $model->save(false);
        }

        return $this->render('setting', [
            'model' => $model
        ]);

    }

    public function actionPhone()
    {
        $model = Suppler::find()->all();
        foreach ($model as $item){
            $item->phone = Common::getphone($item->phone);
            $item->save(false);
        }
        $model = Client::find()->all();
        foreach ($model as $item){
            $item->phone = Common::getphone($item->phone);
            $item->save(false);
        }
    }


}
