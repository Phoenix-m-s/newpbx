<?php
function base64UrlEncode($data) {
    if (is_array($data)) {
        $data = json_encode($data); // تبدیل آرایه به رشته JSON
    }
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}
function base64UrlDecode($data) {
    return base64_decode(strtr($data, '-_', '+/'));
}
// تولید توکن JWT
function generateToken($userId) {
    $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
    $payload = [
        'iat' => time(), // زمان ایجاد توکن
        'exp' => time() + 3600, // انقضا: 1 ساعت بعد
        'user_id' => $userId // سایر داده‌ها
    ];

    $base64UrlHeader = base64UrlEncode($header);
    $base64UrlPayload = base64UrlEncode($payload);
    $secretKey = "A$3cRe7Key@123456!%";


    $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $secretKey, true);
    $base64UrlSignature = base64UrlEncode($signature);

    $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    return $jwt;
}

// احراز هویت با استفاده از JWT
function authenticate() {
    $headers = getallheaders();
    if (!isset($headers['Authorization'])) {
        http_response_code(401);
        echo json_encode(["result" => -1, "data" => ["message" => "توکن یافت نشد، دسترسی غیرمجاز"]], JSON_UNESCAPED_UNICODE);
        exit();
    }

    $token = str_replace('Bearer ', '', $headers['Authorization']);
    list($headerEncoded, $payloadEncoded, $signatureEncoded) = explode('.', $token);

    $data = $headerEncoded . '.' . $payloadEncoded;
    $secretKey = "A$3cRe7Key@123456!%";

    $signature = base64UrlEncode(hash_hmac('sha256', $data, $secretKey, true));

    if ($signature !== $signatureEncoded) {
        http_response_code(401);
        echo json_encode(["result" => -1, "data" => ["message" => "توکن نامعتبر است"]], JSON_UNESCAPED_UNICODE);
        exit();
    }

    $payload = json_decode(base64UrlDecode($payloadEncoded), true);

    if ($payload['exp'] < time()) {
        http_response_code(401);
        echo json_encode(["result" => -1, "data" => ["message" => "توکن منقضی شده است"]], JSON_UNESCAPED_UNICODE);
        exit();
    }

    return $payload; // بازگشت payload توکن
}



?>
