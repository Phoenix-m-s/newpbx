<?php
/**
 * Created by PhpStorm.
 * User: FaridCS
 * Date: 11/1/2014
 * Time: 2:40 PM
 */

class campaign extends DataBase
{
    private $_campaign;
    private $_file;
    private $_tempArr;

    /**
     * explain : construct of class
     */
    public function __construct() {

        $this->$_campaign = array(
            'id',
            'schedule_group_id',
            'name',
            'status',
            'pre_number',
            'fromNum',
            'toNum',
            'camp_extentions',
            'start_date ',
            'end_date',
            'isenable',
            'creation_type',
            'chann_no',
            'numberListType'
        );

        $this->_file = array(
            'name'      => '',
            'error'     => '',
            'tmp_name'  => '',
            'type'      => '',
            'size'      => ''
        );

        $this->_tempArr = array();

    }

    /**
     * @param $property
     * @param $value
     * @return bool
     * @date 10/28/2014
     * @author f.vosoughi
     * @version 01.01.01
     */
    public function __set($property,$value) {
        switch ($property) {

            case 'addCampaignFiles' :
                $this->_set_addCampaignFiles($value);
                break;

            case 'addCampaignInfo' :
                $this->_set_addCampaignInfo($value);
                break;

            default :
                return false;
        }
    }

    /**
     * explain : call magic function of customer class
     * @param $methodName
     * @param $arguments
     * @return mixed
     */
    public function __call($methodName,$arguments)
    {
        $_Result = $this->_checkMethod($methodName);
        if($_Result[0]==1)
        {
            $_Result = $this->_set_Arguments($arguments);
            if($_Result[0]==1 || $_Result[0]==0)
            {
                $methodName = '_'.$methodName;
                $Result = $this->$methodName();
                return($Result);
                die();
            }
            elseif($_Result[0]==-1)
            {
                redirectPage(RELA_DIR.'index.php',$_Result['errMsg']);
                die();
            }
        }
        elseif($_Result[0]==0)
        {
            redirectPage(RELA_DIR.'index.php',$_Result['errMsg']);
            die();
        }
    }


    /**
     * @return mixed
     */
    private function _checkMethod()
    {
        $temp = func_get_args();
        if(method_exists($this,"_".$temp[0]))
        {
            $_Result[0] = 1;
            $_Result['Msg'] = ModelADMIN_29;
        }
        else
        {
            $_Result[0] = 0;
            $_Result['errMsg'] = "The Method (".$temp[0].") that you call is wrong";// For Test : The Method (".$temp[0].") that you call is wrong
        }
        return $_Result;
    }

    /**
     * @return mixed
     */
    private function _set_Arguments($arguments)
    {

        $temp = func_get_args();
        if(!empty($temp[0]))
        {
            if(count($temp[0])==1)
            {
                if(!empty($temp[0][0]))
                {
                    $this->_Arguments = handleData($temp[0][0]);
                }
                else
                {
                    $_Result[0] = -1;
                    $_Result['errMsg'] = ModelADMIN_31;
                    return $_Result;
                }

            }
            else {
                $_Result[0] = -1;
                $_Result['errMsg'] = ModelADMIN_31;
                return $_Result;
            }

            $_Result[0] = 1;
            $_Result['Msg'] = ModelADMIN_33;
            return $_Result;

        }
        else
        {
            $_Result[0] = 0;
            $_Result['Msg'] = ModelADMIN_34;
            return $_Result;
        }
    }

    /**
     * @param $property
     * @return mixed
     * @date 10/28/2014
     * @author f.vosoughi
     * @version 01.01.01
     */
    public function __get($property) {
        if (property_exists($this,$property)) {
            return $this->$property;
        } else {
            return false;
        }
    }

    /**
     * set file campaign property
     */
    private function _set_addCampaignFiles() {
        $temp = func_get_args();
        $temp = $temp[0];

        if(!empty($temp['name'])) {
            $this->_file['name']        = handleData($temp['name']);
            $this->_file['type']        = handleData($temp['type']);
            $this->_file['tmp_name']    = $temp['tmp_name'];
            $this->_file['size']        = handleData($temp['size']);
            $this->_file['error']       = handleData($temp['error']);
        }

    }

