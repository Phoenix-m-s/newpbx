<?php
/**
 * @author Malekloo Izadi Sakhamanesh <Izadi@dabacenter.ir>
 * @version 0.0.1 this is the beta version of News
 * @copyright 2015 The Imen Daba Parsian Co.
 */
class dstOption_db extends DataBase
{
    /** Contains each field
     * @var
     */
    private $_dstOptionFields;
    /**
     * Contains company list
     * @var array
     */
    private $_dstOptionListDb;

    /**
     * Specifies the type of output
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function __construct()
    {
        $this->_dstOptionListDb = array();
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
                case "_getDstOption" :
                    return $this->_getDstOption($args['0']);
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

            case 'dstOptionList':
                return $this->_dstOptionListDb;

                break;
            case 'dstOptionFields':
                return $this->_dstOptionFields;
                break;
            default:
                break;
        }
    }


    /**
     * Specifies the type of output
     * @param $dstOptionID
     * @param $value
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _set_dstOptionListDb($dstOptionID, $value = '')
    {
        if (!empty($dstOptionID) && is_numeric($dstOptionID) && is_array($value))
        {
            $this->_dstOptionListDb[$dstOptionID] = $value;
        }
        $result['result'] = 1;
        return $result;
    }

    /**
     * Gets get DST Option
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getDstOption()
    {
        global $lang;

        $conn = parent::getConnection();

        $sql = "SELECT
                    `dst_option_id` as DstOptionID,
                    `option_value` as OptionValue
                FROM
                     tbl_dst_option";

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

        while ($row = $stmt->fetch())
        {
            $this->_set_dstOptionListDb($row['DstOptionID'], $row);
        }

        $result['result'] = 1;
        $result['no'] = 2;
        //$result['list']=$fields;
        return $result;

    }
}
