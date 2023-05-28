<?php
include_once ROOT_DIR . "component/announce.operation.class.php";

/**
 * @author Malekloo,Izadi,Sakhamanesh <Izadi@dabacenter.ir>
 * @version 0.0.1 this is the beta version of News
 * @copyright 2015 The Imen Daba Parsian Co.
 */
class announce_presentation
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
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function template($list = [], $msg = '', $message = '')
    {
        global $conn, $lang;
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
     * search
     *
     * @param $get
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    10/09/2015
     */
    public function search($get)
    {
        include_once(ROOT_DIR . "component/datatable.converter.php");

        $columns = array(
            array('db' => 'announce_id', 'dt' => 0),
            array('db' => 'announce_name', 'dt' => 1),
            array('db' => 'repeat_input', 'dt' => 2),
            array('db' => 'announce_date', 'dt' => 3),
            array('db' => 'title', 'dt' => 4),
            array('db' => 'option_value', 'dt' => 5),
            array('db' => 'announce_status', 'dt' => 6),
            array('db' => 'comp_name', 'dt' => 7)
        );

        $convert = new convertDatatableIO();
        $convert->input = $get;
        $convert->columns = $columns;
        $searchFields = $convert->convertInput();
        $operation = new announce_operation();
        $operationSearchFields = $searchFields;
        unset($operationSearchFields['showFields']);
        $operationSearchFields['filter']['trash'] = 0;
        $operation->getAnnounceList($operationSearchFields);
        $list['list'] = $operation->announceList;
        $list['upload'] = $this->getUploadList($operationSearchFields);
        $list['paging'] = $operation->paging;

        $other['8'] = array(
            'formatter' => function($list) {
                $st = '<a href="' . RELA_DIR . 'announce.php?action=editAnnounce&id=' . $list['announce_id'] . '"  rel="tooltip" data-original-title="' . EDIT_01 . '">
                                            <i class="fa fa-pencil text-green"></i>
                                        </a>
                                        <a href="' . RELA_DIR . 'announce.php?action=trashAnnounce&id=' . $list['announce_id'] . '"  rel="tooltip" data-original-title="' . DELETE_01 . '">
                                            <i class="fa fa-trash text-red"></i>
                                        </a>';

                return $st;
            }
        );

        $other['6'] = array(
            'formatter' => function($list) {
                $st = ($list['announce_status'] == 0 ? ENABLE_01 : DISABLED_01);

                return $st;
            }
        );

        $other['0'] = array(
            'formatter' => function($list) {
                $st = '<input type="checkbox" name="announceID[]" id="announceID[]" value="' . $list['announce_id'] . '">';

                return $st;
            }
        );

        $export = $convert->convertOutput($list, $columns, $other);
        echo json_encode($export);
        die();


    }

    /**
     * Shows all the Announces
     *
     * @return  mixed
     *
     * @param  $msg
     * @param  $list
     *
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function showAllAnnounce($list, $msg, $message)
    {
        $operation = new announce_operation();
        $operationSearchFields['filter']['trash'] = 0;
        $operation->getAnnounceList($operationSearchFields);
        $list['list'] = $operation->announceList;
        $list['upload'] = $this->getUploadList($operationSearchFields);
        $this->exportType = 'html';
        $this->fileName = 'announce.show.php';
        $this->template($list, $msg, $message);
        die();
    }

    /**
     * Add Announce form
     *
     * @param $fields
     * @param $msg
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function addAnnounceForm($fields, $msg)
    {
        global $conn, $lang;
        $fields['DSTList'] = $this->getAllDstOption();
        $fields['upload_list'] = $this->getUploadList();
        $this->exportType = 'html';
        $this->fileName = 'announce.add.form.php';

        $uniqid = uniqid();
        $_SESSION['token'][$uniqid] = '1';
        $fields['token'] = 'token[' . $uniqid . ']';

        $this->template($fields, $msg);
        die();

    }

    /**
     * Add announce
     *
     * @param $fields
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function addAnnounce($fields)
    {
        global $conn, $lang;
        $token_list = array_keys($fields['token']);
        $token = $token_list['0'];
        if (isset($_SESSION['token'][$token]) and $_SESSION['token'][$token] == '1') {
            unset($_SESSION['token'][$token]);
        } else {
            $this->addAnnounceForm($fields, '');
        }

        include_once(ROOT_DIR . "component/package.db.class.php");
       /* $package = new Package_db;
        $packageResult = $package->checkExtensionCount();


        if ($packageResult['result'] != '1') {
            $this->exportType = 'html';
            $this->fileName = 'announce.show.php';
            $this->showAllAnnounce('', $packageResult['msg'], '');
            die();
        }*/

        $operation = new announce_operation();

        foreach ($operation->addForm as $key => $val) {
            $input_fields[$key] = $fields[$key];
        }

        $result = $operation->set_announceInfo($input_fields);

        if ($result['result'] != 1) {
            $this->addAnnounceForm($fields, $result['msg']);
        }

        $announceName = $operation->announceInfo['announce_name'];
        $compID = $operation->announceInfo['comp_id'];
        $nameResult = $operation->checkIfNameExists($announceName, $compID);

        if ($nameResult['rowCount'] >= 1) {
            $msg = ModelANNOUNCE_01;
            $this->addAnnounceForm($fields, $msg);
        }

        $operation->insertAnnounce();

        if ($result == - 1) {
            return $result['msg'];
        } else {
            redirectPage(RELA_DIR . "announce.php", ModelANNOUNCE_02);
        }
        die();
    }

    /**
     * Show edit Announce form based on its ID
     *
     * @param $announceID
     * @param $msg
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function editAnnounceForm($announceID, $msg)
    {
        //global $conn, $lang;
        $operation = new announce_operation();
        $result = $operation->getAnnounceListById($announceID);

        if ($result['result'] == '0') {
            return $result['msg'];

        }

        $fields = $operation->announceInfo;


        $fields['DSTList'] = $this->getAllDstOption();
        $fields['upload_list'] = $this->getUploadList();

        switch ($fields['dst_option_id']) {
            case 1:
                include_once(ROOT_DIR . "component/sip.operation.class.php");
                $sip = new sip_operation();
                $result = $sip->getSipList();

                if ($result['result'] != 1) {
                    return $result['msg'];
                }

                foreach ($sip->sipList as $SipKey => $SipValue) {
                    $fields['DstSub'][$SipKey] = $SipValue['sip_name'];
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
                    $fields['DstSub'][$QueueKey] = $QueueValue['queue_name'];
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
                    $fields['DstSub'][$extensionKey] = $extensionValue['Extension_Name'];
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
                    $fields['DstSub'][$announceKey] = $announceValue['announce_name'];
                }
                break;

            case 5:
                include_once(ROOT_DIR . "component/ivr.operation.class.php");
                $ivr = new ivr_operation();
                $result = $ivr->getIvrList();

                if ($result['result'] != 1) {
                    return $result['msg'];
                }

                foreach ($ivr->ivrList as $ivrKey => $ivrValue) {
                    $fields['DstSub'][$ivrKey] = $ivrValue['ivr_name'];
                }
                break;

            case 6:
                include_once(ROOT_DIR . "component/extension.operation.class.php");
                $operation = new extension_operation();
                $input_fields['filter']['trash'] = 0;
                $result = $operation->getVoiceMailList($input_fields);

                if ($result['result'] != 1) {
                    return $result['msg'];
                }
                $list = $operation->extensionList;

                foreach ($list as $value) {
                    $fields['DstSub'][$value['extension_no']] = $value['extension_no'];
                }
                break;
        }

        $this->exportType = 'html';
        $this->fileName = 'announce.edit.form.php';
        $this->template($fields, $msg);
        die();
    }

    /**
     * Edit Announce based on its ID
     *
     * @param $fields
     * @param $msg
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function editAnnounce($fields, $msg)
    {
        $operation = new announce_operation();

        foreach ($operation->editForm as $key => $val) {
            $input_fields[$key] = $fields[$key];
        }

        $result = $operation->set_announceInfo($input_fields);

        if ($result['result'] != 1) {
            $this->editAnnounceForm($fields['announce_id'], $result['msg']);
        }

        $announceName = $operation->announceInfo['announce_name'];
        $compID = $operation->announceInfo['comp_id'];
        $nameResult = $operation->checkIfNameExists($announceName, $compID);

        if ($nameResult['rowCount'] >= 2) {
            $msg = "This name exists";
            $this->addAnnounceForm($fields, $msg);
        }

        $result = $operation->updateAnnounce();

        $fields['DSTList'] = $this->getAllDstOption();

        if ($result['result'] == 1) {
            redirectPage(RELA_DIR . "announce.php", ModelANNOUNCE_02);
        } else {
            $this->editAnnounceForm($fields['announce_id'], $msg);
        }

        die();
    }

    /**
     * Trashes announces
     *
     * @param $announceID
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function deleteAnnounce($announceID)
    {
        $found = 0;

        /////////checkInboundTrashDependency/////////
        $resultInbound = $this->checkInboundDependency($announceID);

        if ($resultInbound['result'] != 1) {
            $message = $resultInbound['msg'];
            $this->exportType = 'html';
            $this->fileName = 'announce.show.php';
            $this->template($resultInbound, $message);
            die();
        }

        if ($resultInbound['rowCount'] >= 1) {
            $found = 1;
            $result['list']['inbound'] = $resultInbound['list'];
            $result['label']['inbound'] = ModelANNOUNCE_03;
        }
        ///////end checkInboundTrashDependency////


        /////////checkQueueTrashDependency/////////
        $resultQ = $this->checkQueueDependency($announceID);

        if ($resultQ['result'] != 1) {
            $message = $resultQ['msg'];
            $this->exportType = 'html';
            $this->fileName = 'announce.show.php';
            $this->template($resultQ, $message);
            die();
        }

        if ($resultQ['rowCount'] >= 1) {
            $found = 1;
            $result['list']['queue'] = $resultQ['list'];
            $result['label']['queue'] = ModelANNOUNCE_04;
        }
        ///////end checkQueueTrashDependency////

        /////////checkIvrTrashDependency/////////
        $resultIVR = $this->checkIvrDependency($announceID);

        if ($resultIVR['result'] != 1) {
            $message = $resultIVR['msg'];
            $this->exportType = 'html';
            $this->fileName = 'announce.show.php';
            $this->template($resultIVR, $message);
            die();
        }

        if ($resultIVR['rowCount'] >= 1) {
            $found = 1;
            foreach ($resultIVR['list'] as $key => $value) {
                $IVR = new ivr_operation();
                $result_getIVR = $IVR->getIVRListById($value['ivr_id']);

                if ($result_getIVR['result'] == 1) {
                    $result['list']['ivr'][$value['ivr_id']]['name'] = $IVR->ivrInfo['Ivr_Name'];
                }
            }

            $result['label']['ivr'] = ModelANNOUNCE_05;
        }

        ///////end checkIVRTrashDependency////

        if ($found == 1) {
            $this->exportType = 'html';
            $this->fileName = 'announce.show.php';
            $this->showAllAnnounce('', '', $result);
            die();
        }


        $operation = new announce_operation();

        $result = $operation->deleteAnnounce($announceID);

        if ($result['result'] == - 1) {
            return $result;
        } else {
            $msg = ModelANNOUNCE_06;
            redirectPage(RELA_DIR . "announce.php", $msg);
        }
        die();
    }

    /**
     * Deletes announce based on its ID
     *
     * @param announceID
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function deleteAnnounce_temp($announceID)
    {
        $operation = new announce_operation();
        $result = $operation->deleteAnnounce($announceID);

        if ($result['result'] == - 1) {
            return $result;
        } else {
            $msg = "Successfully deleted.";
            redirectPage(RELA_DIR . "trash.php?action=showAnnounceTrash", $msg);
        }
        die();
    }

    /**
     * changeStatus announce based on its ID
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
        //global $conn, $lang;
        $operation = new announce_operation();
        $result = $operation->set_IDs($fields['announceID']);

        if ($result['result'] == - 1) {
            return $result;
        }

        $result = $operation->changeStatus($fields['status']);

        if ($result['result'] == - 1) {
            return $result;
        } else {
            $this->showAllAnnounce('', '');
        }
        die();
    }

    /**
     * Get list o uploaded files
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function getUploadList()
    {
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
     * Recycle announce
     *
     * @param $announceID
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function recycleAnnounces($announceID)
    {
        $operation = new announce_operation();
        $result = $operation->getAnnounceListById($announceID);

        if ($result['result'] == - 1) {
            return $result;
        }

        $announceName = $operation->announceInfo['announce_name'];
        $compID = $operation->announceInfo['comp_id'];
        $nameResult = $operation->checkIfNameExists($announceName, $compID);

        if ($nameResult['rowCount'] >= 1) {
            $msg = "This name exists";
            include_once(ROOT_DIR . "component/trash.presentation.class.php");
            $operation = new trash_presentation();
            $result = $operation->showAnnounceTrash('', $msg);
            if ($result['result'] == - 1) {
                return $result;
            }
        }

        $result = $operation->recycleAnnounce($announceID);

        if ($result['result'] == - 1) {
            return $result;
        } else {
            $msg = ModelANNOUNCE_07;
            redirectPage(RELA_DIR . "announce.php", $msg);
        }
        die();
    }

    /**
     * Checks if inbound is dependant
     *
     * @param $announceID
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function checkInboundDependency($announceID)
    {
        $operation = new announce_operation();
        $result = $operation->checkInboundDependency($announceID);

        return $result;
    }

    /**
     * Checks if Queue is dependant
     *
     * @param $announceID
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function checkQueueDependency($announceID)
    {
        $operation = new announce_operation();
        $result = $operation->checkQueueDependency($announceID);

        return $result;
    }

    /**
     * Checks if IVR is dependant
     *
     * @param $announceID
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function checkIvrDependency($announceID)
    {
        $operation = new announce_operation();
        $result = $operation->checkIvrDependency($announceID);

        return $result;
    }

    /**
     * Add extension form
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function getAllDstOption()
    {
        include_once(ROOT_DIR . "component/dstOption.operation.class.php");
        $operation = new dstOption_operation();
        $result = $operation->getDstOptionList();

        if ($result['result'] != 1) {
            return $result['msg'];
        }

        return $operation->dstOptionList;
    }

}


