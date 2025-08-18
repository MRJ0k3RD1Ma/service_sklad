<?php
namespace frontend\components;
use Yii;
class TGBot extends \yii\base\Component{

    public static function send($chat_id,$message)
    {
        $url = 'https://api.telegram.org/bot'.Yii::$app->params['telegram']['token'].'/sendMessage?chat_id='.$chat_id.'&text='.$message;
        file_get_contents($url);
    }

    public static function sendHtmlAsImage($chat_id, $html_url)
    {
        // Fayl nomi
        $fileName = 'page.png';


        try {
            // HTML sahifadan matnni olish
            $htmlContent = strip_tags(file_get_contents($html_url)); // Faqat matn qismi

            // Tasvir o'lchamlari
            $width = 800;
            $height = 600;
            $image = imagecreate($width, $height);

            // Ranglarni belgilash
            $bgColor = imagecolorallocate($image, 255, 255, 255); // Oq fon
            $textColor = imagecolorallocate($image, 0, 0, 0);     // Qora matn

            // Matnni tasvirga joylash
            $fontPath = Yii::$app->basePath.'/web/design/src/Montserrat.ttf';
            if (!file_exists($fontPath)) {
                throw new \Exception("Font fayl mavjud emas: " . $fontPath);
            }

            imagettftext($image, 12, 0, 10, 20, $textColor, $fontPath, $htmlContent);

            // Tasvirni PNG formatda saqlash
            imagepng($image, $fileName);
            imagedestroy($image);

            // Telegramga yuborish
            $telegramUrl = "https://api.telegram.org/bot".Yii::$app->params['telegram']['token']."/sendPhoto";
            $postFields = [
                'chat_id' => $chat_id,
                'photo' => new \CURLFile($fileName)
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $telegramUrl);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);

            // Faylni o'chirish
            unlink($fileName);

            return $response;

        } catch (\Exception $e) {
            Yii::error("HTML sahifani yuklashda yoki Imagick bilan rasm yaratishda xatolik: " . $e->getMessage(), __METHOD__);
            return false; // Xatolik yuz berganda xabar berish
        }
    }

}