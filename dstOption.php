<?php
include_once "server.inc.php";
include_once ROOT_DIR . "common/db.inc.php";
include_once ROOT_DIR . "common/init.inc.php";
include_once ROOT_DIR . "common/func.inc.php";
include_once ROOT_DIR . "component/db.inc.class.php";
include_once ROOT_DIR . "component/dstOption.presentation.class.php";
$dstOption = new dstOption_presentation();

switch ($_GET['action']) {
    case 'dstOption':
        $value = $_POST['DSTOption'];
        $dstOption->callOperation($value);
        break;
    case 'dstOptionCamp':
        $value = $_POST['DSTOption'];
        $dstOption->callOperationCamp($value);
        break;
    case 'dstOptionIvr':
        $value = $_POST['DSTOption'];
        $dstOption->callOption($value);
        break;
    case 'showDstOption':
        $dstOption->showAllDstOption('');
        break;
    case 'VMForward':
        $dstOption->VMForward($_POST);
        break;
    case 'VMDSTOption':
        $dstOption->VMDSTOption($_POST);
        break;
    default:
        $dstOption->showAllDstOption('');
        break;
}