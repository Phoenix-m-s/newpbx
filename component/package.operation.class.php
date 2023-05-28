`<?php
include_once(ROOT_DIR . "component/Validators.class.php");

/**
 * @author Malekloo Izadi Sakhamanesh <Izadi@dabacenter.ir>
 * @version 0.0.1 this is the beta version of groupPakegs
 * @copyright 2015 The Imen Daba Parsian Co.
 */
class Package_operation
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

    public $_set;
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
     * Specifies the type of output
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    public function __construct()
    {

        $this->_PackageInfo = array();

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
                case "_getSalablePackageList" :

                    return $this->_getSalablePackageList($args['0'], $args['1']);
                    break;
                case "_getCompanyPackageList" :
                    return $this->_getCompanyPackageList($args['0']);
                    break;
                case "_showInvoice" :
                    return $this->_showInvoice();
                    break;
                case "_getCompanyList" :
                    return $this->_getCompanyList($args['0']);
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
    private function _set_groupPackagesInfo($value = '')
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
                $this->_PackageInfo['comp_id'] = $value['comp_id'];
            }

        } else {
            $this->_PackageInfo['comp_id'] = $company_info['comp_id'];
        }
        /**
         * Checks if the value of package_group_name is not empty and is string.
         */
        if (isset($value['package_group_name'])) {
            if (empty($value['package_group_name'])) {
                $msg = ModelBASCKET_01;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['package_group_name'] = $msg;
            } elseif (!is_string($value['package_group_name'])) {
                $msg = ModelBASCKET_02;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['package_group_name'] = $msg;
            } else {
                $this->_PackageInfo['package_group_name'] = $value['package_group_name'];
            }

        }

        /**
         * Checks if the value of package_group_name is not empty and is string.
         */
        if (isset($value['package_id'])) {
            if (empty($value['package_id'])) {
                $msg = ModelPACKAGE_02;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['package_id'] = $msg;
            } elseif (!is_numeric($value['package_id'])) {
                $msg = ModelPACKAGE_03;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['package_id'] = $msg;
            } else {
                $this->_PackageInfo['package_id'] = $value['package_id'];
            }

        }

        /**
         * Checks if the value of package_group_name is not empty and is string.
         */
        if (isset($value['package_name'])) {
            if (empty($value['package_name'])) {
                $msg = ModelBASCKET_04;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['package_name'] = $msg;
            } elseif (!is_string($value['package_name'])) {
                $msg = ModelBASCKET_05;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['package_name'] = $msg;
            } else {
                $this->_PackageInfo['package_name'] = $value['package_name'];
            }

        }
        /**
         * Checks if the value of package_group_id is not empty and is integer.
         */
        if (isset($value['package_group_id'])) {

            if (empty($value['package_group_id'])) {
                $msg = ModelBASCKET_06;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['id'] = $msg;
            } elseif (!Validator::Numeric($value['package_group_id'])) {
                $msg = ModelBASCKET_07;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['package_group_id'] = $msg;
            } else {
                $this->_PackageInfo['package_group_id'] = $value['package_group_id'];
            }

        }

        /**
         * Checks if the value of package_group_id is not empty and is integer.
         */
        if (isset($value['package_id'])) {

            if (empty($value['package_id'])) {
                $msg = ModelBASCKET_08;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['id'] = $msg;
            } elseif (!Validator::Numeric($value['package_id'])) {
                $msg = ModelBASCKET_09;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['package_id'] = $msg;
            } else {
                $this->_PackageInfo['package_id'] = $value['package_id'];
            }

        }

        /**
         * Checks if the value of package_group_id is not empty and is integer.
         */
        if (isset($value['group_id'])) {

            if (empty($value['group_id'])) {
                $msg = ModelBASCKET_10;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['id'] = $msg;
            } elseif (!Validator::Numeric($value['group_id'])) {
                $msg = ModelBASCKET_07;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['group_id'] = $msg;
            } else {
                $this->_PackageInfo['group_id'] = $value['group_id'];
            }

        }

        /**
         * Checks if the value of package_group_id is not empty and is integer.
         */
        if (isset($value['extension_count'])) {

            if (empty($value['extension_count'])) {
                $msg = ModelBASCKET_11;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['id'] = $msg;
            } elseif (!Validator::Numeric($value['extension_count'])) {
                $msg = ModelBASCKET_12;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['extension_count'] = $msg;
            } else {
                $this->_PackageInfo['extension_count'] = $value['extension_count'];
            }

        }

        /**
         * Checks if the value of package_group_id is not empty and is integer.
         */
        if (isset($value['price'])) {

            if (empty($value['price'])) {
                $msg = ModelBASCKET_13;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['id'] = $msg;
            } elseif (!Validator::Numeric($value['price'])) {
                $msg = ModelBASCKET_12;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['price'] = $msg;
            } else {
                $this->_PackageInfo['price'] = $value['price'];
            }

        }


        /**
         * Checks if the value of package_group_id is not empty and is integer.
         */
        if (isset($value['duration'])) {

            if (empty($value['duration'])) {
                $msg = ModelBASCKET_14;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['id'] = $msg;
            } elseif (!is_string($value['duration'])) {
                $msg = ModelPACKAGE_04;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['price'] = $msg;
            } else {
                $this->_PackageInfo['duration'] = $value['duration'];
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
     * @since   01.01.01
     * @date    08/08/2015
     */
    public function __get($field)
    {

        switch ($field) {
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
     * Access the database class
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    private function getGroupPackagesDbObj()
    {
        include_once(ROOT_DIR . "component/package.db.class.php");
        $this->_packageDbObj = new Package_db();
    }


    /**
     * Gets the group Package List list
     * @param  $fields
     * @param  $compID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    private function _getSalablePackageList($fields, $compID)
    {
        global $conn, $lang, $admin_info;;
        $this->getGroupPackagesDbObj();
        $result = $this->_packageDbObj->getSalablePackages($fields, $compID);

        if ($result['result'] != 1) {
            return $result;
        }

        $this->_paging = $this->_packageDbObj->paging;
        $this->_PackageList = $this->_packageDbObj->PackageListDb;
        include_once(ROOT_DIR . "component/packageLog.operation.class.php");
        $invoice = new packageLog_operation();

        $result = $invoice->getLastPackage($compID);

        if ($result['result'] == -1 && $result['no'] == 1000) {
            $startDate = date("Y-m-d H:i:s");
            $expireDate = '';
        } else {
            $keys = array_keys($invoice->InvoiceList);
            $expireDate = $invoice->InvoiceList[$keys['0']]['expire_date'];
            $startDate = date("Y-m-d H:i:s", strtotime("+1 second", strtotime($expireDate)));
        }

        foreach ($this->_PackageList as $key => $value) {
            $newExpiryDate = date("Y-m-d H:i:s", strtotime("+" . $value['duration'], strtotime($startDate)));
            $this->_PackageList[$key]['new_expire_date'] = $newExpiryDate;
            $this->_PackageList[$key]['start_date'] = $startDate;
            $this->_PackageList[$key]['expire_date'] = date("Y-m-d H:i:s");//$expireDate;
        }

        unset($this->_packageDbObj);
        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }

    /**
     * Gets the company Package List
     * @param  $fields
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    private function _getCompanyPackageList($fields)
    {
        global $conn, $lang;
        $this->getGroupPackagesDbObj();
        $result = $this->_packageDbObj->getCompanyPackages($fields);

        if ($result['result'] != 1) {
            return $result;
        }

        $this->_paging = $this->_packageDbObj->paging;
        $this->_PackageList = $this->_packageDbObj->PackageListDb;

        unset($this->_packageDbObj);
        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }

    /**
     * Gets the group Package List
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    private function _showInvoice()
    {
        global $conn, $lang;
        $this->getGroupPackagesDbObj();
        $result = $this->_packageDbObj->showInvoiceDB();

        if ($result['result'] != 1) {
            return $result;
        }

        $this->_paging = $this->_packageDbObj->paging;
        $this->_PackageList = $this->_packageDbObj->PackageListDb;
        unset($this->_packageDbObj);
        $result['result'] = 1;
        $result['no'] = 2;
        return $result;

    }

    /**
     * Gets the company List
     * @param  $fields
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    private function _getCompanyList($fields)
    {
        global $conn, $lang;

        $this->getGroupPackagesDbObj();
        $result = $this->_packageDbObj->getCompany($fields);

        if ($result['result'] != 1) {
            return $result;
        }

        $this->_paging = $this->_packageDbObj->paging;
        $this->_PackageList = $this->_packageDbObj->PackageListDb;
        unset($this->_packageDbObj);
        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }
}

