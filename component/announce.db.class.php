<?php

/**
 * @author Malekloo Izadi Sakhamanesh <Izadi@dabacenter.ir>
 * @version 0.0.1 this is the beta version of News
 * @copyright 2015 The Imen Daba Parsian Co.
 */
class announce_db extends DataBase
{


    /** Contains each field
     * @var
     */
    private $_announceFields;

    /** Contains each field
     * @var
     */
    private $_paging;
    /**
     * Contains company list
     * @var array
     */
    private $_announceListDb;
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
        $this->_announceListDb = array();
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
                case "_set_announceFields" :
                    return $this->_set_announceFields($args['0']);
                    break;
                case "_insertAnnounceDB" :
                    return $this->_insertAnnounceDB();
                    break;
                case "_updateAnnounceDB" :
                    return $this->_updateAnnounceDB();
                    break;
                case "_getAnnounceById" :
                    return $this->_getAnnounceById($args['0']);
                    break;
                case "_getAnnounce" :
                    return $this->_getAnnounce($args['0']);
                    break;
                case "_removeAnnounceDB" :
                    return $this->_removeAnnounceDB($args['0']);
                    break;
                case "_trashAnnounceDB" :
                    return $this->_trashAnnounceDB($args['0']);
                    break;
                case "_recycleAnnounceDB" :
                    return $this->_recycleAnnounceDB($args['0']);
                    break;
                case "_changeStatusDB" :
                    return $this->_changeStatusDB($args['0']);
                    break;
                case "_set_IDs" :
                    return $this->_set_IDs($args['0']);
                    break;
                case "_GetAll" :
                    return $this->GetAll($args['0']);
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
        switch ($property) {
            case 'paging':
                $this->_paging = $value;
                break;
            default:
                $this->_set_announceFields(array($property => $value));
                break;
        }
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

