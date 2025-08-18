<?php
/* @var $model Array*/
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;

$qr =function() use ($model) {
    $data=Builder::create()
        ->writer(new PngWriter())
        ->writerOptions([])
        ->data('https://www.instagram.com/kharezm_kia_oil')
        ->encoding(new Encoding('UTF-8'))
        ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
        ->size(130)
        ->margin(0)
        ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
//        ->logoPath(Yii::$app->basePath."/web/favicon.png")
        ->foregroundColor(new Color(0, 0, 0))
        ->backgroundColor(new Color(255, 255, 255))
        ->labelText('')
        ->labelFont(new NotoSans(20))
        ->labelAlignment(new LabelAlignmentCenter())
        ->build();
    return $data->getDataUri();
};

?>
<style>
    table {
        width: 100%;
        border-collapse: collapse; /* Hujayralar orasidagi bo'shliqni olib tashlaydi */
    }

    th, td {
        border: 1px solid black; /* Hujayra chegaralarini qora chiziq bilan belgilash */
        padding: 8px; /* Hujayralarda ichki bo'shliq */
        text-align: left; /* Matnni chapga hizalash */
    }

    th {
        background-color: #f2f2f2; /* Sarlavhalar uchun engil fon rangi */
    }
</style>
<h4>Sotuv №<?= $model->code ?></h4>
<table>
    <thead>
        <tr>
            <td>#</td>
            <td>Nomi</td>
            <td>Narxi</td>
            <td>Soni</td>
            <td>Umumiy narx</td>
        </tr>
    </thead>
    <tbody>
        <?php $narx = 0; foreach ($model->product as $key=>$item):?>
            <tr>
                <td><?= $key+1?></td>
                <td><?= $item->product->name ?></td>
                <td><?= $item->price ?></td>
                <td><?= $item->cnt ?></td>
                <td><?php $a =  $item->cnt_price; $narx+= $a; echo $a?></td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="3">Jami:</td>
            <td colspan="2"><?= $narx?> so'm</td>
        </tr>
    </tbody>
</table>
<p>Sotuvchi: <?= $model->user->name ?></p>
<p>Soat: <?= $model->created ?></p>

