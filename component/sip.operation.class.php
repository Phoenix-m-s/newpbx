<?php

include_once(ROOT_DIR . "component/Validators.class.php");

/**
 * @author Malekloo Izadi Sakhamanesh <Izadi@dabacenter.ir>
 * @version 0.0.1 this is the beta version of News
 * @copyright 2015 The Imen Daba Parsian Co.
 */
class sip_operation
{
    /**
     * Contains sip info
     * @var
     */
    private $_sipInfo;
    /**
     * Contains List of sip
     * @var
     */
    private $_sipList;
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
    private $_sipDbObj;
    /**
     * @var
     */
    private $_IDs;
    /**
     * @var
     */
    public $addForm;

    /**
     * @var
     */
    public $editForm;


    /**
     * Specifies the type of output
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function __construct()
    {
        //parent::__construct();
        $this->_sipInfo = array();
        $this->addForm = array();
        $this->addForm = array(
            'sip_name' => '',
            'pass' => '',
            'checkHost' => '',
            'nat' => '',
            'host' => '',
            'sip_type' => '',
            'codec' => '',
            'codecList' => ''
        );

        $this->editForm = array();
        $this->editForm = array(
            'id' => '',
            'sip_id' => '',
            'sip_name' => '',
            'pass' => '',
            'checkHost' => '',
            'host' => '',
            'nat' => '',
            'sip_type' => '',
            'codec' => '',
            'codecList' => '',
            'comp_id' => ''
        );
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
                case "_set_sipInfo" :
                    return $this->_set_sipInfo($args['0']);
                    break;
                case "_set_IDs" :
                    return $this->_set_IDs($args['0']);
                    break;
                case "_check" :
                    return $this->$method($args);
                    break;
                case "_getPointAction" :
                    return $this->$method($args[0]);
                    break;
                case "_deleteSip" :
                    return $this->_deleteSip($args['0']);
                    break;
                case "_getSipList" :
                    return $this->_getSipList($args['0']);
                    break;
                case "_getSipListById" :
                    return $this->_getSipListById($args['0']);
                    break;
                case "_insertSip" :
                    return $this->_insertSip();
                    break;
                case "_updateSip" :
                    return $this->_updateSip();
                    break;
                case "_changeStatus" :
                    return $this->_changeStatus($args['0']);
                    break;
                case "_trashSips" :
                    return $this->_trashSips($args['0']);
                    break;
                case "_recycleSips" :
                    return $this->_recycleSips($args['0']);
                    break;
                case "_getSIPByCompany" :
                    return $this->_getSIPByCompany($args['0']);
                    break;
                case "_getSipByOutbound" :
                    return $this->_getSipByOutbound($args['0']);
                    break;
                case "_checkAnnounceDependency" :
                    return $this->_checkAnnounceDependency($args['0']);
                    break;
                case "_checkInboundDependency" :
                    return $this->_checkInboundDependency($args['0']);
                    break;
                case "_checkQueueDependency" :
                    return $this->_checkQueueDependency($args['0']);
                    break;
                case "_checkIvrDependency" :
                    return $this->_checkIvrDependency($args['0']);
                    break;
                case "_checkOutboundDependency" :
                    return $this->_checkOutboundDependency($args['0']);
                    break;
                case "_checkIfNameExists" :
                    return $this->_checkIfNameExists($args['0'], $args['1']);
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
    private function _set_sipInfo($value = '')
    {

        $result['result'] = 1;

        global $admin_info, $company_info;

        /**
         * Checks if the value of announce_id is not empty and is integer.
         */
        if (isset($value['comp_id'])) {

            if (empty($value['comp_id'])) {
                $msg = ModelANNOUNCE_09;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['comp_id'] = $msg;
            } elseif (!Validator::Numeric($value['comp_id'])) {
                $msg = ModelANNOUNCE_10;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['id'] = $msg;
            } else {
                $this->_sipInfo['comp_id'] = $value['comp_id'];
            }

        } else {
            $this->_sipInfo['comp_id'] = $company_info['comp_id'];
        }