    /**
     * explain : set add group schedule properties
     * @param $params
     * @author f.vosoughi
     * @version 01.01.01
     * @date 10/29/2014
     */
    private function _set_addCampaignInfo($params) {
//        echo "<pre>";
//        print_r($params);
//        die();
        global $messageStack;

        $campId = handleData($params['campId']);
        $campaignName = handleData($params['campaignName']);
        $DSTOption = handleData($params['DSTOption']);
        $subDSTOption = handleData($params['dst_option_sub_id']);
        switch($DSTOption){
            case '2':
                $DST = 'Queue';
                include_once(ROOT_DIR . "component/queue.operation.class.php");
                $operation = new queue_operation();
                $result = $operation->getQueueListById($subDSTOption);

                if($result['result']==-1)
                {
                    return $result['msg'];
                }

                $subDST =$operation->queueInfo;
                break;
            case '3':
                $DST = 'Extension';
                include_once(ROOT_DIR . "component/extension.operation.class.php");
                $operation = new extension_operation();
                $result = $operation->getExtensionListById($subDSTOption);

                if($result['result']==-1)
                {
                    return $result['msg'];
                }

                $subDST =$operation->extensionInfo;
            break;
            case '4':
                $DST = 'Announce';
                include_once(ROOT_DIR . "component/announce.operation.class.php");
                $operation = new announce_operation();
                $result = $operation->getAnnounceListById($subDSTOption);

                if($result['result']==-1)
                {
                    return $result['msg'];
                }

                $subDST =$operation->announceInfo;
            break;
            case '5':
                $DST = 'IVR';
                include_once(ROOT_DIR . "component/ivr.operation.class.php");
                $operation = new ivr_operation();
                $result = $operation->getIVRListById($subDSTOption);

                if($result['result']==-1)
                {
                    return $result['msg'];
                }

                $subDST =$operation->ivrInfo;
            break;
            case '6':
                $DST = 'VoiceMail';
                include_once(ROOT_DIR . "component/extension.operation.class.php");
                $operation = new extension_operation();
                $result = $operation->getExtensionListById($subDSTOption);

                if($result['result']==-1)
                {
                    return $result['msg'];
                }

                $subDST =$operation->extensionInfo;
            break;

        }

        $extensionNumber = handleData($params['extensionNumber']);
        $sipName = handleData($params['sip_id']);

        $channelNumber = handleData($params['channelNumber']);
        $scheduleGroup = handleData($params['scheduleGroup']);
        $numberListType = handleData($params['numberListType']);
        $prefixNum = handleData($params['prefixNum']);
        $fromNum = handleData($params['fromNum']);
        $toNum = handleData($params['toNum']);

        $startDate = $params['startDate'];
        $stopDate = $params['stopDate'];

        $this->_campaign['id'] = $campId;
        $this->_campaign['name'] = $campaignName;
        $this->_campaign['camp_extentions'] = $extensionNumber;
        $this->_campaign['sip_name'] = $sipName;
        $this->_campaign['DSTOption'] = $DST;
        $this->_campaign['subDSTOption'] = $subDST;
        $this->_campaign['chann_no'] = $channelNumber;
        $this->_campaign['schedule_group_id'] = $scheduleGroup;
        $this->_campaign['numberListType'] = $numberListType;
        $this->_campaign['start_date'] = $startDate;
        $this->_campaign['end_date'] = $stopDate;

        if ((isset($this->_campaign['numberListType'])) && (!empty($this->_campaign['numberListType'])) && ($this->_campaign['numberListType'] != 'importTextFile')) {

            // check valid input
            if (ctype_digit($prefixNum)) {

                $this->_campaign['pre_number'] = $prefixNum;
            } else {
                $messageStack->add_session('campaign',ModelADMIN_35, 'error');
                redirectPage(RELA_DIR."campaign.php?action=showAddCamp","");
                die();
            }

            // check valid input
            if (ctype_digit($fromNum)) {

                $this->_campaign['fromNum'] = $fromNum;
            } else {
                $messageStack->add_session('campaign',ModelADMIN_36, 'error');
                redirectPage(RELA_DIR."campaign.php?action=showAddCamp","");
                die();
            }

            // check valid input
            if (ctype_digit($fromNum)) {

                $this->_campaign['toNum'] = $toNum;
            } else {
                $messageStack->add_session('campaign',ModelADMIN_37, 'error');
                redirectPage(RELA_DIR."campaign.php?action=showAddCamp","");
                die();
            }

        }

    }

