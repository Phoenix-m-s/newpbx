<?php
include_once ROOT_DIR . "component/extension/AdminExstionNewModel.php";
include_once ROOT_DIR . "component/timeCondition/mainTimeConditionModel.php";
include_once ROOT_DIR . "component/dialDestination/adminDialDestinationController.php";
include_once ROOT_DIR . "component/ivr/adminIVRModel.php";
include_once ROOT_DIR . "component/queue/adminQueueModel.php";
include_once ROOT_DIR . "component/announce/adminAnnounceModel.php";
include_once ROOT_DIR . "component/company/AdminCompanyModel.php";
include_once ROOT_DIR . "component/extension.model.php";
include_once ROOT_DIR . "common/init.inc.php";
include_once ROOT_DIR . "common/func.inc.php";
//die('a');
include_once ROOT_DIR . "services/ExtensionService.php";
include_once ROOT_DIR . "component/Responce.php";


include_once ROOT_DIR . "component/conference/component/ConferenceModel.php";
include_once ROOT_DIR . "common/db.inc.php";
include_once ROOT_DIR . "component/db.inc.class.php";
include_once ROOT_DIR . "component/php-ami-class.php";

/**
 * Class extensionController
 */
class extensionControllerNew
{

    /**
     * @var array
     */
    private $days = [];
    /**
     * @var array
     */
    private $WeekdaysName = ['sat', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
    /**
     * @var array
     */
    private $monthsName = ['January', 'february', 'march', 'april', 'may', 'june', 'july', 'August', 'September', 'October', 'November', 'December'];
    /**
     * @var array
     */
    private $forwardList = ['choose', 'internal', 'external'];
    /**
     * @var array
     */
    private $voiceMailList = ['withOutMessage', 'defaultMessage', 'customMessageByList', 'customMessageByRecord'];
    /**
     * @var array
     */
    private $dialExtensionList = ['HangUp', 'voiceMail', 'forward', 'IVR', 'Queue', 'Announce', 'fax'];

    private $dialExtensionListLabel = array('HangUp' => 'HangUp', 'VoiceMail' => 'voiceMail', 'Forward' => 'forward', 'IVR' => 'IVR', 'Queue' => 'Queue', 'Announce' => 'Announce', 'Fax' => 'fax');

    /**
     * @var
     */
    public $exportType;
    /**
     * @var
     */
    public $fileName;

    /*
    | -----------------------------------------------------------------------------------------------------------------
    | SHOW THE RELATED TEMPLATES
    | -----------------------------------------------------------------------------------------------------------------
    */
    /**
     * @param array $list
     * @param string $message
     */
    public function template($list = [], $message = '')
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

            default:
                break;
        }
    }

    /**
     * set a destination template address and needed variables in this method and it will show it like ABC
     *
     * @var $fields
     * @var $destination
     * @var $msg
     */
    private function showRelatedTemplate($fields, $destination, $msg = '')
    {
        $this->exportType = 'html';
        $this->fileName = $destination;
        $this->template($fields, $msg);
        die();
    }

    /**
     * show main page of the Time Condition(a list of available time conditions
     *
     */
    public function showTimeConditionPage()
    {
        $list = AdminMainTimeConditionModel::getAll()->getList();

        $export = $list['export']['list'];

        $this->exportType = 'html';
        $this->fileName = 'timeCondition.php';
        $this->template($export, '');
        die();
    }

    /**
     *
     */
    public function showTimeConditionAddForm()
    {

        $list['fields']['voice_list'] = $this->getVoiceList();
        $list['fields']['ExtensionList'] = $this->getActiveExtensionList();

        for ($i = 1; $i < 31; $i++) {
            $this->days[] = $i;
        }

        $list['fields']['forwardList'] = $this->forwardList;
        $list['fields']['voiceMailList'] = $this->voiceMailList;
        $list['fields']['dialExtensionList'] = $this->dialExtensionList;
        $list['fields']['FDialExtension'] = $this->dialExtensionListLabel;
        $list['fields']['weekDaysName'] = $this->WeekdaysName;
        $list['fields']['days'] = $this->days;
        $list['fields']['monthsName'] = $this->monthsName;
        $list['fields']['monthsName'] = $this->monthsName;
        $result['result'] = -1;
        $this->exportType = 'html';
        $this->fileName = 'addTimeConditionNew.php';
        $this->template($list, '');
    }


    /**
     * show "time condition edit" form
     *
     * @param int $id
     */
    public function showTimeConditionEditForm($id)
    {

        $extensionDirty = AdminExtensionModel::getAll()->getList();
        $extensionClean = $extensionDirty['export']['list'];
        foreach ($extensionClean as $key => $value) {
            $help[$value['extension_id']] = $value['extension_name'];
        }
        $fields['extensionList'] = $help;
        unset($help);
        $fields['IVRList'] = $this->getIVRList($fields);
        $fields['QueueList'] = $this->getQueueList($fields);
        $fields['AnnounceList'] = $this->getAnnounceList($fields);
        $fields['ExtensionList'] = $this->getActiveExtensionList($fields);
        $fields = $this->setArraysToFields($fields);
        $fields['plus'] = 0;
        $timeConditionDirty = AdminMainTimeConditionModel::find($id);
        $timeConditionID = $timeConditionDirty->id;
        $timeCondition = AdminMainTimeConditionDetailModel::getBy_timeConditionID($timeConditionID)->getList();
        $timeConditionClean = $timeCondition['export']['list'];
        $timeConditionName = AdminMainTimeConditionModel::find($timeConditionID);

        if ($timeCondition['result'] != 1) {
            return $timeCondition['msg'];
        }

        $fields = $this->reArrangeData($fields, $timeConditionClean);
        $fields = $this->getVoiceList($fields);
        $fields['action'] = 'editTimeCondition';
        $fields['name'] = $timeConditionName->name;
        $fields['json']['tc'] = $fields['tc'];
        $fields['json']['failTc'] = $fields['failTc'];
        $fields['json']['name'] = $fields['name'];
        $fields['json']['comp_id'] = $id;
        $fields['json']['action'] = $fields['action'];
        $result['fields'] = $fields;
        $result['result'] = 1;

        $result['msg'] = 'Successfully Update';
        $this->exportType = 'html';
        $this->fileName = 'addTimeConditionNew.php';
        $this->template($result, '');
        die();

    }

    /*
    | -----------------------------------------------------------------------------------------------------------------
    | SUBMIT ALL THE DATA INTO DATABASE
    | -----------------------------------------------------------------------------------------------------------------
    */
    /**
     * add new time condition into database
     *
     * @param array $fields
     */
    public function addTimeCondition($fields)
    {
        global $company_info, $member_info;
        $fields['comp_id'] = $company_info['comp_id'];
        $fields['member_id'] = $member_info['member_id'];
        $timeConditionModel = new AdminMainTimeConditionModel($fields);
        $result1 = $timeConditionModel->SetFieldsAndSave($fields);
        if ($result1['result'] == -1) {
            echo json_encode($result1);
            die();
        }

        $fields['timeConditionID'] = $result1['timeConditionID'];
        $fields['comp_id'] = $company_info['comp_id'];
        $timeConditionDetailModel = new AdminMainTimeConditionDetailModel();
        $result2 = $timeConditionDetailModel->SetFieldsAndSave($fields);
        $companyObj = new AdminCompanyModel();
        $company = $companyObj->find($company_info['comp_id']);
        $company->reload_alert = 1;
        $company->save();
        $result['fields'] = $fields;
        $result['result'] = 1;
        $result['msg'] = 'Successfully Update';
        echo json_encode($result);
        die();
    }

    /**
     * edit time condition into database
     *
     * @param array $fields
     * @author m.sakhamanesh@googlemail.com
     * @date 2018/23/6
     * @version 0.0.1
     *
     */
    public function editTimeCondition($fields)
    {

        global $company_info;

        $fields['timeConditionID'] = $fields['id'];
        $fields['comp_id'] = $company_info['comp_id'];
        $timeConditionModel = new AdminMainTimeConditionDetailModel();
        if ($timeConditionModel::getBy_timeConditionID($fields['timeConditionID'])->getList()['export']['recordsCount'] == 0) {
            $result = $timeConditionModel->SetFieldsAndSave($fields);
            if ($result['result'] == -1) {
                $result['msg'] = 'error ';
                echo json_encode($result);
                die();
            }
        } else {

            $timeCondition = $timeConditionModel::getBy_timeConditionID($fields['timeConditionID'])->get();
            foreach ($timeCondition['export']['list'] as $timeCondition) {
                $timeCondition->delete();
            }

            $result = $timeConditionModel->SetFieldsAndSave($fields);
            if ($result['result'] == -1) {
                $result['msg'] = 'error ';
                echo json_encode($result);
                die();
            }
            $timeConditionModelName = AdminMainTimeConditionModel::find($fields['timeConditionID']);
            $timeConditionModelName->name = $fields['name'];
            $result = $timeConditionModelName->save();
            $companyObj = new AdminCompanyModel();
            $company = $companyObj->find($company_info['comp_id']);
            $company->reload_alert = 1;
            $company->save();
            if ($result['result'] == -1) {
                $result['msg'] = 'error ';
                echo json_encode($result);
                die();
            }
        }
        $result['fields'] = $fields;
        $result['result'] = 1;
        $result['msg'] = "Successfully Update";
        echo json_encode($result);
        die();
    }

    /**
     * delete time condition and all it's data
     *
     * @param int $timeConditionID
     */
    public function deleteTimeCondition($timeConditionID)
    {
        global $company_info;
        /*
        | -----------------------------------------------------------------------------------------------------------------
        | find time condition's details first
        | -----------------------------------------------------------------------------------------------------------------
        */
        $detailedTimeConditionObj = new AdminMainTimeConditionDetailModel();
        $detailedTimeCondition = $detailedTimeConditionObj::getBy_timeConditionID($timeConditionID)->get();

        /*
        | -----------------------------------------------------------------------------------------------------------------
        | delete the details first
        | -----------------------------------------------------------------------------------------------------------------
        */
        foreach ($detailedTimeCondition['export']['list'] as $timeCondition) {

            $result1 = $timeCondition->delete();

            if ($result1['result'] != 1) {
                $destination = 'mainTimeCondition.php';
                $this->showRelatedTemplate('', $destination, '');
            }
        }


        $timeConditionObj = new AdminMainTimeConditionModel();
        $result2 = $timeConditionObj::find($timeConditionID);

        /*
        | -----------------------------------------------------------------------------------------------------------------
        | if the details have been deleted successfully
        | -----------------------------------------------------------------------------------------------------------------
        */
        if (!is_object($result2)) {
            $destination = 'mainTimeCondition.php';
            $this->showRelatedTemplate('', $destination, '');
        }

        /*
        | -----------------------------------------------------------------------------------------------------------------
        | finally delete the time extension himself
        | -----------------------------------------------------------------------------------------------------------------
        */
        $result3 = $result2->delete();
        $companyObj = new AdminCompanyModel();
        $company = $companyObj->find($company_info['comp_id']);

        $company->reload_alert = 1;
        $company->save();

        if ($result3['result'] == 1) {
            redirectPage(RELA_DIR . "mainTimeCondition.php", ModelANNOUNCE_17);
        } else {
            $destination = 'mainTimeCondition.php';
            $this->showRelatedTemplate('', $destination, '');
        }

    }

    /*
    | -----------------------------------------------------------------------------------------------------------------
    | VALIDATE INPUTS AND OUTPUTS IN TIME CONDITION
    | -----------------------------------------------------------------------------------------------------------------
    */
    /**
     * It adds a new time condition whenever user click on "+" button and there is no TIME-CONFLICT
     *
     * @var $fields
     */
    public function validateTimeArray(&$fields)
    {
        $this->setArraysToFields($fields);

        $this->reFactorTimeVariable($fields);

        $this->checkTimeConflict($fields);

        $this->getExtensionArrays($fields);

        unset($fields['id']);
        $fields['id'] = $fields['TCID'];
        if ($fields['status'] == 1) {
            $destination = 'addTimeConditionNew.php';
        } else {
            $destination = 'editTimeCondition.php';
        }

        $this->getVoiceList($fields);

        $this->getIVRList($fields);

        $this->getQueueList($fields);

        $this->getAnnounceList($fields);

        $this->getActiveExtensionList($fields);

        $this->showRelatedTemplate($fields, $destination, '');

    }

    /**
     * checks if There is no Time conflict in the inserted array
     *
     * @var $fields
     */
    private function checkTimeConflict(&$fields)
    {
        $fields['error'] = array();

        /*
        | -----------------------------------------------------------------------------------------------------------------
        | this method is 598 faster than counting the size inside of loop
        | The slow one i.e: for ($i = 0; $i < count($var); $i++)
        | The fast one i.e: $limit = count($var)
        | for ($i = 0; $i < $limit $i++)
        | -----------------------------------------------------------------------------------------------------------------
        */
        $limit = count($fields['monthStart']) - 1;

        /*
        | -----------------------------------------------------------------------------------------------------------------
        | if the + button clicked for first/second time then add the time
        | condition The fields['plus'] value shows if there will be
        | new time condition or not (0 = false, 1 = true)
        | -----------------------------------------------------------------------------------------------------------------
        */
        if ($limit == -1 or $limit == 0) {
            $fields['plus'] = 1;
        }

        /*
        | -----------------------------------------------------------------------------------------------------------------
        | if the 'hour start' is equal with 'hour end' then add an error
        | the 'hour end' always must be greater than 'hour start'
        | -----------------------------------------------------------------------------------------------------------------
        */
        for ($i = 0; $i <= $limit; $i++) {
            $fields['error'][$i] = 0;
            if ($fields['hourStart'][$i] == $fields['hourEnd'][$i]) {
                $fields['error'][$i] = 2;
                $fields['plus'] = 0;
            } else {
                $fields['error'][$i] = 0;
            }
        }

        /*
        | -----------------------------------------------------------------------------------------------------------------
        | Checking if there is more than 1 input then compare the entry value
        | with the previous existence, so there will be no time conflict
        | -----------------------------------------------------------------------------------------------------------------
        */
        if ($limit >= 1) {
            for ($i = 0; $i < $limit; $i++) {
                if (
                    /*
                    | -----------------------------------------------------------------------------------------------------------------
                    | check if the entry's Start Time is between the
                    | previous value's Start Time and End Time
                    | -----------------------------------------------------------------------------------------------------------------
                    */
                    ($fields['hourStart'][$limit] >= $fields['hourStart'][$i] and $fields['hourStart'][$limit] <= $fields['hourEnd'][$i])
                    or
                    /*
                    | -----------------------------------------------------------------------------------------------------------------
                    | check if the entry's Start Time is before the
                    | previous value's and entry's End Time is
                    | before the previous value's End Time
                    | -----------------------------------------------------------------------------------------------------------------
                    */
                    ($fields['hourStart'][$limit] <= $fields['hourStart'][$i] and $fields['hourEnd'][$limit] >= $fields['hourStart'][$i])
                ) {
                    if (
                        /*
                        | -----------------------------------------------------------------------------------------------------------------
                        | check if the entry's Start Day is between the
                        | previous value's Start Day and End Day
                        | -----------------------------------------------------------------------------------------------------------------
                        */
                        ($fields['weekDayStart'][$limit] >= $fields['weekDayStart'][$i] and $fields['weekDayStart'][$limit] <= $fields['weekDayEnd'][$i])
                        or
                        /*
                        | -----------------------------------------------------------------------------------------------------------------
                        | check if the entry's Start Day is before the
                        | previous value's and entry's End Day is
                        | before the previous value's End Day
                        | -----------------------------------------------------------------------------------------------------------------
                        */
                        ($fields['weekDayStart'][$limit] <= $fields['weekDayStart'][$i] and $fields['weekDayEnd'][$limit] >= $fields['weekDayStart'][$i])
                    ) {
                        if (
                            /*
                            | -----------------------------------------------------------------------------------------------------------------
                            | check if the entry's Start Day is between the
                            | previous value's Start Day and End Day
                            | -----------------------------------------------------------------------------------------------------------------
                            */
                            ($fields['dayStart'][$limit] >= $fields['dayStart'][$i] and $fields['dayStart'][$limit] <= $fields['dayEnd'][$i])
                            or
                            /*
                            | -----------------------------------------------------------------------------------------------------------------
                            | check if the entry's Start Day is before the previous
                            | value's and entry's End Day is before the
                            | previous value's End Day
                            | -----------------------------------------------------------------------------------------------------------------
                            */
                            ($fields['dayStart'][$limit] <= $fields['dayStart'][$i] and $fields['dayEnd'][$limit] >= $fields['dayStart'][$i])
                        ) {
                            if (
                                /*
                                | -----------------------------------------------------------------------------------------------------------------
                                | check if the entry's Start Month is between the
                                | previous value's Start month and End Month
                                | -----------------------------------------------------------------------------------------------------------------
                                */
                                ($fields['monthStart'][$limit] >= $fields['monthStart'][$i] and $fields['monthStart'][$limit] <= $fields['monthEnd'][$i])
                                or

                                /*
                                | -----------------------------------------------------------------------------------------------------------------
                                | check if the entry's Start Month is before the previous
                                | value's and entry's End Month is before the
                                | previous value's End Month
                                | -----------------------------------------------------------------------------------------------------------------
                                */
                                ($fields['monthStart'][$limit] <= $fields['monthStart'][$i] and $fields['monthEnd'][$limit] >= $fields['monthStart'][$i])
                            ) {
                                $fields['error'][$i] = 1;
                            }
                        }
                    }
                }
            }
        }
        for ($i = 0; $i <= $limit; $i++) {

            /*
            | -----------------------------------------------------------------------------------------------------------------
            | checking if there is a error or no ( conflict ) !
            | -----------------------------------------------------------------------------------------------------------------
            */

            if ($fields['error'][$i] != 0) {
                $fields['plus'] = 0;

                break;
            } else {
                $fields['plus'] = 1;
            }
        }
        return $fields;

    }

    /**
     * checks if There is no Time conflict in the inserted array
     *
     * @var $fields
     */
    private function checkTimeConflictTimeCondition($fields)
    {


        $fields['error'] = array();
        /*
        | -----------------------------------------------------------------------------------------------------------------
        | this method is 598 faster than counting the size inside of loop
        | The slow one i.e: for ($i = 0; $i < count($var); $i++)
        | The fast one i.e: $limit = count($var)
        | for ($i = 0; $i < $limit $i++)
        | -----------------------------------------------------------------------------------------------------------------
        */
        $limit = count($fields['monthStart']) - 1;


        /*
        | -----------------------------------------------------------------------------------------------------------------
        | if the + button clicked for first/second time then add the time
        | condition The fields['plus'] value shows if there will be
        | new time condition or not (0 = false, 1 = true)
        | -----------------------------------------------------------------------------------------------------------------
        */
        if ($limit == -1 or $limit == 0) {
            //die('1');
            $fields['plus'] = 1;
        }
        /*
        | -----------------------------------------------------------------------------------------------------------------
        | if the 'hour start' is equal with 'hour end' then add an error
        | the 'hour end' always must be greater than 'hour start'
        | -----------------------------------------------------------------------------------------------------------------
        */
        for ($i = 0; $i <= $limit; $i++) {
            $fields['error'][$i] = 0;
            if ($fields['hourStart'][$i] == $fields['hourEnd'][$i]) {

                $fields['error'][$i] = 2;
                $fields['plus'] = 0;
            } else {
                $fields['error'][$i] = 0;
            }
        }

        /*
        | -----------------------------------------------------------------------------------------------------------------
        | Checking if there is more than 1 input then compare the entry value
        | with the previous existence, so there will be no time conflict
        | -----------------------------------------------------------------------------------------------------------------
        */
        if ($limit >= 1) {
            for ($i = 0; $i < $limit; $i++) {
                if (
                    /*
                    | -----------------------------------------------------------------------------------------------------------------
                    | check if the entry's Start Time is between the
                    | previous value's Start Time and End Time
                    | -----------------------------------------------------------------------------------------------------------------
                    */
                    ($fields['hourStart'][$limit] >= $fields['hourStart'][$i] and $fields['hourStart'][$limit] <= $fields['hourEnd'][$i])
                    or
                    /*
                    | -----------------------------------------------------------------------------------------------------------------
                    | check if the entry's Start Time is before the
                    | previous value's and entry's End Time is
                    | before the previous value's End Time
                    | -----------------------------------------------------------------------------------------------------------------
                    */
                    ($fields['hourStart'][$limit] <= $fields['hourStart'][$i] and $fields['hourEnd'][$limit] >= $fields['hourStart'][$i])
                ) {
                    if (
                        /*
                        | -----------------------------------------------------------------------------------------------------------------
                        | check if the entry's Start Day is between the
                        | previous value's Start Day and End Day
                        | -----------------------------------------------------------------------------------------------------------------
                        */
                        ($fields['weekDayStart'][$limit] >= $fields['weekDayStart'][$i] and $fields['weekDayStart'][$limit] <= $fields['weekDayEnd'][$i])
                        or
                        /*
                        | -----------------------------------------------------------------------------------------------------------------
                        | check if the entry's Start Day is before the
                        | previous value's and entry's End Day is
                        | before the previous value's End Day
                        | -----------------------------------------------------------------------------------------------------------------
                        */
                        ($fields['weekDayStart'][$limit] <= $fields['weekDayStart'][$i] and $fields['weekDayEnd'][$limit] >= $fields['weekDayStart'][$i])
                    ) {
                        if (
                            /*
                            | -----------------------------------------------------------------------------------------------------------------
                            | check if the entry's Start Day is between the
                            | previous value's Start Day and End Day
                            | -----------------------------------------------------------------------------------------------------------------
                            */
                            ($fields['dayStart'][$limit] >= $fields['dayStart'][$i] and $fields['dayStart'][$limit] <= $fields['dayEnd'][$i])
                            or
                            /*
                            | -----------------------------------------------------------------------------------------------------------------
                            | check if the entry's Start Day is before the previous
                            | value's and entry's End Day is before the
                            | previous value's End Day
                            | -----------------------------------------------------------------------------------------------------------------
                            */
                            ($fields['dayStart'][$limit] <= $fields['dayStart'][$i] and $fields['dayEnd'][$limit] >= $fields['dayStart'][$i])
                        ) {
                            if (
                                /*
                                | -----------------------------------------------------------------------------------------------------------------
                                | check if the entry's Start Month is between the
                                | previous value's Start month and End Month
                                | -----------------------------------------------------------------------------------------------------------------
                                */
                                ($fields['monthStart'][$limit] >= $fields['monthStart'][$i] and $fields['monthStart'][$limit] <= $fields['monthEnd'][$i])
                                or

                                /*
                                | -----------------------------------------------------------------------------------------------------------------
                                | check if the entry's Start Month is before the previous
                                | value's and entry's End Month is before the
                                | previous value's End Month
                                | -----------------------------------------------------------------------------------------------------------------
                                */
                                ($fields['monthStart'][$limit] <= $fields['monthStart'][$i] and $fields['monthEnd'][$limit] >= $fields['monthStart'][$i])
                            ) {
                                $fields['error'][$i] = 1;
                            }
                        }
                    }
                }
            }
        }
        for ($i = 0; $i <= $limit; $i++) {

            /*
            | -----------------------------------------------------------------------------------------------------------------
            | checking if there is a error or no ( conflict ) !
            | -----------------------------------------------------------------------------------------------------------------
            */

            if ($fields['error'][$i] != 0) {
                $fields['plus'] = 0;

                break;
            } else {
                $fields['plus'] = 1;
            }
        }
        //print_r_debug($fields);
        return $fields;

    }

    /**
     * Change time format from HH:MM:SS to HH.MM so we can compare the time conflict
     *
     * @var $fields
     */
    private function reFactorTimeVariable(&$fields)
    {
        /*
        | -----------------------------------------------------------------------------------------------------------------
        | Reformatting Time from any format to HH:MM:SS with
        | adding 0 before H if the hour is before 10
        | -----------------------------------------------------------------------------------------------------------------
        */
        for ($i = 0; $i < count($fields['hourStart']); $i++) {
            if (substr($fields['hourStart'][$i], 0, 2) < 10) {
                $fields['hourStart'][$i] = '0' . $fields['hourStart'][$i];
            }
            if (substr($fields['hourEnd'][$i], 0, 2) < 10) {
                $fields['hourEnd'][$i] = '0' . $fields['hourEnd'][$i];
            }

            /*
            | -----------------------------------------------------------------------------------------------------------------
            | Reformatting the Time from HH:MM:SS to HH.MM, so we can
            | compare it with previous ones(conflict check)
            | -----------------------------------------------------------------------------------------------------------------
            */
            $fields['hourStart'][$i] = str_replace(':', '.', $fields['hourStart'][$i]);
            $fields['hourEnd'][$i] = str_replace(':', '.', $fields['hourEnd'][$i]);
            $fields['hourStart'][$i] = substr($fields['hourStart'][$i], 0, 5);
            $fields['hourEnd'][$i] = substr($fields['hourEnd'][$i], 0, 5);
        }
        return $fields;

    }

    /**
     * Change the Time Format From HH.MM to HH:MM:SS
     *
     * @var $fields
     */
    private function deFactorTimeVariable(&$fields)
    {

        for ($i = 0; $i < count($fields['hourStart']); $i++) {

            /*
            | -----------------------------------------------------------------------------------------------------------------
            | Reformatting the time from HH.MM to HH.MM.SS with adding 00
            | -----------------------------------------------------------------------------------------------------------------
            */
            $fields['hourStart'][$i] = $fields['hourStart'][$i] . ':00';
            $fields['hourEnd'][$i] = $fields['hourEnd'][$i] . ':00';

            /*
            | -----------------------------------------------------------------------------------------------------------------
            | Reformatting the time from HH.MM.SS with replacing : instead of.
            | -----------------------------------------------------------------------------------------------------------------
            */
            $fields['hourStart'][$i] = str_replace('.', ':', $fields['hourStart'][$i]);
            $fields['hourEnd'][$i] = str_replace('.', ':', $fields['hourEnd'][$i]);
        }
    }

    /**
     * baraye darje arayeyi az liste extensionhaye mojod dar DataBase va insert shode dar TimeTable
     *
     * @var $fields
     */
    private function getExtensionArrays($fields)
    {
        //print_r_debug($fields['timeConditionID']);
        if (isset($fields['action'])) {
            /*
            | -----------------------------------------------------------------------------------------------------------------
            | find the All time conditons
            | -----------------------------------------------------------------------------------------------------------------
            */
            /*$timeScheduleDirty = AdminMainTimeConditionDetailModel::getBy_timeConditionID($fields['timeConditionID'])->getList();
            $timeScheduleClean = $timeScheduleDirty['export']['list'];*/


            /*
            | -----------------------------------------------------------------------------------------------------------------
            | setting the found Extension and other arrays in
            | the html format in the $fields variable
            | -----------------------------------------------------------------------------------------------------------------
            */
            /*$this->reArrangeData($fields, $timeScheduleClean);*/
            /*$help = array();
            $ExtensionDirty = AdminExtensionModel::getAll()->getList();
            $ExtensionClean = $ExtensionDirty['export']['list'];
            foreach ($ExtensionClean as $key => $value) {
                $help[] = $value['ExtensionList'];
            }
            $fields['ExtensionList'] = $help;*/


            /*
            | -----------------------------------------------------------------------------------------------------------------
            | Get All the Extension name list from database
            | -----------------------------------------------------------------------------------------------------------------
            */
            $extensionDirty = adminExtensionModel::getAll()->getList();
            //print_r_debug($extensionDirty);
            $extensionClean = $extensionDirty['export']['list'];

            /*
            | -----------------------------------------------------------------------------------------------------------------
            | set the all the Extension name List to the output variable
            | -----------------------------------------------------------------------------------------------------------------
            */
            foreach ($extensionClean as $key => $value) {
                $help[] = $value['extension_id'];
            }

            $fields['extension_no'] = $help;

            //print_r_debug($fields);

            return $fields;
        }

    }

    /**
     * @param $fields
     * @param $timeScheduleClean
     * @return mixed
     */
    private function reArrangeData($fields, $timeScheduleClean)
    {


        for ($i = 0; $i < count($timeScheduleClean); $i++) {
            $fields['tc'][$i]['hourStart'] = $timeScheduleClean[$i]['hourStart'];
            $fields['tc'][$i]['hourEnd'] = $timeScheduleClean[$i]['hourEnd'];
            $fields['tc'][$i]['timeConditionID'] = $timeScheduleClean[$i]['timeConditionID'];
            $fields['tc'][$i]['weekDayStart'] = $timeScheduleClean[$i]['weekDayStart'];
            $fields['tc'][$i]['weekDayEnd'] = $timeScheduleClean[$i]['weekDayEnd'];
            $fields['tc'][$i]['dayStart'] = $timeScheduleClean[$i]['dayStart'];
            $fields['tc'][$i]['dayEnd'] = $timeScheduleClean[$i]['dayEnd'];
            $fields['tc'][$i]['monthStart'] = $timeScheduleClean[$i]['monthStart'];
            $fields['tc'][$i]['monthEnd'] = $timeScheduleClean[$i]['monthEnd'];
            $fields['tc'][$i]['dialExtension'] = $timeScheduleClean[$i]['dialExtension'];
            $fields['tc'][$i]['forward'] = $timeScheduleClean[$i]['forward'];
            $fields['tc'][$i]['DSTOption'] = $timeScheduleClean[$i]['DSTOption'];
            $fields['tc'][$i]['id'] = $timeScheduleClean[$i]['id'];
            $fields['tc'][$i]['sub_dst'] = $timeScheduleClean[$i]['sub_dst'];
            $fields['failTc'][$i]['FDialExtension'] = $timeScheduleClean[$i]['FDialExtension'];
            $fields['failTc'][$i]['FForward'] = $timeScheduleClean[$i]['FForward'];
            $fields['failTc'][$i]['FDSTOption'] = $timeScheduleClean[$i]['FDSTOption'];
            $fields['failTc'][$i]['FSub_dst'] = $timeScheduleClean[$i]['FSub_dst'];
        }

        return $fields;
    }

    /**
     * to fill selects in the html page dynamically.
     *
     * @var $fields
     */
    private function setArraysToFields($fields)
    {


        for ($i = 1; $i < 31; $i++) {
            $this->days[] = $i;
        }

        $fields['forwardList'] = $this->forwardList;
        $fields['voiceMailList'] = $this->voiceMailList;
        $fields['dialExtensionList'] = $this->dialExtensionListLabel;
        $fields['weekDaysName'] = $this->WeekdaysName;
        $fields['days'] = $this->days;
        $fields['monthsName'] = $this->monthsName;
        return $fields;


    }

    /**
     * Gives a list, of all the voices
     *
     * @var $fields
     */
    private function getVoiceList($fields)
    {

        global $admin_info, $member_info;
        if ($admin_info != -1) {
            $company_id = $admin_info['comp_id'];
            $fields['voiceDirty'] = AdminUploadModel::getBy_comp_id($company_id)->getList()['export']['list'];
        } elseif ($member_info != -1) {
            $company_id = $member_info['comp_id'];
            $extension_id = $fields['Extension_ID'];
            $fields['voiceDirty'] = AdminUploadModel::getBy_comp_id_and_extension_id($company_id, $extension_id)->getList()['export']['list'];
        }

        return $fields;
    }

    /**
     * Gives a list, of all the IVRs
     *
     * @var $fields
     */
    private function getIVRList()
    {

        $help = array();
        $IVRDirty = AdminIVRModel::getAll()->getList();
        $IVRClean = $IVRDirty['export']['list'];
        foreach ($IVRClean as $key => $value) {
            $help[] = $value['ivr_name'];
        }
        $fields['IVRList'] = $help;
        return $fields;
    }


    /**
     * Gives a list, of all the uploads
     *
     * @var $fields
     */
    private function getVoiceArrays(&$fields)
    {
        global $admin_info, $member_info;
        if ($admin_info != -1) {
            $company_id = $admin_info['comp_id'];
            $voiceDirty = AdminUploadModel::getBy_comp_id($company_id)->getList();
        } elseif ($member_info != -1) {
            $company_id = $member_info['comp_id'];
            $extension_id = $fields['Extension_ID'];
            $voiceDirty = AdminUploadModel::getBy_comp_id_and_extension_id($company_id, $extension_id)->getList();
        }

        $voiceClean = $voiceDirty['export']['list'];
        $fields['voiceList'] = $voiceClean;
    }

    /**
     * Gives a list, of all the uploads
     *
     * @var $fields
     */
    private function getActiveExtensionList()
    {
        return AdminExtensionModel::getBy_voiceMail_status(1)->getList()['export']['list'];

    }

    /**
     * Gives a list, of all the Queues
     *
     * @var $fields
     */
    private function getQueueList($fields)
    {
        $help = array();
        $queueDirty = AdminQueueModel::getAll()->getList();
        $queueClean = $queueDirty['export']['list'];
        foreach ($queueClean as $key => $value) {
            $help[] = $value['queue_name'];
        }

        $fields['queueList'] = $help;

        return $fields['queueList'];
    }

    /**
     * Gives a list, of all the Announces
     *
     * @var $fields
     */
    private function getAnnounceList($fields)
    {
        $help = array();
        $announceDirty = AdminAnnounceModel::getAll()->getList();
        $announceClean = $announceDirty['export']['list'];
        foreach ($announceClean as $key => $value) {
            $help[] = $value['announce_name'];
        }
        $fields['announceList'] = $help;
        return $fields['announceList'];
    }

    /*
    | -----------------------------------------------------------------------------------------------------------------
    | TIME CONDITION DIAL EXTENSION SECTION USING AJAX
    | -----------------------------------------------------------------------------------------------------------------
    */
    public function extensionList($fields)
    {
        $status = $fields['name'];
        $dialDestination = new AdminDialDestinationController();
        $extensionDirty = AdminExtensionModel::getBy_voiceMail_status(1)->getList();

        foreach ($extensionDirty['export']['list'] as $key => $value) {
            $extensionList[$value['extension_id']] = $value['extension_no'];
        }

        if ($status == 'success') {
            $dialDestination->activeExtension($extensionList, 'sub_dst[]');
        } elseif ($status == 'failed') {
            $dialDestination->activeExtension($extensionList, 'FSub_dst');
        }
    }

    /**
     * Fill the Forward Combo Box Using Ajax in the Time Condition Section(Both of Them)
     *
     * @var $input
     */
    public function timeConditionForwardSelectTag($input)
    {

        $dialDestination = new AdminDialDestinationController();
        $status = $input['status'];

        switch ($input['dialExtension']) {
            case 'directDial' :
                if ($status == 'success') {
                    $dialDestination->directDial('forward[]', 'DSTOption[]');
                } elseif ($status == 'failed') {
                    $dialDestination->directDial('FForward', 'FDSTOption');
                }
                break;

            case 'voiceMail' :

                if ($status == 'success') {
                    $dialDestination->voiceMail('forward[]', 'forward');
                } elseif ($status == 'failed') {
                    $dialDestination->voiceMail('FForward', 'FForward');
                }
                break;

            case 'forward' :
                if ($status == 'success') {
                    $dialDestination->forward('forward[]', 'forward');
                } elseif ($status == 'failed') {
                    $dialDestination->forward('FForward', 'FForward');
                }
                break;

            case 'IVR':
                $IVRObject = new adminIVRModel();
                $IVRListDirty = $IVRObject->getAll()->get();
                $IVRListClean = $IVRListDirty['export']['list'];
                if ($status == 'success') {
                    $dialDestination->IVR($IVRListClean, 'forward[]', 'forward', 'DSTOption[]');
                } elseif ($status == 'failed') {
                    $dialDestination->IVR($IVRListClean, 'FForward', 'FForward', 'FDSTOption');
                }
                break;

            case 'Queue':
                $queueObj = new adminQueueModel();
                $queueListDirty = $queueObj->getAll()->get();
                $queueListClean = $queueListDirty['export']['list'];
                if ($status == 'success') {
                    $dialDestination->queue($queueListClean, 'forward[]', 'forward', 'DSTOption[]');
                } elseif ($status == 'failed') {
                    $dialDestination->queue($queueListClean, 'FForward', 'FForward', 'FDSTOption');
                }
                break;

            case 'Announce':
                $announceObj = new adminAnnounceModel();
                $announceListDirty = $announceObj->getAll()->get();
                $announceListClean = $announceListDirty['export']['list'];
                if ($status == 'success') {
                    $dialDestination->announce($announceListClean, 'forward[]', 'forward', 'DSTOption[]');
                } elseif ($status == 'failed') {
                    $dialDestination->announce($announceListClean, 'FForward', 'FForward', 'FDSTOption');
                }
                break;

            case 'HangUp':
                if ($status == 'success') {
                    $dialDestination->hangUp('forward[]', 'DSTOption[]');
                } elseif ($status == 'failed') {
                    $dialDestination->hangUp('FForward', 'FDSTOption');
                }
                break;

            case 'fax':
                if ($status == 'success') {
                    $dialDestination->hangUp('forward[]', 'DSTOption[]');
                } elseif ($status == 'failed') {
                    $dialDestination->hangUp('FForward', 'FDSTOption');
                }
                break;
        }


    }

    /**
     * Fill the DSTOption Combo Box Using Ajax in the Time Condition Section(Both of Them)
     *
     * @var $input
     */
    public function timeConditionDSTOptionSelectTag($input)
    {
        $recordId = $input['recordId'];
        $status = $input['status'];
        $dialDestination = new AdminDialDestinationController();

        switch ($input['forward']) {
            case 'withOutMessage' :
                if ($status == 'success') {
                    $dialDestination->withOutMessage('DSTOption[]');
                } elseif ($status == 'failed') {
                    $dialDestination->withOutMessage('FDSTOption');
                }
                break;
            case 'defaultMessage' :
                if ($status == 'success') {
                    $dialDestination->defaultMessage('DSTOption[]');
                } elseif ($status == 'failed') {
                    $dialDestination->defaultMessage('FDSTOption');
                }
                break;
            case 'customMessageByRecord' :
                if ($status == 'success') {
                    $dialDestination->customMessageByRecord($recordId, 'successRecordVoiceLink');
                } elseif ($status == 'failed') {
                    $dialDestination->customMessageByRecord($recordId, 'failedRecordVoiceLink');
                }
                break;
            case 'customMessageByList':
                $voiceObj = new AdminUploadModel();
                $voiceDirty = $voiceObj->getByFilter();
                foreach ($voiceDirty['export']['list'] as $key => $value) {
                    $voiceClean[$value['upload_id']] = $value['title'];
                }


                if ($status == 'success') {
                    $dialDestination->customMessageByList($voiceClean, 'DSTOption[]');
                } elseif ($status == 'failed') {
                    $dialDestination->customMessageByList($voiceClean, 'FDSTOption');
                }
                break;
            case 'internal' :
                $extensionObj = new adminExtensionModel();
                $extensionDirty = $extensionObj->getByFilter();
                $extensionClean = $extensionDirty['export']['list'];

                if ($status == 'success') {
                    $dialDestination->internal($extensionClean, 'DSTOption[]');
                } elseif ($status == 'failed') {
                    $dialDestination->internal($extensionClean, 'FDSTOption');
                }
                break;
            case 'external' :
                if ($status == 'success') {
                    $dialDestination->external('DSTOption[]');

                } elseif ($status == 'failed') {
                    $dialDestination->external('FDSTOption');
                }
                break;
        }

    }

    public function showAllextention()
    {
   

        $extentionService = new ExtensionService();
        $list = $extentionService->getAllExtensionsApi();

        $list['success'] = true;
        Response::json($list, 200);

    }

    public function addExtensionApi($fields)
    {
        global $conn, $lang, $company_info;
        $extentionService = new ExtensionService();
        $fields = $extentionService->addExtensionApi($fields);
        $list['success'] = "true";
        $list['list'] = $fields;
        Response::json($list, 201);

        $company = new CompanyService();
        $company->activeRelaod($company_info['comp_id']);
    }

    public function editExtensionApi($fields)
    {
        $extentionService = new ExtensionService();
        $fields = $extentionService->editExtensionApi($fields);
        $list['success'] = "True";
        $list['list'] = $fields;

        Response::json($list, 202);
    }

    /**
     * Deletes extension based on its ID
     *
     * @param $extensionID
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh
     * @version 01.01.01
     * @date    08/08/2020
     */
    public function deleteExtensionsApi($extensionID)
    {

        global $conn, $lang, $company_info;
        $checkDependency = new DependencyService;
        $input['id'] = $extensionID;
        $input['comp_id'] = AdminExtensionModel::find($extensionID)->comp_id;
        $input['name'] = 'Extension';
        $input['dst_option_id'] = '9';
        $result = $checkDependency->checkDependency($input);
        if ($result['result'] !== 1) {
            $list['success'] = "false";
            $list['list'] = $result;
            Response::json($list, 404);
        }

       /* $extensionType = 2;
        $extension = new AdminExstionNewModel();*/

        $extension = adminExtensionModel::find($extensionID);
        $extension->delete();

        $list['success'] = true;
        $list['list'] = $extension;
        Response::json($list, 204);

        $company = new CompanyService();

        $company->activeRelaod($company_info['comp_id']);
    }

    public function createArrayByResponceCommand($responce)
    {
        $arrayList = array();
        $arrayIndex = 0;
        foreach ($responce as $key => $val) {
            if (trim($val) == '') {
                $arrayIndex++;
            } else {
                $temp = explode(':', trim($val));
                $arrayList[$arrayIndex][trim($temp[0])] = trim($temp[1]);
            }

        }
        return $arrayList;
    }

    public function extensionStatus()
    {
        $conn = new AstMan;
        $conn->amiHost = AMI_HOST;
        $conn->amiPort = AMI_Port;
        $conn->amiUsername = AMI_USER_NAME;
        $conn->amiPassword = AMI_PASSWORD;

        $ret = $conn->Login();

        $responce = $conn->getOnlineSip();


        //todo company ?
        if (trim($responce['0']) == 'Response: Error') {
            // die('nadarad');

        }
        $arrayList = $this->createArrayByResponceCommand($responce);


        foreach ($arrayList as $key => $sipInfo) {
            if (isset($sipInfo['ObjectName'])) {
                $temp = explode('-', $sipInfo['ObjectName']);
                if (isset($temp[1])) {

                    $extension[$temp[0]]['ObjectName'] = $sipInfo['ObjectName'];
                    $extension[$temp[0]]['Status'] = $sipInfo['Status'];
                    $extension[$temp[0]]['extension_no'] = $temp[0];
                    $extensionNoList[] = $temp[0];

                }
            }
        }

        // dd($extension);
        $append['is_online'] = array('formatter' => function ($list) use ($extension)
        {
            $pos = strpos($extension[$list['extension_no']]['Status'], 'OK');
            if ($pos === false) {
                return 0;
            } else {
                return 1;

            }

        });

        //dd($extensionNoList);
        $list = AdminExtensionModel::getBy_extension_no($extensionNoList)
            ->appendRelation($append)
            ->select(AdminExstionNewModel::$extensionFillable)
            ->paginate(1000)->getList();


        $list['success'] = true;
        Response::json($list, 200);

        //return $ret;
    }

    public function conferenceOnlineUser($number)
    {
        $conn = new AstMan;
        $conn->amiHost = AMI_HOST;
        $conn->amiPort = AMI_Port;
        $conn->amiUsername = AMI_USER_NAME;
        $conn->amiPassword = AMI_PASSWORD;

        $ret = $conn->Login();
        //print_r_debug($number);
        $responce = $conn->getOnlineUserConference($number);

        //todo company ?
        if (trim($responce['0']) == 'Response: Error') {
            // die('nadarad');

        }

        //dd($responce);
        $onlineList = array();
        $callerIdList = array();
        $callerIdList[] = 112233665544779;
        foreach ($responce as $key => $val) {

            $temp = explode(':', trim($val));
            $keyResponce = trim($temp[0]);
            $valResponce = trim($temp[1]);


            if ($keyResponce == 'Channel') {
                $online['Channel'] = $valResponce;
            }
            if ($keyResponce == 'CallerIDNum') {
                $online['CallerIDNum'] = $valResponce;
                $callerIdList[$valResponce] = $valResponce;
            }

            //extension name
            if ($keyResponce == 'CallerIDName') {
                $online['CallerIDName'] = $valResponce;
                $onlineList[$online['CallerIDNum']] = $online;
                //unset($online);
            }


        }

        // dd($onlineList);
        $append['chanel'] = array('formatter' => function ($list) use ($onlineList) {
            return $onlineList[$list['caller_id_number']]['Channel'];
        });
        $append['is_webrtc'] = array('formatter' => function ($list) {
            if ($list['extension_type'] == 2) {
                return 1;
            } else {
                return 0;
            }
        });

        $allExtension = AdminExtensionModel::getBy_caller_id_number($callerIdList)
            ->appendRelation($append)
            ->select(AdminExstionNewModel::$extensionFillable)
            ->paginate(1000)->getList();

        $list = $allExtension;
        $list['success'] = true;

        Response::json($list, 200);

    }

    public function conferenceList()
    {
        $list = ConferenceModel::getAll()
            ->paginate(1000)->getList();

        $list['success'] = true;
        Response::json($list, 200);

    }


}






