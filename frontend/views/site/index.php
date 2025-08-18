<?php

/** @var yii\web\View $this */

$this->title = 'Qr kod skanerlash';
?>

    <div id="reader" style="width: 300px; height: 300px;"></div>
    <div id="result"></div>


    <a href="<?= Yii::$app->urlManager->createUrl(['/'])?>" class="btn btn-primary">Yana QR kod o'qitish</a>

<?php
    $this->registerJsFile("https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js");
?>

<?php
    $this->registerJs(<<<JS
        $(document).ready(function() {
        // QR kodni o'qish uchun Html5Qrcode ob'ektini yaratish
        const html5QrCode = new Html5Qrcode("reader");
    
        // QR kod skanerlash funksiyasi
        function onScanSuccess(decodedText, decodedResult) {
            // QR kod muvaffaqiyatli o'qilganda bajariladigan amal
            $("#result").text("QR Kod topildi: " + decodedText);
            html5QrCode.stop(); // Skanerlashni to'xtatish
        }
    
        function onScanFailure(error) {
            // Agar skanerlashda xatolik yuz bersa
            console.warn('QR kod skanerlashda xatolik: '+ error);
        }
    
        // Skanerlashni boshlash (kamera tanlash uchun)
        html5QrCode.start(
            { facingMode: "environment" }, // Orqa kamera
            {
                fps: 10,    // Frame per second
                qrbox: 250  // Skanerlash maydoni o'lchami
            },
            onScanSuccess,
            onScanFailure
        );
    });
JS);
?>