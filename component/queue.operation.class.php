<?php

include_once(ROOT_DIR . "component/Validators.class.php");

/**
 * @author Malekloo Izadi Sakhamanesh <Izadi@dabacenter.ir>
 * @version 0.0.1 this is the beta version of News
 * @copyright 2015 The Imen Daba Parsian Co.
 */
class queue_operation
{
    /**
     * Contains Company info
     * @var
     */
    private $_queueInfo;
    /**
     * Contains List of companies
     * @var
     */
    private $_queueList;
    /**
     * Contains the information of a voice mail
     * @var
     */
    private $_voiceMailInfo;
    /**
     * Contains the list of all the voice mails
     * @var
     */
    private $_voiceMailList;
    /**
     * @var
     */
    public $_set;
    /**
     * Accessing the database
     * @var
     */
    private $_queueDbObj;
    /**
     * @var
     */
    private $_IDs;
    /**
     * @var
     */
    private $_paging;
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
        $this->_queueInfo = array();
        $this->addForm = array();
        $this->addForm = array(
            'Queue_Name' => '',
            'Queue_Ext_Number' => '',
            'Queue_Pass' => '',
            'Max_Wait_Time' => '',
            'Agents_No' => '',
            'Position_Announcement' => '',
            'Hold_Time_Announcement' => '',
            'Frequency' => '',
            'Ring_Strategy' => '',
            'DSTOption' => '',
            'Recording' => '',
            'instead' => '',
            'dst_option_sub_id' => ''
        );

