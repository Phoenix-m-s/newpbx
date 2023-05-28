<?php
include_once("server.inc.php");
include_once(ROOT_DIR . "common/db.inc.php");
include_once(ROOT_DIR . "common/init.inc.php");
include_once(ROOT_DIR . "common/func.inc.php");
include_once(ROOT_DIR . "component/db.inc.class.php");
include_once(ROOT_DIR . "component/company.presentation.class.php");



global $admin_info,$company_info;

if ($admin_info == -1) {
    if( $member_info != -1 ) {
        redirectPage ( RELA_DIR, "You dont have the permission to this page" );
    }
    header("location:".RELA_DIR."login.php");
    die();
}

$Company = new Company_presentation();

switch ($_GET['action'])
{
    case 'search':
        $Company->search($_GET);
        break;

    case 'searchGroupCompany':
        $Company->searchGroupCompany($_GET);
        break;

    case 'searchMember':
        $Company->searchMember($_GET);
        break;

    case 'showCompanies':
        //checkPermissions('showAllCompany','company');
        $Company->showAllCompany('');
        break;

    case 'addCompany':
        //checkPermissions('addCompany','company');
        if (isset($_POST['action']) & $_POST['action'] == 'addCompany')
        {
            $Company->addCompany($_POST);
        }
        else
        {
            $Company->addCompanyForm('', '');
        }
        break;


    case 'showCompanyGroups':
        //checkPermissions('showAllCompanyGroup','company');
        $Company->showAllCompanyGroup('');
        break;

    case 'addCompanyGroup':
        //checkPermissions('addCompanyGroup','company');
        if(isset($_POST['action']) & $_POST['action']=='addCompanyGroup')
        {
            $Company->addCompanyGroup($_POST);
        }
        else
        {
            $Company->addCompanyGroupForm('','');
        }
        break;

    case 'editCompany':
        //checkPermissions('editCompany','company');
        if(isset($_POST['action'])& $_POST['action']=='update')
        {
            $Company->editCompany($_POST,'');
        }
        else
        {
            $Company->editCompanyForm($_GET['id'],'');
        }
        break;

    case 'editCompanyGroup':
        //checkPermissions('editCompanyGroup','company');
        if(isset($_POST['action'])& $_POST['action']=='update')
        {
            $Company->editCompanyGroup($_POST,'');
        }
        else
        {
            $Company->editCompanyGroupForm($_GET['id'],'');
        }
        break;

    case 'AddCompanyToGroup':
        //checkPermissions('AddCompanyToGroup','company');
        if(isset($_POST['action'])& $_POST['action']=='addCompany')
        {
            $Company->addCompanyToGroup($_POST);
        }
        else
        {
            $Company->addCompanyToGroupForm($_GET['id'],'');
        }
        break;

    case 'ShowCompanyGroupMembers':
        //checkPermissions('ShowCompanyGroupMembers','company');
        $Company->showCompanyGroupMembers($_GET['id']);
        break;

    case 'deleteCompany':
        checkPermissions('deleteCompany','company');

        if(isset($_GET['id']))
        {
            $Company->deleteCompanies($_GET['id']);
        }
        break;

    case 'RemoveCompanyFromGroup':
        //checkPermissions('deleteCompanyFromGroup','company');
        if(isset($_GET['group_id']) && isset($_GET['comp_id']))
        {
            $Company->deleteCompanyFromGroup($_GET['group_id'],$_GET['comp_id']);
        }
        break;

    case 'changeStatus':
        //checkPermissions('changeStatus','company');
        if(isset($_POST['active']) && isset($_POST['compID']))
        {
            $_POST['status']='Enable';
            $Company->changeStatus($_POST);
        }
        else if(isset($_POST['inactive']) && isset($_POST['compID']) )
        {
            $_POST['status']='Disable';
            $Company->changeStatus($_POST);
        }
        else{
            $Company->showAllCompany("");
        }
        break;

    case 'changeGroupStatus':
        //checkPermissions('changeGroupStatus','company');
        if(isset($_POST['active']) && isset($_POST['compGroupID']))
        {

            $_POST['status']='Enable';
            $Company->changeGroupStatus($_POST);
        }
        else if(isset($_POST['inactive']) && isset($_POST['compGroupID']) )
        {
            $_POST['status']='Disable';
            $Company->changeGroupStatus($_POST);
        }
        else{
            $Company->showAllCompanyGroup("");
        }
        break;

    case 'trashCompany':
        checkPermissions('deleteCompany','company');

        if(isset($_GET['id']))
        {
            $Company->trashCompanies($_GET['id']);
        }
        break;

    case 'recycleCompany':
        checkPermissions('recycleCompanies','company');
        if(isset($_GET['id']))
        {
            $Company->recycleCompanies($_GET['id']);
        }
        break;

    default:
        checkPermissions('showAllCompany','company');
        $Company->showAllCompany("");
        break;
}
