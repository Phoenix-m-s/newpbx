<?php

/**
 * @author Malekloo Izadi Sakhamanesh <Izadi@dabacenter.ir>
 * @version 0.0.1 this is the beta version of News
 * @copyright 2015 The Imen Daba Parsian Co.
 */
class queue_db extends DataBase
{

    /** Contains each field
     * @var
     */
    private $_queueFields;
    /**
     * Contains queue list
     * @var array
     */
    private $_queueListDb;
    /** Contains each field
     * @var
     */
    private $_paging;
    /**
     * Contains company list
     * @var array
     */
    private $_IDs;

    /**
     * Specifies the type of output
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function __construct()
    {
        $this->queueListDb = array();
    }


    /**
     * Specifies the type of output
     * @param $method
     * @param $args
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    function __call($method, $args)
    {

        $method = '_' . $method;

        if (method_exists($this, $method)) {
            switch ($method) :
                case "_set_queueFields" :
                    return $this->_set_queueFields($args['0']);
                    break;
                case "_insertQueueDB" :
                    return $this->_insertQueueDB();
                    break;
                case "_changeStatusDB" :
                    return $this->_changeStatusDB($args['0']);
                    break;
                case "_updateQueueDB" :
                    return $this->_updateQueueDB();
                    break;
                case "_getQueueById" :
                    return $this->_getQueueById($args['0']);
                    break;
                case "_getQueue" :
                    return $this->_getQueue($args['0']);
                    break;
                case "_getTrash" :
                    return $this->_getTrash();
                    break;
                case "_removeQueueDB" :
                    return $this->_removeQueueDB($args['0']);
                    break;
                case "_trashQueueDB" :
                    return $this->_trashQueueDB($args['0']);
                    break;
                case "_recycleQueueDB" :
                    return $this->_recycleQueueDB($args['0']);
                    break;
                case "_unTrashQueueDB" :
                    return $this->_unTrashQueueDB($args['0']);
                    break;
                case "_set_IDs" :
                    return $this->_set_IDs($args['0']);
                    break;
                case "_checkIfNameExistsDB" :
                    return $this->_checkIfNameExistsDB($args['0'], $args['1']);
                    break;

            endswitch;
        }

    }


    /**
     * Specifies the type of output
     * @param $property
     * @param $value
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function __set($property, $value)
    {

    }

    /**
     * Specifies the value of each field
     * @param $field
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function __get($field)
    {
        switch ($field) {

            case 'queueListDb':
                return $this->_queueListDb;
                break;
            case 'paging':
                return $this->_paging;
                break;
            case 'queueFields':
                return $this->_queueFields;
                break;
            default:
                break;
        }
    }


    /**
     * Specifies the type of output
     * @param extensionID
     * @param $value
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _set_queueListDb($queueID, $value = '')
    {
        if (!empty($queueID) && is_numeric($queueID) && is_array($value)) {
            $this->_queueListDb[$queueID] = $value;
        }
        $result['result'] = 1;
        return $result;
    }

    /**
     * Specifies the type of output
     * @param $insertedId
     * @param $value
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _set_InsertQueueDB($insertedId, $value = '')
    {
        if (!empty($insertedId) && is_numeric($insertedId) && is_array($insertedId)) {
            $this->_queueFields[$insertedId] = $value;
        }
    }

    /**
     * Specifies the type of output
     * @param $value
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */

    private function _set_queueFields($value = '')
    {
        $this->_queueFields = $value;
        $result['result'] = 1;
        $result['no'] = 1;
        return $result;
    }

