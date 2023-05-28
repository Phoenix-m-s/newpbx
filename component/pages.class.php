<?php

/**
 * Created by PhpStorm.
 * User: omid
 * Date: 5/16/14
 * Time: 4:21 AM
 */
class pages
{

    private static $_pageStart = "template_start.tpl";
    private static $_pageHead = "template_header.tpl";
    private static $_pageRightmenu = "template_rightMenu.tpl.php";
    private static $_pageFoot = "template_footer.tpl";
    private static $_pageEnd = "template_end.tpl";
    private $_pageMessage;
    private $_myPage;
    private $_pageContent;

    /**
     * stream html for view
     */
    public function template($list = [], $msg = '')
    {

        global $conn, $lang;
        switch ($this->exportType) {
            case 'html':
                include ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_start.tpl";
                include ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_header.tpl";
                include ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_rightMenu.tpl.php";
                include ROOT_DIR . "templates/" . CURRENT_SKIN . "/$this->fileName";
                include ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_footer.tpl";
                include ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_end.tpl";
                break;
            case 'json':
                return;
                break;
            case 'array' :
                echo $list;
                break;
            case 'serialize' :
                echo serialize($list);
                break;
            default:
                break;
        }

        die();
    }

    private function htmlStream($header = 1, $rightMenu = 1, $footer = 1)
    {

        global $admin_info, $messageStack;
        // include head have links and scripts and meta tags
        include_once(ROOT_DIR . "templates/" . CURRENT_SKIN . DIRECTORY_SEPARATOR . self::$_pageStart);

        // include header of body
        if ($header) {
            include_once(ROOT_DIR . "templates/" . CURRENT_SKIN . DIRECTORY_SEPARATOR . self::$_pageHead);
        }

        // include rightmenu
        if ($rightMenu) {
            include_once(ROOT_DIR . "templates/" . CURRENT_SKIN . DIRECTORY_SEPARATOR . self::$_pageRightmenu);
        }

        // information to send into users view
        if ($this->_pageContent != "") {
            $temp = $this->_pageContent;
        }

        // include my own page template
        include_once(ROOT_DIR . "templates/" . CURRENT_SKIN . DIRECTORY_SEPARATOR . $this->_myPage);

        if ($footer) {
            // include end of html document have end of body and html
            include_once(ROOT_DIR . "templates/" . CURRENT_SKIN . DIRECTORY_SEPARATOR . self::$_pageFoot);
        }

        // include end of html document have end of body and html
        include_once(ROOT_DIR . "templates/" . CURRENT_SKIN . DIRECTORY_SEPARATOR . self::$_pageEnd);

        die();
    }

    /**
     *  constructor of this class
     */
    public function __construct()
    {
        $this->_myPage = "";
        $this->_pageContent = array();
        $this->_pageMessage = array(
            'type' => '',
            'title' => '',
            'message' => ''
        );
    }

    /**
     * include home page of website
     */
    public function showOldIndex()
    {
        $this->_myPage = "index.php";
        $temp = func_get_args();
        $this->_pageContent = $temp[0];
        $this->htmlStream();
    }

    public function showIndex($list)
    {
        include_once ROOT_DIR . "common/init.inc.php";
        include_once ROOT_DIR . "common/func.inc.php";
        global $admin_info,$member_info, $company_info;
        include_once ROOT_DIR . "component/cdr.model.php";
        include_once ROOT_DIR . "component/extension.model.php";
        //print_r_debug($company_info);

       /* $companyName = $company_info['comp_name'];
        date_default_timezone_set('Asia/Tehran');

        $start = date("Y-m-d H:i:s");
        $dateExpiredDate= date('Y-m-d H:i:s',strtotime('0 hour -30 minutes',strtotime($start)));
       //die($dateExpiredDate);

        $cdr = AdminCdrModel::query("
            SELECT
             count(`cdr`.`disposition`) AS `count` ,`cdr`.`disposition`
            FROM
              `cdr`
           WHERE `cdr`.`dcontext` like '%-$companyName'  AND  `cdr`.`calldate` > '$dateExpiredDate' 
            
            GROUP BY
              `cdr`.`disposition`
        ")->getList()['export']['list'];




        $count = $cdr['0']['count'] + $cdr['1']['count'] + $cdr['2']['count'] + $cdr['3']['count'];
        $list['cdr']['ANSWERED'] = ($cdr['0']['count'] / $count) * 100;
        $list['cdr']['BUSY'] = ($cdr['1']['count'] / $count) * 100;
        $list['cdr']['FAILED'] = ($cdr['2']['count'] / $count) * 100;
        $list['cdr']['NO ANSWER'] = ($cdr['3']['count'] / $count) * 100;


        $extensionModel = AdminExtensionModel::getAll()->getList()['export']['list'];
        $appendSql = array();
        foreach ($extensionModel as $key => $value) {
            $appendSql[] = "clid like '%<" . $value['extension_no'] . ">'" ;
        }
        $appendSqlStr =  " `cdr`.`calldate` > '$dateExpiredDate'" ; ' AND (' ;
        $appendSql = implode(' or ', $appendSql);
        $appendSqlStr = $appendSqlStr.$appendSql.')' ;



        $sql = "SELECT count(`cdr`.`clid`) AS `count`  FROM `cdr`  WHERE `cdr`.`dcontext` like '%-$companyName'";
        $list['extensionCount'] = AdminCdrModel::query($sql)->getList()['export']['list']['0']['count'];


       $sql = 'SELECT
             count(`cdr`.`clid`) AS `count` ,`cdr`.`clid`
            FROM
              `cdr`  where ' . $appendSql .' 
            GROUP BY
               `cdr`.`clid` ORDER BY `count` DESC  limit 6';

        $extension = AdminCdrModel::query($sql)->getList();

        $list['extension'] = $extension['export']['list'];
        $sql = "select count(t1) from
                (
                SELECT
                 EXTRACT(HOUR FROM calldate) as t1 
                 FROM
                  `cdr` where `dcontext` like '%-$companyName')
                   pick 
                 where t1>=08 and t1 < 16 and .$dateExpiredDate. ";
        $extension = AdminCdrModel::query($sql)->getList();
        $list['extensionTiming']['0'] = $extension['export']['list']['0']['count(t1)'];

        $sql = "select count(t1) from 
                (
                SELECT
                 EXTRACT(HOUR FROM calldate) as t1 
                 FROM
                  `cdr` where `dcontext` like '%-$companyName')
                   pick 
                 where t1>=16 and t1 <= 23 and .$dateExpiredDate.";

        $extensionTiming = AdminCdrModel::query($sql)->getList();
        $list['extensionTiming']['1'] = $extensionTiming['export']['list']['0']['count(t1)'];
        $sql = "select count(t1) from 
                (
                SELECT
                 EXTRACT(HOUR FROM calldate) as t1 
                 FROM
                  `cdr` where `dcontext` like '%-$companyName')
                   pick 
                 where t1>=00 and t1 < 08 and .$dateExpiredDate.";
        $extension = AdminCdrModel::query($sql)->getList();
        $list['extensionTiming']['2'] = $extension['export']['list']['0']['count(t1)'];*/
        $list['listMenu'] = checkDisplayUi();
        $this->exportType = 'html';
        $this->fileName = 'index.php';
       //print_r_debug($list);

        $this->template($list, '');
        die();
    }

