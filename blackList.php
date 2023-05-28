<?php
/**
 * Created by PhpStorm.
 * User: FaridCS
 * Date: 11/6/2014
 * Time: 11:23 AM
 */

include_once("server.inc.php");
include_once("common/essential.inc.php");

if($admin_info == -1) {
    if( $member_info != -1 ) {
        redirectPage ( RELA_DIR, "You dont have the permission to this page" );
    }
    $page->loginform();
}


checkPermissions('blackList');

$blackList = new blackList();

if(isset($_REQUEST['action'])) {
    switch ($_REQUEST['action']) {

        // Get data table of black list
        case 'black' :
            $blackList->blackList();
            break;

        // add to black list
        case 'add' :
            checkPermissions('add',ADD);
            $blackList->addInfo = $_POST;
            $blackList->addToList();
            break;

        // edit black list
        case 'edit' :
            checkPermissions('edit',EDIT_01);
            $blackList->editInfo = $_POST;
            $blackList->editToList();
            break;

        // delete number from black list
        case 'delete' :
            checkPermissions('delete',DELETE_01);
            $id = handleData($_POST['deleteId']);
            $blackList->deleteBlackList($id);
            break;

        // show black List
        default :
            checkPermissions('blackList',BLACK_LIST);
            $result = $blackList->getCamp();
            $page->blackList();
            break;
    }
} else {

    // show black List
    checkPermissions('blackList');
    $result = $blackList->getCamp();
    $page->blackList($result);
}
