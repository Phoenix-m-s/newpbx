<?php
include_once(ROOT_DIR . "component/Validators.class.php");

/**
 * @author Malekloo Izadi Sakhamanesh <Izadi@dabacenter.ir>
 * @version 0.0.1 this is the beta version of News
 * @copyright 2015 The Imen Daba Parsian Co.
 */
class announce_operation
{

    /**
     * Contains sip info
     * @var
     */
    private $_announceInfo;
    /**
     * Contains List of sip
     * @var
     */
    private $_announceList;
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
    private $_announceDbObj;
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
        $this->_announceInfo = array();
        $this->addForm = array();
        $this->addForm = array(
            'announce_name' => '',
            'upload_id' => '',
            'repeat_input' => '',
            'DSTOption' => '',
            'dst_option_sub_id' => ''
        );

        $this->editForm = array();
        $this->editForm = array(
            'announce_id' => '',
            'announce_name' => '',
            'upload_id' => '',
            'repeat_input' => '',
            'DSTOption' => '',
            'dst_option_sub_id' => ''
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
                case "_set_announceInfo" :
                    return $this->_set_announceInfo($args['0']);
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
                case "_deleteAnnounce" :
                    return $this->_deleteAnnounce($args['0']);
                    break;
                case "_getAnnounceList" :
                    return $this->_getAnnounceList($args['0']);
                    break;
                case "_getAnnounceListById" :
                    return $this->_getAnnounceListById($args['0']);
                    break;
                case "_insertAnnounce" :
                    return $this->_insertAnnounce();
                    break;
                case "_updateAnnounce" :
                    return $this->_updateAnnounce();
                    break;
                case "_changeStatus" :
                    return $this->_changeStatus($args['0']);
                    break;
                case "_trashAnnounce" :
                    return $this->_trashAnnounce($args['0']);
                    break;
                case "_recycleAnnounce" :
                    return $this->_recycleAnnounce($args['0']);
                    break;
                case "_getAnnounceByCompany" :
                    return $this->_getAnnounceByCompany($args['0']);
                    break;
                case "_checkUploadDependency" :
                    return $this->_checkUploadDependency($args['0']);
                    break;
                case "_getAnnounceBySip" :
                    return $this->_getAnnounceBySip($args['0']);
                    break;
                case "_getAnnounceByQueue" :
                    return $this->_getAnnounceByQueue($args['0']);
                    break;
                case "_getAnnounceByIvr" :
                    return $this->_getAnnounceByIvr($args['0']);
                    break;
                case "_getAnnounceByExtension" :
                    return $this->_getAnnounceByExtension($args['0']);
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
                case "_getAnnounceByFile" :
                    return $this->_getAnnounceByFile($args['0']);
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
    private function _set_announceInfo($value = '')
    {
        global $admin_info, $company_info;
        $result['result'] = 1;


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
                $this->_announceInfo['comp_id'] = $value['comp_id'];
            }

        } else {
            $this->_announceInfo['comp_id'] = $company_info['comp_id'];
        }


        /**
         * Checks if the value of announce_id is not empty and is integer.
         */
        if (isset($value['announce_id'])) {

            if (empty($value['announce_id'])) {
                $msg = ModelANNOUNCE_11;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['announce_id'] = $msg;
            } elseif (!Validator::Numeric($value['announce_id'])) {
                $msg = ModelANNOUNCE_10;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['id'] = $msg;
            } else {
                $this->_announceInfo['announce_id'] = $value['announce_id'];
            }

        }
        /**
         * Checks if the value of dst_option_id is not empty and is string.
         */
        if (empty($value['DSTOption'])) {
            $this->_announceInfo['DSTOption'] = 0;
        } else {
            $this->_announceInfo['DSTOption'] = $value['DSTOption'];
        }

        /**
         * Checks if the value of dst_option_sub_id is not empty and is string.
         */
        if (empty($value['dst_option_sub_id'])) {
            $this->_announceInfo['dst_option_sub_id'] = 0;
        } else {
            $this->_announceInfo['dst_option_sub_id'] = $value['dst_option_sub_id'];
        }

