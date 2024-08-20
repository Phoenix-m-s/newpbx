<?php
// توابع کمکی برای کدگذاری و کدگشایی Base64 در فرمت URL
function base64UrlEncode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function base64UrlDecode($data) {
    return base64_decode(strtr($data, '-_', '+/'));
}

// تولید توکن JWT
function generateToken($userId) {
    $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
    $payload = json_encode([
        'userId' => $userId,
        'iat' => time(),
        'exp' => time() + 3600  // توکن بعد از 1 ساعت منقضی می‌شود
    ]);

    $base64UrlHeader = base64UrlEncode($header);
    $base64UrlPayload = base64UrlEncode($payload);
    $secretKey = "A$3cRe7Key@123456!%";


    $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $secretKey, true);
    $base64UrlSignature = base64UrlEncode($signature);

    $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    return $jwt;
}

// احراز هویت با استفاده از JWT
// احراز هویت با استفاده از JWT
function authenticate() {

    header('Content-Type: application/json; charset=utf-8');

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

    // تولید signature دوباره برای مقایسه
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
