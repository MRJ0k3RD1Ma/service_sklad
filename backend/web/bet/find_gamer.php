<?php

// API uchun kerakli parametrlar (shu yerga o'z ma'lumotlaringizni yozing)
$hash = "6ba7481b54c22d03d5c1228c3367824313d033a50a24d5745c3cd6955f41bd56";        // API hash
$cashierpass = "542558";          // Kassir paroli
$cashdeskid = "1114271";              // Kassa ID

// Hozirgi vaqt UTC formatda (masalan: 2023.01.01 10:00:00)
$dt = gmdate("Y.m.d H:i:s");      // UTC format
$userId = "1310874607";                  // Qidirilayotgan foydalanuvchi ID

// 1. Confirm ni hisoblash: confirm = MD5(userId:hash)
$confirm = md5("$userId:$hash");

// 2. Sign ni hisoblash:
// a) sha256("hash=...&userid=...&cashdeskid=...")
$step1 = hash("sha256", "hash=$hash&userid=$userId&cashdeskid=$cashdeskid");

// b) md5("userid=...&cashierpass=...&hash=...")
$step2 = md5("userid=$userId&cashierpass=$cashierpass&hash=$hash");

// c) sha256($step1 . $step2)
$sign = hash("sha256", $step1 . $step2);

// So‘rov URL'si
$baseUrl = "https://partners.servcul.com/CashdeskBotAPI";
$url = "$baseUrl/Users/$userId?confirm=$confirm&cashdeskId=$cashdeskid";

// cURL so‘rovini yuboramiz
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Sign ni headerga qo‘shamiz
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "sign: $sign"
]);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo "cURL error: " . curl_error($ch);
} else {
    echo "Foydalanuvchi haqida ma'lumot:\n$response\n";
}

curl_close($ch);
