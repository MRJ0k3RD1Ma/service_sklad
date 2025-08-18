<?php

namespace frontend\modules\cp\controllers;

use common\models\Custom;
use common\models\CustomType;
use common\models\search\CustomTypeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
/**
 * CustomTypeController implements the CRUD actions for CustomType model.
 */
class CustomTypeController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all CustomType models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new CustomTypeSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSetting($id)
    {
        if($model = CustomType::findOne($id)){
            $setting = Custom::find()->where(['type_id' => $id])->all();

            // Process form submission
            if (Yii::$app->request->isPost) {
                $postData = Yii::$app->request->post('Custom');
                echo "<pre>";
                foreach ($postData as $key => $value) {

                    // Find existing setting or create new
                    $customSetting = Custom::findOne(['type_id' => $id, 'key' => $key]);

                    $customSetting->value = "$value";

                    if (!$customSetting->save(false)) {
                        var_dump($customSetting);
                        exit;
                    }

                }
                Yii::$app->session->setFlash('success', 'Sozlamalar muvaffaqiyatli saqlandi');
                return $this->refresh();
            }

            return $this->render('setting', [
                'model' => $model,
                'setting' => $setting,
            ]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }



}
