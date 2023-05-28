<?php
include_once("server.inc.php");
include_once(ROOT_DIR . "common/db.inc.php");
include_once(ROOT_DIR . "common/init.inc.php");
include_once(ROOT_DIR . "common/func.inc.php");
include_once(ROOT_DIR . "component/db.inc.class.php");
include_once(ROOT_DIR . "component/packageLog.presentation.class.php");

global $admin_info;
if ($admin_info == -1)
{
    if( $member_info != -1 ) {
        redirectPage ( RELA_DIR, "You dont have the permission to this page" );
    }
    header("location:".RELA_DIR."login.php");
    die();
}

$packageLog = new packageLog_presentation();

switch ($_GET['action']) {

    case 'showPackageLog':
        checkPermissions('showAllPackageLog','packageLog');
        $packageLog->showAllPackageLog('');
        break;

    case 'searchPackageLog':
        $packageLog->searchPackageLog('');
        break;

    case 'getInvoice':
        checkPermissions('getLastPackage','packageLog');
        $packageLog->getLastPackage('');
        break;

    case 'checkStartDate':
        checkPermissions('checkStartDate','packageLog');
        $packageLog->checkStartDate();
        break;

    case 'getLastPackageByOrderFor':
        checkPermissions('getLastPackageByOrderFor','packageLog');
        $packageLog->getLastPackageByOrderFor($_GET['invoice_id']);
        break;

    default:
        checkPermissions('showAllPackageLog','packageLog');
        $packageLog->showAllPackageLog('');
        break;

}
