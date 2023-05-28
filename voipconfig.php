<?php

include_once("server.inc.php");

include_once(ROOT_DIR . "common/db.inc.php");
include_once(ROOT_DIR . "common/init.inc.php");
include_once(ROOT_DIR . "common/func.inc.php");
include_once(ROOT_DIR . "component/db.inc.class.php");
include_once(ROOT_DIR . "component/StepForm/StepForm.php");
include_once ROOT_DIR . "component/StepForm/UploaderConfig.php";
include_once(ROOT_DIR . "component/voipConfig/adminNewVoipConfigController.php");
include_once ROOT_DIR . "component/extension.model.php";
global $admin_info;

if ($admin_info == -1) {
    if($member_info != -1) {
        redirectPage (RELA_DIR, "You dont have the permission to this page");
    }
    header("location:".RELA_DIR."login.php");
    die();
}
$voip = new adminNewVoipConfigController();



switch ($_GET['action']) {

    case 'stepform' :
            $voip->stepform($_POST);

        break;

    case 'finish' :
       // $voip->finish($_POST);
        break;

    default :
        $voip->index('','');
        break;
}
