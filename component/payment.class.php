<?php
/**
 * Created by PhpStorm.
 * User: Izadi
 * Date: 11/18/2014
 * Time: 1:39 PM
 */

class payment extends DataBase
{

    /** Contains price
     *
     * @var
     */
    private $_amount;

    /** Contains unique ID
     *
     * @var
     */
    private $_uniqueID;

    /** Contains serial Number
     *
     * @var
     */
    private $_serialID;

    /** Contains username of bank
     *
     * @var
     */
    private $_merchantID;

    /** Contains Reference Number
     *
     * @var
     */
    private $_RefNum;

    /** Contains password of bank
     *
     * @var
     */
    private $_merchantPass;

    /** Contains password of bank
     *
     * @var
     */
    private $_productDetail;

    /** Bank errors
     *
     * @var
     */
    public $errorVerify = array(
        '-1' => ModelPAYMENT_01,
        '-2' => ModelPAYMENT_02,
        '-3' => ModelPAYMENT_03,
        '-4' => ModelPAYMENT_04,
        '-5' => ModelPAYMENT_05,
        '-6' => ModelPAYMENT_06,
        '-7' => ModelPAYMENT_07,
        '-8' => ModelPAYMENT_08,
        '-9' => ModelPAYMENT_09,
        '-10' => ModelPAYMENT_10,
        '-11' => ModelPAYMENT_11,
        '-12' => ModelPAYMENT_12,
        '-13' => ModelPAYMENT_13,
        '-14' => ModelPAYMENT_14,
        '-15' => ModelPAYMENT_15,
        '-16' => ModelPAYMENT_16,
        '-17' => ModelPAYMENT_17,
        '-18' => ModelPAYMENT_18
    );

    /**
     * Contains file type
     *
     * @var
     */
    public $exportType;

    /**
     * Contains file name
     *
     * @var
     */
    public $fileName;

    function __construct()
    {

        include_once(ROOT_DIR . "common/bankConfig.php");
        $this->_merchantID = $merchantID;
        $this->_merchantPass = $merchantPass;
    }

    /**
     * Specifies the type of output
     *
     * @param $list
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    public function template($list = [], $msg = '')
    {
        global $conn, $lang;
        switch ($this->exportType) {
            case 'html':
                include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_start.tpl");
                include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_header.tpl");
                include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_rightMenu.tpl.php");
                include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/$this->fileName");
                include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_footer.tpl");
                include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_end.tpl");
                break;

            case 'json':
                return;
                break;
            default:
                break;
        }

    }

    /**
     *Online Payment
     *
     * @param $serialID
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    03/01/2016
     */
    public function onlinePayment($serialID)
    {
        $resultSerial = $this->getBasketBySerial($serialID);

        if ($resultSerial['result'] == - 1) {
            return $resultSerial['msg'];
        }

        $resultPayment = $this->insertToOnlinePayment();

        if ($resultPayment['result'] == - 1) {
            return $resultPayment['msg'];
        }

        $resultToken = $this->getTokenRequest();

        if ($resultToken['result'] == - 1) {
            return $resultToken['msg'];
        }

        $insertToken = $this->updateOnlinePaymentWithToken($resultToken['tokenResult']);

        if ($insertToken['result'] == - 1) {
            return $insertToken['msg'];
        }

        $result['result'] = 1;
        $result['no'] = 2;

        include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/payment_online_addForm.php");

        return $result;
    }

    /**
     * Get Price and product detail By Serial from basket
     *
     * @param $serialID
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    03/01/2016
     */
    private function getBasketBySerial($serialID)
    {
        global $lang, $conn;
        $conn = parent::getConnection();
        $this->_serialID = $serialID;

        $sql = "
           SELECT   *
           FROM 	tbl_basket
		   WHERE    invoice_id = '$this->_serialID'";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if (!$stmt) {
            $result['result'] = - 1;
            $result['Number'] = 1;
            $result['msg'] = $conn->errorInfo();

            return $result;
        }

        while ($row = $stmt->fetch()) {
            $this->_amount = $row['price'];
            $this->_productDetail = $row['product_detail'];
        }

        $result['result'] = 1;
        $result['no'] = 2;