    /**
     * explain : Show Campaigns List
     * @return mixed
     * @author f.vosoughi
     * @version 01.01.01
     * @date 11/1/2014
     */
    public function campList() {
        $conn  = parent::getConnection();
        $camp  = array();
        $group = array();

        $sql = "SELECT `id` as campID,
                       `name` as name,
                       `status` as status,
                       `pre_number` as prefixNumber,
                       `camp_extentions` as campExtensions,
                       `start_date` as startDate,
                       `end_date` as endDate,
                       `isenable` as isEnable,
                       `creation_type` as creationType,
                       `creation_type` as creationType,
                       `chann_no` as chanelNumber,
                       `schedule_group_id` as scheduleGroupId
                  FROM `required_camp` WHERE 1";

        $rs = $conn->query($sql);

        if(!$rs)
        {
            print_r($conn->errorInfo());
            die();
        }

        $obj = $rs->fetchAll(PDO::FETCH_ASSOC);

        foreach( $obj as $v )
        {
            $camp[$v['campID']] = $v;
        }

        // get schedule group
        $sql = "SELECT * FROM `schedule_group`";

        $scheduleGroupRS = $conn->query($sql);

        if(!$scheduleGroupRS)
        {
            print_r($conn->errorInfo());
            die();
        }

        $scheduleGroup = $scheduleGroupRS->fetchAll(PDO::FETCH_ASSOC);

        foreach( $scheduleGroup as $value )
        {
            $group[$value['schedule_group_id']]['name'] = $value['schedule_group_name'];
        }

        $result['campaigns'] = $camp;
        $result['group'] = $group;
//        echo "<pre>";
//        print_r($result);
        return $result;
    }

    /**
     * explain : show add campaign page
     * @return mixed
     * @author f.vosoughi
     * @version 01.01.01
     * @date 11/2/2014
     */
    public function showAddCamp() {
        $conn = parent::getConnection();
        $camp = array();

        $sql = "SELECT * FROM `schedule_group`
                WHERE `status` = 1";

        $rs = $conn->query($sql);

        if(!$rs)
        {
            print_r($conn->errorInfo());
            die();
        }

        $obj = $rs->fetchAll(PDO::FETCH_ASSOC);

        foreach( $obj as $v )
        {
            $camp[$v['schedule_group_id']]['name'] = $v['schedule_group_name'];
        }

        $result['campaigns'] = $camp;
        return $result;
    }

    /**
     * explain : show edit campaign page
     * @param $id
     * @return mixed
     * @author f.vosoughi
     * @version 01.01.01
     * @date 12/22/2014
     */
    public function showEditCamp($id) {
        $conn  = parent::getConnection();
        $camp  = array();
        $group = array();

        $sql = "SELECT * FROM `required_camp` WHERE `id` = ".$id."";
        $sql = "SELECT `id` as campID,
                       `name` as name,
                       `status` as status,
                       `pre_number` as prefixNumber,
                       `camp_extentions` as campExtensions,
                       `start_date` as startDate,
                       `end_date` as endDate,
                       `isenable` as isEnable,
                       `creation_type` as creationType,
                       `creation_type` as creationType,
                       `chann_no` as chanelNumber,
                       `schedule_group_id` as scheduleGroupId
                  FROM `required_camp` WHERE `id` = ".$id."";

        $rs = $conn->query($sql);

        if(!$rs)
        {
            print_r($conn->errorInfo());
            die();
        }

        $camp = $rs->fetch(PDO::FETCH_ASSOC);

        // get schedule group
        $sql = "SELECT * FROM `schedule_group` WHERE `status` = 1";

        $scheduleGroupRS = $conn->query($sql);

        if(!$scheduleGroupRS)
        {
            print_r($conn->errorInfo());
            die();
        }

        $scheduleGroup = $scheduleGroupRS->fetchAll(PDO::FETCH_ASSOC);

        foreach( $scheduleGroup as $value )
        {
            $group[$value['schedule_group_id']]['name'] = $value['schedule_group_name'];
        }

        $result['campaigns'] = $camp;
        $result['group'] = $group;
        return $result;
    }

