<?php

/**
 * @author Malekloo Izadi Sakhamanesh <Izadi@dabacenter.ir>
 * @version 0.0.1 this is the beta version of sip
 * @copyright 2015 The Imen Daba Parsian Co.
 */
class packageLog_db extends DataBase
{
    /** Contains each field
     * @var
     */
    private $_packageLogFields;
    /** Contains each field
     * @var
     */
    private $_paging;
    /**
     * Contains sip list
     * @var array
     */
    private $_packageLogListDb;
    /**
     * Contains sip list
     * @var array
     */
    private $_IDs;
    /**
     * Contains sip list
     * @var array
     */
    private $_basketToPackageLogListDb;

    /**
     * Specifies the type of output
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function __construct()
    {
        $this->_packageLogListDb = array();
    }

    /**
     * Specifies the type of output
     * @param   $method
     * @param   $args
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    function __call($method, $args)
    {

        $method = '_' . $method;

        if (method_exists($this, $method)) {
            switch ($method) :
                case "_set_packageLogFields" :
                    return $this->_set_packageLogFields($args['0']);
                    break;
                case "_set_packageLogListDb" :
                    return $this->_set_packageLogListDb($args['0']);
                    break;
                case "_getSalablePackages" :
                    return $this->_getSalablePackages($args['0']);
                    break;
                case "_getCompanyPackages" :
                    return $this->_getCompanyPackages($args['0']);
                    break;
                case "_set_IDs" :
                    return $this->_set_IDs($args['0']);
                    break;
                case "_showPackageLogDB" :
                    return $this->_showPackageLogDB($args['0']);
                    break;
                case "_getLastPackageDB" :
                    return $this->_getLastPackageDB($args['0']);
                    break;
                case "_addLogDB" :
                    return $this->_addLogDB();
                    break;
                case "_getLogDB" :
                    return $this->_getLogDB();
                    break;
                case "_set_basketToPackageLogListDb" :
                    return $this->_set_basketToPackageLogListDb($args['0']);
                    break;
                case "_getPackageBySerialNumber" :
                    return $this->_getPackageBySerialNumber($args['0']);
                    break;
                case "_getLastPackageByOrderForDB" :
                    return $this->_getLastPackageByOrderForDB($args['0']);
                    break;
                case "_updateExpiryForLastPackage" :
                    return $this->_updateExpiryForLastPackage($args['0'], $args['1']);
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
     * @date    08/08/2015
     */
    public function __set($property, $value)
    {
        switch ($property) {
            case 'paging':
                $this->_paging = $value;
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
     * @date    08/08/2015
     */
    public function __get($field)
    {
        switch ($field) {
            case 'packageLogListDb':
                return $this->_packageLogListDb;
                break;
            case 'packageLogFields':
                return $this->_packageLogFields;
                break;
            case 'paging':
                return $this->_paging;
                break;
            case 'basketToPackageLogListDb':
                return $this->_basketToPackageLogListDb;
                break;
            default:
                break;
        }
    }


    /**
     * Specifies the type of output
     * @param $GroupPackageID
     * @param   $value
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    private function _set_packageLogListDb($GroupPackageID, $value = '')
    {
        if (!empty($GroupPackageID) && is_numeric($GroupPackageID) && is_array($value)) {
            $this->_packageLogListDb[$GroupPackageID] = $value;
        }
        $result['result'] = 1;
        return $result;
    }

    /**
     * Specifies the type of output
     * @param $value
     * @param   $value
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    private function _set_basketToPackageLogListDb($value = '')
    {
        $this->_basketToPackageLogListDb = $value;
        $result['result'] = 1;
        return $result;
    }

    /**
     * Specifies the type of output
     * @param $value
     * @param   $value
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    private function _set_packageLogFields($value = '')
    {
        $this->_packageLogFields = $value;
        $result['result'] = 1;
        $result['no'] = 1;
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
     * @date    08/08/2015
     */
    private function _set_insertGroupPackagesDB($insertedId, $value = '')
    {
        if (!empty($insertedId) && is_numeric($insertedId) && is_array($value)) {
            $this->_packageLogFields[$insertedId] = $value;
        }

    }

    /**
     * Specifies the type of output
     * @param $value
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    private function _set_groupPackageFields($value = '')
    {
        $this->_packageLogFields = $value;
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
     * Get Salable Packages
     * @return  mixed
     * @param  $fields
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.02.02
     * @since   01.01.01
     * @date    08/08/2015
     */
    private function _getSalablePackages($fields = '')
    {
        global $lang;
        $filter = $this->filterBuilder($fields);
        $length = $filter['length'];
        $filter = $filter['list'];
        $this->_checkPermission();
        $conn = parent::getConnection();

        $sql = "  SELECT
              `t1`.*
               FROM
              (SELECT
                `tbl_package`.*,
                `tbl_package_group_company`.`comp_id`,
                `tbl_package_group_company`.`assign_date`,
                `tbl_package_group`.`package_group_name`
                FROM
                `tbl_package_group_company`
                INNER JOIN `tbl_package_group_relation`
                ON `tbl_package_group_company`.`package_group_id` =
                `tbl_package_group_relation`.`package_group_id`
                INNER JOIN `tbl_package` ON `tbl_package_group_relation`.`package_id` =
                `tbl_package`.`id`
                INNER JOIN `tbl_package_group`
                ON `tbl_package_group_relation`.`package_group_id` =
                `tbl_package_group`.`package_group_id`) AS `t1`
              " . $filter['WHERE'] . $filter['filter'] . $filter['order'] . $filter['limit'];

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
              SELECT COUNT(`tbl_package`.`id`) as recCount
              FROM
              `tbl_package`
             ";

        $stmtP = $conn->prepare($sql);
        $stmtP->setFetchMode(PDO::FETCH_ASSOC);
        $stmtP->execute();
        $rowP = $stmtP->fetch();
        $rowFound = $rowP['recCount'];
        $this->_paging['recordsFiltered'] = $rowP['recCount'];
        $this->_paging['recordsTotal'] = $rowFound['found'];

        //echo $stmt->rowCount();
        while ($row = $stmt->fetch()) {
            $this->_set_packageLogListDb($row['id'], $row);
        }

        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }

    /**
     * Gets Company Packages
     * @return  mixed
     * @param  $fields
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.02.02
     * @since   01.01.01
     * @date    08/08/2015
     */
    private function _getCompanyPackages($fields = '')
    {
        global $lang;
        $filter = $this->filterBuilder($fields);
        $length = $filter['length'];
        $filter = $filter['list'];
        $this->_checkPermission();
        $conn = parent::getConnection();

        $sql = "  SELECT
              `t1`.*
            FROM
              (SELECT
                      `tbl_package_company`.*,
                      `tbl_company`.`comp_name`,
                      `tbl_package`.`package_name`,
                      `tbl_package`.`price`,
                      `tbl_package`.`extension_count` AS `extension_count1`,
                      `tbl_package`.`duration`,
                      `tbl_package`.`package_status`
                    FROM
                      `tbl_package_company`
                      LEFT JOIN `tbl_company` ON `tbl_package_company`.`comp_id` =
                        `tbl_company`.`comp_id`
                      RIGHT JOIN `tbl_package` ON `tbl_package_company`.`package_id` =
                        `tbl_package`.`id`) AS `t1`
              " . $filter['WHERE'] . $filter['filter'] . $filter['order'] . $filter['limit'];

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
          SELECT COUNT(`tbl_package_company`.`id`) as recCount
          FROM
          `tbl_package_company`  ";

        $stmtP = $conn->prepare($sql);
        $stmtP->setFetchMode(PDO::FETCH_ASSOC);
        $stmtP->execute();
        $rowP = $stmtP->fetch();
        $rowFound = $rowP['recCount'];
        $this->_paging['recordsFiltered'] = $rowP['recCount'];
        $this->_paging['recordsTotal'] = $rowFound['found'];

        //echo $stmt->rowCount();
        while ($row = $stmt->fetch()) {
            $this->_set_packageLogListDb($row['id'], $row);
        }

        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }

    /**
     * Show Package Log DB
     * @param  $fields
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.02.02
     * @since   01.01.01
     * @date    08/08/2015
     */
    private function _showPackageLogDB($fields)
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

        if ($filter['filter'] != '') {
            $filter['filter'] = ' AND ' . $filter['filter'];
        }

        $sql = "SELECT
              `t1`.*
              FROM
              (SELECT
              `log_package_company`.*, `tbl_package`.`package_name`, `tbl_company`.`comp_name`
               FROM
              `log_package_company`
               LEFT JOIN
              `tbl_package` ON `log_package_company`.`package_id` = `tbl_package`.`id`
               RIGHT JOIN `tbl_company` ON `log_package_company`.`order_for` =
                        `tbl_company`.`comp_id`
              ORDER BY `log_package_company`.`issue_date` DESC
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
              SELECT COUNT(`log_package_company`.`id`) as recCount
              FROM `log_package_company`  WHERE comp_id in (" . $result['list'] . ") " . $filter['filter'];

        $stmtP = $conn->prepare($sql);
        $stmtP->setFetchMode(PDO::FETCH_ASSOC);
        $stmtP->execute();
        $rowP = $stmtP->fetch();
        $rowFound = $rowP['recCount'];
        $this->_paging['recordsFiltered'] = $rowP['recCount'];
        $this->_paging['recordsTotal'] = $rowFound['found'];

        if (!$stmt) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }

        //echo $stmt->rowCount();
        while ($row = $stmt->fetch()) {
            $this->_set_packageLogListDb($row['id'], $row);
        }

        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }

    /**
     * Get Last Package DB
     * @param  mixed
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.02.02
     * @since   01.01.01
     * @date    08/08/2015
     */
    private function _getLastPackageDB($CompID)
    {
        global $lang, $admin_info, $company_info;

        if ($CompID == '') {
            $CompID = $company_info['comp_id'];
        }

        $this->_checkPermission();
        $conn = parent::getConnection();

        $sql = "
               SELECT *
               FROM log_package_company
               WHERE comp_id = $CompID
               ORDER BY expire_date DESC LIMIT 1
               ";

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
        if ($stmt->rowCount() >= 1) {
            //echo $stmt->rowCount();
            while ($row = $stmt->fetch()) {
                $this->_set_packageLogListDb($row['id'], $row);
            }

            $result['result'] = 1;
            $result['no'] = 2;
            return $result;
        } else {
            $result['result'] = -1;
            $result['no'] = 1000;
            return $result;
        }
    }

    /**
     * Get Last Package By Order For DB
     * @param  mixed
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.02.02
     * @since   01.01.01
     * @date    08/08/2015
     */
    private function _getLastPackageByOrderForDB($orderFor)
    {
        global $lang, $admin_info;

        $this->_checkPermission();
        $conn = parent::getConnection();
        $sql = "
               SELECT *
               FROM log_package_company
               WHERE order_for = $orderFor
               ORDER BY expire_date DESC LIMIT 1
               ";


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

        if ($stmt->rowCount() >= 1) {
            //echo $stmt->rowCount();
            while ($row = $stmt->fetch()) {
                $this->_set_packageLogListDb($row['id'], $row);
            }

            $result['result'] = 1;
            $result['no'] = 2;
            return $result;
        } else {
            $result['result'] = -1;
            $result['no'] = 1000;
            return $result;
        }

    }


    /**
     * Update Expiry For Last Package
     * @param  $orderFor
     * @param  $logID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    private function _updateExpiryForLastPackage($orderFor, $logID)
    {
        global $lang;
        $conn = parent::getConnection();
        $date = date('Y-m-d H:i:s');
        /*$keys = array_keys($this->_packageLogListDb);
        $expiryDate = $this->_packageLogListDb[$keys['0']]['expire_date'];*/
        $newExpiryDate = date("Y-m-d H:i:s", strtotime("-1 second", strtotime($date)));

        $sql = "UPDATE   log_package_company
                SET      expire_date = '" . $newExpiryDate . "'
                WHERE    order_for = '$orderFor' AND id = '$logID'";

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
     * Add Log DB
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.02.02
     * @since   01.01.01
     * @date    08/08/2015
     */
    private function _addLogDB()
    {
        global $lang, $admin_info, $company_info;

        if ($CompID == '') {
            $CompID = $company_info['comp_id'];

        }

        $admin_id = $admin_info['admin_id'];
        $comment = '';

        $this->_checkPermission();
        $conn = parent::getConnection();

        $append_sql = "INSERT INTO log_package_company
                        (`comp_id`,`issue_date`,`start_date`,`expire_date`,`package_id`,
                        `creator`,`duration`,`comment`,`extension_count`,`order_for`,
                        `price`,`total_price`,`serial`,`pay_date`,`payment_type`) VALUES ";

        //$keyList= array_keys($this->basketToPackageLogListDb);

        //$this->_getPackageBySerialNumber();
        foreach ($this->basketToPackageLogListDb as $key => $fields) {

            $fields['payment_type'] = 'online';
            $fields['pay_date'] = 'NOW()';
            $append_sql .= "('" . $CompID . "','" . $fields['issue_date'] . "','" . $fields['start_date'] . "','" . $fields['new_expire_date'] . "','" . $fields['package_id'] . "','" .
                $admin_id . "','" . $fields['duration'] . "','" . $comment . "','" . $fields['extension_count'] . "','" . $fields['order_for'] . "','" .
                $fields['price'] . "','" . $fields['total_price'] . "','" . $fields['invoice_id'] . "','" . $fields['pay_date'] . "','" . $fields['payment_type'] . "'),";
        }

        $append_sql = substr($append_sql, 0, -1);

        //or WHERE    news_id='$id' ");
        $stmt = $conn->prepare($append_sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        if (!$stmt) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }

        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }

    /**
     * Get Package By Serial Number
     * @param  $SerialNo
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.02.02
     * @since   01.01.01
     * @date    08/08/2015
     */
    private function _getPackageBySerialNumber($SerialNo)
    {
        global $lang, $admin_info, $company_info;

        if ($CompID == '') {
            $CompID = $company_info['comp_id'];
        }

        $this->_checkPermission();
        $conn = parent::getConnection();

        $sql = "
               SELECT *
               FROM log_package_company
               WHERE serial = $SerialNo
               ";


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

        $result['count'] = $stmt->rowCount();

        if ($stmt->rowCount() >= 1) {
            //echo $stmt->rowCount();
            while ($row = $stmt->fetch()) {
                $result['list'][$row['id']] = $row;
            }

            $result['result'] = 1;
            $result['no'] = 2;
            return $result;
        } else {
            $result['result'] = -1;
            $result['no'] = 1000;
            return $result;
        }
    }


    /**
     * Get Log DB
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.02.02
     * @since   01.01.01
     * @date    08/08/2015
     */
    private function _getLogDB()
    {
        global $lang, $admin_info;

        $this->_checkPermission();
        $conn = parent::getConnection();

        $sql = "
               SELECT *
               FROM log_package_company
               ";


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

        //echo $stmt->rowCount();
        while ($row = $stmt->fetch()) {
            $this->_set_packageLogListDb($row['id'], $row);
        }

        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }

}

