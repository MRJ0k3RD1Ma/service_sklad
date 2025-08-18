<?php

namespace frontend\modules\cp\controllers;

use common\models\Come;
use common\models\ComeProduct;
use common\models\Goods;
use common\models\search\ComeSearch;
use common\models\search\GoodsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use arturoliveira\ExcelView;

/**
 * ComeController implements the CRUD actions for Come model.
 */
class ComeController extends Controller
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
     * Lists all Come models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ComeSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Come model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Come model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($come_id)
    {
        $model = new ComeProduct();
        if($model->load($this->request->post())){
            $model->come_id = $come_id;
            $id = ComeProduct::find()->where(['come_id' => $come_id,'goods_id'=>$model->goods_id])->max('id');
            if(!$id){
                $id = 0;
            }
            $id++;
            $model->id = $id;
            $model->cnt_price = $model->price*$model->cnt;
            if($model->save(false)){
                // ostatkaga ham qo'shish kerak
                $goods = Goods::findOne($model->goods_id);
                $goods->come += $model->cnt;
                $goods->remainder += $model->cnt;
                $goods->save(false);
                $come = Come::findOne($come_id);
                $price = 0;
                foreach ($come->comeProducts as $item){
                    $price += $item->price*$item->cnt;
                }
                $come->price = $price;
                $come->save(false);
                Yii::$app->session->setFlash('success','Yangi mahsulot qo`shildi');
            }else{
                Yii::$app->session->setFlash('error','Yangi mahsulot qo\'shishda xatolik');
            }

            return $this->redirect(['view', 'id' => $come_id]);
        }

        return $this->renderAjax('_form',[
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Come model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Come model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Come model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Come the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Come::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionDeletepro($id,$goods_id,$come_id)
    {
        $model = ComeProduct::findOne(['id'=>$id,'come_id'=>$come_id,'goods_id'=>$goods_id]);

        if($model ){
            $cnt = $model->cnt;
            if($model->delete()){
                $goods = Goods::findOne($model->goods_id);
                $goods->come -= $model->cnt;
                $goods->remainder -= $model->cnt;
                $goods->save(false);
                $come = Come::findOne(['id'=>$come_id]);
                $price = 0;
                foreach ($come->comeProducts as $item){
                    $price += $item->price*$item->cnt;
                }
                $come->price = $price;
                $come->save(false);
                Yii::$app->session->setFlash('success','Ushbu mahsulot muvoffaqiyatli o`chirildi');
            }else{
                Yii::$app->session->setFlash('error','Ushbu mahsulotni o`chirishda xatolik. Urinib ko`ring');
            }

        }else{
            Yii::$app->session->setFlash('error','Ushbu mahsulotni o`chirishda xatolik. Urinib ko`ring');
        }
        return $this->redirect(['view','id'=>$come_id]);
    }

    public function actionReminder()
    {
        $searchModel = new GoodsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        if($this->request->isPost){
            // excelga export qilish yoziladi
            $u = true;
        }
        return $this->render('reminder', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

}