        /**
         * Checks if the value of ID is not empty and is integer.
         */
        if (isset($value['id'])) {

            if (empty($value['id'])) {
                $msg = ModelSIP_01;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['id'] = $msg;
            } elseif (!Validator::Numeric($value['id'])) {
                $msg = ModelANNOUNCE_10;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['id'] = $msg;
            } else {
                $this->_sipInfo['id'] = $value['id'];
            }

        }
        /**
         * Checks if the value of NAT is not empty and is string.
         */
        if (isset($value['nat'])) {
            if ($value['nat'] == 'on') {
                $this->_sipInfo['nat'] = 0;
            } else {
                $this->_sipInfo['nat'] = 1;
            }

        }
        /**
         * Checks if the value of Codec is not empty and is string.
         */
        if (empty($value['codec'])) {
            $this->_sipInfo['codec'] = 0;
        } else {
            $this->_sipInfo['codec'] = $value['codec'];
        }

        /**
         * Checks if the value of SipName is not empty and is string.
         */
        if (isset($value['sip_name'])) {
            if (empty($value['sip_name'])) {
                $msg = ModelSIP_02;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['sip_name'] = $msg;
            } elseif (!is_string($value['sip_name'])) {
                $msg = ModelSIP_03;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['sip_name'] = $msg;
            } else {
                $this->_sipInfo['sip_name'] = $value['sip_name'];
            }

        }

        if (isset($value['checkHost'])) {
            if ($value['checkHost'] == 'on') {
                $this->_sipInfo['checkHost'] = '1';
                $this->_sipInfo['host'] = 'Dynamic';
            }
            $this->_sipInfo['checkHost'] = '0';
        }
        /**
         * Checks if the value of Host is not empty and is string.
         */
        if (isset($value['host'])) {
            if (empty($value['host'])) {
                $msg = ModelSIP_04;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['host'] = $msg;
            } elseif (!is_string($value['host'])) {
                $msg = ModelSIP_05;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['host'] = $msg;
            } else {
                $this->_sipInfo['host'] = $value['host'];
            }

        }
        /**
         * Checks if the value of Password is not empty and is string.
         */
        if (isset($value['pass'])) {
            if (!is_string($value['pass'])) {
                $msg = ModelANNOUNCE_16;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['pass'] = $msg;
            } else {
                $this->_sipInfo['pass'] = $value['pass'];
            }

        }


        /**
         * Checks if the value of SipType is not empty and is string.
         */
        if (isset($value['sip_type'])) {
            if (empty($value['sip_type'])) {
                $msg = ModelSIP_06;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['sip_type'] = $msg;
            } elseif (!is_string($value['sip_type'])) {
                $msg = ModelSIP_07;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['sip_type'] = $msg;
            } else {
                $this->_sipInfo['sip_type'] = $value['sip_type'];
            }

        }

        /**
         * Checks if the value of sip_id is not empty and is integer.
         */
        if (isset($value['sip_id'])) {

            if (empty($value['sip_id'])) {
                $msg = ModelSIP_08;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['id'] = $msg;
            } elseif (!Validator::Numeric($value['sip_id'])) {
                $msg = ModelSIP_09;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['sip_id'] = $msg;
            } else {
                $this->_sipInfo['sip_id'] = $value['sip_id'];
            }

        }

        /**
         * Checks if the value of ID is not empty and is integer.
         */
        /* if (isset($value['comp_id']))
         {
             if (empty($value['comp_id']))
             {
                 $msg='Please enter comp id';

                 if($result['result']==1)
                 {
                     $result['msg'] = $msg;
                 }
                 $result['result'] = -1;
                 $result['err'] = -2;

                 $result['msgList']['comp_id'] =  $msg;
             }
             elseif(!Validator::Numeric($value['comp_id']))
             {
                 $msg='Comp ID should only contain numbers.';

                 if($result['result']==1)
                 {
                     $result['msg'] = $msg;
                 }
                 $result['result'] = -1;
                 $result['err'] = -2;

                 $result['msgList']['comp_id'] =  $msg;
             }
             {
                 $this->_sipInfo['comp_id'] = $value['comp_id'];
             }

         }*/


