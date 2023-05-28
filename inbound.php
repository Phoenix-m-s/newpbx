<?php
include_once("server.inc.php");
include_once(ROOT_DIR . "common/db.inc.php");
include_once(ROOT_DIR . "common/init.inc.php");
include_once(ROOT_DIR . "common/func.inc.php");
include_once(ROOT_DIR . "component/db.inc.class.php");
include_once(ROOT_DIR . "component/inbound.presentation.class.php");
include_once(ROOT_DIR . "component/inbound/adminInboundController.php");

global $admin_info;
if ($admin_info == -1) {
    if ($member_info != -1) {
        redirectPage(RELA_DIR, "You dont have the permission to this page");
    }
    header("location:" . RELA_DIR . "login.php");
    die();
}
//checkPermissions();

$inbound = new AdminInboundController();
switch ($_GET['action']) {

    case 'showInbound':
        checkPermissions('showAllInbound', 'inbound');
        $inbound->showAllInbound();
        break;

    case 'addInbound':
        checkPermissions('addInbound', 'inbound');
        if (isset($_POST['action']) & $_POST['action'] == 'addInbound') {
            $inbound->addInbound($_POST);
        } else {
            $inbound->addInboundForm($_GET['id'], '');
        }
        break;

    case 'editInbound':
        checkPermissions('editInbound', 'inbound');
        if (isset($_POST['action']) & $_POST['action'] == 'editInbound') {
            //print_r_debug($_POST);
            $inbound->editInbound($_POST);
        } else {
            $inbound->editInboundForm($_GET['id'], '');
        }
        break;

    case 'deleteInbound':
        checkPermissions('deleteInbound', 'inbound');
        if (isset($_GET['id'])) {
            $inbound->deleteInbound($_GET['id']);
        }
        break;

    default:
        checkPermissions('showAllInbound', 'inbound');
        $inbound->showAllInbound();
        break;
}