    /**
     * explain : Insert into the campaign and number tables for definition campaign
     * @return bool
     * @author f.vosoughi
     * @version 01.01.01
     * @date 11/5/2014
     */
    private function _addCampaign() {
//        echo "<pre>";
//        print_r($this->_campaign['start_date']);
//        die();
        global $messageStack;
        $conn = parent::getConnection();

        // If Insert number Is Text File
        if ($this->_campaign['numberListType'] == 'importTextFile') {
            $sql = "INSERT INTO `required_camp`(`name`, `camp_extentions`,`option_id`,`sip_trunk`, `start_date`, `end_date`, `creation_type`, `chann_no`, `schedule_group_id`)
                    VALUES ('".$this->_campaign['name']."','".$this->_campaign['camp_extentions']."', '".$this->_campaign['DSTOption']."', '".$this->_campaign['sip_name']."',
                            '".$this->_campaign['start_date']."','".$this->_campaign['end_date']."',
                            '".$this->_campaign['numberListType']."','".$this->_campaign['chann_no']."',
                            '".$this->_campaign['schedule_group_id']."')";

            $stmt = $conn->prepare($sql);

            try {
                $stmt->execute();
                // get last insert id
                $lastId = $conn->lastInsertId();

            } catch(PDOExecption $e) {

                print "Error!: " . $e->getMessage() . "</br>";
            }

            // open text file
            $fp = fopen($this->_file['tmp_name'], 'rb');
            while ( ($line = fgets($fp)) !== false) {

                try {

                    // checked Number in BlackList
                    $sql = "SELECT `id` FROM `blacklist` WHERE `number` = ".$line." AND `isblack` = 't'";

                    $stmt2 = $conn->query($sql);
                    $result = $stmt2->fetch(PDO::FETCH_OBJ);

                    if (true) {//empty($result->id)
                        $sql = "INSERT INTO `numbers`(`black_list`, `camp_id`, `number`, `creation_time`) VALUES
                        ('f','".$lastId."','".handleData($line)."',NOW())";

                        $stmt1 = $conn->prepare($sql);

                        $stmt1->execute();
                    } else {
                        $sql = "INSERT INTO `numbers`(`black_list`, `camp_id`, `number`, `creation_time`) VALUES
                        ('t','".$lastId."','".handleData($line)."',NOW())";

                        $stmt1 = $conn->prepare($sql);

                        $stmt1->execute();
                    }


                } catch(PDOExecption $e) {

                    print "Error!: " . $e->getMessage() . "</br>";
                }
            }

            $messageStack->add_session('campaign',ModelADMIN_38, 'success');
            redirectPage(RELA_DIR."campaign.php","");

        } else {

            $sql = "INSERT INTO `required_camp`(`name`, `pre_number`, `camp_extentions`,`option_id`,`sip_trunk`,`start_date`, `end_date`, `creation_type`, `chann_no`, `schedule_group_id`)
                    VALUES ('".$this->_campaign['name']."','".$this->_campaign['pre_number']."','".$this->_campaign['camp_extentions']."', '".$this->_campaign['DSTOption']."', '".$this->_campaign['sip_name']."',
                            '".$this->_campaign['start_date']."','".$this->_campaign['end_date']."',
                            '".$this->_campaign['numberListType']."','".$this->_campaign['chann_no']."',
                            '".$this->_campaign['schedule_group_id']."')";

            $stmt = $conn->prepare($sql);

            try {
                $stmt->execute();

                // get last insert id
                $lastId = $conn->lastInsertId();

            } catch(PDOExecption $e) {

                print "Error!: " . $e->getMessage() . "</br>";
            }

            $from = $this->_campaign['pre_number'].$this->_campaign['fromNum'];
            $to = $this->_campaign['pre_number'].$this->_campaign['toNum'];
            

            // checked Number in BlackList
            for ($i = $from; $i <= $to; $i++) {

                try {

                    $sql = "SELECT `id` FROM `blacklist` WHERE `number` = '".$i."' AND `isblack` = 't'";

                    $stmt2 = $conn->query($sql);
                    $result = $stmt2->fetch(PDO::FETCH_OBJ);

                    if (empty($result->id)) {
                        $sql = "INSERT INTO `numbers`(`black_list`, `camp_id`, `number`, `creation_time`) VALUES
                        ('f','".$lastId."','".$i."',NOW())";

                        $stmt1 = $conn->prepare($sql);

                        $stmt1->execute();
                    } else {
                        $sql = "INSERT INTO `numbers`(`black_list`, `camp_id`, `number`, `creation_time`) VALUES
                        ('t','".$lastId."','".$i."',NOW())";

                        $stmt1 = $conn->prepare($sql);

                        $stmt1->execute();
                    }

                } catch(PDOExecption $e) {

                    print "Error!: " . $e->getMessage() . "</br>";
                }
            }

            $messageStack->add_session('campaign',ModelADMIN_38, 'success');
            redirectPage(RELA_DIR."campaign.php","");
        }

        return true;
    }

