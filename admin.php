<?php


include_once("server.inc.php");
include_once("common/essential.inc.php");

if ($admin_info == -1) {
    if( $member_info != -1 ) {
        redirectPage ( RELA_DIR, "You dont have the permission to this page" );
    }
    header("location:index.php");
    die();
}


//checkPermissions('view');


$AdminList = new admin();

if ($_REQUEST['action'] == "showeditadminform") {

    checkPermissions('edit');

    $adminListEdit = $AdminList->showEditAdminForm();
    $page->showAdminListEdit($adminListEdit);

} elseif ($_REQUEST['action'] == "editadmin") {

    checkPermissions('edit');
    $AdminList->editAdmin();
} elseif ($_REQUEST['action'] == "removeadmin") {

    checkPermissions('remove');
    $AdminList->removeAdmin();
} elseif ($_REQUEST['action'] == 'addadmin') {

    checkPermissions('add');
    $AdminList->addAdmin();
} elseif ($_REQUEST['action'] == "showsettask") {

    checkPermissions('settask');
    $permissionResult = $AdminList->showSetTask();
    $page->showAdminPermissionList($permissionResult);

} elseif ($_REQUEST['action'] == "setAdminTask") {

    checkPermissions('settask');
    $AdminList->setAdminTask();
} else {

   $adminListObj = $AdminList->showAdminList();
   $page->showAdminList($adminListObj);
}