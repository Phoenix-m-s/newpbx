<?php

include_once("server.inc.php");
include_once(ROOT_DIR . "common/db.inc.php");
include_once(ROOT_DIR . "common/init.inc.php");
include_once(ROOT_DIR . "common/func.inc.php");
include_once(ROOT_DIR . "component/db.inc.class.php");
include_once(ROOT_DIR . "component/routing/controller/routingController.php");

global $admin_info;
if ($admin_info == -1) {
    if($member_info != -1) {
        redirectPage (RELA_DIR, "You dont have the permission to this page");
    }
    header("location:".RELA_DIR."login.php");
    die();

}
//checkPermissions();

//$Routing = new routing_presentation();
$routing = new routingController();
switch ($_GET['action']) {

    case 'showRouting':
        checkPermissions('showAllRouting', 'routing');
        $routing->showAllRouting();
        break;

    case 'editRouting':
        checkPermissions('editRouting','routing');
        $routing->addRouting($_POST);
        break;
    default:
        checkPermissions('showAllRouting', 'routing');
        $routing->showAllRouting();
        break;
}