    /**
     * explain : enable campaign
     * @param $id
     * @author f.vosoughi
     * @version 01.01.01
     * @date 11/5/2014
     */
    public function enableCampaign($id) {
        $conn = parent::getConnection();

        $sql = "SELECT `isenable` FROM `required_camp` WHERE `id` = ".$id."";

        $rs = $conn->query($sql);

        if(!$rs)
        {
            print_r($conn->errorInfo());
            die();
        }

        $obj = $rs->fetch(PDO::FETCH_OBJ);

        if ($obj->isenable == 'y') {

            $sql = "UPDATE `required_camp` SET `isenable`= 'n' WHERE `id` = ".$id."";

            $stmt = $conn->prepare($sql);

            try {
                $stmt->execute();

            } catch(PDOExecption $e) {

                print "Error!: " . $e->getMessage() . "</br>";
            }
        } elseif ($obj->isenable == 'n') {

            $sql = "UPDATE `required_camp` SET `isenable`= 'y' WHERE `id` = ".$id."";

            $stmt = $conn->prepare($sql);

            try {
                $stmt->execute();

            } catch(PDOExecption $e) {

                print "Error!: " . $e->getMessage() . "</br>";
            }
        }

        redirectPage(RELA_DIR."campaign.php","");
    }

    /**
     * explain : delete campaign
     * @param $id
     * @author f.vosoughi
     * @version 01.01.01
     * @date 11/5/2014
     */
    public function deleteCampaign($id) {
        $conn = parent::getConnection();

        // delete campaign
        $sql = "DELETE FROM `required_camp` WHERE `id` = ".$id."";

        $stmt1 = $conn->prepare($sql);

        try {
            $stmt1->execute();
        } catch(PDOExecption $e) {
            print "Error!: " . $e->getMessage() . "</br>";
        }

        // delete numbers
        $sql = "DELETE FROM `numbers` WHERE `camp_id` = ".$id."";

        $stmt2 = $conn->prepare($sql);

        try {
            $stmt2->execute();
        } catch(PDOExecption $e) {
            print "Error!: " . $e->getMessage() . "</br>";
        }
        redirectPage(RELA_DIR."campaign.php","");
    }

