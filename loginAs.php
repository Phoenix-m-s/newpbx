<?php
include_once("server.inc.php");
include_once(ROOT_DIR . "common/db.inc.php");
include_once(ROOT_DIR . "common/init.inc.php");
include_once(ROOT_DIR . "common/func.inc.php");
include_once(ROOT_DIR . "component/db.inc.class.php");
include_once(ROOT_DIR . "component/loginAs.presentation.class.php");

global $admin_info,$company_info;


if($_GET['action']=='loginas')
{

    include_once(ROOT_DIR . "component/admin.class.php");
    
    $admin = new admin();
    $admin->loginas($_GET);
}

if ($admin_info == -1)
{
    header("location:".RELA_DIR."login.php");
    die();
}

$LoginAs = new loginAs_presentation();

switch ( $_GET[ 'action' ] )
{
    case 'return':
        if( $admin_info[ 'loginAs' ] != '' )
        {
            $fields[ 'CompID' ]=$admin_info[ 'comp_id' ];
            $LoginAs->LoginAs($fields);
        }
        break;
    
    default:
        if(isset($_POST['action']) & $_POST['action']=='LoginAs')
        {
            $LoginAs->LoginAs($_POST);
        }
        else
        {
            $LoginAs->LoginAsForm();
        }
        break;
}
