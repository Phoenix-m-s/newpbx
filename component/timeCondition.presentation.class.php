<?php
include_once(ROOT_DIR . "component/timeCondition.operation.class.php");

/**
 * @author Malekloo Izadi Sakhamanesh <Izadi@dabacenter.ir>
 * @version 0.0.1 this is the beta version of News
 * @copyright 2015 The Imen Daba Parsian Co.
 */
class timeCondition_presentation
{

    /**
     * Contains file type
     *
     * @var
     */
    public $exportType;

    /**
     * Contains file name
     *
     * @var
     */
    public $fileName;

    /**
     * Specifies the type of output
     *
     * @param $list
     * @param $msg
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function template($list = [], $msg = '', $message = '')
    {
        //global $conn, $lang;
        switch ($this->exportType) {
            case 'html':

                include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_start.tpl");
                include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_header.tpl");
                include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_rightMenu.tpl.php");
                include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/$this->fileName");
                include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_footer.tpl");
                include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_end.tpl");
                break;

            case 'json':
                return;
                break;
            default:
                break;
        }

    }

    /**
     * Gets all IVRs
     *
     * @param  $get
     *
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */


    public function search($get)
    {
        include_once(ROOT_DIR . "component/datatable.converter.php");

        $columns = array(
            array('db' => 'ivr_id', 'dt' => 0),
            array('db' => 'ivr_name', 'dt' => 1),
            array('db' => 'title', 'dt' => 2),
            array('db' => 'timeout', 'dt' => 3),
            array('db' => 'direct_dial', 'dt' => 4),
            array('db' => 'ivr_status', 'dt' => 5),
            array('db' => 'ivr_id', 'dt' => 6),
            array('db' => 'comp_name', 'dt' => 7),
            array('db' => 'ivr_id', 'dt' => 8)

        );

        $convert = new convertDatatableIO();
        $convert->input = $get;
        $convert->columns = $columns;
        $searchFields = $convert->convertInput();
        $operation = new ivr_operation();
        $operationSearchFields = $searchFields;
        unset($operationSearchFields['showFields']);
        $operationSearchFields['filter']['trash'] = 0;
        $operation->getIvrList($operationSearchFields);
        $list['list'] = $operation->ivrList;
        $list['paging'] = $operation->paging;

        $other['8'] = array(

            'formatter' => function($list) {

                //$st = '<div class="nice-checkbox"><input type="checkbox" class="checkbox-o" name="box[' . $list['news_id'] . ']" value="' . $list['Title'] . '" id="checkbox-o-' . $i . '"><label for="checkbox-o-' . $i . '"></label></div>';

                $st = '<a href="' . RELA_DIR . 'ivr.php?action=editIvr&id=' . $list['ivr_id'] . '"  rel="tooltip" data-original-title="ویرایش">
                                            <i class="fa fa-pencil text-green"></i>
                                        </a>
                                        <a href="' . RELA_DIR . 'ivr.php?action=trashIvr&id=' . $list['ivr_id'] . '"  rel="tooltip" data-original-title="پاک کردن">
                                            <i class="fa fa-trash text-red"></i>
                                        </a>';

                return $st;
            }
        );

        $other['6'] = array(

            'formatter' => function($list) {

                //$st = '<div class="nice-checkbox"><input type="checkbox" class="checkbox-o" name="box[' . $list['news_id'] . ']" value="' . $list['Title'] . '" id="checkbox-o-' . $i . '"><label for="checkbox-o-' . $i . '"></label></div>';

                $st = '<a href="' . RELA_DIR . 'ivr.php?action=showDST&id=' . $list['ivr_id'] . '"  rel="tooltip" data-original-title="جزییات">
                                            <i class="fa fa-tasks text-orange"></i>
                                        </a>';


                return $st;
            }
        );

        $other['5'] = array(

            'formatter' => function($list) {

                $st = ($list['ivr_status'] == 0 ? 'غیر فعال' : 'فعال');

                return $st;

            }
        );

        $other['3'] = array(

            'formatter' => function($list) {

                $st = ($list['invalid'] == 0 ? 'غیر فعال' : 'فعال');

                return $st;

            }
        );

        $other['0'] = array(

            'formatter' => function($list) {

                $st = '<input type="checkbox" name="ivrID[]" id="ivrID[]" value="' . $list['ivr_id'] . '"/>';


                return $st;
            }
        );

        //$other[2]='news={$news_id}';

        //$other[2]='<div class="nice-checkbox"><input type="checkbox" class="checkbox-o" name="box[{$news_id}]" value="{$Title}" id="checkbox-o-'.$i.'"><label for="checkbox-o-'.$i.'"></label></div>';
        $export = $convert->convertOutput($list, $columns, $other);
        echo json_encode($export);
        die();

    }

