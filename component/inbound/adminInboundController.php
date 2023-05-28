<?php
/**
 * Created by PhpStorm.
 * User: VeRJiL
 * Date: 2/4/2017
 * Time: 1:42 PM
 */

include_once ROOT_DIR . "component/timeCondition/mainTimeConditionModel.php";
include_once ROOT_DIR . "component/announce/adminAnnounceModel.php";
include_once ROOT_DIR . "component/inbound/adminInboundModel.php";
include_once ROOT_DIR . "component/package_company/adminPackageCompanyModel.php";
include_once ROOT_DIR . "component/checkdependency/adminCheckDependency.php";
include_once ROOT_DIR . "component/ivr/adminIVRModel.php";
include_once ROOT_DIR . "component/upload/AdminUploadModel.php";
include_once ROOT_DIR . "services/InboundService.php";
include_once ROOT_DIR . "services/TblDstOptionService.php";
include_once ROOT_DIR . "component/sip/adminSIPModel.php";
include_once ROOT_DIR . "component/extension.model.php";
include_once ROOT_DIR . "component/company/AdminCompanyModel.php";
include_once ROOT_DIR . "common/init.inc.php";
include_once ROOT_DIR . "common/func.inc.php";
include_once ROOT_DIR . 'services/CompanyService.php';
include_once ROOT_DIR . "services/TblDstOptionService.php";
include_once ROOT_DIR . "services/IvrService.php";
include_once ROOT_DIR . "services/UploadService.php";


/**
 * @author VeRJiL
 * @version 0.0.1
 * @copyright 2017 The Imen Daba Parsian Co.
 */
