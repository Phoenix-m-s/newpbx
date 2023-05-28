<?php
include_once(ROOT_DIR . "component/Validators.class.php");

/**
 * @author Malekloo Izadi Sakhamanesh <Izadi@dabacenter.ir>
 * @version 0.0.1 this is the beta version of groupPakegs
 * @copyright 2015 The Imen Daba Parsian Co.
 */
class basket_operation
{
    /**
     * Contains group info
     * @var
     */
    private $_basketInfo;
    /**
     * Contains List of group
     * @var
     */
    private $_basketList;
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
    private $_basketDbObj;
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

        $this->_basketList = array();

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
                case "_set_basketInfo" :
                    return $this->_set_basketInfo($args['0']);
                    break;
                case "_getBasketList" :
                    return $this->_getBasketList($args['0']);
                    break;
                case "_addPackageToBasket" :
                    return $this->_addPackageToBasket();
                    break;
                case "_removeInvoice" :
                    return $this->_removeInvoice($args['0']);
                    break;
                case "_calculateTax" :
                    return $this->_calculateTax($args['0']);
                    break;
                case "_getSalablePackageListById":
                    return $this->_getSalablePackageListById($args['0']);
                    break;
                case "_sendInvoice":
                    return $this->_sendInvoice($args['0']);
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
    private function _set_basketInfo($value = '')
    {
        $result['result'] = 1;
        global $admin_info, $company_info;
        $this->_basketInfo['order_for'] = $value['order_for'];

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
                $this->_basketInfo['comp_id'] = $value['comp_id'];
            }

        } else {
            $this->_basketInfo['comp_id'] = $company_info['comp_id'];
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
                $this->_basketInfo['package_group_name'] = $value['package_group_name'];
            }

        }

        /**
         * Checks if the value of package_group_name is not empty and is string.
         */
        if (isset($value['assign_date'])) {
            if (empty($value['assign_date'])) {
                $msg = ModelBASCKET_03;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['assign_date'] = $msg;
            } else {
                $this->_basketInfo['assign_date'] = $value['assign_date'];
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
                $this->_basketInfo['package_name'] = $value['package_name'];
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
                $this->_basketInfo['package_group_id'] = $value['package_group_id'];
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
                $this->_basketInfo['package_id'] = $value['package_id'];
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
                $this->_basketInfo['group_id'] = $value['group_id'];
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
                $msg = 'extension_count should only contain numbers.';

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['extension_count'] = $msg;
            } else {
                $this->_basketInfo['extension_count'] = $value['extension_count'];
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
                $this->_basketInfo['price'] = $value['price'];
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
                $msg = ModelBASCKET_15;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['price'] = $msg;
            } else {
                $this->_basketInfo['duration'] = $value['duration'];
            }

        }
        /**
         * Checks if the value of package_group_id is not empty and is integer.
         */
        if (isset($value['package_status'])) {

            if (empty($value['package_status'])) {
                $msg = 'Please enter status';

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['id'] = $msg;
            } elseif (!Validator::Numeric($value['package_status'])) {
                $msg = ModelBASCKET_15;

                if ($result['result'] == 1) {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['price'] = $msg;
            } else {
                $this->_basketInfo['package_status'] = $value['package_status'];
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
            case 'basketList':
                return $this->_basketList;
                break;
            case 'basketInfo':
                return $this->_basketInfo;
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
    private function getBasketDbObj()
    {
        include_once(ROOT_DIR . "component/basket.db.class.php");
        $this->_basketDbObj = new basket_db();

    }

    /**
     * Remove Invoice based on BasketID
     * @return  mixed
     * @param mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    private function _removeInvoice($BasketID)
    {
        global $conn, $lang;
        $this->getBasketDbObj();

        $result = $this->_basketDbObj->removeBasketDB($BasketID);

        unset($this->_basketDbObj);
        if ($result == -1) {
            $result['result'] = -1;
            $result['no'] = 2;
            return $result;
        }
        $result['result'] = 1;
        return $result;
    }

    /**
     * Add Package To Basket
     * @return  mixed
     * @param mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    private function _addPackageToBasket()
    {

        global $conn, $lang;
        $this->getBasketDbObj();
        $result = $this->_basketDbObj->set_basketFields($this->_basketInfo);

        if ($result['result'] == -1) {
            return $result;
        }

        $result = $this->_basketDbObj->addPackageToBasketDB();

        unset($this->_basketDbObj);

        if ($result == -1) {
            $result['result'] = -1;
            $result['no'] = 2;
            return $result;
        }

        $result['result'] = 1;
        return $result;
    }

    /**
     * Get Basket List
     * @param $input
     * @return mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    private function _getBasketList($input)
    {
        global $conn, $admin_info, $company_info;
        $comp_id = $input['comp_id'];
        $invoice_id = $input['invoice_id'];

        if ($comp_id == '') {
            $comp_id = $company_info['comp_id'];
        }

        $this->getBasketDbObj();
        $result = $this->_basketDbObj->getBaskets($input);

        if ($result['result'] != 1) {
            return $result;
        }

        $this->_paging = $this->_basketDbObj->paging;
        $basket_list = $this->_basketDbObj->basketListDb;
        include_once(ROOT_DIR . "component/packageLog.operation.class.php");
        $invoice = new packageLog_operation();
        $result = $invoice->getLastPackage($company_info['comp_id']);//ghalat ast bayad az to basket khande shabvad

        if ($result['result'] == -1 && $result['no'] == 1000) {
            $startDate = date("Y-m-d H:i:s");
            $expireDate = '';
        } else {
            $keys = array_keys($invoice->InvoiceList);
            $expireDate = $invoice->InvoiceList[$keys['0']]['expire_date'];
            $startDate = date("Y-m-d H:i:s", strtotime("+1 second", strtotime($expireDate)));
        }


        foreach ($basket_list as $key => $value) {
            $this->_basketList[$key]['duration'] = $value['product_detail']->duration;
            $newExpiryDate = date("Y-m-d H:i:s", strtotime("+" . $this->_basketList[$key]['duration'], strtotime($startDate)));
            $this->_basketList[$key]['start_date'] = $startDate;
            $this->_basketList[$key]['expire_date'] = $expireDate;
            $this->_basketList[$key]['new_expire_date'] = $newExpiryDate;
            $this->_basketList[$key]['package_name'] = $value['product_detail']->package_name;
            $this->_basketList[$key]['extension_count'] = $value['product_detail']->extension_count;
            $this->_basketList[$key]['price'] = $value['product_detail']->price;
            $this->_basketList[$key]['status'] = $value['status'];
            $this->_basketList[$key]['total_price'] = $this->_calculateTax($value['price']);
            $this->_basketList[$key]['issue_date'] = $value['issue_date'];
            $this->_basketList[$key]['invoice_id'] = $value['invoice_id'];
            $this->_basketList[$key]['order_for'] = $value['order_for'];
            $this->_basketList[$key]['package_id'] = $value['package_id'];
        }

        // unset($this->_basketDbObj);
        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }


    /**
     * Calculate Tax
     * @param  $price
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    private function _calculateTax($price)
    {
        $price = ($price * VAT) / 100 + $price;
        return $price;
    }


    /**
     * Get Salable Package List By ID
     * @param  $input
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    private function _getSalablePackageListById($input)
    {

        $this->getBasketDbObj();
        $result = $this->_basketDbObj->getSalablePackageListById($input);

        if ($result['result'] == -1) {
            return $result;
        }

        $this->_basketInfo = $this->_basketDbObj->basketFields;

        unset($this->_queueDbObj);
        $result['result'] = 1;
        $result['no'] = 2;
        return $result;

    }

    /**
     * Send Invoice
     * @param  $compID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    private function _sendInvoice($compID)
    {
        $this->getBasketDbObj();
        $result = $this->_basketDbObj->sendInvoice($compID);

        if ($result['result'] == -1) {
            return $result;
        }

        $this->_basketInfo = $this->_basketDbObj->basketListDb;
        unset($this->_queueDbObj);
        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }

}
