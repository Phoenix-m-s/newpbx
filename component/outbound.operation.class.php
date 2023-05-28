<?php
include_once(ROOT_DIR . "component/Validators.class.php");

/**
 * @author Malekloo Izadi Sakhamanesh <Izadi@dabacenter.ir>
 * @version 0.0.1 this is the beta version of outbound
 * @copyright 2015 The Imen Daba Parsian Co.
 */
class outbound_operation
{
    /**
     * Contains inbound info
     * @var
     */
    private $_outboundInfo;
    /**
     * Contains List of inbound
     * @var
     */
    private $_outboundList;
    /**     * @var
     */
    private $_paging;
    /**     * @var
     */
    public $_set;
    /**
     * Accessing the database
     * @var
     */
    private $_outboundDialPatternInfo;
    /**
     * @var
     */
    private $_outboundDbObj;
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
     * @date    05/09/2015
     */
    public function __construct()
    {
        $this->_outboundInfo = array();
        $this->addForm = array(
            'outbound_name' => '',
            'caller_id_name' => '',
            'caller_id_number' => '',
            'prepend' => '',
            'prefix' => '',
            'caller_id' => '',
            'match_pattern' => '',
            'sip_id' => '',
            'priority' => ''
        );
        $this->editForm = array(
            'outbound_id' => '',
            'outbound_name' => '',
            'caller_id_name' => '',
            'caller_id_number' => '',
            'prepend' => '',
            'prefix' => '',
            'caller_id' => '',
            'match_pattern' => '',
            'priority' => '',
            'sip_id' => ''
        );
    }

    /**
     * Specifies the type of output
     * @param $property
     * @param $value
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since 01.01.01
     * @date    05/09/2015
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
     * @since   05/09/2015
     * @date    05/09/2015
     */
    function __call($method, $args)
    {
        $method = '_' . $method;
        if (method_exists($this, $method)) {
            switch ($method) :
                case "_set_OutboundInfo" :
                    return $this->_set_OutboundInfo($args['0']);
                    break;
                case "_set_dialPatternInfo" :
                    return $this->_set_dialPatternInfo($args['0']);
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
                case "_deleteOutbound" :
                    return $this->_deleteOutbound($args['0']);
                    break;
                case "_deleteOutbound1" :
                    return $this->_deleteOutbound1($args['0']);
                    break;
                case "_getOutboundList" :
                    return $this->_getOutboundList($args['0']);
                    break;
                case "_getOutboundListById" :
                    return $this->_getOutboundListById($args['0']);
                    break;
                case "_insertOutbound" :
                    return $this->_insertOutbound();
                    break;
                case "_insertOutboundToDialPattern" :
                    return $this->_insertOutboundToDialPattern($args['0']);
                    break;
                case "_updateOutbound" :
                    return $this->_updateOutbound();
                    break;
                case "_updateOutboundToDialPattern" :
                    return $this->_updateOutboundToDialPattern($args['0']);
                case "_changeStatus" :
                    return $this->_changeStatus($args['0']);
                    break;
                case "_trashOutbound" :
                    return $this->_trashOutbound($args['0']);
                    break;
                case "_recycleOutbound" :
                    return $this->_recycleOutbound($args['0']);
                    break;
                case "_getOutboundByCompany" :
                    return $this->_getOutboundByCompany($args['0']);
                    break;
                case "_getOutboundBySip" :
                    return $this->_getOutboundBySip($args['0']);
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
     * @date    05/09/2015
     *
     */
    private function _set_OutboundInfo($value = '')
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
                $this->_outboundInfo['comp_id'] = $value['comp_id'];
            }

        } else {
            $this->_outboundInfo['comp_id'] = $company_info['comp_id'];
        }
        /**
         * Checks if the value of ID is not empty and is integer.
         */
        if (isset($value['outbound_id'])) {
            if (empty($value['outbound_id'])) {
                $msg = ModelOUTBOUND_01;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['outbound_id'] = $msg;
            } elseif (!Validator::Numeric($value['outbound_id'])) {

                $msg = ModelANNOUNCE_10;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['outbound_id'] = $msg;

            } else {

                $this->_outboundInfo['outbound_id'] = $value['outbound_id'];
            }


        }
        /**
         * Checks if the value of ID is not empty and is integer.
         */
        if (isset($value['priority'])) {
            if (empty($value['priority'])) {
                $msg = ModelOUTBOUND_02;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['priority'] = $msg;
            } elseif (!Validator::Numeric($value['priority'])) {

                $msg = ModelOUTBOUND_03;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['priority'] = $msg;

            } else {

                $this->_outboundInfo['priority'] = $value['priority'];
            }


        }

