<?php
/**
 * @Email M.sakhamanesh@googlemail.com
 * @param $fields
 */

include_once ROOT_DIR . "component/conference/component/ConferenceModel.php";
include_once ROOT_DIR . "component/package_company/adminPackageCompanyModel.php";
include_once ROOT_DIR . "component/checkdependency/adminCheckDependency.php";
include_once ROOT_DIR . "component/ivr/adminIVRModel.php";
include_once ROOT_DIR . "component/queue/adminQueueModel.php";
include_once ROOT_DIR . "services/UploadService.php";
include_once ROOT_DIR . "component/upload/AdminUploadModel.php";
include_once ROOT_DIR . "component/sip/adminSIPModel.php";
include_once ROOT_DIR . "component/company/AdminCompanyModel.php";
include_once ROOT_DIR . "component/extension.model.php";
include_once ROOT_DIR . "common/init.inc.php";
include_once ROOT_DIR . "common/func.inc.php";
include_once ROOT_DIR . "common/looeic.php";
include_once ROOT_DIR . 'services/dependency/DependencyService.php';
include_once ROOT_DIR . 'services/ConferenceService.php';
include_once ROOT_DIR . 'services/CompanyService.php';
include_once ROOT_DIR . "services/TblDstOptionService.php";
include_once ROOT_DIR . "services/UploadService.php";
include_once ROOT_DIR . "services/ExtensionService.php";
include_once ROOT_DIR . "component/conference/component/ConferencePivoteModel.php";
include_once ROOT_DIR . "component/conference/component/PhoneModel.php";
include_once ROOT_DIR . "component/queue/adminQueueModel.php";
/**
 * Class ConferenceController
 */
class ConferenceController
{
    private $error;
    private $fileName;
    private $exportType;
    private $msg = [];
    private $DSTList = [
        2 => 'Queue',
        3 => 'Extension',
        4 => 'Announce',
        5 => 'IVR',
        6 => 'Voice Mail',
        7 => 'Hang Up',
        8 => 'Time Condition'
    ];

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
    public function showAllConference($message = '')
    {
        $conference = new ConferenceService();
        $list = $conference->getAllConference();
        $this->exportType = 'html';
        $this->fileName = 'conference.show.php';
        $this->template($list, $message);
        die();
    }


    /**
     * @param array $fields
     * @param $message
     */
    public function addConferenceForm($fields = [], $message)
    {

        global $admin_info, $member_info,$company_info;
        
        //////////////get dialExtensionDetail////////////
        $extentionList = new ExtensionService();

        //$fields['extentionList']=array_merge(array(array('id'=>-1,'name'=>'All')),$extentionList->getAllExtensionName());
        $fields['extentionList']=$extentionList->getAllExtensionNameWithType();



        //$fields['extentionList']=array_merge(array('id'=>-1,'name'=>'All'),$extentionList->getAllExtensionName());

        //$fields['dst_option_id'] = $ivrOption->getDialExtensionDetailByName($dialExtension_list);
        $fields['action'] = 'addConference';
        //$fields['direct_dial'] = 1;
        $list = json_encode($fields, JSON_PRETTY_PRINT);

        $this->exportType = 'html';
        $this->fileName = 'conference.form.php';
        $this->template($list, $message);
        die();

    }


    /**
     * @param $fields
     */
    public function addConference($fields)
    {
        global $admin_info, $member_info,$company_info;
        $checharacter = checkForPersianWordsInMultiDimensionalKeyValueArray($fields);
        if ($checharacter==-1) {
            $result['result'] = -1;
            $result['msg'] = 'You used an illegal character';
            echo json_encode($result);
            die();
        }
        $conference = new ConferenceService();
        $result = $conference->addConference($fields);

        if ($result['result'] != 1) {
            $result['result'] = -1;
        }
        echo json_encode($result);
        die();

    }

