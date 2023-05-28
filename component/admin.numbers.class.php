<?php
/**
 * Created by PhpStorm.
 * User: FaridCS
 * Date: 11/8/2014
 * Time: 3:46 PM
 */

class numbers extends DataBase
{
    private $_number;

    /**
     * explain : construct of class
     */
    public function __construct() {

        $this->_number = array(
            'id',
            'call_status',
            'black_list',
            'camp_id',
            'number',
            'creation_time',
            'complet_time'
        );

    }

    /**
     * @param $property
     * @param $value
     * @return bool
     * @date 10/28/2014
     * @author f.vosoughi
     * @version 01.01.01
     */
    public function __set($property,$value) {
        switch ($property) {

            case 'addInfo' :
                $this->_set_addInfo($value);
                break;

            case 'editInfo' :
                $this->_set_editInfo($value);
                break;

            default :
                return false;
        }
    }

    /**
     * explain : call magic function of customer class
     * @param $methodName
     * @param $arguments
     * @return mixed
     */
    public function __call($methodName,$arguments)
    {
        $_Result = $this->_checkMethod($methodName);
        if($_Result[0]==1)
        {
            $_Result = $this->_set_Arguments($arguments);
            if($_Result[0]==1 || $_Result[0]==0)
            {
                $methodName = '_'.$methodName;
                $Result = $this->$methodName();
                return($Result);
                die();
            }
            elseif($_Result[0]==-1)
            {
                redirectPage(RELA_DIR.'index.php',$_Result['errMsg']);
                die();
            }
        }
        elseif($_Result[0]==0)
        {
            redirectPage(RELA_DIR.'index.php',$_Result['errMsg']);
            die();
        }
    }


    /**
     * @return mixed
     */
    private function _checkMethod()
    {
        $temp = func_get_args();
        if(method_exists($this,"_".$temp[0]))
        {
            $_Result[0] = 1;
            $_Result['Msg'] = ModelADMIN_46;
        }
        else
        {
            $_Result[0] = 0;
            $_Result['errMsg'] = "The Method (".$temp[0].") that you call is wrong";// For Test : The Method (".$temp[0].") that you call is wrong
        }
        return $_Result;
    }

    /**
     * @return mixed
     */
    private function _set_Arguments()
    {
        $temp = func_get_args();
        if(!empty($temp[0]))
        {
            if(count($temp[0])==1)
            {
                if(!empty($temp[0][0]))
                {
                    $this->_Arguments = handleData($temp[0][0]);
                }
                else
                {
                    $_Result[0] = -1;
                    $_Result['errMsg'] = ModelADMIN_58;
                    return $_Result;
                }

            }
            else {
                $_Result[0] = -1;
                $_Result['errMsg'] = ModelADMIN_58;
                return $_Result;
            }

            $_Result[0] = 1;
            $_Result['Msg'] = ModelADMIN_60;
            return $_Result;

        }
        else
        {
            $_Result[0] = 0;
            $_Result['Msg'] = ModelADMIN_61;
            return $_Result;
        }
    }

    /**
     * @param $property
     * @return mixed
     * @date 10/28/2014
     * @author f.vosoughi
     * @version 01.01.01
     */
    public function __get($property) {
        if (property_exists($this,$property)) {
            return $this->$property;
        } else {
            return false;
        }
    }

    /**
     * set add black list info
     */
    private function _set_addInfo() {
        $temp = func_get_args();
        $temp = $temp[0];

        $this->_blackList['number']  = handleData($temp['number']);
        $this->_blackList['isblack'] = handleData($temp['status']);
        $this->_blackList['camp_id']  = handleData($temp['campaign']);

    }

    /**
     * set edit black list info
     */
    private function _set_editInfo() {
        $temp = func_get_args();
        $temp = $temp[0];

        $this->_blackList['id']      = handleData($temp['editId']);
        $this->_blackList['number']  = handleData($temp['numberEdit']);
        $this->_blackList['isblack'] = handleData($temp['statusEdit']);
        $this->_blackList['camp_id'] = handleData($temp['campaignEdit']);

    }

    /**
     * explain : get Number
     * @return mixed
     * @author f.vosoughi
     * @version 01.01.01
     * @date 11/8/2014
     */

    public function getNumber() {
        $conn = parent::getConnection();
        $camp = array();

        $sql = "SELECT * FROM `required_camp` WHERE 1";

        $rs = $conn->query($sql);

        if(!$rs)
        {
            print_r($conn->errorInfo());
            die();
        }

        $obj = $rs->fetchAll(PDO::FETCH_ASSOC);

        foreach( $obj as $v )
        {
            $camp[$v['id']]['name'] = $v['name'];
        }

        $result['campaigns'] = $camp;
        return $result;
    }


    /**
     * explain : Show List
     * @return mixed
     * @author f.vosoughi
     * @version 01.01.01
     * @date 11/8/2014
     */
    public function listNumber() {
        parent::getConnection();

        $aColumns = array( 'number', 'call_status', 'black_list', 'camp_id', 'creation_time', 'complet_time' );

        parent::get('numbers', 'id',$aColumns);
    }

}