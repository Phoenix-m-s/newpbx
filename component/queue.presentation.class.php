<?php
include_once(ROOT_DIR . "component/queue.operation.class.php");

/**
 * @author Malekloo Izadi Sakhamanesh <Izadi@dabacenter.ir>
 * @version 0.0.1 this is the beta version of News
 * @copyright 2015 The Imen Daba Parsian Co.
 */
class queue_presentation
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
     * @param $msg
     * @param $list
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function template($list = [], $msg = '', $message = '')
    {
        switch($this->exportType) {
            case 'html':
                include ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_start.tpl";
                include ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_header.tpl";
                include ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_rightMenu.tpl.php";
                include ROOT_DIR . "templates/" . CURRENT_SKIN . "/$this->fileName";
                include ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_footer.tpl";
                include ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_end.tpl";
                break;
        }

    }

    /**
     * Shows all the queues
     * @return  mixed
     * @param  $list
     * @param  $msg
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function showAllQueues($list, $msg, $message)
    {
        //global $conn, $lang;
        $operation = new queue_operation();
        $operationSearchFields['filter']['trash'] = 0;
        $operation->getQueueList($operationSearchFields);
        $list['list'] = $operation->queueList;
        $this->exportType = 'html';
        $this->fileName = 'queue.show.php';
        $this->template($list, $msg, $message);
        die();
    }

    /**
     * Shows all the Agents
     * @return  mixed
     * @param $queueID
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function showAllAgents($queueID)
    {
        //global $conn, $lang;
        $operation = new queue_operation();
        $result = $operation->getQueueListById($queueID);

        if ($result['result'] != 1) {
            return $result['msg'];
        }

        $this->exportType = 'html';
        $this->fileName = 'queue.agents.show.php';
        $list = explode(',', $operation->queueInfo['Agents_No']);
        $this->template($list);
        die();

    }

    /**
     * Add queue
     * @param $fields
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function addQueue($fields)
    {
        if (!isset($fields['Position_Announcement'])) {
            $fields['Position_Announcement'] = 0;
        }

        if (!isset($fields['Hold_Time_Announcement'])) {
            $fields['Hold_Time_Announcement'] = 0;
        }

        if (!isset($fields['Recording'])) {
            $fields['Recording'] = 0;
        }

        if (!isset($fields['instead'])) {
            $fields['instead'] = 0;
        }

        $token_list = array_keys($fields['token']);
        $token = $token_list['0'];
        if(isset($_SESSION['token'][$token]) and $_SESSION['token'][$token] == '1')  {
            unset($_SESSION['token'][$token]);
        } else {
            $this->addQueueForm($fields, '');
        }

        include_once(ROOT_DIR . "component/package.db.class.php");
       /* $package = new Package_db;

        $packageResult = $package->checkExtensionCount();

        if ($packageResult['result'] != '1') {
            $this->exportType = 'html';
            $this->fileName = 'queue.show.php';
            $this->showAllQueues('', $packageResult['msg']);
            die();
        }*/




        $operation = new queue_operation();
        foreach($operation->addForm as $key => $val) {
            $input_fields[$key] = $fields[$key];
        }

        $result = $operation->set_queueInfo($input_fields);

        if ($result['result'] != 1) {
            $this->addQueueForm($fields, $result['msg']);
        }

        $queueName = $operation->queueInfo['Queue_Name'];
        $compID = $operation->queueInfo['comp_id'];
        $nameResult = $operation->checkIfNameExists($queueName, $compID);

        if($nameResult['rowCount'] >= 1) {
            $msg = ModelINBOUND_13;
            $this->addQueueForm($fields,$msg);
        }

        $operation->insertQueue();

        if($result == -1) {
            return $result['msg'];
        } else {
            redirectPage(RELA_DIR . "queue.php", ModelANNOUNCE_02);
        }

        die();
    }

    /**
     * Add queue form
     * @param $fields
     * @param $msg
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function addQueueForm($fields, $msg='')
    {

        // global $conn, $lang;
        $operation = new queue_operation();
        $fields['DSTList'] = $this->getAllDstOption();
        $operationSearchFields['filter']['trash'] = 0;
        $fields['ExtensionList'] = $operation->getAllExtensionList($operationSearchFields);
        $this->exportType='html';
        $this->fileName='queue.add.form.php';

        $uniqID = uniqid();
        $_SESSION['token'][$uniqID] = '1';
        $fields['token'] = 'token['.$uniqID.']';

        $this->template($fields, $msg);
        die();

    }

    /**
     * Edit queue based on its ID
     * @param $fields
     * @param $msg
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function editQueue($fields, $msg)
    {
        if (!isset($fields['Position_Announcement'])) {
            $fields['Position_Announcement'] = 0;
        }

        if (!isset($fields['Hold_Time_Announcement'])) {
            $fields['Hold_Time_Announcement'] = 0;
        }

        if (!isset($fields['Recording'])) {
            $fields['Recording'] = 0;
        }

        if (!isset($fields['instead'])) {
            $fields['instead'] = 0;
        }

        // global $conn, $lang;
        $operation = new queue_operation();

        foreach ($operation->editForm as $key => $val) {
            $input_fields[$key] = $fields[$key];
        }

        $result = $operation->set_queueInfo($input_fields);

        if ($result['result'] !=1 ) {
            $this->editQueueForm($fields['id'],$result['msg']);

        }

        $queueName = $operation->queueInfo['Queue_Name'];
        $compID = $operation->queueInfo['comp_id'];
        $nameResult    = $operation->checkIfNameExists($queueName,$compID);

        if ($nameResult['rowCount'] >= 2) {
            $msg = ModelINBOUND_13;
            $this->addQueueForm($fields,$msg);
        }

        $result = $operation->updateQueue();

        if ($result['result'] == 1) {
            redirectPage(RELA_DIR . "queue.php", ModelINBOUND_14);
        } else {
            $this->editQueueForm($fields['id'],$msg);
        }

        die();
    }

    /**
     * Show edit queue form based on its ID
     * @param $queueID
     * @param $msg
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function editQueueForm($queueID, $msg)
    {
        //global $conn, $lang;
        $operation = new queue_operation();
        $DSTList = $this->getAllDstOption();
        $ExtensionList = $operation->getAllExtensionList();
        $result = $operation->getQueueListById($queueID);

        if ($result['result']=='0') {
            return $result['msg'];
        }

        $queueList= $operation->queueInfo;
        $list['Agents_No'] =  $ExtensionList;
        $list['DSTList'] = $DSTList;
        $list['QueueList'] = $queueList;

        switch ($list['QueueList']['dst_option_id']) {
            case 1:
                include_once(ROOT_DIR . "component/sip.operation.class.php");

                $sip=new sip_operation();
                $result=$sip->getSipList();

                if ($result['result'] != 1) {
                    return $result['msg'];
                }

                foreach ($sip->sipList as $SipKey => $SipValue) {
                    $list['DstSub'][$SipKey] = $SipValue['sip_name'];
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
                    $list['DstSub'][$QueueKey] = $QueueValue['queue_name'];
                }
                break;
            case 3:
                include_once(ROOT_DIR . "component/extension.operation.class.php");
                $extension=new extension_operation();
                $result=$extension->getExtensionList();

                if ($result['result'] != 1) {
                    return $result['msg'];
                }

                foreach ($extension->extensionList as $extensionKey => $extensionValue) {
                    $list['DstSub'][$extensionKey] = $extensionValue['Extension_Name'];
                }
                break;
            case 4:
                include_once(ROOT_DIR . "component/announce.operation.class.php");
                $announce=new announce_operation();
                $result=$announce->getAnnounceList();

                if($result['result'] != 1) {
                    return $result['msg'];
                }

                foreach ($announce->announceList as $announceKey => $announceValue) {
                    $list['DstSub'][$announceKey] = $announceValue['announce_name'];
                }
                break;
            case 5:
                include_once(ROOT_DIR . "component/ivr.operation.class.php");
                $ivr=new ivr_operation();
                $result = $ivr->getIvrList();

                if($result['result'] != 1) {
                    return $result['msg'];
                }

                foreach ($ivr->ivrList as $ivrKey => $ivrValue) {
                    $list['DstSub'][$ivrKey] = $ivrValue['ivr_name'];
                }
                break;
            case 6:
                include_once(ROOT_DIR . "component/upload.operation.class.php");
                $upload=new upload_operation();
                $result=$upload->getUploadList();

                if ($result['result'] != 1) {
                    return $result['msg'];
                }

                foreach ($upload->uploadList as $uploadKey => $uploadValue) {
                    $list['DstSub'][$uploadKey] = $uploadValue['Title'];
                }
                break;
        }

        $list['Agents'] = explode(',', $list['QueueList']['Agents_No']);
        $this->exportType = 'html';
        $this->fileName = 'queue.edit.form.php';
        $this->template($list, $msg);
        die();
    }

    /**
     * Deletes queue based on its ID
     * @param $queueID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function deleteQueues_temp($queueID)
    {
        $operation = new queue_operation();
        $result = $operation->deleteQueue($queueID);

        if ($result['result'] == -1) {
            return $result;
        } else {
            $msg = ModelEXTENSION_11;
            redirectPage(RELA_DIR . "trash.php?action=showQueueTrash", $msg);
        }
        die();
    }

    /**
     * Trashes queue based on its ID
     * @param $queueID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function deleteQueues($queueID)
    {
        $found = 0;
        global $conn, $lang;

        /////////checkAnnounceTrashDependency////////
        $resultAnnounce = $this->checkAnnounceDependency($queueID);

        if ($resultAnnounce['result'] != 1) {
            $message = $resultAnnounce['msg'];
            $this->exportType = 'html';
            $this->fileName = 'queue.show.php';
            $this->template($resultAnnounce, $message);
            die();
        }

        if ($resultAnnounce['rowCount'] >= 1) {
            $found = 1;
            $result['list']['announce'] = $resultAnnounce['list'];
            $result['label']['announce'] = ModelQUEUE_17;
        }

        /////////end checkAnnounceTrashDependency/////////

        /////////checkInboundTrashDependency////////
        $resultInbound = $this->checkInboundDependency($queueID);

        if ($resultInbound['result'] != 1) {
            $message = $resultInbound['msg'];
            $this->exportType = 'html';
            $this->fileName = 'queue.show.php';
            $this->template($resultInbound, $message);
            die();
        }


        if ($resultInbound['rowCount'] >= 1) {
            $found = 1;
            $result['list']['inbound'] = $resultInbound['list'];
            $result['label']['inbound'] = ModelQUEUE_18;
        }

        /////////end checkInboundTrashDependency/////////

        /////////checkIvrTrashDependency////////
        $resultIVR = $this->checkIvrDependency($queueID);

        if ($resultIVR['result'] != 1) {
            $message = $resultIVR['msg'];
            $this->exportType = 'html';
            $this->fileName = 'queue.show.php';
            $this->template($resultIVR, $message);
            die();
        }

        if ($resultIVR['rowCount'] >= 1) {

            $found = 1;
            //$result['list']['ivr'] = $resultIVR['list'];
            foreach ($resultIVR['list'] as $key => $value) {
                $IVR = new ivr_operation();
                $result_getIVR = $IVR->getIVRListById($value['ivr_id']);

                if($result_getIVR['result']==1) {
                    $result['list']['ivr'][$value['ivr_id']]['name'] = $IVR->ivrInfo['Ivr_Name'];
                }
            }
            $result['label']['ivr'] = ModelQUEUE_19;
        }

        /////////end checkIvrTrashDependency/////////
        if($found == 1) {
            $this->exportType = 'html';
            $this->fileName = 'queue.show.php';
            $this->showAllQueues('', '', $result);
            die();
        }

        $operation = new queue_operation();
        $result = $operation->deleteQueue($queueID);


        if ($result['result'] == -1) {
            return $result;
        } else {
            $msg = ModelQUEUE_20;
            redirectPage(RELA_DIR . "queue.php", $msg);
        }
        die();
    }

    /**
     * Add extension form
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function getAllDstOption()
    {
        global $conn, $lang;
        include_once(ROOT_DIR . "component/dstOption.operation.class.php");
        $operation = new dstOption_operation();
        $result = $operation->getDstOptionList();

        if($result['result'] != 1) {
            return $result['msg'];
        }

        return $operation->dstOptionList;
    }

    /**
     * Checks if extensions exists based on comp ID
     * @param $queueID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function checkAnnounceDependency($queueID)
    {
        $operation = new queue_operation();
        $result = $operation->checkAnnounceDependency($queueID);
        return $result;
    }

    /**
     * Checks if extensions exists based on comp ID
     * @param $queueID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function checkInboundDependency($queueID)
    {
        $operation = new queue_operation();
        $result = $operation->checkInboundDependency($queueID);
        return $result;
    }

    /**
     * Checks if extensions exists based on comp ID
     * @param $queueID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function checkIvrDependency($queueID)
    {
        $operation = new queue_operation();
        $result = $operation->checkIvrDependency($queueID);
        return $result;
    }

}

