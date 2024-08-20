<?php
// اطلاعات اتصال به دیتابیس
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'newpbx');

// ایجاد اتصال به دیتابیس
function getDBConnection() {
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    // بررسی اتصال
    if ($conn->connect_error) {
        die("اتصال به دیتابیس ناموفق بود: " );
    }
    return $conn;
}