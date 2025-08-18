<script>
    const user_id = <?= Yii::$app->user->id ?>
</script>
<!-- right sidebar -->
<div class="w-5/12 flex flex-col bg-blue-gray-50 h-full bg-white pr-4 pl-2 py-4">
    <div class="bg-white rounded-3xl flex flex-col h-full shadow">
        <!-- empty cart -->
        <div x-show="cart.length === 0" class="flex-1 w-full p-4 opacity-25 select-none flex flex-col flex-wrap content-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <p>SAVAT BO'SH</p>
        </div>

        <!-- cart items -->
        <div x-show="cart.length > 0" class="flex-1 flex flex-col overflow-auto">
            <div class="h-16 text-center flex justify-center">
                <div class="pl-8 text-left text-lg py-4 relative">
                    <!-- cart icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <div x-show="getItemsCount() > 0" class="text-center absolute bg-cyan-500 text-white w-5 h-5 text-xs p-0 leading-5 rounded-full -right-2 top-3" x-text="getItemsCount()"></div>
                </div>
                <div class="flex-grow px-8 text-right text-lg py-4 relative">
                    <!-- trash button -->
                    <button x-on:click="clear()" class="text-blue-gray-300 hover:text-pink-500 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="flex-1 w-full px-4 overflow-auto">
                <template x-for="item in cart" :key="item.productId">
                    <div class="select-none mb-3 bg-blue-gray-50 rounded-lg w-full text-blue-gray-700 py-2 px-2 flex justify-center">
                        <img :src="item.image" alt="" class="rounded-lg h-10 w-10 bg-white shadow mr-2"/>
                        <div class="flex-grow">
                            <h5 class="text-sm" x-text="item.name"></h5>
                            <p class="text-xs block" x-text="priceFormat(item.price)"></p>
                        </div>
                        <div class="py-1">
                            <div class="w-40 grid grid-cols-3 gap-2 ml-2">
                                <button x-on:click="addQty(item, -1)" class="rounded-lg text-center py-1 text-white bg-blue-gray-600 hover:bg-blue-gray-700 focus:outline-none">
                                    -
                                </button>
                                <input x-model.number="item.qty" type="text" class="bg-white rounded-lg text-center shadow focus:outline-none focus:shadow-lg text-sm"/>
                                <button x-on:click="addQty(item, 1)" class="rounded-lg text-center py-1 text-white bg-blue-gray-600 hover:bg-blue-gray-700 focus:outline-none">
                                    +
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
        <!-- end of cart items -->

        <!-- payment info -->
        <div class="select-none h-auto w-full text-center pt-3 pb-4 px-4">
            <div class="flex mb-3 text-lg font-semibold text-blue-gray-700">
                <div>UMUMIY</div>
                <div class="text-right w-full" x-text="priceFormat(getTotalPrice())"></div>
            </div>

            <div x-show="change > 0" class="flex mb-3 text-lg font-semibold bg-cyan-50 text-blue-gray-700 rounded-lg py-2 px-3">
                <div class="text-cyan-800">CHANGE</div>
                <div class="text-right flex-grow text-cyan-600" x-text="priceFormat(change)"></div>
            </div>
            <div x-show="change < 0" class="flex mb-3 text-lg font-semibold bg-pink-100 text-blue-gray-700 rounded-lg py-2 px-3">
                <div class="text-right flex-grow text-pink-600" x-text="priceFormat(change)"></div>
            </div>

            <div class="flex justify-center gap-1">
                <button class="text-white bg-red-500 rounded-2xl text-lg w-full px-6 py-2 focus:outline-none" id="printButton">
                    Chek
                </button>
                <button class="text-white rounded-2xl text-lg w-full px-6 bg-yellow-500" id="submitqarz">
                    Qarz
                </button>

                <button id="submitButton" class="text-white bg-cyan-500 rounded-2xl text-lg w-full px-6 py-1 focus:outline-none text-white">
                    To'lov
                </button>

                <div id="customDialogUsta" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
                    <div class="bg-white rounded-2xl shadow-lg p-6 relative" style="width: 80%; max-width: 700px;">
                        <button id="closeDialogUsta" class="text-white bg-red-500 rounded-2xl px-4 py-2 absolute top-2 right-2">
                            x
                        </button>
                        <h2 class="text-2xl font-bold mb-4">Xizmat ko'rsatuvchini tanlash</h2>
                        <div class="row">
                            <?php $users = \common\models\User::find()->where(['status'=>1,'role_id'=>60])->all();
                                foreach ($users as $item):
                            ?>
                                <div class="col-md-4" style="margin-bottom:15px;">
                                    <input type="radio" name="user" id="user-<?= $item->id?>" value="<?= $item->id?>" style="transform: scale(170%); margin-left:10px;">
                                    <label for="user-<?= $item->id?>"><?= $item->name?></label>
                                </div>
                            <?php endforeach;?>
                        </div>
                        <button class="btn btn-success" id="customDialogUstabtn" type="button" value="1">Saqlash</button>
                    </div>
                </div>


                <div id="customDialog" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
                    <div class="bg-white rounded-2xl shadow-lg p-6 relative" style="width: 80%; max-width: 700px;">
                        <button id="closeDialog" class="text-white bg-red-500 rounded-2xl px-4 py-2 absolute top-2 right-2">
                            x
                        </button>
                        <h2 class="text-2xl font-bold mb-4">To'lovni tasdiqlash</h2>
                        <div id="listsales"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="umumiynarx" style="float: left; font-weight: bold">
                                        Umumiy narx
                                    </label>
                                    <input type="text" class="form-control" disabled id="umumiynarx" name="umumiynarx">
                                </div>
                            </div>

                            <div class="col-md-12" style="margin-top:10px;">
                                <div class="row">
                                    <?php foreach (\common\models\Payment::find()->all() as $pay):?>
                                    <div class="col-md-3">
                                        <label for="pay-<?=$pay->id?>"><?= $pay->name?></label>
                                        <input type="radio" id="pay-<?= $pay->id?>" name="paidtype" style="transform: scale(170%); margin-left:10px;" value="<?= $pay->id?>">
                                    </div>
                                    <?php endforeach;?>
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="col-md-12" style="position: relative">
                                <div class="row">
                                    <div class="col-md-12 hidden" id="qarzdordiv">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="paydate"  style="float: left; font-weight: bold">To'lov sanasi</label>
                                                <input type="date" class="form-control" id="paydate" name="paydate">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="qarzdorname" style="float: left; font-weight: bold">
                                                Mijoz
                                            </label>
                                            <input type="text" class="form-control" id="qarzdorname" name="qarzdorname">
                                            <input type="text" class="form-control" id="qarzdor" name="qarzdor" value="-1" hidden style="display: none">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="qarzdorphone" style="float: left; font-weight: bold">
                                                Telefon
                                            </label>
                                            <input type="text" class="form-control" id="qarzdorphone" name="qarzdorphone">
                                        </div>
                                    </div>

                                </div>
                                <br>
                                <style>
                                    ul#results,ul#results-product {
                                        list-style-type: none;
                                        padding: 0;
                                        margin: 0;
                                        position: absolute; /* UL elementini sahifada belgilangan joyga joylashtirish */
                                        top: 0; /* Input maydonidan pastga joylashtirish */
                                        left: 0;
                                        width: 100%;
                                        background-color: white;
                                        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                                        z-index: 999;
                                    }
                                    ul#results li,ul#results-product li {
                                        padding: 8px;
                                        border-bottom: 1px solid #000 !important;
                                    }
                                    ul#results li:hover,ul#results-product li:hover {
                                        background-color: #acacac !important;
                                    }
                                </style>
                                <?php
                                $url = Yii::$app->urlManager->createUrl(['/cp/gen/getclient']);

                                $this->registerJs("
                                            $('#results').on('click', 'li', function() {
                                                var id = $(this).data('id');
                                                var name = $(this).data('name');
                                                var phone = $(this).data('phone');
                                                $('#qarzdorname').val(name);
                                                $('#qarzdorphone').val(phone);
                                                $('#qarzdor').val(id);
                                                $('#results').empty();
                                            });
                                            function search(){
                                                var name = $('#qarzdorname').val();
                                                var phone = $('#qarzdorphone').val();
                                                $('#qarzdor').val(-1);
                                                if(name.length === 0 && phone.length === 0){
                                                    $('#results').empty();
                                                    $('#qarzdor').val(-1);
                                                    return;
                                                }
                                                $.get('$url?name='+name+'&phone='+phone).done(function(data){
                                                    $('#results').empty();
                                                    $('#results').append(data);
                                                })
                                             }
                                             $('#qarzdorname').on('keyup', function() {
                                                search();
                                             });
                                        
                                            $('#qarzdorphone').on('keyup', function() {
                                                search();
                                            });
                                    ")?>
                                <div class="row">
                                    <div class="col-md-12" style="position: relative">
                                        <ul class="results" id="results">
                                        </ul>
                                    </div>
                                </div>

                            </div>
                            <br><br>
                            <div class="col-md-12" style="display: none" hidden>
                                <div class="form-group">
                                    <label for="tulov" style="float: left; font-weight: bold">
                                        To'lav summasi
                                    </label>
                                    <input type="text" class="form-control" id="tulov" disabled name="tulov">
                                </div>
                            </div>
                            <br>
                            <input type="text" value="1" name="sotuvturi" id="sotuvturi" hidden style="display: none">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-primary form-control" style="height: 80px;" id="sotish">Sotuvni amalga oshirish</button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-success form-control" style="height: 80px;" id="sotishandprint"> Sotish va chek</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of payment info -->
    </div>
</div>
<!-- end of right sidebar -->

<?php
$this->registerJs("
    $(document).ready(function(){
        if(window.innerWidth <= 1800){
            $('#goodsContent').removeClass('grid-cols-5');
            $('#goodsContent').addClass('grid-cols-4');
            
        }
    })
")
?>