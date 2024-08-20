<?php
/**
 * Created by PhpStorm.
 * User: VeRJiL
 * Date: 4/22/2017
 * Time: 11:50 AM
 */

include ROOT_DIR . 'component/company/model/company.php';
include_once ROOT_DIR . "common/init.inc.php";
include_once ROOT_DIR . "common/func.inc.php";
include_once ROOT_DIR . "common/looeic.php";
include_once ROOT_DIR . 'services/CompanyService.php';
include_once ROOT_DIR . "services/TblDstOptionService.php";
include_once ROOT_DIR . 'model/admin/admin/model/AdminUser.php';
include_once ROOT_DIR . "component/Responce.php";
/**
 * Class AdminAnnounceController
 */
class companyController
{
    /**
     * @var
     */
    private $error;
    /**
     * @var
     */
    private $fileName;
    /**
     * @var
     */
    private $exportType;

    /**
     * @var array
     */
    private $msg = [];
    /**
     * @var array
     */
    private $DSTList = [
        2 => 'Queue',
        3 => 'Extension',
        4 => 'Announce',
        5 => 'IVR',
        6 => 'Voice Mail',
        7 => 'Hang Up',
        8 => 'Time Condition'
    ];
    /**
     * @var array
     */
    private $forwardList = [
        'defaultMessage' => 'Default Message',
        'customMessage' => 'Custom Message',
        'customMessageByList' => 'Custom Message By List',
        'customMessageByRecord' => 'Custom Message By Record'
    ];

    /**
     * @param $list
     * @param string $message
     */
    private function template($list, $message = '')
    {
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
    }

    /**
     * @param string $message
     */
    public function showAllCompany($list, $message = '')
    {
        global $conn, $lang;
        $this->exportType = 'html';
        $this->fileName = 'company.show.php';
        $this->template($msg);
        die();
    }

    /**
     * @param string $message
     */
    public function showAllCompanyApi()
    {
        $company = new CompanyService();
        $data = $company->getCompanylistApi();
        $data['export']['success']=true;
        Response::json($data['export'],200);
    }

    public function search($fields)
    {
        include_once(ROOT_DIR . "model/datatable.converter.php");

        $columns = array(
            array('db' => 'comp_id', 'dt' => 0),
            array('db' => 'comp_name', 'dt' => 1),
            array('db' => 'manager_name', 'dt' => 2),
            array('db' => 'address', 'dt' => 3),
            array('db' => 'phone_number', 'dt' => 4),
            array('db' => 'email', 'dt' => 5),
            array('db' => 'comp_status', 'dt' => 6)
        );
        //$primaryKey = 'id';
        $convert = new convertDatatableIO();
        $convert->input = $fields;
        $convert->columns = $columns;
        $searchFields = $convert->convertInput();
        $getCompanyUser = new CompanyService();
        $getCompanyUserList = $getCompanyUser->getCompanyUsers($searchFields);


        $list['list'] = $getCompanyUserList['company']['export']['list'];
        $list['paging'] = $getCompanyUserList['totalRecord'];

        $i=0;
        foreach ($list['list'] as $key=>$value)
        {
            $i++;
            $list['list'][$key]['counter']=$i;
        }
        $other['0'] = array(
            'formatter' => function ($list) {
                $st = $list['counter'];
                return $st;
            }
        );

        $other['6'] = array(
            'formatter' => function ($list) {
                $st = ($list['Comp_Status'] == '0' ? DISABLED_01 : ENABLE_01);
                return $st;
            }
        );

        $other['7'] = array(

            'formatter' => function ($list) {

                //$st = '<div class="nice-checkbox"><input type="checkbox" class="checkbox-o" name="box[' . $list['news_id'] . ']" value="' . $list['Title'] . '" id="checkbox-o-' . $i . '"><label for="checkbox-o-' . $i . '"></label></div>';

                $st = '<a href="' . RELA_DIR . 'company.php?action=editCompany&id=' . $list['comp_id'] . '"   rel="tooltip" data-original-title="' . EDIT_01 . '">
                                            <i class="fa fa-pencil text-green"></i>
                                        </a>
                                        <a href="' . RELA_DIR . 'company.php?action=deleteCompany&id=' . $list['comp_id'] . '" onclick="return confirm(\'Are you sure want to delete this item?\');"  rel="tooltip" data-original-title="' . DELETE_01 . '">
                                            <i class="fa fa-trash text-red"></i>
                                        </a>';
                return $st;
            }
        );

        $internalVariable['showstatus'] = $fields['status'];

        //$other[2]='news={$news_id}';
        //$other[2]='<div class="nice-checkbox"><input type="checkbox" class="checkbox-o" name="box[{$news_id}]" value="{$Title}" id="checkbox-o-'.$i.'"><label for="checkbox-o-'.$i.'"></label></div>';
        $export = $convert->convertOutput($list, $columns, $other, $internalVariable);

        echo json_encode($export);
        die();
    }