        /**
         * Checks if the value of inboundName is not empty and is string.
         */
        if (isset($value['outbound_name'])) {

            if (empty($value['outbound_name'])) {

                $msg = ModelOUTBOUND_04;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['outbound_name'] = $msg;

            } elseif (!is_string($value['outbound_name'])) {
                $msg = ModelOUTBOUND_05;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['outbound_name'] = $msg;
            } else {
                $this->_outboundInfo['outbound_name'] = $value['outbound_name'];
            }

        }

        if (isset($value['caller_id_name'])) {
            $this->_outboundInfo['caller_id_name'] = $value['caller_id_name'];
        }

        if (isset($value['caller_id_number'])) {
            $this->_outboundInfo['caller_id_number'] = $value['caller_id_number'];
        }
        /**
         * Checks if the value of sip_id is not empty and is string.
         */
        if (isset($value['sip_id'])) {
            $this->_outboundInfo['sip_id'] = $value['sip_id'];
        } else {
            $this->_outboundInfo['sip_id'] = 0;
        }

        return $result;
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
     * @date    05/09/2015
     *
     */
    private function _set_dialPatternInfo($value = '')
    {


        $result['result'] = 1;

        $count = count($value['prepend']);


        for ($i = 0; $i <= $count - 1; $i++) {

            if ($value['match_pattern'][$i] == '') {
                $msg = ModelOUTBOUND_06;

                $result['msg'] = $msg;

                $result['result'] = -1;
                $result['err'] = -2;
                return $result;
            } else {
                $this->_outboundDialPatternInfo['match_pattern'][$i] = $value['match_pattern'][$i];
            }

            if (empty($value['prepend'][$i])) {
                $this->_outboundDialPatternInfo['prepend'][$i] = '';
            } else {
                $this->_outboundDialPatternInfo['prepend'][$i] = $value['prepend'][$i];
            }

            if (empty($value['prefix'][$i])) {
                $this->_outboundDialPatternInfo['prefix'][$i] = '';

            } else {

                $this->_outboundDialPatternInfo['prefix'][$i] = $value['prefix'][$i];
            }

            if (empty($value['caller_id'][$i])) {

                $this->_outboundDialPatternInfo['caller_id'][$i] = '';
            } else {
                $this->_outboundDialPatternInfo['caller_id'][$i] = $value['caller_id'][$i];
            }


        }

        return $result;
    }


    /**
     * Specifies the type of output
     * @param $value
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    05/09/2015
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
     * @date    05/09/2015
     */
    public function __get($field)
    {

        switch ($field) {
            case 'paging':
                return $this->_paging;
                break;
            case 'outboundList':
                return $this->_outboundList;
                break;
            case 'outboundInfo':
                return $this->_outboundInfo;
                break;
            case 'outboundDialPatternInfo':
                return $this->_outboundDialPatternInfo;
                break;

            default:
                break;
        }
    }

    /**
     * Gets the outbound list based on its ID
     * @param   $outboundID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    05/09/2015
     */
    private function _getOutboundListById($outboundID)
    {

        global $conn, $lang;

        if (is_int($outboundID)) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = ModelCOMPANY_16;
            $result['func'] = 'getOutboundListById';
            return $result;
        }
        $this->getOutboundDbObj();
        $result = $this->_outboundDbObj->getOutboundById($outboundID);

        if ($result['result'] == -1) {
            return $result;
        }


