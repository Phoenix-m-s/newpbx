<?php

class groupSchedule extends DataBase
{
    private $_schedule;
    private $_group;

    /**
     * explain : construct of class
     */
    public function __construct() {

        $this->$_group = array(
            'schedule_group_id',
            'schedule_group_name',
            'status'
        );

        $this->$_schedule = array(
            'id',
            'schedule_group_id',
            'weekday' => array(),
            'start_time' => array(),
            'end_time' => array(),
            'start_except_time' => array(),
            'end_except_time' => array()
        );

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

            case 'addGroupScheduleInfo' :
                $this->_set_addGroupScheduleInfo($value);
                break;

            case 'editScheduleInfo' :
                $this->_set_editScheduleInfo($value);
                break;

            case 'addGroupInfo' :
                $this->_set_addGroupInfo($value);
                break;

            case 'editGroupInfo' :
                $this->_set_editGroupInfo($value);
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
            $_Result['Msg'] = ModelADMIN_46;
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
    private function _set_Arguments()
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
                    $_Result['errMsg'] = ModelADMIN_47;
                    return $_Result;
                }

            }
            else {
                $_Result[0] = -1;
                $_Result['errMsg'] = ModelADMIN_47;
                return $_Result;
            }

            $_Result[0] = 1;
            $_Result['Msg'] = ModelADMIN_49;
            return $_Result;

        }
        else
        {
            $_Result[0] = 0;
            $_Result['Msg'] = ModelADMIN_50;
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
     * explain : set add group properties
     * @author f.vosoughi
     * @version 01.01.01
     * @date 10/28/2014
     */
    private function _set_addGroupInfo($params) {
        $scheduleGroupName = handleData($params['scheduleGroupName']);
        $status = handleData($params['status']);

        $this->_group['schedule_group_name'] = $scheduleGroupName;
        $this->_group['status'] = $status;

    }

    /**
     * explain : set add group schedule properties
     * @author f.vosoughi
     * @version 01.01.01
     * @date 10/29/2014
     */
    private function _set_addGroupScheduleInfo($params) {
        $groupId = handleData($params['groupId']);
        $weekday = $params['weekday'];
        $startTime = $params['startTime'];
        $stopTime = $params['stopTime'];
        $startExTime = $params['startExTime'];
        $stopExTime = $params['stopExTime'];

        $this->_schedule['schedule_group_id'] = $groupId;
        $this->_schedule['weekday'] = $weekday;
        $this->_schedule['start_time'] = $startTime;
        $this->_schedule['end_time'] = $stopTime;
        $this->_schedule['start_except_time'] = $startExTime;
        $this->_schedule['end_except_time'] = $stopExTime;

    }

    /**
     * explain : set edit schedule properties
     * @param $params
     * @author f.vosoughi
     * @version 01.01.01
     * @date 10/29/2014
     */
    private function _set_editScheduleInfo($params) {
        $id = handleData($params['id']);
        $groupId = handleData($params['groupId']);
        $weekday = $params['weekday'];
        $startTime = $params['startTime'];
        $stopTime = $params['stopTime'];
        $startExTime = $params['startExTime'];
        $stopExTime = $params['stopExTime'];

        $this->_schedule['id'] = $id;
        $this->_schedule['schedule_group_id'] = $groupId;
        $this->_schedule['weekday'] = $weekday;
        $this->_schedule['start_time'] = $startTime;
        $this->_schedule['end_time'] = $stopTime;
        $this->_schedule['start_except_time'] = $startExTime;
        $this->_schedule['end_except_time'] = $stopExTime;

    }

    /**
     * explain : set edit group properties
     * @author f.vosoughi
     * @version 01.01.01
     * @date 10/28/2014
     */
    private function _set_editGroupInfo($params) {
        $GroupIdEdit = handleData($params['GroupIdEdit']);
        $GroupNameEdit = handleData($params['GroupNameEdit']);
        $GroupStatusEdit = handleData($params['GroupStatusEdit']);

        $this->_group['schedule_group_id'] = $GroupIdEdit;
        $this->_group['schedule_group_name'] = $GroupNameEdit;
        $this->_group['status'] = $GroupStatusEdit;
    }

    /**
     * explain : Show Group Schedule List
     * @return mixed
     * @author f.vosoughi
     * @version 01.01.01
     * @date 10/28/2014
     */
    public function groupScheduleList() {

        $conn = parent::getConnection();

        $groupSchedule = array();

        $sql = "SELECT  schedule_group_id   as scheduleGroupID,
                        schedule_group_name as scheduleGroupName,
                        status              as Status

                FROM    `schedule_group` WHERE 1";

        $rs = $conn->query($sql);

        if(!$rs)
        {
            print_r($conn->errorInfo());
            die();
        }

        $obj = $rs->fetchAll(PDO::FETCH_ASSOC);

        foreach( $obj as $v )
        {
            $groupSchedule[$v['scheduleGroupID']] = $v;
        }

        $result['groupSchedule'] = $groupSchedule;
        return $result;
    }

    /**
     * explain : Show Group Schedule edit page
     * @return mixed
     * @author f.vosoughi
     * @version 01.01.01
     * @date 10/28/2014
     */
    private function _editGroup() {
        global $messageStack;
        $conn = parent::getConnection();

        // if status = 0 (inactive) => check campaign
        if ($this->_group['status'] == 0 || $this->_group['status'] == '0') {

            $sql = "SELECT COUNT(*) FROM `required_camp` WHERE
                `schedule_group_id` = ".$this->_group['schedule_group_id']."";

            $row = $conn->query($sql);

            if ($row->fetchColumn() > 0) {
                $messageStack->add_session('groupSchedule',ModelADMIN_51, 'error');
                redirectPage(RELA_DIR."groupSchedule.php","");
                die();
            }
        }

        $sql = "UPDATE `schedule_group`
                SET `schedule_group_name`= '".$this->_group['schedule_group_name']."',
                    `status`= ".$this->_group['status']."
                    WHERE `schedule_group_id` = ".$this->_group['schedule_group_id']."";

        $rs = $conn->query($sql);

        if(!$rs)
        {
            print_r($conn->errorInfo());
            die();
        }

        redirectPage(RELA_DIR."groupSchedule.php","");
    }

    /**
     * explain : Add Group Schedule
     * @return mixed
     * @author f.vosoughi
     * @version 01.01.01
     * @date 10/28/2014
     */
    private function _addGroup() {
        $conn = parent::getConnection();

        $sql = "INSERT INTO `schedule_group`(`schedule_group_name`, `status`)
                VALUES ('".$this->_group['schedule_group_name']."',".$this->_group['status'].")";

        $rs = $conn->exec($sql);

        if(!$rs)
        {
            print_r($conn->errorInfo());
            die();
        }

        redirectPage(RELA_DIR."groupSchedule.php","");
    }



    /**
     * explain : Show Schedule List
     * @return mixed
     * @author f.vosoughi
     * @version 01.01.01
     * @date 10/29/2014
     */
    public function showSchedule($id) {
        $conn = parent::getConnection();
        $schedule = array();

        $sql = "SELECT * FROM `schedule` WHERE `schedule_group_id` = ".$id."";

        $scheduleRS = $conn->query($sql);

        if(!$scheduleRS)
        {
            print_r($conn->errorInfo());
            die();
        }

        $obj = $scheduleRS->fetchAll(PDO::FETCH_ASSOC);

        foreach( $obj as $value )
        {
            $schedule[$value['id']]['schedule_group_id'] = $value['schedule_group_id'];
            $schedule[$value['id']]['weekday'] = $value['weekday'];
            $schedule[$value['id']]['start_time'] = $value['start_time'];
            $schedule[$value['id']]['end_time'] = $value['end_time'];
            $schedule[$value['id']]['start_except_time'] = $value['start_except_time'];
            $schedule[$value['id']]['end_except_time'] = $value['end_except_time'];
        }
        $result['schedule'] = $schedule;
        $result['scheduleGroupId'] = $id;
        return $result;
    }

    /**
     * explain : add to s table
     * @return bool
     * @author f.vosoughi
     * @date 10/29/2014
     * @version 01.01.01
     */
    private function _addGroupSchedule() {
        global $messageStack;
        $conn = parent::getConnection();

        for ($i=0; $i < count($this->_schedule['weekday']); $i++) {

            // First Condition => (Conflict Time)
            for ($j=0; $j < count($this->_schedule['weekday']); $j++) {

                // If weekdays are same
                if ($i != $j) {
                    if ($this->_schedule['weekday'][$i] == $this->_schedule['weekday'][$j]) {

                        // If Second start time have been between First start and end time (Conflict Time) (1)
                        if ((strtotime($this->_schedule['start_time'][$i]) <= strtotime($this->_schedule['start_time'][$j])) && (strtotime($this->_schedule['start_time'][$j]) <= strtotime($this->_schedule['end_time'][$i]))) {

                            $messageStack->add_session('groupSchedule',ModelADMIN_52, 'error');
                            redirectPage(RELA_DIR."groupSchedule.php?action=showAddSchedule&id=".$this->_schedule['schedule_group_id'],"");
                            die();
                        }
                    }
                }

            }


            // start with validator => 2 step
            $sql = "SELECT * FROM `schedule`
                    WHERE `schedule_group_id` = ".$this->_schedule['schedule_group_id']."";

            $scheduleRS = $conn->query($sql);

            if(!$scheduleRS)
            {
                print_r($conn->errorInfo());
                die();
            }

            $schedulesArrayObj = $scheduleRS->fetchAll(PDO::FETCH_OBJ);

            $startTime   = $this->_schedule['start_time'][$i];
            $stopTime    = $this->_schedule['end_time'][$i];
            $startTimeEx = $this->_schedule['start_except_time'][$i];
            $stopTimeEx  = $this->_schedule['end_except_time'][$i];

            // check database for conflict (2)
            foreach ($schedulesArrayObj as $value) {
                if ($value->weekday == $this->_schedule['weekday'][$i]) {
                    if ((strtotime($value->start_time) <= strtotime($startTime)) && (strtotime($startTime) <= strtotime($value->end_time))) {

                        $messageStack->add_session('groupSchedule',ModelADMIN_53, 'error');
                        redirectPage(RELA_DIR."groupSchedule.php?action=showAddSchedule&id=".$this->_schedule['schedule_group_id'],"");
                        die();
                    }
                }
            }

            // check valid input in start and stop
            $validInput = $this->_checkValidInput($startTime,$stopTime);

            if (!$validInput) {
                $messageStack->add_session('groupSchedule',ModelADMIN_54, 'error');
                redirectPage(RELA_DIR."groupSchedule.php?action=showAddSchedule&id=".$this->_schedule['schedule_group_id'],"");
                die();
            }

            // validator => (check expire time have been between on start and stop time)
            $this->_checkExBetweenTime($startTime,$stopTime,$startTimeEx,$stopTimeEx,'add');


            // insert into the schedule
            $sql = "INSERT INTO `schedule`(`schedule_group_id`, `weekday`, `start_time`, `end_time`, `start_except_time`, `end_except_time`)
                                VALUES (".$this->_schedule['schedule_group_id'].",'".$this->_schedule['weekday'][$i]."',
                                        '".$startTime."','".$stopTime."',
                                        '".$startTimeEx."','".$stopTimeEx."')";

            $scheduleRS = $conn->exec($sql);

            if(!$scheduleRS)
            {
                print_r($conn->errorInfo());
                die();
            }

        }

        redirectPage(RELA_DIR."groupSchedule.php?action=showSchedule&id=".$this->_schedule['schedule_group_id'],"");
    }

    /**
     * @param $id
     * @param $groupId
     * explain : delete schedule table
     * @return bool
     * @author f.vosoughi
     * @date 10/30/2014
     * @version 01.01.01
     */
    public function deleteSchedule($id,$groupId) {
        $conn = parent::getConnection();

        $sql = "DELETE FROM `schedule` WHERE `id` = ".$id."";

        $scheduleRS = $conn->exec($sql);

        if(!$scheduleRS)
        {
            print_r($conn->errorInfo());
            die();
        }

        redirectPage(RELA_DIR."groupSchedule.php?action=showSchedule&id=".$groupId,"");
    }

    /**
     * @param $id
     * @return mixed
     * explain : show edit schedule page
     * @return bool
     * @author f.vosoughi
     * @date 10/30/2014
     * @version 01.01.01
     */
    public function showEditSchedule($id,$groupId) {
        $conn = parent::getConnection();

        $sql = "SELECT * FROM `schedule` WHERE `id` = ".$id."";

        $scheduleRS = $conn->query($sql);

        if(!$scheduleRS)
        {
            print_r($conn->errorInfo());
            die();
        }

        $obj = $scheduleRS->fetch(PDO::FETCH_ASSOC);

        $schedule['schedule_group_id'] = $obj['schedule_group_id'];
        $schedule['weekday'] = $obj['weekday'];
        $schedule['start_time'] = $obj['start_time'];
        $schedule['end_time'] = $obj['end_time'];
        $schedule['start_except_time'] = $obj['start_except_time'];
        $schedule['end_except_time'] = $obj['end_except_time'];

        $result['schedule'] = $schedule;
        $result['id'] = $obj['id'];
        $result['groupId'] = $groupId;
        return $result;
    }

    /**
     * explain : edit group schedule
     * @author faridcs
     * @date 12/16/2014
     * @version 01.01.01
     */
    private function _editSchedule() {
        global $messageStack;

        $conn = parent::getConnection();

        $startTime   = $this->_schedule['start_time'];
        $stopTime    = $this->_schedule['end_time'];
        $startTimeEx = $this->_schedule['start_except_time'];
        $stopTimeEx  = $this->_schedule['end_except_time'];

        // database validator
        $sql = "SELECT * FROM `schedule`
                    WHERE `schedule_group_id` = ".$this->_schedule['schedule_group_id']."";

        $scheduleRS = $conn->query($sql);

        if(!$scheduleRS)
        {
            print_r($conn->errorInfo());
            die();
        }

        $schedulesArrayObj = $scheduleRS->fetchAll(PDO::FETCH_OBJ);

        // check database for conflict
        foreach ($schedulesArrayObj as $value) {
            if ($value->weekday == $this->_schedule['weekday']) {
                if ($this->_schedule['id'] != $value->id) {
                    if ((strtotime($value->start_time) <= strtotime($startTime)) && (strtotime($startTime) <= strtotime($value->end_time))) {

                        $messageStack->add_session('groupSchedule',ModelADMIN_55, 'error');
                        redirectPage(RELA_DIR."groupSchedule.php?action=showEditSchedule&id=".$this->_schedule['id']."&groupId=".$this->_schedule['schedule_group_id'],"");
                        die();
                    }
                }
            }
        }

        // check valid time
        $this->_checkExBetweenTime($startTime,$stopTime,$startTimeEx,$stopTimeEx,'edit');

        $sql = "UPDATE `schedule` SET `weekday`= ".$this->_schedule['weekday'].",
                                      `start_time`= '".$startTime."',
                                      `end_time`= '".$stopTime."',
                                      `start_except_time`= '".$startTimeEx."',
                                      `end_except_time`= '".$stopTimeEx."'
                WHERE `id` = ".$this->_schedule['id']."";

        $scheduleRS = $conn->prepare($sql);

        $scheduleRS = $scheduleRS->execute();

        if(!$scheduleRS)
        {
            print_r($conn->errorInfo());
            die();
        }

        redirectPage(RELA_DIR."groupSchedule.php?action=showSchedule&id=".$this->_schedule['schedule_group_id'],"");
    }

    /**
     * explain : check valid exception (Must Be between start and stop time)
     * @param $startTime
     * @param $stopTime
     * @param $startTimeEx
     * @param $stopTimeEx
     * @param $method (add or edit)
     * @author faridcs
     * @date 12/16/2014
     * @version 01.01.01
     */
    private function _checkExBetweenTime($startTime,$stopTime,$startTimeEx,$stopTimeEx,$method) {
        global $messageStack;

        // check 4 condition
        // 1 => start and stop exception are lesser than start time
        // 2 => start and stop exception are bigger than stop time
        // 3 => start exception is lesser than start time and stop exception is between times
        // 4 => stop exception is bigger than stop time and stop exception is between times
        if (
            ((strtotime($startTime) > strtotime($startTimeEx)) && (strtotime($startTime) > strtotime($stopTimeEx))) ||
            ((strtotime($stopTime)  < strtotime($startTimeEx)) && (strtotime($stopTime)  < strtotime($stopTimeEx))) ||
            ((strtotime($startTime) > strtotime($startTimeEx)) && ((strtotime($startTime) < strtotime($stopTimeEx)) && (strtotime($stopTimeEx)  < strtotime($stopTime)))) ||
            ((strtotime($stopTime)  < strtotime($stopTimeEx))  && ((strtotime($startTime) < strtotime($startTimeEx)) && (strtotime($startTimeEx)  < strtotime($stopTime))))
        ) {

            if ($method == 'add') {
                $messageStack->add_session('groupSchedule',ModelADMIN_56, 'error');
                redirectPage(RELA_DIR."groupSchedule.php?action=showAddSchedule&id=".$this->_schedule['schedule_group_id'],"");
                die();
            } elseif ($method == 'edit') {

                $messageStack->add_session('groupSchedule',ModelADMIN_56, 'error');
                redirectPage(RELA_DIR."groupSchedule.php?action=showEditSchedule&id=".$this->_schedule['id']."&groupId=".$this->_schedule['schedule_group_id'],"");
                die();
            }

        }
    }

    /**
     * check valid input (Start Time Must Be letter than Stop Time)
     *
     * @param $startTime
     * @param $stopTime
     * @return bool
     * @author faridcs
     * @date 12/20/2014
     * @version 01.01.01
     */
    private function _checkValidInput($startTime,$stopTime) {

        if ($startTime > $stopTime) {
            return false;
        } else {
            return true;
        }
    }
}