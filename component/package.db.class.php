<?php
/**
 * @author Malekloo Izadi Sakhamanesh <Izadi@dabacenter.ir>
 * @version 0.0.1 this is the beta version of sip
 * @copyright 2015 The Imen Daba Parsian Co.
 */
class Package_db extends DataBase
{


    /** Contains each field
     * @var
     */
    private $_PackageFields;

    /** Contains each field
     * @var
     */
    private  $_paging;
    /**
     * Contains sip list
     * @var array
     */
    private $_PackageListDb;
    /**
     * Contains sip list
     * @var array
     */
    private $_IDs;
    /**
     * Contains company list
     * @var array
     */
    public $subCompanies;

    /**
     * Specifies the type of output
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function __construct()
    {
        $this->_PackageListDb = array();
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
                case "_updatePackageCompany" :
                    return $this->_updatePackageCompany($args['0']);
                    break;
                case "_insertPackageCompany" :
                    return $this->_insertPackageCompany($args['0']);
                    break;
                case "_set_groupPackageFields" :
                    return $this->_set_groupPackageFields($args['0']);
                    break;
                case "_getSalablePackages" :
                    return $this->_getSalablePackages($args['0'],$args['1']);
                    break;
                case "_getCompanyPackages" :
                    return $this->_getCompanyPackages($args['0']);
                    break;
                case "_set_IDs" :
                    return $this->_set_IDs($args['0']);
                    break;
                case "_showInvoiceDB" :
                    return $this->_showInvoiceDB();
                    break;
                case "_getCompany" :
                    return $this->_getCompany($args['0']);
                    break;
                case "_checksIfLogIDExistsInPackageCompany" :
                    return $this->_checksIfLogIDExistsInPackageCompany($args['0']);
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
        switch($property)
        {
            case 'paging':
                $this->_paging=$value;

                break;
            default:
                $this->_set_groupPackageFields(array($property=>$value));
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
        switch ($field)
        {
            case 'PackageListDb':
                return $this->_PackageListDb;
                break;
            case 'PackageFields':
                return $this->_PackageFields;
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
     * @param $GroupPackageID
     * @param   $value
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    private function _set_groupPackageListDb($GroupPackageID,$value = '')
    {

        if (!empty($GroupPackageID) && is_numeric($GroupPackageID) && is_array($value))
        {

            $this->_PackageListDb[$GroupPackageID] = $value;
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
     * @date    08/08/2015
     */
    private function _set_insertGroupPackagesDB($insertedId, $value = '')
    {
        if (!empty($insertedId) && is_numeric($insertedId) && is_array($value))
        {
            $this->_PackageFields[$insertedId] = $value;
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
        $this->_PackageFields = $value;
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
    private function _set_IDs($value='')
    {

        $result['result'] = 1;

        foreach($value as $key => $val )
        {
            if (is_numeric($val) && !empty($val))
            {
                $this->_IDs[$key]=$val;
            }else
            {
                $msg="$val not Valid";
                if($result['result']==1)
                {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;
                $result['msgList'][$key] =  $msg;
            }
        }

        return $result;
    }


    /**
     * Gets group Packages
     * @return  mixed
     * @param  $fields
     * @param  $compID
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.02.02
     * @since   01.01.01
     * @date    08/08/2015
     */
    private function _getSalablePackages($fields='',$compID)
    {
        global $lang,$admin_info;
        $fields['useTrash']='false';
        $filter=$this->filterBuilder($fields);
        $length=$filter['length'];
        $filter=$filter['list'];
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
                `tbl_package_group`.`package_group_id` WHERE `tbl_package_group_company`.`comp_id` = ".$compID.")
                AS `t1`

              ".$filter['WHERE'] .$filter['filter'].$filter['order'].$filter['limit'];

        //or WHERE    news_id='$id' ");
        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        if (!$stmt)
        {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }

        $sql="
          SELECT COUNT(`tbl_package`.`id`) as recCount
          FROM
          `tbl_package` ".$filter['WHERE'] .$filter['filter'];

        $stmtP = $conn->prepare($sql);
        $stmtP->setFetchMode(PDO::FETCH_ASSOC);
        $stmtP->execute();
        $rowP = $stmtP->fetch();
        $rowFound=$rowP['recCount'];
        $this->_paging['recordsFiltered']=$rowP['recCount'];
        $this->_paging['recordsTotal']= $rowFound['found'];
        //echo $stmt->rowCount();
        while ($row = $stmt->fetch())
        {
            $row['comp_id']=$compID;
            $this->_set_groupPackageListDb($row['id'], $row);
        }

        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }

    /**
     * Gets company Packages
     * @return  mixed
     * @param  $fields
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.02.02
     * @since   01.01.01
     * @date    08/08/2015
     */
    private function _getCompanyPackages($fields='')
    {
        global $lang;
        //echo '<pre>';
        $fields['useTrash']='false';
        //print_r($fields);
        $filter=$this->filterBuilder($fields);
        $length=$filter['length'];
        $filter=$filter['list'];

        include_once(ROOT_DIR . "component/company.operation.class.php");
        $company_operation = new company_operation;
        $result = $company_operation->getSubCompanies();
        $appendSql = "WHERE comp_id in (" . $result['list'] . ") ";

        if($filter['filter'] != '')
        {
            $filter['filter'] = ' AND '. $filter['filter'];
        }

        $this->_checkPermission();
        $conn = parent::getConnection();
        $sql = "SELECT
              `t1`.*
              FROM
              (SELECT
                      `tbl_package_company`.*,
                      `tbl_company`.`comp_name`,
                      `tbl_package`.`package_name`,
                      `tbl_package`.`price`,
                      `tbl_package`.`duration`,
                      `tbl_package`.`package_status`
                    FROM
                      `tbl_package_company`
                      LEFT JOIN `tbl_company` ON `tbl_package_company`.`comp_id` =
                        `tbl_company`.`comp_id`
                      LEFT JOIN `tbl_package` ON `tbl_package_company`.`package_id` =
                        `tbl_package`.`id`) AS `t1`
              ".$appendSql.$filter['WHERE'] .$filter['filter'].$filter['order'].$filter['limit'];

        //or WHERE    news_id='$id' ");
        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        if (!$stmt)
        {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }

        $sql="
          SELECT COUNT(`tbl_package_company`.`id`) as recCount
        FROM
          `tbl_package_company`  ".$filter['WHERE'] .$filter['filter'];

        $stmtP = $conn->prepare($sql);
        $stmtP->setFetchMode(PDO::FETCH_ASSOC);
        $stmtP->execute();
        $rowP = $stmtP->fetch();
        $rowFound=$rowP['recCount'];
        $this->_paging['recordsFiltered']=$rowP['recCount'];
        $this->_paging['recordsTotal']= $rowFound['found'];

        //echo $stmt->rowCount();
        while ($row = $stmt->fetch()) {
            $this->_set_groupPackageListDb($row['id'], $row);
        }

        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }

    /**
     * Gets group Packages
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.02.02
     * @since   01.01.01
     * @date    08/08/2015
     */
    private function _showInvoiceDB()
    {
        global $lang;

        $this->_checkPermission();
        $conn = parent::getConnection();
        $sql = "SELECT *
                FROM tbl_invoice
              ";

        //or WHERE    news_id='$id' ");
        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        if (!$stmt)
        {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }

        //echo $stmt->rowCount();
        while ($row = $stmt->fetch()) {
            $this->_set_groupPackageListDb($row['id'], $row);
        }

        $result['result'] = 1;
        $result['no'] = 2;
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
    private function _getCompany($fields='')
    {
        global $lang;
        $filter = $this->filterBuilder($fields);
        include_once(ROOT_DIR . "component/company.operation.class.php");
        $company_operation = new company_operation;
        $result = $company_operation->getSubCompanies();
        $length = $filter['length'];
        $filter = $filter['list'];
        $appendSql = "WHERE comp_id in (" . $result['list'] . ") ";

        if($filter['filter'] != '')
        {
            $filter['filter'] = ' AND '. $filter['filter'];
        }

        $this->_checkPermission();
        $conn = parent::getConnection();

        $sql = "SELECT
                 `comp_name` as Comp_Name,
                 `manager_name` as Manager_Name,
                 `address` as Address,
                 `phone_number` as Phone_Number,
                 `email` as Email,
                 `comp_id` as comp_id,
                 `comp_status` as Comp_Status
    		     FROM 	tbl_company
    		     ".$appendSql.$filter['filter'].$filter['order'].$filter['limit'];

        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        if (!$stmt)
        {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }

        $sql="
                SELECT COUNT(`tbl_company`.`comp_id`) as recCount
                FROM
                `tbl_company` ".$appendSql.$filter['filter'];
        //echo $stmt->rowCount();

        $stmTp = $conn->prepare($sql);
        $stmTp->setFetchMode(PDO::FETCH_ASSOC);
        $stmTp->execute();
        $rowP = $stmTp->fetch();

        $rowFound=$rowP['recCount'];
        $this->_paging['recordsFiltered']=$rowP['recCount'];
        $this->_paging['recordsTotal']= $rowFound['found'];

        while ($row = $stmt->fetch())
        {
            $this->_set_groupPackageListDb($row['comp_id'], $row);
        }

        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }

    /**
     * Checks If LogID Exists In Package Company
     * @param  $LogID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.02.02
     * @since   01.01.01
     * @date    08/08/2015
     */
    private function _checksIfLogIDExistsInPackageCompany($LogID)
    {
        global $lang,$admin_info;

        $this->_checkPermission();
        $conn = parent::getConnection();

        $sql = "
               SELECT *
               FROM  tbl_package_company
               WHERE log_id = '$LogID'
               ";

        //or WHERE    news_id='$id' ");
        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        if (!$stmt)
        {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }

        $result['exist'] =$stmt->rowCount();

        return $result;
    }


    /**
     * Update Package Company
     * @param  $fields
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    private function _updatePackageCompany($fields)
    {
        $logID = $fields['id'];
        global $lang;
        $conn = parent::getConnection();

        $sql = "UPDATE   tbl_package_company
                SET      comp_id = '". $fields['order_for'] . "',
                         package_id = '". $fields['package_id'] . "',
                         extension_count = '". $fields['extension_count'] . "',
                         assign_date = '". $fields['issue_date'] . "',
                         expire_date = '". $fields['expire_date'] . "',
                         start_date = '". $fields['start_date'] . "',
                         log_id = '". $fields['log_id'] . "'

                WHERE    log_id= '$logID'";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        if (!$stmt)
        {
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
     * Insert Package Company
     * @param  $fields
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    private function _insertPackageCompany($fields)
    {
        $logID = $fields['id'];
        global $lang;
        $conn = parent::getConnection();

        $sql = "INSERT INTO   tbl_package_company
                               (comp_id,
                                package_id,
                                extension_count,
                                assign_date,
                                expire_date,
                                start_date,
                                log_id)
                                VALUES(
                                '". $fields['order_for'] . "',
                                '". $fields['package_id'] . "',
                                '". $fields['extension_count'] . "',
                                '". $fields['issue_date'] . "',
                                '". $fields['expire_date'] . "',
                                '". $fields['start_date'] . "',
                                '". $logID . "'
                                )";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        if (!$stmt)
        {
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
     * Insert Package Company
     * @param  $sign
     * @param  $CompID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    public static function calculateExtension($sign, $CompID)
    {
        global $admin_info,$lang,$company_info;
        $conn = parent::getConnection();

        if($CompID == '')
        {
            $CompID = $company_info['comp_id'] ;
        }



            if($sign == '+')
        {
            $sql = "
                    UPDATE   tbl_package_company
                    SET      package_usage = package_usage + 1
                    WHERE    comp_id = '$CompID'
                    ";

            $stmt = $conn->prepare($sql);
            $stmt->execute();

            if (!$stmt)
            {
                $result['result'] = -1;
                $result['no'] = 1;
                $result['msg'] = 'DB error : ' . $conn->errorInfo();
                return $result;
            }
        }

        elseif($sign == '-')
        {
            $sql = "
                    UPDATE   tbl_package_company
                    SET      package_usage = package_usage - 1
                    WHERE    comp_id = '$CompID'
                    ";

            $stmt = $conn->prepare($sql);
            $stmt->execute();

            if (!$stmt)
            {
                $result['result'] = -1;
                $result['no'] = 1;
                $result['msg'] = 'DB error : ' . $conn->errorInfo();
                return $result;
            }
        }
    }

    /**
     * checks Extension Count
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    public function checkExtensionCount()
    {
        global $lang,$admin_info,$company_info;
        $compID = $company_info['comp_id'];
        $conn = parent::getConnection();

        $sql = "SELECT *
                FROM   tbl_package_company
                WHERE  comp_id= '$compID'";

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
            $this->_set_groupPackageListDb($row['id'], $row);
        }

        $keys = array_keys($this->PackageListDb);
        $extensionCount = $this->PackageListDb[$keys['0']]['extension_count'];
        $packageUsage = $this->PackageListDb[$keys['0']]['package_usage'];


        if($extensionCount - $packageUsage <= '0') {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = ModelPACKAGE_01;
            return $result;
        }

        $result['result'] = 1;
        $result['no'] = 2;
        return $result;

    }


}
