<?php

include_once "server.inc.php";
include_once ROOT_DIR . "common/db.inc.php";
include_once ROOT_DIR . "common/init.inc.php";
include_once ROOT_DIR . "common/func.inc.php";
include_once ROOT_DIR . "component/db.inc.class.php";
include_once ROOT_DIR . "component/timeCondition/mainTimeConditionController.php";
include_once ROOT_DIR . "component/upload/adminUploadController.php";

global $admin_info;

if ($admin_info == -1) {
    redirectPage(RELA_DIR . "login.php");
    die();
}

$timeCondition = new adminMainTimeConditionController();
$voiceObj = new AdminUploadController();


if ($admin_info != -1) {
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

        case 'addTimeCondition' :
            if (isset($_POST['action'])) {

                $timeCondition->addTimeCondition($_POST, '');
                $_POST['status'] = 1;
                $timeCondition->ValidateTimeArray($_POST);
            }
            //elseif (isset( $_POST['edit'])) {
                //$_POST['status'] = 1;
                //$timeCondition->ValidateTimeArray($_POST);

            //}
             else {
                $timeCondition->showTimeConditionAddForm();
            }
            break;

        case 'editTimeCondition' :
            if (isset($_POST['action'])) {
                $_POST['timeConditionID'] = $_GET['id'];

                $timeCondition->editTimeCondition($_POST);
            } elseif (isset($_POST['plus'])) {
                $_POST['status'] = 0;
                $timeCondition->ValidateTimeArray($_POST);
            } else {
                $timeCondition->showTimeConditionEditForm($_GET['id']);
            }
            break;

        case 'deleteTimeCondition' :
            $timeCondition->deleteTimeCondition($_GET['id']);
            break;
//--------------------------------- RECORDING VOICE AND PLAY ---------------------------------//

        case 'saveVoice':
            $_FILES['status'] = $_GET['status'];
            $_FILES['voiceTitle'] = $_GET['voiceTitle'];
            $voiceObj->saveVoice($_FILES);
            break;

        default:
            $timeCondition->showTimeConditionPage();
            break;

    }
}

