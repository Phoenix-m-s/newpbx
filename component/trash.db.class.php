<?php

/**
 * @author Malekloo Izadi Sakhamanesh <Izadi@dabacenter.ir>
 * @version 0.0.1 this is the beta version of News
 * @copyright 2015 The Imen Daba Parsian Co.
 */
class trash_db extends DataBase
{


    /** Contains each field
     * @var
     */
    private $_trashFields;


    /**
     * Contains queue list
     * @var array
     */
    private $_trashListDb;

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
        $this->trashListDb = array();
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
                case "_changeStatusDB" :
                    return $this->_changeStatusDB($args['0']);
                    break;
                case "_getQueueById" :
                    return $this->_getQueueById($args['0']);
                    break;
                case "_getQueue" :
                    return $this->_getQueue($args['0']);
                    break;
                case "_removeQueueDB" :
                    return $this->_removeQueueDB($args['0']);
                    break;
                case "_trashQueueDB" :
                    return $this->_trashQueueDB($args['0']);
                    break;
                case "_trashAnnounceDB" :
                    return $this->_trashAnnounceDB($args['0']);
                    break;
                case "_unTrashQueueDB" :
                    return $this->_unTrashQueueDB($args['0']);
                    break;
                case "_getTrash" :
                    return $this->_getTrash($args['0']);
                    break;
                case "_set_IDs" :
                    return $this->_set_IDs($args['0']);
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

            case 'trashListDb':
                return $this->_trashListDb;
                break;
            case 'paging':
                return $this->_paging;
                break;
            case 'trashFields':
                return $this->_trashFields;
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
    private function _set_trashListDb($queueID, $value = '')
    {
        if (!empty($queueID) && is_numeric($queueID) && is_array($value)) {
            $this->_trashListDb[$queueID] = $value;
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
            $this->_trashFields[$insertedId] = $value;
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


        $this->_trashFields = $value;
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
        global $lang;
        $conn = parent::getConnection();

        $sql = " SELECT 	`dst_option_id` as Dst_Option_ID,
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
			            `ring_strategy` as Ring_Strategy
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
     * Get Queue
     * @param  $fields
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getQueue($fields)
    {
        global $lang;
        $filter = $this->filterBuilder($fields);
        $length = $filter['length'];
        $filter = $filter['list'];
        $this->_checkPermission();
        $conn = parent::getConnection();

        $sql = "
         SELECT
              `t1`.*
                FROM(SELECT
              `tbl_queue`.*, `tbl_dst_option`.`option_value`
               FROM
              `tbl_queue` INNER JOIN
              `tbl_dst_option` ON `tbl_queue`.`dst_option_id` =
              `tbl_dst_option`.`dst_option_id`) AS `t1`
              " . $filter['WHERE'] . $filter['filter'] . $filter['order'] . $filter['limit'];


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
        FROM
          `tbl_queue`  " . $filter['WHERE'] . $filter['filter'];


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
     * Gets Trash
     * @param  $fields
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getTrash($fields)
    {
        global $lang;
        $filter = $this->filterBuilder($fields);
        $length = $filter['length'];
        $filter = $filter['list'];
        $this->_checkPermission();
        // $this->_checkPermission();
        $conn = parent::getConnection();

        $sql = "
         SELECT
              `t1`.*
                FROM(SELECT
              `tbl_queue`.*, `tbl_dst_option`.`option_value`
               FROM
              `tbl_queue` INNER JOIN
              `tbl_dst_option` ON `tbl_queue`.`dst_option_id` =
              `tbl_dst_option`.`dst_option_id`
              WHERE trash = 1
              ) AS `t1`
             " . $filter['WHERE'] . $filter['filter'] . $filter['order'] . $filter['limit'];

        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        if (!$stmt) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }
        //ssss

        while ($row = $stmt->fetch()) {
            $this->_set_trashListDb($row['queue_id'], $row);
        }


        $result['result'] = 1;
        $result['no'] = 2;
        return $result;

    }


    /**
     * Remove Queue DB
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
     * Trash Queue DB
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
     * Trash Announce DB
     * @param $AnnounceID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _trashAnnounceDB($AnnounceID)
    {
        global $lang, $conn;
        $conn = parent::getConnection();
        $sql = "
           UPDATE   tbl_announce
           SET	    trash = 1
		   WHERE    announce_id= '$AnnounceID'";

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
     * UnTrash Queue DB
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
        global $lang;
        $conn = parent::getConnection();
        $listId = implode(',', $this->_IDs);
        $sql = "
                UPDATE 	tbl_queue
			    SET
                    queue_status=$val
				    WHERE   queue_id in ($listId) ";

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


}
