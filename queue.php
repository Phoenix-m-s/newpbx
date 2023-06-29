<?php
include_once "server.inc.php";
include_once ROOT_DIR . "common/db.inc.php";
include_once ROOT_DIR . "common/init.inc.php";
include_once ROOT_DIR . "common/func.inc.php";
include_once ROOT_DIR . "component/db.inc.class.php";
include_once ROOT_DIR . "component/queue.presentation.class.php";
include_once ROOT_DIR . "component/company/AdminCompanyModel.php";
include_once ROOT_DIR . "component/queue/adminQueueController.php";

global $admin_info;
if ($admin_info == -1) {
    if ($member_info != -1) {
        redirectPage(RELA_DIR, "You dont have the permission to this page");
    }

    header("location:" . RELA_DIR . "login.php");
    die();
}
//checkPermissions();

$Queue = new AdminQueueController();
switch ($_GET['action']) {
    case 'downloadExcel':
        $Queue->excelQueue();
        break;


    case 'showLiveQueue':
        //checkPermissions('showAllQueues', 'queue');
        $Queue->showLiveQueue();
        break;

    case 'showQueues':
        checkPermissions('showAllQueues', 'queue');
        $Queue->showAllQueues();
        break;

    case 'showAgents':
        checkPermissions('showAllAgents', 'queue');
        $Queue->showAllAgents($_GET['queue_id']);
        break;

    case 'addQueue':
        checkPermissions('addQueue', 'queue');
        if (isset($_POST['action']) & $_POST['action'] == 'addQueue') {
            $Queue->addQueue($_POST);
        } else {
            $Queue->addQueueForm();
        }
        break;

    case 'editQueue':
        checkPermissions('editQueue', 'queue');

        if (isset($_POST['action']) & $_POST['action'] == 'editQueue') {
            $Queue->editQueue($_POST);
        } else {
            $Queue->editQueueForm($_GET['queue_id'], '');
        }
        break;

    case 'deleteQueues':
        checkPermissions('deleteQueue', 'queue');
        if (isset($_GET['queue_id'])) {
            $Queue->deleteQueues($_GET['queue_id']);
        }
        break;

    default:
        checkPermissions('showAllQueues', 'queue');
        $Queue->showAllQueues();
        break;
}
