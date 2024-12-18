<?php

/**
 * @author Malekloo Izadi Sakhamanesh <Izadi@dabacenter.ir>
 * @version 0.0.1 this is the beta version of News
 * @copyright 2015 The Imen Daba Parsian Co.
 */
class company_db extends DataBase
{


    /** Contains each field
     * @var
     */
    private $_companyFields;

    /** Contains each field
     * @var
     */
    private $_groupCompany;

    /**
     * Contains company list
     * @var array
     */
    private $_companyListDb;
    /**
     * Contains company list
     * @var array
     */
    public $subCompanies;
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
     * @date    08/08/2015
     */
    public function __construct()
    {
        $this->_companyListDb = array();
        $this->_groupCompany = array();
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
                case "_set_companyFields" :
                    return $this->_set_companyFields($args['0']);
                    break;
                case "_set_companyGroupFields" :
                    return $this->_set_companyGroupFields($args['0']);
                    break;
                case "_insertCompanyDB" :
                    return $this->_insertCompanyDB();
                    break;
                case "_insertCompanyGroupDB" :
                    return $this->_insertCompanyGroupDB();
                    break;
                case "_insertCompanyToGroupDB" :
                    return $this->_insertCompanyToGroupDB();
                    break;
                case "_updateCompanyDB" :
                    return $this->_updateCompanyDB();
                    break;
                case "_updateCompanyGroupDB" :
                    return $this->_updateCompanyGroupDB();
                    break;
                case "_getCompanyById" :
                    return $this->_getCompanyById($args['0']);
                    break;
                case "_getCompanyGroupById" :
                    return $this->_getCompanygroupById($args['0']);
                    break;
                case "_getCompany" :
                    return $this->_getCompany($args['0']);
                    break;
                case "_getMembersList" :
                    return $this->_getMembersList($args['0'], $args['1']);
                    break;
                case "_getCompanyGroup" :
                    return $this->_getCompanyGroup($args['0']);
                    break;
                case "_removeCompanyDB" :
                    return $this->_removeCompanyDB($args['0']);
                    break;
                case "_removeFromGroupDB" :
                    return $this->_removeFromGroupDB($args['0'], $args['1']);
                    break;
                case "_set_IDs" :
                    return $this->_set_IDs($args['0']);
                    break;
                case "_changeStatusDB" :
                    return $this->_changeStatusDB($args['0']);
                    break;
                case "_changeGroupStatusDB" :
                    return $this->_changeGroupStatusDB($args['0']);
                    break;
                case "_trashCompanyDB" :
                    return $this->_trashCompanyDB($args['0']);
                    break;
                case "_recycleCompanyDB" :
                    return $this->_recycleCompanyDB($args['0']);
                    break;
                case "_getSubCompanies" :
                    return $this->_getSubCompanies($args['0']);
                    break;
                case "_checkIfMemberExistsDB" :
                    return $this->_checkIfMemberExistsDB($args['0'], $args['1']);
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
            case '_groupCompany':
                $this->_groupCompany = $value;
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

            case 'companyList':
                return $this->_companyListDb;
                break;
            case 'companyFields':
                return $this->_companyFields;
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
     * @param $companyID
     * @param $value
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _set_companyListDb($companyID, $value = '')
    {
        if (!empty($companyID) && is_numeric($companyID) && is_array($value)) {

            $this->_companyListDb[$companyID] = $value;

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
    private function _set_InsertCompanyDB($insertedId, $value = '')
    {
        if (!empty($insertedId) && is_numeric($insertedId) && is_array($insertedId)) {
            $this->_companyFields[$insertedId] = $value;
        }

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
    private function _set_InsertCompanyGroupDB($insertedId, $value = '')
    {
        if (!empty($insertedId) && is_numeric($insertedId) && is_array($insertedId)) {
            $this->_groupCompany[$insertedId] = $value;
        }

    }

    /**
     * Specifies the type of output
     * @param $groupInfo
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _set_companyGroupFields($groupInfo)
    {

        $this->_groupCompany = $groupInfo;


    }

    /**
     * Specifies the type of output
     * @param $value
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _set_companyFields($value = '')
    {
        $this->_companyFields = $value;
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
     * Gets company based on its ID
     * @param $compID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getCompanyById($compID)
    {
        //global $lang;
        $conn = parent::getConnection();
        $sql = "SELECT
                    `comp_name` as Comp_Name,
                    `manager_name` as Manager_Name,
                    `address` as Address,
                    `phone_number` as Phone_Number,
                    `email` as Email,
                    `timezone` as timezone,
                    `comp_id` as comp_id

                FROM
                    tbl_company
                WHERE
                    comp_id= '$compID'";

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
        $this->_set_companyFields($row);
        $result['result'] = 1;
        return $result;

    }


    /**
     * Gets the sub companies
     * @param $compID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getSubCompanies($compID)
    {
        global $lang, $company_info, $admin_info;
        $conn = parent::getConnection();
        if ($compID == '') {
            $compID = $company_info['comp_id'];
        }


        $sql = "
          SELECT DISTINCT(comp_id)
                FROM  `tbl_company_group_relation`
                WHERE
                      `comp_id` = '$compID'
                  or
                      `comp_group_id`
                  IN    (
                          SELECT  `comp_group_id`
                          FROM    `tbl_company_group_relation`
                          WHERE   `comp_id`  = '$compID'
                          AND     `is_admin` = '1'
                         )
          ";
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
            $this->subCompanies[] = $row['comp_id'];
        }
        if (!in_array($company_info['comp_id'], $this->subCompanies)) {
            $this->subCompanies[] = $company_info['comp_id'];
        }
        $result['list'] = implode(',', $this->subCompanies);
        $result['listArray'] = $this->subCompanies;
        $result['result'] = 1;
        return $result;
    }


    /**
     * Gets company group
     * @param $compID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getCompanyGroupById($compID)
    {
        //global $lang;
        $conn = parent::getConnection();

        $sql = "SELECT
                    `group_name` as Group_Name,
                    `admin_creator` as Admin_Creator,
                    `comp_group_id` as comp_group_id

                FROM
                    tbl_company_group
                WHERE
                    comp_group_id= '$compID'
                ";

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
        $this->_set_companyFields($row);
        $result['result'] = 1;
        return $result;
    }

    /**
     * Gets company
     * @return  mixed
     * @param mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getCompany($fields = '')
    {

        global $admin_info,$company_info;
        $this->_checkPermission();
        $conn = parent::getConnection();
        $filter = $this->filterBuilder($fields);
        $length = $filter['length'];
        $filter = $filter['list'];
        if($company_info['comp_name']!='zitel')
        {
            $filter['filter'] = 'trash = 0 and comp_id='.$company_info['comp_id'];
        }


        $sql = "SELECT
                 `comp_name` as Comp_Name,
                 `manager_name` as Manager_Name,
                 `address` as Address,
                 `phone_number` as Phone_Number,
                 `email` as Email,
                 `comp_id` as comp_id,
                 `timezone` as timezone,
                 `comp_status` as Comp_Status
    		     FROM 	tbl_company" . $filter['WHERE'] . $filter['filter'] . $filter['order'] . $filter['limit'];



// استفاده از پارامترهای محافظت شده

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':compId', $company_info['comp_id'], PDO::PARAM_INT);
        //$stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        if (!$stmt) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }

        $sql = "
                SELECT COUNT(`tbl_company`.`comp_id`) as recCount
                FROM
                `tbl_company` " . $filter['WHERE'] . $filter['filter'];
        //echo $stmt->rowCount();

        $stmTp = $conn->prepare($sql);
        $stmTp->setFetchMode(PDO::FETCH_ASSOC);
        $stmTp->execute();
        $rowP = $stmTp->fetch();
        $rowFound = $rowP['recCount'];
        $this->_paging['recordsFiltered'] = $rowP['recCount'];
        $this->_paging['recordsTotal'] = $rowFound['found'];

        while ($row = $stmt->fetch()) {
            $this->_set_companyListDb($row['comp_id'], $row);
        }

        $result['result'] = 1;
        $result['no'] = 2;
        return $result;

    }

    /**
     * Checks if name exists
     * @return  mixed
     * @param $compGroupID
     * @param $compID
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _checkIfMemberExistsDB($compGroupID, $compID)
    {
        global $admin_info;
        $this->_checkPermission();
        $conn = parent::getConnection();

        $sql = "SELECT  *
    		    FROM 	tbl_company_group_relation
    		    WHERE   comp_id = '$compID' AND comp_group_id = '$compGroupID'";

        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        if (!$stmt) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;

        }

        if ($stmt->rowCount() >= 1) {
            $result['result'] = -2;
            $result['no'] = 2;
            $result['msg'] = ModelCOMPANY_01;
            return $result;
        }

        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }

    /**
     * Gets model list
     * @return  mixed
     * @param  $fields
     * @param  $GroupID
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getMembersList($fields, $GroupID)
    {
        global $lang;
        $this->_checkPermission();
        $conn = parent::getConnection();

        if (isset($fields['filter']['comp_name'])) {
            $append_sql = " AND c1.comp_name LIKE '%{$fields['filter']['comp_name']}%' ";
            unset($fields['filter']['comp_name']);

        }


        $filter = $this->filterBuilder($fields);

        $length = $filter['length'];
        $filter = $filter['list'];


        if ($filter['filter'] != '') {
            $filter['filter'] = ' AND ' . $filter['filter'];
        }
        $sql = "
          SELECT    `c1`.`comp_name` as comp_name,
                    `c1`.`comp_id` as comp_id,
                    `c2`.`comp_group_id` as comp_group_id,
                    `c2`.`is_admin` as is_admin
          FROM      tbl_company c1 JOIN tbl_company_group_relation c2
          WHERE     `c1`.`comp_id` = `c2`.`comp_id` AND `c2`.`comp_group_id`='$GroupID'
          " . $append_sql . $filter['filter'] . $filter['order'] . $filter['limit'];


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
                SELECT COUNT(`c1`.`comp_id`) as recCount
                FROM
                tbl_company c1 JOIN tbl_company_group_relation c2
                WHERE     `c1`.`comp_id` = `c2`.`comp_id` AND `c2`.`comp_group_id`='$GroupID'
              " . $append_sql . $filter['filter'];

        $stmTp = $conn->prepare($sql);
        $stmTp->setFetchMode(PDO::FETCH_ASSOC);
        $stmTp->execute();
        $rowP = $stmTp->fetch();
        $rowFound = $rowP['recCount'];
        $this->_paging['recordsFiltered'] = $rowP['recCount'];
        $this->_paging['recordsTotal'] = $rowFound['found'];

        while ($row = $stmt->fetch()) {
            $this->_set_companyListDb($row['comp_id'], $row);
        }

        $result['result'] = 1;
        $result['no'] = 2;
        return $result;

    }

    /**
     * Gets company group
     * @param  $fields
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getCompanyGroup($fields)
    {
        //global $lang;
        $this->_checkPermission();
        $conn = parent::getConnection();
        $fields['useTrash'] = 'false';
        $filter = $this->filterBuilder($fields);
        $length = $filter['length'];
        $filter = $filter['list'];

        $sql = "
                SELECT
                `group_name` as Group_Name,
                `comp_group_id` as comp_group_id,
                `group_status` as Group_Status

                FROM 	tbl_company_group" .
            $filter['WHERE'] . $filter['filter'] . $filter['order'] . $filter['limit'];

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
            SELECT COUNT(`tbl_company_group`.`comp_group_id`) as recCount
            FROM    `tbl_company_group`
           " . $filter['WHERE'] . $filter['filter'];
        //echo $stmt->rowCount();

        $stmTp = $conn->prepare($sql);
        $stmTp->setFetchMode(PDO::FETCH_ASSOC);
        $stmTp->execute();
        $rowP = $stmTp->fetch();
        $rowFound = $rowP['recCount'];
        $this->_paging['recordsFiltered'] = $rowP['recCount'];
        $this->_paging['recordsTotal'] = $rowFound['found'];

        while ($row = $stmt->fetch()) {
            $this->_set_companyListDb($row['comp_group_id'], $row);
        }

        $result['result'] = 1;
        $result['no'] = 2;
        return $result;

    }

    /**
     * Inserts company
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _insertCompanyDB()
    {
        global $comp_id;
        // global $lang;
        $conn = parent::getConnection();

        $sql = "
    INSERT INTO tbl_company(
        comp_name,
        manager_name,
        address,
        email,
        phone_number,
        comp_status,
        support_name,
        trash,
        support_phone,
        support_email,
        timezone
    )
    VALUES(
        '" . $this->_companyFields['Comp_Name'] . "',
        '" . $this->_companyFields['Manager_Name'] . "',
        '" . $this->_companyFields['Address'] . "',
        '" . $this->_companyFields['Email'] . "',
        '" . $this->_companyFields['Phone_Number'] . "',
        '" . $this->_companyFields['comp_status'] = "1" . "',    
        '" . $this->_companyFields['support_name'] = "Zitel" . "',
        '" . $this->_companyFields['trash'] = "0" . "',      
        '" . $this->_companyFields['support_phone'] = "1" . "',
        '" . $this->_companyFields['support_email'] = "Zitel" . "',
        '" . $this->_companyFields['timezone'] . "'
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
        // Assign the value to the global variable
        $comp_id = $insertedId;
        $this->_companyFields['comp_id'] = $insertedId;
        $this->_set_InsertCompanyDB($insertedId, $this->_companyFields);
        $result['result'] = 1;
        $result['Number'] = 2;
        return $result;
    }

    /**
     * Inserts company to group
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _insertCompanyToGroupDB()
    {

        //global $lang;
        $conn = parent::getConnection();

        $sql = "
        INSERT INTO tbl_company_group_relation(
        comp_id,
        comp_group_id,
        is_admin
        )
        VALUES";

        foreach ($this->_groupCompany as $compID => $groupList) {
            foreach ($groupList as $groupID => $value) {
                $sql .= "(
                            '" . $compID . "',
                            '" . $groupID . "',
                            '" . $value . "'
                            ),";
            }
        }


        $sql = substr($sql, 0, -1);
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        //echo '<pre/>';
        //print_r($stmt);
        //die($stmt);
        if (!$stmt) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = 'DB error : ' . $conn->errorInfo();
            return $result;
        }

        $insertedId = $conn->lastInsertId();
        $this->_groupCompany['comp_id'] = $insertedId;
        $this->_set_InsertCompanyGroupDB($insertedId, $this->_groupCompany);
        $result['result'] = 1;
        $result['Number'] = 2;
        return $result;

    }

    /**
     * Insert company group
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _insertCompanyGroupDB()
    {
        global $lang;
        // echo $id;
        $conn = parent::getConnection();
        $sql = "
                INSERT INTO tbl_company_group(
                group_name)
                VALUES(
                '" . $this->_companyFields['Group_Name'] . "')";

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
        $this->_companyFields['comp_id'] = $insertedId;
        $this->_set_InsertCompanyDB($insertedId, $this->_companyFields);
        $result['result'] = 1;
        $result['Number'] = 2;
        return $result;
    }

    /**
     * Update company
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _updateCompanyDB()
    {
        //global $lang;
        $conn = parent::getConnection();
        $compID = $this->_companyFields['id'];

        $sql = "
                UPDATE tbl_company
                SET
                comp_name =   '" . $this->_companyFields['Comp_Name'] . "',
                manager_name ='" . $this->_companyFields['Manager_Name'] . "',
                address =  '" . $this->_companyFields['Address'] . "',
                email =  '" . $this->_companyFields['Email'] . "',
                phone_number =    '" . $this->_companyFields['Phone_Number'] . "',
                timezone = '" . $this->_companyFields['timezone'] . "'
                WHERE comp_id = $compID;
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
     * Update company group
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _updateCompanyGroupDB()
    {
        //global $lang;
        $conn = parent::getConnection();
        $compID = $this->_companyFields['id'];

        $sql = "UPDATE tbl_company_group
                SET    group_name =   '" . $this->_companyFields['Group_Name'] . "'
                WHERE comp_group_id = $compID;
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
     * Remove company
     * @param $compID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _removeCompanyDB($compID)
    {
        global $conn;
        $conn = parent::getConnection();

        $sql = "
           DELETE
           FROM 	tbl_company
		   WHERE    comp_id= '$compID'";

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
     * Remove company from group
     * @param $groupId
     * @param $compID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    function removeAllCompanyFromGroupDB($compID)
    {
        global $conn;
        $conn = parent::getConnection();

        $sql = "DELETE
                FROM 	tbl_company_group_relation
		        WHERE    comp_id = '$compID' ";


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
     * Remove company from group
     * @param $groupId
     * @param $compID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _removeFromGroupDB($groupId, $compID)
    {
        global $conn;
        $conn = parent::getConnection();

        $sql = "DELETE
                FROM 	tbl_company_group_relation
		        WHERE    comp_id = '$compID' AND comp_group_id = '$groupId'";


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
                UPDATE 	tbl_company
			    SET     comp_status=$val
				WHERE   comp_id in ($listId) ";

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
     * changeStatus set flag in status
     * @param $val
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/09/2015
     */
    private function _changeGroupStatusDB($val)
    {
        //global  $lang;
        $conn = parent::getConnection();
        $listId = implode(',', $this->_IDs);

        $sql = "
                UPDATE 	tbl_company_group
			    SET     group_status=$val
				WHERE   comp_group_id in ($listId) ";

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
     * Trash company
     * @param $companyID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _trashCompanyDB($companyID)
    {
        global $conn;
        $conn = parent::getConnection();

        $sql = "
           UPDATE   tbl_company
           SET	    trash = 1
		   WHERE    comp_id= '$companyID'";

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
     * Recycle company
     * @param $companyID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _recycleCompanyDB($companyID)
    {
        global $conn;
        $conn = parent::getConnection();

        $sql = "
           UPDATE   tbl_company
           SET	    trash = 0
		   WHERE    comp_id= '$companyID'";

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
     * Updates reload
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public static function updateReload()
    {
        global $company_info;
        $conn = dbConn::getConnection();

        $sql = "
                UPDATE tbl_company
                SET
                reload_alert =   '1'
                WHERE comp_id = '" . $company_info['comp_id'] . "' ";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result['result'] = '1';
        return $result;
    }
}
