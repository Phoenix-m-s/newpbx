<?php

include_once "server.inc.php";
include_once ROOT_DIR . "common/db.inc.php";
include_once ROOT_DIR . "common/init.inc.php";
include_once ROOT_DIR . "common/func.inc.php";
include_once ROOT_DIR . "component/db.inc.class.php";
define("looeicConfig", 'api');
global $admin_info;

if ($admin_info == -1) {
    if ($member_info != -1) {
        redirectPage(RELA_DIR, "You don't have the permission to this page");
    }
    header("location:" . RELA_DIR . "login.php");
    die();
}

switch ($_GET['action']) {
    case 'fa':
        //checkPermissions('showAllAnnounce','announce');
        $lang= changeLang('fa');
        break;
    case 'en':
        $lang= changeLang('en');
        break;
    default:
        $lang= changeLang('en');
        break;
}
