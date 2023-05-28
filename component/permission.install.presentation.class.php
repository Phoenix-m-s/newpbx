<?php
include_once(ROOT_DIR . "component/company.operation.class.php");
include_once(ROOT_DIR . "component/queue.operation.class.php");
/**
 * @author Malekloo Izadi Sakhamanesh <Izadi@dabacenter.ir>
 * @version 0.0.1 this is the beta version of News
 * @copyright 2015 The Imen Daba Parsian Co.
 */


class install_permission_presentation
{

    /**
     * Contains file type
     * @var
     */
    public $exportType;

    /**
     * Contains file name
     * @var
     */
    public $fileName;

    /**
     * Specifies the type of output
     * @param $list
     * @param $msg
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    function template($list='',$msg)
    {
       // global $conn, $lang;
        switch($this->exportType)
        {
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
     * Shows all the companies
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    function install($config)
    {


        $db = dbConn::getConnection();



        $sql = "SELECT * FROM web_config";

        $stmt = $db->query($sql);

        /*** echo number of columns ***/
        $obj = $stmt->fetchAll(PDO::FETCH_OBJ);

       print_r($obj);
        die();

        foreach($config as $key=>$val)
        {
            echo $key;
            //$rs=select * from permission where file_name = 'customer.controller'
            //if (!record count)
            //{
            //$rs=insert in to permission file_name = 'customer.controller'
            //$insert_id=$rs->getinsert id
            //}else insert_id=$rs->fields[permission_id];
            //
            //$PagePermission['customer.controller'] = new clsPermissionsPage($insert_id, $len);

            /*$PagePermission['customer.controller'] = new clsPermissionsPage(3,$len);
            $PagePermission['customer.controller']->addAction(array('action' => 'showCustomerList', 'code' => 1, 'label' => adminList_0029));
            $PagePermission['customer.controller']->addAction(array('action' => 'viewOnlineCustomer', 'code' => 2, 'label' => adminList_0030));
            $PagePermission['customer.controller']->addAction(array('action' => 'newCustomer', 'code' => 3, 'label' => adminList_0031));
            $PagePermission['customer.controller']->addAction(array('action' => 'dataCustomer', 'code' => 4, 'label' => adminList_0032));
            $PagePermission['customer.controller']->addAction(array('action' => 'smsCustomer', 'code' => 5, 'label' => adminList_0033));
            */


        }

    }




}