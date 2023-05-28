<?php
include_once("server.inc.php");
include_once(ROOT_DIR . "common/db.inc.php");
include_once(ROOT_DIR . "common/init.inc.php");
include_once(ROOT_DIR . "common/func.inc.php");
include_once(ROOT_DIR . "component/db.inc.class.php");
include_once(ROOT_DIR . "component/sip.presentation.class.php");

global $admin_info;
if ($admin_info == -1) {
    if($member_info != -1) {
        redirectPage (RELA_DIR, "You dont have the permission to this page");
    }
    header("location:".RELA_DIR."login.php");
    die();
}
//checkPermissions();*/


$Sip = new sip_presentation();

switch ($_GET['action']) {

    case 'showSip':
        //checkPermissions('showAllSip', 'sip');
        $Sip->showAllSip('', '', '');
        break;

    case 'addSip':
        //checkPermissions('addSip', 'sip');
        if(isset($_POST['action']) & $_POST['action']=='addSip') {
            $Sip->addSip($_POST);
        } else {
            $Sip->addSipForm('', '');
        }
        break;

    case 'editSip':
        //checkPermissions('editSip','sip');
        if (isset($_POST['action']) & $_POST['action'] == 'editSip') {
            $Sip->editSip($_POST, '');
        } else {
            $Sip->editSipForm($_GET['id'], '');
        }
        break;

    case 'deleteSip':
        //checkPermissions('deleteSip', 'sip');
        if (isset($_GET['id'])) {
            $Sip->deleteSip($_GET['id']);
        }
        break;

    default:
        //checkPermissions('showAllSip', 'sip');
        $Sip->showAllSip('', '', '');
        break;
}
