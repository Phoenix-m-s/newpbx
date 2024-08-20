<?php
header('Content-Type: application/json; charset=utf-8');
include_once "jwt/jwt.php";
include_once 'config/dbConfig.php';

// بررسی صحت ورودی‌ها
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'login') {

    if (empty($_POST['username']) || empty($_POST['password'])) {
        http_response_code(400); // Bad Request
        echo json_encode([
            "data" => ["message" => "نام کاربری و رمز عبور نمی‌توانند خالی باشند"],
            "result" => -1
        ], JSON_UNESCAPED_UNICODE);
        exit();
    }

    $username = $_POST['username'];
    $password = md5($_POST['password']); // استفاده از md5 (که توصیه نمی‌شود، اما به نظر می‌رسد شما این را انتخاب کرده‌اید)

    // اتصال به دیتابیس
    $conn = getDBConnection();

    if ($conn->connect_error) {
        http_response_code(500); // Internal Server Error
        echo json_encode([
            "data" => ["message" => "مشکل در اتصال به دیتابیس: " . $conn->connect_error],
            "result" => -1
        ], JSON_UNESCAPED_UNICODE);
        exit();
    }

    // ساخت کوئری
    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ? AND password = ?");
    if (!$stmt) {
        http_response_code(500); // Internal Server Error
        echo json_encode([
            "data" => ["message" => "خطا در ساخت کوئری: " . $conn->error],
            "result" => -1
        ], JSON_UNESCAPED_UNICODE);
        exit();
    }

    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // تولید توکن
        $userId = $user['admin_id'];
        $token = generateToken($userId);

        echo json_encode([
            "data" => ["token" => $token, "message" => "ورود موفقیت‌آمیز بود"],
            "result" => 1
        ], JSON_UNESCAPED_UNICODE);
    } else {
        http_response_code(401); // Unauthorized
        echo json_encode([
            "data" => ["message" => "نام کاربری یا رمز عبور اشتباه است"],
            "result" => -1
        ], JSON_UNESCAPED_UNICODE);
    }

    $stmt->close();
    $conn->close();
    exit();
}

// اگر درخواست نامعتبر باشد
http_response_code(404); // Not Found
echo json_encode([
    "data" => ["message" => "درخواست نامعتبر است"],
    "result" => -1
], JSON_UNESCAPED_UNICODE);