        return $result;
    }


    /**
     * Get total amount by Res Num
     *
     * @param $uniqueID
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    03/01/2016
     */
    private function getInfoByResNum($uniqueID)
    {
        global $lang, $conn;
        $conn = parent::getConnection();
        $this->_uniqueID = $uniqueID;

        $sql = "
           SELECT   *
           FROM 	online_payment
		   WHERE    res_num = '$this->_uniqueID'";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if (!$stmt) {
            $result['result'] = - 1;
            $result['Number'] = 1;
            $result['msg'] = $conn->errorInfo();

            return $result;
        }

        $row = $stmt->fetch();
        $this->_amount = $row['total_amount'];
        $this->_serialID = $row['invoice_id'];
        $result['result'] = 1;
        $result['no'] = 2;

        return $result;
    }

    /**
     * Insert To Online Payment
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    03/01/2016
     */
    private function insertToOnlinePayment()
    {
        global $lang, $conn, $admin_info, $company_info;
        $conn = parent::getConnection();
        $compID = $company_info['comp_id'];
        $this->_uniqueID = uniqid();


        $sql = "
                INSERT INTO online_payment(
                               total_amount,
                               res_num,
                               invoice_id,
                               product_detail,
                               comp_id)
                VALUES(
                            '" . $this->_amount . "',
                            '" . $this->_uniqueID . "',
                            '" . $this->_serialID . "',
                            '" . $this->_productDetail . "',
                            '" . $compID . "'
                            )";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if (!$stmt) {
            $result['result'] = - 1;
            $result['Number'] = 1;
            $result['msg'] = $conn->errorInfo();

            return $result;
        }

        $result['result'] = 1;
        $result['Number'] = 2;

        return $result;
    }

    /**
     * Get Token Request
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    03/01/2016
     */
    private function getTokenRequest()
    {
        global $lang, $conn;
        $conn = parent::getConnection();

        $this->_merchantID = "10370175";
        $this->_merchantPass = "5128755";

        $soapClient = new SoapClient('https://sep.shaparak.ir/Payments/InitPayment.asmx?WSDL');

        $tokenResult = $soapClient->RequestToken("$this->_merchantID", "$this->_uniqueID", "$this->_amount");

        if (in_array($tokenResult, array_keys($this->errorVerify))) {
            $result['msg'] = $this->errorVerify[$tokenResult];
            $result['result'] = - 1;
            $result['no'] = $tokenResult;

            return $result;
        }

        $result['result'] = 1;
        $result['tokenResult'] = $tokenResult;

        return $result;
    }

    /**
     * Update Online Payment With Token
     *
     * @param  $token
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    03/01/2016
     */
    private function updateOnlinePaymentWithToken($token)
    {
        global $lang, $conn;

        $conn = parent::getConnection();

        $sql = "UPDATE online_payment
                SET    token =   '" . $token . "',
                       status =   1
                WHERE `res_num` = '{$this->_uniqueID}'
                      ";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if (!$stmt) {
            $result['result'] = - 1;
            $result['Number'] = 1;
            $result['msg'] = $conn->errorInfo();

            return $result;
        }

        $result['result'] = 1;
        $result['Number'] = 2;

        return $result;
    }

    /**
     * Update Payment Status
     *
     * @param  $fields
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    03/01/2016
     */
    public function updatePaymentStatus($fields)
    {
        global $lang, $conn;

        $this->_RefNum = $fields['RefNum'];
        $this->_uniqueID = $fields['ResNum'];

        $conn = parent::getConnection();

        $sql = "UPDATE online_payment
                SET
                       bank_status =   '" . $fields['StateCode'] . "',
                       ref_num ='" . $fields['RefNum'] . "'
                WHERE `res_num` = '{$fields['ResNum']}'";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if (!$stmt) {
            $result['result'] = - 1;
            $result['Number'] = 1;
            $result['msg'] = $conn->errorInfo();

            return $result;
        }

        $result['result'] = 1;
        $result['Number'] = 2;

        return $result;
    }

    /**
     * Update Online Payment Status
     *
     * @param $error
     * @param $resNum
     * @param $status
     *
     * @return bool
     */
    private function updateOnlinePaymentStatus($error, $resNum, $status)
    {

        global $lang, $conn;
        $conn = parent::getConnection();

        $sql = "UPDATE `online_payment`
                SET    `bank_status`= '$error',
                       `status`= '$status'
                WHERE  `res_num` = '$resNum'
                ";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if (!$stmt) {
            $result['result'] = - 1;
            $result['Number'] = 1;
            $result['msg'] = $conn->errorInfo();

            return $result;
        }

        $result['result'] = 1;
        $result['Number'] = 2;

        return $result;
    }

    /**
     * Check Res Number
     *
     * @param  $fields
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    03/01/2016
     */
    public function checkResNumber($fields)
    {
        global $lang, $conn;

        $conn = parent::getConnection();

        $sql = "SELECT *
                FROM  online_payment
                WHERE `res_num` = '{$fields['ResNum']}'
                ";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);


        if (!$stmt) {
            $result['result'] = - 1;
            $result['Number'] = 1;
            $result['msg'] = $conn->errorInfo();

            return $result;
        }

        if (!$stmt->rowCount()) {
            $msg = ModelPAYMENT_19;
            $this->exportType = 'html';
            $this->fileName = 'basket.show.php';
            $this->template('', $msg);
            die();
        }

        $result['result'] = 1;
        $result['Number'] = 2;

        return $result;
    }

    /**
     * Insert Token and check for error
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    03/01/2016
     */
    public function verifyTrans()
    {

        $soapClient = new SoapClient('https://acquirer.samanepay.com/payments/referencepayment.asmx?WSDL');
        //$soapProxy  = $soapClient->getProxy();
        $result = false;

        for ($a = 1; $a < 6; ++ $a) {
            $result = $soapClient->verifyTransaction($this->_RefNum, $this->_merchantID);
            if ($result != false) {
                break;
            }
        }

        return $result;

    }


    /**
     * Reverse transaction
     *
     * @param $revNumber
     *
     * @return bool
     * @author faridcs
     * @date 5/28/2015
     * @version 01.01.01
     */
    protected function reverseTrans($revNumber)
    {
        if ($revNumber <= 0 or empty($this->_RefNum) or empty($this->_merchantID) or empty($this->_password)) {
            return false;
        }
        $soapClient = new SoapClient('https://acquirer.samanepay.com/payments/referencepayment.asmx?WSDL');
        //$soapProxy  = $soapClient->getProxy();
        $result = false;

        for ($a = 1; $a < 6; ++ $a) {
            $result = $soapClient->reverseTransaction($this->_RefNum, $this->_merchantID, $this->_password, $revNumber);
            if ($result != false)
                break;
        }

        return $result;
    }


    /**
     * Insert Token and check for error
     *
     * @param  $verify
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    03/01/2016
     */
    public function errorCheck($verify)
    {

        $result = $this->getInfoByResNum($this->_uniqueID);

        if ($result['result'] == - 1) {
            return $result['msg'];
        }


        $result = $this->updateOnlinePaymentStatus($verify, $this->_uniqueID, $status = 2);

        if ($result['result'] == - 1) {
            return $result['msg'];
        }

        if ($verify > 0) {

            if ($verify == $this->_amount) {
                $result = $this->updateOnlinePaymentStatus($verify, $this->_uniqueID, $status = 3);

                if ($result['result'] == - 1) {
                    return $result['msg'];
                }

                include_once(ROOT_DIR . "component/packageLog.operation.class.php");
                $packageLog = new packageLog_operation();
                $result = $packageLog->addInvoiceToLog($this->_serialID);

                if ($result['result'] == - 1) {
                    return $result['msg'];
                }

                redirectPage(RELA_DIR . "packageLog.php", ModelPAYMENT_20);

            } else {
                $result = $this->updateOnlinePaymentStatus($verify, $this->_uniqueID, $status = - 1);
                if ($result['result'] == - 1) {
                    return $result['msg'];
                }

                $rev = $this->reverseTrans($verify);

                if ($rev == 1) {
                    $msg = ModelPAYMENT_21;
                    $this->exportType = 'html';
                    $this->fileName = 'basket.show.php';
                    $this->template('', $msg);
                    die();
                } else {
                    $msg = ModelPAYMENT_22;
                    $this->exportType = 'html';
                    $this->fileName = 'basket.show.php';
                    $this->template('', $msg);
                    die();
                }

            }

        } elseif ($verify < 0 or $verify == false) {
            $result = $this->updateOnlinePaymentStatus($verify, $this->_uniqueID, $status = - 1);

            if ($result['result'] == - 1) {
                return $result['msg'];
            }

            $msg = ModelPAYMENT_23;
            $this->exportType = 'html';
            $this->fileName = 'basket.show.php';
            $this->template('', $msg);
            die();
        }
    }

}



