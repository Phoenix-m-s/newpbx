<?php
/**
 * @author Malekloo Izadi Sakhamanesh <Izadi@dabacenter.ir>
 * @version 0.0.1 this is the beta version of News
 * @copyright 2015 The Imen Daba Parsian Co.
 */
class sip_db extends dbConn
{


    /** Contains each field
     * @var
     */
    private $_sipFields;

    /** Contains each field
     * @var
     */
    private $_paging;
    /**
     * Contains company list
     * @var array
     */
    private $_sipListDb;
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
        $this->_sipListDb = array();
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
                case "_set_sipFields" :
                    return $this->_set_sipFields($args['0']);
                    break;
                case "_insertSipDB" :
                    return $this->_insertSipDB();
                    break;
                case "_updateSipDB" :
                    return $this->_updateSipDB();
                    break;
                case "_getSipById" :
                    return $this->_getSipById($args['0']);
                    break;
                case "_getSip" :
                    return $this->_getSip($args['0']);
                    break;
                case "_removeSipDB" :
                    return $this->_removeSipDB($args['0']);
                    break;
                case "_changeStatusDB" :
                    return $this->_changeStatusDB($args['0']);
                    break;
                case "_set_IDs" :
                    return $this->_set_IDs($args['0']);
                    break;
                case "_trashSipDB" :
                    return $this->_trashSipDB($args['0']);
                    break;
                case "_recycleSipDB" :
                    return $this->_recycleSipDB($args['0']);
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
            case 'newsList' :
                $this->_set_newsList("", $value);
                break;
            default:
                $this->_set_companyFields(array($property => $value));
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