    /**
     * explain : Running the campaign
     * @author f.vosoughi
     * @date 11/10/2014
     * @version 01.01.01
     */
    public function runCampaign() {
        global $messageStack;
        $conn = parent::getConnection();
        $camp = array();

        // check number call file in folder
        if ($this->_getTotalFileCount() >= TOTAL_CHANNEL) {
            $messageStack->add_session('campaign',ModelADMIN_40, 'error');
            redirectPage(RELA_DIR."campaign.php","");
            die();
        }

        // Get All campaign that is enabled
        $sql = "SELECT * FROM `required_camp`
                WHERE `isenable` = 'y'
                AND `status` != 'complete'
                ORDER BY `priority` ASC";

        $stmt = $conn->query($sql);

        if(!$stmt) {
            print_r($conn->errorInfo());
            die();
        }

        $result = $stmt->fetchAll(PDO::FETCH_OBJ);

        $sumChannelCamp = 0;
        foreach( $result as $value ) {

            // Check camp that it's schedules in current time
            $campValid = $this->checkGroupSchedule($value->schedule_group_id);

            if($campValid) {

                if($sumChannelCamp >= TOTAL_CHANNEL) {
                    break;
                }

                //get call file exist for this camp
                //$countFile number of campaign call file exists
                $countFile = $this->_getFileCount($value->id,$value->camp_extentions,"/var/spool/asterisk/outgoing");

                //$value->chann_no number of campaign Channel
                //$fileNeeded id channel number must be created
                //$sumChannelCamp sum of call file created for lasts campaign
                $fileNeeded = ($value->chann_no - $countFile);

                // check over channel if sum of channel campaigns are bigger than TOTAL channel
                if(($sumChannelCamp + $fileNeeded) > TOTAL_CHANNEL)
                {
                    $overChannel = ($sumChannelCamp + $fileNeeded) - TOTAL_CHANNEL;

                    $fileNeeded =  $fileNeeded - $overChannel;
                    if($fileNeeded == 0 )
                    {
                        break;
                    }
                }

                $sumChannelCamp += $fileNeeded;

                $camp[$value->id]['numberOfCallFileNeeded'] = $fileNeeded;
                $camp[$value->id]['campid'] = $campValid;
                $camp[$value->id]['channelNo'] = $value->chann_no;
                $camp[$value->id]['campExtention'] = $value->camp_extentions;

            }
            else {
                continue;
            }

        }

        // check camp list that isn't empty and sum of total channel isn't more than max_channel
        foreach ($camp as $campaignID=>$campaignValues) {

            if($campaignValues['numberOfCallFileNeeded']== 0)
            {
                continue;
            }


            $numbersList = $this->_getNumbers($campaignID,$campaignValues['campExtention'],$campaignValues['numberOfCallFileNeeded']);
            if($numbersList == 0) {
                //update campaign status to completed and disabled
                $this->_updateCampaignStatus($campaignID);
                continue;
            }

            $numberIDs = $this->_createCampaignCallFiles($campaignID,$numbersList,$campaignValues['campExtention']);

            // update call_status='callfile Created'
            $this->_updateNumbersStatus($numberIDs,'callfile Created');

            // check campaign for complete
            $resultVal = $this->_checkCampaign($campaignID);

            if ($resultVal == true) {
                $this->_updateCampaignStatus($campaignID);
            }

        }

        $this->_moveCampaignCallFiles();

       redirectPage(RELA_DIR."campaign.php","");
    }

    /**
     * explain : check valid camp
     * @param $scheduleGroupId
     * @return int
     * @author f.vosoughi
     * @date 11/11/2014
     * @version 01.01.01
     */
    private function checkGroupSchedule($scheduleGroupId) {
        $conn = parent::getConnection();
        $rs = array();

        // date("N") = 1 (for Monday) through 7 (for Sunday)
        $day = date("N") == 7 ? 1 : date("N")+1 ;

        $sql = "SELECT * FROM `schedule`
                WHERE `schedule_group_id` = ".$scheduleGroupId."
                AND `weekday` = ".$day."
                ";

        $stmt = $conn->query($sql);

        if(!$stmt)
        {
            print_r($conn->errorInfo());
            die();
        }

        $result = $stmt->fetchAll(PDO::FETCH_OBJ);

        // current time
        $time = date("H:m:s");

        $i = 0;
        foreach( $result as $value ) {

            // Check Start Time, Stop Time With Except Time

            if (
                ((strtotime($value->start_time) <= strtotime($time)) && (strtotime($time) <= strtotime($value->end_time)))
                &&
                !((strtotime($value->start_except_time) < strtotime($time)) && (strtotime($time) < strtotime($value->end_except_time)))
            ) {

                $rs[$i] = 1;

            } else {
                $rs[$i] = 0;

            }
            $i++;
        }

        if(in_array(1,$rs)) {
            return 1;
        } else {
            return 0;
        }

    }

