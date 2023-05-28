<?php
/**
 * @author Malekloo Izadi Sakhamanesh <Izadi@dabacenter.ir>
 * @version 0.0.1 this is the beta version of sip
 * @copyright 2015 The Imen Daba Parsian Co.
 */
class report_db extends DataBase
{


    /** Contains each field
     * @var
     */
    private $_reportFields;

    /** Contains each field
     * @var
     */
    private  $_paging;
    /**
     * Contains sip list
     * @var array
     */
    private $_reportListDb;
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
        $this->_reportListDb = array();
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

                case "_getReport" :
                    return $this->_getReport($args['0']);
                    break;
                case "_getPaymentReportList" :
                    return $this->_getPaymentReportList($args['0']);
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
                $this->_set_reportFields(array($property=>$value));
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
            case 'reportListDb':
                return $this->_reportListDb;
                break;
            case 'reportFields':
                return $this->_reportFields;
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
     * @param   $ReportID
     * @param   $value
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    private function _set_reportListDb($ReportID,$value = '')
    {
        if (!empty($ReportID) && is_numeric($ReportID) && is_array($value))
        {

            $this->_reportListDb[$ReportID] = $value;
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
    private function _set_insertReportDB($insertedId, $value = '')
    {
        if (!empty($insertedId) && is_numeric($insertedId) && is_array($value))
        {
            $this->_reportFields[$insertedId] = $value;
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
    private function _set_reportFields($value = '')
    {
        $this->_reportFields = $value;
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
     * Gets Report
     * @param  $fields
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.02.02
     * @since   01.01.01
     * @date    08/08/2015
     */
    private function _getReport($fields='')
    {

        global $company_info;
        $company_name=$company_info['comp_name'];
        $this->_checkPermission();
        $conn = parent::getConnection();
        $fields['useTrash']='false';
        $filter=$this->filterBuilder($fields);
        $length=$filter['length'];
        $filter=$filter['list'];
        if($filter['order'] =='')
        {
            $filter['order']= 'ORDER BY `calldate` DESC';
        }
        $sql = "
                  SELECT  `t1`.* FROM (SELECT `cdr`.* FROM `cdr` WHERE `cdr`.`dcontext` like '%-$company_name') as t1

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

                SELECT
                  Count(`t1`.`cdr_id`) AS `recCount`
                FROM
                  (SELECT *
                  FROM `cdr`
                  WHERE `cdr`.`dcontext` LIKE '%-$company_name') AS `t1`

             ".$filter['WHERE'] .$filter['filter'];
        //echo $stmt->rowCount();

        $stmTp = $conn->prepare($sql);
        $stmTp->setFetchMode(PDO::FETCH_ASSOC);
        $stmTp->execute();

        $rowP = $stmTp->fetch();
        $rowFound=$rowP['recCount'];
        $this->_paging['recordsFiltered']=$rowP['recCount'];
        $this->_paging['recordsTotal']= $rowFound['found'];

        while($row = $stmt->fetch())
        {
            $callDate=$row['calldate'];
            list($date, $time) = explode(" ",$callDate);
            list($year, $month, $day) = explode("-", $date);
            list($extension, $compName) = explode("-", $row['dcontext']);
                $row['filename']=RELA_CHANEL.$company_name.'/'.$year.'/'.$month.'/'.$day.'/'.$row['src'].'-'.$row['dst'].'-'.$row['uniqueid'].'.'.'wav';
            $this->_set_reportListDb($row['cdr_id'], $row);
        }


        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }

    /**
     * Gets Payment Report List
     * @param  $fields
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.02.02
     * @since   01.01.01
     * @date    08/08/2015
     */
    private function _getPaymentReportList($fields='')
    {
        //global $lang;
        $this->_checkPermission();
        $conn = parent::getConnection();
        $fields['useTrash']='false';
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

        $sql = "SELECT
                    `id` as id,
                    `status` as status,
                    `total_amount` as total_amount,
                    `ref_num` as ref_num,
                    `product_detail` as `product_detail`

                FROM online_payment   WHERE comp_id in (".$result['list'].") ".$filter['WHERE'] .$filter['filter'].$filter['order'].$filter['limit'];

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
            SELECT COUNT(`online_payment`.`id`) as recCount
            FROM
            `online_payment`  ".$filter['WHERE'] .$filter['filter'];
        //echo $stmt->rowCount();

        $stmTp = $conn->prepare($sql);
        $stmTp->setFetchMode(PDO::FETCH_ASSOC);
        $stmTp->execute();
        $rowP = $stmTp->fetch();
        $rowFound=$rowP['recCount'];
        $this->_paging['recordsFiltered']=$rowP['recCount'];
        $this->_paging['recordsTotal']= $rowFound['found'];

        while($row = $stmt->fetch())
        {
            $row['product_detail'] = json_decode($row['product_detail']);
            $this->_set_reportListDb($row['id'], $row);
        }

        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }
}
