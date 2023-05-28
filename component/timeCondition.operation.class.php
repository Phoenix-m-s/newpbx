<?php
include_once(ROOT_DIR . "component/Validators.class.php");

/**
 * @author Malekloo Izadi Sakhamanesh <Izadi@dabacenter.ir>
 * @version 0.0.1 this is the beta version of News
 * @copyright 2015 The Imen Daba Parsian Co.
 */
class timeCondition_operation
{

    /**
     * Contains sip info
     * @var
     */
    private $_ivrInfo;
    /**
     * Contains List of sip
     * @var
     */
    private $_ivrList;
    /**
     * @var
     */

    private $_paging;
    /**
     * Contains Company info
     * @var
     */

    public  $_set;
    /**
     * Accessing the database
     * @var
     */
    private $_ivrDbObj;
    /**
     * @var
     */
    private $_IDs;
    /**
     * @var
     */
    public  $addForm;
    /**
     * @var
     */
    public  $editForm;


    /**
     * Specifies the type of output
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function __construct(){


        //parent::__construct();
        $this->_ivrInfo = array();
        $this->addForm = array();
        $this->addForm = array(
            'Ivr_Name' => '',
            'Announcement' => '',
            'TimeOut' => '',
            'Direct_Dial' => '',
            'IVRExtension' => '',
            'DSTOption' => '',
            'dst_option_sub_id' => '',
            'Description' => ''
        );

        $this->editForm = array();
        $this->editForm = array(
            'Ivr_ID' => '',
            'Ivr_Name' => '',
            'Announcement' => '',
            'TimeOut' => '',
            'Direct_Dial' => '',
            'IVRExtension' => '',
            'DSTOption' => '',
            'dst_option_sub_id' => '',
            'Description' => ''
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

        switch($property)
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
                case "_set_ivrInfo" :
                    return $this->_set_ivrInfo($args['0']);
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
                case "_deleteIvr" :
                    return $this->_deleteIvr($args['0']);
                    break;
                case "_getIvrList" :
                    return $this->_getIvrList($args['0']);
                    break;
                case "_getDSTList" :
                    return $this->_getDSTList($args['0']);
                    break;
                case "_getIVRListById" :
                    return $this->_getIVRListById($args['0']);
                    break;
                case "_insertIvr" :
                    return $this->_insertIvr();
                    break;
                case "_insertDST" :
                    return $this->_insertDST($args['0']);
                    break;
                case "_updateIvr" :
                    return $this->_updateIvr();
                    break;
                case "_updateDST" :
                    return $this->_updateDST($args['0']);
                    break;
                case "_changeStatus" :
                    return $this->_changeStatus($args['0']);
                    break;
                case "_trashIvr" :
                    return $this->_trashIvr($args['0']);
                    break;
                case "_recycleIvr" :
                    return $this->_recycleIvr($args['0']);
                    break;
                case "_getIVRByCompany" :
                    return $this->_getIVRByCompany($args['0']);
                    break;
                case "_checkAnnounceDependency" :
                    return $this->_checkAnnounceDependency($args['0']);
                    break;
                case "_getIvrBySip" :
                    return $this->_getIvrBySip($args['0']);
                    break;
                case "_checkQueueDependency" :
                    return $this->_checkQueueDependency($args['0']);
                    break;
                case "_checkInboundDependency" :
                    return $this->_checkInboundDependency($args['0']);
                    break;
                case "_getIvrByQueue" :
                    return $this->_getIvrByQueue($args['0']);
                    break;
                case "_getIvrByAnnounce" :
                    return $this->_getIvrByAnnounce($args['0']);
                    break;
                case "_getIvrByExtension" :
                    return $this->_getIvrByExtension($args['0']);
                    break;
                case "_getIvrByFile" :
                    return $this->_getIvrByFile($args['0']);
                    break;
                case "_checkIvrDependency" :
                    return $this->_checkIvrDependency($args['0']);
                    break;
                case "_checkIfNameExists" :
                    return $this->_checkIfNameExists($args['0'],$args['1']);
                    break;
            endswitch;
        }
    die();
    }





    /**
     * Specifies the value of each field.
     * Setter can act in 2 ways.
     * 1)It gets all the input at once
     * 2)It gets the fields one by one
     * We have used the 2nd method.
     * @param $field
     * @return  mixed
     * @author  Malekloo,Izadi,Sakhamanesh
     * @version 01.01.01
     * @since 01.01.01
     * @date    08/08/2015
     *
     */
    private function _set_ivrInfo($field='')
    {
        $result['result'] = 1;
        global $admin_info,$company_info;

        /**
         * Checks if the value of announce_id is not empty and is integer.
         */
        if (isset($field['comp_id']))
        {

            if (empty($field['comp_id']))
            {
                $msg='Please enter  comp_id';

                if($result['result']==1)
                {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['comp_id'] =  $msg;
            }
            elseif(!Validator::Numeric($field['comp_id']))
            {
                $msg='ID should only contain numbers.';

                if($result['result']==1)
                {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['id'] =  $msg;
            }
            else
            {
                $this->_ivrInfo['comp_id'] = $field['comp_id'];
            }

        }

        else
        {
            $this->_ivrInfo['comp_id'] = $company_info['comp_id'] ;
        }

        /**
         * Checks if the value of email is not empty and is integer.
         */
        if (isset($field['Direct_Dial']))
        {
            if ($field['Direct_Dial'] == 'on')
            {
                $this->_ivrInfo['Direct_Dial'] = 1;
            }
            else
            {
                $this->_ivrInfo['Direct_Dial'] = 0;
            }

        }

        /**
         * Checks if the value of announce_id is not empty and is integer.
         */
        if (isset($field['Ivr_ID']))
        {

            if (empty($field['Ivr_ID']))
            {
                $msg='Please enter  Ivr_ID';

                if($result['result']==1)
                {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['Ivr_ID'] =  $msg;
            }

            else
            {
                $this->_ivrInfo['Ivr_ID'] = $field['Ivr_ID'];
            }

        }
        /**
         * Checks if the value of announce_id is not empty and is integer.
         */
        if (isset($field['Ivr_Name']))
        {

            if (empty($field['Ivr_Name']))
            {
                $msg='Please enter  Ivr_Name';

                if($result['result']==1)
                {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['Ivr_Name'] =  $msg;
            }

            else
            {
                $this->_ivrInfo['Ivr_Name'] = $field['Ivr_Name'];
            }

        }



        /**
         * Checks if the value of announce_id is not empty and is integer.
         */
        if (isset($field['Announcement']))
        {

            if (empty($field['Announcement']))
            {
                $msg='Please enter  Announcement';

                if($result['result']==1)
                {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['upload_id'] =  $msg;
            }
            elseif(!Validator::Numeric($field['Announcement']))
            {
                $msg='ID should only contain numbers.';

                if($result['result']==1)
                {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['id'] =  $msg;
            }
            else
            {
                $this->_ivrInfo['Announcement'] = $field['Announcement'];
            }

        }

        /**
         * Checks if the value of announce_id is not empty and is integer.
         */
        if ($field['Invalid'] == 'on')
        {

            $this->_ivrInfo['Invalid'] = 1;
        }
        else
        {
            $this->_ivrInfo['Invalid'] = 0;
        }

        /**
         * Checks if the value of announce_name is not empty and is string.
         */
        if (isset($field['TimeOut']))
        {
            if (empty($field['TimeOut']))
            {
                $msg='Please enter TimeOut';

                if($result['result']==1)
                {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['TimeOut'] =  $msg;
            }
            elseif(!Validator::Numeric($field['TimeOut']))
            {
                $msg='TimeOut should only contain numbers.';

                if($result['result']==1)
                {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['TimeOut'] =  $msg;
            }
            else
            {
                $this->_ivrInfo['TimeOut'] = $field['TimeOut'];
            }

        }

        /**
         * Checks if the value of announce_name is not empty and is string.
         */
        if (isset($field['DSTOption']))
        {
            foreach($field['DSTOption'] as $key=>$value)
            {
                $this->_ivrInfo['DST'][$key]['DSTOption'] = $value;
            }

        }
        /**
         * Checks if the value of announce_name is not empty and is string.
         */
        if (isset($field['dst_option_sub_id']))
        {
            foreach($field['dst_option_sub_id'] as $key=>$value)
            {
                $this->_ivrInfo['DST'][$key]['dst_option_sub_id'] = $value;
            }

        }

        /**
         * Checks if the value of announce_name is not empty and is string.
         */
        if (isset($field['IVRExtension']))
        {
            foreach($field['IVRExtension'] as $key=>$value)
            {
                $this->_ivrInfo['DST'][$key]['IVRExtension'] = $value;
            }

        }

        /**
         * Checks if the value of announce_name is not empty and is string.
         */
        if (isset($field['Description']))
        {
            foreach($field['Description'] as $key=>$value)
            {
                $this->_ivrInfo['DST'][$key]['Description'] = $value;
            }

        }

        return  $result;

    }


    /**
     * Specifies the type of output
     * @param   $value
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
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
                    $res['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;
                $result['msgList'][$key] =  $msg;
            }
        }
        return  $result;

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

        switch($field)
        {
            case 'paging':
                return $this->_paging;
                break;
            case 'ivrList':
                return $this->_ivrList;
                break;
            case 'ivrInfo':
                return $this->_ivrInfo;
                break;
            default:
                break;
        }

    die();
    }


    /**
     * Gets the IVR List
     * @param $fields
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getIvrList($fields)
    {
        //global $conn, $lang;
        $this->getIvrDbObj();
        $result=$this->_ivrDbObj->getIvr($fields);

        if($result['result']!=1)
        {
            return $result;
        }

        $this->_paging=$this->_ivrDbObj->paging;
        $this->_ivrList = $this->_ivrDbObj->ivrListDb;
        unset($this->_ivrDbObj);
        $result['result'] = 1;
        $result['no'] = 2;
        return  $result;
    }

    /**
     * Gets the DST list
     * @return  mixed
     * @param  $ivrID
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getDSTList($ivrID)
    {
        //global $conn, $lang;

        if (is_int($ivrID))
        {
            $result['result']=-1;
            $result['no']=1;
            $result['msg']='Wrong ID';
            $result['func']='getIVRListById';
            return $result;
        }

        $this->getIvrDbObj();
        $result=$this->_ivrDbObj->getDST($ivrID);

        if($result['result']!=1)
        {
            return $result;
        }

        $this->_ivrList = $this->_ivrDbObj->ivrListDb;
        unset($this->_ivrDbObj);
        $result['result'] = 1;
        $result['no'] = 2;
        return  $result;
    }

    /**
     * Gets the IVR list based on its ID
     * @param   $ivrID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getIVRListById($ivrID)
    {
        //global $conn, $lang;
        if (is_int($ivrID))
        {
            $result['result']=-1;
            $result['no']=1;
            $result['msg']='Wrong ID';
            $result['func']='getIVRListById';
            return $result;
        }

        $this->getIvrDbObj();

        $result=$this->_ivrDbObj->getIvrById($ivrID);

        if ($result['result']==-1)
        {
            return $result;
        }

        $this->_ivrInfo = $this->_ivrDbObj->ivrFields;
        $this->_ivrDbObj = '';
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
    private function getIvrDbObj()
    {
        include_once(ROOT_DIR . "component/timeCondition.db.class.php");
        $this->_ivrDbObj = new ivr_db();
    }

    /**
     * Inserts IVR
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _insertIvr()
    {
        //global $conn, $lang;
        global $admin_info,$company_info;

        $this->getIvrDbObj();
        $result=$this->_ivrDbObj->set_ivrFields($this->_ivrInfo);

        if($result['result']==-1)
        {
            return $result;
        }

        $resultInsert=$this->_ivrDbObj->insertIvrDB();

        if($resultInsert['result']==-1)
        {
            return $resultInsert['msg'];
        }

        $result=$this->set_ivrInfo($this->_ivrDbObj->ivrFields);
        $result['result'] = 1;
        $result['no'] = 2;

        include_once(ROOT_DIR . "component/package.db.class.php");

      /*  $packageLogResult = package_db::calculateExtension('+',$company_info['comp_id'] );

        if($packageLogResult == -1)
        {
            $packageLogResult['result'] = -1;
            $packageLogResult['no'] = 2;
            return $packageLogResult;
        }*/

        include_once(ROOT_DIR . "component/company.db.class.php");
        $companyResult = company_db::updateReload();

        if($companyResult == -1)
        {
            $companyResult['result'] = -1;
            $companyResult['no'] = 2;
            return $companyResult;
        }

        return $result;
    }

    /**
     * Inserts DST
     * @return  mixed
     * @param  $IvrID
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _insertDST($IvrID)
    {
       // global $conn, $lang;
        $this->getIvrDbObj();

        $result=$this->_ivrDbObj->set_ivrFields($this->_ivrInfo);

        if($result['result']==-1)
        {
            return $result;
        }

        $resultInsert=$this->_ivrDbObj->insertDSTDB($IvrID);

        if($resultInsert['result']==-1)
        {
            return $resultInsert['msg'];
        }

        $result=$this->set_ivrInfo($this->_ivrDbObj->ivrFields);
        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }

    /**
     * Updates IVR
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _updateIvr()
    {
        //global $conn, $lang;
        $this->getIvrDbObj();
        $result=$this->_ivrDbObj->set_ivrFields($this->_ivrInfo);

        if($result['result']==-1)
        {
            return $result;
        }
        $resultUpdate=$this->_ivrDbObj->updateIvrDB();

        if($resultUpdate['result']==-1)
        {
            return $resultUpdate['msg'];
        }

        include_once(ROOT_DIR . "component/company.db.class.php");
        $companyResult = company_db::updateReload();

        if($companyResult == -1)
        {
            $companyResult['result'] = -1;
            $companyResult['no'] = 2;
            return $companyResult;
        }

        $result['no'] = 2;
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
    private function _updateDST($IvrID)
    {

        //global $conn, $lang;
        $this->getIvrDbObj();
        $result=$this->_ivrDbObj->set_ivrFields($this->_ivrInfo);

        if($result['result']==-1)
        {
            return $result;
        }

        $resultUpdate=$this->_ivrDbObj->updateDSTDB($IvrID);

        if($resultUpdate['result']==-1)
        {
            return $resultUpdate['msg'];
        }

        $result['no'] = 2;
        return $result;
    }


    /**
     * Change the status
     * @param  $value
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _changeStatus($value='')
    {
        if($value=='Disable')
        {
            $value = '0';
        }
        else if($value=='Enable')
        {
            $value = '1';
        }
        $this->getIvrDbObj();
        $result=$this->_ivrDbObj->set_IDs($this->_IDs);

        if($result['result']==-1)
        {
            return $result;
        }

        $result=$this->_ivrDbObj->changeStatusDB($value);

        if(!isset($result['result']) or $result['result']==-1)
        {
            return $result;
        }

        return $result;
    }

    /**
     * Deletes IVR
     * @param  $ivrID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    private function _deleteIvr_temp($ivrID){
        //global $conn, $lang;
        $this->getIvrDbObj();
        $result = $this->_ivrDbObj->removeIvrDB($ivrID);

        if($result == -1)
        {
            $result['result'] = -1;
            $result['no'] = 2;
            return $result;
        }

        $result = $this->_ivrDbObj->removeIvrDSTDB($ivrID);

        if($result == -1)
        {
            $result['result'] = -1;
            $result['no'] = 2;
            return $result;
        }

        unset($this->_ivrDbObj);

        $result['result'] = 1;
        return $result;
    }

    /**
     * Trashes IVR
     * @param  $ivrID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    private function _deleteIvr($ivrID){
        //global $conn, $lang;
        global $admin_info,$company_info;

        $this->getIvrDbObj();
        $result = $this->_ivrDbObj->removeIvrDB($ivrID);

        if($result == -1)
        {
            $result['result'] = -1;
            $result['no'] = 2;
            return $result;
        }

        $result = $this->_ivrDbObj->removeIvrDSTDB($ivrID);

        if($result == -1)
        {
            $result['result'] = -1;
            $result['no'] = 2;
            return $result;
        }

        $result['result'] = 1;

        include_once(ROOT_DIR . "component/package.db.class.php");

      /*  $packageLogResult = package_db::calculateExtension('-',$company_info['comp_id'] );


        if($packageLogResult == -1)
        {
            $packageLogResult['result'] = -1;
            $packageLogResult['no'] = 2;
            return $packageLogResult;
        }*/

        include_once(ROOT_DIR . "component/company.db.class.php");
        $companyResult = company_db::updateReload();

        if($companyResult == -1)
        {
            $companyResult['result'] = -1;
            $companyResult['no'] = 2;
            return $companyResult;
        }

        return $result;
    }

    /**
     * Recycles IVR
     * @param  $ivrID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    private function _recycleIvr($ivrID){
        //global $conn, $lang;
        $this->getIvrDbObj();
        $result = $this->_ivrDbObj->recycleIvrDB($ivrID);

        if($result == -1)
        {
            $result['result'] = -1;
            $result['no'] = 2;
            return $result;
        }

        $result['result'] = 1;
        return $result;
    }

    /**
     * Gets IVR by Company
     * @param   $companyID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getIVRByCompany($companyID)
    {
        //global $conn, $lang;
        if (is_int($companyID))
        {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = 'Wrong ID';
            $result['func'] = 'getAnnounceListById';
            return $result;
        }

        $this->getIvrDbObj();
        $where = "comp_id= '$companyID' AND trash = '0'";
        $result = $this->_ivrDbObj->GetAll($where);
        $this->_ivrList = $this->_ivrDbObj->ivrListDb;
        unset($this->_ivrDbObj);
        return $result;
    }

    /**
     * Checks the dependency of announce and file before deleting the announce.
     * @return  mixed
     * @param  $ivrID
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _checkAnnounceDependency($ivrID)
    {
        //global $conn, $lang;
        include_once(ROOT_DIR . "component/announce.operation.class.php");
        $Announce = new announce_operation();
        $result = $Announce->getAnnounceByIvr($ivrID);

        if($result['result'] = 1)
        {
            $result['list'] = $Announce->announceList;
            return $result;
        }

        $result['result'] = -1;
        $result['no'] = 2;
        return  $result;
    }

    /**
     * Checks the dependency of announce and file before deleting the announce.
     * @return  mixed
     * @param  $ivrID
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _checkQueueDependency($ivrID)
    {
        //global $conn, $lang;
        include_once(ROOT_DIR . "component/queue.operation.class.php");
        $Queue = new queue_operation();
        $result = $Queue->getQueueByIvr($ivrID);

        if($result['result'] = 1)
        {
            $result['list'] = $Queue->queueList;
            return $result;
        }

        $result['result'] = -1;
        $result['no'] = 2;
        return  $result;
    }

    /**
     * Checks the dependency of announce and file before deleting the announce.
     * @return  mixed
     * @param  $ivrID
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _checkInboundDependency($ivrID)
    {
        //global $conn, $lang;
        include_once(ROOT_DIR . "component/inbound.operation.class.php");
        $Queue = new inbound_operation();
        $result = $Queue->getInboundByIvr($ivrID);

        if($result['result'] = 1)
        {
            $result['list'] = $Queue->inboundList;
            return $result;
        }

        $result['result'] = -1;
        $result['no'] = 2;
        return  $result;
    }

    /**
     * Gets the Extension list based on its ID
     * @param   $sipID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getIvrBySip($sipID)
    {
        //global $conn, $lang;
        if (is_int($sipID))
        {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = 'Wrong ID';
            $result['func'] = 'getIvrBySip';
            return $result;
        }

        $this->getIvrDbObj();
        $where="dst_option_id= '1' AND dst_option_sub_id = '$sipID' AND trash = '0'";
        $result = $this->_ivrDbObj->GetAllDST($where);
        $this->_ivrList = $this->_ivrDbObj->ivrListDb;
        unset($this->_inboundDbObj);
        return $result;
    }


    /**
     * Gets the Extension list based on its ID
     * @param   $queueID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getIvrByQueue($queueID)
    {
        //global $conn, $lang;
        if (is_int($queueID))
        {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = 'Wrong ID';
            $result['func'] = 'getIvrByQueue';
            return $result;
        }

        $this->getIvrDbObj();
        $where="dst_option_id= '2' AND dst_option_sub_id = '$queueID' AND trash = '0'";
        $result = $this->_ivrDbObj->GetAllDST($where);
        $this->_ivrList = $this->_ivrDbObj->ivrListDb;
        unset($this->_inboundDbObj);
        return $result;
    }

    /**
     * Gets the Extension list based on its ID
     * @param   $announceID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getIvrByAnnounce($announceID)
    {
        //global $conn, $lang;
        if (is_int($announceID))
        {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = 'Wrong ID';
            $result['func'] = 'getIvrByQueue';
            return $result;
        }

        $this->getIvrDbObj();
        $where="dst_option_id= '4' AND dst_option_sub_id = '$announceID' AND trash = '0'";
        $result = $this->_ivrDbObj->GetAllDST($where);
        $this->_ivrList = $this->_ivrDbObj->ivrListDb;
        return $result;
    }

    /**
     * Gets the Extension list based on its ID
     * @param   $extensionID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getIvrByExtension($extensionID)
    {
        //global $conn, $lang;
        if (is_int($extensionID))
        {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = 'Wrong ID';
            $result['func'] = 'getIvrByQueue';
            return $result;
        }

        $this->getIvrDbObj();
        $where="dst_option_id= '3' AND dst_option_sub_id = '$extensionID' AND trash = '0'";
        $result = $this->_ivrDbObj->GetAllDST($where);
        $this->_ivrList = $this->_ivrDbObj->ivrListDb;
        unset($this->_ivrDbObj);
        return $result;
    }

    /**
     * Gets the Extension list based on its ID
     * @param   $uploadID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getIvrByFile($uploadID)
    {
        //global $conn, $lang;
        if (is_int($uploadID))
        {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = 'Wrong ID';
            $result['func'] = 'getIvrByQueue';
            return $result;
        }

        $this->getIvrDbObj();
        $where="upload_id = '$uploadID' AND trash = '0'";
        $result = $this->_ivrDbObj->GetAll($where);
        $this->_ivrList = $this->_ivrDbObj->ivrListDb;
        unset($this->_ivrDbObj);
        return $result;
    }

    /**
     * Gets the IVR list based on the ID of the IVR being trashed
     * @param   $ivrID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _checkIvrDependency($ivrID)
    {
        //global $conn, $lang;
        if (is_int($ivrID))
        {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = 'Wrong ID';
            $result['func'] = 'getIvrByQueue';
            return $result;
        }

        $this->getIvrDbObj();
        $where="dst_option_id= '5' AND dst_option_sub_id = '$ivrID' AND trash = '0'";
        $result = $this->_ivrDbObj->GetAllDST($where);
        $this->_ivrList = $this->_ivrDbObj->ivrListDb;
        $result['list'] =  $this->_ivrList;
        unset($this->_ivrDbObj);
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
    private function _checkIfNameExists($name,$compID)
    {
        //global $conn, $lang;
        $this->getIvrDbObj();
        $result = $this->_ivrDbObj->checkIfNameExistsDB($name,$compID);

        if($result == -1)
        {
            $result['result'] = -1;
            $result['no'] = 2;
            return $result;
        }

        $result['result'] = 1;
        return $result;
    }
}

