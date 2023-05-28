<?php
/**
 * @author Malekloo Izadi Sakhamanesh <Izadi@dabacenter.ir>
 * @version 0.0.1 this is the beta version of sip
 * @copyright 2015 The Imen Daba Parsian Co.
 */
class admin_Package_db extends DataBase
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
                case "_set_groupPackageFields" :
                    return $this->_set_groupPackageFields($args['0']);
                    break;
                case "_insertGroupPackagesDB" :
                    return $this->_insertGroupPackagesDB();
                    break;
                case "_insertPackagesDB" :
                    return $this->_insertPackagesDB();
                    break;
                case "_insertPackageToGroupDB" :
                    return $this->_insertPackageToGroupDB();
                    break;
                case "_insertPackageToCompanyDB" :
                    return $this->_insertPackageToCompanyDB();
                    break;
                case "_updatePackageToCompanyDB" :
                    return $this->_updatePackageToCompanyDB();
                    break;
                case "_removePackageFromCompanyDB" :
                    return $this->_removePackageFromCompanyDB();
                    break;
                case "_checkIfPackageExists" :
                    return $this->_checkIfPackageExists();
                    break;
                case "_insertGroupPackagesToCompany" :
                    return $this->_insertGroupPackagesToCompany();
                    break;
                case "_removeGroupPackagesFromCompany" :
                    return $this->_removeGroupPackagesFromCompany();
                    break;
                case "_updateGroupPackageDB" :
                    return $this->_updateGroupPackageDB();
                    break;
                case "_updatePackageDB" :
                    return $this->_updatePackageDB();
                    break;
                case "_getGroupPackageById" :
                    return $this->_getGroupPackageById($args['0']);
                    break;
                case "_getPackageById" :
                    return $this->_getPackageById($args['0']);
                    break;
                case "_getGroupPackages" :
                    return $this->_getGroupPackages($args['0']);
                    break;
                case "_getPackages" :
                    return $this->_getPackages($args['0']);
                    break;
                case "_removeGroupPackagesDB" :
                    return $this->_removeGroupPackagesDB($args['0']);
                    break;
                case "_removePackagesDB" :
                    return $this->_removePackagesDB($args['0']);
                    break;
                case "_changeStatusDB" :
                    return $this->_changeStatusDB($args['0']);
                    break;
                case "_changePackageStatusDB" :
                    return $this->_changePackageStatusDB($args['0']);
                    break;
                case "_calculatePackageDB" :
                    return $this->_calculatePackageDB();
                    break;
                case "_set_IDs" :
                    return $this->_set_IDs($args['0']);
                    break;
                case "_logPackageToCompanyDB" :
                    return $this->_logPackageToCompanyDB($args['0']);
                    break;
                 case "_calculateTax" :
                    return $this->_calculateTax($args['0']);
                    break;
                 case "_logPackageToCompanyNowDB" :
                    return $this->_logPackageToCompanyNowDB();
                    break;
                case "_checkIfNameExistsDB" :
                    return $this->_checkIfNameExistsDB($args['0'],$args['1']);
                    break;
                case "_checkIfGroupNameExistsDB" :
                    return $this->_checkIfGroupNameExistsDB($args['0'],$args['1']);
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
     * Gets each Group Package based on its ID
     * @param $GroupPackageID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    private function _getGroupPackageById($GroupPackageID)
    {
        global $lang;
        $conn = parent::getConnection();
        $sql = " SELECT
             `package_group_id` as package_group_id,
             `package_group_name` as package_group_name,
			 `package_group_status` as package_group_status
    		   FROM tbl_package_group
               WHERE
                    package_group_id= '$GroupPackageID'";


        //or WHERE    news_id='$id' ");
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if (!$stmt)
        {
            $result['result'] = -1;
            $result['Number'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }

        if (!$stmt->rowCount())
        {
            $result['result'] = -1;
            $result['Number'] = 1;
            $result['msg'] = ModelADMIN_62;
            return $result;
        }
        $row = $stmt->fetch();
        $this->_set_groupPackageFields($row);
        $result['result'] = 1;
        return $result;

    }

    /**
     * Gets each package based on its ID
     * @param $PackageID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    private function _getPackageById($PackageID)
    {
        global $lang;
        $conn = parent::getConnection();

        $sql = " SELECT
             `id` as id,
             `package_name` as package_name,
			 `price` as price,
			 `extension_count` as extension_count,
			 `duration` as duration,
			 `package_status` as package_status,
			 `package_group_id` as package_group_id
    		   FROM tbl_package
               WHERE
                    id= '$PackageID'";

        //or WHERE    news_id='$id' ");
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if (!$stmt)
        {
            $result['result'] = -1;
            $result['Number'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }

        if (!$stmt->rowCount())
        {
            $result['result'] = -1;
            $result['Number'] = 1;
            $result['msg'] = 'This Record was Not Found';
            return $result;
        }

        $row = $stmt->fetch();
        $this->_set_groupPackageFields($row);
        $result['result'] = 1;
        return $result;
    }

    /**
     * Gets group Packages
     * @return  mixed
     * @param  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.02.02
     * @since   01.01.01
     * @date    08/08/2015
     */
    private function _getGroupPackages($fields='')
    {
        global $lang;
        $fields['useTrash']='false';
        $filter=$this->filterBuilder($fields);
        $length=$filter['length'];
        $filter=$filter['list'];
        $this->_checkPermission();
        $conn = parent::getConnection();

        $sql = "
          SELECT
             `package_group_id` as package_group_id,
             `package_group_name` as package_group_name,
			 `package_group_status` as package_group_status
    	  FROM tbl_package_group
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
          SELECT COUNT(`tbl_package_group`.`package_group_id`) as recCount
          FROM
          `tbl_package_group`  ".$filter['WHERE'] .$filter['filter'];

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
            $this->_set_groupPackageListDb($row['package_group_id'], $row);
        }

        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }

    /**
     * Get Packages
     * @return  mixed
     * @param  $fields
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.02.02
     * @since   01.01.01
     * @date    08/08/2015
     */
    private function _getPackages($fields='')
    {
        global $lang;
        $fields['useTrash']='false';
        $filter=$this->filterBuilder($fields);
        $length=$filter['length'];
        $filter=$filter['list'];
        $this->_checkPermission();
        $conn = parent::getConnection();

        $sql = "SELECT
                  `t1`.*
                FROM
               (SELECT
                    `tbl_package`.*, `tbl_package_group`.`package_group_name`
                    FROM
                    `tbl_package` INNER JOIN
                    `tbl_package_group` ON `tbl_package`.`package_group_id` = `tbl_package_group`.`package_group_id`) AS `t1`
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
          `tbl_package`  ".$filter['WHERE'] .$filter['filter'];

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
            $this->_set_groupPackageListDb($row['id'], $row);
        }

        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }

    /**
     * Insert Group Packages DB
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _insertGroupPackagesDB()
    {
        global $lang;
        $conn = parent::getConnection();

        $sql = "
                        INSERT INTO tbl_package_group(
                                package_group_name
                            )
                        VALUES(
                            '" .$this->_PackageFields['package_group_name'] . "'

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

        $insertedId = $conn->lastInsertId();
        $this->_PackageFields['groupPackageID'] = $insertedId;
        $this->_set_insertGroupPackagesDB($insertedId, $this->_PackageFields);
        $result['result'] = 1;
        $result['Number'] = 2;
        return $result;
    }

    /**
     * Insert Packages DB
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _insertPackagesDB()
    {
        global $lang;
        $conn = parent::getConnection();

        $sql = "
                        INSERT INTO tbl_package(
                                package_name,
                                price,
                                extension_count,
                                duration,
                                package_group_id
                            )
                        VALUES(
                            '" .$this->_PackageFields['package_name'] . "',
                            '" .$this->_PackageFields['price'] . "',
                            '" .$this->_PackageFields['extension_count'] . "',
                            '" .$this->_PackageFields['duration'] . "',
                            '" .$this->_PackageFields['group_id'] . "'

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

        $insertedId = $conn->lastInsertId();
        $this->_PackageFields['package_id'] = $insertedId;
        $this->_set_insertGroupPackagesDB($insertedId, $this->_PackageFields);
        $result['result'] = 1;
        $result['Number'] = 2;
        return $result;
    }

    /**
     * Insert Packages DB
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _insertPackageToGroupDB()
    {
        global $lang;
        $conn = parent::getConnection();

        $sql = "
                        INSERT INTO tbl_package_group_relation(
                                package_id,
                                package_group_id
                            )
                        VALUES(
                            '" .$this->_PackageFields['package_id'] . "',
                            '" .$this->_PackageFields['group_id'] . "'

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

        $insertedId = $conn->lastInsertId();
        $this->_PackageFields['package_id'] = $insertedId;
        $this->_set_insertGroupPackagesDB($insertedId, $this->_PackageFields);
        $result['result'] = 1;
        $result['Number'] = 2;
        return $result;
    }

    /**
     * insertPackagesDB
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _insertPackageToCompanyDB()
    {
        global $lang;
        $conn = parent::getConnection();
        $date = date("Y-m-d H:i:s");
        $startDate = date("Y-m-d H:i:s",strtotime("+1 second",strtotime($date)));
        $expireDate = date("Y-m-d H:i:s",strtotime("+". $this->_PackageFields['duration'] ,strtotime($startDate)));

        $sql = "        INSERT INTO tbl_package_company(
                                comp_id,
                                package_id,
                                log_id,
                                extension_count,
                                assign_date,
                                start_date,
                                expire_date
                            )
                        VALUES(
                            '" .$this->_PackageFields['comp_id'] . "',
                            '" .$this->_PackageFields['package_id'] . "',
                            '" .$this->_PackageFields['id'] . "',
                            '" .$this->_PackageFields['extension_count'] . "',
                            '" .$date . "',
                            '" .$startDate . "',
                            '" .$expireDate . "'
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

        $insertedId = $conn->lastInsertId();
        $this->_PackageFields['package_id'] = $insertedId;
        $this->_set_insertGroupPackagesDB($insertedId, $this->_PackageFields);
        $result['result'] = 1;
        $result['Number'] = 2;
        return $result;
    }

    /**
     * updatePackageToCompanyDB
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _updatePackageToCompanyDB()
    {
        global $lang;
        $conn = parent::getConnection();
        $date = date("Y-m-d H:i:s");
        $startDate = date("Y-m-d H:i:s",strtotime("+1 second",strtotime($date)));
        $expireDate = date("Y-m-d H:i:s",strtotime("+". $this->_PackageFields['duration'] ,strtotime($startDate)));

        $sql = "UPDATE   tbl_package_company
                SET	    comp_id =   '" .$this->_PackageFields['comp_id'] . "',
                        package_id = '" .$this->_PackageFields['package_id'] . "',
                        log_id = '" .$this->_PackageFields['id'] . "',
                        extension_count =  '" .$this->_PackageFields['extension_count'] . "',
                        assign_date =   '" .$date . "',
                        start_date =   '" .$startDate . "',
                        expire_date =   '" .$expireDate . "'
                WHERE comp_id ='" .$this->_PackageFields['comp_id'] . "'
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

        $insertedId = $conn->lastInsertId();
        $this->_PackageFields['package_id'] = $insertedId;
        $this->_set_insertGroupPackagesDB($insertedId, $this->_PackageFields);
        $result['result'] = 1;
        $result['Number'] = 2;
        return $result;
    }


    /**
     * Log Package To Company Now DB
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _logPackageToCompanyNowDB()
    {
        global $admin_info,$lang,$company_info;
        $conn = parent::getConnection();
        $date = date("Y-m-d H:i:s");
        $startDate = date("Y-m-d H:i:s",strtotime("+1 second",strtotime($date)));
        $expireDate = date("Y-m-d H:i:s",strtotime("+". $this->_PackageFields['duration'] ,strtotime($startDate)));
        $totalPrice = $this->_calculateTax($this->_PackageFields['price']);
        $paymentType = 'Admin';

        $sql = "        INSERT INTO log_package_company(
                                comp_id,
                                order_for,
                                creator,
                                package_id,
                                extension_count,
                                price,
                                duration,
                                comment,
                                total_price,
                                issue_date,
                                start_date,
                                expire_date,
                                payment_type
                            )
                        VALUES(
                            '" .$company_info['comp_id']  . "',
                            '" .$this->_PackageFields['comp_id'] . "',
                            '" .$admin_info['admin_id'] . "',
                            '" .$this->_PackageFields['package_id'] . "',
                            '" .$this->_PackageFields['extension_count'] . "',
                            '" .$this->_PackageFields['price'] . "',
                            '" .$this->_PackageFields['duration'] . "',
                            '" .$this->_PackageFields['comment'] . "',
                            '" .$totalPrice . "',
                            '" .$date . "',
                            '" .$startDate . "',
                            '" .$expireDate . "',
                            '" .$paymentType . "'
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

        $insertedId = $conn->lastInsertId();
        $this->_PackageFields['id'] = $insertedId;
        $this->_set_insertGroupPackagesDB($insertedId, $this->_PackageFields);
        $result['result'] = 1;
        $result['Number'] = 2;
        return $result;
    }

    /**
     * Log Package To Company DB
     * @param  $lastExpiryDate
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _logPackageToCompanyDB($lastExpiryDate)
    {
        global $admin_info,$lang,$company_info;
        $conn = parent::getConnection();
        $date = date("Y-m-d H:i:s");
        $startDate = date("Y-m-d H:i:s",strtotime("+1 second",strtotime($lastExpiryDate)));
        $expireDate = date("Y-m-d H:i:s",strtotime("+". $this->_PackageFields['duration'] ,strtotime($startDate)));
        $totalPrice = $this->_calculateTax($this->_PackageFields['price']);
        $paymentType = 'Admin';

        $sql = "        INSERT INTO log_package_company(
                                comp_id,
                                order_for,
                                creator,
                                package_id,
                                extension_count,
                                price,
                                duration,
                                comment,
                                total_price,
                                issue_date,
                                start_date,
                                expire_date,
                                payment_type
                            )
                        VALUES(
                            '" .$company_info['comp_id']  . "',
                            '" .$this->_PackageFields['comp_id'] . "',
                            '" .$admin_info['admin_id'] . "',
                            '" .$this->_PackageFields['package_id'] . "',
                            '" .$this->_PackageFields['extension_count'] . "',
                            '" .$this->_PackageFields['price'] . "',
                            '" .$this->_PackageFields['duration'] . "',
                            '" .$this->_PackageFields['comment'] . "',
                            '" .$totalPrice . "',
                            '" .$date . "',
                            '" .$startDate . "',
                            '" .$expireDate . "',
                            '" .$paymentType . "'
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

        $insertedId = $conn->lastInsertId();
        $this->_PackageFields['id'] = $insertedId;
        $this->_set_insertGroupPackagesDB($insertedId, $this->_PackageFields);
        $result['result'] = 1;
        $result['Number'] = 2;
        return $result;
    }

    /**
     * Remove Package From Company DB
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _removePackageFromCompanyDB()
    {
        global $lang;
        $conn = parent::getConnection();

        $sql = "DELETE
                FROM tbl_package_company";

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
     * Checks If Package Exists
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _checkIfPackageExists()
    {
        global $lang;
        $compID = $this->_PackageFields['comp_id'];
        $conn = parent::getConnection();

        $sql = "SELECT *
                FROM tbl_package_company
                WHERE comp_id = '$compID'";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        if (!$stmt)
        {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = 'DB error : ' . $conn->errorInfo();
            return $result;
        }

        $result['rowCount'] = $stmt->rowCount();
        $result['result'] = 1;
        $result['Number'] = 2;
        return $result;
    }

    /**
     * Insert Packages DB
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _insertGroupPackagesToCompany()
    {
        global $lang;
        // echo $id;
        $conn = parent::getConnection();
        $date = date('Y-m-d H:i:s');

        $sql = "
                        INSERT INTO tbl_package_group_company(
                                comp_id,
                                package_group_id,
                                assign_date
                            )
                        VALUES(
                            '" .$this->_PackageFields['comp_id'] . "',
                            '" .$this->_PackageFields['package_group_id'] . "',
                            '" .$date. "'

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

        $insertedId = $conn->lastInsertId();
        $this->_PackageFields['package_group_id'] = $insertedId;
        $this->_set_insertGroupPackagesDB($insertedId, $this->_PackageFields);
        $result['result'] = 1;
        $result['Number'] = 2;
        return $result;
    }

    /**
     * Insert Packages DB
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _removeGroupPackagesFromCompany()
    {
        global $lang;
        // echo $id;
        $conn = parent::getConnection();
        $groupID = $this->_PackageFields['package_group_id'];

        $sql = "  DELETE
                  FROM 	tbl_package_group_company
		          WHERE    package_group_id = '$groupID'";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        if (!$stmt)
        {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = 'DB error : ' . $conn->errorInfo();
            return $result;
        }

        $insertedId = $conn->lastInsertId();
        $this->_PackageFields['package_group_id'] = $insertedId;
        $this->_set_insertGroupPackagesDB($insertedId, $this->_PackageFields);
        $result['result'] = 1;
        $result['Number'] = 2;
        return $result;
    }

    /**
     * Update Group Package DB
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    private function _updateGroupPackageDB()
    {
        global $lang;
        $conn = parent::getConnection();
        $GroupPackageID = $this->_PackageFields['package_group_id'];

        $sql = "UPDATE tbl_package_group
                SET
                    package_group_name =   '". $this->_PackageFields['package_group_name'] . "'
                WHERE
                    package_group_id = $GroupPackageID;
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

        $result['result'] = 1;
        $result['Number'] = 2;
        return $result;
    }


    /**
     * Update Package DB
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    private function _updatePackageDB()
    {
        global $lang;
        $conn = parent::getConnection();
        $PackageID = $this->_PackageFields['package_id'];

        $sql = "UPDATE tbl_package
                SET
                    package_name =   '". $this->_PackageFields['package_name'] . "',
                    price =   '". $this->_PackageFields['price'] . "',
                    extension_count =   '". $this->_PackageFields['extension_count'] . "',
                    duration =   '". $this->_PackageFields['duration'] . "',
                    package_group_id =   '". $this->_PackageFields['group_id'] . "'
                WHERE
                    id = $PackageID;
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

        $result['result'] = 1;
        $result['Number'] = 2;
        return $result;
    }

    /**
     * Specifies the type of output
     * @param $GroupPackageID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    private function _removeGroupPackagesDB($GroupPackageID)
    {
        global $lang,$conn;
        $conn = parent::getConnection();

        $sql = "
           DELETE
           FROM 	tbl_package_group
		   WHERE    package_group_id = '$GroupPackageID'";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if (!$stmt)
        {
            $result['result'] = -1;
            $result['Number'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }

        $result['result'] = 1;
        return $result;
    }

    /**
     * Removes Package
     * @param $PackageID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    private function _removePackagesDB($PackageID)
    {
        global $lang,$conn;
        $conn = parent::getConnection();

        $sql = "
           DELETE
           FROM 	tbl_package
		   WHERE    id = '$PackageID'";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if (!$stmt)
        {
            $result['result'] = -1;
            $result['Number'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }

        $result['result'] = 1;
        return $result;
    }

    /**
     * Change Status DB
     * @param $val
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/09/2015
     */
    private function _changeStatusDB($val)
    {
        global  $lang;
        $conn = parent::getConnection();
        $listId  =implode(',',$this->_IDs);

        $sql = "
                UPDATE 	tbl_package_group
			    SET     package_group_status=$val
				WHERE   package_group_id in ($listId)";

        $stmt = $conn->prepare($sql);
        /*** bind the parameters ***/
        $stmt->bindParam(':val',$val, PDO::PARAM_INT);
        $stmt->execute();

        if(!$stmt)
        {
            $result['result']=-1;
            $result['no']=1;
            $res['msg']='DB error : '.$conn->errorInfo();
            return $res;
        }

        $result['result']=1;
        $result['Number']=2;
        return $result;
    }

    /**
     * Change Package Status
     * @param $val
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/09/2015
     */
    private function _changePackageStatusDB($val)
    {
        global  $lang;
        $conn = parent::getConnection();
        $listId  =implode(',',$this->_IDs);

        $sql = "
                UPDATE 	tbl_package
			    SET
                        package_status=$val
				WHERE id in ($listId) ";

        $stmt = $conn->prepare($sql);
        /*** bind the parameters ***/
        $stmt->bindParam(':val',$val, PDO::PARAM_INT);
        $stmt->execute();

        if(!$stmt)
        {
            $result['result']=-1;
            $result['no']=1;
            $res['msg']='DB error : '.$conn->errorInfo();
            return $res;
        }

        $result['result']=1;
        $result['Number']=2;
        return $result;
    }



    /**
     * Calculate Package DB
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/09/2015
     */
    private function _calculatePackageDB()
    {
        global  $lang;
        $conn = parent::getConnection();

        $sql = "
                UPDATE 	tbl_package_company
			    SET package_usage = package_usage + 1 ";

        $stmt = $conn->prepare($sql);
        /*** bind the parameters ***/
        $stmt->execute();

        if(!$stmt)
        {
            $result['result']=-1;
            $result['no']=1;
            $res['msg']='DB error : '.$conn->errorInfo();
            return $res;
        }

        $result['result']=1;
        $result['Number']=2;
        return $result;

    }

    /**
     * Calculates Tax
     * @param  $price
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    private function _calculateTax($price)
    {
        $price = ($price * VAT) / 100 + $price  ;
        return $price;

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
    private function _checkIfNameExistsDB($name,$compID)
    {
        global $lang,$conn;
        $conn = parent::getConnection();

        $sql = "
           SELECT   *
           FROM	    tbl_package
		   WHERE    package_name= '$name' AND trash = 0";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if (!$stmt)
        {
            $result['result'] = -1;
            $result['Number'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }

        while ($row = $stmt->fetch())
        {
            $this->_set_groupPackageListDb($row['package_id'], $row);
        }

        $result['rowCount'] = $stmt->rowCount();
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
    private function _checkIfGroupNameExistsDB($name,$compID)
    {
        global $lang,$conn;
        $conn = parent::getConnection();

        $sql = "
           SELECT   *
           FROM	    tbl_package_group
		   WHERE    package_group_name= '$name'";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if (!$stmt)
        {
            $result['result'] = -1;
            $result['Number'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }

        while ($row = $stmt->fetch())
        {
            $this->_set_groupPackageListDb($row['package_id'], $row);
        }

        $result['rowCount'] = $stmt->rowCount();
        $result['result'] = 1;
        return $result;
    }

}
