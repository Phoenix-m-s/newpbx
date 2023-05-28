<?php
include_once "server.inc.php";
include_once ROOT_DIR . "common/db.inc.php";
include_once ROOT_DIR . "common/init.inc.php";
include_once ROOT_DIR . "common/func.inc.php";
include_once ROOT_DIR . "component/db.inc.class.php";
include_once ROOT_DIR . "component/conference/controller/ConferenceController.php";

global $admin_info;
if ($admin_info == -1 and $member_info == -1) {
    redirectPage(RELA_DIR . "login.php");
    die();
}
/*if ($member_info != -1) {
    if ($_GET['action'] == 'showConference' or $_GET['action'] == 'deleteExtension') {
        redirectPage(RELA_DIR . "extension.php" , "It's not possible");
        die();
    }
}*/
/*if ($admin_info == -1) {
    if ($member_info != -1) {
        redirectPage(RELA_DIR, "You don't have the permission to this page");
    }
    header("location:" . RELA_DIR . "login.php");
    die();
}*/
// checkPermissions();
$conference = new ConferenceController();

switch ($_GET['action']) {
    case 'showConference':
        checkPermissions('showAllConference','conference');
        $conference->showAllConference('', '', '');
        break;
    case 'addConference':
        checkPermissions('addConference', 'conference');

        if (isset($_POST['action']) & $_POST['action'] == 'addConference') {
            $conference->addConference($_POST);
        } else {
            $conference->addConferenceForm();
        }
        break;

    case 'editConference':
        checkPermissions('editConference','conference');
        if (isset($_POST['action']) & $_POST['action'] == 'editConference') {
            $conference->editConference($_POST, '');
        } else {
            $conference->editConferenceForm($_GET['id'], '', '');
        }
        break;

    case 'deleteConference':
        checkPermissions('deleteConference','conference');
        if (isset($_GET['id'])) {
            $conference->deleteConference($_GET['id']);
        }
        break;
    default:
        $conference->showAllConference('', '', '');
        break;
}
