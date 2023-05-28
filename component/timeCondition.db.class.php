<?php
/**
 * @author Malekloo Izadi Sakhamanesh <Izadi@dabacenter.ir>
 * @version 0.0.1 this is the beta version of News
 * @copyright 2015 The Imen Daba Parsian Co.
 */
class ivr_db extends DataBase
{


    /** Contains each field
     * @var
     */
    private $_ivrFields;

    /**
     * Contains extension list
     * @var array
     */
    private $_ivrListDb;

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
                case "_set_ivrFields" :
                    return $this->_set_ivrFields($args['0']);
                    break;
                case "_insertIvrDB" :
                    return $this->_insertIvrDB();
                    break;
                case "_insertDSTDB" :
                    return $this->_insertDSTDB($args['0']);
                    break;
                case "_set_InsertIvrDB" :
                    return $this->_set_InsertIvrDB($args['0']);
                    break;
                case "_getIvr" :
                    return $this->_getIvr($args['0']);
                    break;
                case "_getDST" :
                    return $this->_getDST($args['0']);
                    break;
                case "_getIvrById" :
                    return $this->_getIvrById($args['0']);
                    break;
                case "_set_IDs" :
                    return $this->_set_IDs($args['0']);
                    break;
                case "_changeStatusDB" :
                    return $this->_changeStatusDB($args['0']);
                    break;
                case "_removeIvrDB" :
                    return $this->_removeIvrDB($args['0']);
                    break;
                case "_removeIvrDSTDB" :
                    return $this->_removeIvrDSTDB($args['0']);
                    break;
                case "_updateIvrDB" :
                    return $this->_updateIvrDB();
                    break;
                case "_updateDSTDB" :
                    return $this->_updateDSTDB($args['0']);
                    break;
                 case "_trashIvrDB" :
                    return $this->_trashIvrDB($args['0']);
                    break;
                case "_trashIvrDSTDB" :
                    return $this->_trashIvrDSTDB($args['0']);
                    break;
                case "_recycleIvrDB" :
                    return $this->_recycleIvrDB($args['0']);
                    break;
                case "_GetAll" :
                    return $this->GetAll($args['0']);
                    break;
                case "_checkIfNameExistsDB" :
                    return $this->_checkIfNameExistsDB($args['0'],$args['1']);
                    break;


