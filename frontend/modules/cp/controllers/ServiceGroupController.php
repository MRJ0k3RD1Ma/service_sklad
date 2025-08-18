<?php

namespace frontend\modules\cp\controllers;

use common\models\GoodsGroup;
use common\models\search\GoodsGroupSearch;
use common\models\search\ServiceGroupSearch;
use Imagine\Image\ManipulatorInterface;
use tpmanc\imagick\Imagick;
use yii\imagine\Image;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use yii\web\UploadedFile;

/**
 * GoodsGroupController implements the CRUD actions for GoodsGroup model.
 */
class ServiceGroupController extends Controller
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
     * Lists all GoodsGroup models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ServiceGroupSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single GoodsGroup model.
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
     * Creates a new GoodsGroup model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new GoodsGroup();
        $model->type = "2";
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if($model->image = UploadedFile::getInstance($model,'image')){
                    $name = microtime(true).'.'.$model->image->extension;
                    $model->image->saveAs(Yii::$app->basePath.'/web/upload/goodsgroup/'.$name);
                    $model->image = $name;

                    Image::resize(Yii::$app->basePath.'/web/upload/goodsgroup/'.$name, 300,null,ManipulatorInterface::THUMBNAIL_INSET)
                        ->save(Yii::$app->basePath.'/web/upload/goodsgroup/tmp/'.$name, ['quality' => 80]);

                }else{
                    $model->image = "default/nophoto.png";
                }

                if($model->save()){
                    Yii::$app->session->setFlash('success','Amal muvaffaqiyatli bajarildi');
                    return $this->redirect(['view', 'id' => $model->id]);
                }else{
                    Yii::$app->session->setFlash('error','Ma`lumotni qo`shishda xatolik. Iltimos qayta urinib ko`ring.');
                    return $this->redirect(['index']);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing GoodsGroup model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $image = $model->image;
        if ($this->request->isPost && $model->load($this->request->post())) {
            if($model->image = UploadedFile::getInstance($model,'image')){
                $name = microtime(true).'.'.$model->image->extension;
                $model->image->saveAs(Yii::$app->basePath.'/web/upload/goodsgroup/'.$name);
                $model->image = $name;

                Image::resize(Yii::$app->basePath.'/web/upload/goodsgroup/'.$name, 300,null,ManipulatorInterface::THUMBNAIL_INSET)
                    ->save(Yii::$app->basePath.'/web/upload/goodsgroup/tmp/'.$name, ['quality' => 80]);

            }else{
                $model->image = $image;
            }
            if($model->save()){
                Yii::$app->session->setFlash('success','Amal muvaffaqiyatli bajarildi');
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                Yii::$app->session->setFlash('error','Ma`lumotni qo`shishda xatolik. Iltimos qayta urinib ko`ring.');
                return $this->redirect(['index']);
            }
        }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing GoodsGroup model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = 1;
        if($model->save()){
            Yii::$app->session->setFlash('success','Amal muvaffaqiyatli bajarildi');
        }else{
            Yii::$app->session->setFlash('error','Ma`lumotni o`chirishda xatolik. Iltimos qayta urinib ko`ring.');
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the GoodsGroup model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return GoodsGroup the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GoodsGroup::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
