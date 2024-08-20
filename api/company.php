<?php
header('Content-Type: application/json; charset=utf-8');
define("looeicConfig", 'api');
include_once "../server.inc.php";
include_once ROOT_DIR . "common/looeic.config.php";
include_once ROOT_DIR . "common/db.inc.php";
include_once ROOT_DIR . "common/init.inc.php";
include_once ROOT_DIR . "common/func.inc.php";
include_once ROOT_DIR . "component/company/companyController.php";
include_once ROOT_DIR . 'services/dependency/DependencyService.php';
include_once ROOT_DIR . "api/jwt/jwt.php"; // وارد کردن فایل JWT

$company = new companyController();

// احراز هویت برای هر درخواست
$decodedToken = authenticate(); // احراز هویت با توکن

$company = new companyController();


applicationData();

switch ($_GET['action']) {

    case 'company':
        //middleware(); // در صورت نیاز می‌توانید Middlewareها را اضافه کنید
        $company->showAllCompanyApi();
        break;

    case 'createcompany':
        //middleware();
        $company->addCompanyApi($_POST);
        break;

    default:
        http_response_code(404); // Not Found
        echo json_encode([
            "result" => -1,
            "data" => ["message" => "درخواست نامعتبر است"]
        ], JSON_UNESCAPED_UNICODE);
        break;
}

?>
