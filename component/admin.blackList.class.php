<?php
/**
 * Created by PhpStorm.
 * User: FaridCS
 * Date: 11/6/2014
 * Time: 11:25 AM
 */

class blackList extends DataBase
{
    private $_blackList;

    /**
     * explain : construct of class
     */
    public function __construct() {

        $this->_blackList = array(
            'id',
            'number',
            'isblack',
            'camp_id',
            'date'
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
            $_Result['Msg'] = ModelADMIN_29;
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
                    $_Result['errMsg'] = ModelADMIN_25;
                    return $_Result;
                }

            }
            else {
                $_Result[0] = -1;
                $_Result['errMsg'] = ModelADMIN_25;
                return $_Result;
            }

            $_Result[0] = 1;
            $_Result['Msg'] = ModelADMIN_27;
            return $_Result;

        }
        else
        {
            $_Result[0] = 0;
            $_Result['Msg'] = ModelADMIN_28;
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
        $this->_blackList['date']  = handleData($temp['date']);

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
     * explain : Show black List
     * @return mixed
     * @author f.vosoughi
     * @version 01.01.01
     * @date 11/6/2014
     */
    public function blackList() {
        parent::getConnection();

        $aColumns = array( 'number', 'isblack', 'camp_id', 'date', 'id');

        parent::get('blacklist', 'id',$aColumns);
    }

    /**
     * explain : get Campaign
     * @return mixed
     * @author f.vosoughi
     * @version 01.01.01
     * @date 11/6/2014
     */
    public function getCamp() {
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
     * explain : add To black List and update number
     * @return mixed
     * @author f.vosoughi
     * @version 01.01.01
     * @date 11/8/2014
     */
    private function _addToList() {
        $conn = parent::getConnection();

        // add number
        $sql = "INSERT INTO `blacklist`(`number`, `isblack`, `camp_id`,`date`)
                VALUES ('".$this->_blackList['number']."','".$this->_blackList['isblack']."',".$this->_blackList['camp_id'].",NOW())";

        $result = $conn->prepare($sql);

        $result = $result->execute();

        if(!$result)
        {
            print_r($conn->errorInfo());
            die();
        }

        // update number black status
        $sql = "UPDATE `numbers` SET `black_list`= 't'
                WHERE `number` = '".$this->_blackList['number']."'";

        $updateRS = $conn->prepare($sql);

        $updateRS = $updateRS->execute();

        if(!$updateRS)
        {
            print_r($conn->errorInfo());
            die();
        }

        redirectPage(RELA_DIR."blackList.php","");
    }

    /**
     * explain : edit To black List
     * @return mixed
     * @author f.vosoughi
     * @version 01.01.01
     * @date 11/8/2014
     */
    private function _editToList() {
        $conn = parent::getConnection();

        // edit number
        $sql = "UPDATE `blacklist` SET `number`= '".$this->_blackList['number']."',
                       `isblack`= '".$this->_blackList['isblack']."',
                       `camp_id`= ".$this->_blackList['camp_id']."
                WHERE `id` = ".$this->_blackList['id']."";

        $result = $conn->prepare($sql);

        $result = $result->execute();

        if(!$result)
        {
            print_r($conn->errorInfo());

        }

        redirectPage(RELA_DIR."blackList.php","");
    }

    /**
     * explain : delete number from black List
     * @return mixed
     * @author f.vosoughi
     * @version 01.01.01
     * @date 11/8/2014
     */
    public function deleteBlackList($id) {
        $conn = parent::getConnection();

        // delete number
        $sql = "DELETE FROM `blacklist` WHERE `id` = :user_id";

        $result = $conn->prepare($sql);
        $result = $result->execute(array('user_id' => $id));

        if(!$result)
        {
            print_r($conn->errorInfo());
            die();
        }

        redirectPage(RELA_DIR."blackList.php","");
    }

}