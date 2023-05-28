<?php
include_once("server.inc.php");
include_once(ROOT_DIR . "common/db.inc.php");
include_once(ROOT_DIR . "common/init.inc.php");
include_once(ROOT_DIR . "common/func.inc.php");
include_once(ROOT_DIR . "component/db.inc.class.php");
include_once(ROOT_DIR . "component/inbound.presentation.class.php");

global $admin_info;
if ($admin_info == -1) {
    if( $member_info != -1 ) {
        redirectPage ( RELA_DIR, "You dont have the permission to this page" );
    }
    header("location:".RELA_DIR."login.php");
    die();
}

$Inbound = new guide();

switch ($_GET['action'])
{
    case 'showGuide':
        $Inbound->showGuide();
        break;
    default:
        $Inbound->showGuide();
        break;
}