        $this->_outboundInfo = $this->_outboundDbObj->outboundFields;
        $this->_outboundDialPatternInfo = $this->_outboundDbObj->outboundDialPatternFields;
        $this->_outboundDbObj = '';
        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }

    /**
     * Access the database class
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    05/09/2015
     */
    private function getOutboundDbObj()
    {
        include_once(ROOT_DIR . "component/outbound.db.class.php");
        $this->_outboundDbObj = new outbound_db();
    }

    /**
     * Deletes outbound
     * @param  $outboundID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   05/09/2015
     * @date    05/09/2015
     */
    private function _deleteOutbound($outboundID)
    {

        global $conn, $lang;
        $this->getOutboundDbObj();
        $result = $this->_outboundDbObj->removeOutboundDB($outboundID);
        unset($this->_outboundDbObj);
        if ($result == -1) {
            $result['result'] = -1;
            $result['no'] = 2;
            return $result;
        }
        $result['result'] = 1;
        $result['result'] = 1;
        include_once(ROOT_DIR . "component/package.db.class.php");
        /*$packageLogResult = package_db::calculateExtension('-', $company_info['comp_id']);


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
     * Deletes outbound
     * @param  $outboundID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   05/09/2015
     * @date    05/09/2015
     */
    private function _deleteOutbound1($outboundID)
    {

        global $conn, $lang;
        $this->getOutboundDbObj();
        $result = $this->_outboundDbObj->removeOutboundDB1($outboundID);
        unset($this->_outboundDbObj);
        if ($result == -1) {
            $result['result'] = -1;
            $result['no'] = 2;
            return $result;
        }
        $result['result'] = 1;
        return $result;
    }

    /**
     * Gets the get outbound List
     * @param  $fields
     * @return  mixed
     * @author  Malekloo,Sakhamanesh, Izadi
     * @version 01.02.02
     * @date    05/09/2015
     */
    private function _getOutboundList($fields)
    {
        global $conn, $lang;
        $this->getOutboundDbObj();
        $result = $this->_outboundDbObj->getOutbound($fields);

        if ($result['result'] != 1) {
            return $result;
        }

        $this->_paging = $this->_outboundDbObj->paging;
        $this->_outboundList = $this->_outboundDbObj->outboundList;
        unset($this->_outboundDbObj);
        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }

    /**
     * Inserts outbound
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    05/09/2015
     */
    private function _insertOutbound()
    {
        global $conn, $lang;
        global $admin_info, $company_info;
        $this->getOutboundDbObj();
        $result = $this->_outboundDbObj->set_outboundFields($this->_outboundInfo);

        if ($result['result'] == -1) {
            return $result;
        }


        $resultInsert = $this->_outboundDbObj->insertOutboundDB();


        if ($resultInsert['result'] == -1) {
            return $resultInsert['msg'];
        }

        $result = $this->_set_OutboundInfo($this->_outboundDbObj->outboundFields);
        $result['result'] = 1;

        include_once(ROOT_DIR . "component/package.db.class.php");

        /*$packageLogResult = package_db::calculateExtension('+', $company_info['comp_id']);


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
     * insertOutboundToDialPattern list
     * @param  $outboundID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    30/09/2015
     */
    private function _insertOutboundToDialPattern($outboundID)
    {

        global $conn, $lang;
        $this->getOutboundDbObj();

        $result = $this->_outboundDbObj->set_dialPatternInfo($this->_outboundDialPatternInfo);

        if ($result['result'] == -1) {
            return $result;
        }

        $resultInsert = $this->_outboundDbObj->insertOutboundToDialPatternDB($outboundID);

        if ($resultInsert['result'] == -1) {
            return $resultInsert['msg'];
        }

        $result = $this->_set_dialPatternInfo($this->_outboundDbObj->outboundFields);

        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }

    /**
     * Update Outbound
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since 01.01.01
     * @date    05/09/2015
     */
    private function _updateOutbound()
    {

        global $conn, $lang;
        $this->getOutboundDbObj();
        $result = $this->_outboundDbObj->set_outboundFields($this->_outboundInfo);

        if ($result['result'] == -1) {
            return $result;
        }

        $resultInsert = $this->_outboundDbObj->updateOutboundDB();

        if ($resultInsert['result'] == -1) {
            return $resultInsert['msg'];
        }

        $result = $this->_set_OutboundInfo($this->_outboundDbObj->outboundFields);
        include_once(ROOT_DIR . "component/company.db.class.php");
        $companyResult = company_db::updateReload();

        if ($companyResult == -1) {
            $companyResult['result'] = -1;
            $companyResult['no'] = 2;
            return $companyResult;
        }

        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }

    /**
     * Update outbound
     * @param  $outboundID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    30/09/2015
     */
    private function _updateOutboundToDialPattern($outboundID)
    {

        global $conn, $lang;
        $this->getOutboundDbObj();
        $result = $this->_outboundDbObj->set_dialPatternInfo($this->_outboundDialPatternInfo);

        if ($result['result'] == -1) {
            return $result;
        }

        $resultInsert = $this->_outboundDbObj->updateOutboundToDialPatternDB($outboundID);

        if ($resultInsert['result'] == -1) {
            return $resultInsert['msg'];
        }

        $result = $this->_set_dialPatternInfo($this->_outboundDbObj->outboundFields);
        $result['result'] = 1;
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

        $this->getOutboundDbObj();

        $result = $this->_outboundDbObj->set_IDs($this->_IDs);

        if ($result['result'] == -1) {
            return $result;
        }

        $result = $this->_outboundDbObj->changeStatusDB($value);

        if (!isset($result['result']) or $result['result'] == -1) {
            return $result;
        }

        return $result;
    }

    /**
     * Deletes Outbound
     * @param  $outboundID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    private function _trashOutbound($outboundID)
    {
        global $conn, $lang;
        global $admin_info, $company_info;
        $this->getOutboundDbObj();
        $result = $this->_outboundDbObj->trashOutboundDB($outboundID);

        if ($result == -1) {
            $result['result'] = -1;
            $result['no'] = 2;
            return $result;
        }

        $result['result'] = 1;
        include_once(ROOT_DIR . "component/package.db.class.php");
        /*$packageLogResult = package_db::calculateExtension('-', $company_info['comp_id']);


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
     * Recycles outbound
     * @param  $outboundID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    private function _recycleOutbound($outboundID)
    {
        global $conn, $lang;
        $this->getOutboundDbObj();
        $result = $this->_outboundDbObj->recycleOutboundDB($outboundID);

        if ($result == -1) {
            $result['result'] = -1;
            $result['no'] = 2;
            return $result;
        }

        $result['result'] = 1;
        return $result;
    }

    /**
     * Gets the Outbound list based on company
     * @param   $companyID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getOutboundByCompany($companyID)
    {
        //global $conn, $lang;
        if (is_int($companyID)) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = ModelCOMPANY_16;
            $result['func'] = 'getUploadByCompany';
            return $result;
        }

        $this->getOutboundDbObj();
        $where = "comp_id= '$companyID' AND trash = '0'";
        $result = $this->_outboundDbObj->GetAll($where);
        $this->_outboundList = $this->_outboundDbObj->outboundList;
        unset($this->_outboundDbObj);
        return $result;
    }

    /**
     * Gets the Outbound list based on SIP
     * @param   $sipID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getOutboundBySip($sipID)
    {
        //global $conn, $lang;
        if (is_int($sipID)) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = ModelCOMPANY_16;
            $result['func'] = 'getOutboundBySip';
            return $result;
        }

        $this->getOutboundDbObj();
        $where = "siptrunk_id= '$sipID' AND trash = '0'";
        $result = $this->_outboundDbObj->GetAll($where);
        $this->_outboundList = $this->_outboundDbObj->outboundList;
        unset($this->_outboundDbObj);
        return $result;
    }

    /**
     * Checks if name exists
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
        $this->getOutboundDbObj();
        $result = $this->_outboundDbObj->checkIfNameExistsDB($name, $compID);

        if ($result == -1) {
            $result['result'] = -1;
            $result['no'] = 2;
            return $result;
        }

        $result['result'] = 1;
        return $result;
    }

}

