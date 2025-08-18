<?php

namespace frontend\modules\service\controllers;

use common\models\Goods;
use common\models\GoodsGroup;
use common\models\SaleProduct;
use common\models\User;
use common\models\Visit;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use Yii;
/**
 * Default controller for the `service` module
 */
class DefaultController extends Controller
{
    public function behaviors(){
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'staterun' => ['POST'],
                ]
            ]
        ];
    }
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionProfile(){
        if($model = User::findOne(Yii::$app->user->id)){
            $username = $model->username;
            $img = $model->image;
            $pas = $model->password;
            if($model->load($this->request->post())){

                if($model->password){
                    $model->setPassword($model->password);
                }else{
                    $model->password = $pas;
                }
                $model->username = $username;
                if($model->image = UploadedFile::getInstance($model,'image')){
                    $name = 'avatar/'.microtime(true).".".$model->image->extension;
                    if(!file_exists(Yii::$app->basePath.'/web/upload/avatar')){
                        mkdir(Yii::$app->basePath.'/web/upload/avatar');
                    }
                    $model->image->saveAs(Yii::$app->basePath.'/web/upload/'.$name);
                    $model->image = $name;

                    if(!file_exists(Yii::$app->basePath.'/web/upload/'.$img) and $img != "default/avatar.png"){
                        unlink(Yii::$app->basePath.'/web/upload/'.$img);
                    }
                }else{
                    $model->image = $img;
                }
                if($model->save()){
                    Yii::$app->session->setFlash('success','Ma`lumotlar muvoffaqiyatli saqlandi');
                    return $this->redirect(['profil']);
                }else{
                    Yii::$app->session->setFlash('error','Ma`lumotlarni saqlashda xatolik. Kiritilgan ma`lumotlarni to`g`ri va to`liqligini qayta tekshirib ko`ring.');
                }
            }
            $model->password = "";
            return $this->render('profil',[
                'model'=>$model
            ]);


        }else{
            throw new NotFoundHttpException('Bunday foydalanuvchi topilmadi');
        }
    }


    public function actionRunning($search = null)
    {


        if($search){
            $s = ['like','client_car.number', $search];
        }else{
            $s = ' 1 ';
        }
        $model = Visit::find()
            ->select(['visit.*'])
            ->innerJoin('client_car','client_car.id = visit.car_id')
            ->where(['visit.state'=>'RUNNING','visit.status'=>1,'visit.user_id'=>Yii::$app->user->id])
            ->andFilterWhere(['like','client_car.number', $search])
            ->all();


        return $this->render('running',[
            'model'=>$model,
            'search'=>$search
        ]);

    }

    public function actionCompleted($type = null,$search = null)
    {

        if($type == 'month'){
            $model = Visit::find()
                ->innerJoin('client_car','client_car.id = visit.car_id')
                ->where(['visit.status'=>1,'visit.user_id'=>Yii::$app->user->id])->andWhere(['visit.state'=>'COMPLETED',])
                ->andFilterWhere(['like','client_car.number', $search])
                ->andFilterWhere(['like','visit.date',date('Y-m-')])->all();
        }elseif($type == 'today') {
            $model = Visit::find()
                ->innerJoin('client_car','client_car.id = visit.car_id')
                ->where(['visit.status'=>1,'visit.user_id'=>Yii::$app->user->id])->andWhere(['visit.state'=>'COMPLETED',])
                ->andFilterWhere(['like','client_car.number', $search])
                ->andFilterWhere(['like','visit.date',date('Y-m-d')])->all();
        }else{
            $model = Visit::find()
                ->innerJoin('client_car','client_car.id = visit.car_id')
                ->where(['visit.status'=>1,'visit.user_id'=>Yii::$app->user->id])->andWhere(['visit.state'=>'COMPLETED',])
                ->andFilterWhere(['like','client_car.number', $search])
                ->all();
        }

        return $this->render('completed',[
            'model'=>$model,
            'search'=>$search,
            'type'=>$type
        ]);

    }

    public function actionNew()
    {
        $model = Visit::find()->where(['status'=>1,'user_id'=>Yii::$app->user->id])->andWhere(['state'=>'NEW',])->all();

        return $this->render('running',[
            'model'=>$model
        ]);

    }

    public function actionView($id)
    {
        $model = Visit::findOne($id);
        return $this->render('view',[
            'model'=>$model
        ]);
    }

    public function actionStaterun($id)
    {
        $model = Visit::findOne($id);
        $model->state = 'RUNNING';
        if($model->save(false)){
            Yii::$app->session->setFlash('success','Moshina ta`mirlash ishi boshlandi');
        }else{
            Yii::$app->session->setFlash('error','Ta`mirlash boshlashda xatolik. Qayta urinib ko`ring!');
        }
        return $this->redirect(['view','id'=>$id]);
    }

    public function actionStatecompleted($id){
        $model = Visit::findOne($id);
        $model->state = 'COMPLETED';
        if($model->save(false)){
            Yii::$app->session->setFlash('success','Moshina ta`mirlash ishi tugadi');
        }else{
            Yii::$app->session->setFlash('error','Ta`mirlashni tugatishd xatolik. Qayta urinib ko`ring!');
        }
        return $this->redirect(['view','id'=>$id]);
    }

    public function actionAddproduct($id)
    {
        $visit = Visit::findOne($id);
        $model = GoodsGroup::find()->where(['status'=>1,'type'=>1])->all();

        return $this->render('addproduct',[
            'model'=>$model,
            'visit'=>$visit
        ]);
    }

    public function actionChooseproduct($id,$group_id)
    {
        $visit = Visit::findOne($id);
        $group = GoodsGroup::findOne($group_id);
        $model = Goods::find()->where(['status'=>1,'type'=>1,'group_id'=>$group->id])->all();
        return $this->render('chooseproduct',[
           'visit'=>$visit,
           'group'=>$group,
           'model'=>$model
        ]);
    }

    public function actionSetproduct($id,$group_id,$goods_id){
        $visit = Visit::findOne($id);
        $group = GoodsGroup::findOne($group_id);
        $goods = Goods::findOne($goods_id);
        $sale = $visit->sale;
        if($model = SaleProduct::findOne(['product_id'=>$goods_id,'sale_id'=>$sale->id])){
            $i = true;
        }else{
            $model = new SaleProduct();
            $model->sale_id = $sale->id;
            $model->product_id = $goods_id;
            $model->user_id = Yii::$app->user->id;
            $model->price = $goods->price;
            $model->cnt = 1;
            $model->cnt_price = $goods->price;
        }

        if($model->load($this->request->post())){
            $cnt = 0;
            if($product = SaleProduct::find()->where(['sale_id'=>$sale->id,'product_id'=>$goods_id])->one()){
                $cnt = $model->cnt;
                $model = $product;
                $model->cnt = $cnt;
            }
            $model->cnt_price = $model->price * $model->cnt;
            if($model->save()){
                // salega hisoblab yozish kerak
                $cnt_price = 0;
                foreach ($visit->visitProducts as $item){
                    $cnt_price += $item->price * $item->cnt;
                }
                $sale->price = $cnt_price;
                $sale->save(false);

                $goods->sale = $goods->sale + $cnt - $model->cnt;
                $goods->remainder = $goods->remainder + $cnt - $model->cnt;
                $goods->save(false);

                // sklad remove


                Yii::$app->session->setFlash('success','Ma`lumotlarni saqlandi. Mahsulot qo`shishda davom eting!');
                return $this->redirect(['chooseproduct','id'=>$id,'group_id'=>$group_id]);
            }else{
                Yii::$app->session->setFlash('error','Ma`lumotni saqlashda xatolik. Qayta urinib ko`ring.');
                return $this->redirect(['setproduct','id'=>$id,'group_id'=>$group_id,'goods_id'=>$goods_id]);
            }
        }
        return $this->render('setproduct',[
            'model'=>$model,
            'visit'=>$visit,
            'group'=>$group,
            'goods'=>$goods,
        ]);
    }

    public function actionUpdateproduct($id,$visit_id){
        $visit = Visit::findOne($visit_id);

        $sale = $visit->sale;
        $model = SaleProduct::findOne($id);
        $group = $model->product->group;
        $goods = $model->product;
        $old_cnt = $model->cnt;
        if($model->load($this->request->post())){

            $model->cnt_price = $model->price * $model->cnt;
            // remove sklad va set sklad
            if($model->save()){
                // salega hisoblab yozish kerak


                $cnt_price = 0;
                foreach ($visit->visitProducts as $item){
                    $cnt_price += $item->price * $item->cnt;
                }
                $sale->price = $cnt_price;
                $sale->save(false);


                $goods->sale = $goods->sale + $old_cnt - $model->cnt;
                $goods->remainder = $goods->remainder + $old_cnt - $model->cnt;
                $goods->save(false);


                Yii::$app->session->setFlash('success','Ma`lumotlarni saqlandi.');
                return $this->redirect(['view','id'=>$visit_id]);
            }else{
                Yii::$app->session->setFlash('error','Ma`lumotni saqlashda xatolik. Qayta urinib ko`ring.');
                return $this->redirect(['updateproduct','id'=>$id,'visit_id'=>$visit_id]);
            }
        }
        return $this->render('updateproduct',[
            'model'=>$model,
            'visit'=>$visit,
            'goods'=>$goods,
            'group'=>$group,
        ]);
    }



    // service ////

    /*
     *
     *
     *
     *
     *
     *
     */



    public function actionAddservice($id)
    {
        $visit = Visit::findOne($id);
        $model = GoodsGroup::find()->where(['status'=>1,'type'=>2])->all();

        return $this->render('addservice',[
            'model'=>$model,
            'visit'=>$visit
        ]);
    }

    public function actionChooseservice($id,$group_id)
    {
        $visit = Visit::findOne($id);
        $group = GoodsGroup::findOne($group_id);
        $model = Goods::find()->where(['status'=>1,'type'=>2,'group_id'=>$group->id])->all();
        return $this->render('chooseservice',[
            'visit'=>$visit,
            'group'=>$group,
            'model'=>$model
        ]);
    }

    public function actionSetservice($id,$group_id,$goods_id){

        $visit = Visit::findOne($id);
        $group = GoodsGroup::findOne($group_id);
        $goods = Goods::findOne($goods_id);
        $sale = $visit->sale;
        if($model = SaleProduct::findOne(['product_id'=>$goods_id,'sale_id'=>$sale->id])){
            $i = true;
        }else{
            $model = new SaleProduct();
            $model->sale_id = $sale->id;
            $model->product_id = $goods_id;
            $model->user_id = Yii::$app->user->id;
            $model->price = $goods->price;
            $model->cnt = 1;
            $model->cnt_price = $goods->price;
        }

        if($model->load($this->request->post())){

            if($product = SaleProduct::find()->where(['sale_id'=>$sale->id,'product_id'=>$goods_id])->one()){
                $cnt = $model->cnt;
                $model = $product;
                $model->cnt = $cnt;
            }
            $model->cnt_price = $model->price * $model->cnt;
            if($model->save()){
                // salega hisoblab yozish kerak
                $cnt_price = 0;
                foreach ($visit->visitProducts as $item){
                    $cnt_price += $item->price * $item->cnt;
                }
                $sale->credit = $cnt_price - $sale->debt;
                $sale->price = $cnt_price;
                $sale->save(false);


                Yii::$app->session->setFlash('success','Ma`lumotlarni saqlandi. Mahsulot qo`shishda davom eting!');
                return $this->redirect(['chooseservice','id'=>$id,'group_id'=>$group_id]);
            }else{
                Yii::$app->session->setFlash('error','Ma`lumotni saqlashda xatolik. Qayta urinib ko`ring.');
                return $this->redirect(['setservice','id'=>$id,'group_id'=>$group_id,'goods_id'=>$goods_id]);
            }
        }
        return $this->render('setservice',[
            'model'=>$model,
            'visit'=>$visit,
            'group'=>$group,
            'goods'=>$goods,
        ]);
    }

    public function actionUpdateservice($id,$visit_id){
        $visit = Visit::findOne($visit_id);

        $sale = $visit->sale;
        $model = SaleProduct::findOne($id);
        $group = $model->product->group;
        $goods = $model->product;
        if($model->load($this->request->post())){
            $model->cnt_price = $model->price * $model->cnt;
            if($model->save()){
                // salega hisoblab yozish kerak
                $cnt = 0;
                $cnt_price = 0;
                foreach ($visit->visitProducts as $item){
                    $cnt_price += $item->price * $item->cnt;
                }
                $sale->price = $cnt_price;
                $sale->save(false);

                Yii::$app->session->setFlash('success','Ma`lumotlarni saqlandi.');
                return $this->redirect(['view','id'=>$visit_id]);
            }else{
                Yii::$app->session->setFlash('error','Ma`lumotni saqlashda xatolik. Qayta urinib ko`ring.');
                return $this->redirect(['updateservice','id'=>$id,'visit_id'=>$visit_id]);
            }
        }
        return $this->render('updateservice',[
            'model'=>$model,
            'visit'=>$visit,
            'goods'=>$goods,
            'group'=>$group,
        ]);
    }

}