            case 'announceList':
                return $this->_announceListDb;
                break;
            case 'announceFields':
                return $this->_announceFields;
                break;
            case 'paging':
                return $this->_paging;
                break;
            default:
                break;
        }
        die();
    }


    /**
     * Specifies the type of output
     * @param $announceID
     * @param $value
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _set_announceListDb($announceID, $value = '')
    {

        if (!empty($announceID) && is_numeric($announceID) && is_array($value)) {
            $this->_announceListDb[$announceID] = $value;
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
    private function _set_InsertAnnounceDB($insertedId, $value = '')
    {
        if (!empty($insertedId) && is_numeric($insertedId) && is_array($value)) {
            $this->_announceFields[$insertedId] = $value;
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
    private function _set_announceFields($value = '')
    {
        $this->_announceFields = $value;
        $result['result'] = 1;
        $result['no'] = 1;
        return $result;
    }

    /**
     * Specifies the type of output
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function _checkPermission()
    {


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
     * Gets each Announce based on its ID
     * @param $announceID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getAnnounceById($announceID)
    {
        global $lang;
        $conn = parent::getConnection();

        $sql = "SELECT *
                FROM  tbl_announce
                WHERE
                    announce_id= '$announceID'";


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
        $this->_set_announceFields($row);
        $result['result'] = 1;
        return $result;
    }

    /**
     * Gets ALL
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

        $table = 'tbl_announce';

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
            $this->_set_announceListDb($row['announce_id'], $row);
        }

        $result['result'] = 1;
        $result['rowCount'] = $stmt->rowCount();
        $result['rs'] = $stmt;
        return $result;
    }

    /**
     * Gets announce
     * @param $fields
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getAnnounce($fields)
    {
        $filter = $this->filterBuilder($fields);
        $length = $filter['length'];
        $filter = $filter['list'];
        $conn = parent::getConnection();
        include_once(ROOT_DIR . "component/company.operation.class.php");
        $company_operation = new company_operation;
        $result = $company_operation->getSubCompanies();

        if ($filter['filter'] != '') {
            $filter['filter'] = ' AND ' . $filter['filter'];
        }

        $sql = "SELECT
              `t1`.*
                FROM
              (SELECT
              `tbl_announce`.*, `tbl_dst_option`.`option_value`, `tbl_upload`.`title`,`tbl_company`.`comp_name`
               FROM
              `tbl_announce` INNER JOIN
              `tbl_upload` ON `tbl_announce`.`upload_id` = `tbl_upload`.`upload_id`
               INNER JOIN
              `tbl_dst_option` ON `tbl_dst_option`.`dst_option_id` =
              `tbl_announce`.`dst_option_id`
              LEFT JOIN
              `tbl_company` ON `tbl_company`.`comp_id` =
              `tbl_announce`.`comp_id`
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
              SELECT COUNT(`tbl_announce`.`announce_id`) as recCount
              FROM `tbl_announce`  WHERE comp_id in (" . $result['list'] . ") " . $filter['filter'];

        $stmtP = $conn->prepare($sql);
        $stmtP->setFetchMode(PDO::FETCH_ASSOC);
        $stmtP->execute();
        $rowP = $stmtP->fetch();
        $rowFound = $rowP['recCount'];
        $this->_paging['recordsFiltered'] = $rowP['recCount'];
        $this->_paging['recordsTotal'] = $rowFound['found'];

        while ($row = $stmt->fetch()) {
            $this->_set_announceListDb($row['announce_id'], $row);
        }

        $result['result'] = 1;
        $result['no'] = 2;
        //$res['list']=$fields;
        return $result;
    }

    /**
     * Insert Announce
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _insertAnnounceDB()
    {
        global $lang;
        $conn = parent::getConnection();

        $sql = "
                        INSERT INTO tbl_announce(
                                announce_name,
                                repeat_input,
                                dst_option_id,
                                dst_option_sub_id,
                                upload_id,
                                comp_id
                            )
                        VALUES(
                            '" . $this->_announceFields['announce_name'] . "',
                            '" . $this->_announceFields['repeat_input'] . "',
                            '" . $this->_announceFields['DSTOption'] . "',
                            '" . $this->_announceFields['dst_option_sub_id'] . "',
                            '" . $this->_announceFields['upload_id'] . "',
                            '" . $this->_announceFields['comp_id'] . "'

                            )";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        if (!$stmt) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = 'DB error : ' . $conn->errorInfo();
            return $result;
        }

        $insertedId = $conn->lastInsertId();
        $this->_announceFields['announceID'] = $insertedId;
        $this->_set_InsertAnnounceDB($insertedId, $this->_announceFields);
        $result['result'] = 1;
        $result['Number'] = 2;
        return $result;
    }

    /**
     * update Announce
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _updateAnnounceDB()
    {
        //global $lang;
        $conn = parent::getConnection();
        $announceID = $this->_announceFields['announce_id'];

        $sql = "UPDATE tbl_announce
                SET
                    announce_name =   '" . $this->_announceFields['announce_name'] . "',
                    repeat_input =    '" . $this->_announceFields['repeat_input'] . "',
                    dst_option_id =   '" . $this->_announceFields['DSTOption'] . "',
                    dst_option_sub_id =   '" . $this->_announceFields['dst_option_sub_id'] . "',
                    upload_id =       '" . $this->_announceFields['upload_id'] . "',
                    announce_date =       '" . $this->_announceFields['announce_date'] . "'
                WHERE
                    announce_id = $announceID;
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
     * Remove Announce
     * @param $announceID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _removeAnnounceDB($announceID)
    {
        global $lang, $conn;
        $conn = parent::getConnection();

        $sql = "
           DELETE
           FROM 	tbl_announce
		   WHERE    announce_id = '$announceID'";

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
     * Trash Announce
     * @param $announceID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _trashAnnounceDB($announceID)
    {
        global $lang, $conn;
        $conn = parent::getConnection();

        $sql = "
           UPDATE   tbl_announce
           SET	    trash = 1
		   WHERE    announce_id= '$announceID'";

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
     * Recycle Announce
     * @param $announceID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _recycleAnnounceDB($announceID)
    {
        global $lang, $conn;
        $conn = parent::getConnection();

        $sql = "
           UPDATE   tbl_announce
           SET	    trash = 0
		   WHERE    announce_id= '$announceID'";

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
           FROM	    tbl_announce
		   WHERE    announce_name= '$name' AND comp_id = '$compID' AND trash = 0";

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
            $this->_set_announceListDb($row['announce_id'], $row);
        }

        $result['rowCount'] = $stmt->rowCount();
        $result['result'] = 1;
        return $result;
    }

    /**
     * Change status
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
                UPDATE 	tbl_announce
			    SET
                announce_status=$val
                WHERE   announce_id in ($listId)";

        $stmt = $conn->prepare($sql);
        /*** bind the parameters ***/
        //$stmt->bindParam(':id',$this->_newsFields['newsID'], PDO::PARAM_INT);
        $stmt->bindParam(':val', $val, PDO::PARAM_INT);
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
}