    /**
     * Shows all the IVR
     *
     * @param  $list
     * @param  $msg
     * @param  $message
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function showAllIvr($list, $msg, $message)
    {
        $operation = new ivr_operation();
        $operationSearchFields['filter']['trash'] = 0;
        $operation->getIvrList($operationSearchFields);
        $list['list'] = $operation->ivrList;
        $this->exportType = 'html';
        $this->fileName = 'ivr.show.php';
        $this->template($list, $msg, $message);
        die();
    }

    /**
     * Shows all the DST
     *
     * @return  mixed
     *
     * @param $ivrID
     *
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function showAllDST($ivrID)
    {
        //global $conn, $lang;
        $operation = new ivr_operation();
        $result = $operation->getDSTList($ivrID);

        if ($result['result'] != 1) {
            return $result['msg'];
        }

        $this->exportType = 'html';
        $this->fileName = 'ivr.dst.show.php';
        $list = $operation->ivrList;
        $this->template($list);
        die();

    }

    /**
     * Add IVR
     *
     * @param $fields
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function addIvr($fields)
    {
        //******
        $token_list = array_keys($fields['token']);
        $token = $token_list['0'];
        if (isset($_SESSION['token'][$token]) and $_SESSION['token'][$token] == '1') {
            unset($_SESSION['token'][$token]);
        } else {
            $this->addIvrForm($fields, '');
        }
        //******

        include_once(ROOT_DIR . "component/package.db.class.php");
        /*$package = new Package_db;

        $packageResult = $package->checkExtensionCount();

        if ($packageResult['result'] != '1') {
            $this->exportType = 'html';
            $this->fileName = 'ivr.show.php';
            $this->showAllIvr('', $packageResult['msg']);
            die();
        }*/

        //global $conn, $lang;
        $operation = new ivr_operation();

        foreach ($operation->addForm as $key => $val) {
            $input_fields[$key] = $fields[$key];
        }

        $result = $operation->set_ivrInfo($input_fields);

        if ($result['result'] != 1) {
            $this->addIvrForm($fields, $result['msg']);
        }

        $ivrName = $operation->ivrInfo['Ivr_Name'];
        $compID = $operation->ivrInfo['comp_id'];
        $nameResult = $operation->checkIfNameExists($ivrName, $compID);

        if ($nameResult['rowCount'] >= 1) {
            $msg = "This name exists";
            $this->showAllIvr($fields, $msg, '');
        }

        $operation->insertIvr();

        if ($result == - 1) {
            return $result['msg'];
        } else {

            $IvrID = $operation->ivrInfo['Ivr_ID'];
            $operation->insertDST($IvrID);
        }

        if ($result == - 1) {
            return $result['msg'];
        } else {
            redirectPage(RELA_DIR . "ivr.php", "Successfully added.");
        }