    /**
     * explain : count the file of campaign
     * @param $camp_id
     * @param $extention
     * @param $dir
     * @return int
     * @author f.vosoughi
     * @date 11/11/2014
     * @version 01.01.01
     */
    private function _getFileCount($camp_id,$extention,$dir)
    {
        $filteredArray = array();

        foreach (glob($dir."/".$camp_id."_".$extention."_*.call") as $filename)
            $filteredArray[] = $filename;

        return count($filteredArray);

    }

    /**
     * explain : count total file of call_file folder
     * @author f.vosoughi
     * @date 11/11/2014
     * @version 01.01.01
     */
    private function _getTotalFileCount()
    {
        // integer starts at 0 before counting
        $i = 0;
        $dir = '/var/spool/asterisk/outgoing/';
        if ($handle = opendir($dir)) {
            while (($file = readdir($handle)) !== false){
                if (!in_array($file, array('.', '..')) && !is_dir($dir.$file))
                    $i++;
            }
        }

        return $i;
    }

    /**
     * explain : Get numbers of campaign
     * @param $campid
     * @param $extention
     * @param $limit
     * @return array|int
     * @author f.vosoughi
     * @date 11/11/2014
     * @version 01.01.01
     */
    private function _getNumbers($campid,$extention,$limit) {
        $conn = parent::getConnection();

        // Get All campaign that is enabled
        $numbersQuery = "SELECT  *
                        FROM    `numbers`
                        WHERE   `black_list`= 'f'
                        AND     `camp_id`   = '$campid'
                        AND     `call_status`     = 'Not called'
                        LIMIT   0,".$limit;

        $numbersResult = $conn->query($numbersQuery);

        if(!$numbersResult) {
            print_r($conn->errorInfo());
            die();
        }

        $numbersList = $numbersResult->fetchAll(PDO::FETCH_OBJ);

        if($numbersResult->rowCount()) {
            return $numbersList;
        } else {
            return 0;
        }

    }

    /**
     * explain : create campaign call file
     * @param $campid
     * @param $numbersList
     * @param $extention
     * @return string
     * @author f.vosoughi
     * @date 11/11/2014
     * @version 01.01.01
     */
    private function _createCampaignCallFiles($campid,$numbersList,$extention) {
        $number_ids = '';
        foreach($numbersList  as $numbersInf){
            $rs =  $this->createcallfile($campid,$numbersInf->number,$extention,$numbersInf->id);
            if($rs == '200')
            {
                //create update condition
                $number_ids .= $numbersInf->id.",";
            }
        }

        $number_ids = substr($number_ids,0,-1);

        return $number_ids;
    }

    /**
     * explain : update numbers status
     * @param $numberIDs
     * @param $status
     * @author f.vosoughi
     * @date 11/11/2014
     * @version 01.01.01
     */
    private function _updateNumbersStatus($numberIDs,$status) {

        $numberIn = "(".$numberIDs.")";

        $conn = parent::getConnection();
        // Get All campaign that is enabled
        $statusQuery = "UPDATE  numbers
                        SET    `call_status` = '$status',
                               `call_file_created` = NOW()
                        WHERE  `id` IN $numberIn ";

        $statusUpdateResult = $conn->exec($statusQuery);

        if(!$statusUpdateResult)
        {
            print_r($conn->errorInfo());
            die();
        }

    }