        $this->editForm = array();
        $this->editForm = array(
            'queue_id' => '',
            'dst_option_id' => '',
            'dst_option_sub_id' => '',
            'Queue_Name' => '',
            'Queue_Ext_Number' => '',
            'Queue_Pass' => '',
            'Max_Wait_Time' => '',
            'Agents_No' => '',
            'Position_Announcement' => '',
            'Hold_Time_Announcement' => '',
            'Frequency' => '',
            'Ring_Strategy' => '',
            'DSTOption' => '',
            'Recording' => '',
            'instead' => '',
            'comp_id' => ''
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
                case "_set_info" :
                    return $this->_set_info($args['0']);
                    break;
                case "_set_queueInfo" :
                    return $this->_set_queueInfo($args['0']);
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
                case "_deleteQueue" :
                    return $this->_deleteQueue($args['0']);
                    break;
                case "_trashQueue" :
                    return $this->_trashQueue($args['0']);
                    break;
                case "_recycleQueue" :
                    return $this->_recycleQueue($args['0']);
                    break;
                case "_unTrashQueue" :
                    return $this->_unTrashQueue($args['0']);
                    break;
                case "_getQueueList" :
                    return $this->_getQueueList($args['0']);
                    break;
                case "_getAllExtensionList" :
                    return $this->_getAllExtensionList();
                    break;
                case "_getTrashList" :
                    return $this->_getTrashList();
                    break;
                case "_getQueueListById" :
                    return $this->_getQueueListById($args['0']);
                    break;
                case "_insertQueue" :
                    return $this->_insertQueue();
                    break;
                case "_updateQueue" :
                    return $this->_updateQueue();
                    break;
                case "_changeStatus" :
                    return $this->_changeStatus($args['0']);
                    break;
                case "_getQueueByCompany" :
                    return $this->_getQueueByCompany($args['0']);
                    break;
                case "_getQueueBySip" :
                    return $this->_getQueueBySip($args['0']);
                    break;
                case "_checkAnnounceDependency" :
                    return $this->_checkAnnounceDependency($args['0']);
                    break;
                case "_checkInboundDependency" :
                    return $this->_checkInboundDependency($args['0']);
                    break;
                case "_getQueueByIvr" :
                    return $this->_getQueueByIvr($args['0']);
                    break;
                case "_checkIvrDependency" :
                    return $this->_checkIvrDependency($args['0']);
                    break;
                case "_getQueueByExtension" :
                    return $this->_getQueueByExtension($args['0']);
                    break;
                case "_getQueueByAnnounce" :
                    return $this->_getQueueByAnnounce($args['0']);
                    break;
                case "_getQueueByFile" :
                    return $this->_getQueueByFile($args['0']);
                    break;
                case "_checkIfNameExists" :
                    return $this->_checkIfNameExists($args['0'], $args['1']);
                    break;


            endswitch;
        }
        die();
    }


    /**
     * Validation for fields
     * @param  $value
     * @return  mixed
     * @author  Malekloo,Izadi,Sakhamanesh
     * @version 01.01.01
     * @since 01.01.01
     * @date    08/08/2015
     *
     */
    private function _set_info($value = '')
    {
        $result['result'] = 1;


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
     * @date    08/08/2015
     *
     */
    private function _set_QueueInfo($value = '')
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
                $this->_queueInfo['comp_id'] = $value['comp_id'];
            }

        } else {
            $this->_queueInfo['comp_id'] = $company_info['comp_id'];
        }

        /**
         * Checks if the value of ID is not empty and is integer.
         */
        if (isset($value['id'])) {

            if (empty($value['id'])) {
                $msg = ModelEXTENSION_01;

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
                $this->_queueInfo['id'] = $value['id'];
            }

        }

        /**
         * Checks if the value of ID is not empty and is integer.
         */
        if (isset($value['queue_id'])) {
            if (empty($value['queue_id'])) {
                $msg = ModelQUEUE_02;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['queue_id'] = $msg;
            } elseif (!Validator::Numeric($value['queue_id'])) {
                $msg = ModelQUEUE_02;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['queue_id'] = $msg;
            } else {
                $this->_queueInfo['queue_id'] = $value['queue_id'];
            }

        }
        /**
         * Checks if the value is not empty and is string.
         */
        if (isset($value['Queue_Name'])) {
            if (empty($value['Queue_Name'])) {
                $msg = ModelQUEUE_03;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['Queue_Name'] = $msg;
            } elseif (!is_string($value['Queue_Name'])) {
                $msg = ModelQUEUE_04;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['Queue_Name'] = $msg;
            } else {
                $this->_queueInfo['Queue_Name'] = $value['Queue_Name'];
            }

        }

        /**
         * Checks if the value is numeric and not empty.
         */
        if (isset($value['Queue_Pass'])) {
            if (empty($value['Queue_Pass'])) {
                $msg = ModelQUEUE_05;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['Queue_Pass'] = $msg;
            } else {
                $this->_queueInfo['Queue_Pass'] = $value['Queue_Pass'];
            }

        }

        /**
         * Checks if the value is numeric and not empty.
         */
        if (isset($value['Agents_No'])) {
            if (empty($value['Agents_No'])) {
                $msg = ModelQUEUE_06;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['Agents_No'] = $msg;
            } else {
                $this->_queueInfo['Agents_No'] = $value['Agents_No'];
            }

        }


        /**
         * Checks if the value is numeric and not empty.
         */
        if (isset($value['Max_Wait_Time'])) {
            if (empty($value['Max_Wait_Time'])) {
                $msg = ModelQUEUE_07;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['Max_Wait_Time'] = $msg;
            } elseif (!Validator::Numeric($value['Max_Wait_Time'])) {
                $msg = ModelQUEUE_08;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['Max_Wait_Time'] = $msg;
            } else {
                $this->_queueInfo['Max_Wait_Time'] = $value['Max_Wait_Time'];
            }

        }

        /**
         * Checks if the value is numeric and not empty.
         */
        if (isset($value['Queue_Ext_Number'])) {
            if (empty($value['Queue_Ext_Number'])) {
                $msg = ModelEXTENSION_04;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['Queue_Ext_Number'] = $msg;
            } elseif (!Validator::Numeric($value['Queue_Ext_Number'])) {
                $msg = ModelQUEUE_09;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['Queue_Ext_Number'] = $msg;
            } else {
                $this->_queueInfo['Queue_Ext_Number'] = $value['Queue_Ext_Number'];
            }

        }

        /**
         * Checks if the value of checkbox and puts 1 in it.
         */
        if (isset($value['Position_Announcement'])) {
            if (empty($value['Position_Announcement'])) {
                $msg = ModelQUEUE_10;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['Position_Announcement'] = $msg;
            } else {
                $this->_queueInfo['Position_Announcement'] = 1;
            }

        }

        /**
         * Checks if the value of checkbox and puts 1 in it.
         */
        if (isset($value['Hold_Time_Announcement'])) {
            if (empty($value['Hold_Time_Announcement'])) {
                $msg = ModelQUEUE_11;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['Hold_Time_Announcement'] = $msg;
            } else {
                $this->_queueInfo['Hold_Time_Announcement'] = 1;
            }

        }
        /**
         * Checks if the value of checkbox and puts 1 in it.
         */
        if (isset($value['Recording'])) {
            if (empty($value['Recording'])) {
                $msg = ModelQUEUE_12;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['Recording'] = $msg;
            } else {
                $this->_queueInfo['Recording'] = 1;
            }

        }


        /**
         * Checks if the value is numeric and not empty
         */
        if (isset($value['Frequency'])) {
            if (empty($value['Frequency'])) {
                $msg = ModelQUEUE_13;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['Frequency'] = $msg;
            } elseif (!Validator::Numeric($value['Frequency'])) {
                $msg = ModelQUEUE_14;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['Frequency'] = $msg;
            } else {
                $this->_queueInfo['Frequency'] = $value['Frequency'];
            }

        }


        /**
         * Checks if the value is numeric and not empty
         */
        if (isset($value['DSTOption'])) {
            if (empty($value['DSTOption'])) {
                $msg = ModelINBOUND_09;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['DSTOption'] = $msg;
            } elseif (!Validator::Numeric($value['DSTOption'])) {
                $msg = ModelINBOUND_10;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['DSTOption'] = $msg;
            } else {
                $this->_queueInfo['DSTOption'] = $value['DSTOption'];
            }

        }
        /**
         * Checks if the value of dst_option_sub_id is not empty and is string.
         */
        if (empty($value['dst_option_sub_id'])) {
            $this->_queueInfo['dst_option_sub_id'] = 0;
        } else {
            $this->_queueInfo['dst_option_sub_id'] = $value['dst_option_sub_id'];
        }


        /**
         * Checks if the value is string and not empty.
         */
        if (isset($value['Ring_Strategy'])) {
            if (empty($value['Ring_Strategy'])) {
                $msg = ModelQUEUE_15;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['Ring_Strategy'] = $msg;
            } elseif (!is_string($value['Ring_Strategy'])) {
                $msg = ModelQUEUE_16;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['Ring_Strategy'] = $msg;
            } else {
                $this->_queueInfo['Ring_Strategy'] = $value['Ring_Strategy'];
            }


            if (isset($value['instead'])) {
                $this->_queueInfo['instead'] = $value['instead'];
            }


            /**
             * Checks if the value of ID is not empty and is integer.
             */
            if (isset($value['Secret']) || isset($value['secret2'])) {

                if ($value['Secret'] != $value['secret2']) {
                    $msg = ModelEXTENSION_09;

                    if ($result['result'] == 1) {
                        $result['msg'] = $msg;
                    }
                    $result['result'] = -1;
                    $result['err'] = -2;

                    $result['msgList']['id'] = $msg;
                }
            }

            /**
             * Checks if the value of ID is not empty and is integer.
             */
            if (isset($value['VoiceMailEmail']) || isset($value['VoiceMailPass'])) {
                if (($value['VoiceMailStatus']) === NULL) {
                    $msg = ModelEXTENSION_10;

                    if ($result['result'] == 1) {
                        $result['msg'] = $msg;
                    }
                    $result['result'] = -1;
                    $result['err'] = -2;

                    $result['msgList']['id'] = $msg;
                }

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
            case 'queueList':
                return $this->_queueList;
                break;
            case 'voiceMailInfo':
                return $this->_voiceMailInfo;
                break;
            case 'voiceMailList':
                return $this->_voiceMailList;
                break;
            case 'queueInfo':
                return $this->_queueInfo;
                break;
            case 'paging':
                return $this->_paging;
                break;
            default:
                break;
        }

        die();
    }

    /**
     * Gets the queue list based on its ID
     * @param $queueID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getQueueListById($queueID)
    {
        //global $conn, $lang;

        if (is_int($queueID)) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = ModelCOMPANY_16;
            $result['func'] = 'getCompanyListById';
            return $result;
        }

        $this->getQueueDbObj();
        $result = $this->_queueDbObj->getQueueById($queueID);

        if ($result['result'] == -1) {
            return $result;
        }

        $this->_queueInfo = $this->_queueDbObj->queueFields;

        $this->_queueDbObj = '';
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
    private function getQueueDbObj()
    {
        include_once(ROOT_DIR . "component/queue.db.class.php");
        $this->_queueDbObj = new queue_db();
    }

    /**
     * Deletes queue
     * @param  $queueID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    private function _deleteQueue_temp($queueID)
    {
        // global $conn, $lang;
        $this->getQueueDbObj();
        $result = $this->_queueDbObj->removeQueueDB($queueID);

        if ($result == -1) {
            $result['result'] = -1;
            $result['no'] = 2;
            return $result;
        }

        $result['result'] = 1;
        return $result;
    }

    /**
     * Deletes queue
     * @param  $queueID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    private function _deleteQueue($queueID)
    {
        //global $conn, $lang;
        global $admin_info, $company_info;
        $this->getQueueDbObj();
        $result = $this->_queueDbObj->removeQueueDB($queueID);

        if ($result == -1) {
            $result['result'] = -1;
            $result['no'] = 2;
            return $result;
        }

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
     * Recycle queue
     * @param  $queueID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    private function _recycleQueue($queueID)
    {
        //global $conn, $lang;
        $this->getQueueDbObj();
        $result = $this->_queueDbObj->recycleQueueDB($queueID);

        if ($result == -1) {
            $result['result'] = -1;
            $result['no'] = 2;
            return $result;
        }

        $result['result'] = 1;
        return $result;
    }

    /**
     * unTrash queue
     * @param  $queueID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    private function _unTrashQueue($queueID)
    {
        //global $conn, $lang;
        $this->getQueueDbObj();
        $result = $this->_queueDbObj->unTrashQueueDB($queueID);

        if ($result == -1) {
            $result['result'] = -1;
            $result['no'] = 2;
            return $result;
        }

        $result['result'] = 1;
        return $result;
    }

    /**
     * Gets the queue list
     * @param  $fields
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getQueueList($fields)
    {
        //global $conn, $lang;
        $this->getQueueDbObj();
        $result = $this->_queueDbObj->getQueue($fields);

        if ($result['result'] == -1) {
            return $result;
        }

        $this->_paging = $this->_queueDbObj->paging;
        $this->_queueList = $this->_queueDbObj->queueListDb;

        if ($result['result'] != 1) {
            return $result['msg'];
        }

        unset($this->_queueDbObj);
        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }

    /**
     * Gets the queue list
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getTrashList()
    {
        //global $conn, $lang;
        $this->getQueueDbObj();
        $result = $this->_queueDbObj->getTrash();

        if ($result['result'] == -1) {
            return $result;
        }

        $this->_queueList = $this->_queueDbObj->queueListDb;
        unset($this->_queueDbObj);
        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }

    /**
     * Add queue
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _insertQueue()
    {
        //global $conn, $lang;
        global $admin_info, $company_info;
        $this->getQueueDbObj();
        $result = $this->_queueDbObj->set_queueFields($this->_queueInfo);

        if ($result['result'] == -1) {
            return $result;
        }

        $resultInsert = $this->_queueDbObj->insertQueueDB();

        if ($resultInsert['result'] == -1) {
            return $resultInsert['msg'];
        }

        $result = $this->set_queueInfo($this->_queueDbObj->queueFields);
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
     * Updates queue
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _updateQueue()
    {
        //global $conn, $lang;
        $this->getQueueDbObj();
        $result = $this->_queueDbObj->set_queueFields($this->_queueInfo);

        if ($result['result'] == -1) {
            return $result;
        }

        $resultUpdate = $this->_queueDbObj->updateQueueDB();

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
     * Get all extension list
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getAllExtensionList()
    {
        //global $conn, $lang;
        include_once(ROOT_DIR . "component/extension.operation.class.php");
        $operation = new extension_operation();
        $result = $operation->getExtensionList();

        if ($result['result'] != 1) {
            return $result['msg'];

        }

        return $operation->extensionList;
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

        $this->getQueueDbObj();
        $result = $this->_queueDbObj->set_IDs($this->_IDs);

        if ($result['result'] == -1) {
            return $result;
        }

        $result = $this->_queueDbObj->changeStatusDB($value);

        if (!isset($result['result']) or $result['result'] == -1) {
            return $result;
        }

        return $result;
    }

    /**
     * Gets the queue list based on its ID
     * @param   $companyID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getQueueByCompany($companyID)
    {
        //global $conn, $lang;
        if (is_int($companyID)) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = ModelCOMPANY_16;
            $result['func'] = 'getAnnounceListById';
            return $result;
        }

        $this->getQueueDbObj();
        $where = "comp_id= '$companyID'";
        $result = $this->_queueDbObj->GetAll($where);
        $this->_queueList = $this->_queueDbObj->queueListDb;

        unset($this->_queueDbObj);
        return $result;
    }

    /**
     * Gets the queue list based on its ID
     * @param   $sipID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getQueueBySip($sipID)
    {
        //global $conn, $lang;
        if (is_int($sipID)) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = ModelCOMPANY_16;
            $result['func'] = 'getAnnounceListById';
            return $result;
        }

        $this->getQueueDbObj();
        $where = "dst_option_id= '1' AND dst_option_sub_id = '$sipID' AND trash = '0'";
        $result = $this->_queueDbObj->GetAll($where);
        $this->_queueList = $this->_queueDbObj->queueListDb;

        unset($this->_queueDbObj);
        return $result;
    }

    /**
     * Gets the queue list based on its ID
     * @param   $queueID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getQueueByIvr($queueID)
    {
        //global $conn, $lang;
        if (is_int($queueID)) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = ModelCOMPANY_16;
            $result['func'] = 'getAnnounceListById';
            return $result;
        }

        $this->getQueueDbObj();
        $where = "dst_option_id= '5' AND dst_option_sub_id = '$queueID' AND trash = '0'";
        $result = $this->_queueDbObj->GetAll($where);
        $this->_queueList = $this->_queueDbObj->queueListDb;
        unset($this->_queueDbObj);
        return $result;
    }

    /**
     * Checks the dependency before deleting
     * @return  mixed
     * @param  $queueID
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _checkAnnounceDependency($queueID)
    {
        //global $conn, $lang;
        include_once(ROOT_DIR . "component/announce.operation.class.php");
        $announce = new announce_operation();
        $result = $announce->getAnnounceByQueue($queueID);

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
     * @param  $queueID
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _checkInboundDependency($queueID)
    {
        //global $conn, $lang;
        include_once(ROOT_DIR . "component/inbound.operation.class.php");
        $announce = new inbound_operation();
        $result = $announce->getInboundByQueue($queueID);

        if ($result['result'] = 1) {
            $result['list'] = $announce->inboundList;
            return $result;
        }

        $result['result'] = -1;
        $result['no'] = 2;
        return $result;
    }

    /**
     * Checks the dependency before deleting
     * @return  mixed
     * @param  $queueID
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _checkIvrDependency($queueID)
    {
        //global $conn, $lang;
        include_once(ROOT_DIR . "component/ivr.operation.class.php");
        $ivr = new ivr_operation();
        $result = $ivr->getIvrByQueue($queueID);

        if ($result['result'] = 1) {
            $result['list'] = $ivr->ivrList;
            return $result;
        }

        $result['result'] = -1;
        $result['no'] = 2;
        return $result;
    }


    /**
     * Gets the queue list based on its ID
     * @param   $extensionID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getQueueByExtension($extensionID)
    {
        //global $conn, $lang;
        if (is_int($extensionID)) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = ModelCOMPANY_16;
            $result['func'] = 'getAnnounceListById';
            return $result;
        }

        $this->getQueueDbObj();
        $where = "dst_option_id= '3' AND dst_option_sub_id = '$extensionID' AND trash = '0'";
        $result = $this->_queueDbObj->GetAll($where);
        $this->_queueList = $this->_queueDbObj->queueListDb;
        unset($this->_queueDbObj);
        return $result;
    }

    /**
     * Gets the queue list based on its ID
     * @param   $announceID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getQueueByAnnounce($announceID)
    {
        //global $conn, $lang;
        if (is_int($announceID)) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = ModelCOMPANY_16;
            $result['func'] = 'getAnnounceListById';
            return $result;
        }

        $this->getQueueDbObj();
        $where = "dst_option_id= '4' AND dst_option_sub_id = '$announceID' AND trash = '0'";
        $result = $this->_queueDbObj->GetAll($where);
        $this->_queueList = $this->_queueDbObj->queueListDb;
        unset($this->_queueDbObj);
        return $result;
    }

    /**
     * Gets the queue list based on its ID
     * @param   $uploadID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getQueueByFile($uploadID)
    {

        //global $conn, $lang;
        if (is_int($uploadID)) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = ModelCOMPANY_16;
            $result['func'] = 'getAnnounceListById';
            return $result;
        }

        $this->getQueueDbObj();
        $where = "dst_option_id= '6' AND dst_option_sub_id = '$uploadID' AND trash = '0'";
        $result = $this->_queueDbObj->GetAll($where);
        $this->_queueList = $this->_queueDbObj->queueListDb;
        unset($this->_queueDbObj);
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
        $this->getQueueDbObj();
        $result = $this->_queueDbObj->checkIfNameExistsDB($name, $compID);

        if ($result == -1) {
            $result['result'] = -1;
            $result['no'] = 2;
            return $result;
        }

        $result['result'] = 1;
        $this->_queueDbObj = '';
        return $result;
    }
}

