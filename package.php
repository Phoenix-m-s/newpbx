<?php
include_once("server.inc.php");
include_once(ROOT_DIR . "common/db.inc.php");
include_once(ROOT_DIR . "common/init.inc.php");
include_once(ROOT_DIR . "common/func.inc.php");
include_once(ROOT_DIR . "component/db.inc.class.php");
include_once(ROOT_DIR . "component/package.presentation.class.php");

global $admin_info;
if ($admin_info == -1)
{
    if( $member_info != -1 ) {
        redirectPage ( RELA_DIR, "You dont have the permission to this page" );
    }
    header("location:".RELA_DIR."login.php");
    die();
}

$Package = new package_presentation();

switch ($_GET['action']) {
    case 'searchSalable':
        $Package->searchSalable($_GET);
        break;

  case 'searchBuyPackageForCompany':
        $Package->searchBuyPackageForCompany($_GET);
        break;

    case 'searchCompanyPackage':
        $Package->searchCompanyPackage($_GET);
        break;

    case 'buyPackage':
        checkPermissions('buyPackage','package');
        $Package->showAllCompanies();
        break;

    case 'buyPackageForCompany':
        checkPermissions('buyPackageForCompany','package');
        $Package->buyPackageForCompany($_GET['comp_id']);
        break;

    case 'showCompanyPackage':
        checkPermissions('showAllCompanyPackages','package');
        $Package->showAllCompanyPackages('');
        break;

    default:
        checkPermissions('showAllCompanyPackages','package');
        $Package->showAllCompanyPackages("");
        break;
}