<?php
error_reporting(0);
error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED ^ E_STRICT);
    ini_set('display_errors',0);

//ado for admin class

$db = dbConn::getConnection();

$db->exec('SET character_set_database=UTF8');
$db->exec('SET character_set_client=UTF8');
$db->exec('SET character_set_connection=UTF8');
$db->exec('SET character_set_results=UTF8');
$db->exec('SET character_set_server=UTF8');
$db->exec('SET names UTF8');


/*** The SQL SELECT statement ***/
$sql = "SELECT * FROM web_config";
/*** fetch into an PDOStatement object ***/
$stmt = $db->query($sql);

/*** echo number of columns ***/
$obj = $stmt->fetchAll(PDO::FETCH_OBJ);
foreach( $obj as $v )
{

    if ( strtoupper($v->config) == "TITLE" )
    {
        define(strtoupper($v->config), ucwords(strtolower($v->value)) );
    }
    else
    {
        define(strtoupper($v->config), $v->value);
    }
}

if(isset($_REQUEST['lang']))
{
    $_SESSION['lang'] = $_REQUEST['lang'];
    //$_REQUEST['currency']==$_SESSION['currency'];
}

if($_SESSION['lang'] == "" || !isset($_SESSION['lang']) || $_SESSION['lang']!='en')
{
    $_SESSION['lang'] = WEBSITE_LANGUAGE;
}

$lang = $_SESSION['lang'];

define('CURRENT_SKIN',"template_".$lang);
define('TEMPLATE_DIR',RELA_DIR."templates/".CURRENT_SKIN."/");
define('Count_Permission','20');
//include(ROOT_DIR . "resource/language_fa.inc.php");
include(ROOT_DIR . "resource/language_".$lang.".inc.php");
include(ROOT_DIR . "common/message_stack.php");

global $messageStack;
$messageStack = new messageStack();
$messageStack->loadFromSession();

include_once( ROOT_DIR . "component/admin.class.php" );
include_once( ROOT_DIR . "component/login/extension.member.login.controller.php" );

global $admin_info,$member_info,$company_info;
$admin = new admin();
$member=new adminLoginController();
getCompanyBySubDomain();

$jwt_info=array();

$admin_info = $admin->checkLogin();
$member_info = $member->checkLogin();

function __autoload($name)
{
    $modelFileName = ROOT_DIR . 'component/' . $name . '.class.php';
    $adminModelFileName = ROOT_DIR . 'component/admin.' . $name . '.class.php';

    if (file_exists($modelFileName)) {
        require_once($modelFileName);
    } elseif (file_exists($adminModelFileName)) {
        require_once($adminModelFileName);
    }
}


function getCompanyBySubDomain()
{
    global $company_info,$admin_info;
    $Domain = $_SERVER['SERVER_NAME'];
    $DomainList = explode('.', $Domain);
    if (count($DomainList) > 1)
    {
        $company_name=$DomainList['0'];
        $conn = dbConn::getConnection();
        // echo '<pre/>';

        ///////////
        //print_r($_SESSION);
        //$_GET['s_temp']='X1lZZA==';
        //print_r($_SESSION);
        // die();

        if($DomainList[0] == 'payment') {

            //echo '<pre/>';
            //print_r($_POST);
            include_once(ROOT_DIR . "component/Validators.class.php");
            if (Validator::required($_POST['comp_name']))
            {

                $company_name = $_POST['comp_name'];

            }
            else if(isset($_SESSION['sessionID']))
            {

                //$_SESSION['sessionID']


                $admin = new admin();
                $company_result=$admin->getCompanyBysessionID($_SESSION['sessionID']);
                //print_r($company_result);

            }

            if(Validator::required($_POST['s_temp']))
            {

                $_SESSION["sessionID"] = $_POST['s_temp'];//$_sessionID kasi ke logine
            }
        }
        ////////////
        /*if($company_name=='payment')
        {
            $company_name='a';
            $_SESSION[sessionID] = 'X1lZYg==';

        }*/


        $sql = "SELECT * FROM tbl_company WHERE  comp_name= '$company_name' " ;

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if (!$stmt)
        {
            $result['result'] = -1;
            $result['Number'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }
        if ($stmt->rowCount())
        {
            $company_info= $stmt->fetch();
        }else
        {
            $company_info=-1;
        }

    }

}

?>