        die();
    }

    public function getMonthList($fields, $msg = '')
    {
        $fields['1']['value'] = 1;
        $fields['1']['label'] = 'فروردین';
        $fields['2']['value'] = 2;
        $fields['2']['label'] = 'اردیبهشت';
        $fields['3']['value'] = 3;
        $fields['3']['label'] = 'خرداد';
        $fields['4']['value'] = 4;
        $fields['4']['label'] = 'تیر';
        $fields['5']['value'] = 5;
        $fields['5']['label'] = 'مرداد';
        $fields['6']['value'] = 6;
        $fields['6']['label'] = 'شهریور';
        $fields['7']['value'] = 7;
        $fields['7']['label'] = 'مهر';
        $fields['8']['value'] = 8;
        $fields['8']['label'] = 'آبان';
        $fields['9']['value'] = 9;
        $fields['9']['label'] = 'آذر';
        $fields['10']['value'] = 10;
        $fields['10']['label'] = 'دی';
        $fields['11']['value'] = 11;
        $fields['11']['label'] = 'بهمن';
        $fields['12']['value'] = 12;
        $fields['12']['label'] = 'اسفند';

        return $fields;

    }

    /**
     * Add addTimeConditionForm form
     *
     * @param $fields
     * @param $msg
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function addTimeConditionForm($fields, $msg = '')
    {
        global $conn, $lang;

        $fields['DSTList'] = $this->getAllDstOption('ivr');
        //echo '<pre/>';
        //print_r($fields['DSTList']);
        //die();
        //$fields['uploadList'] = $this->getUploadList();

        $fields['monthList'] = $this->getMonthList();

        for ($i = 1; $i <= 31; $i ++) {
            $fields['daysMonthList'][$i] = $i;
        }
        for ($i = 1; $i <= 7; $i ++) {
            $fields['daysWeekList'][$i]['label'] = $i;
            $fields['daysWeekList'][$i]['value'] = $i;
        }


        $this->exportType = 'html';
        $this->fileName = 'timeCondition.add.form.php';

        //*****
        $uniqid = uniqid();
        $_SESSION['token'][$uniqid] = '1';
        $fields['token'] = 'token[' . $uniqid . ']';
        //*****

        $this->template($fields, $msg);
        die();

    }

    /**
     * Add IVR form
     *
     * @param $ivrID
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function editIvrForm($ivrID)
    {
        //global $conn, $lang;
        $operation = new ivr_operation();
        $result = $operation->getIVRListById($ivrID);

        if ($result['result'] == '0') {
            return $result['msg'];

        }

        $list = $operation->ivrInfo;
        $operation = new ivr_operation();
        $result = $operation->getDSTList($ivrID);

        if ($result['result'] != 1) {
            return $result['msg'];
        }

        $list['DST'] = $operation->ivrList;

        /*foreach($list['DST'] as $key=>$value)
        {
            $list['DST']['Type'][$value['dst_option_id']]  = true;
        }*/

        foreach ($list['DST'] as $optID => $fields) {

            switch ($fields['dst_option_id']) {
                case 1:
                    include_once(ROOT_DIR . "component/sip.operation.class.php");

                    $sip = new sip_operation();
                    $result = $sip->getSipList();

                    if ($result['result'] != 1) {
                        return $result['msg'];
                    }
                    foreach ($sip->sipList as $SipKey => $SipValue) {
                        $list['DstSub'][1][$SipKey] = $SipValue['sip_name'];
                    }

                    break;
                case 2:
                    include_once(ROOT_DIR . "component/queue.operation.class.php");
                    $queue = new queue_operation();
                    $result = $queue->getQueueList();

                    if ($result['result'] != 1) {
                        return $result['msg'];
                    }

                    foreach ($queue->queueList as $QueueKey => $QueueValue) {
                        $list['DstSub'][2][$QueueKey] = $QueueValue['queue_name'];
                    }

                    break;
                case 3:
                    include_once(ROOT_DIR . "component/extension.operation.class.php");
                    $extension = new extension_operation();
                    $result = $extension->getExtensionList();

                    if ($result['result'] != 1) {
                        return $result['msg'];
                    }

                    foreach ($extension->extensionList as $extensionKey => $extensionValue) {
                        $list['DstSub'][3][$extensionKey] = $extensionValue['Extension_Name'];
                    }

                    break;
                case 4:
                    include_once(ROOT_DIR . "component/announce.operation.class.php");
                    $announce = new announce_operation();
                    $result = $announce->getAnnounceList();

                    if ($result['result'] != 1) {
                        return $result['msg'];
                    }

                    foreach ($announce->announceList as $announceKey => $announceValue) {
                        $list['DstSub'][4][$announceKey] = $announceValue['announce_name'];
                    }
                    break;
                case 5:
                    $ivr = new ivr_operation();
                    $result = $ivr->getIvrList();

                    if ($result['result'] != 1) {
                        return $result['msg'];
                    }

                    foreach ($ivr->ivrList as $ivrKey => $ivrValue) {
                        $list['DstSub'][5][$ivrKey] = $ivrValue['ivr_name'];
                    }
                    break;
                case 6:
                    include_once(ROOT_DIR . "component/extension.operation.class.php");
                    $upload = new extension_operation();
                    $result = $upload->getVoiceMailList();

                    if ($result['result'] != 1) {
                        return $result['msg'];
                    }

                    foreach ($upload->extensionList as $Key => $Value) {
                        $list['DstSub'][6][$Key] = $Value['extension_no'];
                    }
                    break;
                case 100:
                    $list['DstSub'][100][$fields['dst_menu_id']] = $fields['dst_option_sub_id'];
                    break;
            }
        }

        $list['DSTList'] = $this->getAllDstOption('ivr');
        $list['uploadList'] = $this->getUploadList();
        $this->exportType = 'html';
        $this->fileName = 'ivr.edit.form.php';
        $this->template($list);
        die();

    }

    /**
     * Edit IVR based on its ID
     *
     * @param $fields
     * @param $msg
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function editIvr($fields, $msg)
    {

        //global $conn, $lang;
        $operation = new ivr_operation();

        foreach ($operation->editForm as $key => $val) {
            $input_fields[$key] = $fields[$key];
        }

        $result = $operation->set_ivrInfo($input_fields);

        if ($result['result'] != 1) {
            $this->addIvrForm($fields, $result['msg']);
        }


        $ivrName = $operation->ivrInfo['Ivr_Name'];
        $compID = $operation->ivrInfo['comp_id'];
        $nameResult = $operation->checkIfNameExists($ivrName, $compID);

        if ($nameResult['rowCount'] >= 2) {
            $msg = "This name exists";
            $this->addIvrForm($fields, $msg);
        }

        $operation->updateIvr();

        if ($result == - 1) {
            return $result['msg'];
        } else {
            $IvrID = $operation->ivrInfo['Ivr_ID'];
            $operation->updateDST($IvrID);
        }

        if ($result == - 1) {
            return $result['msg'];
        } else {
            redirectPage(RELA_DIR . "ivr.php", "Successfully updated.");
        }

        die();
    }

    /**
     * Deletes IVR based on its ID
     *
     * @param $ivrID
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function deleteIVRs_delete($ivrID)
    {
        //global $conn, $lang;
        $operation = new ivr_operation();
        $result = $operation->deleteIvr($ivrID);

        if ($result['result'] == - 1) {
            return $result;
        }

        $msg = "Successfully deleted.";
        redirectPage(RELA_DIR . "trash.php?action=showIvrTrash", $msg);
        die();
    }

    /**
     * changeStatus of IVR based on its ID
     *
     * @return  mixed
     *
     * @param  $fields
     *
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function changeStatus($fields)
    {
        global $conn, $lang;
        $operation = new ivr_operation();
        $result = $operation->set_IDs($fields['ivrID']);
        if ($result['result'] == - 1) {
            return $result;
        }
        $result = $operation->changeStatus($fields['status']);
        if ($result['result'] == - 1) {
            return $result;
        } else {
            $this->showAllIvr('', '');
        }
        die();
    }

    /**
     * Add extension form
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function getUploadList()
    {
        global $conn, $lang;
        include_once(ROOT_DIR . "component/upload.operation.class.php");
        $operation = new upload_operation();
        $operationSearchFields['filter']['trash'] = 0;
        $result = $operation->getUploadList($operationSearchFields);

        if ($result['result'] != 1) {
            return $result['msg'];
        }

        return $operation->uploadList;

    }

    /**
     * Add extension form
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function getAllDstOption($filter)
    {
        global $conn, $lang;
        include_once(ROOT_DIR . "component/dstOption.operation.class.php");
        $operation = new dstOption_operation();
        $result = $operation->getDstOptionList($filter);
        if ($result['result'] != 1) {
            return $result['msg'];
        }

        return $operation->dstOptionList;

    }

    /**
     * Trashes IVR based on its ID
     *
     * @param $IvrID
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function deleteIVRs($IvrID)
    {
        $found = 0;
        //global $conn, $lang;
        $operation = new ivr_operation();

        /////////checkAnnounceTrashDependency/////////
        $resultFile = $this->checkAnnounceDependency($IvrID);

        if ($resultFile['result'] != 1) {
            $message = $resultFile['msg'];
            $this->exportType = 'html';
            $this->fileName = 'ivr.show.php';
            $this->template($resultFile, $message);
            die();
        }

        if ($resultFile['rowCount'] >= 1) {
            $found = 1;
            $result['list']['announce'] = $resultFile['list'];
            $result['label']['announce'] = 'These announces need to be deleted before deleting this IVR: ';
        }

        ///////end checkAnnounceTrashDependency////

        /////////checkQueueTrashDependency/////////
        $resultFile = $this->checkQueueDependency($IvrID);

        if ($resultFile['result'] != 1) {
            $message = $resultFile['msg'];
            $this->exportType = 'html';
            $this->fileName = 'ivr.show.php';
            $this->template($resultFile, $message);
            die();
        }

        if ($resultFile['rowCount'] >= 1) {
            $found = 1;
            $result['list']['queue'] = $resultFile['list'];
            $result['label']['queue'] = 'These queues need to be deleted before deleting this IVR: ';
        }
        ///////end checkQueueTrashDependency////


        /////////checkInboundTrashDependency/////////
        $resultFile = $this->checkInboundDependency($IvrID);


        if ($resultFile['result'] != 1) {
            $message = $resultFile['msg'];
            $this->exportType = 'html';
            $this->fileName = 'ivr.show.php';
            $this->template($resultFile, $message);
            die();
        }

        if ($resultFile['rowCount'] >= 1) {
            $found = 1;
            $result['list']['inbound'] = $resultFile['list'];
            $result['label']['inbound'] = 'These inbounds need to be deleted before deleting this IVR: ';
        }

        ///////end checkInboundTrashDependency////

        /////////checkIvrTrashDependency/////////
        $resultIVR = $this->checkIvrDependency($IvrID);

        if ($resultIVR['result'] != 1) {
            $message = $resultIVR['msg'];
            $this->exportType = 'html';
            $this->fileName = 'ivr.show.php';
            $this->template($resultFile, $message);
            die();
        }


        if ($resultIVR['rowCount'] >= 1) {
            $found = 1;
            //$result['list']['ivr'] = $resultIVR['list'];
            foreach ($resultIVR['list'] as $key => $value) {
                $IVR = new ivr_operation();
                $result_getIVR = $IVR->getIVRListById($value['ivr_id']);


                if ($result_getIVR['result'] == 1) {
                    $result['list']['ivr'][$value['ivr_id']]['name'] = $IVR->ivrInfo['Ivr_Name'];
                }
            }
            $result['label']['ivr'] = 'These IVRs need to be deleted before deleting this IVR: ';

        }
        ///////end checkIvrTrashDependency////

        if ($found == 1) {
            $this->exportType = 'html';
            $this->fileName = 'ivr.show.php';
            $this->showAllIvr('', '', $result);
            die();
        }

        $result = $operation->deleteIvr($IvrID);

        if ($result['result'] == - 1) {
            return $result;
        } else {
            $msg = "Successfully deleted.";
            redirectPage(RELA_DIR . "ivr.php", $msg);
        }

        die();
    }

    /**
     * Trashes IVR based on its ID
     *
     * @param $IvrID
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function recycleIvr($IvrID)
    {
        global $conn, $lang;
        $operation = new ivr_operation();
        $result = $operation->getIVRListById($IvrID);

        if ($result['result'] == - 1) {
            return $result;
        }

        $ivrName = $operation->ivrInfo['Ivr_Name'];
        $compID = $operation->ivrInfo['comp_id'];
        $nameResult = $operation->checkIfNameExists($ivrName, $compID);

        if ($nameResult['rowCount'] >= 1) {
            $msg = "This name exists";
            include_once(ROOT_DIR . "component/trash.presentation.class.php");
            $operation = new trash_presentation();
            $result = $operation->showIvrTrash('', $msg);
            if ($result['result'] == - 1) {
                return $result;
            }
        }

        $result = $operation->recycleIvr($IvrID);


        if ($result['result'] == - 1) {
            return $result;
        } else {
            $msg = "Successfully recycled.";
            redirectPage(RELA_DIR . "ivr.php", $msg);
        }
        die();
    }

    /**
     * Checks if extensions exists based on comp ID
     *
     * @param $ivrID
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function checkAnnounceDependency($ivrID)
    {
        $operation = new ivr_operation();
        $result = $operation->checkAnnounceDependency($ivrID);

        return $result;
    }

    /**
     * Checks if extensions exists based on comp ID
     *
     * @param $ivrID
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function checkQueueDependency($ivrID)
    {
        $operation = new ivr_operation();
        $result = $operation->checkQueueDependency($ivrID);

        return $result;
    }

    /**
     * Checks if extensions exists based on comp ID
     *
     * @param $ivrID
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function checkInboundDependency($ivrID)
    {
        $operation = new ivr_operation();
        $result = $operation->checkInboundDependency($ivrID);

        return $result;
    }

    /**
     * Checks if extensions exists based on comp ID
     *
     * @param $ivrID
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function checkIvrDependency($ivrID)
    {
        $operation = new ivr_operation();
        $result = $operation->checkIvrDependency($ivrID);

        return $result;
    }
}
