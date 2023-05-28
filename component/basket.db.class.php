<?php
/**
 * @author Malekloo Izadi Sakhamanesh <Izadi@dabacenter.ir>
 * @version 0.0.1 this is the beta version of sip
 * @copyright 2015 The Imen Daba Parsian Co.
 */
class basket_db extends DataBase
{
    /** Contains each field
     * @var
     */
    private $_basketFields;

    /** Contains each field
     * @var
     */
    private  $_paging;
    /**
     * Contains sip list
     * @var array
     */
    private $_basketListDb;
    /**
     * Contains sip list
     * @var array
     */
    private $_IDs;


    /**
     * Specifies the type of output
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function __construct()
    {
        $this->_basketListDb = array();
    }


    /**
     * Specifies the type of output
     * @param   $method
     * @param   $args
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    function __call($method, $args)
    {

        $method = '_' . $method;

        if (method_exists($this, $method)) {
            switch ($method) :

                case "_getBaskets" :
                    return $this->_getBaskets($args['0']);
                    break;
                case "_addPackageToBasketDB" :
                    return $this->_addPackageToBasketDB();
                    break;
                case "_removeBasketDB" :
                    return $this->_removeBasketDB($args['0']);
                    break;
                case "_set_basketFields" :
                    return $this->_set_basketFields($args['0']);
                    break;
                case "_getSalablePackageListById" :
                    return $this->_getSalablePackageListById($args['0']);
                    break;
                case "_sendInvoice" :
                    return $this->_sendInvoice($args['0']);
                    break;

            endswitch;
        }

    }


    /**
     * Specifies the type of output
     * @param $property
     * @param $value
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    public function __set($property, $value)
    {
        switch($property)
        {
            case 'paging':
                $this->_paging=$value;

                break;
            default:
                $this->_set_basketFields(array($property=>$value));
                break;
        }
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
        switch ($field)
        {
            case 'basketListDb':

                return $this->_basketListDb;
                break;
            case 'basketFields':
                return $this->_basketFields;
                break;
            case 'paging':
                return $this->_paging;
                break;
            default:
                break;
        }
    }


    /**
     * Specifies the type of output
     * @param $BasketID
     * @param   $value
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    private function _set_basketListDb($BasketID,$value = '')
    {
        if (!empty($BasketID) && is_numeric($BasketID) && is_array($value))
        {
            $this->_basketListDb[$BasketID] = $value;
        }

        $result['result'] = 1;
        return $result;
    }

    /**
     * Specifies the type of output
     * @param $insertedId
     * @param $value
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    private function _set_insertBasketDB($insertedId, $value = '')
    {
        if (!empty($insertedId) && is_numeric($insertedId) && is_array($value))
        {
            $this->_basketFields[$insertedId] = $value;
        }
    }

    /**
     * Specifies the type of output
     * @param $value
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    private function _set_basketFields($value = '')
    {
        $this->_basketFields = $value;
        $result['result'] = 1;
        $result['no'] = 1;
        return $result;

    }

    /**
     * Specifies the type of output
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function _checkPermission()
    {


    }


    /**
     * Gets Basket Content
     * @param  $input
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.02.02
     * @since   01.01.01
     * @date    08/08/2015
     */
    private function _getBaskets($input)
    {
        global $lang, $admin_info,$company_info;



        $comp_id    =   $input['comp_id'];
        $invoice_id =   $input['invoice_id'];

        if($comp_id=='')
        {
            $comp_id=$company_info['comp_id'] ;
        }


        $this->_checkPermission();
        $conn = parent::getConnection();

        if($invoice_id!='')
        {
            $append_sql= " and invoice_id='".$invoice_id. "' ";
        }else
        {
            $append_sql= " and invoice_id='' ";
        }

        $sql = "SELECT *
                FROM  tbl_basket
                WHERE comp_id = '".$comp_id."'".$append_sql." ";


        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        if (!$stmt)
        {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }

        while ($row = $stmt->fetch())
        {
            $row['product_detail'] = json_decode($row['product_detail']);
            $this->_set_basketListDb($row['basket_id'], $row);
        }

        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }

    /**
     * Gets Basket by invoice ID
     * @param  $invoice_id
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.02.02
     * @since   01.01.01
     * @date    08/08/2015
     */
    private function _getBasketsByInvoiceId($invoice_id)
    {
        global $lang, $admin_info;

        if($invoice_id=='')
        {
            $result['result'] = -1;
            $result['no'] = 2;
            return $result;
        }

        $this->_checkPermission();
        $conn = parent::getConnection();

        $sql = "SELECT
                    `basket_id` as basket_id,
                    `product_detail` as product_detail,
                    `status` as status,
                    `comp_id` as comp_id,
                    `price` as price,
                    `issue_date` as issue_date,
                    `invoice_id` as invoice_id
                FROM
                    tbl_basket
                WHERE invoice_id = '".$invoice_id."'";

        //or WHERE    news_id='$id' ");
        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        if (!$stmt)
        {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }

        //echo $stmt->rowCount();
        //echo $stmt->rowCount();
        while ($row = $stmt->fetch()) {
            $row['product_detail'] = json_decode($row['product_detail']);
            $this->_set_basketListDb($row['basket_id'], $row);
        }

        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }


    /**
     * Remove Basket DB
     * @param $BasketID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    private function _removeBasketDB($BasketID)
    {
        global $lang,$conn;
        $conn = parent::getConnection();

        $sql = "
           DELETE
           FROM 	tbl_basket
		   WHERE    basket_id = '$BasketID'";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if (!$stmt)
        {
            $result['result'] = -1;
            $result['Number'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }

        $result['result'] = 1;
        return $result;
    }

    /**
     * Add Package To Basket DB
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    private function _addPackageToBasketDB()
    {
        $this->_basketFields['product_detail']['assign_date'] = $this->_basketFields['assign_date'];
        $this->_basketFields['product_detail']['duration'] = $this->_basketFields['duration'];
        $this->_basketFields['product_detail']['package_name'] = $this->_basketFields['package_name'];
        $this->_basketFields['product_detail']['extension_count'] = $this->_basketFields['extension_count'];
        $this->_basketFields['product_detail']['price'] = $this->_basketFields['price'];
        $this->_basketFields['product_detail'] = json_encode($this->_basketFields['product_detail']);

        global $lang,$conn;
        $conn = parent::getConnection();
        $date = date('Y-m-d H:i:s');


        $sql = "
           DELETE
           FROM 	tbl_basket
		   WHERE    comp_id = '". $this->_basketFields['comp_id']."'";

        $stmt_delete = $conn->prepare($sql);
        $stmt_delete->execute();

        $sql = "
           INSERT INTO tbl_basket(
                                status,
                                package_id,
                                price,
                                comp_id,
                                product_detail,
                                issue_date,
                                order_for
                            )
       VALUES(      '" . $this->_basketFields['package_status'] . "',
                    '" . $this->_basketFields['package_id']. "',
                    '" . $this->_basketFields['price']. "',
                    '" . $this->_basketFields['comp_id'] . "',
                    '" . $this->_basketFields['product_detail'] . "',
                    '" . $date . "',
                    '" . $this->_basketFields['order_for'] . "'

           )";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if (!$stmt)
        {

            $result['result'] = -1;
            $result['Number'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }

        $result['result'] = 1;
        return $result;
    }


    /**
     * Get Salable Package List By Id
     * @param $input
     * @return mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getSalablePackageListById($input)
    {
        global $lang;
        $conn = parent::getConnection();
        $PackageID=$input['package_id'];
        $comp_id=$input['comp_id'];

        $sql = "SELECT
                `tbl_package`.*,
                `tbl_package_group_company`.`comp_id`,
                `tbl_package_group_company`.`assign_date`,
                `tbl_package_group`.`package_group_name`
                FROM
                `tbl_package_group_company`
                INNER JOIN `tbl_package_group_relation`
                ON `tbl_package_group_company`.`package_group_id` =
                `tbl_package_group_relation`.`package_group_id`
                INNER JOIN `tbl_package` ON `tbl_package_group_relation`.`package_id` =
                `tbl_package`.`id`
                INNER JOIN `tbl_package_group`
                ON `tbl_package_group_relation`.`package_group_id` =
                `tbl_package_group`.`package_group_id`
                WHERE
                 `tbl_package_group_company`.`comp_id` = '".$comp_id."' AND
                `tbl_package`.`id`= '$PackageID'";


        //or WHERE    news_id='$id' ");
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if (!$stmt)
        {
            $result['result'] = -1;
            $result['Number'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }

        if (!$stmt->rowCount())
        {
            $result['result'] = -1;
            $result['Number'] = 1;
            $result['msg'] = ModelADMIN_62;
            return $result;
        }

        $row = $stmt->fetch();
        $this->_set_basketFields($row);
        $result['result'] = 1;
        return $result;
    }


    /**
     * Send Invoice
     * @param $compID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _sendInvoice($compID)
    {
        global $lang;
        $invoiceNo= uniqid();
        $conn = parent::getConnection();

        $sql = "
                UPDATE tbl_basket
                SET
                invoice_id =   '" . $invoiceNo . "'
                WHERE comp_id = $compID and invoice_id='';
                ";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        if (!$stmt)
        {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = 'DB error : ' . $conn->errorInfo();
            return $result;
        }

        $this->_getBasketsByInvoiceId($invoiceNo);
        $result['result'] = 1;
        $result['Number'] = 2;
        return $result;
    }


}