class AdminInboundController
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
        8 => 'Time Condition',
        10=>'Sip'
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
     * @Email :sakhamanesh@dabacenter.ir
     * @param $list
     * @param $message
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
     *
     */
    public function showAllInbound()
    {
        global $company_info;
        $inboundDirty = AdminInboundModel::getAll()
          ->where('comp_id', '=', $company_info['comp_id'])->getList();
        $inboundClean = $inboundDirty['export']['list'];
        $this->exportType = 'html';
        $this->fileName = 'inbound.show.php';
        $this->template($inboundClean, '');
    }

    /**
     * @Email :sakhamanesh@dabacenter.ir
     * @param $fields
     * @param $message
     */
    public function addInboundForm($fields, $message)
    {
        /*$fields['DSTList'] = $this->DSTList;
        $uniId = uniqid();
        $_SESSION['token'][$uniId] = '1';
        $fields['token'] = 'token[' . $uniId . ']';*/

        //////////////get extensionList////////////
        $extensionNameList = new ExtensionService();
        $fields['extensionList'] = $extensionNameList->getAllExtensionName();

        //////////////get dialExtensionDetail////////////

        $queueOption = new TblDstOptionService();
        $dialExtension_list = $queueOption->getInboundOption();
        $fields['dst_option_id'] = $queueOption->getDialExtensionDetailByName($dialExtension_list);

        $fields['action'] = 'addInbound';
        $list = json_encode($fields, JSON_PRETTY_PRINT);
        $this->exportType = 'html';
        $this->fileName = 'inbound.form.php';
        $this->template($list, $message);
        die();
    }

    /**
     * @param $fields
     * @Email :sakhamanesh@dabacenter.ir
     * @author :Sakhamanesh
     * @version :0.0.1
     */
    public function addInbound($fields)
    {

        $inbound = new InboundService();
        $result = $inbound->addInbound($fields);

        if ($result['result'] != 1) {
            $result['result'] = -1;
        }
        echo json_encode($result);
        die();
    }

    /**
     * @Email :sakhamanesh@dabacenter.ir
     * @param $inboundID
     * @param $message
     * @param array $fields
     */
    public function editInboundForm($inboundID, $message, $fields = array())
    {
        $inboundDirty = AdminInboundModel::find($inboundID);
        $fields = $inboundDirty->fields;

        //////////////get uploadList////////////
        $fields['upload_id_selected'] = $fields['upload_id'];
        //////////////get uploadList////////////
        $upload = new UploadService();
        $fields['upload_id'] = $upload->getUploadList();
        //////////////get dialExtensionDetail////////////
        $fields['dst_option_id_selected'][0]['dst_option_id'] = $fields['dst_option_id'];
        $fields['dst_option_id_selected'][0]['dst_option_sub_id'] = $fields['dst_option_sub_id'];
        $fields['dst_option_id_selected'][0]['DSTOption'] = $fields['DSTOption'];
        unset($fields['dst_option_id']);
        unset($fields['dst_option_sub_id']);
        unset($fields['DSTOption']);
        unset($fields['forward']);

        //////////////get dialExtensionDetail////////////
        $ivrOption = new TblDstOptionService();
        $dialExtension_list = $ivrOption->getInboundOption();
        $fields['dst_option_id'] = $ivrOption->getDialExtensionDetailByName($dialExtension_list);
        $fields['action'] = 'editInbound';
        if($fields['did_name']==''){
            $fields['check_did_name']="1";

        }
        else{
            $fields['check_did_name']="0";
        }
        if($fields['cid_name']==''){
            $fields['check_cid_name']="1";
        }
        else{
            $fields['check_cid_name']="0";
        }
        if($fields['fax_email']=='')
        {
            $fields['check_fax_ext']="0";
        }
        else{
            $fields['check_fax_ext']="1";
        }



        $list = json_encode($fields, JSON_PRETTY_PRINT);
        //print_r_debug($list);
        $this->exportType = 'html';
        $this->fileName = 'inbound.form.php';
        $this->template($list, $message);
        die();
    }


    /**
     * @param $fields
     * @Email :sakhamanesh@dabacenter.ir
     * @param $message
     * @param array $fields
     */
    public function oldeditInboundForm($inboundID, $message, $fields = array())
    {
        if (count($fields) == 0) {
            $inboundDirty = AdminInboundModel::find($inboundID);
            $fields = $inboundDirty->fields;
        }

        /*
        |--------------------------------------------------------------------------
        | Available Telephone system (DSTOption)
        | --------------------------------------------------------------------------
        | --------------Voice Mail=6--------------
        | ------------Extension=3------------
        | ----------Announce=4----------
        | --------Hang Up=7--------
        | ------Inbound=2------
        | ----IVR=5----
        */
        switch ($fields['dst_option_id']) {
            case 2:
                $queueDirty = AdminQueueModel::getAll()->getList();
                foreach ($queueDirty['export']['list'] as $key => $value) {
                    $fields['DstSub'][$value['queue_id']] = $value['queue_name'];
                }
                break;
            case 3:
                $extensionDirty = AdminExtensionModel::getAll()->getList();
                foreach ($extensionDirty['export']['list'] as $key => $value) {
                    $fields['DstSub'][$value['extension_id']] = $value['extension_name'];
                }
                break;
            case 4:
                $announceDirty = AdminAnnounceModel::getAll()->getList();
                foreach ($announceDirty['export']['list'] as $key => $value) {
                    $fields['DstSub'][$value['announce_id']] = $value['announce_name'];
                }
                break;
            case 5:
                $ivrDirty = AdminIVRModel::getAll()->getList();
                foreach ($ivrDirty['export']['list'] as $key => $value) {
                    $fields['DstSub'][$value['ivr_id']] = $value['ivr_name'];
                }
                break;
            case 6:
                $extensionDirty = AdminExtensionModel::getBy_voicemail_status(1)->getList();
                foreach ($extensionDirty['export']['list'] as $key => $value) {
                    $fields['DstSub'][$value['extension_id']] = $value['extension_no'];
                }
                break;
            case 8:
                $timeConditionDirty = AdminMainTimeConditionModel::getAll()->getList();
                foreach ($timeConditionDirty['export']['list'] as $key => $value) {
                    $fields['DstSub'][$value['id']] = $value['name'];
                }
                break;
        }

        $uploadDirty = AdminUploadModel::getAll()->getList();
        foreach ($uploadDirty['export']['list'] as $key => $value) {
            $fields['uploadList'][$value['upload_id']] = $value['title'];
        }

        $fields['DSTList'] = $this->DSTList;
        $fields['forwardList'] = $this->forwardList;


        $this->exportType = 'html';
        $this->fileName = 'inbound.edit.form.php';
        $this->template($fields, $message);
        die();
    }


    /**
     * @param $fields
     * @Email :sakhamanesh@dabacenter.ir
     * @param $inboundID
     * @param $fields
     */
    public function editInbound($fields)
    {
        global $company_info;
        $inbound = new InboundService();
        $result = $inbound->editInbound($fields);
        if ($result['result'] != 1) {
            $result['result'] = -1;
        }
        echo json_encode($result);
        die();

    }

    /**
     * @message deleteInbound
     * @param $fields
     * @Email :sakhamanesh@dabacenter.ir
     * @author :Sakhamanesh
     * @version :0.0.1
     * @param $inboundID
     */
    public function deleteInbound($inboundID)
    {
        global $company_info;
        $inbound = new InboundService();
        $result = $inbound->deleteInboundByInboundId($inboundID);
        if ($result['result'] != 1) {
            $result['result'] = -1;
            $result['msg'] = 'Failed To Delete';
            $this->showAllInbound($result['msg']);
            die();
        } else {
            $company = new CompanyService();
            $company->activeRelaod($company_info['comp_id']);

            $result['msg'] = 'Successfully Deleted';

            redirectPage(RELA_DIR . 'inbound.php?action=showInbound', 'Successfully Deleted');
            die();
        }
    }

}