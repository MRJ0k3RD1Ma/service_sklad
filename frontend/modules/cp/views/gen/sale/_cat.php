<!-- left sidebar -->
<div class="flex flex-row w-96 h-screen overflow-y-auto ">
    <div class="flex flex-col items-center py-6 w-96 bg-white rounded-2xl shadow-lg">
        <div class="relative w-auto px-10 pl-1">
            <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">
                Mahsulotlar
                <span style="float: right"><button id="closebtn" class="btn btn-danger">&times;</button></span>
            </h1>
            <div class="flex space-x-8 mb-6 px-4">
                <button id="foodButton" class="w-1/2 px-6 py-2 rounded-xl border border-gray-200 focus:outline-none bg-blue-50 transition-all duration-200 shadow-sm hover:shadow-md active">
                    <span class="inline-flex items-center justify-center">
                      <span class="font-semibold text-black">Mahsulotlar</span>
                    </span>
                </button>
                <button id="categoryButton"  class="w-1/2 px-6 py-2 rounded-xl border border-gray-200 focus:outline-none bg-white transition-all duration-200 shadow-sm hover:shadow-md">
                    <span class="inline-flex items-center justify-center">
                      <span class="font-semibold text-black">Xizmatlar</span>
                    </span>
                </button>
            </div>
            <div id="foodList" class="absolute w-full rounded-xl shadow-xl transform transition-all duration-200 z-10 overflow-y-auto">

                <?php foreach (\common\models\GoodsGroup::find()->where(['status'=>1,'type'=>1])->all() as $item):?>
                <div class="p-3 hover:bg-blue-50 cursor-pointer flex items-center border-gray-100 catlist" data-id="<?= $item->id?>">
                    <img src="/upload/<?= $item->image == 'default/nophoto.png' ? 'default/nophoto.png' : 'goodsgroup/'.$item->image ?>" class="w-12 h-12 mr-3 rounded-lg shadow-sm" alt="CheeseBurger"/>
                    <div>
                        <p class="font-semibold text-gray-800"><?= $item->name?></p>
                    </div>
                </div>
                <?php endforeach;?>

            </div>

            <div id="categoryList" class="absolute w-full rounded-xl shadow-xl hidden transform transition-all duration-200 z-10 max-h-[calc(100vh-300px)] overflow-y-auto">

                <?php foreach (\common\models\GoodsGroup::find()->where(['status'=>1,'type'=>2])->all() as $item):?>
                    <div class="p-3 hover:bg-blue-50 cursor-pointer flex items-center border-gray-100 catlist" data-id="<?= $item->id?>">
                        <img src="/upload/<?= $item->image == 'default/nophoto.png' ? 'default/nophoto.png' : 'goodsgroup/'.$item->image ?>" class="w-12 h-12 mr-3 rounded-lg shadow-sm" alt="CheeseBurger"/>
                        <div>
                            <p class="font-semibold text-gray-800"><?= $item->name?></p>
                        </div>
                    </div>
                <?php endforeach;?>

            </div>
        </div>
    </div>
</div>
<!-- page content -->

<?php

$url_close = Yii::$app->urlManager->createUrl(['/cp/default/']);

$this->registerJs("
    $('#closebtn').click(function(){
        window.location.href='{$url_close}'
    })
")?>