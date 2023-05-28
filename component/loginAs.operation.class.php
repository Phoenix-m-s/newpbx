<?php

include_once(ROOT_DIR . "component/Validators.class.php");

/**
 * @author Malekloo Izadi Sakhamanesh <Izadi@dabacenter.ir>
 * @version 0.0.1 this is the beta version of News
 * @copyright 2015 The Imen Daba Parsian Co.
 */
class loginAs_operation
{
    /**
     * Contains Company info
     * @var
     */
    private $_companyInfo;
    /**
     * Contains Company info
     * @var
     */
    private $_paging;
    /**
     * Contains List of companies
     * @var
     */
    private $_companyList;
    /**
     * @var
     */
    public $_set;
    /**
     * Accessing the database
     * @var
     */
    private $_companyDbObj;


    /**
     * Specifies the type of output
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function __construct()
    {
        $this->_companyInfo = array();
        $this->_companyGroupInfo = array();
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
     * @since   08/08/2015
     * @date    08/08/2015
     */
    function __call($method, $args)
    {
        $method = '_' . $method;

        if (method_exists($this, $method)) {
            switch ($method) :
                case "_insertLoginAs" :
                    return $this->_insertLoginAs();
                    break;
                case "_set_loginAsInfo" :
                    return $this->_set_loginAsInfo($args['0']);
                    break;
            endswitch;
        }

    }

    /**
     * Specifies the value of each field.
     * Setter can act in 2 ways.
     * 1)It gets all the input at once
     * 2)It gets the fields one by one
     * We have used the 2nd method.
     * @param $value
     * @return  mixed
     * @author  Malekloo,Izadi,Sakhamanesh
     * @version 01.01.01
     * @since 01.01.01
     * @date    08/08/2015
     *
     */
    private function _set_loginAsInfo($value = '')
    {

        $result['result'] = 1;
        $this->_companyInfo = $value;
        return $result;
        /**
         * Checks if the value of ID is not empty and is integer.
         */
        if (isset($value['comp_id'])) {

            if (empty($value['comp_id'])) {
                $msg = ModelCOMPANY_03;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['comp_id'] = $msg;
            } elseif (!Validator::Numeric($value['comp_id'])) {
                $msg = ModelCOMPANY_04;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['comp_id'] = $msg;
            }
            {
                $this->_companyInfo['comp_id'] = $value['comp_id'];
            }

        }

        /**
         * Checks if the value of Company name is not empty and is string.
         */
        if (isset($value['Comp_Name'])) {
            if (empty($value['Comp_Name'])) {
                $msg = ModelCOMPANY_05;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['Comp_Name'] = $msg;
            } elseif (!is_string($value['Comp_Name'])) {
                $msg = ModelCOMPANY_06;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['Comp_Name'] = $msg;
            } else {
                $this->_companyInfo['Comp_Name'] = $value['Comp_Name'];
            }

        }


        return $result;

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
                return $this->_companyList;
                break;
            case 'paging':
                return $this->_paging;
                break;
            case 'companyInfo':
                return $this->_companyInfo;
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
     * @date    08/08/2015
     */
    private function getLoginAsDbObj()
    {
        include_once(ROOT_DIR . "component/loginAs.db.class.php");
        $this->_companyDbObj = new loginAs_db();
    }

    /**
     * /**
     * Insert Login As
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _insertLoginAs()
    {
        //global $conn, $lang;

        $this->getLoginAsDbObj();
        $result = $this->_companyDbObj->set_loginAsFields($this->_companyInfo);

        if ($result['result'] == -1) {
            return $result;
        }

        $resultInsert = $this->_companyDbObj->insertLoginAsDB();

        if ($resultInsert['result'] == -1) {
            return $resultInsert['msg'];
        }

        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }


}