            endswitch;
        }
        die();
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
            case 'ivrListDb':
                return $this->_ivrListDb;
                break;
            case 'ivrFields':
                return $this->_ivrFields;
                break;
            default:
                break;
        }
        die();
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
    private function _set_ivrListDb($Ivr_ID, $value = '')
    {
        if (!empty($Ivr_ID) && is_numeric($Ivr_ID) && is_array($value))
        {
            $this->_ivrListDb[$Ivr_ID] = $value;

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
    private function _set_InsertIvrDB($insertedId, $value = '')
    {
        if (!empty($insertedId) && is_numeric($insertedId) && is_array($insertedId))
        {
            $this->_ivrFields[$insertedId] = $value;
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

    private function _set_ivrFields($value = '')
    {
        $this->_ivrFields = $value;
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
    private function _set_IDs($value='')
    {

        $result['result'] = 1;

        foreach($value as $key => $val )
        {
            if (is_numeric($val) && !empty($val))
            {
                $this->_IDs[$key]=$val;
            }
            else
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
     * Gets IVR
     * @return  mixed
     * @param $fields
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getIvr($fields='')
    {
        //global $lang;
        $conn = parent::getConnection();
        $filter=$this->filterBuilder($fields);
        $length=$filter['length'];
        $filter=$filter['list'];

        include_once(ROOT_DIR . "component/company.operation.class.php");
        $company_operation= new company_operation;
        $result = $company_operation->getSubCompanies();

        if($filter['filter'] != '')
        {
            $filter['filter'] = ' AND '. $filter['filter'];
        }

        $sql = "
                SELECT `t1`.*
                FROM
                (SELECT `tbl_ivr`.*, `tbl_upload`.`title`, `tbl_company`.`comp_name`
                FROM `tbl_ivr` INNER JOIN `tbl_upload` ON `tbl_ivr`.`upload_id` = `tbl_upload`.`upload_id`
                LEFT JOIN
    		   `tbl_company` ON `tbl_company`.`comp_id` =
              `tbl_ivr`.`comp_id`
                )
                AS `t1`
        WHERE comp_id in (".$result['list'].") ".$filter['filter'].$filter['order'].$filter['limit'];

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
          SELECT COUNT(`tbl_ivr`.`ivr_id`) as recCount
          FROM
          `tbl_ivr` WHERE comp_id in (".$result['list'].") ".$filter['filter'];
        //echo $stmt->rowCount();

        $stmTp = $conn->prepare($sql);
        $stmTp->setFetchMode(PDO::FETCH_ASSOC);
        $stmTp->execute();
        $rowP = $stmTp->fetch();

        $rowFound=$rowP['recCount'];
        $this->_paging['recordsFiltered']=$rowP['recCount'];
        $this->_paging['recordsTotal']= $rowFound['found'];

        while ($row = $stmt->fetch()) {
            $this->_set_ivrListDb($row['ivr_id'], $row);
        }

        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }

    /**
     * Gets DST menu, FailOver in IVR
     * @return  mixed
     * @param $ivrID
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getDST($ivrID)
    {
        //global $lang;
        $conn = parent::getConnection();

        $sql = "
                SELECT
                        `dst_menu_id` as dst_menu_id,
                        `ivr_id` as ivr_id,
                        `dst_option_id` as dst_option_id,
			            `dst_option_sub_id` as dst_option_sub_id,
			            `ivr_menu_no` as ivr_menu_no,
			            `description` as description

    		    FROM 	tbl_ivr_dst_menu
                WHERE
                        ivr_id= '$ivrID'";

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


        while ($row = $stmt->fetch()) {
            $this->_set_ivrListDb($row['dst_menu_id'], $row);
        }

        $result['result'] = 1;
        $result['no'] = 2;
        return $result;

    }


    /**
     * Gets each IVR based on its ID
     * @param $ivrID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getIvrById($ivrID)
    {
        //global $lang;
        $conn = parent::getConnection();

        $sql = "SELECT
                    `ivr_name` as Ivr_Name,
                    `ivr_id` as Ivr_id,
                    `upload_id` as Upload_Id,
                    `invalid` as Invalid,
                    `direct_dial` as Direct_Dial,
                    `timeout` as Timeout,
                    `comp_id` as comp_id
                FROM
                    tbl_ivr
                WHERE
                    ivr_id= '$ivrID'";

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

        $row = $stmt->fetch();
        $this->_set_ivrFields($row);
        $result['result'] = 1;
        return $result;

    }




    /**
     * Inserts IVR
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _insertIvrDB()
    {
        //global $lang;
        $conn = parent::getConnection();

        $sql = "
                        INSERT INTO tbl_ivr(
                                ivr_name,
                                upload_id,
                                Invalid,
                                timeout,
                                direct_dial,
                                comp_id
                            )
                        VALUES(
                            '" . $this->_ivrFields['Ivr_Name'] . "',
                            '" . $this->_ivrFields['Announcement'] . "',
                            '" . $this->_ivrFields['Invalid'] . "',
                            '" . $this->_ivrFields['TimeOut'] . "',
                            '" . $this->_ivrFields['Direct_Dial'] . "',
                            '" . $this->_ivrFields['comp_id'] . "'

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
        $this->_ivrFields['Ivr_ID'] = $insertedId;
        $this->_set_InsertIvrDB($insertedId, $this->_ivrFields);
        $result['result'] = 1;
        $result['Number'] = 2;
        return $result;

    }

    /**
     * Inserts DST Menu
     * @return  mixed
     * @param  $IvrID
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _insertDSTDB($IvrID)
    {
        //global $lang;
        $conn = parent::getConnection();
        $sql = "
                        INSERT INTO tbl_ivr_dst_menu(
                                ivr_id,
                                dst_option_id,
                                dst_option_sub_id,
                                ivr_menu_no,
                                description
                            )
                        VALUES";

        foreach($this->_ivrFields['DST'] as $key=>$value)
        {
                $sql .= "(
                            '" . $IvrID . "',
                            '" . $value['DSTOption'] . "',
                            '" . $value['dst_option_sub_id'] . "',
                            '" . $value['IVRExtension'] . "',
                            '" . $value['Description'] . "'

                            ),";
        }

        $sql = substr($sql,0,-1);

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
        $this->_ivrFields['dst_menu_id'] = $insertedId;
        $this->_set_InsertIvrDB($insertedId, $this->_ivrFields);
        $result['result'] = 1;
        $result['Number'] = 2;
        return $result;


    }


    /**
     * Update IVR
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _updateIvrDB()
    {
        global $lang;
        $conn = parent::getConnection();
        $IVR_ID = $this->_ivrFields['Ivr_ID'];

        $sql = "UPDATE    tbl_ivr
                SET
                         ivr_name =   '" . $this->_ivrFields['Ivr_Name'] . "',
                         upload_id ='" . $this->_ivrFields['Announcement'] . "',
                         invalid =  '" . $this->_ivrFields['Invalid'] . "',
                         direct_dial =   '" . $this->_ivrFields['Direct_Dial'] . "',
                         timeout =   '" . $this->_ivrFields['TimeOut'] . "'
                WHERE    ivr_id= '$IVR_ID'";
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
     * Update DST
     * @return  mixed
     * @param  $IvrID
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _updateDSTDB($IvrID)
    {
        $this->_removeIvrDSTDB($IvrID);
        $this->_insertDSTDB($IvrID);
    }

    /**
     * changeStatus
     * @param $val
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/09/2015
     */
    private function _changeStatusDB($val)
    {
        global  $lang;
        $conn = parent::getConnection();
        $listId  =implode(',',$this->_IDs);

        $sql = "
                UPDATE 	tbl_ivr
			    SET
                       ivr_status=$val
                WHERE  ivr_id in ($listId) ";

        $stmt = $conn->prepare($sql);
        /*** bind the parameters ***/
        //$stmt->bindParam(':id',$this->_newsFields['newsID'], PDO::PARAM_INT);
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
     * Remove IVR
     * @param $ivrID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _removeIvrDB($ivrID)
    {
        global $lang,$conn;
        $conn = parent::getConnection();
        $sql = "
               DELETE
               FROM 	tbl_ivr
               WHERE    ivr_id= '$ivrID'";

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
     * Remove IVR
     * @param $ivrID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _removeIvrDSTDB($ivrID)
    {
        global $lang,$conn;
        $conn = parent::getConnection();
        $sql = "
               DELETE
               FROM 	tbl_ivr_dst_menu
               WHERE    ivr_id= '$ivrID'";

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
     * Trashes IVR
     * @param queue
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _trashIvrDB($ivrID)
    {
        global $lang,$conn;
        $conn = parent::getConnection();

        $sql = "
               UPDATE   tbl_ivr
               SET	    trash = 1
               WHERE    ivr_id= '$ivrID'";

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
     * Trash IVR DST
     * @param queue
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _trashIvrDSTDB($ivrID)
    {
        global $lang,$conn;
        $conn = parent::getConnection();

        $sql = "
               UPDATE   tbl_ivr_dst_menu
               SET	    trash = 1
               WHERE    ivr_id= '$ivrID'";

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
     * Recycle IVR
     * @param queue
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _recycleIvrDB($ivrID)
    {
        global $lang,$conn;
        $conn = parent::getConnection();

        $sql = "
               UPDATE   tbl_ivr
               SET	    trash = 0
               WHERE    ivr_id = '$ivrID'";

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
     * Gets all data based on its ID
     * @param $where
     * @param $fieldSort
     * @param $sort
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */


    public function GetAll($where='',$fieldSort='',$sort='asc')
    {
        global $conn,$member_info;
        $conn = parent::getConnection();
        $table='tbl_ivr';

        if(strlen($table)==0)
        {
            return -1	;
        }

        $appendSql = "select * from ".$table." ";

        if($where!='')
        {
            $appendSql.='WHERE '.$where.' ';
        }

        if($fieldSort!='')
        {
            $appendSql.="ORDER BY ".$fieldSort." ".$sort;
        }
        $stmt = $conn->prepare($appendSql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        if (!$stmt)
        {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }

        while ($row = $stmt->fetch()) {
            $this->_set_ivrListDb($row['ivr_id'], $row);
        }

        $result['result'] = 1;
        $result['rowCount'] = $stmt->rowCount();
        $result['rs'] =$stmt;
        return $result;
    }

    /**
     * Gets all DST menu based on its ID
     * @param $where
     * @param $fieldSort
     * @param $sort
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function GetAllDST($where='',$fieldSort='',$sort='asc')
    {
        global $conn,$member_info;
        $conn = parent::getConnection();
        $table='tbl_ivr_dst_menu';

        if(strlen($table)==0)
        {
            return -1	;
        }

        $appendSql = "select * from ".$table." ";

        if($where!='')
        {
            $appendSql.='WHERE '.$where.' ';
        }

        if($fieldSort!='')
        {
            $appendSql.="ORDER BY ".$fieldSort." ".$sort;
        }

        $stmt = $conn->prepare($appendSql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        if (!$stmt)
        {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }

        while ($row = $stmt->fetch()) {
            $this->_set_ivrListDb($row['dst_menu_id'], $row);
        }

        $result['result'] = 1;
        $result['rowCount'] = $stmt->rowCount();
        $result['rs'] =$stmt;
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
    private function _checkIfNameExistsDB($name,$compID)
    {
        global $lang,$conn;
        $conn = parent::getConnection();

        $sql = "
           SELECT   *
           FROM	    tbl_ivr
		   WHERE    ivr_name= '$name' AND comp_id = '$compID' AND trash= 0";

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
            $this->_set_ivrListDb($row['ivr_id'], $row);
        }

        $result['rowCount'] = $stmt->rowCount();
        $result['result'] = 1;
        return $result;
    }
}
