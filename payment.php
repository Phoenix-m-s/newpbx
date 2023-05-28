<?php
include_once("server.inc.php");
include_once(ROOT_DIR . "common/db.inc.php");
include_once(ROOT_DIR . "common/init.inc.php");
include_once(ROOT_DIR . "common/func.inc.php");
include_once(ROOT_DIR . "component/db.inc.class.php");
include_once(ROOT_DIR . "component/payment.class.php");

global $admin_info;
if ($admin_info == -1)
{
    if( $member_info != -1 ) {
        redirectPage ( RELA_DIR, "You dont have the permission to this page" );
    }
    header("location:".RELA_DIR."login.php");
    die();
}

$Payment = new payment();

switch ($_GET['action'])
{

    case 'onlinePayment':
        $Payment->onlinePayment($_GET['InvoiceID']);
        break;

    case 'returnBank':

        $result = $Payment->checkResNumber($_POST);

        if ($result['result'] == -1)
        {
            return $result['msg'];
        }
        else
        {
            $Payment->updatePaymentStatus($_POST);

            $verify = $Payment->verifyTrans();

            $Payment->errorCheck($verify);

        }

        break;

    default:
        $Payment->showInvoice("");
        break;


}
