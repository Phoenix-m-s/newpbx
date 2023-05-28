<?php
include_once("server.inc.php");
include_once(ROOT_DIR . "common/db.inc.php");
include_once(ROOT_DIR . "common/init.inc.php");
include_once(ROOT_DIR . "common/func.inc.php");
include_once(ROOT_DIR . "component/db.inc.class.php");
include_once(ROOT_DIR . "component/outbound.presentation.class.php");
include_once(ROOT_DIR . "services/OutBoundService.php");
include_once(ROOT_DIR . "component/outbound/adminOutboundController.php");
global $admin_info;
if ($admin_info == -1) {
    if($member_info != -1) {
        redirectPage (RELA_DIR, "You dont have the permission to this page");
    }

    header("location:".RELA_DIR."login.php");
    die();
}

//checkPermissions();

$Outbound = new AdminOutboundController();

switch ($_GET['action'])
{
    case 'search':
        $Outbound->search($_GET);
        break;

    case 'showOutbound':
        checkPermissions('showAllOutbound', 'outbound');
        $Outbound->showAllOutbound('','');
        break;

    case 'showDialPattern':
        checkPermissions('showDialPattern', 'outbound');
        $Outbound->showAllDialPattern($_GET['id']);
        break;

    case 'addOutbound':
        checkPermissions('addOutbound', 'outbound');
        if (isset($_POST['action']) & $_POST['action'] == 'addOutbound') {
            $Outbound->addOutbound($_POST);
        } else {
            $Outbound->addOutboundForm($_GET['id'], '');

        }
        break;

    case 'editOutbound':
        checkPermissions('editOutbound', 'outbound');
        if (isset($_POST['action'])& $_POST['action'] == 'editOutbound') {
            $Outbound->editOutbound($_POST, '');
        } else {
            $Outbound->editOutboundForm($_GET['id'], '');
        }
        break;

    case 'deleteOutbound':
        checkPermissions('deleteOutbound', 'outbound');
        if (isset($_GET['id'])) {
            $Outbound->deleteOutbound($_GET['id']);
        }
        break;

    case 'trashOutbound':
        checkPermissions('trashOutbound', 'outbound');
        if (isset($_GET['id'])) {
            $Outbound->trashOutbounds($_GET['id']);
        }
        break;

    case 'recycleOutbound':
        checkPermissions('recycleOutbound', 'outbound');
        if (isset($_GET['id'])) {
            $Outbound->recycleOutbounds($_GET['id']);
        }
        break;

    case 'changeStatus':
        checkPermissions('changeStatus', 'outbound');
        if (isset($_POST['active']) && isset($_POST['outboundID'])) {

            $_POST['status']='Enable';
            $Outbound->changeStatus($_POST);
        } elseif(isset($_POST['inactive']) && isset($_POST['outboundID'])) {
            $_POST['status'] = 'Disable';
            $Outbound->changeStatus($_POST);
        } else {
            $Outbound->showAllOutbound('', '');
        }
        break;

    default:
        checkPermissions('showAllOutbound', 'outbound');
        $Outbound->showAllOutbound('', '');
        break;
}
