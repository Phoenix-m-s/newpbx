<?php
include_once "server.inc.php";
include_once ROOT_DIR . "common/db.inc.php";
include_once ROOT_DIR . "common/init.inc.php";
include_once ROOT_DIR . "common/func.inc.php";
include_once ROOT_DIR . "component/db.inc.class.php";
include_once ROOT_DIR . "component/upload.presentation.class.php";
include_once ROOT_DIR . "component/upload/adminUploadController.php";

global $admin_info, $member_info;
//checkPermissions();

//$Upload = new upload_presentation();
    $Upload = new AdminUploadController();

if ($member_info != -1) {

    switch ($_GET['action']) {
        case 'search':
            $Upload->search($_GET);
            break;
        case 'showUploads':
            $Upload->showAllUploads('', '', '');
            break;
        case 'addFile':
            if (isset($_POST['submit'])) {
                $Upload->addFile($_FILES, $_POST);
            } elseif (($_POST['audiosrc'])) {
                $session_id = '1';
                $audiosrc = $_POST['audiosrc'];
                $Upload->recorder($audiosrc, $session_id);
            } else {
                $Upload->addUploadForm('', '');
            }
            break;
        case 'deleteFiles':
            if (isset($_GET['id'])) {
                $Upload->deleteFiles($_GET['id']);
            }
            break;
        case 'trashFile':
            if (isset($_GET['id'])) {
                $Upload->trashFiles($_GET['id']);
            }
            break;
        case 'recycleFile':
            if (isset($_GET['id'])) {
                $Upload->recycleFiles($_GET['id']);
            }
            break;
        default:
            $Upload->showAllUploads('', '', '');
            break;
    }

}

if ($admin_info != -1) {

    switch ($_GET['action']) {
        case 'search':
            $Upload->search($_GET);
            break;
        case 'showUploads':
            //checkPermissions('showAllUploads', 'upload');
            $Upload->showAllUploads('', '', '');
            break;
        case 'addFile':
            //checkPermissions('addFile', 'upload');
            if (isset($_POST['submit'])) {
                $Upload->addFile($_FILES, $_POST);
            } elseif (($_POST['audiosrc'])) {
                $session_id = '1';
                $audiosrc = $_POST['audiosrc'];
                $Upload->recorder($audiosrc, $session_id);
            } else {
                $Upload->addUploadForm('', '');
            }
            break;
        case 'deleteFiles':
            checkPermissions('deleteUpload','upload');
            if (isset($_GET['id'])) {
                $Upload->deleteFiles($_GET['id']);
            }
            break;
        case 'trashFile':
            checkPermissions('trashFiles','upload');
            if (isset($_GET['id'])) {
                $Upload->trashFiles($_GET['id']);
            }
            break;
        case 'recycleFile':
            checkPermissions('recycleFiles', 'upload');
            if (isset($_GET['id'])) {
                $Upload->recycleFiles($_GET['id']);
            }
            break;
        default:
            checkPermissions('showAllUpload', 'upload');
            $Upload->showAllUploads('', '', '');
            break;
    }

}

