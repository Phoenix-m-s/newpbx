<?php
include_once ROOT_DIR . "component/dstOption.operation.class.php";
include_once ROOT_DIR . "component/dialDestination/adminDialDestinationController.php";
include_once ROOT_DIR . "component/queue/adminQueueModel.php";
include_once ROOT_DIR . "component/upload/AdminUploadModel.php";
include_once ROOT_DIR . "component/ivr/adminIVRModel.php";
include_once ROOT_DIR . "component/announce/adminAnnounceModel.php";
include_once ROOT_DIR . "component/sip/adminSIPModel.php";
include_once ROOT_DIR . "component/upload/adminUploadController.php";
include_once ROOT_DIR . "component/timeCondition/mainTimeConditionModel.php";
include_once ROOT_DIR . "component/extension.model.php";

/**
 * @author Malekloo,Izadi,Sakhamanesh <Izadi@dabacenter.ir>
 * @version 0.0.1 this is the beta version of News
 * @copyright 2015 The Imen Daba Parsian Co.
 */
class dstOption_presentation
{
    /**
     * Contains file type
     * @var
     */
    public $exportType;

    /**
     * Contains file name
     * @var
     */
    public $fileName;

    /**
     * Specifies the type of output
     * @param $list
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    function template($list = '', $msg)
    {
        if ($this->exportType == 'html') {
            include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_start.tpl");
            include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_header.tpl");
            include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_rightMenu.tpl.php");
            include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/$this->fileName");
            include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_footer.tpl");
            include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_end.tpl");
        }

    }

    /**
     * Shows the detail of each company based on its ID
     * @param $id
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    function showAllDstOptionDetail($id)
    {
        global $conn, $lang;
        $operation = new news_operation();
        $news_result = $operation->getNewsListById($id);
        $this->exportType = 'html';
        $this->fileName = 'newsdetail.tpl';
        $this->template($operation->newsList);
        die();
    }

    /**
     * Show All DstOption
     * @param  $msg
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    function showAllDstOption($msg)
    {
        global $conn, $lang;
        $operation = new dstOption_operation();
        $result = $operation->getDstOptionList();

        if ($result['result'] != 1) {
            return $result['msg'];
        }

        $this->exportType = 'html';
        $this->fileName = 'dstOption.show.php';
        $list = $operation->dstOptionList;
        $this->template($list, $msg);
        die();
    }

    /**
     * Shows all the callOperation
     * @return  mixed
     * @param   $value
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function callOperation($value)
    {
        /*
        |--------------------------------------------------------------------------
        | Available Telephone system (DSTOption)
        | --------------------------------------------------------------------------
        | --------------Voice Mail=6--------------
        | ------------Extension=3------------
        | ----------Announce=4----------
        | --------Hang Up=7--------
        | ------Queue=2------
        | ----IVR=5----
        */

