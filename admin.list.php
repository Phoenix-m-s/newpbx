<?php

include_once "server.inc.php";

include_once ROOT_DIR . "common/db.inc.php";
include_once ROOT_DIR . "common/init.inc.php";
include_once ROOT_DIR . "common/func.inc.php";
include_once ROOT_DIR . "component/db.inc.class.php";
include_once ROOT_DIR . "component/admin/AdminUserController.php";


global $admin_info;
if ($admin_info == -1) {
    if ($member_info != -1) {
        redirectPage(RELA_DIR, "You don't have the permission to this page");
    }
    header("location:" . RELA_DIR . "login.php");
    die();
}
//checkPermissions();

$adminList = new AdminUserController();


switch ($_GET['action']) {

    case 'showAdmin':
        //checkPermissions('showAdmin','announce');
        $adminList->showAllAdmin('', '', '');
        break;
    case 'filterUser':
        $adminList->filterUser($_GET);
        break;
    case 'addAdmin':

        //checkPermissions('add','admin.list');

        if (isset($_POST['action']) & $_POST['action'] == 'addAdmin') {
            $adminList->addAdmin($_POST);
        } else {
            $adminList->addAdminForm($_GET['id'], '');
        }
        break;
    case 'editAdmin':
        //checkPermissions('edit','admin.list');
        if (isset($_POST['action']) & $_POST['action'] == 'editAdmin') {
            $adminList->editAdmin($_POST, '');
        } else {
            $adminList->editAdminForm($_GET['id'], '', '');
        }
        break;
    case 'deleteAdmin':
        //checkPermissions('remove','admin.list');
        if (isset($_GET['id'])) {
            $adminList->deleteAdmin($_GET['id']);
        }
        break;
    case 'permissionAdmin':
        //checkPermissions('permission','admin.list');
        if (isset($_GET['id'])) {
            $adminList->permissionAdmin($_GET['id']);
        }
        break;
    case 'addPermissionAdmin':
        //checkPermissions('addPermission','admin.list');
        //if(isset($_POST['action'])){
        $adminList->addPermissionAdmin($_POST);
        //}
        break;
    default:
        $adminList->showAllAdmin('', '', '');
        break;
}

