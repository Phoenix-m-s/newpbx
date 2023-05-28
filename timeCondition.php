<?php
include_once("server.inc.php");
include_once(ROOT_DIR . "common/db.inc.php");
include_once(ROOT_DIR . "common/init.inc.php");
include_once(ROOT_DIR . "common/func.inc.php");
include_once(ROOT_DIR . "component/db.inc.class.php");
include_once(ROOT_DIR . "component/timeCondition.presentation.class.php");

global $admin_info;
if ($admin_info == -1)
{
    if( $member_info != -1 ) {
        redirectPage ( RELA_DIR, "You dont have the permission to this page" );
    }
    header("location:" . RELA_DIR . "login.php");
    die();
}

$TimeCondition = new timeCondition_presentation();

switch ($_GET['action'])
{
    case 'search':
        $IVR->search($_GET);
        break;

    case 'showIvr':
        checkPermissions('showAllIvr', 'ivr');
        $IVR->showAllIvr('','','');
        break;

    case 'showDST':
        checkPermissions('showAllDST', 'ivr');
        $IVR->showAllDST($_GET['id']);
        break;

    case 'addTimeCondition':
        //checkPermissions('addIvr','ivr');
        if (isset($_POST['action']) & $_POST['action'] == 'addIvr') {
            $TimeCondition->addIvr($_POST);
        } else {
            $TimeCondition->addTimeConditionForm('','');
        }
        break;

    case 'editIvr':
        checkPermissions('editIvr', 'ivr');
        if (isset($_POST['action'])& $_POST['action'] == 'update') {
            $TimeCondition->editIvr($_POST,'');

        } else {
            $TimeCondition->editIvrForm($_GET['id']);
        }
        break;

    case 'deleteIvr':
        checkPermissions('deleteIvr', 'ivr');
        if(isset($_GET['id'])) {
            $IVR->deleteIVRs($_GET['id']);
        }
        break;

    default:
        checkPermissions('showAllIvr', 'ivr');
        $IVR->showAllIvr('','','');
        break;
}