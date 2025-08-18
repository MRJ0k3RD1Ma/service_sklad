
  <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Label Print</title>
    <style>
        @page {
            size: 60mm 40mm; /* Setting the page size to 60mm x 40mm */
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            font-size: 10px;
        }

        .label {
            width: 60mm;
            height: 40mm;
            padding: 0;
            padding-top:2mm;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .barcode-img {
            width: 80%;  /* Adjusting the barcode size to fit */
            height: auto;
        }

        .barcode-number {
            font-size: 14px;
            margin-top: 5px;
        }

        .product-name {
            font-size: 16px;
            margin-top: 5px;
        }

        .price {
            font-size: 14px;
            margin-top: 5px;
        }

        @media print {
            body {
                padding: 0;
            }

            .label {
                border: 1px solid #000; /* Optional: border for visibility */
                padding: 2mm;
                box-sizing: border-box;
            }
        }
    </style>
</head>
<body>
<div class="label">
    <img src="<?= $url ?>" class="barcode-img" alt="Barcode">
    <div class="barcode-number"><?= $model->barcode ?></div>

    <?php if( \common\models\Custom::findOne(['key'=>'barcode-print-name'])->value == 1 ){ ?><div class="product-name"><?=$model->name ?></div><?php }?>

    <?php if( \common\models\Custom::findOne(['key'=>'barcode-print-price'])->value == 1 ){ ?> <div class="price">Цена: <b><?= $model->price ?> сум</b></div><?php }?>

</div>
</body>
</html>

<script>
    window.onload = function() {
        document.title = " ";
        window.print();
        window.onafterprint = function() {
            window.close();
        }
    }
</script>

