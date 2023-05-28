<?php
include_once(ROOT_DIR . "component/Validators.class.php");

/**
 * @author Malekloo Izadi Sakhamanesh <Izadi@dabacenter.ir>
 * @version 0.0.1 this is the beta version of groupPakegs
 * @copyright 2015 The Imen Daba Parsian Co.
 */
class report_operation
{
    /**
     * Contains group info
     * @var
     */
    private $_reportInfo;
    /**
     * Contains List of group
     * @var
     */
    private $_reportList;
    /**
     * @var
     */
    private $_paging;
    /**
     * Contains Company info
     * @var
     */
    public $_set;
    /**
     * Accessing the database
     * @var
     */
    private $_reportDbObj;
    /**
     * @var
     */
    private $_IDs;


    /**
     * Specifies the type of output
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    public function __construct()
    {
        $this->_reportList = array();
    }

    /**
     * Specifies the type of output
     * @param $property
     * @param $value
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since 01.01.01
     * @date    08/08/2015
     */
    public function __set($property, $value)
    {
        switch ($property)
        {
            default:
                break;
        }
    }

    /**
     * Specifies the type of output
     * @param $method
     * @param $args
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    function __call($method, $args)
    {
        $method = '_' . $method;
        if (method_exists($this, $method)) {
            switch ($method) :

                case "_getReportList" :
                    return $this->_getReportList($args['0']);
                    break;
                case "_getPaymentReportList" :
                    return $this->_getPaymentReportList($args['0']);
                    break;

            endswitch;
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
            case 'paging':
                return $this->_paging;
                break;
            case 'reportList':
                return $this->_reportList;
                break;
            case 'reportInfo':
                return $this->_reportInfo;
                break;
            default:
                break;
        }
    }

    /**
     * Access the database class
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    private function getReportDbObj()
    {
        include_once(ROOT_DIR . "component/report.db.class.php");
        $this->_reportDbObj = new report_db();
    }

    /**
     * Gets the report List
     * @param  $fields
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    private function _getReportList($fields)
    {
        //global $conn, $lang;
        $this->getReportDbObj();
        $result = $this->_reportDbObj->getReport($fields);

        if ($result['result'] != 1)
        {
            return $result;
        }

        $this->_paging = $this->_reportDbObj->paging;
        $this->_reportList = $this->_reportDbObj->reportListDb;
        unset($this->_basketDbObj);
        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }

    /**
     * Get Payment Report List
     * @param  $fields
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    private function _getPaymentReportList($fields)
    {
        //global $conn, $lang;
        $this->getReportDbObj();
        $result = $this->_reportDbObj->getPaymentReportList($fields);

        if ($result['result'] != 1)
        {
            return $result;
        }

        $this->_paging = $this->_reportDbObj->paging;
        $this->_reportList = $this->_reportDbObj->reportListDb;

        foreach($this->_reportList as $key=>$value)
        {
            $this->_reportList[$key]['duration'] = $value['product_detail']->duration;
            $this->_reportList[$key]['package_name'] = $value['product_detail']->package_name;
            $this->_reportList[$key]['extension_count'] = $value['product_detail']->extension_count;
        }

        unset($this->_basketDbObj);
        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }
}

