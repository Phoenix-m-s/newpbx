<?php
include_once ROOT_DIR . "component/extension.operation.class.php";
include_once ROOT_DIR . "component/upload/AdminUploadModel.php";
include_once ROOT_DIR . "component/dialDestination/adminDialDestinationController.php";
include_once ROOT_DIR . "component/extension.model.php";
include_once ROOT_DIR . "component/time.condition.php";
include_once ROOT_DIR . "component/timeCondition/AdminNewExstionModel.php";
include_once ROOT_DIR . "component/extension/AdminExstionNewModel.php";
include_once ROOT_DIR . "component/timeCondition/AdminNewNameExstionModel.php";
include_once ROOT_DIR . "component/company/AdminCompanyModel.php";
include_once ROOT_DIR . "component/ivr/adminIVRModel.php";
include_once ROOT_DIR . "component/queue/adminQueueModel.php";
include_once ROOT_DIR . "component/announce/adminAnnounceModel.php";
include_once ROOT_DIR . "component/inbound/adminInboundModel.php";
include_once ROOT_DIR . "component/timeCondition/AdminNewNameExstionModel.php";
include_once ROOT_DIR . "component/queue/adminQueueModel.php";
require_once ROOT_DIR . "common/func.inc.php";
include_once ROOT_DIR . "component/company/AdminCompanyModel.php";
include_once ROOT_DIR . 'services/dependency/DependencyService.php';
include_once ROOT_DIR . "services/TblDstOptionService.php";
require_once ROOT_DIR . "common/init.inc.php";
include_once ROOT_DIR . 'component/admin/AdminUser.php';
include_once ROOT_DIR . "component/timeCondition/mainTimeConditionController.php";
/**
 * @author Malekloo Izadi Sakhamanesh <Izadi@dabacenter.ir>
 * @version 0.0.1 this is the beta version of News
 * @copyright 2015 The Imen Daba Parsian Co.
 */
