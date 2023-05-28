<?php
include_once "server.inc.php";
include_once ROOT_DIR . "common/db.inc.php";
include_once ROOT_DIR . "common/init.inc.php";
include_once ROOT_DIR . "common/func.inc.php";
include_once ROOT_DIR . "component/db.inc.class.php";
include_once ROOT_DIR . "component/extension.presentation.class.php";
include_once ROOT_DIR . "component/timeCondition/mainTimeConditionController.php";
include_once ROOT_DIR . "component/upload/adminUploadController.php";
include_once ROOT_DIR . "component/voipConfig/adminVoipConfigController.php";
include_once ROOT_DIR . "services/ExtensionService.php";

//for api
/*$ExtensionService = new ExtensionService();
$ExtensionService->registerApiExtention($fields);
die();*/


//print_r_debug($_POST);
if ($admin_info == -1 and $member_info == -1) {
    redirectPage(RELA_DIR . "login.php");
    die();
}
//checkPermissions();

if ($member_info != -1) {
    if ($_GET['action'] == 'addExtension' or $_GET['action'] == 'deleteExtension') {
        redirectPage(RELA_DIR . "extension.php" , "It's not possible");
        die();
    }
}

$extension = new extension_presentation();
$voiceObj = new AdminUploadController();
$timeCondition = new adminMainTimeConditionController();
$voipConfig = new adminVoipConfigController();


