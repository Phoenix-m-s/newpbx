<?php

class clsPermissionsPage
{
    private $_action;
    private $_startPoint;
    private $_scriptName;
    private $_index;
    private $_base;


//******************************************
    function __construct($index, $base, $scriptName = '')
    {
        $this->_setPoint($index, $base);

        if (strlen($scriptName) == 0) {
            $this->_scriptName = pathinfo($_SERVER['SCRIPT_NAME'], PATHINFO_FILENAME);
        } else {
            $this->_scriptName = $scriptName;
        }


    }

//******************************************
    public function __get($field)
    {
        if ($field == 'action') {
            return $this->_action;
        }


    }

//******************************************
    function __call($method, $args)
    {


        $method = '_' . $method;

        if (method_exists($this, $method)) {
            switch ($method) :
                case "_addAction" :
                    return $this->$method($args[0]);
                    break;
                case "_check" :
                    return $this->$method($args);
                    break;
                case "_getPointAction" :
                    return $this->$method($args[0]);
                    break;


            endswitch;
        }

    }

//******************************************
    private function _setPoint($index, $base)
    {

        $this->_index = $index;
        $this->_base = $base;
        $this->_startPoint = ($index - 1) * $base + 1;
    }

//*****************************************
    private function _setAction($args)
    {

        $this->_action[$args['action']]['action'] = $args['action'];//_setActionAction($args['action']);
        $this->_action[$args['action']]['code'] = $args['code'];//_setActioncode($args['code']);
        $this->_action[$args['action']]['label'] = $args['label'];    //_setActionlabel($args['label']);

    }

//******************************************
    private function _addAction($args)
    {
        $this->_setAction($args);
        $return['result'] = 1;
        $return['msgNo'] = 1;
        $return['msg'] = "Permission Added Successfully";
        return $return;

    }

//******************************************
    private function _getPointAction($args)
    {

        return ($this->_startPoint + $this->_action[$args]['code'] - 1);

    }


//******************************************
    private function _check($args)
    {
        $action = $args[0];
        $code = $args[1];
        //echo '<pre/>';
        //print_r($this->_action[$action]);
        //die();
        if (isset($this->_action[$action])) {
            //$this->_action[$action]['code'].'<br/>';
            //print_r_debug($code[$this->_startPoint + ($this->_action[$action]['code']) - 2);
            //print_r_debug($code[$this->_startPoint + ($this->_action[$action]['code']) - 2] );
            if ($code[$this->_startPoint + ($this->_action[$action]['code']) - 2] == 1) {

                $return['result'] = 1;
                $return['msgNo'] = 2;
                $return['msg'] = "";
                //print_r_debug($return);
                return $return;


            } else {


                $return['result'] = -1;
                $return['msgNo'] = 3;
                $return['msg'] = "You Dont Have Permission To Access This " . $action;
                //print_r_debug($return);
                return ($return);


            }
        }


    }

//******************************************

}