        /**
         * Checks if the value of codec is not empty and is integer.
         */
        /* if (isset($value['codec']))
         {
             if (empty($value['codec']))
             {
                 $msg='Please enter codec.';

                 if($result['result']==1)
                 {
                     $result['msg'] = $msg;
                 }
                 $result['result'] = -1;
                 $result['err'] = -2;

                 $result['msgList']['codec'] =  $msg;
             }
             elseif(!is_string($value['codec']))
             {
                 $msg='codec should only contain characters.';

                 if($result['result']==1)
                 {
                     $result['msg'] = $msg;
                 }
                 $result['result'] = -1;
                 $result['err'] = -2;

                 $result['msgList']['codec'] =  $msg;
             }
             else
             {
               $this->_sipInfo['codec'] = $value['codec'];
             }

         }*/

        /**
         * Checks if the value of sip_type is not empty and is numeric.
         */
        /*if (isset($value['sip_type']))
        {
            if (empty($value['sip_type']))
            {
                $msg='Please enter sip_type.';

                if($result['result']==1)
                {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;
                $result['msgList']['sip_type'] =  $msg;
            }
            elseif(!Validator::Numeric($value['sip_type']))
            {
                $msg='Phone number should only contain numbers.';

                if($result['result']==1)
                {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;
                $result['msgList']['sip_type'] =  $msg;

            }
            else
            {
                $this->_sipInfo['sip_type'] = $value['sip_type'];

            }

        }*/

