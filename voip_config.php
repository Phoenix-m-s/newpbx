<?php
include_once("server.inc.php");
include_once(ROOT_DIR . "common/db.inc.php");
include_once(ROOT_DIR . "common/init.inc.php");
include_once(ROOT_DIR . "common/func.inc.php");
include_once(ROOT_DIR . "component/db.inc.class.php");
include_once(ROOT_DIR . "component/db.inc.class.php");
include_once(ROOT_DIR . "component/voipConfig/adminVoipConfigController.php");
include_once ROOT_DIR . "component/extension.model.php";

global $admin_info;
if ($admin_info == -1) {
    if($member_info != -1) {
        redirectPage (RELA_DIR, "You dont have the permission to this page");
    }
    header("location:".RELA_DIR."login.php");
    die();
}

$voip = new adminVoipConfigController();

switch ($_GET['action']) {

    case 'addVoipConfig':
        //checkPermissions('addVoipConfig', 'voipConfig');
        if(isset($_POST['action']) & $_POST['action']=='addVoipConfig') {
            $voip->createFile($_POST);
        } else {
            $voip->addVoipConfigForm($_GET['id']);
        }
        break;

    default:
        $voip->addVoipConfigForm('', '');
        break;
}
