<?php
include_once("server.inc.php");
include_once(ROOT_DIR . "common/db.inc.php");
include_once(ROOT_DIR . "common/init.inc.php");
include_once(ROOT_DIR . "common/func.inc.php");
include_once(ROOT_DIR . "component/db.inc.class.php");
include_once(ROOT_DIR . "component/trunk/controller/trunkController.php");

global $admin_info;
if ($admin_info == -1) {
    if($member_info != -1) {
        redirectPage (RELA_DIR, "You dont have the permission to this page");
    }
    header("location:".RELA_DIR."login.php");
    die();
}
//  checkPermissions();

$Trunk_New = new TrunkController();


switch ($_GET['action']) {

    case 'showTrunk':
        //checkPermissions('showAllTrunk', 'trunk');
        $Trunk_New->showAllTrunk();
        break;

    case 'addTrunk':
        //checkPermissions('addTrunk', 'trunk');
        if(isset($_POST['action']) & $_POST['action']=='addTrunk') {
            $Trunk_New->addTrunk($_POST);
        } else {
            $Trunk_New->addTrunkForm('', '');
        }
        break;

    case 'editTrunk':
        //checkPermissions('editTrunk','trunk');
        if (isset($_POST['action']) & $_POST['action'] == 'editTrunk') {
            $Trunk_New->editTrunk($_POST, '');
        } else {
            $Trunk_New->editTrunkForm($_GET['id'], '');
        }
        break;

    case 'deleteTrunk':
        //checkPermissions('deleteTrunk', 'trunk');
        if (isset($_GET['id'])) {
            $Trunk_New->deleteTrunk($_GET['id']);
        }
        break;

    default:
        //checkPermissions('showAllTrunk', 'trunk');
        $Trunk_New->showAllTrunk('', '', '');
        break;
}