    /**
     * explain : create call file
     * @param $campid
     * @param $target_number
     * @param $extension
     * @param $phone_ID
     * @return int
     * @author f.vosoughi
     * @date 11/11/2014
     * @version 01.01.01
     */
    private function createcallfile($campid,$target_number,$extension,$phone_ID) {
        try{
            $file_dir_name =ROOT_DIR.'Call_File/'.$campid.'_'.$extension.'_' .$target_number.'.call';

            echo $file_dir_name;
            die('ghchkgcfhgc');
            $this->_tempArr[] = $campid.'_'.$extension.'_' .$target_number.'.call';

            $call_file = fopen($file_dir_name, 'w');

            $nowdateTime = date("Y-m-d H:i:s");

            fwrite($call_file,"Channel: SIP/"."11" . $target_number  .  $this->_campaign['sip_name']. "\n");
            fwrite($call_file,"Context: akbaricampaign" . "\n");
            fwrite($call_file,"Extension: " . 1000 . "\n");
            fwrite($call_file,"Set: dstExtension=" . $extension . "\n");
            fwrite($call_file,"Set: camp_id=" . $campid . "\n");
            fwrite($call_file,"Priority: 1" . "\n");

            fwrite($call_file,"CallerID: ".$extension."campaign<" . $target_number .">".  "\n");
            fwrite($call_file,"Set: nowdatetime=" . $nowdateTime . "\n");

            fwrite($call_file,"Set: Mobile=" . $target_number . "\n");
            fwrite($call_file,"Set: phone_id=" . $phone_ID . "\n");
            fwrite($call_file,"AlwaysDelete: yes" . "\n");
            fwrite($call_file,"Archive: Yes" . "\n");
            fwrite($call_file,"Status : Failed" . "\n");
            fclose($call_file);
            ///var/spool/asterisk/outgoing
            // shell_exec("mv " . $file_dir_name . " ".ROOT_DIR."Call_File");
            // shell_exec("mv " . $file_dir_name . " /root");


        }catch(Exception $e) {
            return 501;
        }

        return 200;
    }

    /**
     * explain : count all number it's status is 'Not called'
     * @param $campId
     * @return bool
     * @author f.vosoughi
     * @date 11/11/2014
     * @version 01.01.01
     */
    private function _checkCampaign($campId) {
        $conn = parent::getConnection();

        $sql = "SELECT * FROM `numbers`
                WHERE `camp_id` = ".$campId."
                AND `call_status` = 'Not called'";

        $result = $conn->query($sql);

        if(!$result)
        {
            print_r($conn->errorInfo());
            die();
        }

        $count = $result->rowCount();

        if ($count == 0) {
            return true;
        } else {
            return false;
        }

    }

    /**
     * explain : update camp status
     * @param $campId
     */
    private function _updateCampaignStatus($campId) {
        $conn = parent::getConnection();

        $sql = "UPDATE `required_camp`
                SET `status`= 'complete', `isenable` = 'n'
                WHERE `id` = ".$campId."";

        $result = $conn->exec($sql);

        if(!$result)
        {
            print_r($conn->errorInfo());
            die();
        }
    }

    /**
     * edit campaign information
     */
    private function _editCampaign() {
        $conn = parent::getConnection();

        $sql = "UPDATE `required_camp` SET `name`= '".$this->_campaign['name']."',`camp_extentions`= '".$this->_campaign['camp_extentions']."',
                `start_date`= '".$this->_campaign['start_date']."',`end_date`= '".$this->_campaign['end_date']."',
                `chann_no`= '".$this->_campaign['chann_no']."',`schedule_group_id`= '".$this->_campaign['schedule_group_id']."'
                WHERE `id` = '".$this->_campaign['id']."'";

        $result = $conn->exec($sql);

        if(!$result)
        {
//            print_r($conn->errorInfo());
            die();
        }

        redirectPage(RELA_DIR."campaign.php","");
    }

    private function _moveCampaignCallFiles() {

        // Identify directories
        $source = ROOT_DIR."Call_File/";
        $destination = "/var/spool/asterisk/outgoing/";
        //$destination = ROOT_DIR."Call_File1/";

        // Cycle through source files
        foreach ($this->_tempArr as $file) {


            if(!rename($source.$file, $destination.$file))
            {
                die('Move Error');
            }
        }

    }
}