            case 'sipList':
                return $this->_sipListDb;
                break;
            case 'sipFields':
                return $this->_sipFields;
                break;
            case 'paging':
                return $this->_paging;
                break;
            default:
                break;
        }
    }


    /**
     * Specifies the type of output
     * @param $sipID
     * @param $value
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _set_sipListDb($sipID, $value = '')
    {
        if (!empty($sipID) && is_numeric($sipID) && is_array($value)) {
            $this->_sipListDb[$sipID] = $value;
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
    private function _set_InsertSipDB($insertedId, $value = '')
    {
        if (!empty($insertedId) && is_numeric($insertedId) && is_array($value)) {
            $this->_sipFields[$insertedId] = $value;
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
    private function _set_sipFields($value = '')
    {

        $this->_sipFields = $value;
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
        //echo '<pre/>start';
        /*print_r(get_class($this));
        print_r(__CLASS__);
        print_r(__METHOD__);

        die();*/


        /*echo '<pre/>';
       print_r($this);
        die(__CLASS__);
        if(get_class($this)!='news_operation'){
            die('You don\'t have permission to access the class');

        }*/

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
     * Gets SIP based on its ID
     * @param $sipID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getSipById($sipID)
    {
        global $lang,$conn;
        //$this->_checkPermission();
        // echo $id;
        $checked = implode(',', $this->_sipFields['codec']);
        $checked = ',' . $checked . ',';
        $conn = parent::getConnection();

        $sql = "SELECT
                     `sip_id` as sip_id,
                     `sip_name` as sip_name,
                     `pass` as pass,
                     `sip_type` as sip_type,
                     `nat` as nat,
                     `host` as host,
                     `codec` as codec,
                     `comp_id` as comp_id
    		    FROM  tbl_sip
                WHERE sip_id= '$sipID'";

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

        //echo 'count='.$stmt->fetchColumn();
        //echo $stmt->rowCount();
        $row = $stmt->fetch();
        $this->_set_sipFields($row);
        $result['result'] = 1;
        return $result;

    }

    /**
     * Gets sip
     * @param  $fields
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getSip($fields = '')
    {

        global $lang;
        $checked = implode(',', $this->_sipFields['codec']);
        $checked = ',' . $checked . ',';
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

        $sql = "
         SELECT
              `t1`.*
               FROM(
               SELECT
              `tbl_sip`.*,`tbl_company`.`comp_name`
               FROM
              `tbl_sip`
               LEFT JOIN
    		   `tbl_company` ON `tbl_company`.`comp_id` =
              `tbl_sip`.`comp_id`
              ) AS `t1`
              WHERE comp_id in (" . $result['list'] . ")  " . $filter['filter'] . $filter['order'] . $filter['limit'];

        //or WHERE    news_id='$id' ");
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
              SELECT COUNT(`tbl_sip`.`sip_id`) as recCount
              FROM `tbl_sip` WHERE comp_id in (" . $result['list'] . ")  " . $filter['filter'];


        $stmtP = $conn->prepare($sql);
        $stmtP->setFetchMode(PDO::FETCH_ASSOC);
        $stmtP->execute();
        $rowP = $stmtP->fetch();

        $rowFound = $rowP['recCount'];
        $this->_paging['recordsFiltered'] = $rowP['recCount'];
        $this->_paging['recordsTotal'] = $rowFound['found'];


        //echo $stmt->rowCount();
        while ($row = $stmt->fetch()) {
            $this->_set_sipListDb($row['sip_id'], $row);
        }

        $result['result'] = 1;
        $result['no'] = 2;
        //$res['list']=$fields;

        return $result;

    }

    /**
     * Insert SIP
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _insertSipDB()
    {
        global $lang;
        // echo $id;
        $conn = parent::getConnection();

        $checked = implode(',', $this->_sipFields['codec']);
        $checked = ',' . $checked . ',';
        $sql = "
                        INSERT INTO tbl_sip(
                                sip_name,
                                pass,
                                sip_type,
                                host,
                                nat,
                                codec,
                                comp_id
                            )
                        VALUES(
                            '" . $this->_sipFields['sip_name'] . "',
                            '" . $this->_sipFields['pass'] . "',
                            '" . $this->_sipFields['sip_type'] . "',
                            '" . $this->_sipFields['host'] . "',
                            '" . $this->_sipFields['nat'] . "',
                            '" . $checked . "',
                            '" . $this->_sipFields['comp_id'] . "'

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
        $this->_sipFields['sipID'] = $insertedId;
        $this->_set_InsertSipDB($insertedId, $this->_sipFields);
        $result['result'] = 1;
        $result['Number'] = 2;
        return $result;
    }

    /**
     * updateSipDB
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _updateSipDB()
    {
        global $lang;
        $conn = parent::getConnection();
        $checked = implode(',', $this->_sipFields['codec']);
        $checked = ',' . $checked . ',';
        $sipID = $this->_sipFields['id'];
        $sql = "UPDATE tbl_sip
                SET
                    sip_name =   '" . $this->_sipFields['sip_name'] . "',
                    pass =       '" . $this->_sipFields['pass'] . "',
                    sip_type =   '" . $this->_sipFields['sip_type'] . "',
                    host =       '" . $this->_sipFields['host'] . "',
                    nat =        '" . $this->_sipFields['nat'] . "',
                    codec =      '" . $checked . "'
                WHERE
                    sip_id = $sipID;
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
     * Remove SIP
     * @param $sipID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _removeSipDB($sipID)
    {
        global $lang, $conn;
        $conn = parent::getConnection();
        $sql = "
           DELETE
           FROM 	tbl_sip
		   WHERE    sip_id = '$sipID'";
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
                UPDATE 	tbl_sip
			    SET
                    sip_status=$val
				    WHERE   sip_id in ($listId) ";

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
     * Trash SIP
     * @param queue
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _trashSipDB($sipID)
    {
        global $lang, $conn;
        $conn = parent::getConnection();
        $sql = "
           UPDATE   tbl_sip
           SET	    trash = 1
		   WHERE    sip_id= '$sipID'";

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
     * Recycle SIP
     * @param queue
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _recycleSipDB($sipID)
    {
        global $lang, $conn;
        $conn = parent::getConnection();
        $sql = "
           UPDATE   tbl_sip
           SET	    trash = 0
		   WHERE    sip_id= '$sipID'";

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
        $table = 'tbl_sip';

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
            $this->_set_sipListDb($row['sip_id'], $row);
        }

        $result['result'] = 1;
        $result['rowCount'] = $stmt->rowCount();
        $result['rs'] = $stmt;
        $result['msg'] = $conn->errorInfo();
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
           FROM	    tbl_sip
		   WHERE    sip_name= '$name' AND comp_id = '$compID' AND trash = 0";

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
            $this->_set_sipListDb($row['sip_id'], $row);
        }

        $result['rowCount'] = $stmt->rowCount();
        $result['result'] = 1;
        return $result;
    }
}