//******************************************
function getAllPermisssion()
{
    $len = COUNT_PERMISSION;
    $PagePermission['index'] = new clsPermissionsPage(1, $len);
    $PagePermission['index']->addAction(array('action' => 'show', 'code' => 1, 'label' => 'view'));//showAdminList

//******************************************announce*****************************************//
    $PagePermission['announce'] = new clsPermissionsPage(2, $len);
    $PagePermission['announce']->addAction(array('action' => 'showAllAnnounce', 'code' => 1, 'label' => 'view'));
    $PagePermission['announce']->addAction(array('action' => 'editAnnounce', 'code' => 2, 'label' => 'edit'));
    $PagePermission['announce']->addAction(array('action' => 'addAnnounce', 'code' => 3, 'label' => 'create'));
    $PagePermission['announce']->addAction(array('action' => 'deleteAnnounce', 'code' => 4, 'label' => 'delete'));

//******************************************showReport*****************************************//
    $PagePermission['report'] = new clsPermissionsPage(3, $len);
    $PagePermission['report']->addAction(array('action' => 'showReport', 'code' => 1, 'label' => 'view'));

//******************************************extension*****************************************//
    $PagePermission['extension'] = new clsPermissionsPage(4, $len);
    $PagePermission['extension']->addAction(array('action' => 'showAllExtensions', 'code' => 1, 'label' => 'view'));
    $PagePermission['extension']->addAction(array('action' => 'editExtension', 'code' => 2, 'label' => 'edit'));
    $PagePermission['extension']->addAction(array('action' => 'addExtension', 'code' => 3, 'label' => 'create'));
    $PagePermission['extension']->addAction(array('action' => 'deleteExtension', 'code' => 4, 'label' => 'delete'));
//******************************************conference*****************************************//
    $PagePermission['conference'] = new clsPermissionsPage(5, $len);
    $PagePermission['conference']->addAction(array('action' => 'showAllConference', 'code' => 1, 'label' => 'view'));
    $PagePermission['conference']->addAction(array('action' => 'editConference', 'code' => 2, 'label' => 'edit'));
    $PagePermission['conference']->addAction(array('action' => 'addConference', 'code' => 3, 'label' => 'create'));
    $PagePermission['conference']->addAction(array('action' => 'deleteConference', 'code' => 4, 'label' => 'delete'));
//******************************************showAllSip*****************************************//
    $PagePermission['sip'] = new clsPermissionsPage(6, $len);
    $PagePermission['sip']->addAction(array('action' => 'showAllSip', 'code' => 1, 'label' => 'view'));
    $PagePermission['sip']->addAction(array('action' => 'editSip', 'code' => 2, 'label' => 'edit'));
    $PagePermission['sip']->addAction(array('action' => 'addSip', 'code' => 3, 'label' => 'create'));
    $PagePermission['sip']->addAction(array('action' => 'deleteSip', 'code' => 4, 'label' => 'delete'));
//******************************************queue*****************************************//
    $PagePermission['queue'] = new clsPermissionsPage(7, $len);
    $PagePermission['queue']->addAction(array('action' => 'showAllQueues', 'code' => 1, 'label' => 'view'));
    $PagePermission['queue']->addAction(array('action' => 'editQueue', 'code' => 2, 'label' => 'edit'));
    $PagePermission['queue']->addAction(array('action' => 'addQueue', 'code' => 3, 'label' => 'create'));
    $PagePermission['queue']->addAction(array('action' => 'deleteQueue', 'code' => 4, 'label' => 'delete'));
//******************************************outbound*****************************************//
    $PagePermission['outbound'] = new clsPermissionsPage(8, $len);
    $PagePermission['outbound']->addAction(array('action' => 'showAllOutbound', 'code' => 1, 'label' => 'view'));
    $PagePermission['outbound']->addAction(array('action' => 'editOutbound', 'code' => 2, 'label' => 'edit'));
    $PagePermission['outbound']->addAction(array('action' => 'addOutbound', 'code' => 3, 'label' => 'create'));
    $PagePermission['outbound']->addAction(array('action' => 'deleteOutbound', 'code' => 4, 'label' => 'delete'));
//******************************************inbound*****************************************//
    $PagePermission['inbound'] = new clsPermissionsPage(9, $len);
    $PagePermission['inbound']->addAction(array('action' => 'showAllInbound', 'code' => 1, 'label' => 'view'));
    $PagePermission['inbound']->addAction(array('action' => 'editInbound', 'code' => 2, 'label' => 'edit'));
    $PagePermission['inbound']->addAction(array('action' => 'addInbound', 'code' => 3, 'label' => 'create'));
    $PagePermission['inbound']->addAction(array('action' => 'deleteInbound', 'code' => 4, 'label' => 'delete'));
//******************************************ivr*****************************************//
    $PagePermission['ivr'] = new clsPermissionsPage(10, $len);
    $PagePermission['ivr']->addAction(array('action' => 'showAllIvr', 'code' => 1, 'label' => 'view'));
    $PagePermission['ivr']->addAction(array('action' => 'editIvr', 'code' => 2, 'label' => 'edit'));
    $PagePermission['ivr']->addAction(array('action' => 'addIvr', 'code' => 3, 'label' => 'create'));
    $PagePermission['ivr']->addAction(array('action' => 'deleteIvr', 'code' => 4, 'label' => 'delete'));
//******************************************timeCondition*****************************************//
    $PagePermission['mainTimeCondition'] = new clsPermissionsPage(11, $len);
    $PagePermission['mainTimeCondition']->addAction(array('action' => 'showAllTimeCondition', 'code' => 1, 'label' => 'view'));
    $PagePermission['mainTimeCondition']->addAction(array('action' => 'editTimeCondition', 'code' => 2, 'label' => 'edit'));
    $PagePermission['mainTimeCondition']->addAction(array('action' => 'addTimeCondition', 'code' => 3, 'label' => 'create'));
    $PagePermission['mainTimeCondition']->addAction(array('action' => 'deleteTimeCondition', 'code' => 4, 'label' => 'delete'));
//******************************************queue*****************************************//
    $PagePermission['trunk'] = new clsPermissionsPage(12, $len);
    $PagePermission['trunk']->addAction(array('action' => 'showAllTrunk', 'code' => 1, 'label' => 'view'));
    $PagePermission['trunk']->addAction(array('action' => 'editTrunk', 'code' => 2, 'label' => 'edit'));
    $PagePermission['trunk']->addAction(array('action' => 'addTrunk', 'code' => 3, 'label' => 'create'));
    $PagePermission['trunk']->addAction(array('action' => 'deleteTrunk', 'code' => 4, 'label' => 'delete'));
//******************************************routing*****************************************//
    $PagePermission['routing'] = new clsPermissionsPage(13, $len);
    $PagePermission['routing']->addAction(array('action' => 'showAllRouting', 'code' => 1, 'label' => 'view'));
    $PagePermission['routing']->addAction(array('action' => 'editRouting', 'code' => 2, 'label' => 'edit'));
//******************************************upload*****************************************//
    $PagePermission['upload'] = new clsPermissionsPage(14, $len);
    $PagePermission['upload']->addAction(array('action' => 'showAllUpload', 'code' => 1, 'label' => 'view'));
    $PagePermission['upload']->addAction(array('action' => 'addUpload', 'code' => 2, 'label' => 'create'));
    $PagePermission['upload']->addAction(array('action' => 'deleteUpload', 'code' => 3, 'label' => 'delete'));
//******************************************loginAs*****************************************////******************************************upload*****************************************//
    $PagePermission['loginAs'] = new clsPermissionsPage(15, $len);
    $PagePermission['loginAs']->addAction(array('action' => 'showloginAs', 'code' => 1, 'label' => 'view'));
//******************************************Company*****************************************////******************************************upload*****************************************//
    $PagePermission['company'] = new clsPermissionsPage(16, $len);
    $PagePermission['company']->addAction(array('action' => 'showAllCompany', 'code' => 1, 'label' => 'view'));
    $PagePermission['company']->addAction(array('action' => 'editCompany', 'code' => 2, 'label' => 'edit'));
    $PagePermission['company']->addAction(array('action' => 'addCompany', 'code' => 3, 'label' => 'create'));
    $PagePermission['company']->addAction(array('action' => 'deleteCompany', 'code' => 4, 'label' => 'delete'));
//******************************************Company*****************************************////******************************************upload*****************************************//
    $PagePermission['voipconfig'] = new clsPermissionsPage(17, $len);
    $PagePermission['voipconfig']->addAction(array('action' => 'showAllVoipconfig', 'code' => 1, 'label' => 'view'));
//******************************************adminlist*****************************************//
    $PagePermission['admin.list'] = new clsPermissionsPage(18, $len);
    $PagePermission['admin.list']->addAction(array('action' => 'showAllAdminList', 'code' => 1, 'label' => 'view'));//******************************************adminlist*****************************************//
//******************************************adminlist*****************************************//
    $PagePermission['record'] = new clsPermissionsPage(19, $len);
    $PagePermission['record']->addAction(array('action' => 'showAllRecord', 'code' => 1, 'label' => 'view'));
    //print_r_debug($PagePermission);
//******************************************SuperAdmin*****************************************//
    $PagePermission['SuperAdmin'] = new clsPermissionsPage(20, $len);
    $PagePermission['SuperAdmin']->addAction(array('action' => 'showAllSuperAdmin', 'code' => 1, 'label' => 'view'));
//******************************************create.device.phone*****************************************//
    $PagePermission['device.phone'] = new clsPermissionsPage(21, $len);
    $PagePermission['device.phone']->addAction(array('action' => 'create.device.phone', 'code' => 1, 'label' => 'view'));
    //print_r_debug($PagePermission);
    return ($PagePermission);
    //******************************************
}

?>
