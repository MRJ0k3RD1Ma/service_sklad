<?php

// API uchun kerakli ma’lumotlar
$hash = "fhd.ncbf9hf2ythr";        // Sizga berilgan hash
$cashierpass = "123123";          // Kassir paroli
$cashdeskid = "77";               // Kassa ID
$userId = "76";                   // O‘yinchi ID
$lng = "ru";                      // Til
$code = "a2a3";                   // Tasdiqlovchi kod (odatda SMS kod bo'lishi mumkin)

// 1. Confirm hisoblash: confirm = MD5(userId:hash)
$confirm = md5("$userId:$hash");

// 2. Sign hisoblash:
// a) sha256("hash=$hash&lng=$lng&UserId=$userId")
$step1 = hash("sha256", "hash=$hash&lng=$lng&UserId=$userId");

// b) md5("code=$code&cashierpass=$cashierpass&cashdeskid=$cashdeskid")
$step2 = md5("code=$code&cashierpass=$cashierpass&cashdeskid=$cashdeskid");

// c) sha256($step1 . $step2)
$sign = hash("sha256", $step1 . $step2);

// URL
$baseUrl = "https://partners.servcul.com/CashdeskBotAPI";
$url = "$baseUrl/Deposit/$userId/Payout";

// JSON yuboriladigan ma’lumotlar
$data = [
    "cashdeskId" => (int)$cashdeskid,
    "lng" => $lng,
    "code" => $code,
    "confirm" => $confirm
];

// cURL so‘rovi
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Header: JSON format va sign
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
