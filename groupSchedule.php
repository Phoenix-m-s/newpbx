<?php
/**
 * Created by PhpStorm.
 * User: FaridCS
 * Date: 10/28/2014
 * Time: 10:00 PM
 */

include_once("server.inc.php");
include_once("common/essential.inc.php");

if($admin_info == -1) {
    if( $member_info != -1 ) {
        redirectPage ( RELA_DIR, "You dont have the permission to this page" );
    }
    $page->loginform();
}

checkPermissions('groupScheduleList');

$groupSchedule = new groupSchedule();

if(isset($_REQUEST['action'])) {
    switch ($_REQUEST['action']) {

        // add Group
        case 'addGroup' :
            checkPermissions('addGroup',ModelADMIN_75);
            $groupSchedule->addGroupInfo = $_POST;
            $groupSchedule->addGroup();
            break;

        // edit Group schedule
        case 'editGroup' :
            checkPermissions('editGroup',ModelADMIN_76);
            $groupSchedule->editGroupInfo = $_POST;
            $result = $groupSchedule->editGroup();
            break;

        // show Schedule list
        case 'showSchedule' :
            checkPermissions('showSchedule',SCHEDULE_LIST);
            $id = handleData($_GET['id']);
            $result = $groupSchedule->showSchedule($id);
            $page->showSchedule($result);
            break;

        // show Add Schedule page
        case 'showAddSchedule' :
            checkPermissions('showAddSchedule',ADD_NEW_SCHEDULE);
            $id = handleData($_GET['id']);
            $page->showAddSchedule($id);
            break;

        // Add Schedule
        case 'addSchedule' :
            $groupSchedule->addGroupScheduleInfo = $_POST;
            $groupSchedule->addGroupSchedule();
            break;

        // delete Schedule
        case 'deleteSchedule' :
            checkPermissions('deleteSchedule',DELETE_SCHEDULE);
            $id = handleData($_POST['deleteScheduleId']);
            $groupId = handleData($_POST['scheduleGroupId']);
            $groupSchedule->deleteSchedule($id,$groupId);
            break;

        // show Edit Schedule
        case 'showEditSchedule' :
            checkPermissions('showEditSchedule',MODIFIED_SCHEDULE);
            $id = handleData($_GET['id']);
            $groupId = handleData($_GET['groupId']);
            $result = $groupSchedule->showEditSchedule($id,$groupId);
            $page->showEditSchedule($result);
            break;

        // Edit Schedule
        case 'editSchedule' :
            $groupSchedule->editScheduleInfo = $_POST;
            $groupSchedule->editSchedule();
            break;

        // Group Schedule List
        default :
            checkPermissions('groupScheduleList',SCHEDULE_GROUP_LIST);
            $result = $groupSchedule->groupScheduleList();
            $page->groupSchedule($result);
            break;
    }
} else {
    // Group Schedule List
    checkPermissions('groupScheduleList');
    $result = $groupSchedule->groupScheduleList();
    $page->groupSchedule($result);
}