switch ($_GET['action']) {

    //--------------------------------- FILL THE SUCCESS SELECT TAGS USING AJAX ---------------------------------//
    case 'extensionList':
        $timeCondition->extensionList($_POST);
        break;
    /*
    | -----------------------------------------------------------------------------------------------------------------
    | fill Forward Combo Box Using ajax in
    | the Success Time condition Section
    | -----------------------------------------------------------------------------------------------------------------
    */
    case 'TCForward' :
        $_POST['status'] = 'success';
        $timeCondition->timeConditionForwardSelectTag($_POST);
        break;
    /*
    | -----------------------------------------------------------------------------------------------------------------
    | display the success record voice page
    | -----------------------------------------------------------------------------------------------------------------
    */
    case 'TCDSTOption' :
        $_POST['status'] = 'success';
        $timeCondition->timeConditionDSTOptionSelectTag($_POST);
        break;
    //------------------------------- FAILED DIAL DESTINATION SECTION -------------------------------//
    case 'downloadExcel':

        $extension->excelExtension();
        break;

    /*
    | -----------------------------------------------------------------------------------------------------------------
    | fill Forward Combo Box Using ajax in
    | the Failed Time condition Section
    | -----------------------------------------------------------------------------------------------------------------
    */
    case 'FTCForward' :
        $_POST['status'] = 'failed';
        $timeCondition->timeConditionForwardSelectTag($_POST);
        break;
    /*
    | -----------------------------------------------------------------------------------------------------------------
    | fill DSTOption Combo Box Using ajax in
    | the Failed Time condition Section
    | -----------------------------------------------------------------------------------------------------------------
    */
    case 'FTCDSTOption' :
        $_POST['status'] = 'failed';
        $timeCondition->timeConditionDSTOptionSelectTag($_POST);
        break;
    //--------------------------------- SUBMIT TIME CONDITION ---------------------------------//

    case 'sendFormAjax':
        $_POST['Extension_ID'] = $_POST['id'];
        if ($_GET['status'] == 'extension') {
            $_SESSION['extensionForm'][$_POST['id']] = $_POST;
        } elseif ($_GET['status'] == 'TC') {
            $_SESSION['TCForm'][$_POST['id']] = $_POST;
        }
        unset($_POST);
        break;

    case 'showExtensions':
        checkPermissions('showAllExtensions', 'extension');
        $extension->showAllExtensions('', '', '');


        //$extension->getAllExtensionsApi();
        //$extension->addExtensionApi();
        break;

    case 'addExtension':
        checkPermissions('addExtension', 'extension');
        if (isset($_POST['action']) & $_POST['action'] == 'addExtension') {
            $extension->addExtension($_POST);
        } else {
            $extension->addExtensionForm($_GET['id'], '');
        }
        break;

    case 'deleteExtension':
       // checkPermissions('deleteExtensions', 'extension');
        if (isset($_GET['id'])) {
            $extension->deleteExtensions($_GET['id']);
        }
        break;

    case 'editExtension':
        checkPermissions('editExtension', 'extension');
        if (isset($_POST['action'])) {

            $_POST['id'] = $_GET['id'];
            $extension->editExtension($_POST, '');
        } else {
            if($member_info!=-1){
                $extension->editExtensionForm($member_info['extension_id'], '');
            }
            else{
                $extension->editExtensionForm($_GET['id'], '');
            }

        }
        break;


    case 'addNewExtensionTimeCondition':
        //checkPermissions('editNewExtension', 'extension');
        if (isset($_POST['action'])) {
            $extension->addNewExtensionTimeConditon($_POST, '');
        } else {

            $extension->addNewExtensionTimeConditonForm($_GET['id'], '');
        }
        break;

    case 'editNewExtensionTimeCondition':
        if (isset($_POST['action'])) {
            //            $_POST['id'] = $_GET['id'];
            $extension->editNewExtensionTimeCondition($_POST, '');
        } else {
            $extension->editNewExtensionTimeConditionForm($_GET['id'], '');
        }
        break;


    case 'showTimeCondition':
        //checkPermissions('editNewExtension', 'extension');
        if (isset($_POST['action'])) {
            $_POST['id'] = $_GET['id'];

            $extension->editNewExtensionTimeCondition($_POST, '');
        } else {

            $extension->showTimeConditionFrom($_GET['id'], '');
        }
        break;


    case 'deleteTimeCondition':
        //checkPermissions('deleteExtensions', 'extension');
        if (isset($_GET['id'])) {
            $extension->deleteTimeCondition($_GET['id']);
        }
        break;
    case 'voipConfig':
        $voipConfig->createFile($_POST);
        break;
    case 'download_sccp':
        $voipConfig->downloadSccp($_GET['mac']);
        break;
    case 'download':
        $voipConfig->download($_GET['name']);
        break;

    //--------------------------------- DIAL DESTINATION PART ---------------------------------//
    // fill the first select box in the left side of edit extension page using ajax (success)
    case 'dialDestination':
        $extension->dialDestination($_POST);
        break;

    // fill the second select box in the left side of edit extension page using ajax (success)
    case 'successForward':
        $_POST['status'] = 'success';
        $extension->forwardSelectTag($_POST);
        break;

    // fill the second select box in the right side of edit extension using ajax (failed)
    case 'failedForward':
        $_POST['status'] = 'failed';
        $extension->forwardSelectTag($_POST);
        break;
    //--------------------------------- TIME CONDITION PART ---------------------------------//
    //--------------------------------- SUBMIT THE DATA AND ADD OPERATION ---------------------------------//
    // handling all the operation in the success time condition page
    case 'successTimeCondition':
        if (isset($_POST['action'])) {
            $_POST['id'] = $_GET['id'];
            $extension->editSuccessTimeCondition($_POST, '');
        } elseif (isset($_POST['edit'])) {
            $_POST['status'] = 1;
            $extension->ValidateTimeArray($_POST);
        } else {
            $extension->showSuccessTimeConditionPage($_GET['id']);
        }
        break;

    // handling all the operation in the failed time condition page
    case 'failedTimeCondition':
        if (isset($_POST['action'])) {
            $_POST['id'] = $_GET['id'];
            $extension->editFailedTimeCondition($_POST, '');
        } elseif (isset($_POST['edit'])) {
            $_POST['status'] = 0;
            $extension->ValidateTimeArray($_POST);
        } else {
            $extension->showFailedTimeConditionPage($_GET['id']);
        }
        break;

    //--------------------------------- FILL THE FAILED SELECT TAGS USING AJAX ---------------------------------//
    //fill Forward Combo Box Using ajax in the Failed Time condition Section
    case 'failedTCForward':
        $_POST['status'] = 'success';
        $extension->TCForwardSelectTag($_POST);
        break;

    //fill DSTOption Combo Box Using ajax in the Failed Time condition Section
    case 'failedTCDSTOption':
        $_POST['status'] = 'success';
        $extension->DSTOptionSelectTag($_POST);
        break;

    //display the failed record voice page
    case 'failedTCRecordVoice':
        $list['status'] = 2;
        $list['id'] = $_GET['id'];
        $list['TCID'] = $_GET['TCID'];
        $extension->failedTCRecordVoice($list);
        break;

    //--------------------------------- FILL THE SUCCESS SELECT TAGS USING AJAX ---------------------------------//
    //fill Forward Combo Box Using ajax in the Success Time condition Section
    case 'successTCForward':
        $_POST['status'] = 'success';
        $extension->TCForwardSelectTag($_POST);
        break;


    //display the timeCondition

    //display the success record voice page
    case 'successTCDSTOption':
        $_POST['status'] = 'success';
        $extension->DSTOptionSelectTag($_POST);
        break;

    //related to extension success voice record save
    case 'successTCRecordVoice':
        $list['status'] = 3;
        $list['id'] = $_GET['id'];
        $list['TCID'] = $_GET['TCID'];
        $extension->successTCRecordVoice($list);
        break;

    //------------------------------- FAILED DIAL DESTINATION SECTION -------------------------------//
    //fill Forward Combo Box Using ajax in the Failed Time condition Section
    case 'FTCForward':
        $_POST['status'] = 'failed';
        $extension->TCForwardSelectTag($_POST);
        break;


    //fill DSTOption Combo Box Using ajax in the Failed Time condition Section
    case 'FTCDSTOption':
        $_POST['status'] = 'failed';
        $extension->DSTOptionSelectTag($_POST);
        break;

    //--------------------------------- RECORDING VOICE ---------------------------------//
    case 'saveVoice':
        $_FILES['status'] = $_GET['status'];
        $_FILES['extension_id'] = $_GET['extension_id'];
        $_FILES['voiceTitle'] = $_GET['voiceTitle'];

        $voiceObj->saveVoice($_FILES);
        break;

    default:
        $extension->showAllExtensions('', '', '');
        break;
}// End of Switch for $admin_info
//}// End of if for $admin_info

