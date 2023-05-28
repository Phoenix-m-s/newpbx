<?php
include_once(ROOT_DIR . "component/Validators.class.php");

/**
 * @author Malekloo Izadi Sakhamanesh <Izadi@dabacenter.ir>
 * @version 0.0.1 this is the beta version of groupPakegs
 * @copyright 2015 The Imen Daba Parsian Co.
 */
class packageLog_operation
{
    /**
     * Contains group info
     * @var
     */
    private $_invoiceInfo;
    /**
     * Contains List of group
     * @var
     */
    private $_InvoiceList;
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
    private $_packageLogDbObj;
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

        $this->_invoiceInfo = array();

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
                case "_showPackageLog" :
                    return $this->_showPackageLog($args['0']);
                    break;
                case "_set_invoiceInfo" :
                    return $this->_set_invoiceInfo($args['0']);
                    break;
                case "_getLastPackage" :
                    return $this->_getLastPackage($args['0']);
                    break;
                case "_addInvoiceToLog" :
                    return $this->_addInvoiceToLog($args['0']);
                    break;
                case "_updateExpiryDateForLastPackage" :
                    return $this->_updateExpiryDateForLastPackage($args['0']);
                    break;
                case "_getExpiryDateForLastPackage" :
                    return $this->_getExpiryDateForLastPackage($args['0']);
                    break;
                case "_checkStartDateInLog" :
                    return $this->_checkStartDateInLog();
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
                $this->_invoiceInfo['comp_id'] = $value['comp_id'];
            }

        } else {
            $this->_invoiceInfo['comp_id'] = $company_info['comp_id'];
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
                $this->_invoiceInfo['package_group_name'] = $value['package_group_name'];
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
                $this->_invoiceInfo['package_id'] = $value['package_id'];
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
                $this->_invoiceInfo['package_name'] = $value['package_name'];
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
                $this->_invoiceInfo['package_group_id'] = $value['package_group_id'];
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
                $this->_invoiceInfo['package_id'] = $value['package_id'];
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
                $this->_invoiceInfo['group_id'] = $value['group_id'];
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
                $this->_invoiceInfo['extension_count'] = $value['extension_count'];
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
                $this->_invoiceInfo['price'] = $value['price'];
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
            } else if (!is_string($value['duration'])) {
                $msg = ModelPACKAGE_04;


                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['price'] = $msg;
            } else {

                $this->_invoiceInfo['duration'] = $value['duration'];
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
     * @param $value
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */


    private function _set_invoiceInfo($value = '')
    {
        $result['result'] = 1;
        global $admin_info, $company_info;


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
                $this->_invoiceInfo['comp_id'] = $value['comp_id'];
            }

        } else {
            $this->_invoiceInfo['comp_id'] = $company_info['comp_id'];
        }
        //$startDate = date("Y-m-d H:i:s");

        if (isset($value['issue_date'])) {
            if (empty($value['issue_date'])) {
                $msg = ModelPACKAGELog_01;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;
                $result['msgList']['issue_date'] = $msg;
            } else {
                $this->_invoiceInfo['issue_date'] = $value['issue_date'];
            }


        }
        if (isset($value['start_date'])) {

            if (empty($value['start_date'])) {
                $msg = ModelPACKAGELog_02;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;
                $result['msgList']['start_date'] = $msg;
            } else {
                $this->_invoiceInfo['start_date'] = $value['start_date'];
            }


        }

        if (isset($value['expiry_date'])) {
            if (empty($value['expiry_date'])) {
                $msg = ModelPACKAGELog_03;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;
                $result['msgList']['expiry_date'] = $msg;
            } else {
                $this->_invoiceInfo['expiry_date'] = $value['expiry_date'];
            }
        }


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
                $this->_invoiceInfo['package_id'] = $value['package_id'];
            }

        }

        if (isset($value['creator'])) {

            if (empty($value['creator'])) {
                $msg = ModelANNOUNCE_09;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['creator'] = $msg;
            } elseif (!Validator::Numeric($value['creator'])) {
                $msg = ModelANNOUNCE_10;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['id'] = $msg;
            } else {
                $this->_invoiceInfo['creator'] = $value['creator'];
            }

        } else {
            $this->_invoiceInfo['creator'] = $admin_info['creator'];
        }

        if (isset($value['comment'])) {
            if (empty($value['comment'])) {
                $msg = ModelPACKAGELog_04;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['comment'] = $msg;
            } elseif (!is_string($value['comment'])) {
                $msg = ModelPACKAGELog_05;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['comment'] = $msg;
            } else {
                $this->_invoiceInfo['comment'] = $value['comment'];
            }

        }


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
                $this->_invoiceInfo['extension_count'] = $value['extension_count'];
            }


        }

        if (isset($value['type_package'])) {
            $this->_invoiceInfo['type_package'] = $value['type_package'];
        }

        if (isset($value['order_for'])) {

            if (empty($value['order_for'])) {
                $msg = ModelPACKAGELog_06;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['creator'] = $msg;
            } elseif (!Validator::Numeric($value['order_for'])) {
                $msg = ModelANNOUNCE_10;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['id'] = $msg;
            } else {
                $this->_invoiceInfo['order_for'] = $value['creator'];
            }
        } else {
            $this->_invoiceInfo['order_for'] = $admin_info['admin_id'];
        }


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
                $this->_invoiceInfo['price'] = $value['price'];
            }

        }

        if (isset($value['pay_date'])) {
            if (empty($value['pay_date'])) {
                $msg = ModelPACKAGELog_07;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;
                $result['msgList']['pay_date'] = $msg;
            } else {
                $this->_invoiceInfo['pay_date'] = $value['pay_date'];
            }

        }

        if (isset($value['payment_type'])) {
            if (empty($value['payment_type'])) {
                $msg = ModelPACKAGELog_08;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;
                $result['msgList']['payment_type'] = $msg;
            } else {
                $this->_invoiceInfo['payment_type'] = $value['payment_type'];
            }

        }
        if (isset($value['duration'])) {

            $this->_invoiceInfo['duration'] = $value['duration'];
        }

        //print_r($this->_invoiceInfo);
        return $result;
    }


    public function __get($field)
    {

        switch ($field) {
            case 'paging':
                return $this->_paging;
                break;
            case 'InvoiceList':
                return $this->_InvoiceList;
                break;
            case 'invoiceInfo':
                return $this->_invoiceInfo;
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
    private function getInvoiceDbObj()
    {
        include_once(ROOT_DIR . "component/packageLog.db.class.php");
        $this->_packageLogDbObj = new packageLog_db();
    }


    /**
     * Gets the group Package List
     * @param  $fields
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    private function _showPackageLog($fields)
    {
        global $conn, $lang;
        $this->getInvoiceDbObj();
        $result = $this->_packageLogDbObj->showPackageLogDB($fields);

        if ($result['result'] != 1) {
            return $result;
        }

        $this->_paging = $this->_packageLogDbObj->paging;
        $this->_InvoiceList = $this->_packageLogDbObj->packageLogListDb;
        unset($this->_packageDbObj);
        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }

    /**
     * Gets the group Package List
     * @param  $CompID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    private function _getLastPackage($CompID)
    {
        global $conn, $lang;
        $this->getInvoiceDbObj();
        $result = $this->_packageLogDbObj->getLastPackageDB($CompID);

        if ($result['result'] != 1) {
            return $result;
        }

        $this->_paging = $this->_packageLogDbObj->paging;
        $this->_InvoiceList = $this->_packageLogDbObj->InvoiceListDb;
        unset($this->_packageDbObj);
        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }

    /**
     * Update Expiry Date For Last Package
     * @param  $orderFor
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    private function _updateExpiryDateForLastPackage($orderFor)
    {
        global $conn, $lang;
        $this->getInvoiceDbObj();
        $result = $this->_packageLogDbObj->getLastPackageByOrderForDB($orderFor);

        if ($result['result'] != 1) {
            return $result;
        }

        $keys = array_keys($this->_packageLogDbObj->packageLogListDb);
        $date = date('Y-m-d H:i:s');
        $expiryDate = $this->_packageLogDbObj->packageLogListDb[$keys['0']]['expire_date'];
        $logID = $this->_packageLogDbObj->packageLogListDb[$keys['0']]['id'];

        if (strtotime($expiryDate) > strtotime($date)) {

            $result = $this->_packageLogDbObj->updateExpiryForLastPackage($orderFor, $logID);

            if ($result['result'] != 1) {
                return $result;
            }
        }

        $this->_InvoiceList = $this->_packageLogDbObj->packageLogListDb;
        unset($this->_packageDbObj);
        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }

    /**
     * Get Expiry Date For Last Package
     * @param  $orderFor
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    private function _getExpiryDateForLastPackage($orderFor)
    {
        global $conn, $lang;
        $this->getInvoiceDbObj();
        $result = $this->_packageLogDbObj->getLastPackageByOrderForDB($orderFor);

        if ($result['result'] != 1) {
            return $result;
        }

        $this->_InvoiceList = $this->_packageLogDbObj->packageLogListDb;
        // unset($this->_packageDbObj);
        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }

    /**
     * Add Invoice To Log
     * @param  $invoiceID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    private function _addInvoiceToLog($invoiceID)
    {
        global $conn, $admin_info, $company_info;
        $this->getInvoiceDbObj();
        include_once(ROOT_DIR . "component/basket.operation.class.php");
        $basket_obj = new basket_operation();
        $input['comp_id'] = $company_info['comp_id'];
        $input['invoice_id'] = $invoiceID;
        $basket_obj->getBasketList($input);
        $result = $this->_packageLogDbObj->set_basketToPackageLogListDb($basket_obj->basketList);

        if ($result['result'] == -1) {
            return $result;
        }

        $result = $this->_packageLogDbObj->addLogDB();

        if ($result['result'] != 1) {
            return $result;
        }

        /*   $result=$this->set_packageLogInfo($this->_packageLogDbObj->companyFields);*/
        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }


    /**
     * Checks start date for all packages in package Log to see if one should be inserted in package company
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    private function _checkStartDateInLog()
    {
        global $conn, $lang;
        $this->getInvoiceDbObj();
        $result = $this->_packageLogDbObj->getLogDB();

        if ($result['result'] != 1) {
            return $result;
        }

        $this->_InvoiceList = $this->_packageLogDbObj->packageLogListDb;
        $now = date("Y-m-d H:i:s");
        $startDateMinusFive = date("Y-m-d H:i:s", strtotime("-5 hour", strtotime($now)));

        include_once(ROOT_DIR . "component/package.db.class.php");
        $package = new Package_db();

        foreach ($this->_InvoiceList as $key => $value) {

            if (strtotime($value['start_date']) >= strtotime($now) AND strtotime($this->_InvoiceList['start_date']) <= strtotime($startDateMinusFive)) {
                $result = $package->checksIfLogIDExistsInPackageCompany($this->_InvoiceList['id']);

                if ($result['exist'] == 1) {
                    $package->updatePackageCompany($this->_InvoiceList);
                } else {
                    $package->insertPackageCompany($this->_InvoiceList);
                }
            }

        }

        unset($this->_packageDbObj);
        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }

}

