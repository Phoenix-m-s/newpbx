<?php
include_once("server.inc.php");
include_once(ROOT_DIR . "common/db.inc.php");
include_once(ROOT_DIR . "common/init.inc.php");
include_once(ROOT_DIR . "common/func.inc.php");
include_once(ROOT_DIR . "component/db.inc.class.php");
include_once(ROOT_DIR . "component/basket.presentation.class.php");

global $admin_info;
if ($admin_info == -1) {
    if( $member_info != -1 ) {
        redirectPage ( RELA_DIR, "You dont have the permission to this page" );
    }
    header("location:".RELA_DIR."login.php");
    die();
}

$Basket = new basket_presentation();

switch ($_GET['action'])
{
    case 'search':

    case 'showBasket':
        $Basket->showBasket('');
        break;

    case 'addToBasket':
        $Basket->addToBasket($_GET);
        break;

    case 'deleteBasket':
        if(isset($_GET['basket_id'])){
            $Basket->deleteBasket($_GET['basket_id']);
        }
        break;

    case 'sendInvoice':
        $Basket->sendInvoice();
        break;


    default:
        $Basket->showBasket("");
        break;


}
