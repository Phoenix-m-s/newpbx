<?php

include_once ROOT_DIR . "component/timeCondition/mainTimeConditionModel.php";
include_once ROOT_DIR . "component/dialDestination/adminDialDestinationController.php";
include_once ROOT_DIR . "component/ivr/adminIVRModel.php";
include_once ROOT_DIR . "component/queue/adminQueueModel.php";
include_once ROOT_DIR . "component/announce/adminAnnounceModel.php";
include_once ROOT_DIR . "component/company/AdminCompanyModel.php";
include_once ROOT_DIR . "component/timeCondition/AdminNewNameExstionModel.php";
include_once ROOT_DIR . "component/extension.model.php";
include_once ROOT_DIR . "common/init.inc.php";
include_once ROOT_DIR . "common/func.inc.php";
include_once ROOT_DIR . 'services/dependency/DependencyService.php';
include_once ROOT_DIR . 'services/TblDstOptionService.php';

//die('a');

/**
 * Class adminMainTimeConditionController
 */
class adminMainTimeConditionController
{

    /**
     * @var array
     */
    private $days = [];
    /**
     * @var array
     */
    private $WeekdaysName = ['choose from list', 'sat', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
    /**
     * @var array
     */
    private $monthsName = ['choose from list', 'January', 'february', 'march', 'april', 'may', 'june', 'july', 'August', 'September', 'October', 'November', 'December'];
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
    private $dialExtensionList = ['HangUp', 'Extension', 'VoiceMail', 'Forward', 'IVR', 'Queue', 'Announce', 'Fax'];

    private $dialExtensionListLabel = array('HangUp' => 'HangUp', 'Extension' => 'extension', 'VoiceMail' => 'voiceMail', 'Forward' => 'forward', 'IVR' => 'IVR', 'Queue' => 'Queue', 'Announce' => 'Announce', 'Fax' => 'fax');

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
    public function showTimeConditionPage($message)
    {
        global $company_info;
        $list = AdminMainTimeConditionModel::getAll()
            ->where('comp_id', '=', $company_info['comp_id'])->getList();;

        $export = $list['export']['list'];

        $this->exportType = 'html';
        $this->fileName = 'timeCondition.php';
        $this->template($export, $message);
        die();
    }

    /** show "time condition add" form */
    public function showTimeConditionAddForm1()
    {
        $fields = [];
        $this->insertVoiceList($fields);
        $this->insertActiveExtensionList($fields);
        $this->exportType = 'html';
        $this->fileName = 'addTimeConditionNew.php';
        $this->template($fields, '');
    }

    /**
     *
     */
    public function showTimeConditionAddForm()
    {
        $list['fields'] = $this->setArraysToFields();
        $timeConditionOption = new TblDstOptionService();
        $dialExtension_list = $timeConditionOption->getTimeConditionOption();
        $list['fields']['dst_option_id'] = $timeConditionOption->getDialExtensionDetailByName($dialExtension_list);
        $list['fields']['fdst_option_id'] = $timeConditionOption->getDialExtensionDetailByName($dialExtension_list);
        $list['fields']['action'] = 'addTimeCondition';
        $list['fields']['form_action'] = 'add';
        $list['fields']['url'] = 'mainTimeCondition.php';
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
        global $company_info;

        $fields = $this->setArraysToFields();
        $timeConditionDirty = AdminMainTimeConditionModel::find($id);
        $timeConditionID = $timeConditionDirty->id;
        $timeCondition = AdminMainTimeConditionDetailModel::getBy_timeConditionID($timeConditionID)->getList();
        $timeConditionClean = $timeCondition['export']['list'];
        $timeConditionName = AdminMainTimeConditionModel::find($timeConditionID);
        if ($timeCondition['result'] != 1) {
            return $timeCondition['msg'];
        }

        $fields = $this->reArrangeData($fields, $timeConditionClean);
        $timeConditionOption = new TblDstOptionService();
        $dialExtension_list = $timeConditionOption->getTimeConditionOption();
        $fields['dst_option_id'] = $timeConditionOption->getDialExtensionDetailByName($dialExtension_list);
        $fields['fdst_option_id'] = $fields['dst_option_id'];
        $fields['action'] = 'editTimeCondition';
        $fields['comp_id'] = $company_info['comp_id'];
        $fields['is_extension'] = 0;
        $fields['url'] = 'mainTimeCondition.php';
        $fields['name'] = $timeConditionName->name;
        $fields['timeConditionID'] = $fields['tc'][0]['timeConditionID'];
        $fields['form_action'] = 'edit';
        $result['fields'] = $fields;
        $result['result'] = 1;
        $result['msg'] = 'edit information';
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

        global $company_info;
        looeic::beginTransaction();
        $checharacter = checkForPersianWordsInMultiDimensionalKeyValueArray($fields);
        if ($checharacter==-1) {
            $result['result'] = -1;
            $result['msg'] = 'You used an illegal character';
            echo json_encode($result);
            die();
        }
        $fields['comp_id'] = $company_info['comp_id'];
        $timeConditionModel = new AdminMainTimeConditionModel($fields);
        $timeConditionModel->name = $fields['name'];
        $timeConditionModel->comp_id = $fields['comp_id'];

        $validate = $timeConditionModel->validator();
        if ($validate['result'] == -1) {
            $result['fields'] = $validate;
            echo json_encode($result);
            die();
        }

        $timeConditionName = AdminMainTimeConditionModel::getBy_comp_id_and_name($fields['comp_id'], $fields['name'])->getList();
        if ($timeConditionName['export']['recordsCount'] >= 1) {
            looeic::rollback();
            $result['result'] = -1;
            $result['msg'] = 'this timeCondition name is exist';
            echo json_encode($result);
            die();
        }
        $timeConditionModel->save();
        $fields['timeConditionID'] = $timeConditionModel->id;
        $timeConditionDetailModel = AdminMainTimeConditionDetailModel::SetFieldsAndSave($fields);
        looeic::commit();
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
        $checharacter = checkForPersianWordsInMultiDimensionalKeyValueArray($fields);
        if ($checharacter==-1) {
            $result['result'] = -1;
            $result['msg'] = 'You used an illegal character';
            echo json_encode($result);
            die();
        }
        $fields['comp_id'] = $company_info['comp_id'];
        looeic::beginTransaction();
        $timeConditionModel = AdminMainTimeConditionModel::find($fields['timeConditionID']);
        $timeConditionModel->setFields($fields);
        $validate = $timeConditionModel->validator();
        if ($validate['result'] == -1) {
            $result['fields'] = $validate;
            echo json_encode($result);
            die();
        }
        $timeConditionName = AdminMainTimeConditionModel::getBy_comp_id_and_name_and_not_id($fields['comp_id'], $fields['name'], $fields['timeConditionID'])->getList();
        if ($timeConditionName['export']['recordsCount'] >= 1) {
            looeic::rollback();
            $result['result'] = -1;
            $result['msg'] = 'this timeCondition name is exist';
            echo json_encode($result);
            die();
        }

        $objDetail = AdminMainTimeConditionDetailModel::getBy_timeConditionID($fields['timeConditionID'])->get();
        if ($objDetail['export']['recordsCount'] == 0) {
            $result = AdminMainTimeConditionDetailModel::SetFieldsAndSave($fields);
            if ($result['result'] == -1) {
                $result['msg'] = 'error ';
                echo json_encode($result);
                die();
            }
        } else {
            foreach ($objDetail['export']['list'] as $timeConditionDetailObj) {
                $timeConditionDetailObj->delete();
            }
            $result = AdminMainTimeConditionDetailModel::SetFieldsAndSave($fields);
            if ($result['result'] == -1) {
                looeic::rollback();
                $result['result'] = -1;
                $result['msg'] = 'error ';
                echo json_encode($result);
                die();
            }
        }

        $result = $timeConditionModel->save();
        if ($result['result'] == -1) {
            looeic::rollback();
            $result['result'] = -1;
            $result['msg'] = 'error ';
            echo json_encode($result);
            die();
        }

        looeic::commit();
        $companyObj = new AdminCompanyModel();
        $company = $companyObj->find($company_info['comp_id']);
        $company->reload_alert = 1;
        $company->save();
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
        include_once ROOT_DIR . 'services/dependency/DependencyService.php';

        $detailedTimeConditionObj = new AdminMainTimeConditionDetailModel();
        $detailedTimeCondition = $detailedTimeConditionObj::getBy_timeConditionID($timeConditionID)->get();
        $checkDependency = new DependencyService;
        $input['id'] = $timeConditionID;
        $input['comp_id'] = $company_info['comp_id'];
        $input['name'] = 'Time Condition';
        $input['dst_option_id'] = '8';
        $result = $checkDependency->checkDependency($input);
        if ($result['msg'] != '') {
            $this->showTimeConditionPage($result['msg']);
            die();
        }

        $input['dst_option_id'] = '9';
//        $input['id'] = 1;
        $input['name'] = 'Forward';

        $checkDependency = new DependencyService;
        $result = $checkDependency->checkDependency($input);

        if ($result['msg'] != '') {
            $this->showTimeConditionPage($result['msg']);
            die();
        }

        foreach ($detailedTimeCondition['export']['list'] as $timeCondition) {
            $result1 = $timeCondition->delete();
            if ($result1['result'] != 1) {
                $destination = 'mainTimeCondition.php';
                $this->showRelatedTemplate('', $destination, '');
            }
        }
        $timeConditionObj = new AdminMainTimeConditionModel();
        $result2 = $timeConditionObj::find($timeConditionID);

        if (!is_object($result2)) {
            $destination = 'mainTimeCondition.php';
            $this->showRelatedTemplate('', $destination, '');
        }

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
            $fields['tc'][$i]['dst_option_id_selected']['dst_option_id'] = $timeScheduleClean[$i]['dst_option_id'];
            $fields['tc'][$i]['dst_option_id_selected']['dst_option_sub_id'] = $timeScheduleClean[$i]['dst_option_sub_id'];
            $fields['tc'][$i]['dst_option_id_selected']['DSTOption'] = $timeScheduleClean[$i]['DSTOption'];
            $fields['tc'][$i]['id'] = $timeScheduleClean[$i]['id'];
//            $fields['tc'][$i]['sub_dst'] = $timeScheduleClean[$i]['sub_dst'];
            $fields['failTc'][$i]['fdst_option_id_selected']['fdst_option_id'] = $timeScheduleClean[$i]['fdst_option_id'];
            $fields['failTc'][$i]['fdst_option_id_selected']['fdst_option_sub_id'] = $timeScheduleClean[$i]['fdst_option_sub_id'];
            $fields['failTc'][$i]['fdst_option_id_selected']['fDSTOption'] = $timeScheduleClean[$i]['fDSTOption'];
        }

        return $fields;
    }