        switch ($value) {
            case 1:
                $sipDirty = AdminSIPModel::getAll()->getList();
                foreach ($sipDirty['export']['list'] as $key => $value) {
                    $list['sipList'][$value['sip_id']] = $value['sip_name'];
                }
                ?>
                <select name="dst_option_sub_id" class="valid select2" id="dst_option_sub_id" required>
                    <?php foreach ($list['sipList'] as $key => $val) { ?>
                        <option value="<?= $key ?>"><?= $val ?> </option>
                    <?php } ?>
                </select>
                <input type="hidden" value="" name="forward">
                <input type="hidden" value="" name="DSTOption">
                <?php
                break;

            case 2:
                $queueDirty = AdminQueueModel::getAll()->getList();
                foreach ($queueDirty['export']['list'] as $key => $value) {
                    $list['queueList'][$value['queue_id']] = $value['queue_name'];
                }
                ?>

                <select name="dst_option_sub_id" class="valid select2" id="dst_option_sub_id" required>
                    <?php foreach ($list['queueList'] as $key => $val) { ?>
                        <option value="<?= $key ?>"><?= $val ?> </option>
                    <?php } ?>
                </select>
                <input type="hidden" value="" name="forward">
                <input type="hidden" value="" name="DSTOption">
                <?php
                break;

            case 3:
                $extensionDirty = AdminExtensionModel::getAll()->getList();
                foreach ($extensionDirty['export']['list'] as $key => $value) {
                    $list['extensionList'][$value['extension_id']] = $value['extension_name'];
                }
                ?>
                <select name="dst_option_sub_id" class="valid select2" id="dst_option_sub_id" required>
                    <?php foreach ($list['extensionList'] as $key => $val) { ?>
                        <option value="<?= $key ?>"><?= $val ?> </option>
                    <?php } ?>
                </select>
                <input type="hidden" value="" name="forward">
                <input type="hidden" value="" name="DSTOption">
                <?php
                break;

            case 4:
                $announceDirty = AdminAnnounceModel::getAll()->getList();
                foreach ($announceDirty['export']['list'] as $key => $value) {
                    $list['announceList'][$value['announce_id']] = $value['announce_name'];
                }
                ?>
                <select name="dst_option_sub_id" class="valid select2" id="dst_option_sub_id" required>
                    <?php foreach ($list['announceList'] as $key => $val) { ?>
                        <option value="<?= $key ?>"><?= $val ?> </option>
                    <?php } ?>
                </select>
                <input type="hidden" value="" name="forward">
                <input type="hidden" value="" name="DSTOption">
                <?php
                break;

            case 5:
                $ivrDirty = AdminIVRModel::getAll()->getList();
                foreach ($ivrDirty['export']['list'] as $key => $value) {
                    $list['ivrList'][$value['ivr_id']] = $value['ivr_name'];
                }
                ?>
                <select name="dst_option_sub_id" class="valid select2" id="dst_option_sub_id" required>
                    <?php foreach ($list['ivrList'] as $key => $val) { ?>
                        <option value="<?= $key ?>"><?= $val ?> </option>
                    <?php } ?>
                </select>
                <input type="hidden" value="" name="forward">
                <input type="hidden" value="" name="DSTOption">
                <?php
                break;

            case 6:
                $extensionDirty = AdminExtensionModel::getBy_voicemail_status(1)->getList();
                foreach ($extensionDirty['export']['list'] as $key => $value) {
                    $list['extensionList'][$value['extension_id']] = $value['extension_no'];
                }
                ?>
                <select name="dst_option_sub_id" class="valid select2" id="dst_option_sub_id" required>
                    <?php foreach ($list['extensionList'] as $key => $val) { ?>
                        <option value="<?= $key ?>"><?= $val ?> </option>
                    <?php } ?>
                </select>
                <?php
                break;

            case 8:
                $timeConditionDirty = AdminMainTimeConditionModel::getAll()->getList();
                foreach ($timeConditionDirty['export']['list'] as $key => $value) {
                    $list['timeConditionList'][$value['id']] = $value['name'];
                }
                ?>
                <select name="dst_option_sub_id" class="valid select2" id="dst_option_sub_id" required>
                    <?php foreach ($list['timeConditionList'] as $key => $val) { ?>
                        <option value="<?= $key ?>"><?= $val ?> </option>
                    <?php } ?>
                </select>
                <input type="hidden" value="" name="forward">
                <input type="hidden" value="" name="DSTOption">
                <?php
                break;

            case 100:
                ?>
                <input type="text" class="form-control ltr" name="dst_option_sub_id" value=""
                        id="dst_option_sub_id" autocomplete="off" placeholder="email">
                <input type="hidden" value="" name="forward">
                <input type="hidden" value="" name="DSTOption">
                <?php
                break;
        }
    }

    /**
     * Shows all the callOperation
     * @return  mixed
     * @param   $value
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function callOperationCamp($value)
    {
        /*
        |--------------------------------------------------------------------------
        | Available Telephone system (DSTOption)
        | --------------------------------------------------------------------------
        | --------------Voice Mail=6--------------
        | ------------Extension=3------------
        | ----------Announce=4----------
        | --------Hang Up=7--------
        | ------Queue=2------
        | ----IVR=5----
        */
        switch ($value) {
            case 1:
                $sipDirty = AdminSIPModel::getAll()->getList();
                foreach ($sipDirty['export']['list'] as $key => $value) {
                    $list['sipList'][$value['sip_id']] = $value['sip_no'];
                }
                ?>
                <select name="extensionNumber" class="valid" id="extensionNumber" required>
                    <?php foreach ($list['sipList'] as $key => $val) { ?>
                        <option value="<?= $key ?>" <?= ($list['sip_id'] == $key) ? 'selected' : '' ?>><?= $val['sip_name'] ?></option>
                    <?php } ?>
                </select>
                <input type="hidden" value="" name="forward">
                <input type="hidden" value="" name="DSTOption">
                <?php
                break;

            case 2:
                $queueDirty = AdminQueueModel::getAll()->getList();
                foreach ($queueDirty['export']['list'] as $key => $value) {
                    $list['queueList'][$value['queue_id']] = $value['queue_no'];
                }
                ?>
                <select name="extensionNumber" class="valid" id="extensionNumber" required>
                    <?php foreach ($list['queueList'] as $key => $val) { ?>
                        <option value="<?= $key ?>" <?= ($list['queue_id'] == $key) ? 'selected' : '' ?>><?= $val['queue_name'] ?> </option>
                    <?php } ?>
                </select>
                <input type="hidden" value="" name="forward">
                <input type="hidden" value="" name="DSTOption">
                <?php
                break;

            case 3:
                $extensionDirty = AdminExtensionModel::getAll()->getList();
                foreach ($extensionDirty['export']['list'] as $key => $value) {
                    $list['extensionList'][$value['extension_id']] = $value['extension_no'];
                }
                ?>
                <select name="extensionNumber" class="valid" id="extensionNumber" required>
                    <?php foreach ($list['extensionList'] as $key => $val) { ?>
                        <option value="<?= $key ?>" <?= ($list['extension_id'] == $key) ? 'selected' : '' ?>><?= $val['extension_name'] ?> </option>
                    <?php } ?>
                </select>
                <input type="hidden" value="" name="forward">
                <input type="hidden" value="" name="DSTOption">
                <?php
                break;

            case 4:
                $announceDirty = AdminAnnounceModel::getAll()->getList();
                foreach ($announceDirty['export']['list'] as $key => $value) {
                    $list['announceList'][$value['announce_id']] = $value['announce_no'];
                }
                ?>
                <select name="extensionNumber" class="valid" id="extensionNumber" required>
                    <?php foreach ($list['announceList'] as $key => $val) { ?>
                        <option value="<?= $key ?>" <?= ($list['announce_id'] == $key) ? 'selected' : '' ?>><?= $val['announce_name'] ?> </option>
                    <?php } ?>
                </select>
                <input type="hidden" value="" name="forward">
                <input type="hidden" value="" name="DSTOption">
                <?php
                break;

            case 5:
                $ivrDirty = AdminIVRModel::getAll()->getList();
                foreach ($ivrDirty['export']['list'] as $key => $value) {
                    $list['ivrList'][$value['ivr_id']] = $value['ivr_no'];
                }
                ?>
                <select name="extensionNumber" class="valid" id="extensionNumber" required>
                    <?php foreach ($list['ivrList'] as $key => $val) { ?>
                        <option value="<?= $key ?>" <?= ($list['ivr_id'] == $key) ? 'selected' : '' ?>><?= $val['ivr_name'] ?></option>
                    <?php } ?>
                </select>
                <input type="hidden" value="" name="forward">
                <input type="hidden" value="" name="DSTOption">
                <?php
                break;

            case 6:
                $extensionDirty = AdminExtensionModel::getBy_voicemail_status(1)->getList();
                foreach ($extensionDirty['export']['list'] as $key => $value) {
                    $list['extensionList'][$value['extension_id']] = $value['extension_no'];
                }
                ?>
                <select name="extensionNumber" class="valid" id="extensionNumber" required>
                    <?php foreach ($list['extensionList'] as $key => $val) { ?>
                        <option value="<?= $key ?>" <?= ($list['extension_id'] == $key) ? 'selected' : '' ?>><?= $val['extension_no'] ?> </option>
                    <?php } ?>
                </select>
                <input type="hidden" value="" name="forward">
                <input type="hidden" value="" name="DSTOption">
                <?php
                break;

        }
    }

    /**
     * Shows all the callOperation
     * @return  mixed
     * @param   $value
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function callOption($value)
    {
        /*
        |--------------------------------------------------------------------------
        | Available Telephone system (DSTOption)
        | --------------------------------------------------------------------------
        | --------------Voice Mail=6--------------
        | ------------Extension=3------------
        | ----------Announce=4----------
        | --------Hang Up=7--------
        | ------Queue=2------
        | ----IVR=5----
        */
        switch ($value) {
            case 1:
                $sipDirty = AdminSIPModel::getAll()->getList();
                foreach ($sipDirty['export']['list'] as $key => $value) {
                    $list['sipList'][$value['sip_id']] = $value['sip_name'];
                }
                ?>
                <select name="dst_option_sub_id[]" class="valid" id="dst_option_sub_id" required>
                    <?php foreach ($list['sipList'] as $key => $val) { ?>
                        <option value="<?= $key ?>"><?= $val ?></option>
                    <?php } ?>
                </select>
                <input type="hidden" value="" name="forward[]">
                <input type="hidden" value="" name="DSTOption[]">
                <?php
                break;

            case 2:
                $queueDirty = AdminQueueModel::getAll()->getList();
                foreach ($queueDirty['export']['list'] as $key => $value) {
                    $list['queueList'][$value['queue_id']] = $value['queue_name'];
                }
                ?>
                <select name="dst_option_sub_id[]" class="valid" id="dst_option_sub_id" required>
                    <?php foreach ($list['queueList'] as $key => $val) { ?>
                        <option value="<?= $key ?>"><?= $val ?></option>
                    <?php } ?>
                </select>
                <input type="hidden" value="" name="forward[]">
                <input type="hidden" value="" name="DSTOption[]">
                <?php
                break;

            case 3:
                $extensionDirty = AdminExtensionModel::getAll()->getList();
                foreach ($extensionDirty['export']['list'] as $key => $value) {
                    $list['extensionList'][$value['extension_id']] = $value['extension_name'];
                }
                ?>
                <select name="dst_option_sub_id[]" class="valid" id="dst_option_sub_id" required>
                    <?php foreach ($list['extensionList'] as $key => $val) { ?>
                        <option value="<?= $key ?>"><?= $val ?></option>
                    <?php } ?>
                </select>
                <input type="hidden" value="" name="forward[]">
                <input type="hidden" value="" name="DSTOption[]">
                <?php
                break;

            case 4:
                $announceDirty = AdminAnnounceModel::getAll()->getList();
                foreach ($announceDirty['export']['list'] as $key => $value) {
                    $list['announceList'][$value['announce_id']] = $value['announce_name'];
                }
                ?>
                <select name="dst_option_sub_id[]" class="valid" id="dst_option_sub_id" required>
                    <?php foreach ($list['announceList'] as $key => $val) { ?>
                        <option value="<?= $key ?>"><?= $val ?> </option>
                    <?php } ?>
                </select>
                <input type="hidden" value="" name="forward[]">
                <input type="hidden" value="" name="DSTOption[]">
                <?php
                break;

            case 5:
                $ivrDirty = AdminIVRModel::getAll()->getList();
                foreach ($ivrDirty['export']['list'] as $key => $value) {
                    $list['ivrList'][$value['ivr_id']] = $value['ivr_name'];
                }
                ?>
                <select name="dst_option_sub_id[]" class="valid" id="dst_option_sub_id" required>
                    <?php foreach ($list['ivrList'] as $key => $val) { ?>
                        <option value="<?= $key ?>"><?= $val ?> </option>
                    <?php } ?>
                </select>
                <input type="hidden" value="" name="forward[]">
                <input type="hidden" value="" name="DSTOption[]">
                <?php
                break;

            case 6:
                $extensionDirty = AdminExtensionModel::getBy_voicemail_status(1)->getList();
                foreach ($extensionDirty['export']['list'] as $key => $value) {
                    $list['extensionList'][$value['extension_id']] = $value['extension_no'];
                }
                ?>
                <select name="dst_option_sub_id[]" class="valid" id="dst_option_sub_id" required>
                    <?php foreach ($list['extensionList'] as $key => $val) { ?>
                        <option value="<?= $key ?>"><?= $val ?> </option>
                    <?php } ?>
                </select>
                <?php
                break;

            case 8:
                $timeConditionDirty = AdminMainTimeConditionModel::getAll()->getList();
                foreach ($timeConditionDirty['export']['list'] as $key => $value) {
                    $list['timeConditionList'][$value['id']] = $value['name'];
                }
                ?>
                <select name="dst_option_sub_id[]" class="valid" id="dst_option_sub_id" required>
                    <?php foreach ($list['timeConditionList'] as $key => $val) { ?>
                        <option value="<?= $key ?>"><?= $val ?> </option>
                    <?php } ?>
                </select>
                <input type="hidden" value="" name="forward[]">
                <input type="hidden" value="" name="DSTOption[]">
                <?php
                break;


            case 100:
                ?>
                <input type="text" class="form-control ltr" name="dst_option_sub_id[]"
                        value="" id="dst_option_sub_id" autocomplete="off" placeholder="email">
                <input type="hidden" value="" name="forward">
                <input type="hidden" value="" name="DSTOption">
                <?php
                break;
        }
    }

    public function VMForward($fields)
    {
        $dialDestination = new AdminDialDestinationController();
        $dialDestination->voiceMail($fields['name'], 'forward');
    }

    public function VMDSTOption($input)
    {

        $dialDestination = new AdminDialDestinationController();


        switch ($input['dstOption']) {
            case 'withOutMessage':
                $dialDestination->withOutMessage($input['name']);
                break;
            case 'defaultMessage':
                $dialDestination->defaultMessage($input['name']);
                break;
            case 'customMessageByList':
                global $admin_info, $member_info;
                if ($admin_info != -1) {

                    $company_id = $admin_info['comp_id'];
                    $voiceDirty = AdminUploadModel::getBy_comp_id($company_id)->getList();

                } elseif ($member_info != -1) {

                    $company_id = $member_info['comp_id'];
                    $extension_id = $member_info['extension_id'];
                    $voiceDirty = AdminUploadModel::getBy_comp_id_and_extension_id($company_id, $extension_id)->getList();
                }

                foreach ($voiceDirty['export']['list'] as $key => $value) {
                    $voiceClean[$value['upload_id']] = $value['title'];
                }

                $dialDestination->customMessageByList($voiceClean, $input['name']);
                break;
            case 'customMessageByRecord':
                $dialDestination->customMessageByRecord($input['recordId'], 'RecordVoiceLink');
                break;
        }

    }

}

