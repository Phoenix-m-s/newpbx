<?php
include_once "server.inc.php";
include_once ROOT_DIR . "common/db.inc.php";
include_once ROOT_DIR . "common/init.inc.php";
include_once ROOT_DIR . "common/func.inc.php";
include_once ROOT_DIR . "component/db.inc.class.php";
include_once ROOT_DIR . "component/announce.presentation.class.php";
include_once ROOT_DIR . "component/announce/adminAnnounceController.php";

global $admin_info;

if ($admin_info == -1) {
    if ($member_info != -1) {
        redirectPage(RELA_DIR, "You don't have the permission to this page");
    }
    header("location:" . RELA_DIR . "login.php");
    die();
}
//checkPermissions();

//$announce = new announce_presentation();
$announce = new AdminAnnounceController();

switch ($_GET['action']) {
    case 'showAnnounce':
        //checkPermissions('showAllAnnounce','announce');
        $announce->showAllAnnounce('', '', '');
        break;
    case 'addAnnounce':
        checkPermissions('addAnnounce', 'announce');

        if (isset($_POST['action']) & $_POST['action'] == 'addAnnounce') {
            $announce->addAnnounce($_POST);
        } else {
            $announce->addAnnounceForm($_GET['id'], '');
        }
        break;
    case 'editAnnounce':
        checkPermissions('editAnnounce','announce');
        if (isset($_POST['action']) & $_POST['action'] == 'editAnnounce') {
            $announce->editAnnounce($_POST, '');
        } else {
            $announce->editAnnounceForm($_GET['id'], '', '');
        }
        break;
    case 'deleteAnnounce':
        checkPermissions('deleteAnnounce','announce');
        if (isset($_GET['id'])) {
            $announce->deleteAnnounce($_GET['id']);
        }
        break;
    default:
        $announce->showAllAnnounce('', '', '');
        break;
}
