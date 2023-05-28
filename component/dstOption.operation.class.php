<?php

include_once(ROOT_DIR . "component/Validators.class.php");

/**
 * @author Malekloo Izadi Sakhamanesh <Izadi@dabacenter.ir>
 * @version 0.0.1 this is the beta version of News
 * @copyright 2015 The Imen Daba Parsian Co.
 */
class dstOption_operation
{
    /**
     * Contains Company info
     * @var
     */
    private $_dstOptionInfo;
    /**
     * Contains List of companies
     * @var
     */
    private $_dstOptionList;
    /**
     * @var
     */
    private $_dstOptionDbObj;


    /**
     * Specifies the type of output
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    29/08/2015
     */
    public function __construct()
    {


        //parent::__construct();
        /** @var TYPE_NAME $this */
        $this->_dstOptionInfo = array();
        //$this->_newsList = array();

    }

    /**
     * Specifies the type of output
     * @param $property
     * @param $value
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since 01.01.01
     * @date    29/08/2015
     */
    public function __set($property, $value)
    {

        switch ($property) {

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
     * @since   29/08/2015
     * @date    29/08/2015
     */
    function __call($method, $args)
    {
        $method = '_' . $method;
        if (method_exists($this, $method)) {
            switch ($method) :
                case "_getDstOptionList" :
                    return $this->_getDstOptionList($args['0']);
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
     * @date    29/08/2015
     */
    public function __get($field)
    {
        switch ($field) {
            case 'dstOptionList':
                return $this->_dstOptionList;
                break;
            case 'dstOptionInfo':
                return $this->_dstOptionInfo;
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
     * @date    29/08/2015
     */
    private function getDstOptionIDDbObj()
    {
        include_once(ROOT_DIR . "component/dstOption.db.class.php");
        $this->_dstOptionDbObj = new dstOption_db();
    }

    /**
     * Get DstOption List
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    29/08/2015
     */
    private function _getDstOptionList($filter = '')
    {
        global $conn, $lang;
        $this->getDstOptionIDDbObj();

        $result = $this->_dstOptionDbObj->getDstOption();

        if ($result['result'] != 1) {
            return $result;
        }

        $this->_dstOptionList = $this->_dstOptionDbObj->dstOptionList;
        if ($filter == 'inbound' or $filter == 'ivr') {
            $this->_dstOptionList['100']['DstOptionID'] = '100';
            $this->_dstOptionList['100']['OptionValue'] = 'fax';
        }

        unset($this->_dstOptionDbObj);
        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }
}
