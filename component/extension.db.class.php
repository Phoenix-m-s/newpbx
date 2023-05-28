<?php

/**
 * @author Malekloo Izadi Sakhamanesh <Izadi@dabacenter.ir>
 * @version 0.0.1 this is the beta version of News
 * @copyright 2015 The Imen Daba Parsian Co.
 */
class extension_db extends DataBase
{


    /** Contains each field
     * @var
     */
    private $_extensionFields;

    /**
     * Contains extension list
     * @var array
     */
    private $_extensionListDb;

    /** Contains each field
     * @var
     */
    private $_paging;

    /**
     * Contains extension list
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
        $this->_extensionListDb = array();
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
                case "_set_extensionFields" :
                    return $this->_set_extensionFields($args['0']);
                    break;
                case "_insertExtensionDB" :
                    return $this->_insertExtensionDB();
                    break;
                case "_updateExtensionDB" :
                    return $this->_updateExtensionDB();
                    break;
                case "_getExtensionById" :
                    return $this->_getExtensionById($args['0']);
                    break;
                case "_set_IDs" :
                    return $this->_set_IDs($args['0']);
                    break;
                case "_changeStatusDB" :
                    return $this->_changeStatusDB($args['0']);
                    break;
                case "_getExtension" :
                    return $this->_getExtension($args['0']);
                    break;
                case "_getVoiceMailList" :
                    return $this->_getVoiceMailList($args['0']);
                    break;
                case "_removeExtensionDB" :
                    return $this->_removeExtensionDB($args['0']);
                    break;
                case "_trashExtensionDB" :
                    return $this->_trashExtensionDB($args['0']);
                    break;
                case "_recycleExtensionDB" :
                    return $this->_recycleExtensionDB($args['0']);
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

            case 'paging':
                return $this->_paging;
                break;
            case 'extensionListDb':
                return $this->_extensionListDb;
                break;
            case 'extensionFields':
                return $this->_extensionFields;
                break;
            default:
                break;
        }
    }

    /**
     * Specifies the type of output
     * @param Extension_ID
     * @param $value
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _set_extensionListDb($Extension_ID, $value = '')
    {
        if (!empty($Extension_ID) && is_numeric($Extension_ID) && is_array($value)) {
            $this->_extensionListDb[$Extension_ID] = $value;
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
    private function _set_InsertExtensionDB($insertedId, $value = '')
    {
        if (!empty($insertedId) && is_numeric($insertedId) && is_array($insertedId)) {
            $this->_extensionFields[$insertedId] = $value;
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
    private function _set_extensionFields($value = '')
    {
        $this->_extensionFields = $value;
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

        //?? ??? ???? ??????? sql ??? ??  id  ?? ??? ???//
        $result['result'] = 1;

        foreach ($value as $key => $val) {
            if (is_numeric($val) && !empty($val)) {
                $this->_IDs[$key] = $val;
            } else {
                $msg = "$val not Valid";
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
     * Gets each extension based on its ID
     * @param $Extension_ID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getExtensionById($Extension_ID)
    {
        global $lang;
        $conn = parent::getConnection();

        $sql = "SELECT
                    `extension_name` as Extension_Name,
                    `extension_no` as Extension_No,
                    `caller_id_number` as caller_id_number,
                    `ring_number` as ring_number,
                    `secret` as Secret,
                    `voicemail_status` as Voicemail_Status,
                    `extension_id` as Extension_ID,
                    `voicemail_email` as Voicemail_Email,
                    `internal_recording` as Internal_Recording,
                    `external_recording` as External_Recording,
                    `voicemail_pass` as Voicemail_Pass,
                    `comp_id` as comp_id,
                    `username` as User_Name,
                    `password` as Password,
                    `successDialDestination` as successDialDestination,
                    `successForward` as successForward,
                    `successDSTOption` as successDSTOption,
                    `failedDialDestination` as failedDialDestination,
                    `failedForward` as failedForward,
                    `failedDSTOption` as failedDSTOption

                FROM
                    tbl_extension
                WHERE
                    extension_id= '$Extension_ID'";

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
        $this->_set_extensionFields($row);
        $result['result'] = 1;
        return $result;
    }
    
    /**
     * Gets extension
     * @param  $fields
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getExtension($fields)
    {
        global $lang;

        $conn = parent::getConnection();
        $filter = $this->filterBuilder($fields);

        $length = $filter['length'];
        $filter = $filter['list'];

        include_once(ROOT_DIR . "component/company.operation.class.php");
        $company_operation = new company_operation;
        $result = $company_operation->getSubCompanies();

        if ($filter['filter'] != '') {
            $filter['filter'] = ' AND ' . $filter['filter'];
        }

        $sql = "SELECT
              `t1`.*
                FROM
              (SELECT 	`tbl_extension`.`extension_name` as Extension_Name,
			            `tbl_extension`.`extension_no` as Extension_No,
			            `tbl_extension`.`caller_id_number` as caller_id_number,
			            `tbl_extension`.`extension_id` as Extension_ID,
			            `tbl_extension`.`secret` as Secret,
                        `tbl_extension`.`voicemail_email` as Voicemail_Email,
			            `tbl_extension`.`voicemail_pass` as Voicemail_Pass,
			            `tbl_extension`.`internal_recording` as Internal_Recording,
			            `tbl_extension`.`external_recording` as External_Recording,
			            `tbl_extension`.`extension_status` as Extension_Status,
			            `tbl_extension`.`comp_id`,
			            `tbl_extension`.`trash`,
			            `tbl_company`.`comp_name`
    		   FROM 	tbl_extension
    		   LEFT JOIN
    		   `tbl_company` ON `tbl_company`.`comp_id` =
              `tbl_extension`.`comp_id`
    		    ) AS `t1`
    		   WHERE comp_id in (" . $result['list'] . ")  " . $filter['filter'] . $filter['order'] . $filter['limit'];


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
          SELECT COUNT(`tbl_extension`.`extension_id`) as recCount
          FROM
          `tbl_extension`  WHERE comp_id in (" . $result['list'] . ")  " . $filter['filter'];
        //echo $stmt->rowCount();

        $stmTp = $conn->prepare($sql);
        $stmTp->setFetchMode(PDO::FETCH_ASSOC);
        $stmTp->execute();
        $rowP = $stmTp->fetch();

        $rowFound = $rowP['recCount'];
        $this->_paging['recordsFiltered'] = $rowP['recCount'];
        $this->_paging['recordsTotal'] = $rowFound['found'];

        while ($row = $stmt->fetch()) {
            $this->_set_extensionListDb($row['Extension_ID'], $row);
        }

        $result['result'] = 1;
        $result['no'] = 2;
        return $result;

    }

    /**
     * Gets voiceMail
     * @param  $fields
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getVoiceMailList($fields)
    {

        global $lang;

        $conn = parent::getConnection();
        $filter = $this->filterBuilder($fields);

        $length = $filter['length'];
        $filter = $filter['list'];

        include_once(ROOT_DIR . "component/company.operation.class.php");
        $company_operation = new company_operation;
        $result = $company_operation->getSubCompanies();

        if ($filter['filter'] != '') {
            $filter['filter'] = ' AND ' . $filter['filter'];
        }

        $sql = "SELECT *
                FROM tbl_extension
                WHERE voicemail_email != '' AND comp_id in (" . $result['list'] . ") " . $filter['filter'] . $filter['order'] . $filter['limit'];


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
          SELECT COUNT(`tbl_extension`.`extension_id`) as recCount
          FROM
          `tbl_extension`  WHERE comp_id in (" . $result['list'] . ") " . $filter['filter'];
        //echo $stmt->rowCount();

        $stmTp = $conn->prepare($sql);
        $stmTp->setFetchMode(PDO::FETCH_ASSOC);
        $stmTp->execute();
        $rowP = $stmTp->fetch();

        $rowFound = $rowP['recCount'];
        $this->_paging['recordsFiltered'] = $rowP['recCount'];
        $this->_paging['recordsTotal'] = $rowFound['found'];

        while ($row = $stmt->fetch()) {
            $this->_set_extensionListDb($row['extension_id'], $row);
        }

        $result['result'] = 1;
        $result['no'] = 2;
        return $result;

    }
    
    /**
     * Inserts extension
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _insertExtensionDB()
    {
        global $lang;
        $conn = parent::getConnection();

        $sql = "
                        INSERT INTO tbl_extension(
                                extension_name,
                                extension_no,
                                caller_id_number,
                                ring_number,
                                secret,
                                voicemail_status,
                                voicemail_email,
                                voicemail_pass,
                                internal_recording,
                                external_recording,
                                comp_id,
                                username,
                                password
                            )
                        VALUES(
                            '" . $this->_extensionFields['Extension_Name'] . "',
                            '" . $this->_extensionFields['Extension_No'] . "',
                            '" . $this->_extensionFields['caller_id_number'] . "',
                            '" . $this->_extensionFields['ring_number'] . "',
                            '" . $this->_extensionFields['Secret'] . "',
                            '" . $this->_extensionFields['Voicemail_Status'] . "',
                            '" . $this->_extensionFields['Voicemail_Email'] . "',
                            '" . $this->_extensionFields['Voicemail_Pass'] . "',
                            '" . $this->_extensionFields['Internal_Recording'] . "',
                            '" . $this->_extensionFields['External_Recording'] . "',
                            '" . $this->_extensionFields['comp_id'] . "',
                            '" . $this->_extensionFields['User_Name'] . "',
                            '" . $this->_extensionFields['Password'] . "'

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
        $this->_extensionFields['Extension_ID'] = $insertedId;
        $this->_set_InsertExtensionDB($insertedId, $this->_extensionFields);

        $result['result'] = 1;
        $result['Number'] = 2;
        return $result;

    }

    /**
     * Update extension
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _updateExtensionDB()
    {
        global $lang;
        $conn = parent::getConnection();
        $Extension_ID = $this->_extensionFields[ 'id' ];

        $sql = "UPDATE tbl_extension
                SET
                      extension_name =   '" . $this->_extensionFields['Extension_Name'] . "',
                      extension_no ='" . $this->_extensionFields['Extension_No'] . "',
                      caller_id_number ='" . $this->_extensionFields['caller_id_number'] . "',
                      ring_number ='" . $this->_extensionFields['ring_number'] . "',
                      secret =  '" . $this->_extensionFields['Secret'] . "',
                      voicemail_email =   '" . $this->_extensionFields['Voicemail_Email'] . "',
                      voicemail_status =   '" . $this->_extensionFields['Voicemail_Status'] . "',
                      voicemail_pass ='" . $this->_extensionFields['Voicemail_Pass'] . "',
                      internal_recording ='" . $this->_extensionFields['Internal_Recording'] . "',
                      external_recording ='" . $this->_extensionFields['External_Recording'] . "',
                      username ='" . $this->_extensionFields['User_Name'] . "',
                      password ='" . $this->_extensionFields['Password'] . "',
                      successDialDestination ='" . $this->_extensionFields['successDialDestination'] . "',
                      successForward ='" . $this->_extensionFields['successForward'] . "',
                      successDSTOption ='" . $this->_extensionFields['successDSTOption'] . "',
                      failedDialDestination ='" . $this->_extensionFields['failedDialDestination'] . "',
                      failedForward ='" . $this->_extensionFields['failedForward'] . "',
                      failedDSTOption ='" . $this->_extensionFields['failedDSTOption'] . "'
                WHERE extension_id = $Extension_ID;
                      ";

        $stmt = $conn->prepare( $sql );
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
     * Remove extension
     * @param $Extension_ID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _removeExtensionDB($Extension_ID)
    {
        global $lang, $conn;
        $conn = parent::getConnection();
        $sql = "
           DELETE
           FROM 	tbl_extension
		   WHERE    extension_id= '$Extension_ID'";

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
     * Trash extension
     * @param $Extension_ID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _trashExtensionDB($Extension_ID)
    {
        global $lang, $conn;
        $conn = parent::getConnection();
        $sql = "
           UPDATE   tbl_extension
           SET 	    trash = 1
		   WHERE    extension_id= '$Extension_ID'";

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
     * Recycle extension
     * @param $Extension_ID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _recycleExtensionDB($Extension_ID)
    {
        global $lang, $conn;
        $conn = parent::getConnection();
        $sql = "
               UPDATE   tbl_extension
               SET 	    trash = 0
               WHERE    extension_id= '$Extension_ID'";

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
     * change Status
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
                UPDATE 	tbl_extension
			    SET     extension_status = $val
                WHERE   extension_id in ($listId)";

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
        $table = 'tbl_extension';

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
            $this->_set_extensionListDb($row['extension_id'], $row);
        }

        $result['result'] = 1;
        $result['rowCount'] = $stmt->rowCount();
        $result['rs'] = $stmt;
        return $result;
    }

    /**
     * Checks if name exists before
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
           FROM	    tbl_extension
		   WHERE    extension_name= '$name' AND comp_id = '$compID' and trash = 0";

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
            $this->_set_extensionListDb($row['extension_id'], $row);
        }

        $result['rowCount'] = $stmt->rowCount();
        $result['result'] = 1;
        return $result;
    }
    
}