        /**
         * Checks if the value of announce_id is not empty and is integer.
         */
        if (isset($value['upload_id'])) {

            if (empty($value['upload_id'])) {
                $msg = ModelANNOUNCE_12;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['upload_id'] = $msg;
            } elseif (!Validator::Numeric($value['upload_id'])) {
                $msg = ModelANNOUNCE_10;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['id'] = $msg;
            } else {
                $this->_announceInfo['upload_id'] = $value['upload_id'];
            }

        }

        /**
         * Checks if the value of announce_name is not empty and is string.
         */
        if (isset($value['announce_name'])) {
            if (empty($value['announce_name'])) {
                $msg = ModelANNOUNCE_13;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['announce_name'] = $msg;
            } elseif (!is_string($value['announce_name'])) {
                $msg = ModelANNOUNCE_14;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['announce_name'] = $msg;
            } else {
                $this->_announceInfo['announce_name'] = $value['announce_name'];
            }

        }

        /**
         * Checks if the value of repeat is not empty and is string.
         */
        if (isset($value['repeat_input'])) {
            if (empty($value['repeat_input'])) {
                $msg = ModelANNOUNCE_15;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['repeat_input'] = $msg;
            } elseif (!is_string($value['repeat_input'])) {
                $msg = ModelANNOUNCE_16;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['repeat'] = $msg;
            } else {
                $this->_announceInfo['repeat_input'] = $value['repeat_input'];
            }

        }

        /**
         * Checks if the value of announce_date is not empty and is integer.
         */
        $this->_announceInfo['announce_date'] = $value['announce_date'];
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
     * @date    08/08/2015
     */
    public function __get($field)
    {

        switch ($field) {
            case 'paging':
                return $this->_paging;
                break;
            case 'announceList':
                return $this->_announceList;
                break;
            case 'announceInfo':
                return $this->_announceInfo;
                break;
            default:
                break;
        }
    }

