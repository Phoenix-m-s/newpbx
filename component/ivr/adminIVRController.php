<?php
/**
 * Created by PhpStorm.
 * User: VeRJiL
 * Date: 2/4/2017
 * Time: 1:42 PM
 */

include_once ROOT_DIR . "common/init.inc.php";
include_once ROOT_DIR . "common/func.inc.php";
include_once ROOT_DIR . "component/timeCondition/mainTimeConditionModel.php";
include_once ROOT_DIR . "component/package_company/adminPackageCompanyModel.php";
include_once ROOT_DIR . "component/checkdependency/adminCheckDependency.php";
include_once ROOT_DIR . "component/announce/adminAnnounceModel.php";
include_once ROOT_DIR . "component/queue/adminQueueModel.php";
include_once ROOT_DIR . "component/ivr/adminIVRModel.php";
include_once ROOT_DIR . "component/sip/adminSIPModel.php";
include_once ROOT_DIR . "component/extension.model.php";
include_once ROOT_DIR . "component/company/AdminCompanyModel.php";
include_once ROOT_DIR . "common/looeic.php";
include_once ROOT_DIR . "services/IvrService.php";
include_once ROOT_DIR . 'services/dependency/DependencyService.php';

/**
 * @author VeRJiL
 * @version 0.0.1
 * @copyright 2017 The Imen Daba Parsian Co.
 */
class AdminIVRController extends looeic
{
    private $fileName;
    private $exportType;

    private function template($list, $message = [])
    {

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
            case 'array' :
                echo $list;
                break;
            case 'serialize' :
                echo serialize($list);
                break;
        }
    }

    public function showAllIvr($message)
    {
        global $company_info;

        $ivrDirty = AdminIVRModel::getAll()
            ->where('comp_id', '=', $company_info['comp_id'])->getList();
        $ivrClean = $ivrDirty['export']['list'];
        $this->exportType = 'html';
        $this->fileName = 'ivr.show.php';
        $this->template($ivrClean, $message);
    }

    public function addIvrForm($fields, $message)
    {
        $ivr = new IvrService();
        $list = $ivr->addIvrForm($fields);
        $this->exportType = 'html';
        $this->fileName = 'ivr.form.php';
        $this->template($list, $message);
        die();
    }

    public function addIvr($fields)
    {
        global $admin_info, $company_info;
        $checharacter = checkForPersianWordsInMultiDimensionalKeyValueArray($fields);
        if ($checharacter==-1) {
            $result['result'] = -1;
            $result['msg'] = 'You used an illegal character';
            echo json_encode($result);
            die();
        }
        $ivr = new IvrService();
        $result = $ivr->addIvr($fields);
        if ($result['result'] != 1) {
            $result['result'] = -1;
        } else {
            $company = new CompanyService();
            $result = $company->activeRelaod($company_info['comp_id']);
        }
        echo json_encode($result);
        die();
    }

    public function editIvrForm($ivrID)
    {
        $ivr = new IvrService();
        $list = $ivr->editIvrForm($ivrID);
        $this->exportType = 'html';
        $this->fileName = 'ivr.form.php';
        $this->template($list, '');
        die();
    }

    public function editIvr($fields)
    {
        global $company_info;
        $checharacter = checkForPersianWordsInMultiDimensionalKeyValueArray($fields);
        if ($checharacter==-1) {
            $result['result'] = -1;
            $result['msg'] = 'You used an illegal character';
            echo json_encode($result);
            die();
        }
        $ivr = new IvrService();
        $result = $ivr->editIvr($fields);
        if ($result['result'] != 1) {
            $result['result'] = -1;
        } else {
            $company = new CompanyService();
            $result = $company->activeRelaod($company_info['comp_id']);
        }
        echo json_encode($result);
        die();
    }

    public function deleteIVRs($ivrID)
    {
        global $company_info;
        looeic::beginTransaction();

        $input['comp_id'] = $company_info['comp_id'];
        $checkDependency = new DependencyService;
        $input['id'] = $ivrID;
        $input['name'] = 'IVR';
        $input['dst_option_id'] = '5';
        $result = $checkDependency->checkDependency($input);
        if ($result['msg'] != '') {
            $this->showAllIvr($result['msg']);
            die();
        }
        $IvrDst = new IvrDstService();
        $result = $IvrDst->deleteIvrDstByIvrId($ivrID);
        if ($result['result'] != 1) {
            looeic::rollback();
            $result['result'] = -1;
            $result['msg'] = 'Failed To Delete';
            $this->showAllIvr($result['msg']);
            die();
        }
        $Ivr = new IvrService();
        $result = $Ivr->deleteIvrByIvrId($ivrID);
        if ($result['result'] != 1) {
            looeic::rollback();
            $result['result'] = -1;
            $result['msg'] = 'Failed To Delete';
            $this->showAllIvr($result['msg']);
            die();
        } else {
            looeic::commit();
            $company = new CompanyService();
            $company->activeRelaod($company_info['comp_id']);
            redirectPage(RELA_DIR . 'ivr.php?action=showIvr', 'Successfully Deleted');
        }
    }
}