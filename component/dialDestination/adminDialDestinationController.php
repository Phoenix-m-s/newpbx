<?php
/**
 * Created by PhpStorm.
 * User: VeRJiL
 * Date: 3/15/2017
 * Time: 11:58 AM
 */

include ROOT_DIR . "voiceMail/adminVoiceMailModel.php";

class AdminDialDestinationController {

    public function directDial($forward, $dstOption, $subDst = '')
    {
        include ROOT_DIR . "templates/" . CURRENT_SKIN . "/directDial.php";
    }

    public function voiceMail($name, $class)
    {
        include ROOT_DIR . "templates/" . CURRENT_SKIN . "/voiceMail.php";
    }

    public function activeExtension($extensionList, $name)
    {
        include ROOT_DIR . "templates/" . CURRENT_SKIN . "/activeExtension.php";
    }

    public function forward($name, $forward, $subDst = '')
    {
        include ROOT_DIR . "templates/" . CURRENT_SKIN . "/forward.php";
    }
    public function extension($extensionListClean, $forward, $subDst = '')
    {
        include ROOT_DIR . "templates/" . CURRENT_SKIN . "/extension.php";
    }

    public function IVR($IVRListClean, $forward, $class, $dstOption, $subDst = '')
    {
        include ROOT_DIR . "templates/" . CURRENT_SKIN . "/IVR.php";
    }

    public function queue($queueListClean, $forward, $class, $dstOption, $subDst = '')
    {
        include ROOT_DIR . "templates/" . CURRENT_SKIN . "/queue.php";
    }

    public function announce($announceListClean, $forward, $class, $dstOption, $subDst = '')
    {
        include ROOT_DIR . "templates/" . CURRENT_SKIN . "/announce.php";
    }

    public function hangUp($forward, $dstOption, $subDst = '')
    {
        include ROOT_DIR . "templates/" . CURRENT_SKIN . "/hangUp.php";
    }

    public function fax($forward, $dstOption, $subDst = '')
    {
        include ROOT_DIR . "templates/" . CURRENT_SKIN . "/fax.php";
    }

    public function defaultMessage($name)
    {
        include ROOT_DIR . "templates/" . CURRENT_SKIN . "/defaultMessage.php";
    }

    public function withOutMessage($name)
    {
        include ROOT_DIR . "templates/" . CURRENT_SKIN . "/withOutMessage.php";
    }

    public function customMessageByList($voiceClean, $name)
    {
        include ROOT_DIR . "templates/" . CURRENT_SKIN . "/customMessageByList.php";
    }

    public function customMessageByRecord($recordId, $status)
    {
        include ROOT_DIR . "templates/" . CURRENT_SKIN . "/customMessageByRecord.php";
    }

    public function internal($extensionClean, $name)
    {
        include ROOT_DIR . "templates/" . CURRENT_SKIN . "/internal.php";
    }

    public function external($name)
    {
        include ROOT_DIR . "templates/" . CURRENT_SKIN . "/external.php";
    }

    public function timeCondition($extensionClean,$forward, $class, $dstOption, $subDst = '')
    {
        include ROOT_DIR . "templates/" . CURRENT_SKIN . "/dialDestinationTimeCondition.php";
    }

}
