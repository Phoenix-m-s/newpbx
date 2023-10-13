<?php
/**
 * Created by PhpStorm.
 * User: VeRJiL
 * Date: 2/4/2017
 * Time: 1:42 PM
 */

include_once ROOT_DIR . "component/announce/adminAnnounceModel.php";
include_once ROOT_DIR . "component/outbound/adminOutboundModel.php";
include_once ROOT_DIR . "component/package_company/adminPackageCompanyModel.php";
include_once ROOT_DIR . "component/checkdependency/adminCheckDependency.php";
include_once ROOT_DIR . "component/ivr/adminIVRModel.php";
include_once ROOT_DIR . "component/inbound/adminInboundModel.php";
include_once ROOT_DIR . "component/upload/AdminUploadModel.php";
include_once ROOT_DIR . "component/sip/adminSIPModel.php";
include_once ROOT_DIR . "component/extension.model.php";
include_once ROOT_DIR . "component/company/AdminCompanyModel.php";
include_once ROOT_DIR . "common/init.inc.php";
include_once ROOT_DIR . "common/func.inc.php";
include_once ROOT_DIR . "services/CompanyService.php";
include_once ROOT_DIR . "component/outbound/adminOutboundModel.php";
include_once ROOT_DIR . "services/SipService.php";


/**
 * @author Sakhamanesh
 * @version 0.0.1
 * @copyright 2017 The Imen Daba Parsian Co.
 */

class AdminOutboundController
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
        2 => 'Inbound',
        3 => 'Extension',
        4 => 'Announce',
        5 => 'IVR',
        6 => 'Voice Mail',
        7 => 'Hang Up'
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
     * @param $message
     * @Email:sakhamanesh@dabacenter.ir
     * version:0.0.1
     */
    private function template($list, $message)
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
        }
    }

    /**
     * @Email:sakhamanesh@dabacenter.ir
     * version:0.0.1
     */
    public function showAllOutbound()
    {
        global $company_info;
        $OutboundDirty = adminOutboundModel::getAll()
            ->where('comp_id', '=', $company_info['comp_id'])->getList();
        $OutboundClean = $OutboundDirty['export']['list'];
        $OutboundClean['list']=$OutboundClean;
        $this->exportType = 'html';
        $this->fileName = 'outbound.show.php';
        $this->template($OutboundClean, $message);
    }


    /**
     * @Email:sakhamanesh@dabacenter.ir
     * version:0.0.1
     */
    public function addOutboundForm()
    {
        /*-----sip----*/
        $sipTrunk = new SipService();
        $fields['sip_id'] = $sipTrunk->getAllSip();

        /*------------*/
        $OutBound = new OutBoundService();

        $fields['priority'] = $OutBound->checkPriority();

        //*****

        $this->exportType = 'html';
        $this->fileName = 'outbound.form.php';
        $fields['action'] = 'addOutbound';
        $list = json_encode($fields);

        $this->template($list, '');
        die();
    }


    /**
     * @param $fields
     * @Email:sakhamanesh@dabacenter.ir
     * version:0.0.1
     */
    public function addOutbound($fields)
    {
        global $admin_info, $company_info;
        $Outbound = new OutBoundService();
        $checharacter = checkForPersianWordsInMultiDimensionalKeyValueArray($fields);
        if ($checharacter==-1) {
            $result['result'] = -1;
            $result['msg'] = 'You used an illegal character';
            echo json_encode($result);
            die();
        }
        $result = $Outbound->addOutBound($fields);
        if ($result['result'] != 1) {
            $result['result'] = -1;
        } else {
            $company = new CompanyService();
            $result = $company->activeRelaod($company_info['comp_id']);
        }
        echo json_encode($result,JSON_PRETTY_PRINT);
        die();
    }

    /**
     * @param $OutboundID
     * @Email:sakhamanesh@dabacenter.ir
     * version:0.0.1
     */
    public function editOutboundForm($OutboundID)
    {
        $Outbound = new OutBoundService();

        $list = json_encode($Outbound->showEditOutBoundForm($OutboundID));


        $this->exportType = 'html';
        $this->fileName = 'outbound.form.php';



        $this->template($list, '');
        die();

    }

    /**
     * @param $fields
     * @Email:sakhamanesh@dabacenter.ir
     * version:0.0.1
     */
    public function editOutbound($fields)
    {
        global $admin_info, $company_info;
        $Outbound = new OutBoundService();
        $checharacter = checkForPersianWordsInMultiDimensionalKeyValueArray($fields);
        if ($checharacter==-1) {
            $result['result'] = -1;
            $result['msg'] = 'You used an illegal character';
            echo json_encode($result);
            die();
        }
        $result = $Outbound->editOutBound($fields);
        if ($result['result'] != 1) {
            $result['result'] = -1;
        } else {
            $company = new CompanyService();
            $result = $company->activeRelaod($company_info['comp_id']);
        }
        echo json_encode($result,JSON_PRETTY_PRINT);
        die();
    }

    /**
     * @param $OutboundID
     * @Email:sakhamanesh@dabacenter.ir
     * version:0.0.1
     */
    public function deleteOutbound($OutboundID)
    {

        global $company_info;
        looeic::beginTransaction();
        $Outbound = new OutBoundService();
        $result = $Outbound->deleteOutBoundId($OutboundID);
        if ($result['result'] != 1) {
            looeic::rollback();
            $result['result'] = -1;
            $result['msg'] = 'Failed To Delete';
            $this->showAllOutbound($result['msg']);
            die();
        }

        $result = $Outbound->deleteSiptrunks($OutboundID);
        if ($result['result'] != 1) {
            looeic::rollback();
            $result['result'] = -1;
            $result['msg'] = 'Failed To Delete';
            $this->showAllOutbound($result['msg']);
            die();
        }

        $result = $Outbound->deleteOutBoundIdDaialPattern($OutboundID);

        if ($result['result'] != 1) {
            looeic::rollback();
            $result['result'] = -1;
            $result['msg'] = 'Failed To Delete';
            $this->showAllOutbound($result['msg']);
            die();
        } else {
            looeic::commit();
            $company = new CompanyService();
            $company->activeRelaod($company_info['comp_id']);
            redirectPage(RELA_DIR . 'outbound.php?action=showOutbound.', 'Successfully Deleted');
        }
    }

}