        return $result;

    }

    /**
     * Specifies the type of output
     * @param $value
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
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
                    $res['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;
                $result['msgList'][$key] = $msg;
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
            case 'paging':
                return $this->_paging;
                break;
            case 'sipList':
                return $this->_sipList;
                break;
            case 'sipInfo':
                return $this->_sipInfo;
                break;
            default:
                break;
        }
    }

    /**
     * Gets the Sip list based on its ID
     * @param   $sipID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getSipListById($sipID)
    {
        //global $conn, $lang;

        if (is_int($sipID)) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = ModelCOMPANY_16;
            $result['func'] = 'getSipListById';
            return $result;
        }

        $this->getSipDbObj();
        $result = $this->_sipDbObj->getSipById($sipID);

        if ($result['result'] == -1) {
            return $result;
        }

        $this->_sipInfo = $this->_sipDbObj->sipFields;
        $this->_sipDbObj = '';
        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }

    /**
     * Access the database class
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function getSipDbObj()
    {
        include_once(ROOT_DIR . "component/sip.db.class.php");
        $this->_sipDbObj = new sip_db();
    }

    /**
     * Deletes Sip
     * @param  $sipID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    private function _deleteSip_temp($sipID)
    {
        //global $conn, $lang;
        $this->getSipDbObj();
        $result = $this->_sipDbObj->removeSipDB($sipID);
        unset($this->_sipDbObj);

        if ($result == -1) {
            $result['result'] = -1;
            $result['no'] = 2;
            return $result;
        }

        $result['result'] = 1;
        return $result;
    }

    /**
     * Gets the sip list
     * @param  $fields
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getSipList($fields)
    {
        //global $conn, $lang;
        $this->getSipDbObj();
        //$fields['filter'] = Array ('trash' => '0');
        $result = $this->_sipDbObj->getSip($fields);

        if ($result['result'] != 1) {
            return $result;
        }

        $this->_paging = $this->_sipDbObj->paging;
        $this->_sipList = $this->_sipDbObj->sipList;
        unset($this->_sipDbObj);
        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }

    /**
     * Inserts SIP
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _insertSip()
    {
        //global $conn, $lang;
        global $admin_info, $company_info;
        $this->getSipDbObj();
        $result = $this->_sipDbObj->set_sipFields($this->_sipInfo);

        if ($result['result'] == -1) {
            return $result;
        }

        $resultInsert = $this->_sipDbObj->insertSipDB();

        if ($resultInsert['result'] == -1) {
            return $resultInsert['msg'];
        }

        $result = $this->set_sipInfo($this->_sipDbObj->sipFields);
        $result['result'] = 1;

        include_once(ROOT_DIR . "component/package.db.class.php");

      /*  $packageLogResult = package_db::calculateExtension('+', $company_info['comp_id']);


        if ($packageLogResult == -1) {
            $packageLogResult['result'] = -1;
            $packageLogResult['no'] = 2;
            return $packageLogResult;
        }*/

        include_once(ROOT_DIR . "component/company.db.class.php");
        $companyResult = company_db::updateReload();

        if ($companyResult == -1) {
            $companyResult['result'] = -1;
            $companyResult['no'] = 2;
            return $companyResult;
        }

        $result['no'] = 2;
        return $result;
    }

    /**
     * Updates SIP
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _updateSip()
    {
        //global $conn, $lang;
        $this->getSipDbObj();
        $result = $this->_sipDbObj->set_sipFields($this->_sipInfo);

        if ($result['result'] == -1) {
            return $result;
        }
        $resultUpdate = $this->_sipDbObj->updateSipDB();

        if ($resultUpdate['result'] == -1) {
            return $resultUpdate['msg'];
        }

        include_once(ROOT_DIR . "component/company.db.class.php");
        $companyResult = company_db::updateReload();

        if ($companyResult == -1) {
            $companyResult['result'] = -1;
            $companyResult['no'] = 2;
            return $companyResult;
        }

        $result['no'] = 2;
        return $result;
    }


    /**
     * Change status
     * @param  $value
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _changeStatus($value = '')
    {
        if ($value == 'Disable') {
            $value = '0';
        } else if ($value == 'Enable') {
            $value = '1';
        }
        $this->getSipDbObj();
        $result = $this->_sipDbObj->set_IDs($this->_IDs);

        if ($result['result'] == -1) {
            return $result;
        }

        $result = $this->_sipDbObj->changeStatusDB($value);

        if (!isset($result['result']) or $result['result'] == -1) {
            return $result;
        }

        return $result;
    }

    /**
     * Trashes SIP
     * @param  $sipID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    private function _deleteSip($sipID)
    {


        //global $conn, $lang;
        global $admin_info, $company_info;
        $this->getSipDbObj();
        $result = $this->_sipDbObj->removeSipDB($sipID);

        if ($result == -1) {
            $result['result'] = -1;
            $result['no'] = 2;
            return $result;
        }

        $result['result'] = 1;

        include_once(ROOT_DIR . "component/package.db.class.php");

       /* $packageLogResult = package_db::calculateExtension('-', $company_info['comp_id']);


        if ($packageLogResult == -1) {
            $packageLogResult['result'] = -1;
            $packageLogResult['no'] = 2;
            return $packageLogResult;
        }*/

        include_once(ROOT_DIR . "component/company.db.class.php");
        $companyResult = company_db::updateReload();

        if ($companyResult == -1) {
            $companyResult['result'] = -1;
            $companyResult['no'] = 2;
            return $companyResult;
        }

        return $result;
    }

    /**
     * Recycles SIP
     * @param  $sipID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    private function _recycleSips($sipID)
    {
        //global $conn, $lang;
        $this->getSipDbObj();
        $result = $this->_sipDbObj->recycleSipDB($sipID);

        if ($result == -1) {
            $result['result'] = -1;
            $result['no'] = 2;
            return $result;
        }

        $result['result'] = 1;
        return $result;
    }

    /**
     * Gets the SIP list based on its ID
     * @param   $companyID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getSIPByCompany($companyID)
    {
        //global $conn, $lang;
        if (is_int($companyID)) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = ModelCOMPANY_16;
            $result['func'] = 'getUploadByCompany';
            return $result;
        }

        $this->getSipDbObj();
        $where = "comp_id= '$companyID'";
        $result = $this->_sipDbObj->GetAll($where);
        $this->_sipList = $this->_sipDbObj->sipList;

        unset($this->_queueDbObj);
        return $result;
    }


    /**
     * Gets the file based on its ID that have been linked to an announce.
     * @param   $sipID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getSipByOutbound($sipID)
    {
        //global $conn, $lang;
        if (is_int($sipID)) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = ModelCOMPANY_16;
            $result['func'] = 'getUploadByCompany';
            return $result;
        }

        $this->getSipDbObj();
        $where = "sip_id= '$sipID' AND trash = '0'";
        $result = $this->_sipDbObj->GetAll($where);
        $this->_sipList = $this->_sipDbObj->sipList;
        unset($this->_sipDbObj);
        return $result;
    }

    /**
     * Checks the dependency before deleting
     * @return  mixed
     * @param  $sipID
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _checkAnnounceDependency($sipID)
    {
        //global $conn, $lang;
        include_once(ROOT_DIR . "component/announce.operation.class.php");
        $announce = new announce_operation();
        $result = $announce->getAnnounceBySip($sipID);

        if ($result['result'] = 1) {
            $result['list'] = $announce->announceList;
            return $result;
        }

        $result['result'] = -1;
        $result['no'] = 2;
        return $result;
    }

    /**
     * Checks the dependency before deleting
     * @return  mixed
     * @param  $sipID
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _checkInboundDependency($sipID)
    {
        //global $conn, $lang;
        include_once(ROOT_DIR . "component/inbound.operation.class.php");
        $inbound = new inbound_operation();
        $result = $inbound->getInboundBySip($sipID);

        if ($result['result'] = 1) {
            $result['list'] = $inbound->inboundList;
            return $result;
        }

        $result['result'] = -1;
        $result['no'] = 2;
        return $result;
    }

    /**
     * Checks the dependency before deleting
     * @return  mixed
     * @param  $sipID
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _checkQueueDependency($sipID)
    {
        //global $conn, $lang;
        include_once(ROOT_DIR . "component/queue.operation.class.php");
        $queue = new queue_operation();
        $result = $queue->getQueueBySip($sipID);

        if ($result['result'] = 1) {
            $result['list'] = $queue->queueList;
            return $result;
        }

        $result['result'] = -1;
        $result['no'] = 2;
        return $result;
    }


    /**
     * Checks the dependency before deleting
     * @return  mixed
     * @param  $sipID
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _checkIvrDependency($sipID)
    {
        //global $conn, $lang;
        include_once(ROOT_DIR . "component/ivr.operation.class.php");
        $queue = new ivr_operation();
        $result = $queue->getIvrBySip($sipID);

        if ($result['result'] = 1) {
            $result['list'] = $queue->ivrList;
            return $result;
        }

        $result['result'] = -1;
        $result['no'] = 2;
        return $result;
    }


    /**
     * Checks the dependency before deleting
     * @return  mixed
     * @param  $sipID
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _checkOutboundDependency($sipID)
    {
        //global $conn, $lang;
        include_once(ROOT_DIR . "component/outbound.operation.class.php");
        $outbound = new outbound_operation();
        $result = $outbound->getOutboundBySip($sipID);

        if ($result['result'] = 1) {
            $result['list'] = $outbound->outboundList;
            return $result;
        }

        $result['result'] = -1;
        $result['no'] = 2;
        return $result;
    }


    /**
     * Gets the Sip list based on its ID
     * @param   $name
     * @param   $compID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _checkIfNameExists($name, $compID)
    {
        //global $conn, $lang;
        $this->getSipDbObj();
        $result = $this->_sipDbObj->checkIfNameExistsDB($name, $compID);

        if ($result == -1) {
            $result['result'] = -1;
            $result['no'] = 2;
            return $result;
        }

        $result['result'] = 1;
        return $result;
    }
}

