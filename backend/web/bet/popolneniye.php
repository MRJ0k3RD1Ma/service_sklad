<?php

// API uchun kerakli ma’lumotlar
$hash = "fhd.ncbf9hf2ythr";        // Sizga berilgan hash
$cashierpass = "123123";          // Kassir paroli
$cashdeskid = "77";               // Kassa ID
$userId = "76";                   // O‘yinchi ID
$summa = 100;                     // To‘ldiriladigan summa
$lng = "ru";                      // Til

// 1. Confirm ni hisoblash: confirm = MD5(userId:hash)
$confirm = md5("$userId:$hash");

// 2. Sign hisoblash:
// a) sha256("hash=$hash&lng=$lng&UserId=$userId")
$step1 = hash("sha256", "hash=$hash&lng=$lng&UserId=$userId");

// b) md5("summa=$summa&cashierpass=$cashierpass&cashdeskid=$cashdeskid")
$step2 = md5("summa=$summa&cashierpass=$cashierpass&cashdeskid=$cashdeskid");

// c) sha256($step1 . $step2)
$sign = hash("sha256", $step1 . $step2);

// So‘rov URL'si
$baseUrl = "https://partners.servcul.com/CashdeskBotAPI";
$url = "$baseUrl/Deposit/$userId/Add";

// Yuboriladigan JSON ma’lumot
$data = [
    "cashdeskId" => (int)$cashdeskid,
    "lng" => $lng,
    "summa" => (float)$summa,
    "confirm" => $confirm
];

// cURL so‘rovi
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// JSON yuborish uchun header
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    "sign: $sign"
]);

curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo "cURL xatosi: " . curl_error($ch);
} else {
    echo "API javobi:\n$response\n";
}

curl_close($ch);