    /**
     * Gets the Sip list based on its ID
     * @param   $announceID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getAnnounceListById($announceID)
    {
        //global $conn, $lang;

        if (is_int($announceID)) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = 'Wrong ID';
            $result['func'] = 'getAnnounceListById';
            return $result;
        }

        $this->getAnnounceDbObj();
        $result = $this->_announceDbObj->getAnnounceById($announceID);

        if ($result['result'] == -1) {
            return $result;
        }

        $this->_announceInfo = $this->_announceDbObj->announceFields;
        $this->_announceDbObj = '';
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
    private function getAnnounceDbObj()
    {
        include_once(ROOT_DIR . "component/announce.db.class.php");
        $this->_announceDbObj = new announce_db();
    }

    /**
     * Deletes Sip
     * @param  $announceID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    private function _deleteAnnounce_temp($announceID)
    {
        // global $conn, $lang;
        $this->getAnnounceDbObj();
        $result = $this->_announceDbObj->removeAnnounceDB($announceID);
        unset($this->_announceDbObj);
        if ($result == -1) {
            $result['result'] = -1;
            $result['no'] = 2;
            return $result;
        }
        $result['result'] = 1;
        return $result;
    }

    /**
     * Gets the news list
     * @param  $fields
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getAnnounceList($fields)
    {
        //global $conn, $lang;
        $this->getAnnounceDbObj();
        $result = $this->_announceDbObj->getAnnounce($fields);

        if ($result['result'] != 1) {
            return $result;
        }

        $this->_paging = $this->_announceDbObj->paging;
        $this->_announceList = $this->_announceDbObj->announceList;
        unset($this->_announceDbObj);
        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }

    /**
     * Insert Announce
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _insertAnnounce()
    {

        //global $conn, $lang;
        global $admin_info, $company_info;
        $this->getAnnounceDbObj();
        $result = $this->_announceDbObj->set_announceFields($this->_announceInfo);

        if ($result['result'] == -1) {
            return $result;
        }

        $resultInsert = $this->_announceDbObj->insertAnnounceDB();

        if ($resultInsert['result'] == -1) {
            return $resultInsert['msg'];
        }

        $result = $this->set_announceInfo($this->_announceDbObj->announceFields);
        $result['result'] = 1;
        $result['no'] = 2;

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

        return $result;
    }

    /**
     * Update Announce
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _updateAnnounce()
    {
        //global $conn, $lang;
        $this->getAnnounceDbObj();
        $this->_announceInfo['announce_date'] = date('Y-m-d H:m:s');
        $result = $this->_announceDbObj->set_announceFields($this->_announceInfo);

        if ($result['result'] == -1) {
            return $result;
        }

        $resultUpdate = $this->_announceDbObj->updateAnnounceDB();

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
     * Change Status
     * @return  mixed
     * @param  $value
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

        $this->getAnnounceDbObj();
        $result = $this->_announceDbObj->set_IDs($this->_IDs);

        if ($result['result'] == -1) {
            return $result;
        }

        $result = $this->_announceDbObj->changeStatusDB($value);

        if (!isset($result['result']) or $result['result'] == -1) {
            return $result;
        }

        return $result;
    }

    /**
     * Trash Announce
     * @param  $announceID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    private function _deleteAnnounce($announceID)
    {
        //global $conn, $lang;
        global $admin_info, $company_info;


        $this->getAnnounceDbObj();
        $result = $this->_announceDbObj->removeAnnounceDB($announceID);
        if ($result == -1) {
            $result['result'] = -1;
            $result['no'] = 2;
            return $result;
        }
        $result['result'] = 1;

        include_once(ROOT_DIR . "component/package.db.class.php");

      /*  $packageLogResult = package_db::calculateExtension('-', $company_info['comp_id']);


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

        $result['result'] = 1;
        return $result;
    }

    /**
     * Recycle Announce
     * @param  $announceID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    private function _recycleAnnounce($announceID)
    {
        //global $conn, $lang;
        $this->getAnnounceDbObj();
        $result = $this->_announceDbObj->recycleAnnounceDB($announceID);

        if ($result == -1) {
            $result['result'] = -1;
            $result['no'] = 2;
            return $result;
        }

        $result['result'] = 1;
        return $result;
    }

    /**
     * Gets Announce based on its ID
     * @param   $companyID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getAnnounceByCompany($companyID)
    {
        //global $conn, $lang;

        if (is_int($companyID)) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = 'Wrong ID';
            $result['func'] = 'getAnnounceListById';
            return $result;
        }


        $this->getAnnounceDbObj();
        $where = "comp_id= '$companyID' AND trash = '0'";
        $result = $this->_announceDbObj->GetAll($where);
        $this->_announceList = $this->_announceDbObj->announceList;
        unset($this->_announceDbObj);
        return $result;
    }


    /**
     * Gets Announce list based on SIp
     * @param   $sipID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getAnnounceBySip($sipID)
    {
        //global $conn, $lang;

        if (is_int($sipID)) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = 'Wrong ID';
            $result['func'] = 'getAnnounceListById';
            return $result;
        }


        $this->getAnnounceDbObj();
        $where = "dst_option_id= '1' AND dst_option_sub_id = '$sipID' AND trash = '0'";
        $result = $this->_announceDbObj->GetAll($where);
        $this->_announceList = $this->_announceDbObj->announceList;
        unset($this->_announceDbObj);
        return $result;
    }


    /**
     * Checks the dependency of announce and file before deleting the announce.
     * @return  mixed
     * @param  $uploadID
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _checkUploadDependency($uploadID)
    {
        //global $conn, $lang;
        include_once(ROOT_DIR . "component/upload.operation.class.php");
        $Upload = new upload_operation();
        $result = $Upload->getUploadByAnnounce($uploadID);

        if ($result['result'] = 1) {
            $result['list'] = $Upload->uploadList;
            return $result;

        }

        $result['result'] = -1;
        $result['no'] = 2;
        return $result;
    }


    /**
     * Gets the Announce list based on Queue
     * @param   $queueID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getAnnounceByQueue($queueID)
    {
        //global $conn, $lang;
        if (is_int($queueID)) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = 'Wrong ID';
            $result['func'] = 'getAnnounceListById';
            return $result;
        }

        $this->getAnnounceDbObj();
        $where = "dst_option_id= '2' AND dst_option_sub_id = '$queueID' AND trash = '0'";
        $result = $this->_announceDbObj->GetAll($where);
        $this->_announceList = $this->_announceDbObj->announceList;
        unset($this->_announceDbObj);
        return $result;
    }

    /**
     * Gets the Announce list based on IVR
     * @param   $ivrID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getAnnounceByIvr($ivrID)
    {
        //global $conn, $lang;
        if (is_int($ivrID)) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = 'Wrong ID';
            $result['func'] = 'getAnnounceListById';
            return $result;
        }

        $this->getAnnounceDbObj();
        $where = "dst_option_id= '5' AND dst_option_sub_id = '$ivrID' AND trash = '0'";
        $result = $this->_announceDbObj->GetAll($where);
        $this->_announceList = $this->_announceDbObj->announceList;
        unset($this->_announceDbObj);
        return $result;
    }

    /**
     * Gets the Announce list based on Extension
     * @param   $extensionID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getAnnounceByExtension($extensionID)
    {
        //global $conn, $lang;
        if (is_int($extensionID)) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = 'Wrong ID';
            $result['func'] = 'getAnnounceByExtension';
            return $result;
        }

        $this->getAnnounceDbObj();
        $where = "dst_option_id= '3' AND dst_option_sub_id = '$extensionID' AND trash = '0'";
        $result = $this->_announceDbObj->GetAll($where);

        $this->_announceList = $this->_announceDbObj->announceList;
        return $result;
    }

    /**
     * Gets the Announce list based on File
     * @param   $uploadID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getAnnounceByFile($uploadID)
    {
        //global $conn, $lang;
        if (is_int($uploadID)) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = 'Wrong ID';
            $result['func'] = 'getAnnounceByExtension';
            return $result;
        }

        $this->getAnnounceDbObj();
        $where = "upload_id = '$uploadID' AND trash = '0'";
        $result = $this->_announceDbObj->GetAll($where);
        $this->_announceList = $this->_announceDbObj->announceList;
        unset($this->_announceDbObj);
        return $result;
    }

    /**
     * Checks if the name exists
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
        $this->getAnnounceDbObj();
        $result = $this->_announceDbObj->checkIfNameExistsDB($name, $compID);

        if ($result == -1) {
            $result['result'] = -1;
            $result['no'] = 2;
            return $result;
        }

        $result['result'] = 1;
        return $result;
    }

    /**
     * Checks the dependency before deleting
     * @return  mixed
     * @param  $announceID
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _checkInboundDependency($announceID)
    {
        //global $conn, $lang;
        include_once(ROOT_DIR . "component/inbound.operation.class.php");
        $inbound = new inbound_operation();
        $result = $inbound->getInboundByAnnounce($announceID);

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
     * @param  $announceID
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _checkQueueDependency($announceID)
    {
        //global $conn, $lang;
        include_once(ROOT_DIR . "component/queue.operation.class.php");
        $queue = new queue_operation();
        $result = $queue->getQueueByAnnounce($announceID);

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
     * @param  $announceID
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _checkIvrDependency($announceID)
    {
        //global $conn, $lang;
        include_once(ROOT_DIR . "component/ivr.operation.class.php");
        $queue = new ivr_operation();
        $result = $queue->getIvrByAnnounce($announceID);

        if ($result['result'] = 1) {
            $result['list'] = $queue->ivrList;
            return $result;
        }

        $result['result'] = -1;
        $result['no'] = 2;
        return $result;
    }

}
