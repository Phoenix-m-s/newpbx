<?php
include_once(ROOT_DIR . "component/Validators.class.php");

/**
 * @author Malekloo Izadi Sakhamanesh <Izadi@dabacenter.ir>
 * @version 0.0.1 this is the beta version of groupPackages
 * @copyright 2015 The Imen Daba Parsian Co.
 */
class admin_Package_operation
{
    /**
     * Contains group info
     * @var
     */
    private $_PackageInfo;
    /**
     * Contains List of group
     * @var
     */
    private $_PackageList;
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
    private $_packageDbObj;
    /**
     * @var
     */
    private $_IDs;
    /**
     * @var
     */
    public  $addForm;


    /**
     * Specifies the type of output
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    public function __construct()
    {
        $this->_PackageInfo = array();
        $this->addForm = array();
        $this->addForm = array(
            'package_name' => '',
            'price' => '',
            'extension_count' => '',
            'duration' => '',
            'group_id' => ''
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
                case "_set_groupPackagesInfo" :
                    return $this->_set_groupPackagesInfo($args['0']);
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
                case "_deleteGroupPackage" :
                    return $this->_deleteGroupPackage($args['0']);
                    break;
                case "_deletePackage" :
                    return $this->_deletePackage($args['0']);
                    break;
                case "_getGroupPackageList" :
                    return $this->_getGroupPackageList($args['0']);
                    break;
                case "_getPackageList" :
                    return $this->_getPackageList($args['0']);
                    break;
                case "_getGroupPackageListById" :
                    return $this->_getGroupPackageListById($args['0']);
                    break;
                case "_getPackageListById" :
                    return $this->_getPackageListById($args['0']);
                    break;
                case "_insertGroupPackages" :
                    return $this->_insertGroupPackages();
                    break;
                case "_insertPackages" :
                    return $this->_insertPackages();
                    break;
                case "_insertPackageToGroup" :
                    return $this->_insertPackageToGroup();
                    break;
                case "_insertPackagesToCompany" :
                    return $this->_insertPackagesToCompany();
                    break;
                case "_insertGroupPackagesToCompany" :
                    return $this->_insertGroupPackagesToCompany();
                    break;
                case "_removeGroupPackagesFromCompany" :
                    return $this->_removeGroupPackagesFromCompany();
                    break;
                case "_updateGroupPackages" :
                    return $this->_updateGroupPackages();
                    break;
                case "_updatePackages" :
                    return $this->_updatePackages();
                    break;
                case "_changeStatus" :
                    return $this->_changeStatus($args['0']);
                    break;
                case "_changePackageStatus" :
                    return $this->_changePackageStatus($args['0']);
                    break;
                case "_calculatePackage" :
                    return $this->_calculatePackage();
                    break;
                case "_checkIfNameExists" :
                    return $this->_checkIfNameExists($args['0'],$args['1']);
                    break;
                case "_checkIfGroupNameExists" :
                    return $this->_checkIfGroupNameExists($args['0'],$args['1']);
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
    private function _set_groupPackagesInfo($value='')
    {

        $result['result'] = 1;
        global $admin_info,$company_info;

        /**
         * Checks if the value of announce_id is not empty and is integer.
         */
        if (isset($value['comp_id']))
        {

            if (empty($value['comp_id']))
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
            elseif(!Validator::Numeric($value['comp_id']))
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
                $this->_PackageInfo['comp_id'] = $value['comp_id'];
            }

        }

        else
        {
            $this->_PackageInfo['comp_id'] = $company_info['comp_id'] ;
        }
        /**
         * Checks if the value of package_group_name is not empty and is string.
         */
        if (isset($value['package_group_name']))
        {
            if (empty($value['package_group_name']))
            {
                $msg='Please enter group Package name';

                if($result['result']==1)
                {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['package_group_name'] =  $msg;
            }
            elseif(!is_string($value['package_group_name']))
            {
                $msg='Group Package name should only contain characters.';

                if($result['result']==1)
                {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['package_group_name'] =  $msg;
            }
            else
            {
                $this->_PackageInfo['package_group_name'] = $value['package_group_name'];
            }

        }

        /**
         * Checks if the value of package_group_name is not empty and is string.
         */
        if (isset($value['package_id']))
        {
            if (empty($value['package_id']))
            {
                $msg='Please enter group package_id ';

                if($result['result']==1)
                {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['package_id'] =  $msg;
            }
            elseif(!is_numeric($value['package_id']))
            {
                $msg='Group Package name should only contain numbers.';

                if($result['result']==1)
                {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['package_id'] =  $msg;
            }
            else
            {
                $this->_PackageInfo['package_id'] = $value['package_id'];
            }

        }

        /**
         * Checks if the value of package_group_name is not empty and is string.
         */
        if (isset($value['assign_package_now']))
        {
            if (empty($value['assign_package_now']))
            {
                $msg='Please enter assign_package_now';

                if($result['result']==1)
                {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['package_id'] =  $msg;
            }
            elseif($value['assign_package_now'] == 'on')
            {
                $this->_PackageInfo['assign_package_now'] = '1';
            }
            else
            {
                $this->_PackageInfo['assign_package_now'] = '0';
            }

        }

        /**
         * Checks if the value of package_group_name is not empty and is string.
         */
        if (isset($value['package_name']))
        {
            if (empty($value['package_name']))
            {
                $msg='Please enter package_name ';

                if($result['result']==1)
                {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['package_name'] =  $msg;
            }
            elseif(!is_string($value['package_name']))
            {
                $msg='Package name should only contain characters.';

                if($result['result']==1)
                {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['package_name'] =  $msg;
            }
            else
            {
                $this->_PackageInfo['package_name'] = $value['package_name'];
            }

        }
        /**
         * Checks if the value of package_group_id is not empty and is integer.
         */
        if (isset($value['package_group_id']))
        {

            if (empty($value['package_group_id']))
            {
                $msg='Please enter package_group_id';

                if($result['result']==1)
                {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['id'] =  $msg;
            }
            elseif(!Validator::Numeric($value['package_group_id']))
            {
                $msg='package_group_id should only contain numbers.';

                if($result['result']==1)
                {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['package_group_id'] =  $msg;
            }
            else
            {
                $this->_PackageInfo['package_group_id'] = $value['package_group_id'];
            }

        }

        /**
         * Checks if the value of package_group_id is not empty and is integer.
         */
        if (isset($value['package_id']))
        {

            if (empty($value['package_id']))
            {
                $msg='Please enter package_id';

                if($result['result']==1)
                {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['id'] =  $msg;
            }
            elseif(!Validator::Numeric($value['package_id']))
            {
                $msg='package_id should only contain numbers.';

                if($result['result']==1)
                {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['package_id'] =  $msg;
            }
            else
            {
                $this->_PackageInfo['package_id'] = $value['package_id'];
            }

        }

        /**
         * Checks if the value of package_group_id is not empty and is integer.
         */
        if (isset($value['group_id']))
        {

            if (empty($value['group_id']))
            {
                $msg='Please enter group_id';

                if($result['result']==1)
                {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['id'] =  $msg;
            }
            elseif(!Validator::Numeric($value['group_id']))
            {
                $msg='package_group_id should only contain numbers.';

                if($result['result']==1)
                {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['group_id'] =  $msg;
            }
            else
            {
                $this->_PackageInfo['group_id'] = $value['group_id'];
            }

        }

        /**
         * Checks if the value of package_group_id is not empty and is integer.
         */
        if (isset($value['extension_count']))
        {

            if (empty($value['extension_count']))
            {
                $msg='Please enter extension_count';

                if($result['result']==1)
                {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['id'] =  $msg;
            }
            elseif(!Validator::Numeric($value['extension_count']))
            {
                $msg='extension_count should only contain numbers.';

                if($result['result']==1)
                {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['extension_count'] =  $msg;
            }
            else
            {
                $this->_PackageInfo['extension_count'] = $value['extension_count'];
            }

        }

        /**
         * Checks if the value of package_group_id is not empty and is integer.
         */
        if (isset($value['price']))
        {

            if (empty($value['price']))
            {
                $msg='Please enter price';

                if($result['result']==1)
                {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['id'] =  $msg;
            }
            elseif(!Validator::Numeric($value['price']))
            {
                $msg='extension_count should only contain numbers.';

                if($result['result']==1)
                {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['price'] =  $msg;
            }
            else
            {
                $this->_PackageInfo['price'] = $value['price'];
            }

        }

        /**
         * Checks if the value of package_group_name is not empty and is string.
         */
        if (isset($value['comment']))
        {
           /* if (empty($value['comment']))
            {
                $msg='Please enter comment';

                if($result['result']==1)
                {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['comment'] =  $msg;
            }
            else*/if(!is_string($value['comment']))
            {
                $msg='comment should only contain characters.';

                if($result['result']==1)
                {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['comment'] =  $msg;
            }
            else
            {
                $this->_PackageInfo['comment'] = $value['comment'];
            }

        }

        /**
         * Checks if the value of package_group_id is not empty and is integer.
         */
        if (isset($value['duration']))
        {

            if (empty($value['duration']))
            {
                $msg='Please enter duration';

                if($result['result']==1)
                {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['id'] =  $msg;
            }
            elseif(!is_string($value['duration']))
            {
                $msg='duration should only contain characters.';

                if($result['result']==1)
                {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['price'] =  $msg;
            }
            else
            {
                $this->_PackageInfo['duration'] = $value['duration'];
            }

        }
        return  $result;

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
     * @since   01.01.01
     * @date    08/08/2015
     */
    public function __get($field)
    {

        switch($field)
        {
            case 'paging':
                return $this->_paging;
                break;
            case 'PackageList':
                return $this->_PackageList;
                break;
            case 'PackageInfo':
                return $this->_PackageInfo;
                break;
            default:
                break;
        }


    }

    /**
     * Gets the Group Package based on its ID
     * @param   $GroupPackageID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    private function _getGroupPackageListById($GroupPackageID)
    {

        global $conn, $lang;

        if (is_int($GroupPackageID))
        {
            $result['result']=-1;
            $result['no']=1;
            $result['msg']='Wrong ID';
            $result['func']='_getGroupPackageListById';
            return $result;
        }

        $this->getGroupPackagesDbObj();
        $result=$this->_packageDbObj->getGroupPackageById($GroupPackageID);

        if ($result['result']==-1)
        {
            return $result;
        }


        $this->_PackageInfo= $this->_packageDbObj->PackageFields;

        $this->_packageDbObj = '';
        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }
    /**
     * Gets the Package List based on its ID
     * @param   $PackageID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    private function _getPackageListById($PackageID)
    {

        global $conn, $lang;

        if (is_int($PackageID))
        {
            $result['result']=-1;
            $result['no']=1;
            $result['msg']='Wrong ID';
            $result['func']='_getGroupPackageListById';
            return $result;
        }

        $this->getGroupPackagesDbObj();
        $result=$this->_packageDbObj->getPackageById($PackageID);

        if ($result['result']==-1)
        {
            return $result;
        }


        $this->_PackageInfo= $this->_packageDbObj->PackageFields;

        $this->_packageDbObj = '';
        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }

    /**
     * Access the database class
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    private function getGroupPackagesDbObj()
    {
        include_once(ROOT_DIR . "component/admin.package.db.class.php");
        $this->_packageDbObj = new admin_Package_db();
    }

    /**
     * Deletes group Packages
     * @return  mixed
     * @param mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    private function _deleteGroupPackage($GroupPackageID)
    {
        global $conn, $lang;
        $this->getGroupPackagesDbObj();

        $result = $this->_packageDbObj->removeGroupPackagesDB($GroupPackageID);

        $this->_packageDbObj = '';
        if($result==-1){
            $result['result'] = -1;
            $result['no'] = 2;
            return $result;
        }
        $result['result'] = 1;
        return $result;
    }


    /**
     * Deletes group Packages
     * @return  mixed
     * @param mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    private function _deletePackage($PackageID)
    {
        global $conn, $lang;
        $this->getGroupPackagesDbObj();

        $result = $this->_packageDbObj->removePackagesDB($PackageID);

        $this->_packageDbObj = '';
        if($result==-1){
            $result['result'] = -1;
            $result['no'] = 2;
            return $result;
        }
        $result['result'] = 1;
        return $result;
    }

    /**
     * Gets the group Package list
     * @param  $fields
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    private function _getGroupPackageList($fields)
    {
        global $conn, $lang;
        $this->getGroupPackagesDbObj();
        $result = $this->_packageDbObj->getGroupPackages($fields);

        if($result['result']!=1)
        {
            return $result;
        }

        $this->_paging  = $this->_packageDbObj->paging;
        $this->_PackageList = $this->_packageDbObj->PackageListDb;
        $this->_packageDbObj = '';
        $result['result'] = 1;
        $result['no'] = 2;
        return  $result;
    }

    /**
     * Get Package List
     * @param  $fields
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    private function _getPackageList($fields)
    {

        global $conn, $lang;

        $this->getGroupPackagesDbObj();
        $result = $this->_packageDbObj->getPackages($fields);

        if($result['result']!=1)
        {
            return $result;
        }

        $this->_paging  = $this->_packageDbObj->paging;
        $this->_PackageList = $this->_packageDbObj->PackageListDb;
        $this->_packageDbObj = '';
        $result['result'] = 1;
        $result['no'] = 2;
        return  $result;

    }

    /**
     * Insert Group Packages
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    private function _insertGroupPackages()
    {
        global $conn, $lang;
        $this->getGroupPackagesDbObj();
        $result=$this->_packageDbObj->set_groupPackageFields($this->_PackageInfo);

        if($result['result']==-1)
        {
            return $result;
        }

        $resultInsert=$this->_packageDbObj->insertGroupPackagesDB();

        if($resultInsert['result']==-1)
        {
            return $resultInsert['msg'];
        }

        $result=$this->set_groupPackagesInfo($this->_packageDbObj->groupPakegsFields);
        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }


    /**
     * Insert Packages
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    private function _insertPackages()
    {
        global $conn, $lang;
        $this->getGroupPackagesDbObj();
        $result=$this->_packageDbObj->set_groupPackageFields($this->_PackageInfo);

        if($result['result']==-1)
        {
            return $result;
        }

        $resultInsert=$this->_packageDbObj->insertPackagesDB();

        if($resultInsert['result']==-1)
        {
            return $resultInsert['msg'];
        }

        $result=$this->set_groupPackagesInfo($this->_packageDbObj->PackageFields);
        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }

    /**
     * Insert Package To Group
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    private function _insertPackageToGroup()
    {
        global $conn, $lang;

        $this->getGroupPackagesDbObj();
        $result=$this->_packageDbObj->set_groupPackageFields($this->_PackageInfo);

        if($result['result']==-1)
        {
            return $result;
        }

        $resultInsert=$this->_packageDbObj->insertPackageToGroupDB();

        if($resultInsert['result']==-1)
        {
            return $resultInsert['msg'];
        }

        $result=$this->set_groupPackagesInfo($this->_packageDbObj->PackageFields);
        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }

    /**
     * Insert Packages To Company
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    private function _insertPackagesToCompany()
    {
        global $conn, $lang;

        $this->getGroupPackagesDbObj();

        $result = $this->_packageDbObj->set_groupPackageFields($this->_PackageInfo);

        if($result['result']==-1)
        {
            return $result;
        }

        $result = $this->_packageDbObj->checkIfPackageExists();

        if($result['rowCount'] >= 1)
        {

            if($this->_packageDbObj->PackageFields['assign_package_now'] == '1')
            {
                include_once(ROOT_DIR . "component/packageLog.operation.class.php");
                $packageLog = new packageLog_operation();
                $packageLog = $packageLog->updateExpiryDateForLastPackage($this->_packageDbObj->PackageFields['comp_id']);

               /* if ($packageLog['result'] == -1)
                {
                    return $packageLog['msg'];
                }*/

                $resultLog = $this->_packageDbObj->logPackageToCompanyNowDB();

                if($resultLog['result']==-1)
                {
                    return $resultLog['msg'];
                }

                $resultUpdate = $this->_packageDbObj->updatePackageToCompanyDB();

                if($resultUpdate['result']==-1)
                {
                    return $resultUpdate['msg'];
                }
            }

            else
            {
                include_once(ROOT_DIR . "component/packageLog.operation.class.php");
                $packageLog = new packageLog_operation();
                $packageLogResult = $packageLog->getExpiryDateForLastPackage($this->_packageDbObj->PackageFields['comp_id']);

               /* if ($packageLogResult['result'] == -1)
                {
                    return $packageLogResult['msg'];
                }*/

                $keys = array_keys($packageLog->InvoiceList);
                $lastExpiryDate = $packageLog->InvoiceList[$keys['0']]['expire_date'];

                $resultLog = $this->_packageDbObj->logPackageToCompanyDB($lastExpiryDate);

                if($resultLog['result']==-1)
                {
                    return $resultLog['msg'];
                }

                $resultUpdate = $this->_packageDbObj->updatePackageToCompanyDB();

                if($resultUpdate['result']==-1)
                {
                    return $resultUpdate['msg'];
                }
            }
        }

        else
        {
            $resultLog = $this->_packageDbObj->logPackageToCompanyNowDB();

            if($resultLog['result']==-1)
            {
                return $resultLog['msg'];
            }

            $resultInsert = $this->_packageDbObj->insertPackageToCompanyDB();

            if($resultInsert['result']==-1)
            {
                return $resultInsert['msg'];
            }
        }

        $result=$this->set_groupPackagesInfo($this->_packageDbObj->PackageFields);
        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }

    /**
     * Insert Group Packages To Company
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    private function _insertGroupPackagesToCompany()
    {
        global $conn, $lang;

        $this->getGroupPackagesDbObj();

        $result=$this->_packageDbObj->set_groupPackageFields($this->_PackageInfo);

        if($result['result']==-1)
        {
            return $result;
        }

        $resultInsert=$this->_packageDbObj->insertGroupPackagesToCompany();

        if($resultInsert['result']==-1)
        {
            return $resultInsert['msg'];
        }

        $result=$this->set_groupPackagesInfo($this->_packageDbObj->PackageFields);
        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }

    /**
     * Remove Group Packages From Company
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    private function _removeGroupPackagesFromCompany()
    {
        global $conn, $lang;

        $this->getGroupPackagesDbObj();

        $result=$this->_packageDbObj->set_groupPackageFields($this->_PackageInfo);

        if($result['result']==-1)
        {
            return $result;
        }

        $resultInsert=$this->_packageDbObj->removeGroupPackagesFromCompany();

        if($resultInsert['result']==-1)
        {
            return $resultInsert['msg'];
        }

        $result=$this->set_groupPackagesInfo($this->_packageDbObj->PackageFields);
        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }

    /**
     * Update Group Packages
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    private function _updateGroupPackages()
    {
        global $conn, $lang;
        $this->getGroupPackagesDbObj();
        //$this->_newsDbObj->_checkPermission();

        $result=$this->_packageDbObj->set_groupPackageFields($this->_PackageInfo);

        if($result['result']==-1)
        {
            return $result;
        }

        $resultUpdate=$this->_packageDbObj->updateGroupPackageDB();

        if($resultUpdate['result']==-1)
        {
            return $resultUpdate['msg'];
        }

        $result['no'] = 2;
        return $result;
    }

    /**
     * Updates Packages
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    private function _updatePackages()
    {
        global $conn, $lang;

        $this->getGroupPackagesDbObj();

        $result=$this->_packageDbObj->set_groupPackageFields($this->_PackageInfo);

        if($result['result']==-1)
        {
            return $result;
        }

        $resultUpdate=$this->_packageDbObj->updatePackageDB();

        if($resultUpdate['result']==-1)
        {
            return $resultUpdate['msg'];
        }

        $result['no'] = 2;
        return $result;
    }


    /**
     * Change Status
     * @return  mixed
     * @param mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
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

        $this->getGroupPackagesDbObj();
        $result=$this->_packageDbObj->set_IDs($this->_IDs);

        if($result['result']==-1)
        {
            return $result;
        }

        $result=$this->_packageDbObj->changeStatusDB($value);

        if(!isset($result['result']) or $result['result']==-1)
        {
            return $result;
        }

        return $result;
    }


    /**
     * Change Package Status
     * @return  mixed
     * @param mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    private function _changePackageStatus($value='')
    {
        if($value=='Disable')
        {
            $value = '0';
        }
        else if($value=='Enable')
        {
            $value = '1';
        }

        $this->getGroupPackagesDbObj();

        $result=$this->_packageDbObj->set_IDs($this->_IDs);

        if($result['result']==-1)
        {
            return $result;
        }

        $result=$this->_packageDbObj->changePackageStatusDB($value);

        if(!isset($result['result']) or $result['result']==-1)
        {
            return $result;
        }

        return $result;
    }

    /**
     * Calculate Package
     * @return  mixed
     * @param mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    private function _calculatePackage()
    {
        $this->getGroupPackagesDbObj();

        $result=$this->_packageDbObj->calculatePackageDB();

        if($result['result']==-1)
        {
            return $result;
        }

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
    private function _checkIfNameExists($name,$compID)
    {
        //global $conn, $lang;
        $this->getGroupPackagesDbObj();
        $result = $this->_packageDbObj->checkIfNameExistsDB($name,$compID);

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
     * Checks if the name exists
     * @param   $name
     * @param   $compID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _checkIfGroupNameExists($name,$compID)
    {
        //global $conn, $lang;
        $this->getGroupPackagesDbObj();
        $result = $this->_packageDbObj->checkIfGroupNameExistsDB($name,$compID);

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