    /**
     * to fill selects in the html page dynamically.
     *
     * @var $fields
     */
    private function setArraysToFields()
    {
        $this->days[0]['name'] = 'choose from list';
        $this->days[0]['id'] = '';
        for ($i = 1; $i < 31; $i++) {
            $this->days[$i]['name'] = $i;
            $this->days[$i]['id'] = $i;
        }

        for ($i = 0; $i < 8; $i++) {
            $this->WeekdaysList[$i]['name'] = $this->WeekdaysName[$i];
            $this->WeekdaysList[$i]['id'] = $i;
        }
        $this->WeekdaysList[0]['id'] = '';

        for ($i = 0; $i < 13; $i++) {
            $this->monthsNameList[$i]['name'] = $this->monthsName[$i];
            $this->monthsNameList[$i]['id'] = $i;
        }
        $this->monthsNameList[0]['id'] = '';

        $list['weekDayStart'] = $this->WeekdaysList;
        $list['dayStart'] = $this->days;
        $list['monthStart'] = $this->monthsNameList;

        return $list;

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
//        die($input['dialExtension']);

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

            case 'Time Condition' :
                $extensionObj = new AdminMainTimeConditionModel();
                $extensionDirty = $extensionObj->getAll()->getList();
                $extensionClean = $extensionDirty['export']['list'];
                if ($status == 'success') {
                    $dialDestination->timeCondition($extensionClean, 'forward[]', 'forward', 'DSTOption[]');
                } elseif ($status == 'failed') {
                    $dialDestination->timeCondition($extensionClean, 'FForward', 'FForward', 'FDSTOption');
                }
                break;

            case 'ExtensionTimeCondition' :
                $extensionObj = new AdminNewNameExstionModel();
                $extensionDirty = $extensionObj->getBy_extension_id($input['id'])->getList();
                $extensionClean = $extensionDirty['export']['list'];
                if ($status == 'success') {
                    $dialDestination->timeCondition($extensionClean, 'forward[]', 'forward', 'DSTOption[]');
                } elseif ($status == 'failed') {
                    $dialDestination->timeCondition($extensionClean, 'FForward[]', 'FForward', 'FDSTOption');
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

            case 'extension' :
                $extensionDirty = AdminExtensionModel::getAll()->get();
                $extensionListClean = $extensionDirty['export']['list'];

                //print_r_debug($extensionDirty);
                if ($status == 'success') {
                    $dialDestination->extension($extensionListClean, 'forward[]', 'forward');
                } elseif ($status == 'failed') {
                    $dialDestination->extension($extensionListClean, 'FForward', 'FForward');
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
                $extensionDirty = $extensionObj->getBy_not_extension_id($input['extensionId'])->getList();
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


}