    /**
     * Specifies the type of output
     * @return  mixed
     * @param   $value
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _set_IDs($value = '')
    {
        $result['result'] = 1;

        foreach ($value as $key => $val) {
            if (is_numeric($val) && !empty($val)) {
                $this->_IDs[$key] = $val;
            } else {
                $msg = $val . ModelANNOUNCE_08;
                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;
                $result['msgList'][$key] = $msg;
            }
        }
        return $result;
    }

    /**
     * Gets each queue based on its ID
     * @param $queueID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getQueueById($queueID)
    {
        // global $lang;

        $conn = parent::getConnection();

        $sql = " SELECT `dst_option_id` as dst_option_id,
			            `dst_option_sub_id` as dst_option_sub_id,
			            `queue_id` as queue_id,
			            `queue_name` as Queue_Name,
			            `queue_ext_no` as Queue_Ext_Number,
			            `queue_pass` as Queue_Pass,
			            `max_wait_time` as Max_Wait_Time,
                        `agents_no` as Agents_No,
			            `position_announcement` as Position_Announcement,
			            `hold_time_announcement` as Hold_Time_Announcement,
			             `frequency` as Frequency,
			            `recording` as Recording,
			            `ring_strategy` as Ring_Strategy,
			            `instead` as instead,
			            `comp_id` as comp_id
              FROM 	tbl_queue
              WHERE
                    queue_id= '$queueID'";

        //or WHERE    news_id='$id' ");
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if (!$stmt) {
            $result['result'] = -1;
            $result['Number'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }

        if (!$stmt->rowCount()) {
            $result['result'] = -1;
            $result['Number'] = 1;
            $result['msg'] = ModelADMIN_62;
            return $result;
        }

        $row = $stmt->fetch();
        $this->_set_queueFields($row);
        $result['result'] = 1;
        return $result;
    }

    /**
     * Gets queue
     * @param  $fields
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getQueue($fields)
    {
        //global $lang;
        $filter = $this->filterBuilder($fields);
        $length = $filter['length'];
        $filter = $filter['list'];
        //$this->_checkPermission();
        $conn = parent::getConnection();

        include_once(ROOT_DIR . "component/company.operation.class.php");
        $company_operation = new company_operation;
        $result = $company_operation->getSubCompanies();

        if ($filter['filter'] != '') {
            $filter['filter'] = ' AND ' . $filter['filter'];
        }

        $sql = "
         SELECT
              `t1`.*
               FROM(
               SELECT
              `tbl_queue`.*, `tbl_dst_option`.`option_value`, `tbl_company`.`comp_name`
               FROM
              `tbl_queue` INNER JOIN
              `tbl_dst_option` ON `tbl_queue`.`dst_option_id` =
              `tbl_dst_option`.`dst_option_id`
               LEFT JOIN
    		   `tbl_company` ON `tbl_company`.`comp_id` =
              `tbl_queue`.`comp_id`
              ) AS `t1`
              WHERE comp_id in (" . $result['list'] . ") " . $filter['filter'] . $filter['order'] . $filter['limit'];

        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        if (!$stmt) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }

        $sql = "
              SELECT COUNT(`tbl_queue`.`queue_id`) as recCount
              FROM `tbl_queue` WHERE comp_id in (" . $result['list'] . ") " . $filter['filter'];

        $stmtP = $conn->prepare($sql);
        $stmtP->setFetchMode(PDO::FETCH_ASSOC);
        $stmtP->execute();
        $rowP = $stmtP->fetch();
        $rowFound = $rowP['recCount'];
        $this->_paging['recordsFiltered'] = $rowP['recCount'];
        $this->_paging['recordsTotal'] = $rowFound['found'];

        while ($row = $stmt->fetch()) {
            $this->_set_queueListDb($row['queue_id'], $row);
        }


        $result['result'] = 1;
        $result['no'] = 2;
        return $result;

    }

    /**
     * Gets queue
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getTrash()
    {
        //global $lang;
        //$this->_checkPermission();
        $conn = parent::getConnection();

        $sql = "
              SELECT 	`dst_option_id` as DstOptionID,
			            `queue_id` as QueueID,
			            `queue_name` as QueueName,
			            `queue_ext_no` as QueueExtNumber,
			            `queue_pass` as QueuePassword,
			            `max_wait_time` as MaximumWaitTime,
			            `position_announcement` as PositionAnnouncement,
			            `hold_time_announcement` as HoldTimeAnnouncement,
			             `frequency` as Frequency,
			            `recording` as Recording,
			            `ring_strategy` as RingStrategy
    		   FROM 	tbl_queue
    		   WHERE    queue_status = -1;

    		   ";

        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        if (!$stmt) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }

        while ($row = $stmt->fetch()) {
            $this->_set_queueListDb($row['QueueID'], $row);
        }

        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }

    /**
     * Inserts queue
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _insertQueueDB()
    {
        //global $lang;
        // echo $id;
        $conn = parent::getConnection();

        $extensionNo = implode(',', $this->_queueFields['Agents_No']);

        $extensionNo = ',' . $extensionNo . ',';

        $sql = "
                        INSERT INTO tbl_queue(
                                queue_name,
                                queue_ext_no,
                                queue_pass,
                                max_wait_time,
                                position_announcement,
                                hold_time_announcement,
                                frequency,
                                recording,
                                ring_strategy,
                                dst_option_id,
                                dst_option_sub_id ,
                                agents_no,
                                instead,
                                comp_id
                            )
                        VALUES(
                            '" . $this->_queueFields['Queue_Name'] . "',
                            '" . $this->_queueFields['Queue_Ext_Number'] . "',
                            '" . $this->_queueFields['Queue_Pass'] . "',
                            '" . $this->_queueFields['Max_Wait_Time'] . "',
                            '" . $this->_queueFields['Position_Announcement'] . "',
                            '" . $this->_queueFields['Hold_Time_Announcement'] . "',
                            '" . $this->_queueFields['Frequency'] . "',
                            '" . $this->_queueFields['Recording'] . "',
                            '" . $this->_queueFields['Ring_Strategy'] . "',
                            '" . $this->_queueFields['DSTOption'] . "',
                            '" . $this->_queueFields['dst_option_sub_id'] . "',
                            '" . $extensionNo . "',
                            '" . $this->_queueFields['instead'] . "',                            
                            '" . $this->_queueFields['comp_id'] . "'
                            )";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        if (!$stmt) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = 'DB error : ' . $conn->errorInfo();
            return $result;
        }

        //echo 'count='.$stmt->fetchColumn();
        //echo $stmt->rowCount();
        $insertedId = $conn->lastInsertId();
        $this->_queueFields['ExtensionID'] = $insertedId;
        $this->_set_InsertQueueDB($insertedId, $this->_queueFields);
        $result['result'] = 1;
        $result['Number'] = 2;
        return $result;
    }


    /**
     * Update queue
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _updateQueueDB()
    {
        // global $lang;
        $conn = parent::getConnection();
        $queueID = $this->_queueFields['queue_id'];
        $extensionNo = implode(',', $this->_queueFields['Agents_No']);
        $extensionNo = ',' . $extensionNo . ',';

        $sql = "UPDATE  tbl_queue
                SET
                        queue_name = '" . $this->_queueFields['Queue_Name'] . "',
                        queue_ext_no = '" . $this->_queueFields['Queue_Ext_Number'] . "',
                        queue_pass = '" . $this->_queueFields['Queue_Pass'] . "',
                        max_wait_time = '" . $this->_queueFields['Max_Wait_Time'] . "',
                        position_announcement = '" . $this->_queueFields['Position_Announcement'] . "',
                        hold_time_announcement = '" . $this->_queueFields['Hold_Time_Announcement'] . "',
                        frequency = '" . $this->_queueFields['Frequency'] . "',
                        recording = '" . $this->_queueFields['Recording'] . "',
                        ring_strategy = '" . $this->_queueFields['Ring_Strategy'] . "',
                        dst_option_id = '" . $this->_queueFields['DSTOption'] . "',
                        dst_option_sub_id = '" . $this->_queueFields['dst_option_sub_id'] . "',
                        instead = '" . $this->_queueFields['instead'] . "',
                        agents_no =   '" . $extensionNo . "'
                WHERE   queue_id = $queueID;
                      ";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        if (!$stmt) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = 'DB error : ' . $conn->errorInfo();
            return $result;
        }

        $result['result'] = 1;
        $result['Number'] = 2;
        return $result;
    }

    /**
     * Remove queue
     * @param queue
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _removeQueueDB($queueID)
    {
        global $lang, $conn;
        $conn = parent::getConnection();

        $sql = "
           DELETE
           FROM 	tbl_queue
		   WHERE    queue_id= '$queueID'";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if (!$stmt) {
            $result['result'] = -1;
            $result['Number'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }

        $result['result'] = 1;
        return $result;
    }

    /**
     * Trash queue
     * @param queue
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _trashQueueDB($queueID)
    {
        global $lang, $conn;
        $conn = parent::getConnection();

        $sql = "
           UPDATE   tbl_queue
           SET	    trash = 1
		   WHERE    queue_id= '$queueID'";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if (!$stmt) {
            $result['result'] = -1;
            $result['Number'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }

        $result['result'] = 1;
        return $result;
    }

    /**
     * Recycle queue
     * @param queue
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _recycleQueueDB($queueID)
    {
        global $lang, $conn;
        $conn = parent::getConnection();

        $sql = "
           UPDATE   tbl_queue
           SET	    trash = 0
		   WHERE    queue_id= '$queueID'";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if (!$stmt) {
            $result['result'] = -1;
            $result['Number'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }

        $result['result'] = 1;
        return $result;
    }

    /**
     * UnTrash queue
     * @param queue
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _unTrashQueueDB($queueID)
    {
        global $lang, $conn;
        $conn = parent::getConnection();

        $sql = "
           UPDATE   tbl_queue
           SET	    queue_status = 1
		   WHERE    queue_id= '$queueID'";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if (!$stmt) {

            $result['result'] = -1;
            $result['Number'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }

        $result['result'] = 1;
        return $result;
    }

    /**
     * changeStatus set flag in status
     * @param $val
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/09/2015
     */
    private function _changeStatusDB($val)
    {
        //global  $lang;
        $conn = parent::getConnection();
        $listId = implode(',', $this->_IDs);

        $sql = "
                UPDATE 	tbl_queue
			    SET
                queue_status=$val
                WHERE   queue_id in ($listId)";

        $stmt = $conn->prepare($sql);
        /*** bind the parameters ***/
        //$stmt->bindParam(':id',$this->_newsFields['newsID'], PDO::PARAM_INT);
        $stmt->bindParam(':val', $val, PDO::PARAM_INT);
        $stmt->execute();

        if (!$stmt) {
            $result['result'] = -1;
            $result['no'] = 1;
            $res['msg'] = 'DB error : ' . $conn->errorInfo();
            return $res;
        }

        $result['result'] = 1;
        $result['Number'] = 2;
        return $result;
    }

