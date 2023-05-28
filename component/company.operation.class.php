<?php

include_once(ROOT_DIR . "component/Validators.class.php");

/**
 * @author Malekloo Izadi Sakhamanesh <Izadi@dabacenter.ir>
 * @version 0.0.1 this is the beta version of News
 * @copyright 2015 The Imen Daba Parsian Co.
 */
class company_operation
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
     * Contains Company info
     * @var
     */
    private $_companyGroupInfo;
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
     * @var
     */
    private $_IDs;
    /**
     * @var
     */
    private $_trashList;
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
        $this->_companyInfo = array();
        $this->_companyGroupInfo = array();
        $this->addForm = array();
        $this->addForm = array(
            'Comp_Name' => '',
            'Manager_Name' => '',
            'Address' => '',
            'Email' => '',
            'Phone_Number' => '',
            'GroupID' => '',
        );
        $this->editForm = array();
        $this->editForm = array(
            'id' => '',
            'Comp_Name' => '',
            'Manager_Name' => '',
            'Address' => '',
            'Email' => '',
            'Phone_Number' => '',
            'GroupID' => ''
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
                case "_set_companyInfo" :
                    return $this->_set_companyInfo($args['0']);
                    break;
                case "_set_companyGroupInfo" :
                    return $this->_set_companyGroupInfo($args['0']);
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
                case "_deleteCompany" :
                    return $this->_deleteCompany($args['0']);
                    break;
                case "_deleteFromGroup" :
                    return $this->_deleteFromGroup($args['0'], $args['1']);
                    break;
                case "_getCompanyList" :
                    return $this->_getCompanyList($args['0']);
                    break;
                case "_getGroupMembersList" :
                    return $this->_getGroupMembersList($args['0'], $args['1']);
                    break;
                case "_getCompanyGroupList" :
                    return $this->_getCompanyGroupList($args['0']);
                    break;
                case "_getCompanyListById" :
                    return $this->_getCompanyListById($args['0']);
                    break;
                case "_getCompanyGroupListById" :
                    return $this->_getCompanyGroupListById($args['0']);
                    break;
                case "_insertCompany" :
                    return $this->_insertCompany();
                    break;
                case "_insertCompanyToGroup" :
                    return $this->_insertCompanyToGroup();
                    break;
                case "_insertCompanyGroup" :
                    return $this->_insertCompanyGroup();
                    break;
                case "_updateCompany" :
                    return $this->_updateCompany();
                    break;
                case "_updateCompanyGroup" :
                    return $this->_updateCompanyGroup();
                    break;
                case "_changeStatus" :
                    return $this->_changeStatus($args['0']);
                    break;
                case "_changeGroupStatus" :
                    return $this->_changeGroupStatus($args['0']);
                    break;
                case "_trashCompany" :
                    return $this->_trashCompany($args['0']);
                    break;
                case "_recycleCompany" :
                    return $this->_recycleCompany($args['0']);
                    break;
                case "_checkAnnounceDependency" :
                    return $this->_checkAnnounceDependency($args['0']);
                    break;
                case "_checkIVRDependency" :
                    return $this->_checkIVRDependency($args['0']);
                    break;
                case "_checkQueueDependency" :
                    return $this->_checkQueueDependency($args['0']);
                    break;
                case "_checkExtensionDependency" :
                    return $this->_checkExtensionDependency($args['0']);
                    break;
                case "_checkUploadDependency" :
                    return $this->_checkUploadDependency($args['0']);
                    break;
                case "_checkSIPDependency" :
                    return $this->_checkSIPDependency($args['0']);
                    break;
                case "_checkInboundDependency" :
                    return $this->_checkInboundDependency($args['0']);
                    break;
                case "_checkOutboundDependency" :
                    return $this->_checkOutboundDependency($args['0']);
                    break;
                case "_getSubCompanies" :
                    return $this->_getSubCompanies($args['0']);
                    break;
                case "_checkIfNameExists" :
                    return $this->_checkIfNameExists($args['0']);
                    break;
                case "_checkIfMemberExists" :
                    return $this->_checkIfMemberExists($args['0'], $args['1']);
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
    private function _set_companyGroupInfo($value = '')
    {
        $result['result'] = 1;

        /**
         * Checks if the value of ID is not empty and is integer.
         */


        foreach ($value as $compID => $groups) {
            foreach ($groups as $groupId => $groupInfo) {
                if (isset($groupInfo['Admin']) && !isset($groupInfo['Value'])) {

                    $msg = ModelCOMPANY_02;

                    if ($result['result'] == 1) {
                        $result['msg'] = $msg;
                    }
                    $result['result'] = -1;
                    $result['err'] = -2;

                    $result['msgList']['id'] = $msg;
                }

                $this->_companyGroupInfo[$compID][$groupId] = ($groupInfo['Admin'] == 'on' ? 1 : 0);

            }

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
     * @date    08/08/2015
     *
     */
    private function _set_companyInfo($value = '')
    {

        $result['result'] = 1;

        /**
         * Checks if the value of ID is not empty and is integer.
         */
        if (isset($value['id'])) {


            if (empty($value['id'])) {
                $msg = ModelCOMPANY_03;

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
                $this->_companyInfo['id'] = $value['id'];
            }

        }

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
         * Checks if the value of ID is not empty and is integer.
         */
        if (isset($value['CompID'])) {
            if (empty($value['CompID'])) {
                $msg = ModelCOMPANY_03;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['CompID'] = $msg;
            } elseif (!Validator::Numeric($value['CompID'])) {
                $msg = ModelCOMPANY_04;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['CompID'] = $msg;
            }
            {
                $this->_companyInfo['CompID'] = $value['CompID'];
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

        /**
         * Checks if the value of Company name is not empty and is string.
         */
        if (isset($value['Group_Name'])) {
            if (empty($value['Group_Name'])) {
                $msg = ModelCOMPANY_05;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['Group_Name'] = $msg;
            } elseif (!is_string($value['Group_Name'])) {
                $msg = ModelCOMPANY_06;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['Group_Name'] = $msg;
            } else {
                $this->_companyInfo['Group_Name'] = $value['Group_Name'];
            }

        }


        /**
         * Checks if the value of manager name is not empty and is string.
         */
        if (isset($value['Manager_Name'])) {
            if (empty($value['Manager_Name'])) {
                $msg = ModelCOMPANY_07;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['Manager_Name'] = $msg;
            } elseif (!is_string($value['Manager_Name'])) {
                $msg = ModelCOMPANY_08;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['Manager_Name'] = $msg;
            } else {
                $this->_companyInfo['Manager_Name'] = $value['Manager_Name'];
            }

        }

        /**
         * Checks if the value of address is not empty and is integer.
         */
        if (isset($value['Address'])) {
            if (empty($value['Address'])) {
                $msg = ModelCOMPANY_09;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['Address'] = $msg;
            } elseif (!is_string($value['Address'])) {
                $msg = ModelCOMPANY_10;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['Address'] = $msg;
            } else {
                $this->_companyInfo['Address'] = $value['Address'];
            }

        }

        /**
         * Checks if the value of email is not empty and is integer.
         */
        if (isset($value['Email'])) {
            if (empty($value['Email'])) {
                $msg = ModelCOMPANY_11;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['Email'] = $msg;
            } elseif (!Validator::Email($value['Email'])) {
                $msg = ModelCOMPANY_12;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['Email'] = $msg;
            } else {
                $this->_companyInfo['Email'] = $value['Email'];
            }

        }

        /**
         * Checks if the value of phone number is not empty and is numeric.
         */
        if (isset($value['Phone_Number'])) {
            if (empty($value['Phone_Number'])) {
                $msg = ModelCOMPANY_13;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;
                $result['msgList']['Phone_Number'] = $msg;
            } elseif (!Validator::Numeric($value['Phone_Number'])) {
                $msg = ModelCOMPANY_14;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;
                $result['msgList']['Phone_Number'] = $msg;

            } else {
                $this->_companyInfo['Phone_Number'] = $value['Phone_Number'];

            }

        }

        if (isset($value['GroupID'])) {

            if (empty($value['GroupID'])) {

                $msg = ModelCOMPANY_15;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }

                $result['result'] = -1;
                $result['err'] = -2;
                $result['msgList']['GroupID'] = $msg;
            } else {
                foreach ($value['GroupID'] as $key => $value) {
                    $this->_companyInfo['GroupID'][$key] = true;
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
            case 'companyList':
                return $this->_companyList;
                break;
            case 'trashList':
                return $this->_trashList;
                break;
            case 'paging':
                return $this->_paging;
                break;
            case 'companyInfo':
                return $this->_companyInfo;
                break;
            case 'companyGroupInfo':
                return $this->_companyGroupInfo;
                break;
            default:
                break;
        }

    }

    /**
     * Gets the company list based on its ID
     * @param $compID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getCompanyListById($compID)
    {
        //global $conn, $lang;
        if (is_int($compID)) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = ModelCOMPANY_16;
            $result['func'] = 'getCompanyListById';
            return $result;
        }

        $this->getCompanyDbObj();
        $result = $this->_companyDbObj->getCompanyById($compID);

        if ($result['result'] == -1) {
            return $result;
        }

        $this->_companyInfo = $this->_companyDbObj->companyFields;
        unset($this->_companyDbObj);
        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }

    /**
     * Gets the news list based on its ID
     * @param $compID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getCompanyGroupListById($compID)
    {
        global $conn, $lang;

        if (is_int($compID)) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = ModelCOMPANY_16;
            $result['func'] = 'getCompanyListById';
            return $result;
        }

        $this->getCompanyDbObj();
        $result = $this->_companyDbObj->getCompanyGroupById($compID);

        if ($result['result'] == -1) {
            return $result;
        }

        $this->_companyInfo = $this->_companyDbObj->companyFields;
        //$this->_set_companyInfo($this->_newsListDb[$id]);
        unset($this->_companyDbObj);
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
    private function getCompanyDbObj()
    {
        include_once(ROOT_DIR . "component/company.db.class.php");
        $this->_companyDbObj = new company_db();
    }

    /**
     * Deletes Company
     * @param  $compID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    private function _deleteCompany($compID)
    {
        //global $conn, $lang;
        $this->getCompanyDbObj();
        $result = $this->_companyDbObj->removeCompanyDB($compID);
        unset($this->_companyDbObj);

        if ($result == -1) {
            $result['result'] = -1;
            $result['no'] = 2;
            return $result;
        }

        $result['result'] = 1;
        return $result;
    }

    /**
     * Deletes Company
     * @param  $compID
     * @param  $groupID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    private function _deleteFromGroup($groupID, $compID)
    {
        //global $conn, $lang;
        $this->getCompanyDbObj();
        $result = $this->_companyDbObj->removeFromGroupDB($groupID, $compID);
        unset($this->_companyDbObj);

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
     * @return  mixed
     * @param  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getCompanyList($fields)
    {
        //global $conn, $lang;
        $this->getCompanyDbObj();
        $result = $this->_companyDbObj->getCompany($fields);

        if ($result['result'] != 1) {
            return $result;
        }

        $this->_paging = $this->_companyDbObj->paging;
        $this->_companyList = $this->_companyDbObj->companyList;
        unset($this->_companyDbObj);
        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }

    /**
     * Gets the news list
     * @return  mixed
     * @param  $compID
     * @param  $compGroupID
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _checkIfMemberExists($compID, $compGroupID)
    {
        //global $conn, $lang;
        $this->getCompanyDbObj();
        $result = $this->_companyDbObj->checkIfMemberExistsDB($compID, $compGroupID);

        if ($result['result'] == -2) {
            return $result;
        }

        $this->_companyDbObj = '';
        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }

    /**
     * Gets the news list
     * @return  mixed
     * @param  mixed
     * @param  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getGroupMembersList($fields, $GroupID)
    {
        //global $conn, $lang;
        $this->getCompanyDbObj();
        $result = $this->_companyDbObj->getMembersList($fields, $GroupID);

        if ($result['result'] != 1) {
            return $result;
        }

        $this->_paging = $this->_companyDbObj->paging;
        $this->_companyList = $this->_companyDbObj->companyList;
        unset($this->_companyDbObj);
        $result['result'] = 1;
        $result['no'] = 2;
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
    private function _getCompanyGroupList($fields)
    {
        //global $conn, $lang;

        $this->getCompanyDbObj();
        $result = $this->_companyDbObj->getCompanyGroup($fields);

        if ($result['result'] != 1) {
            return $result;
        }

        $this->_paging = $this->_companyDbObj->paging;
        $this->_companyList = $this->_companyDbObj->companyList;
        unset($this->_companyDbObj);
        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }

    /**
     * Gets the news list
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _insertCompany()
    {
        //global $conn, $lang;
        $this->getCompanyDbObj();
        $result = $this->_companyDbObj->set_companyFields($this->_companyInfo);

        if ($result['result'] == -1) {
            return $result;
        }

        $resultInsert = $this->_companyDbObj->insertCompanyDB();
        if ($resultInsert['result'] == -1) {
            return $resultInsert['msg'];
        }

        $result = $this->set_companyInfo($this->_companyDbObj->companyFields);
        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }

    /**
     * Gets the news list
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _insertCompanyToGroup()
    {
        //global $conn, $lang;
        $this->getCompanyDbObj();
        $result = $this->_companyDbObj->set_companyGroupFields($this->_companyGroupInfo);

        if ($result['result'] == -1) {
            return $result;
        }

        $resultInsert = $this->_companyDbObj->insertCompanyToGroupDB();

        if ($resultInsert['result'] == -1) {
            return $resultInsert['msg'];
        }

        $result = $this->set_companyGroupInfo($this->_companyDbObj->groupCompany);
        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }

    /**
     * Gets the news list
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _insertCompanyGroup()
    {
        //global $conn, $lang;
        $this->getCompanyDbObj();
        $result = $this->_companyDbObj->set_companyFields($this->_companyInfo);

        if ($result['result'] == -1) {
            return $result;
        }

        $resultInsert = $this->_companyDbObj->insertCompanyGroupDB();

        if ($resultInsert['result'] == -1) {
            return $resultInsert['msg'];
        }

        $result = $this->set_companyInfo($this->_companyDbObj->companyFields);
        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }

    /**
     * Gets the news list
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01`
     * @date    08/08/2015
     */
    private function _updateCompany()
    {
        // global $conn, $lang;
        $this->getCompanyDbObj();
        $result = $this->_companyDbObj->set_companyFields($this->_companyInfo);

        if ($result['result'] == -1) {
            return $result;
        }

        $resultUpdate = $this->_companyDbObj->updateCompanyDB();

        if ($resultUpdate['result'] == -1) {
            return $resultUpdate['msg'];
        }

        $result['no'] = 2;
        return $result;
    }


    /**
     * Gets the news list
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01`
     * @date    08/08/2015
     */
    public function removeAllCompanyFromGroup($compID)
    {
        // global $conn, $lang;
        $this->getCompanyDbObj();

        $resultUpdate = $this->_companyDbObj->removeAllCompanyFromGroupDB($compID);
        if ($resultUpdate['result'] == -1) {
            return $resultUpdate['msg'];
        }

        $resultUpdate['no'] = 2;
        return $resultUpdate;
    }


    /**
     * Gets the news list
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _updateCompanyGroup()
    {
        // global $conn, $lang;
        $this->getCompanyDbObj();
        $result = $this->_companyDbObj->set_companyFields($this->_companyInfo);

        if ($result['result'] == -1) {
            return $result;
        }

        $resultUpdate = $this->_companyDbObj->updateCompanyGroupDB();

        if ($resultUpdate['result'] == -1) {
            return $resultUpdate['msg'];
        }

        $result['no'] = 2;
        return $result;
    }

    /**
     * Gets the sip list
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
        $this->getCompanyDbObj();
        $result = $this->_companyDbObj->set_IDs($this->_IDs);

        if ($result['result'] == -1) {
            return $result;
        }

        $result = $this->_companyDbObj->changeStatusDB($value);

        if (!isset($result['result']) or $result['result'] == -1) {
            return $result;
        }

        return $result;
    }

    /**
     * Gets the sip list
     * @param  $value
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _changeGroupStatus($value = '')
    {
        if ($value == 'Disable') {
            $value = '0';
        } else if ($value == 'Enable') {
            $value = '1';
        }

        $this->getCompanyDbObj();
        $result = $this->_companyDbObj->set_IDs($this->_IDs);

        if ($result['result'] == -1) {
            return $result;
        }

        $result = $this->_companyDbObj->changeGroupStatusDB($value);

        if (!isset($result['result']) or $result['result'] == -1) {
            return $result;
        }

        return $result;
    }

    /**
     * Deletes extension
     * @param  $companyID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    private function _trashCompany($companyID)
    {
        // global $conn, $lang;
        $this->getCompanyDbObj();
        $result = $this->_companyDbObj->trashCompanyDB($companyID);

        if ($result == -1) {
            $result['result'] = -1;
            $result['no'] = 2;
            return $result;
        }

        $result['result'] = 1;
        return $result;
    }

    /**
     * Deletes extension
     * @param  $companyID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    private function _recycleCompany($companyID)
    {
        //global $conn, $lang;
        $this->getCompanyDbObj();
        $result = $this->_companyDbObj->recycleCompanyDB($companyID);

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
     * @param  $companyID
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _checkAnnounceDependency($companyID)
    {
        //global $conn, $lang;
        include_once(ROOT_DIR . "component/announce.operation.class.php");
        $announce = new announce_operation();
        $result = $announce->getAnnounceByCompany($companyID);

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
     * @param  $companyID
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _checkIVRDependency($companyID)
    {
        //global $conn, $lang;
        include_once(ROOT_DIR . "component/ivr.operation.class.php");
        $IVR = new ivr_operation();
        $result = $IVR->getIVRByCompany($companyID);

        if ($result['result'] = 1) {
            $result['list'] = $IVR->ivrList;
            return $result;
        }

        $result['result'] = -1;
        $result['no'] = 2;
        return $result;
    }

    /**
     * Checks the dependency before deleting
     * @return  mixed
     * @param  $companyID
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _checkQueueDependency($companyID)
    {
        //global $conn, $lang;
        include_once(ROOT_DIR . "component/queue.operation.class.php");
        $QUEUE = new queue_operation();
        $result = $QUEUE->getQueueByCompany($companyID);

        if ($result['result'] = 1) {
            $result['list'] = $QUEUE->queueList;
            return $result;
        }

        $result['result'] = -1;
        $result['no'] = 2;
        return $result;
    }

    /**
     * Checks the dependency before deleting
     * @return  mixed
     * @param  $companyID
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _checkExtensionDependency($companyID)
    {
        //global $conn, $lang;
        include_once(ROOT_DIR . "component/extension.operation.class.php");
        $Extension = new extension_operation();
        $result = $Extension->getExtensionByCompany($companyID);

        if ($result['result'] = 1) {
            $result['list'] = $Extension->extensionList;
            return $result;
        }

        $result['result'] = -1;
        $result['no'] = 2;
        return $result;
    }

    /**
     * Checks the dependency before deleting
     * @return  mixed
     * @param  $companyID
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _checkUploadDependency($companyID)
    {
        //global $conn, $lang;
        include_once(ROOT_DIR . "component/upload.operation.class.php");
        $Upload = new upload_operation();
        $result = $Upload->getUploadByCompany($companyID);

        if ($result['result'] = 1) {
            $result['list'] = $Upload->uploadList;
            return $result;
        }

        $result['result'] = -1;
        $result['no'] = 2;
        return $result;
    }

    /**
     * Checks the dependency before deleting
     * @return  mixed
     * @param  $companyID
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _checkSIPDependency($companyID)
    {
        //global $conn, $lang;
        include_once(ROOT_DIR . "component/sip.operation.class.php");
        $SIP = new sip_operation();
        $result = $SIP->getSIPByCompany($companyID);

        if ($result['result'] = 1) {
            $result['list'] = $SIP->sipList;
            return $result;
        }

        $result['result'] = -1;
        $result['no'] = 2;
        return $result;
    }

    /**
     * Checks the dependency before deleting
     * @return  mixed
     * @param  $companyID
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _checkOutboundDependency($companyID)
    {
        //global $conn, $lang;
        include_once(ROOT_DIR . "component/outbound.operation.class.php");
        $Outbound = new outbound_operation();
        $result = $Outbound->getOutboundByCompany($companyID);

        if ($result['result'] = 1) {
            $result['list'] = $Outbound->outboundList;
            return $result;
        }

        $result['result'] = -1;
        $result['no'] = 2;
        return $result;
    }

    /**
     * Checks the dependency before deleting
     * @return  mixed
     * @param  $companyID
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _checkInboundDependency($companyID)
    {
        //global $conn, $lang;
        include_once(ROOT_DIR . "component/inbound.operation.class.php");
        $Inbound = new inbound_operation();
        $result = $Inbound->getInboundByCompany($companyID);

        if ($result['result'] = 1) {
            $result['list'] = $Inbound->inboundList;
            return $result;
        }

        $result['result'] = -1;
        $result['no'] = 2;
        return $result;
    }

    private function _getSubCompanies($compID)
    {

        global $conn, $lang;

        $this->getCompanyDbObj();
        $result = $this->_companyDbObj->getSubCompanies($compID);


        if ($result['result'] == -1) {
            return $result;
        }

        return $result;
    }

    private function _checkIfNameExists($groupName)
    {
        global $conn, $lang;

        $this->getCompanyDbObj();

        $result = $this->_companyDbObj->getCompanyGroup();

        $this->_companyList = $this->_companyDbObj->companyList;

        foreach ($this->_companyList as $key => $value) {
            if ($value['Group_Name'] == $groupName) {
                $result['msg'] = ModelCOMPANY_17;
                $result['result'] = -1;
                return $result;
            }
        }

        $result['result'] = 1;
        return $result;
    }


}

