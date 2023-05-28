<?php

/**
 * @author Malekloo Izadi Sakhamanesh <Izadi@dabacenter.ir>
 * @version 0.0.1 this is the beta version of News
 * @copyright 2015 The Imen Daba Parsian Co.
 */
class outbound_db extends DataBase
{

    /** Contains each field
     * @var
     */
    private $_outboundFields;


    /**
     * Contains company list
     * @var array
     */
    private $_outboundListDb;
    /**
     * Contains Company info
     * @var
     */
    private $_outboundDialPatternFields;
    /**
     * Contains company list
     * @var array
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
     * @date    05/09/2015
     */

    public function __construct()
    {
        $this->_outboundListDb = array();
    }


    /**
     * Specifies the type of output
     * @param $method
     * @param $args
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    05/09/2015
     */
    function __call($method, $args)
    {
        $method = '_' . $method;
        if (method_exists($this, $method)) {
            switch ($method) :
                case "_set_outboundFields" :
                    return $this->_set_outboundFields($args['0']);
                    break;
                case "_set_dialPatternInfo" :
                    return $this->_set_dialPatternInfo($args['0']);
                    break;
                case "_insertOutboundDB" :
                    return $this->_insertOutboundDB();
                    break;
                case "_updateOutboundDB" :
                    return $this->_updateOutboundDB();
                    break;
                case "_getOutboundById" :
                    return $this->_getOutboundById($args['0']);
                    break;
                case "_getOutbound" :
                    return $this->_getOutbound($args['0']);
                    break;
                case "_removeOutboundDB" :
                    return $this->_removeOutboundDB($args['0']);
                    break;
                case "_removeOutboundDB1" :
                    return $this->_removeOutboundDB1($args['0']);
                    break;
                case "_insertOutboundToDialPatternDB" :
                    return $this->_insertOutboundToDialPatternDB($args['0']);
                    break;
                case "_updateOutboundToDialPatternDB" :
                    return $this->_updateOutboundToDialPatternDB($args['0']);
                case "_changeStatusDB" :
                    return $this->_changeStatusDB($args['0']);
                    break;
                case "_trashOutboundDB" :
                    return $this->_trashOutboundDB($args['0']);
                    break;
                case "_recycleOutboundDB" :
                    return $this->_recycleOutboundDB($args['0']);
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
     * @since   01.01.01
     * @date    05/09/2015
     */
    public function __set($property, $value)
    {

        switch ($property) {
            case 'paging':
                $this->_paging = $value;
                break;
            case 'outboundFields':
                $this->_outboundFields = $value;
                break;
            default:
                $this->_set_outboundFields(array($property => $value));
                break;
        }
    }

    /**
     * Specifies the value of each field
     * @param $field
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    05/09/2015
     */
    public function __get($field)
    {
        switch ($field) {

            case 'outboundList':
                return $this->_outboundListDb;
                break;
            case 'outboundFields':
                return $this->_outboundFields;
                break;

            case 'paging':
                return $this->_paging;
                break;
            case 'outboundDialPatternFields' :
                return $this->_outboundDialPatternFields;
                break;
            default:
                break;
        }
    }


    /**
     * Specifies the type of output
     * @param $outboundID
     * @param $value
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    05/09/2015
     */
    private function _set_outboundListDb($outboundID, $value = '')
    {
        if (!empty($outboundID) && is_numeric($outboundID) && is_array($value)) {
            $this->_outboundListDb[$outboundID] = $value;

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
     * @since   01.01.01
     * @date    05/09/2015
     */
    private function _set_InsertOutboundDB($insertedId, $value = '')
    {
        if (!empty($insertedId) && is_numeric($insertedId) && is_array($value)) {
            $this->_outboundFields[$insertedId] = $value;
        }

    }

    /**
     * Specifies the type of output
     * @param $value
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    05/09/2015
     */
    private function _set_outboundFields($value = '')
    {
        $this->_outboundFields = $value;
        $result['result'] = 1;
        $result['no'] = 1;
        return $result;
    }

    /**
     * Specifies the type of output
     * @param   $value
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    05/09/2015
     */
    private function _set_dialPatternInfo($value = '')
    {

        $this->_outboundDialPatternFields = $value;
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
     * @since   01.01.01
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
     * Specifies the type of output
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    05/09/2015
     */
    public function _checkPermission()
    {

    }


    /**
     * Gets Outbound by ID
     * @param $outboundID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    04/10/2015
     */
    private function _getOutboundById($outboundID)
    {
        global $lang;
        $conn = parent::getConnection();
        $sql = "SELECT *
    		    FROM   tbl_outbound
                WHERE  outbound_id= '$outboundID'";

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
        $this->_set_outboundFields($row);
        $result['result'] = 1;

        $sql = "SELECT
                     `outbound_id`  as outbound_id,
                     `prepend`  as prepend,
                     `prefix` as prefix,
                     `match_pattern` as match_pattern,
                     `caller_id` as caller_id
    		    FROM tbl_dialpattern
                WHERE
                    outbound_id= '$outboundID'";

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
        $prepend = explode(',', $row['prepend']);
        $row['prepend'] = $prepend;
        $match_pattern = explode(',', $row['match_pattern']);
        $row['match_pattern'] = $match_pattern;
        $caller_id = explode(',', $row['caller_id']);
        $row['caller_id'] = $caller_id;
        $prefix = explode(',', $row['prefix']);
        $row['prefix'] = $prefix;
        $this->_set_dialPatternInfo($row);
        $result['result'] = 1;
        return $result;

    }

    /**
     * Gets outbound
     * @param  $fields
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.02.02
     * @since   01.01.01
     * @date    05/09/2015
     */
    private function _getOutbound($fields)
    {
        global $lang;
        $this->_checkPermission();
        $conn = parent::getConnection();
        $filter = $this->filterBuilder($fields);

        $length = $filter['length'];
        $filter = $filter['list'];

        include_once(ROOT_DIR . "component/company.operation.class.php");
        $company_operation = new company_operation;
        $result = $company_operation->getSubCompanies();
        $appendSql = "WHERE comp_id in (" . $result['list'] . ") ";
        if (count($filter['filter']) > 0) {
            $appendSql = $appendSql . " AND ";
        }

        $sql = "SELECT
                  `t1`.*
                FROM
                  (SELECT
                        `tbl_sip`.`sip_name`, `tbl_outbound`.*,  `tbl_company`.`comp_name`
                   FROM
                        `tbl_outbound`
                   INNER JOIN
                        `tbl_sip`
                   ON
                        `tbl_outbound`.`siptrunk_id` = `tbl_sip`.`sip_id`
               LEFT JOIN
    		  `tbl_company` ON `tbl_company`.`comp_id` =
              `tbl_outbound`.`comp_id`
                        ) AS `t1`
               " . $appendSql . $filter['filter'] . $filter['order'] . $filter['limit'];

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

        $sql = "SELECT
                COUNT(`tbl_outbound`.`outbound_id`) as recCount
              FROM
                `tbl_outbound` " . $appendSql . $filter['filter'];

        $stmtP = $conn->prepare($sql);
        $stmtP->setFetchMode(PDO::FETCH_ASSOC);
        $stmtP->execute();
        $rowP = $stmtP->fetch();

        $rowFound = $rowP['recCount'];
        $this->_paging['recordsFiltered'] = $rowP['recCount'];
        $this->_paging['recordsTotal'] = $rowFound['found'];

        //echo $stmt->rowCount();
        while ($row = $stmt->fetch()) {
            $this->_set_outboundListDb($row['outbound_id'], $row);
        }

        $result['result'] = 1;
        $result['no'] = 2;
        //$res['list']=$fields;
        return $result;
    }


    /**
     * Insert outbound
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    05/09/2015
     */
    private function _insertOutboundDB()
    {
        global $lang;
        $conn = parent::getConnection();
        $sql = "
                        INSERT INTO tbl_outbound(
                                outbound_name,
                                caller_id_name,
                                caller_id_number,
                                siptrunk_id,
                                comp_id,
                                priority
                            )
                        VALUES(
                            '" . $this->_outboundFields['outbound_name'] . "',
                            '" . $this->_outboundFields['caller_id_name'] . "',
                            '" . $this->_outboundFields['caller_id_number'] . "',
                            '" . $this->_outboundFields['sip_id'] . "',
                            '" . $this->_outboundFields['comp_id'] . "',
                            '" . $this->_outboundFields['priority'] . "'

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
        $this->_outboundFields['outbound_id'] = $insertedId;
        $this->_set_InsertOutboundDB($insertedId, $this->_outboundFields);
        $result['result'] = 1;
        $result['Number'] = 2;
        return $result;
    }

    /**
     * Insert outbound to Dial Pattern Table
     * @param  $outboundID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    30/09/2015
     */
    private function _insertOutboundToDialPatternDB($outboundID)
    {
        global $lang;
        $prepend = implode(',', $this->_outboundDialPatternFields['prepend']);
        $match_pattern = implode(',', $this->_outboundDialPatternFields['match_pattern']);
        $prefix = implode(',', $this->_outboundDialPatternFields['prefix']);
        $callerId = implode(',', $this->_outboundDialPatternFields['caller_id']);
        $conn = parent::getConnection();
        $sql = "
                        INSERT INTO tbl_dialpattern(
                                outbound_id,
                                prepend,
                                prefix,
                                match_pattern,
                                caller_id
                            )
                        VALUES(
                            '" . $outboundID . "',
                            '" . $prepend . "',
                            '" . $prefix . "',
                            '" . $match_pattern . "',
                            '" . $callerId . "'

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
        $this->_outboundDialPatternFields['outbound_id'] = $insertedId;
        $this->_outboundFields['outbound_id'] = $this->_outboundDialPatternFields['outbound_id'];
        $this->_set_InsertOutboundDB($insertedId, $this->_outboundDialPatternFields);
        $result['result'] = 1;
        $result['Number'] = 2;
        return $result;
    }

    /**
     * updateOutboundDB
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    05/09/2015
     */
    private function _updateOutboundDB()
    {
        global $lang;
        $conn = parent::getConnection();
        $outboundID = $this->_outboundFields['outbound_id'];

        $sql = "UPDATE tbl_outbound
                SET
                    outbound_name =     '" . $this->_outboundFields['outbound_name'] . "',
                    priority =     '" . $this->_outboundFields['priority'] . "',
                    siptrunk_id   =     '" . $this->_outboundFields['sip_id'] . "',
                    caller_id_name   =     '" . $this->_outboundFields['caller_id_name'] . "',
                    caller_id_number   =     '" . $this->_outboundFields['caller_id_number'] . "'
                WHERE
                    outbound_id = $outboundID;
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
     * updateOutboundToDialPatternDB
     * @param  $outboundID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since  01.01.01
     * @date    05/09/2015
     */
    private function _updateOutboundToDialPatternDB($outboundID)
    {
        global $lang;
        $conn = parent::getConnection();
        $prepend = implode(',', $this->_outboundDialPatternFields['prepend']);
        $match_pattern = implode(',', $this->_outboundDialPatternFields['match_pattern']);
        $prefix = implode(',', $this->_outboundDialPatternFields['prefix']);
        $callerId = implode(',', $this->_outboundDialPatternFields['caller_id']);

        $sql = "UPDATE tbl_dialpattern
                SET
                    prepend         =    '" . $prepend . "',
                    prefix          =    '" . $prefix . "',
                    match_pattern   =    '" . $match_pattern . "',
                    caller_id       =    '" . $callerId . "'
                WHERE
                    outbound_id = $outboundID;
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
     * Remove the type of output
     * @param   $outboundID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    05/09/2015
     */
    private function _removeOutboundDB($outboundID)
    {
        global $lang, $conn;
        $conn = parent::getConnection();
        $sql = "
           DELETE
           FROM 	tbl_outbound
		   WHERE    outbound_id = '$outboundID'";

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
        $sql = "
           DELETE
           FROM 	tbl_dialpattern
		   WHERE    outbound_id = '$outboundID'";

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
     * Removes Outbound
     * @param   $outboundID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    05/09/2015
     */
    private function _removeOutboundDB1($outboundID)
    {
        global $lang, $conn;
        $conn = parent::getConnection();
        $sql = "
           DELETE
           FROM 	tbl_outbound
		   WHERE    outbound_id = '$outboundID'";

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
     * @since   01.01.01
     * @date    08/09/2015
     */
    private function _changeStatusDB($val)
    {
        global $lang;
        $conn = parent::getConnection();


        $listId = implode(',', $this->_IDs);
        $sql = "
                UPDATE 	tbl_outbound
			    SET
                    outbound_status=$val
				    WHERE   outbound_id in ($listId) ";

        $stmt = $conn->prepare($sql);
        /*** bind the paramaters ***/
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

    /**
     * Remove outbound
     * @param $outboundID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _trashOutboundDB($outboundID)
    {
        global $lang, $conn;
        $conn = parent::getConnection();
        $sql = "
           UPDATE   tbl_outbound
           SET	    trash = 1
		   WHERE    outbound_id= '$outboundID'";

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
     * Recycle Outbound
     * @param $outboundID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _recycleOutboundDB($outboundID)
    {
        global $lang, $conn;
        $conn = parent::getConnection();
        $sql = "
           UPDATE   tbl_outbound
           SET	    trash = 0
		   WHERE    outbound_id= '$outboundID'";

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
        $table = 'tbl_outbound';

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
            $this->_set_outboundListDb($row['outbound_id'], $row);
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
           FROM	    tbl_outbound
		   WHERE    outbound_name= '$name' AND comp_id = '$compID' AND trash = 0";

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
            $this->_set_outboundListDb($row['outbound_id'], $row);
        }

        $result['rowCount'] = $stmt->rowCount();
        $result['result'] = 1;
        return $result;
    }

}