    /**
     * Gets All
     * @param $where
     * @param $fieldSort
     * @param $sort
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */


    public function GetAll($where = '', $fieldSort = '', $sort = 'asc')
    {
        global $conn, $member_info;
        $conn = parent::getConnection();
        $table = 'tbl_queue';

        if (strlen($table) == 0) {
            return -1;
        }

        $appendSql = "select * from " . $table . " ";

        if ($where != '') {
            $appendSql .= 'WHERE ' . $where . ' ';
        }

        if ($fieldSort != '') {
            $appendSql .= "ORDER BY " . $fieldSort . " " . $sort;
        }

        $stmt = $conn->prepare($appendSql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        if (!$stmt) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }

        while ($row = $stmt->fetch()) {
            $this->_set_queueListDb($row['queue_id'], $row);
        }

        $result['result'] = 1;
        $result['rowCount'] = $stmt->rowCount();
        $result['rs'] = $stmt;
        return $result;
    }


    /**
     * Checks if name exists
     * @param $name
     * @param $compID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _checkIfNameExistsDB($name, $compID)
    {
        global $lang, $conn;
        $conn = parent::getConnection();

        $sql = "
           SELECT   *
           FROM	    tbl_queue
		   WHERE    queue_name= '$name' AND comp_id = '$compID' AND trash = 0";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if (!$stmt) {
            $result['result'] = -1;
            $result['Number'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }

        while ($row = $stmt->fetch()) {
            $this->_set_queueListDb($row['queue_id'], $row);
        }

        $result['rowCount'] = $stmt->rowCount();
        $result['result'] = 1;
        return $result;
    }
}
