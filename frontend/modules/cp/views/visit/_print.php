<?php
/* @var $model \common\models\Visit*/
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
$visit  = $model;
$model = $visit->sale;

$setting = \common\models\Setting::findOne(1);
if (!$setting) {
    $setting = new \common\models\Setting();
    $setting->id = 1;
    $setting->save(false);
}

$qr = function() use ($model, $setting) {
    $data = \Endroid\QrCode\Builder\Builder::create()
        ->writer(new PngWriter())
        ->writerOptions([])
        ->data($setting->qr_url ? $setting->qr_url : 'URL NOT FOUND')
        ->encoding(new Encoding('UTF-8'))
        ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
        ->size(100)
        ->margin(0)
        ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
        ->foregroundColor(new Color(0, 0, 0))
        ->backgroundColor(new Color(255, 255, 255))
        ->labelText('')
        ->labelFont(new NotoSans(20))
        ->labelAlignment(new LabelAlignmentCenter())
        ->build();
    return $data->getDataUri();
};
?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="format-detection" content="telephone=no">
<style>
    @page {
        size: 80mm auto;
        margin: 0;
    }
    @media print {
        html, body {
            width: 80mm;
            height: auto;
            margin: 0 !important;
            padding: 0 !important;
        }
        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
    }
    body {
        width: 80mm;
        height: auto;
        margin: 0;
        padding: 0 2mm;
        font-size: 12px;
        font-family: Arial, sans-serif;
        display: inline-block;
    }
    h4 {
        text-align: center;
        margin: 5px 0;
        font-size: 14px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 5px;
        border-spacing: 0;
    }
    th, td {
        padding: 2px;
        font-size: 12px;
        border-bottom: 1px dotted #000;
    }
    tr:last-child td {
        border-bottom: none;
    }
    .total-row {
        border-top: 1px dashed #000 !important;
        font-weight: bold;
    }
    .total-row td {
        border-bottom: none;
    }
    .center {
        text-align: center;
    }
    .qr-code {
        width: 100px;
        height: 100px;
        margin: 0 auto;
        display: block;
    }
    .info {
        text-align: center;
        font-size: 11px;
        margin: 3px 0;
        padding: 0;
    }
</style>

<?php if($setting->is_logo == 1){?>
    <div style="width: 100%; height:auto; text-align:center">

        <img src="/upload/logo/<?= $setting->logo ?>" style="width:<?= $setting->logo_size?>%; height:auto" alt="">

    </div>
<?php }else{?>
    <h4 style="text-align:center;"><?= $setting->name?></h4>
<?php }?>

<h4>Ta'mirlash va sotuv: №<?= $model->code ?></h4>
<table>
    <?php $narx = 0; foreach ($model->product as $key=>$item):?>
        <tr>
            <td colspan="2"><?= $item->product->name ?></td>
        </tr>
        <tr>
            <td><?= $item->cnt ?>ta x <?= $item->price ?> so'mdan</td>
            <td style="text-align: right"><?php $a = $item->cnt_price; $narx += $a; echo $a?> so'm</td>
        </tr>
    <?php endforeach; ?>
    <tr class="total-row">
        <td>Jami:</td>
        <td style="text-align: right"><?= $narx?> so'm</td>
    </tr>
</table>

<p class="info">Usta: <?= $visit->user->name ?></p>
<p class="info">Sotuvchi: <?= $model->user->name ?></p>
<p class="info">Telefon: <?= $setting->phone ?></p>
<p class="info">Manzil: <?= $setting->address ?></p>
<p class="info">Soat: <?= $model->created ?></p>
<img class="qr-code" src="<?= $qr()?>" alt="sertifikat">


<script>
    window.onload = function () {
        window.print();
        setTimeout(function () {
            window.close();
        }, 10000);
    };
</script>