    /**
     * @param $conferenceID
     * @param $fields
     * @param $message
     */
    public function editConferenceForm($conferenceID, $fields, $message)
    {
        // dd($fields['extentionList']);

        global $admin_info, $member_info,$company_info;
        $conferenceDirty = ConferenceModel::find($conferenceID);

        if (is_array($member_info) and $conferenceDirty->creator_id != $member_info['extension_id'])
        {
            redirectPage(RELA_DIR, "You don't have the permission to this page");
        }

        $fields = $conferenceDirty->fields;

        $extentionList = new ExtensionService();

        //$fields['extentionList']=array_merge(array(array('id'=>-1,'name'=>'All')),$extentionList->getAllExtensionName());
        $fields['extentionList']=$extentionList->getAllExtensionNameWithType();
        //********jahanbakhsh
        //not empty  extention
        if (!isset($fields['extentionList']) || empty($fields['extentionList']))
        {
            $result['result'] = -1;
            $result['msg'] = 'select extention list is required!';
        }

        //conference_pivote
        $conferencePivoteobj = ConferencePivoteModel::getBy_conf_id($conferenceID)->getlist();



        if($conferencePivoteobj['export']['list'][0]['number_type']=='3'){
            $fields['extentionList_selected'] = $extentionList->getAllExtensionNameWithType();
            $fields['all_extension_list'] = 1;
        }


        $phoneIdList=array();
        foreach ($conferencePivoteobj['export']['list'] as $key => $value)
        {

            if($value['number_type']=='1')
            {
                $fields['extentionList_selected'][$key] = $value['number_id'];
            }


            else {
                $phoneIdList[]=$value['number_id'];

            }

        }


        //********jahanbakhsh
        //not empty phone (and extention)

        if (!empty($phoneIdList) || isset($phoneIdList)) {

            $result = PhoneModel::getBy_phone_id($phoneIdList)->getList();
            //print_r_debug($result);

            foreach ($result['export']['list'] as $key => $field) {
                $fields['phoneList_selected'][$key] = $field['phone_number'];

            }
            //$fields['phoneList_selected']= substr($phone,0,-1);
        }

        $fields['action'] = 'editConference';

        $list = json_encode($fields, JSON_PRETTY_PRINT);

        $this->exportType = 'html';
        $this->fileName = 'conference.form.php';
        $this->template($list, $message);
        die();

    }

    public function checkErrorNo($result)
    {
        if ($result['result'] != 1) {
            if (isset($result['no']) and $result['no'] = '101') {
                redirectPage(RELA_DIR . 'conference.php?action=showConference', "You don't have the permission to this page");

            }
        }

    }

    public function editConference($fields)
    {
        global $company_info;
        $checharacter = checkForPersianWordsInMultiDimensionalKeyValueArray($fields);
        if ($checharacter==-1) {
            $result['result'] = -1;
            $result['msg'] = 'You used an illegal character';
            echo json_encode($result);
            die();
        }
        $conference = new ConferenceService();
        $result = $conference->editConference($fields);
        if ($result['result'] != 1) {
            $this->checkErrorNo($result);
            $result['result'] = -1;
            echo json_encode($result);
            die();
        }
        $company = new companyService();
        $result = $company->activeRelaod($company_info['comp_id']);
        echo json_encode($result);
        die();

    }

    public function deleteConference($conferenceID)
    {
        global $company_info;

        $conference = new ConferenceService();
        $result = $conference->deleteConferenceByConferenceId($conferenceID);

        if ($result['result'] != 1) {
            $this->checkErrorNo($result);
            $result['result'] = -1;
            $result['msg'] = 'Failed To Delete';
            $this->showAllConference($result['msg']);
            die();
        } else {
            $company = new CompanyService();
            $company->activeRelaod($company_info['comp_id']);
            $result['msg'] = 'Successfully Deleted';
            redirectPage(RELA_DIR . 'conference.php?action=showConference', 'Successfully Deleted');
            die();
        }
    }

}