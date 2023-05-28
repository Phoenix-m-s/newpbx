<?php
/**
 * Created by PhpStorm.
 * User: VeRJiL
 * Date: 4/5/2017
 * Time: 4:40 PM
 */

include_once ROOT_DIR . "component/announce/adminAnnounceModel.php";
include_once ROOT_DIR . "component/package_company/adminPackageCompanyModel.php";
include_once ROOT_DIR . "component/ivr/adminIVRModel.php";
include_once ROOT_DIR . "component/inbound/adminInboundModel.php";
include_once ROOT_DIR . "component/queue/adminQueueModel.php";
include_once ROOT_DIR . "component/upload/AdminUploadModel.php";
include_once ROOT_DIR . "component/sip/adminSIPModel.php";
include_once ROOT_DIR . "component/extension.model.php";
include_once ROOT_DIR . "common/init.inc.php";
include_once ROOT_DIR . "common/func.inc.php";

/**
 * @author VeRJiL
 * @version 0.0.1
 * @copyright 2017 The Imen Daba Parsian Co.
 */
class CheckDependency
{
    public $error;
    public $msg = [];


    /**
     * Check any Announce don't use the $DSTNumber.
     *
     * @var $DSTNumber
     * @var $subDSTID
     * @return true if there is no dependency
     * @return false and error and a message if there is any dependency
     */
    public function checkAnnounceDependency($DSTNumber, $subDSTID)
    {
        $announceDirty = AdminAnnounceModel::getAll()->getList();
        $announceClean = $announceDirty['export']['list'];

        foreach ($announceClean as $key => $value) {
            if ($value['dst_option_id'] == $DSTNumber and $value['dst_option_sub_id'] == $subDSTID) {
                $this->error++;
                $this->msg[] = "This announce has been used by <span style='font: italic bold 18px Georgia; color: red;'> " . $value['announce_name'] . " </span> Queue: First solve it";
                $result['result'] = -1;
                return $result;
            }
        }

        $result['result'] = 1;
        return $result;
    }

    /**
     * Check any IVR don't use the $DSTNumber.
     *
     * @var $DSTNumber
     * @var $subDSTID
     * @return true if there is no dependency
     * @return false and error and a message if there is any dependency
     */
    public function checkIVRDependency($DSTNumber, $subDSTID)
    {
        $sql =
            "SELECT *
         FROM tbl_ivr AS a
         INNER JOIN tbl_ivr_dst_menu AS b ON a.ivr_id = b.ivr_id";

        $IVRDirty = AdminIVRModel::query($sql)->getList();
        $IVRClean = $IVRDirty['export']['list'];

        foreach ($IVRClean as $key => $value) {
            if ($value['dst_option_id'] == $DSTNumber and $value['dst_option_sub_id'] == $subDSTID) {
                $this->error++;
                $this->msg[] = "This announce has been used by <span style='font: italic bold 18px Georgia; color: red;'> " . $value['ivr_name'] . " </span> Queue: First solve it";
                $result['result'] = -1;
                return $result;
            }
        }
        $result['result'] = 1;
        return $result;
    }

    /**
     * Check any Queue that does't use the $DSTNumber.
     *
     * @var $DSTNumber
     * @var $subDSTID
     * @return true if there is no dependency
     * @return false and error and a message if there is any dependency
     */
    public function checkQueueDependency($DSTNumber, $subDSTID)
    {
        $queueDirty = AdminQueueModel::getAll()->getList();
        $queueClean = $queueDirty['export']['list'];


        foreach ($queueClean as $key => $value) {
            if ($value['dst_option_id'] == $DSTNumber and $value['dst_option_sub_id'] == $subDSTID) {
                $this->error++;
                $this->msg[] = "This announce has been used by <span style='font: italic bold 18px Georgia; color: red;'> " . $value['queue_name'] . " </span> Queue: First solve it";
                $result['result'] = -1;
                return $result;
            }
        }

        $result['result'] = 1;
        return $result;
    }

    /**
     * Check any Inbound don't use the $DSTNumber.
     *
     * @var $DSTNumber
     * @var $subDSTID
     * @return true if there is no dependency
     * @return false and error and a message if there is any dependency
     */
    public function checkInboundDependency($DSTNumber, $subDSTID)
    {
        $inboundDirty = AdminInboundModel::getAll()->getList();
        $inboundClean = $inboundDirty['export']['list'];

        foreach ($inboundClean as $key => $value) {
            if ($value['dst_option_id'] == $DSTNumber and $value['dst_option_sub_id'] == $subDSTID) {
                $this->error++;
                $this->msg[] = "This announce has been used by <span style='font: italic bold 18px Georgia; color: red;'> " . $value['inbound_name'] . " </span> Queue: First solve it";
                $result['result'] = -1;
                return $result;
            }
        }

        $result['result'] = 1;
        return $result;
    }
}