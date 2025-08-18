<div class="row">
    <?php foreach ($goods as $item):
        $img =  $item->image == 'default/nophoto.png' ? '/upload/default/nophoto.png' : '/upload/goods/'.$item->image;
        ?>
        <div class="col-md-3" >
            <div class="card item-goods" data-id="<?= $id?>" data-goods_id="<?= $item->id?>">
                <div class="card-body">
                    <div class="image">
                        <img src="<?= $img?>" alt="<?= $img?>" class="img-responsive">
                    </div>
                    <div class="title">
                        <?= $item->name?> - <?= $item->price?> so`m
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach;?>
</div>


<?php
if($type == 1){
    $url = Yii::$app->urlManager->createUrl(['/cp/visit/addgoods']);
}else{
    $url = Yii::$app->urlManager->createUrl(['/cp/visit/addservice']);
}
    $this->registerJs("
        $('.item-goods').click(function(){
            var id = $(this).data('id');
            var goods_id = $(this).data('goods_id');
            $.ajax({
                url: '".$url."',
                type: 'GET',
                data: {id:id,goods_id:goods_id},
                success: function(data){
                    location.reload();
                }
            });
        });
    ");

?>