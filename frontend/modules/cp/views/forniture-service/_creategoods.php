<?php
/* @var $cat \common\models\GoodsGroup*/
/* @var $id integer*/
?>

<div id="cats">
    <div class="row">
        <?php foreach ($cat as $item):
            $img =  $item->image == 'default/nophoto.png' ? '/upload/default/nophoto.png' : '/upload/goodsgroup/'.$item->image;
            ?>
            <div class="col-md-3" >
                <div class="card item-cat" data-id="<?= $id?>" data-group_id="<?= $item->id?>">
                    <div class="card-body">
                        <div class="image">
                            <img src="<?= $img?>" alt="<?= $img?>" class="img-responsive">
                        </div>
                        <div class="title">
                            <?= $item->name?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
    </div>
</div>

<div id="goods">

</div>


<?php
    if($type == 1){
        $url = Yii::$app->urlManager->createUrl(['/cp/forniture-service/getgoods']);
    }else{
        $url = Yii::$app->urlManager->createUrl(['/cp/forniture-service/getservice']);
    }
    $this->registerJs("
        $('.item-cat').click(function(){
            var id = $(this).data('id');
            var group_id = $(this).data('group_id');
            $('#cats').hide();
            $.ajax({
                url: '".$url."',
                type: 'GET',
                data: {id:id,group_id:group_id},
                success: function(data){
                    $('#goods').html(data);
                }
            });
        });
    ")
?>