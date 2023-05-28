<?php

include_once "server.inc.php";
include_once ROOT_DIR . "common/db.inc.php";
include_once ROOT_DIR . "common/init.inc.php";
include_once ROOT_DIR . "common/func.inc.php";
include_once ROOT_DIR . "component/db.inc.class.php";
include_once ROOT_DIR . "component/ivr.presentation.class.php";
include_once ROOT_DIR . "component/ivr/adminIVRController.php";
global $admin_info, $member_info;
if ($admin_info == -1) {
    if ($member_info != -1) {
        redirectPage(RELA_DIR, "You don't have the permission to this page");
    }

    header("location:" . RELA_DIR . "login.php");
    die();
}
//checkPermissions();

$IVR = new AdminIVRController();
switch ($_GET['action']) {

    case 'showIvr':
        checkPermissions('showAllIvr', 'ivr');
        $IVR->showAllIvr('', '', '');
        break;

    case 'showDST':
        checkPermissions('showAllDST', 'ivr');
        $IVR->showAllDST($_GET['id']);
        break;

    case 'addIvr':
        checkPermissions('addIvr', 'ivr');
        if (isset($_POST['action']) & $_POST['action'] == 'addIvr') {
            $IVR->addIvr($_POST);
        } else {
            $IVR->addIvrForm();
        }
        break;

    case 'editIvr':
        checkPermissions('editIvr', 'ivr');
        if (isset($_POST['action']) & $_POST['action'] == 'editIvr') {
            $IVR->editIvr($_POST);
        } else {
            $IVR->editIvrForm($_GET['id']);
        }
        break;


    case 'deleteIvr':
        checkPermissions('deleteIvr', 'ivr');
        if (isset($_GET['id'])) {
            $IVR->deleteIVRs($_GET['id']);
        }
        break;

    default:
        checkPermissions('showAllIvr', 'ivr');
        $IVR->showAllIvr('', '', '');
        break;
}
