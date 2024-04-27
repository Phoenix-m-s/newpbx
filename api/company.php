<?php

define("looeicConfig", 'api');
include_once "../server.inc.php";
include_once ROOT_DIR . "common/looeic.config.php";
include_once ROOT_DIR . "common/db.inc.php";
include_once ROOT_DIR . "common/init.inc.php";
include_once ROOT_DIR . "common/func.inc.php";
include_once ROOT_DIR . "component/company/companyController.php";
include_once ROOT_DIR . 'services/dependency/DependencyService.php';

$company = new companyController();

applicationData();

switch ($_GET['action']) {

    case 'company':
        //middleware();
        $company->showAllCompanyApi();
        break;
    case 'createcompany':
        //middleware();
        $company->addCompanyApi($_POST);
        break;

    default:
        return ;
}