    public function setTypeValue()
    {
        $fields[0] = array('id' => '1', 'name' => 'Admin');
        $fields[1] = array('id' => '2', 'name' => 'Member');
        return $fields;
    }


    /**
     * @param array $fields
     * @param $message
     */
    public function addCompanyForm($list = [], $message)
    {

        $fields['action'] = 'addCompany';
        $fields['type'] = $this->setTypeValue();
        $list = json_encode($fields, JSON_PRETTY_PRINT);
        $this->exportType = 'html';
        $this->fileName = 'company.form.php';
        $this->template($list, $message);
        die();
    }


    /**
     * @param $fields
     */
    public function addCompany($fields)
    {
        global $company_info;
        $company = new CompanyService();
        $result = $company->addCompany($fields);

        if ($result['result'] != 1) {
            $result['result'] = -1;
        }
        else{
            $company = new companyService();
            $result = $company->activeRelaod($company_info['comp_id']);

        }
        echo json_encode($result);
        die();
    }

    /**
     * @param $fields
     */
    public function addCompanyApi($fields)
    {

        global $company_info;
        $company = new CompanyService();
        $result = $company->addCompanyApi($fields);
        if($result['result']!=-1)
        {

            $list['data'] = $fields;
            $list['success'] = "true";
            $list['result'] = 1;

            Response::json($list, 201);
        }
        else
        {

            $list['success'] = "false";
            $list['responseCode'] = 0;
            $list['error'] = $result['msg'];
            Response::json($list, 422);
        }
        echo json_encode($result);
        die();
    }

    /**
     * @param $CompanyID
     * @param $fields
     * @param $message
     */
    public function editCompanyForm($CompanyID, $fields, $message)
    {

        $fields['name'] = $user['name'];
        $fields['family'] = $user['family'];
        $fields['action'] = "editCompany";

        $fields['type'] = $this->setTypeValue();
        $fields['type_selected'] = $user['type'];
        $list = json_encode($fields, JSON_PRETTY_PRINT);
        $this->exportType = 'html';
        $this->fileName = 'company.form.php';
        $this->template($list, $message);
        die();

    }

    /**
     * @Email M.sakhamanesh@googlemail.com
     * @param $fields
     */
    public function editCompany($fields)
    {
        global $company_info;
        $Company = new CompanyService();
        $result = $Company->editCompany($fields);
        if ($result['result'] != 1) {
            $result['result'] = -1;
        }
        else{
            $company = new companyService();
            $result = $company->activeRelaod($company_info['comp_id']);

        }
        echo json_encode($result);
        die();

    }


    /**
     * @Email M.sakhamanesh@googlemail.com
     * @param $CompanyID
     */
    public function deleteCompany($CompanyID)
    {

        global $company_info;
        $Company = new CompanyService();
        $result = $Company->deleteCompany($CompanyID);
        if ($result['result'] != 1) {
            $result['result'] = -1;
        }
        $company = new companyService();
        $company->activeRelaod($company_info['comp_id']);
        redirectPage(RELA_DIR . 'company.php?=showCompany', 'Successfully Deleted');
        die();
    }

}
