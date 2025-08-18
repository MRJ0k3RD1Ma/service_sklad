<?= $this->render('sale/_cat')?>
<!-- page content -->
<div class="flex-1 flex overflow-y-auto ">
    <!-- store menu -->
    <div class="flex flex-col bg-blue-gray-50 h-[800px] w-full py-4 overflow-y-auto">


        <?= $this->render('_search')?>


        <div class="overflow-y mt-4  ">
            <div class="h-full overflow-y-auto px-2">
                <div class="select-none bg-blue-gray-100 rounded-3xl flex flex-wrap content-center justify-center h-full " x-show="products.length === 0">

                    <?= $this->render('_numpad')?>


                    <div id="goodsContent" class="grid grid-cols-5 gap-5 p-5 overflow-auto overflow-y-auto">



                    </div>

                </div>

                <div x-show="filteredProducts().length" class="grid grid-cols-4 gap-4 pb-3">
                    <template x-for="product in filteredProducts()" :key="product.id">
                        <div role="button" class="select-none cursor-pointer transition-shadow overflow-hidden rounded-2xl bg-white shadow hover:shadow-lg" :title="product.name" x-on:click="addToCart(product)">
                            <img :src="product.image" :alt="product.name"/>
                            <div class="flex pb-3 px-3 text-sm -mt-3">
                                <p class="flex-grow truncate mr-1" x-text="product.option"></p>
                                <p class="nowrap font-semibold" x-text="priceFormat(product.price)"></p>
                            </div>
                        </div>
                    </template>


                </div>
            </div>
        </div>
    </div>
    <!-- end of store menu -->

    <?= $this->render('_right')?>
</div>


<?php
$url_scan = Yii::$app->urlManager->createUrl(['/cp/gen/scan']);
$url_one = Yii::$app->urlManager->createUrl(['/cp/gen/getone']);
$this->registerJs(<<<JS

    let scannedData = '';
     let timeout;
     
     $(document).on('keydown',function(event){
        clearTimeout(timeout);
        
        if (event.key === 'Enter') {
            // Enter tugmasi bosilganda skaner ma'lumotni uzatish tugallanganini anglatadi
            $.get('{$url_scan}?code='+scannedData).done(function(data){
                if(data != -1){
                    data = JSON.parse(data);
                    var id = data.id;
                    var name = data.name;
                    var price = data.price;
                    var option = data.ostatka;
                    var image = data.image;
                    addToCart({
                        id : id,
                        name : name,
                        price : price,
                        option : option,
                        image : image
                    });
                }
            });
            scannedData = ''; // Kiritilgan ma'lumotni tozalash
        } else {
            scannedData += event.key; // Har bir tugmachani ketma-ketlikda qo'shish
           
        }
        
        
        timeout = setTimeout(() => {
            scannedData = ''; 
        }, 500);
    })    
    
    
    $(document).on('click', '.goods-items', function() {
        $.get('{$url_one}?id=' + $(this).attr('data-id')).done(function(data) {
            if (data != -1) {
                data = JSON.parse(data);
                addToCart(data);
            }
        });
    });

JS)
?>