    /**
     * include poolad login page
     */
    public function loginForm()
    {

        $server = constant("SERVER");
        if (strlen($server) and $server != 'cloud') {
            header("Location: " . RELA_DIR_BOX );
            die();
        }


        $this->_myPage = "loginForm.tpl";

        // call show page
        $this->htmlStream(0, 0, 0);

    }
    public function userloginForm()
    {

        $this->_myPage = "loginFormUser.tpl";
        // call show page
        $this->htmlStream(0, 0, 0);

    }


    /**
     * show admin list
     */
    public function showAdminList($adminRs)
    {
        $this->_adminList = $adminRs;
        $this->_myPage = "admin.adminlist.php";
        $this->htmlStream();
    }

    /**
     * show admin edit form
     */
    public function showAdminListEdit($adminEditRs)
    {

        $this->_pageContent = $adminEditRs;
        $this->_myPage = "admin.adminlist.edit.tpl";
        $this->htmlStream();
    }

    /**
     * show admin permission list
     */
    public function showAdminPermissionList($adminpermissionRs)
    {

        $this->_pageContent = $adminpermissionRs;
        //echo '<pre/>';
        //print_r($adminpermissionRs);
        //die();

        $this->_myPage = "admin.adminlist.settask.tpl";
        $this->htmlStream();
    }

    /**
     * show group schedule
     */
    public function groupSchedule()
    {
        global $messageStack;

        $this->_myPage = "admin.groupSchedule.list.tpl";
        $temp = func_get_args();
        $this->_pageContent = $temp[0];
        $this->htmlStream();
    }

    /**
     * show schedule list
     */
    public function showSchedule()
    {
        global $messageStack;

        $this->_myPage = "admin.schedule.list.tpl";
        $temp = func_get_args();
        $this->_pageContent = $temp[0];
        $this->htmlStream();
    }

    /**
     * show add schedule to group page
     */
    public function showAddSchedule()
    {
        global $messageStack;

        $this->_myPage = "admin.schedule.add.tpl";
        $temp = func_get_args();
        $this->_pageContent = $temp[0];
        $this->htmlStream();
    }

    /**
     * show edit schedule to group page
     */
    public function showEditSchedule()
    {
        $this->_myPage = "admin.schedule.edit.tpl";
        $temp = func_get_args();
        $this->_pageContent = $temp[0];
        $this->htmlStream();
    }

    /**
     * show campaign List
     */
    public function campList()
    {
        global $messageStack;

        $this->_myPage = "admin.campaign.list.tpl";
        $temp = func_get_args();
        $this->_pageContent = $temp[0];
        $this->htmlStream();
    }

    /**
     * show Add Campaign page
     */
    public function showAddCamp()
    {
        global $messageStack;

        $this->_myPage = "admin.campaign.add.tpl";
        $temp = func_get_args();
        $this->_pageContent = $temp[0];
        $this->htmlStream();
    }

    /**
     * Get all extension list
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function getAllExtensionList()
    {
        //global $conn, $lang;
        include_once(ROOT_DIR . "component/extension.operation.class.php");
        $operation = new extension_operation();
        $result = $operation->getExtensionList();

        if ($result['result'] != 1) {
            return $result['msg'];

        }

        return $operation->extensionList;
    }

    /**
     * show black List
     */
    public function blackList()
    {
        $this->_myPage = "admin.black.list.tpl";
        $temp = func_get_args();
        $this->_pageContent = $temp[0];
        $this->htmlStream();
    }

    /**
     * show number List
     */
    public function getNumberList()
    {
        $this->_myPage = "admin.numbers.list.tpl";
        $temp = func_get_args();
        $this->_pageContent = $temp[0];
        $this->htmlStream();
    }

    /**
     * show edit campaign
     */
    public function showEditCamp()
    {
        $this->_myPage = "admin.campaign.edit.tpl";
        $temp = func_get_args();
        $this->_pageContent = $temp[0];
        $this->htmlStream();
    }

}
