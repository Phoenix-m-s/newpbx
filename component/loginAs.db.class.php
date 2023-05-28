<?php
/**
 * @author Malekloo Izadi Sakhamanesh <Izadi@dabacenter.ir>
 * @version 0.0.1 this is the beta version of News
 * @copyright 2015 The Imen Daba Parsian Co.
 */
class loginAs_db extends DataBase
{


    /** Contains each field
     * @var
     */
    private $_companyFields;

    /** Contains each field
     * @var
     */
    private $_groupCompany;

    /**
     * Contains company list
     * @var array
     */
    private $_companyListDb;
    /**
     * Contains company list
     * @var array
     */
    public $subCompanies;
    /**
     * Contains company list
     * @var array
     */
    private $_paging;
    /**
     * Contains company list
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
        $this->_companyListDb = array();
        $this->_groupCompany = array();
    }


    /**
     * Specifies the type of output
     * @param $method
     * @param $args
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    function __call($method, $args)
    {

        $method = '_' . $method;

        if (method_exists($this, $method)) {
            switch ($method) :
                case "_set_loginAsFields" :
                    return $this->_set_loginAsFields($args['0']);
                    break;
                case "_insertLoginAsDB" :
                    return $this->_insertLoginAsDB();
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
     * @date    08/08/2015
     */
    public function __set($property, $value)
    {

        switch ($property) {
            case '_groupCompany':
                $this->_groupCompany = $value;
                break;
        }

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
                return $this->_companyListDb;
                break;
            case 'companyFields':
                return $this->_companyFields;
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
     * @param $companyID
     * @param $value
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _set_companyListDb($companyID, $value = '')
    {
        if (!empty($companyID) && is_numeric($companyID) && is_array($value)) {

            $this->_companyListDb[$companyID] = $value;

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
     * @date    08/08/2015
     */
    private function _set_InsertCompanyDB($insertedId, $value = '')
    {
        if (!empty($insertedId) && is_numeric($insertedId) && is_array($insertedId)) {
            $this->_companyFields[$insertedId] = $value;
        }

    }


    /**
     * Specifies the type of output
     * @param $value
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _set_loginAsFields($value = '')
    {
        $this->_companyFields = $value;
        $result['result'] = 1;
        $result['no'] = 1;
        return $result;
    }


    /**
     * Get Hash
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private static function GetHash()
    {
        return '%%1^^@@REWcmv21))--';
    }

    function encrypt($string, $key)
    {
        $result = '';
        for($i=0; $i<strlen($string); $i++)
        {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key))-1, 1);
            $char = chr(ord($char)+ord($keychar));
            $result.=$char;
        }

        return base64_encode($result);
    }

    function decrypt($string, $key)
    {
        $result = '';
        $string = base64_decode($string);

        for($i=0; $i<strlen($string); $i++)
        {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key))-1, 1);
            $char = chr(ord($char)-ord($keychar));
            $result.=$char;
        }

        return $result;
    }


    /**
     * Insert Login As DB
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _insertLoginAsDB()
    {
        global $admin_info;
        $conn = parent::getConnection();

        $sql = "
           DELETE
           FROM 	login_as
		   WHERE    session_id= '".$this->_companyFields['session_id']."'";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        if (!$stmt)
        {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = 'DB error : ' . $conn->errorInfo();
            return $result;
        }
        $sql = "
                    INSERT INTO login_as(
                    ascomp_id,comp_id,admin_id,last_access_time,session_id
                    )
                    VALUES(
                    '" .$this->_companyFields['ascomp_id'] . "',
                    '".$this->_companyFields['comp_id']."',
                    '".$this->_companyFields['admin_id']."',
                    '".$this->_companyFields['last_access_time']."',
                    '".$this->_companyFields['session_id']."'
                    )";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        if (!$stmt)
        {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = 'DB error : ' . $conn->errorInfo();
            return $result;
        }

        $insertedId = $conn->lastInsertId();
        $this->_companyFields['comp_id'] = $insertedId;
        $this->_set_InsertCompanyDB($insertedId, $this->_companyFields);
       // redirectPage('')
        $result['result'] = 1;
        $result['Number'] = 2;
        return $result;
    }
}