class extension_presentation
{
    private $days = array();
    private $WeekdaysName = array('choose from list', 'sat', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday');
    private $monthsName = array('choose from list', 'January', 'february', 'march', 'april', 'may', 'june', 'july', 'August', 'September', 'October', 'November', 'December');
    private $forwardList = array('choose', 'internal', 'external');
    // private $voiceMailList = array('name'=>'withOutMessage', 'defaultMessage'/*, 'customMessageByList', 'customMessageByRecord'*/);
    private $voiceMailList = array(array('id' => 'withOutMessage', 'name' => 'withOutMessage'), array('id' => 'defaultMessage', 'name' => 'defaultMessage'));

    private $dialExtensionList = ['choose from list' => '', 'HangUp', 'voiceMail', 'forward', 'IVR', 'Queue', 'Announce', 'fax', 'ExtensionTimeCondition'];
    private $FDialExtension = ['choose from list' => '', 'HangUp' => 'HangUp', 'VoiceMail' => 'voiceMail', 'Forward' => 'forward', 'Announce' => 'Announce'];

    /**
     * Contains file type
     *
     * @var
     */
    public $exportType;

    /**
     * Contains file name
     *
     * @var
     */
    public $fileName;

    /**
     * Specifies the type of output
     *
     * @param $list
     * @param $msg
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function template($list = [], $message = '')
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


    /**
     * Shows all the extensions
     *
     * @param   $list
     * @param   $msg
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */


    public function excelExtension()
    {
        global $company_info;
        $extensionList = AdminExstionNewModel::getAll()->where('comp_id', '=', $company_info['comp_id'])->getList();

        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=Extension_Reoprt.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        echo '<table border="1">';

//make the column headers what you want in whatever order you want
        echo '<tr>
                    <th>extension_id</th>
                    <th>comp_id</th>
                    <th>extension_status</th>
                    <th>voicemail_status</th>
                    <th>voicemail_email</th>
                    <th>voicemail_pass</th>
                    <th>dst_option_id</th>
                    <th>dst_option_sub_id</th>
                    <th>DSTOption</th>
                    <th>extension_name</th>
                    <th>extension_no</th>
                    <th>secret</th>
                    <th>extension_date</th>
                    <th>trash</th>
                    <th>internal_recording</th>
                    <th>external_recording</th>
                    <th>caller_id_number</th>
                    <th>ring_number</th>
                    <th>username</th>
                    <th>password</th>
                    <th>dialExtension</th>
                    <th>sub_dst</th>
                    <th>forward</th>
                    <th>FDialExtension</th>
                    <th>FSub_dst</th>
                    <th>FForward</th>
                    <th>fDSTOption</th>
                    <th>fdst_option_id</th>
                    <th>protocol</th>
                    <th>mac_address</th>
                    <th>extension_type</th>
                    <th>timezone</th>
                    <th>is_busy</th>
              </tr>';
//loop the query data to the table in same order as the headers
        foreach ($extensionList['export']['list'] as $key=>$value){
            echo "<tr>
                      <td>".$value['extension_id']."</td>
                      <td>".$value['comp_id']."</td>
                      <td>".$value['extension_status']."</td>
                      <td>".$value['voicemail_status']."</td>
                      <td>".$value['voicemail_email']."</td>
                      <td>".$value['voicemail_pass']."</td>
                      <td>".$value['dst_option_id']."</td>
                      <td>".$value['dst_option_sub_id']."</td>
                      <td>".$value['DSTOption']."</td>
                      <td>".$value['extension_name']."</td>
                      <td>".$value['extension_no']."</td>
                      <td>".$value['secret']."</td>
                      <td>".$value['extension_date']."</td>
                      <td>".$value['trash']."</td>
                      <td>".$value['internal_recording']."</td>
                      <td>".$value['external_recording']."</td>
                      <td>".$value['caller_id_number']."</td>
                      <td>".$value['ring_number']."</td>
                      <td>".$value['username']."</td>
                      <td>".$value['password']."</td>
                      <td>".$value['dialExtension']."</td>
                      <td>".$value['sub_dst']."</td>
                      <td>".$value['forward']."</td>
                      <td>".$value['FDialExtension']."</td>
                      <td>".$value['FSub_dst']."</td>
                      <td>".$value['FForward']."</td>
                      <td>".$value['fDSTOption']."</td>
                      <td>".$value['fdst_option_id']."</td>
                      <td>".$value['fdst_option_sub_id']."</td>
                      <td>".$value['protocol']."</td>
                      <td>".$value['mac_address']."</td>
                      <td>".$value['extension_type']."</td>
                      <td>".$value['timezone']."</td>
                      <td>".$value['is_busy']."</td>
                  </tr>";
        }
        echo '</table>';

    }

    /**
     * Shows all the extensions
     *
     * @param   $list
     * @param   $msg
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */


    public function getAllExtensions($member_type)
    {


        global $member_info,$company_info;
        $list = AdminExstionNewModel::getAll()->where('comp_id','=',$company_info['comp_id']);


        if ($member_type == 'extension') {
            $list->where('extension_id', '=', $member_info['extension_id']);
        }
        $list->orderBy('extension_no')->getList();

        return $list->orderBy('extension_no')->getList();

        die();
    }


    public function getMembertaype()
    {
        global $member_info;
        $member_type = 'admin';
        if (is_array($member_info)) {
            $member_type = 'extension';
        }
        return $member_type;
    }

    public function showAllExtensions($msg)
    {

        $list = $this->getAllExtensions($this->getMembertaype());
        //print_r_debug($this->getMembertaype());
        $export = $list['export']['list'];
        $this->exportType = 'html';
        $this->fileName = 'extension.show.php';
        $this->template($export, $msg);
        die();
    }


    /**
     * Add extension
     *
     * @param $fields
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function addExtension($fields)
    {
        global $company_info;

        // بررسی مقدار comp_id
        if (empty($company_info['comp_id'])) {
            $result['result'] = -1;
            $result['msg'] = 'Company ID is missing';
            echo json_encode($result);
            die();
        }

        // بررسی کاراکترهای غیرمجاز
        $checharacter = checkForPersianWordsInMultiDimensionalKeyValueArray($fields);
        if ($checharacter == -1) {
            $result['result'] = -1;
            $result['msg'] = 'You used an illegal character';
            echo json_encode($result);
            die();
        }

        // شروع تراکنش
        looeic::beginTransaction();

        // افزودن comp_id به فیلدها
        $fields['comp_id'] = $company_info['comp_id'];

        // ذخیره اکستنش
        $extensionModel = new ExtensionService();
        $resultAddExtension = $extensionModel->addExtension($fields);
        if ($resultAddExtension['result'] == -1 || empty($resultAddExtension['extension_id'])) {
            looeic::rollback();
            $result['result'] = -1;
            $result['msg'] = 'Failed to add extension';
            echo json_encode($result);
            die();
        }


        // دریافت extension_id
        $extension_id = $resultAddExtension['extension_id'];
        $fields['extension_id'] = $extension_id;



        // تنظیم تایم کاندیشن برای rest
        $timeConditionFieldsRest = array_merge($fields, [
            'name' => 'rest-' . $fields['tc'][0]['extension_name'],
            'tc' => [
                [
                    'dst_option_id_selected' => [
                        'dst_option_id' => 7,
                        'dst_option_sub_id' => '',
                        'DSTOption' => ''
                    ],
                    'hourStart' => '1:50',
                    'hourEnd' => '17:50',
                    'weekDayStart' => 6,
                    'weekDayEnd' => 7,
                    'dst_option_id' => 7,
                    'dst_option_sub_id' => 0,
                    'DSTOption' => 0,
                ]
            ],
            'failTc' => [
                [
                    'fdst_option_id' => 7,
                    'fdst_option_sub_id' => '',
                    'fDSTOption' => ''
                ]
            ],
        ]);

        // ذخیره تایم کاندیشن‌های rest
        $timeConditionModelRest = new AdminNewNameExstionModel();
        $resultAddTimeConditionRest = $timeConditionModelRest::SetFieldsAndSave($timeConditionFieldsRest);

        $fields['time_condtion_name_id']=$resultAddTimeConditionRest['id'];

        $timeConditionFieldsRest['time_condtion_name_id']= $fields['time_condtion_name_id'];
        if ($resultAddTimeConditionRest['result'] == -1) {
            looeic::rollback();
            $result['result'] = -1;
            $result['msg'] = 'Failed to add rest time condition';
            echo json_encode($result);
            die();
        }

        // ذخیره جزئیات تایم کاندیشن‌های rest
        $timeConditionDetailModelRest = new adminTimeConditionModel();
        $timeConditionDetailRest = $timeConditionDetailModelRest::SetFieldsAndSaveApi($timeConditionFieldsRest);
        if ($timeConditionDetailRest['result'] == -1) {
            looeic::rollback();
            $result['result'] = -1;
            $result['msg'] = 'Failed to add rest time condition details';
            echo json_encode($result);
            die();
        }
        // تنظیم تایم کاندیشن برای work
        $timeConditionFieldsWork = array_merge($fields, [
            'name' => 'work-' . $fields['tc'][0]['extension_name'],
            'tc' => [
                [
                    'dst_option_id_selected' => [
                        'dst_option_id' => 7,
                        'dst_option_sub_id' => '',
                        'DSTOption' => ''
                    ],
                    'hourStart' => '1:50',
                    'hourEnd' => '3:50',
                    'weekDayStart' => 1,
                    'weekDayEnd' => 5,
                    'dst_option_id' => 7,
                    'dst_option_sub_id' => 0,
                    'DSTOption' => 0,
                ]
            ],
            'failTc' => [
                [
                    'fdst_option_id' => 7,
                    'fdst_option_sub_id' => '',
                    'fDSTOption' => ''
                ]
            ],
        ]);

        // ذخیره تایم کاندیشن‌های work
        $timeConditionModelWork = new AdminNewNameExstionModel();
        $resultAddTimeConditionWork = $timeConditionModelWork::SetFieldsAndSave($timeConditionFieldsWork);
        $fields['time_condtion_name_id']=$resultAddTimeConditionWork['id'];
        $timeConditionFieldsWork['time_condtion_name_id']=$fields['time_condtion_name_id'];

        if ($resultAddTimeConditionWork['result'] == -1) {
            looeic::rollback();
            $result['result'] = -1;
            $result['msg'] = 'Failed to add work time condition';
            echo json_encode($result);
            die();
        }

        // ذخیره جزئیات تایم کاندیشن‌های work
        $timeConditionDetailModelWork = new adminTimeConditionModel();
        $timeConditionDetailWork = $timeConditionDetailModelWork::SetFieldsAndSaveApi($timeConditionFieldsWork);

        if ($timeConditionDetailWork['result'] == -1) {
            looeic::rollback();
            $result['result'] = -1;
            $result['msg'] = 'Failed to add work time condition details';
            echo json_encode($result);
            die();
        }

        // commit تراکنش
        looeic::commit();

        // فعال کردن و ریلود شرکت
        $company = new CompanyService();
        $companyResult = $company->activeRelaod($company_info['comp_id']);
        if ($companyResult['result'] == -1) {
            $result['result'] = -1;
            $result['msg'] = 'Failed to reload company';
            echo json_encode($result);
            die();
        }

        // موفقیت‌آمیز
        $result['result'] = 1;
        $result['msg'] = 'Successfully added';
        echo json_encode($result);
        die();
    }

    /**
     * Add extension form
     *
     * @param $fields
     * @param $msg
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function addExtensionForm($msg = '')
    {
        $extension = new ExtensionService();
        $list = $extension->addExtensionForm();
        $result = json_encode($list);
        $this->exportType = 'html';
        $this->fileName = 'add.extesionNew.php';
        $this->template($result, $msg);
        die();

    }


    public function editExtension($fields, $msg)
    {

        global $company_info,$member_info;
        $checkcharacter = checkForPersianWordsInMultiDimensionalKeyValueArray($fields);
        if ($checkcharacter==-1) {
            $result['result'] = -1;
            $result['msg'] = 'You used an illegal character';
            echo json_encode($result);
            die();
        }
        $fields['comp_id'] = $company_info['comp_id'];
        $extensionNumberCheck = AdminExtensionModel::getBy_comp_id_and_extension_no_and_not_extension_id($fields['comp_id'], $fields['tc'][0]['extension_no'], $fields['tc'][0]['extension_id'])->getList();
        if ($extensionNumberCheck['export']['recordsCount'] >= 1) {
            $result['result'] = -1;
            $result['msg'] = 'this extension number is exist';
            echo json_encode($result);
            die();
        }


        /*
        * check mac address in other database
        * */
        if($fields['tc'][0]['protocol']=='sccp')
        {

            if(isset($mysql['connections']['mysql2'])){
                $checkMac = AdminExtensionModel2::getAll()
                    ->where('mac_address', '=', $fields['tc'][0]['mac_address'])
                    ->getList();
                if ($checkMac['export']['recordsCount'] >= 1) {
                    $result['result'] = -1;
                    $result['msg'] = 'this mac address  is exist in other system';
                    echo json_encode($result);
                    die();

                }

            }



            $checkMac = AdminExtensionModel::getAll()
                ->where('mac_address', '=', $fields['tc'][0]['mac_address'])
                ->where('extension_id', '<>', $fields['tc'][0]['extension_id'])
                ->get();

            //print_r_debug($checkMac);

            if ($checkMac['export']['recordsCount'] >= 1)
            {
                $result['result'] = -1;
                $result['msg'] = 'this mac address  is exist';
                echo json_encode($result);
                die();
            }


        }

        //**************
        //checkusername
        $usernameCheck = AdminExtensionModel::getBy_comp_id_and_username_and_not_extension_id($fields['comp_id'], $fields['tc'][0]['username'], $fields['tc'][0]['extension_id'])->getList();
        if ($usernameCheck['export']['recordsCount'] >= 1) {
            $result['result'] = -1;
            $result['msg'] = 'this user name is exist';
            echo json_encode($result);
            die();
        }
        $extensioName = AdminExtensionModel::getBy_comp_id_and_extension_name_and_not_extension_id($fields['comp_id'], $fields['tc'][0]['extension_name'], $fields['tc'][0]['extension_id'])->getList();
        if ($extensioName['export']['recordsCount'] >= 1) {
            $result['result'] = -1;
            $result['msg'] = 'this extension name is exist';
            echo json_encode($result);
            die();
        }

        $queueNumberCheck = adminQueueModel::getBy_queue_ext_no($fields['tc'][0]['extension_no'])->getList();
        if ($queueNumberCheck['export']['recordsCount'] >= 1) {
            $result['result'] = -1;
            $result['msg'] = 'this extension number is exist';
            echo json_encode($result);
            die();
        }

        if ($fields['username'] != '' & $fields['password'] == '') {
            $result['result'] = -1;
            $result['msg'] = 'Please fill required items';
            echo json_encode($result);
            die();
        }

        //*******************
        //checkusernameAdmin
        $admincheckUsername = $this->checkAdminName($fields);
        if ($admincheckUsername['export']['recordsCount'] >= 1) {
            $result['result'] = -1;
            $result['msg'] = 'this extension name is exist';
            echo json_encode($result);
            die();
        }

        $extesion = AdminExstionNewModel::find($fields['tc']['0']['extension_id']);




        if($fields['tc'][0]['protocol']=='sip-webrtc'){

            $fields['tc'][0]['extension_type'] =2;
        }
        else{
            $fields['tc'][0]['extension_type'] = 1;
        }

        /*$extesion->dst_option_id = '';
        $extesion->dst_option_sub_id = '';
        $extesion->DSTOption = '';
        $extesion->fdst_option_id = '';
        $extesion->fdst_option_sub_id = '';
        $extesion->fDSTOption = '';*/
        //print_r_debug($member_info);
        if ($fields['tc'][0]['dst_option_id_selected']['dst_option_sub_id'] == '') {
            $fields['tc'][0]['dst_option_id_selected']['DSTOption'] = '';
        }
        //print_r_debug();
        if ($member_info == -1) {
            $extesion->setFields($fields['tc'][0]);
        } else {
            $extesion->password = $fields['tc'][0]['password'];
            if ($fields['tc']['0']['voicemail_status'] == 1) {
                $extesion->voicemail_email = $fields['tc'][0]['voicemail_email'];
                $extesion->voicemail_pass = $fields['tc'][0]['voicemail_pass'];
            }
        }


        $extesion->mac_address = strtoupper($fields['tc'][0]['mac_address']);

        $extesion->dst_option_id = $fields['tc'][0]['dst_option_id_selected']['dst_option_id'];

        if($fields['tc'][0]['internal_recording']==''||$fields['tc'][0]['external_recording']==''){
            $extesion->internal_recording =0;
            $extesion->external_recording = 0;
        }
        else{
            $extesion->internal_recording = $fields['tc'][0]['internal_recording'];
            $extesion->external_recording = $fields['tc'][0]['external_recording'];
        }



        $extesion->dst_option_sub_id = $fields['tc'][0]['dst_option_id_selected']['dst_option_sub_id'];
        $extesion->DSTOption = $fields['tc'][0]['dst_option_id_selected']['DSTOption'];
        $extesion->setFields($fields['failTc'][0]);


        if ($extesion->voicemail_status == 0) {
            /*$checkDependency = new DependencyService;
            $input['name'] = 'voiceMail';
            $input['dst_option_id'] = '6';
            $input['id'] = $fields['tc'][0]['extension_id'];
            $input['comp_id'] = $fields['comp_id'];

            $result = $checkDependency->checkDependency($input);

            if ($result['msg'] != '') {
                $result['result'] = -1;
                echo json_encode($result);
                die();
            }*/
            $extesion->voicemail_email = '';
            $extesion->voicemail_pass = '';
        }

        $validate = $extesion->validator();
        if ($validate['result'] == -1) {
            $result = $validate;
            $result['result'] = -1;
            echo json_encode($result);
            die();
        }

        $result = $extesion->save();

        if ($result['result'] == -1) {
            $result['msg'] = 'error ';
            echo json_encode($result);
            die();
        }
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

    public function editNewExtension($fields, $msg)
    {
        global $company_info;
        $fields['comp_id'] = $company_info['comp_id'];
        /*
         | -----------------------------------------------------------------------------------------------------------------
         | update data to main_time_condition_detail table
         | -----------------------------------------------------------------------------------------------------------------
        */

        $timeConditionModel = new AdminNewExstionModel();
        if (empty($timeConditionModel::getBy_extension_id($fields['extension_id'])->getList())) {
            $result = $timeConditionModel->SetFieldsAndSave($fields);
            if ($result['result'] == -1) {
                $result['msg'] = 'error ';
                echo json_encode($result);
                die();
            }

        } else {

            /*
            | -----------------------------------------------------------------------------------------------------------------
            | Not EMPTY update data to main_time_condition_detail table
            | -----------------------------------------------------------------------------------------------------------------
           */
            $timeCondition = $timeConditionModel::getBy_extension_id($fields['extension_id'])->get();

            foreach ($timeCondition['export']['list'] as $timeCondition) {
                $timeCondition->delete();
            }

            $result = $timeConditionModel->SetFieldsAndSave($fields);
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
     * Show edit extension form based on its ID
     *
     * @param $extensionId
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function editExtensionForm($extensionId, $message)
    {
        $extension = new ExtensionService();
        $list = $extension->editExtensionForm($extensionId);
        //dd($list);

        $result= json_encode($list);
        $this->exportType = 'html';
        $destination = 'add.extesionNew.php';
        $this->showRelatedTemplate($result, $destination, $message);
        die();
    }


    /**
     * Show edit extension form based on its ID
     *
     * @param $extensionId
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function editNewExtensionForm($extensionId)
    {

        if (isset($_SESSION['extensionForm'][$extensionId]) & !empty($_SESSION['extensionForm'][$extensionId])) {

            $fields = $_SESSION['extensionForm'][$extensionId];

        } else {

            $extension = AdminExtensionModel::find($extensionId);

            if (!is_object($extension)) {
                redirectPage(RELA_DIR . 'extension.php', 'There is no such extension');
            }

            $fields = $extension->fields;
        }

        //get all the extension
        $extensionDirty = adminExtensionModel::getAll()->getList();
        $extensionClean = $extensionDirty['export']['list'];

        //print_r_debug($extensionClean);
        foreach ($extensionClean as $key => $value) {
            $help[$value['extension_id']] = $value['extension_name'];
            //$help[] = $value['extension_id'];
        }
        $fields['extensionList'] = $help;
        unset($help);

        /*
        | -----------------------------------------------------------------------------------------------------------------
        | finding all the IVR name's List
        | -----------------------------------------------------------------------------------------------------------------
        */
        $fields['IVRList'] = $this->getIVRList($fields);


        /*
        | -----------------------------------------------------------------------------------------------------------------
        | finding all the Queue name's List
        | -----------------------------------------------------------------------------------------------------------------
        */
        $fields['QueueList'] = $this->getQueueList($fields);

        /*
        | -----------------------------------------------------------------------------------------------------------------
        | finding all the Announce name's List
        | -----------------------------------------------------------------------------------------------------------------
        */
        $fields['AnnounceList'] = $this->getAnnounceList($fields);


        $fields['ExtensionList'] = $this->getActiveExtensionList($fields);

        //adding all extension's name into $fields
        $help = array();
        foreach ($extensionClean as $key => $value) {
            $help[] = $value['extension_name'];
        }

        $fields['extensionList'] = $help;
        $this->setArraysToFields($fields);

        //vared kardane list voice haye insert shode va mojod dar database
        $this->insertVoiceArrays($fields);


        $destination = 'addNewTimeCondition.php';
        $this->showRelatedTemplate($fields, $destination);
        die();
    }


    /**
     * showTimeConditionFrom based on its ID
     *
     * @param $extensionId
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function showTimeConditionFrom($extensionId, $message)
    {
        $fields['extension_id'] = $extensionId;
        $export['timeConditions'] = AdminNewNameExstionModel::getBy_extension_id($fields['extension_id'])->getList()['export']['list'];
        $export['extension_id'] = $extensionId;
        $destination = 'timeConditionShowAll.php';
        $this->showRelatedTemplate($export, $destination, $message);
        die();
    }

    /**
     * showTimeConditionFrom based on its ID
     *
     * @param $extensionId
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function editNewExtensionTimeCondition($fields)
    {
        global $company_info;
        $fields['comp_id'] = $company_info['comp_id'];
        looeic::beginTransaction();
        $timeConditionModel = AdminNewNameExstionModel::find($fields['timeConditionID']);
        $timeConditionModel->setFields($fields);
        $validate = $timeConditionModel->validator();
        if ($validate['result'] == -1) {
            $result['fields'] = $validate;
            echo json_encode($result);
            die();
        }

        $timeConditionName = AdminNewNameExstionModel::getBy_comp_id_and_name_and_extension_id_and_not_id($fields['comp_id'], $fields['name'],$fields['extension_id'], $fields['timeConditionID'])->getList();
        if ($timeConditionName['export']['recordsCount'] >= 1) {
            looeic::rollback();
            $result['result'] = -1;
            $result['msg'] = 'this timeCondition name is exist';
            echo json_encode($result);
            die();
        }

        $objDetail = AdminNewExstionModel::getBy_time_condtion_name_id($fields['timeConditionID'])->get();
        if ($objDetail['export']['recordsCount'] == 0) {
            $result = AdminNewExstionModel::SetFieldsAndSave($fields);
            if ($result['result'] == -1) {
                looeic::rollback();
                $result['msg'] = 'error ';
                echo json_encode($result);
                die();
            }
        } else {
            foreach ($objDetail['export']['list'] as $timeConditionDetailObj) {
                $timeConditionDetailObj->delete();
            }
            $result = AdminNewExstionModel::SetFieldsAndSave($fields);
            if ($result['result'] == -1) {
                looeic::rollback();
                $result['msg'] = 'error ';
                echo json_encode($result);
                die();
            }
        }

        $result = $timeConditionModel->save();
        if ($result['result'] == -1) {
            looeic::rollback();
            $result['msg'] = 'error ';
            echo json_encode($result);
            die();
        }
        looeic::commit();
        $result['fields'] = $fields;
        $result['result'] = 1;
        $result['msg'] = "Successfully Update";
        echo json_encode($result);
        die();
    }


    /**
     * addNewExtensionTimeConditon
     * @param $extensionId
     * Version 0.0.1
     * @author m.sakhamanesh@googlemail.com
     * @date :2018.4.20
     */
    public function addNewExtensionTimeConditon($fields)
    {
        global $company_info;
        looeic::beginTransaction();
        $fields['comp_id'] = $company_info['comp_id'];
        $timeConditionModel = new AdminNewNameExstionModel();
        $resultAddTimecondition = $timeConditionModel::SetFieldsAndSave($fields);
        if ($resultAddTimecondition['result'] == -1) {
            looeic::rollback();
            $resultAddTimecondition['result'] = -1;
            echo json_encode($resultAddTimecondition);
            die();
        }
        $fields['timeConditionID'] = $resultAddTimecondition['id'];
        $result2 = AdminNewExstionModel::SetFieldsAndSave($fields);
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
     * addNewExtensionTimeConditonForm
     *
     * @param $extensionId
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function addNewExtensionTimeConditonForm($extensionId)
    {
        global $company_info;

        $list['fields'] = $this->setArraysToFields();
        $timeConditionOption = new TblDstOptionService();
        $dialExtension_list = $timeConditionOption->getExtensionTimeConditionOption($extensionId);
        $list['fields']['dst_option_id'] = $timeConditionOption->getDialExtensionDetailByName($dialExtension_list);
        $list['fields']['fdst_option_id'] = $list['fields']['dst_option_id'];
        $list['fields']['action'] = 'addNewExtensionTimeCondition';
        $list['fields']['form_action'] = 'add';
        $list['fields']['extension_id'] = $extensionId;
        $list['fields']['is_extension'] = 1;
        $list['fields']['url'] = 'extension.php';
        $list['fields']['comp_id'] = $company_info['comp_id'];
        $this->exportType = 'html';
        $this->fileName = 'addTimeConditionNew.php';
        $this->template($list, '');
    }

    /**
     * addNewExtensionTimeConditonForm
     * @param $extensionId
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function editNewExtensionTimeConditionForm($time_condtion_name_id)
    {
        global $company_info;
        $fields = $this->setArraysToFields();
        $timeConditionDirty = AdminNewNameExstionModel::find($time_condtion_name_id);
        $timeConditionID = $timeConditionDirty->id;
        $timeCondition = AdminNewExstionModel::getBy_time_condtion_name_id($time_condtion_name_id)->getList();
        $timeConditionClean = $timeCondition['export']['list'];

        $extension_id = $timeConditionClean[0]['extension_id'];
        $timeConditionName = AdminNewNameExstionModel::find($timeConditionID);
        if ($timeCondition['result'] != 1) {
            return $timeCondition['msg'];
        }
        $fields = $this->reArrangeTimeConditionData($fields, $timeConditionClean);
        $timeConditionOption = new TblDstOptionService();
        $dialExtension_list = $timeConditionOption->getExtensionTimeConditionOption($extension_id);
        //print_r_debug($dialExtension_list);
        $fields['dst_option_id'] = $timeConditionOption->getDialExtensionDetailByNameExtension($dialExtension_list, $extension_id);
        //print_r_debug($fields);
        $fields['fdst_option_id'] = $fields['dst_option_id'];
        $fields['action'] = 'editNewExtensionTimeCondition';
        $fields['comp_id'] = $company_info['comp_id'];
        $fields['extension_id'] = $extension_id;
        $fields['is_extension'] = 1;
        $fields['url'] = 'extension.php';
        $fields['form_action'] = 'edit';
        $fields['timeConditionID'] = $time_condtion_name_id;
        $fields['name'] = $timeConditionName->name;
        $result['fields'] = $fields;
        $result['result'] = 1;


        $result['msg'] = 'Successfully Update';
        $this->exportType = 'html';
        $this->fileName = 'addTimeConditionNew.php';
        $this->template($result, '');

        die();
    }


    /**
     * Deletes extension based on its ID
     *
     * @param $extensionID
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function deleteTimeCondition($time_condtion_name_id)
    {
        global $conn, $lang, $company_info;

        $detailedTimeCondition = AdminNewExstionModel::getBy_time_condtion_name_id($time_condtion_name_id)->get();

        $input['comp_id'] = $company_info['comp_id'];
        $input['id'] = $time_condtion_name_id;
        $input['name'] = "Time Condition";
        $input['dst_option_id'] = '12';

        $checkDependency = new DependencyService;
        $result = $checkDependency->checkDependency($input);

        $extension_id = $detailedTimeCondition['export']['list']['0']->extension_id;


        if ($result['msg'] != '') {
            $this->showTimeConditionFrom($extension_id, $result['msg']);
            die();
        } else {
            if ($detailedTimeCondition['export']['recordsCount'] > 0) {


                foreach ($detailedTimeCondition['export']['list'] as $timeCondition) {


                    $result1 = $timeCondition->delete();
                    if ($result1['result'] != 1) {
                        $destination = 'extension.php';
                        $this->showRelatedTemplate('', $destination, '');
                    }
                }
            }

            $result2 = AdminNewNameExstionModel::find($time_condtion_name_id);

            $extension_id = $result2->extension_id;

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
                redirectPage(RELA_DIR . "extension.php?action=showTimeCondition&id=" . $extension_id, ModelANNOUNCE_17);
            } else {
                $destination = 'extension.php';
                $this->showRelatedTemplate('', $destination, '');
            }
            die();
        }
    }

    /**
     * set a destination template address and needed variables in this method and it will show it like ABC
     *
     * @var $fields
     * @var $destination
     * @var $msg
     */
    private function showRelatedTemplate($fields, $destination, $message = '')
    {
        $this->exportType = 'html';
        $this->fileName = $destination;
        $this->template($fields, $message);
        die();
    }

    /**
     * Deletes extension based on its ID
     *
     * @param $extensionID
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function deleteExtensions_temp($extensionID)
    {
        global $conn, $lang;
        $operation = new extension_operation();
        $result = $operation->deleteExtension($extensionID);

        if ($result['result'] == -1) {
            return $result;
        } else {
            $msg = ModelEXTENSION_11;
            redirectPage(RELA_DIR . "trash.php?action=showExtensionTrash", $msg);
        }
        die();
    }

    /**
     * Deletes extension based on its ID
     *
     * @param $extensionID
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function deleteExtensions($extensionID)
    {

        global $conn, $lang, $company_info;
        $found = 0;

        $checkDependency = new DependencyService;
        $input['id'] = $extensionID;
        $input['comp_id'] = AdminExtensionModel::find($extensionID)->comp_id;
        $input['name'] = 'Extension';
        /*$input['dst_option_id'] = '3';
        $result = $checkDependency->checkDependency($input);
        if ($result['msg'] != '') {
            $this->showAllExtensions($result['msg']);
            die();
        }

        $input['dst_option_id'] = '12';
        $result = $checkDependency->checkDependency($input);
        if ($result['msg'] != '') {
            $this->showAllExtensions($result['msg']);
            die();
        }*/

        $input['dst_option_id'] = '9';
        $result = $checkDependency->checkDependency($input);
        if ($result['msg'] != '') {
            $this->showAllExtensions($result['msg']);
            die();
        }

        $input['name'] = 'voiceMail';
        $input['dst_option_id'] = '6';
        $result = $checkDependency->checkDependency($input);
        if ($result['msg'] != '') {
            $this->showAllExtensions($result['msg']);
            die();
        }

        $timeConditionModel = adminTimeConditionModel::getBy_extension_id($extensionID)->get();
        foreach ($timeConditionModel['export']['list'] as $extensions) {
            $extensions->delete();
        }

        $timeConditionModel = AdminNewNameExstionModel::getBy_extension_id($extensionID)->get();
        foreach ($timeConditionModel['export']['list'] as $extensions) {
            $extensions->delete();
        }

        $extension = adminExtensionModel::find($extensionID);
        $extension->delete();
        $company = new CompanyService();
        $company->activeRelaod($company_info['comp_id']);
        $msg = ModelEXTENSION_11;
        redirectPage(RELA_DIR . "extension.php", $msg);
//        }
        die();
    }


    /**
     * Checks if announces exists based on comp ID
     *
     * @param $extensionID
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function checkAnnounceDependency($extensionID)
    {
        $operation = new extension_operation();
        $result = $operation->checkAnnounceDependency($extensionID);

        return $result;
    }

    /**
     * Checks if announces exists based on comp ID
     *
     * @param $extensionID
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function checkQueueDependency($extensionID)
    {
        $operation = new extension_operation();
        $result = $operation->checkQueueDependency($extensionID);

        return $result;
    }

    /**
     * Checks if announces exists based on comp ID
     *
     * @param $extensionID
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function checkInboundDependency($extensionID)
    {
        $operation = new extension_operation();
        $result = $operation->checkInboundDependency($extensionID);

        return $result;
    }

    /**
     * Checks if announces exists based on comp ID
     *
     * @param $extensionID
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function checkIvrDependency($extensionID)
    {
        $operation = new extension_operation();
        $result = $operation->checkIvrDependency($extensionID);

        return $result;
    }

    //-------------------- VALIDATE INPUTS AND OUTPUTS IN TIME CONDITION (FAILED AND SUCCESS) --------------------//

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

        $this->insertExtensionArrays($fields);

        $this->insertVoiceArrays($fields);

        unset($fields['id']);
        $fields['id'] = $fields['TCID'];

        if ($fields['status'] == 1) {
            $destination = 'successTimeCondition.php';
        } else {
            $destination = 'failedTimeCondition.php';
        }

        $this->showRelatedTemplate($fields, $destination);
    }

    /**
     * checks if There is no Time conflict in the inserted array
     *
     * @var $fields
     */
    private function checkTimeConflict(&$fields)
    {
        $fields['error'] = array();

        // this method is 598 faster than counting the size inside of loop
        // The slow one i.e: for ($i = 0; $i < count($var); $i++)
        // The fast one i.e: $limit = count($var)
        // for ($i = 0; $i < $limit $i++)
        $limit = count($fields['monthStart']) - 1;

        // if the + button clicked for first/second time then add the time condition
        // The fields['plus'] value shows if there will be new time condition or not (0 = false, 1 = true)
        if ($limit == -1 or $limit == 0) {
            $fields['plus'] = 1;
        }

        // if the 'hour start' is equal with 'hour end' then add an error
        // the 'hour end' always must be greater than 'hour start'
        for ($i = 0; $i <= $limit; $i++) {
            $fields['error'][$i] = 0;
            if ($fields['hourStart'][$i] == $fields['hourEnd'][$i]) {
                $fields['error'][$i] = 2;
                $fields['plus'] = 0;
            } else {
                $fields['error'][$i] = 0;
            }
        }

        // Checking if there is more than 1 input then compare the entry value with the previous existence,
        // so there will be no time conflict
        if ($limit >= 1) {
            for ($i = 0; $i < $limit; $i++) {
                if (
                    //check if the entry's Start Time is between the previous value's Start Time and End Time
                    ($fields['hourStart'][$limit] >= $fields['hourStart'][$i] and $fields['hourStart'][$limit] <= $fields['hourEnd'][$i])
                    or
                    //check if the entry's Start Time is before the previous value's and entry's End Time is before the previous value's End Time
                    ($fields['hourStart'][$limit] <= $fields['hourStart'][$i] and $fields['hourEnd'][$limit] >= $fields['hourStart'][$i])
                ) {
                    if (
                        //check if the entry's Start Day is between the previous value's Start Day and End Day
                        ($fields['weekDayStart'][$limit] >= $fields['weekDayStart'][$i] and $fields['weekDayStart'][$limit] <= $fields['weekDayEnd'][$i])
                        or
                        //check if the entry's Start Day is before the previous value's and entry's End Day is before the previous value's End Day
                        ($fields['weekDayStart'][$limit] <= $fields['weekDayStart'][$i] and $fields['weekDayEnd'][$limit] >= $fields['weekDayStart'][$i])
                    ) {
                        if (
                            //check if the entry's Start Day is between the previous value's Start Day and End Day
                            ($fields['dayStart'][$limit] >= $fields['dayStart'][$i] and $fields['dayStart'][$limit] <= $fields['dayEnd'][$i])
                            or
                            //check if the entry's Start Day is before the previous value's and entry's End Day is before the previous value's End Day
                            ($fields['dayStart'][$limit] <= $fields['dayStart'][$i] and $fields['dayEnd'][$limit] >= $fields['dayStart'][$i])
                        ) {
                            if (
                                //check if the entry's Start Month is between the previous value's Start month and End Month
                                ($fields['monthStart'][$limit] >= $fields['monthStart'][$i] and $fields['monthStart'][$limit] <= $fields['monthEnd'][$i])
                                or
                                //check if the entry's Start Month is before the previous value's and entry's End Month is before the previous value's End Month
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
            // checking if there is a error or no ( conflict ) !
            if ($fields['error'][$i] != 0) {
                $fields['plus'] = 0;
                break;
            } else {
                $fields['plus'] = 1;
            }
        }

    }

    /**
     * Change time format from HH:MM:SS to HH.MM so we can compare the time conflict
     *
     * @var $fields
     */
    private function reFactorTimeVariable(&$fields)
    {
        //Reformatting Time from any format to HH:MM:SS with adding 0 before H if the hour is before 10
        for ($i = 0; $i < count($fields['hourStart']); $i++) {
            if (substr($fields['hourStart'][$i], 0, 2) < 10) {
                $fields['hourStart'][$i] = '0' . $fields['hourStart'][$i];
            }

            if (substr($fields['hourEnd'][$i], 0, 2) < 10) {
                $fields['hourEnd'][$i] = '0' . $fields['hourEnd'][$i];
            }

            //Reformatting the Time from HH:MM:SS to HH.MM, so we can compare it with previous ones(conflict check)
            $fields['hourStart'][$i] = str_replace(':', '.', $fields['hourStart'][$i]);
            $fields['hourEnd'][$i] = str_replace(':', '.', $fields['hourEnd'][$i]);
            $fields['hourStart'][$i] = substr($fields['hourStart'][$i], 0, 5);
            $fields['hourEnd'][$i] = substr($fields['hourEnd'][$i], 0, 5);
        }

    }

    /**
     * Change the Time Format From HH.MM to HH:MM:SS
     *
     * @var $fields
     */
    private function deFactorTimeVariable(&$fields)
    {
        for ($i = 0; $i < count($fields['hourStart']); $i++) {

            //Reformatting the time from HH.MM to HH.MM.SS with adding 00
            $fields['hourStart'][$i] = $fields['hourStart'][$i] . ':00';
            $fields['hourEnd'][$i] = $fields['hourEnd'][$i] . ':00';
            //Reformatting the time from HH.MM.SS with replacing : instead of .
            $fields['hourStart'][$i] = str_replace('.', ':', $fields['hourStart'][$i]);
            $fields['hourEnd'][$i] = str_replace('.', ':', $fields['hourEnd'][$i]);
        }
    }

    /**
     * baraye darje arayeyi az liste extensionhaye mojod dar DataBase va insert shode dar TimeTable
     *
     * @var $fields
     */
    private function insertExtensionArrays(&$fields)
    {
        if (isset($fields['action'])) {
            //find the All time conditons
            if ($fields['status'] == 0) {
                $timeScheduleDirty = adminTimeConditionModel::getBy_extension_id_and_status($fields['id'], 0)->getList();
            } else {
                $timeScheduleDirty = adminTimeConditionModel::getBy_extension_id_and_status($fields['id'], 1)->getList();
            }

            $timeScheduleClean = $timeScheduleDirty['export']['list'];
            //setting the found Extension and other arrays in the html format in the $fields variable
            $this->reArrangeData($fields, $timeScheduleClean);
        }

        //Get All the Extension name list from database
        $extensionDirty = adminExtensionModel::getAll()->getList();
        $extensionClean = $extensionDirty['export']['list'];

        //set the all the Extension name List to the output variable
        $help = array();
        foreach ($extensionClean as $key => $value) {
            $help[] = $value['extension_name'];
        }

        $fields['extensionList'] = $help;
    }

    /**
     * Gives a list, of all the voices
     *
     * @var $fields
     */
    private function insertVoiceArrays(&$fields)
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
     * To Find The Time Table That We Are In It Right Now(Current time)
     *
     * @var $fields
     * @return array
     */
    public function findCurrentTimeTable($fields)
    {
        $extensionId = $fields['id'];
        $conn = dbConn::getConnection();

        $sql = "SELECT CURTIME()";
        $stmTp = $conn->prepare($sql);
        $stmTp->setFetchMode(PDO::FETCH_ASSOC);
        $stmTp->execute();
        $currentTime = $stmTp->fetch();

        $sql = "SELECT * FROM `time_condition`
                    WHERE 
                    (hourStart <= '.$currentTime.' AND hourEnd >= '.$currentTime.')
                    AND
                    (monthStart <= MONTH(CURRENT_DATE()) AND monthEnd >= MONTH(CURRENT_DATE()))
                    AND
                    extension_id = '.$extensionId.'";

        $stmTp = $conn->prepare($sql);
        $stmTp->setFetchMode(PDO::FETCH_ASSOC);
        $stmTp->execute();
        $result = $stmTp->fetch();

        return $result;
    }

    /**
     * when we fetch data from database it needs to be changed to html page variables so we can use them easily
     *
     * @var $fields
     * @var $timeScheduleClean
     */

    private function reArrangeTimeConditionData($fields, $timeScheduleClean)
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

//-------------------- FILL FORWARD & DSTOPTION SELECT WITH PROPER VALUE ASKED WITH AJAX (EXTENSION) --------------------//

    /**
     * Fill The First Select using AJAX in the Success Dial Destination
     *
     * @var $input
     */
    public function dialDestination($input)
    {
        $dialDestination = new AdminDialDestinationController();

        switch ($input['dialDestination']) {
            case 'successDirectDial' :
                $dialDestination->directDial('successForward', 'successDSTOption');
                break;
            case 'successTimeCondition' :
                $dialDestination->timeCondition('successTimeConditionLink', 'successForward', 'successDSTOption');
                break;
            case 'successVoiceMail' :
                $dialDestination->voiceMail('successForward', 'forward');
                break;
            case 'successForwarding' :
                $dialDestination->forward('successForward', 'forward');
                break;
            case 'failedTimeCondition' :
                $dialDestination->timeCondition('failedTimeConditionLink', 'failedForward', 'failedDSTOption');
                break;
            case 'failedVoiceMail' :
                $dialDestination->voiceMail('failedForward', 'forward');
                break;
            case 'failedForwarding' :
                $dialDestination->forward('failedForward', 'forward');
                break;
        }
    }

    /**
     * Fill The First Select using AJAX in the Success Forward Part
     *
     * @var $input
     */
    public function forwardSelectTag($input)
    {
        $dialDestination = new AdminDialDestinationController();
        $status = $input['status'];
        switch ($input['Forward']) {
            case 'internal' :
                $extensionObj = new adminExtensionModel();
                $extensionDirty = $extensionObj->getByFilter('');
                $extensionClean = $extensionDirty['export']['list'];
                if ($status == 'success') {
                    $dialDestination->internal($extensionClean, 'successDSTOption');
                } elseif ($status == 'failed') {
                    $dialDestination->internal($extensionClean, 'failedDSTOption');
                }
                break;
            case 'external' :
                if ($status == 'success') {
                    $dialDestination->external('successDSTOption');
                } elseif ($status == 'failed') {
                    $dialDestination->external('failedDSTOption');
                }
                break;
            case 'customMessageByRecord':
                if ($status == 'success') {
                    $dialDestination->customMessageByRecord(1, 'successRecordVoiceLink');
                } elseif ($status == 'failed') {
                    $dialDestination->customMessageByRecord(0, 'failedRecordVoiceLink');
                }
                break;
            case 'customMessageByList':
                global $admin_info, $member_info;
                if ($admin_info != -1) {
                    $company_id = $admin_info['comp_id'];
                    $voiceDirty = AdminUploadModel::getBy_comp_id($company_id)->getList();
                } elseif ($member_info != -1) {
                    $company_id = $member_info['comp_id'];
                    $extension_id = $member_info['extension_id'];
                    $voiceDirty = AdminUploadModel::getBy_comp_id_and_extension_id($company_id, $extension_id)->getList();
                }

                foreach ($voiceDirty['export']['list'] as $key => $value) {
                    $voiceClean[$value['upload_id']] = $value['title'];
                }


                if ($status == 'success') {
                    $dialDestination->customMessageByList($voiceClean, 'successDSTOption');
                } elseif ($status == 'failed') {
                    $dialDestination->customMessageByList($voiceClean, 'failedDSTOption');
                }

                break;
        }
    }

    //---------------------------- SHOW TIME CONDITION PAGE FOR EXTENSION (FAILED AND SUCCESS) ----------------------------//

    /**
     * show the time condition page for the success dial Destination
     *
     * @var $extensionId
     */
    public function showSuccessTimeConditionPage($extensionId)
    {
        if (isset($_SESSION['extensionForm'][$extensionId]) & !empty($_SESSION['extensionForm'][$extensionId])) {
            $fields = $_SESSION['extensionForm'][$extensionId];
        } else {

            $extension = AdminExtensionModel::find($extensionId);

            if (!is_object($extension)) {
                redirectPage(RELA_DIR . 'extension.php', 'There is no such extension');
            }

            $fields = $extension->fields;
        }

        $extensionDirty = adminExtensionModel::getAll()->getList();
        $extensionClean = $extensionDirty['export']['list'];

        $help = array();
        foreach ($extensionClean as $key => $value) {
            $help[] = $value['extension_name'];
        }

        $fields['extensionList'] = $help;

        $this->setArraysToFields($fields);
        $fields['plus'] = 0;

        $timeScheduleDirty = adminTimeConditionModel::getBy_extension_id_and_status($extensionId, 1)->getList();
        $timeScheduleClean = $timeScheduleDirty['export']['list'];
        $this->reArrangeData($fields, $timeScheduleClean);

        //vared kardane list voice haye insert shode va mojod dar database
        $this->insertVoiceArrays($fields);

        $destination = "successTimeCondition.php";
        $this->showRelatedTemplate($fields, $destination);
        die();
    }

    /**
     * show the time condition page for the failed dial Destination
     *
     * @var $extensionId
     */
    public function showFailedTimeConditionPage($extensionId)
    {
        if (isset($_SESSION['extensionForm'][$extensionId]) & !empty($_SESSION['extensionForm'][$extensionId])) {
            $fields = $_SESSION['extensionForm'][$extensionId];
        } else {

            $extension = AdminExtensionModel::find($extensionId);

            if (!is_object($extension)) {
                redirectPage(RELA_DIR . 'extension.php', 'There is no such extension');
            }

            $fields = $extension->fields;
        }

        $extensionDirty = adminExtensionModel::getAll()->getList();
        $extensionClean = $extensionDirty['export']['list'];

        $help = array();
        foreach ($extensionClean as $key => $value) {
            $help[] = $value['extension_name'];
        }
        $fields['extensionList'] = $help;

        $this->setArraysToFields($fields);
        //if $fields['plus'] is 1 it means that we should add 1 more time table but if it is 0 it meant don't add
        $fields['plus'] = 0;

        $timeScheduleDirty = adminTimeConditionModel::getBy_extension_id_and_status($extensionId, 0)->getList();
        $timeScheduleClean = $timeScheduleDirty['export']['list'];
        $this->reArrangeData($fields, $timeScheduleClean);

        //vared kardane list voice haye insert shode va mojod dar database
        $this->insertVoiceArrays($fields);

        $destination = "failedTimeCondition.php";
        $this->showRelatedTemplate($fields, $destination);
        die();
    }

    //---------------------------- TIME CONDITION SUBMIT SECTION (FAILED AND SUCCESS) ----------------------------//

    /**
     * Submit all the Failed time Condition Data in to the DataBase
     *
     * @var $fields
     */
    public function editFailedTimeCondition($fields)
    {
        $fields['status'] = 0;
        $this->reFactorTimeVariable($fields);
        $this->checkTimeConflict($fields);
        if (!in_array(0, $fields['error'])) {

            $this->setArraysToFields($fields);

            //vared kardane list voice haye insert shode va mojod dar database
            $this->insertExtensionArrays($fields);

            //vared kardane list extension haye insert shode va mojod dar database
            $this->insertVoiceArrays($fields);

            $destination = 'successTimeCondition.php';
            $this->showRelatedTemplate($fields, $destination);
        }
        // baraye tabdile format Time az HH.MM be HH:MM:SS
        $this->deFactorTimeVariable($fields);

        $timeConditionModel = new adminTimeConditionModel();

        if (empty($timeConditionModel::getBy_extension_id_and_status($fields['id'], 0)->getList())) {
            $result = $timeConditionModel->SetFieldsAndSave($fields);
        } else {
            $extensions = $timeConditionModel::getBy_extension_id_and_status($fields['id'], 0)->get();
            foreach ($extensions['export']['list'] as $extension) {
                $extension->delete();
            }
            $result = $timeConditionModel->SetFieldsAndSave($fields);
        }

        if ($result['result'] == 1) {
            redirectPage(RELA_DIR . "extension.php?action=failedTimeCondition&id=" . $fields['id'], ModelANNOUNCE_02);
        } else {
            $fields['plus'] = 0;
            $this->setArraysToFields($fields);
            //vared kardane list extension haye insert shode va mojod dar database
            $this->insertExtensionArrays($fields);
            $destination = 'successTimeCondition.php';
            $this->showRelatedTemplate($fields, $destination);
        }
    }

    /**
     * Submit all the success time Condition Data in to the DataBase
     *
     * @var $fields
     */
    public function editSuccessTimeCondition($fields)
    {
        $fields['status'] = 1;
        $this->reFactorTimeVariable($fields);
        $this->checkTimeConflict($fields);
        if (!in_array(0, $fields['error'])) {

            $this->setArraysToFields($fields);

            //vared kardane list extension haye insert shode va mojod dar database
            $this->insertExtensionArrays($fields);

            //vared kardane list extension haye insert shode va mojod dar database
            $this->insertVoiceArrays($fields);

            $destination = 'successTimeCondition.php';
            $this->showRelatedTemplate($fields, $destination);
        }
        // baraye tabdile formate Time az HH.MM be HH:MM:SS
        $this->deFactorTimeVariable($fields);

        $timeConditionModel = new adminTimeConditionModel();

        if (empty($timeConditionModel::getBy_extension_id_and_status($fields['id'], 1)->getList())) {
            $result = $timeConditionModel->SetFieldsAndSave($fields);
        } else {
            $extensions = $timeConditionModel::getBy_extension_id_and_status($fields['id'], 1)->get();
            foreach ($extensions['export']['list'] as $extension) {
                $extension->delete();
            }
            $result = $timeConditionModel->SetFieldsAndSave($fields);
        }

        if ($result['result'] == 1) {
            redirectPage(RELA_DIR . "extension.php?action=successTimeCondition&id=" . $fields['id'], ModelANNOUNCE_02);
        } else {
            $fields['plus'] = 0;
            $this->setArraysToFields($fields);
            //vared kardane list extension haye insert shode va mojod dar database
            $this->insertExtensionArrays($fields);
            $destination = 'successTimeCondition.php';
            $this->showRelatedTemplate($fields, $destination);
        }
    }

    //----------------------------------- TIME CONDITION SECTION -----------------------------------//

    /**
     * Fill the Forward Combo Box Using Ajax in the Time Condition Section(Both of Them)
     *
     * @var $input
     */
    public function TCForwardSelectTag($input)
    {
        $status = $input['status'];
        $dialDestination = new AdminDialDestinationController();
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
            case 'Forward' :
                if ($status == 'success') {
                    $dialDestination->forward('forward[]', 'Forward');
                } elseif ($status == 'failed') {
                    $dialDestination->forward('FForward', 'FForward');
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
        }
    }

    /**
     * Fill the DSTOption Combo Box Using Ajax in the Time Condition Section(Both of Them)
     *
     * @var $input
     */
    public function DSTOptionSelectTag($input)
    {
        $dialDestination = new AdminDialDestinationController();
        $recordId = $input['recordId'];
        $status = $_POST['status'];

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
            case 'customMessageByRecord':
                if ($status == 'success') {
                    $dialDestination->customMessageByRecord($recordId, 'successRecordVoiceLink');
                } elseif ($status == 'failed') {
                    $dialDestination->customMessageByRecord($recordId, 'failedRecordVoiceLink');
                }
                break;
            case 'customMessageByList':
                global $admin_info, $member_info;
                if ($admin_info != -1) {
                    $company_id = $admin_info['comp_id'];
                    $voiceDirty = AdminUploadModel::getBy_comp_id($company_id)->getList();
                } elseif ($member_info != -1) {
                    $company_id = $member_info['comp_id'];
                    $extension_id = $member_info['extension_id'];
                    $voiceDirty = AdminUploadModel::getBy_comp_id_and_extension_id($company_id, $extension_id)->getList();
                }

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
                $extensionDirty = $extensionObj->getByFilter('');
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
    private function timeConditionForward()
    {

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
     * Redirecting the Page to the to Record the Voice
     *
     * @var $fields
     */
    public function successTCRecordVoice($fields)
    {
        $destination = 'voiceIndex.php';
        $this->showRelatedTemplate($fields, $destination);
    }

    public function checkDependency($input)
    {
        $resultExtension = AdminExstionNewModel::getBy_dialExtension_and_forward_and_comp_id("ExtensionTimeCondition", $input['id'], $input['comp_id'])->getList();
        if ($resultExtension['export']['recordsCount'] >= 1) {
            foreach ($resultExtension['export']['list'] as $key => $value) {
                $result['msg'][] = 'This ' . $input['name'] . ' has been used by this Extension : ' . $value['extension_name'];
            }
        }
        $resultTimeCondition = AdminNewExstionModel::getBy_dialExtension_and_forward_and_comp_id('ExtensionTimeCondition', $input['id'], $input['comp_id'])->getList();
        if ($resultTimeCondition['export']['recordsCount'] >= 1) {
            foreach ($resultTimeCondition['export']['list'] as $key => $value) {
                $timeConditonName = AdminNewNameExstionModel::getBy_id($value['time_condtion_name_id'])->getList();
                $result['msg'][] = 'This ' . $input['name'] . ' has been used by this Time Condition : ' . $timeConditonName['export']['list']['0']['name'];
            }
        }
        return $result;

    }
    //checkAdinName
    public function checkAdminName($fields)
    {
        global $company_info;
        return AdminUser::getBy_comp_id_and_username($company_info['comp_id'], $fields['username'])->getList();
    }



    //**************************  add by Jahanbakhsh
    //function for api
    public function getAllExtensionsApi()
    {
        $extensionList = AdminExstionNewModel::getAll()->getList();
        echo json_encode($extensionList);
        die();
    }

}
