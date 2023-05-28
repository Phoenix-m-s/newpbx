<?php
include_once(ROOT_DIR . "component/loginAs.operation.class.php");

/**
 * @author Malekloo Izadi Sakhamanesh <Izadi@dabacenter.ir>
 * @version 0.0.1 this is the beta version of News
 * @copyright 2015 The Imen Daba Parsian Co.
 */
class loginAs_presentation
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
    function template($list = '', $msg)
    {
        // global $conn, $lang;
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
                echo serialize($list);
                return;
                break;
            default:
                break;
        }

    }


    /**
     * Login as
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function LoginAsForm()
    {
        //global $conn, $lang;
        $this->exportType = 'html';
        $this->fileName = 'loginAs.form.php';
        $list = $this->getCompanies();
        $this->template($list);
        die();
    }


    /**
     * Shows all the companies
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function getCompanies()
    {
        global $conn, $lang;
        include_once(ROOT_DIR . "component/company.operation.class.php");
        $operation = new company_operation();
        $result = $operation->getCompanyList();

        if ($result['result'] != 1) {
            return $result['msg'];
        }

        return $operation->companyList;
    }


    /**
     * LoginAs
     * @param $fields
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function LoginAs($fields)
    {

        global $conn, $lang, $admin_info, $company_info;
        $operation = new loginAs_operation();
        include_once(ROOT_DIR . "component/company.operation.class.php");
        $operation_company = new company_operation();
        $result = $operation_company->getCompanyListById($fields['CompID']);


        $fields['ascomp_id'] = $operation_company->companyInfo['comp_id'];
        $fields['comp_id'] = $company_info['comp_id'];
        $fields['admin_id'] = $admin_info['admin_id'];
        $fields['remote_addr'] = $_SERVER["REMOTE_ADDR"];
        include_once(ROOT_DIR . "component/admin.class.php");
        $admin = new admin();
        $session = $admin->getSession_id();

        $fields['session_id'] = $session['decrypt'];
        $fields['last_access_time'] = date("Y-m-d H:i:s");
        $result = $operation->set_loginAsInfo($fields);

        if ($result['result'] != 1) {
            $this->LoginAsForm($fields, $result['msg']);
        }

        $result = $operation->insertLoginAs();

        if ($result == -1) {
            return $result['msg'];
        } else {
            $subName = $operation_company->companyInfo['Comp_Name'];
            $arrayList = explode('.', RELA_DIR);
            $arrayList[0] = 'http://' . $subName;
            $newAddress = implode('.', $arrayList);
            $msg = "successfully added.";
            redirectPage($newAddress . "loginAs.php?action=loginas&s=" . $session['encrypt'], $msg);
        }

        die();
    }
}



