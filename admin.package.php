<?php
include_once("server.inc.php");
include_once(ROOT_DIR . "common/db.inc.php");
include_once(ROOT_DIR . "common/init.inc.php");
include_once(ROOT_DIR . "common/func.inc.php");
include_once(ROOT_DIR . "component/db.inc.class.php");
include_once(ROOT_DIR . "component/admin.package.presentation.class.php");

global $admin_info;
if ($admin_info == -1) {
    if( $member_info != -1 ) {
        redirectPage ( RELA_DIR, "You dont have the permission to this page" );
    }
    header("location:".RELA_DIR."login.php");
    die();
}

$Package = new admin_package_presentation();

switch ($_GET['action'])
{
    case 'search':
        $Package->search($_GET);
        break;

    case 'searchPackage':
        $Package->searchPackage($_GET);
        break;

    case 'showPackage':
        checkPermissions('showAllPackages','admin.package');
        $Package->showAllPackages('');
        break;

    case 'showGroupPackage':
        checkPermissions('showAllGroupPackages','admin.package');
        $Package->showAllGroupPackages('');
        break;

    case 'calculate':
        checkPermissions('calculate','admin.package');
        $Package->calculate();
        break;

    case 'addGroupPackage':
        checkPermissions('addGroupPackage','admin.package');
        if(isset($_POST['action']) & $_POST['action']=='addGroupPackage')
        {
            $Package->addGroupPackage($_POST);
        }
        else
        {
            $Package->addGroupPackageForm('','');
        }
        break;

    case 'addPackage':
        checkPermissions('addPackage','admin.package');
        if(isset($_POST['action']) & $_POST['action']=='addGroupPackage')
        {
            $Package->addPackage($_POST);
        }
        else
        {
            $Package->addPackageForm('','');
        }
        break;

    case 'addPackageToCompany':
        checkPermissions('addPackageToCompany','admin.package');
        if(isset($_POST['action']) & $_POST['action']=='addPackageToCompany')
        {
            $Package->addPackageToCompany($_POST);
        }
        else
        {
            $Package->addPackageToCompanyForm('','');
        }
        break;

    case 'addGroupPackageToCompany':
        checkPermissions('addGroupPackageToCompany','admin.package');
        if(isset($_POST['action']) & $_POST['action']=='addGroupPackageToCompany')
        {
            $Package->addGroupPackageToCompany($_POST);
        }
        else
        {
            $Package->addGroupPackageToCompanyForm();
        }
        break;

    case 'removeGroupPackageFromCompany':
        checkPermissions('removeGroupPackageFromCompany','admin.package');
        if(isset($_POST['action']) & $_POST['action']=='removeGroupPackageFromCompany')
        {
            $Package->removeGroupPackageFromCompany($_POST);
        }
        else
        {
            $Package->removeGroupPackageFromCompanyForm();
        }
        break;

    case 'editGroupPackage':
        checkPermissions('editGroupPackage','admin.package');
        if(isset($_POST['action'])& $_POST['action']=='update')
        {
            $Package->editGroupPackage($_POST,'');
        }
        else
        {
            $Package->editGroupPackageForm($_GET['id'],'');
        }
        break;

    case 'editPackage':
        checkPermissions('editPackage','admin.package');
        if(isset($_POST['action'])& $_POST['action']=='update')
        {
            $Package->editPackage($_POST,'');
        }
        else
        {
            $Package->editPackageForm($_GET['id'],'');
        }
        break;


    case 'deleteGroupPackage':
        checkPermissions('deleteGroupPackage','admin.package');
        if(isset($_GET['id']))
        {
            $Package->deleteGroupPackage($_GET['id']);
        }
        break;

    case 'deletePackage':
        checkPermissions('deletePackage','admin.package');
        if(isset($_GET['id']))
        {
            $Package->deletePackage($_GET['id']);
        }
        break;

    case 'changeStatus':
        checkPermissions('changeStatus','admin.package');
        if(isset($_POST['active']) && isset($_POST['groupPackageID']))
        {
            $_POST['status']='Enable';
            $Package->changeStatus($_POST);
        }
        else if(isset($_POST['inactive']) && isset($_POST['groupPackageID']) )
        {
            $_POST['status']='Disable';
            $Package->changeStatus($_POST);
        }
        else
        {
            $Package->showAllGroupPackages("");
        }
        break;

    case 'changePackageStatus':
        checkPermissions('changePackageStatus','admin.package');
        if(isset($_POST['active']) && isset($_POST['ID']))
        {
            $_POST['status']='Enable';
            $Package->changePackageStatus($_POST);
        }
        else if(isset($_POST['inactive']) && isset($_POST['ID']) )
        {
            $_POST['status']='Disable';
            $Package->changePackageStatus($_POST);
        }
        else
        {
            $Package->showAllPackages("");
        }
        break;

    default:
        checkPermissions('showAllPackages','admin.package');
        $Package->showAllPackages("");
        break;
}


