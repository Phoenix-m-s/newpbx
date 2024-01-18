<?php
include_once ROOT_DIR . "component/extension/AdminExstionNewModel.php";
include_once ROOT_DIR . 'component/admin/AdminUser.php';
include_once ROOT_DIR . "services/TblDstOptionService.php";
include_once ROOT_DIR . "services/QueueService.php";

/**
 * Class ExtensionService
 */
class ExtensionService
{
    private $voiceMailList = array(array('id' => 'withOutMessage', 'name' => 'withOutMessage'), array('id' => 'defaultMessage', 'name' => 'defaultMessage'));

    /**
     *getAllExtension
     * @return mixed
     * @author:Mojtaba Sakhamanesh & Shabihi
     *Email:sakhamanesh@dabacenter.ir
     * @version:0.0.1
     */
    public function getAllExtension($id)
    {
        global $admin_info;
        if ($id) {
            $extensionList = AdminExstionNewModel::getAll()
                ->where('extension_id', '!=', $id)
                ->get();
        } else {

            $extensionList = AdminExstionNewModel::getAll()
                ->where('comp_id', '=', $admin_info['comp_id'])->get();

        }
        $result['0'] = array('name' => 'choose from list', 'id' => '');
        $i = 1;
        foreach ($extensionList['export']['list'] as $key => $value) {
            $result[$i]['name'] = $value->fields['extension_no'];
            $result[$i]['id'] = $value->fields['extension_id'];
            $i++;
        }
        return $result;

    }

    public function getAllExtensionName()
    {
        global $company_info;
        $upLoadDirty = AdminExtensionModel::getAll() ->where('comp_id', '=', $company_info['comp_id'])->get();;

        foreach ($upLoadDirty['export']['list'] as $key => $value) {
            $result[$key]['name'] = $value->fields['extension_name'];
            $result[$key]['id'] = $value->fields['extension_id'];
        }

        return $result;

    }

    public function getAllExtensionNameWithType()
    {

        $upLoadDirty = AdminExtensionModel::getAll()->get();

        foreach ($upLoadDirty['export']['list'] as $key => $value) {
            $result[$key]['name'] = $value->fields['extension_name'];
            $result[$key]['id'] = $value->fields['extension_id'];
            $result[$key]['type'] = 0;
        }

        return $result;

    }


    public function checkExtensionNumber($fields)
    {
        return AdminExtensionModel::getBy_extension_no_and_comp_id($fields['queue_ext_no'], $fields['comp_id'])->getList();
    }


    /**
     * @param $fields
     * @return mixed
     */
    public function checkAdminName($fields)
    {
        global $company_info;
        return AdminUser::getBy_comp_id_and_username($company_info['comp_id'], $fields['username'])->getList();
    }

    //checkExtentionName for username

    /**
     * @param $fields
     * @return mixed
     */


    public function addExtensionForm()
    {
        global $conn, $lang, $company_info;
        $extensionOption = new TblDstOptionService();
        $dialExtension_list = $extensionOption->getExtensionSuccessOption();
        $list['dst_option_id'] = $extensionOption->getDialExtensionDetailByName($dialExtension_list);
        $FdialExtension_list = $extensionOption->getExtensionFailedOption();
        $list['fdst_option_id'] = $extensionOption->getDialExtensionDetailByName($FdialExtension_list);
        foreach ($list['fdst_option_id'] as $key => $value) {
            if ($value['dst_option_id'] == 6) {
                foreach ($value['child'] as $k => $v) {
                    $list['fdst_option_id'][$key]['child'][$k]['child'] = $this->voiceMailList;
                }
            }
        }

        $list['protocol'] =
            array(
                array('id' => '', 'name' => 'choose from list'),
                array('id' => 'sip', 'name' => 'sip'),
                array('id' => 'sccp', 'name' => 'sccp'),
                array('id' => 'sip-webrtc', 'name' => 'sip-webrtc')
            );
        $string = file_get_contents(ROOT_DIR. "common/timezones.json");
        $timezones = json_decode($string, true);
        $list['timezones'] = $timezones;

//        $list['upload_id'] = $this->getVoiceList($fields);
        $list['action'] = 'addExtension';
        $list['form_action'] = 'add';
        $list['url'] = 'extension.php';
        $list['comp_id'] = $company_info['comp_id'];
        return $list;
    }

    public function addExtension($fields)
    {
        global $conn, $lang, $company_info, $mysql;
        if (!isset($fields['internal_recording'])) {
            $fields['internal_recording'] = 0;
        }

        if (!isset($fields['external_recording'])) {
            $fields['external_recording'] = 0;
        }

        if (!isset($fields['voicemail_email'])) {
            $fields['voicemail_email'] = 0;
        }

        if ($fields['forward'] == 'internal' && $fields['DSTOption'] == '') {
            $result['result'] = -1;
            $result['msg'] = 'this DSTOption is not exist';
            echo json_encode($result);
            die();
        }
        if ($fields['forward'] == 'Choose') {
            $result['result'] = -1;
            $result['msg'] = 'this DSTOption is not exist';
            echo json_encode($result);
            die();
        }

        $extensionNumberCheck = AdminExtensionModel::getBy_comp_id_and_extension_name($fields['comp_id'], $fields['tc'][0]['extension_name'])->getList();

        if ($extensionNumberCheck['export']['recordsCount'] >= 1) {
            $result['result'] = -1;
            $result['msg'] = 'this extension name is exist';
            echo json_encode($result);
            die();
        }

        /*
        * check mac address in other database
        * */
        if ($fields['protocol'] == 'sccp') {

            if (isset($mysql['connections']['mysql2'])) {
                $checkMac = AdminExtensionModel2::getAll()
                    ->where('mac_address', '=', $fields['tc'][0]['mac_address'])
                    ->getList();
                if ($checkMac['export']['recordsCount'] >= 1) {
                    $result['result'] = -1;
                    $result['msg'] = 'this mac address is exist in other system';
                    echo json_encode($result);
                    die();

                }

            }


            $checkMac = AdminExtensionModel::getAll()
                ->where('mac_address', '=', $fields['tc'][0]['mac_address'])
                ->getList();
            if ($checkMac['export']['recordsCount'] >= 1) {
                $result['result'] = -1;
                $result['msg'] = 'this mac address is exist';
                echo json_encode($result);
                die();

            }

        }


        $extensionNumberCheck = AdminExtensionModel::getBy_comp_id_and_extension_no($fields['comp_id'], $fields['tc'][0]['extension_no'])->getList();
        if ($extensionNumberCheck['export']['recordsCount'] >= 1) {
            $result['result'] = -1;
            $result['msg'] = 'this extension number is exist';
            echo json_encode($result);
            die();
        }

        //**********************
        //checkusername extention
        $usernameCheck = AdminExtensionModel::getBy_comp_id_and_username($fields['comp_id'], $fields['tc'][0]['username'])->getList();
        if ($usernameCheck['export']['recordsCount'] >= 1) {
            $result['result'] = -1;
            $result['msg'] = 'this user name is exist';
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

        //******************
        //check AdminUsername
        $checkAdminUsername = $this->checkAdminName($fields);

        if ($checkAdminUsername['export']['recordsCount'] >= 1) {
            $result['result'] = -1;
            $result['msg'] = 'this adminUsername is exist';
            echo json_encode($result);
            die();
        }


        if ($fields['username'] != '' & $fields['password'] == '') {
            $result['result'] = -1;
            $result['msg'] = 'Please fill required items';
            echo json_encode($result);
            die();
        }

        if ($fields['tc'][0]['protocol'] == 'sip-webrtc') {

            $fields['tc'][0]['extension_type'] = 2;
        } else {
            $fields['tc'][0]['extension_type'] = 1;
        }

        $operation = new AdminExstionNewModel();
        $result = $operation->SetFieldsAndSave($fields);

        return $result;

    }

    public function checkUserName($fields)
    {
        return AdminExstionNewModel::getBy_username($fields['username'])->first();
    }


    public function addExtensionApi($fields)
    {

        global $company_info;
        $extension = $this->checkUserName($fields);

        if (!is_object($extension)) {
            $extension = new AdminExstionNewModel();

        }


        $modelFields = $extension->getFields();
        unset($modelFields['extension_id']);
        unset($modelFields['voicemail_status']);

        foreach ($modelFields as $key => $val) {
            $extension->$key = '';
        }

        $extension->extension_status = '1';
        $extension->voicemail_email = $fields['username'];
        $extension->voicemail_pass = $fields['extension_no'];
        $extension->extension_name = $fields['username'];
        $extension->extension_no = $fields['extension_no'];
        $extension->secret = '1';
        $extension->extension_date = date();
        $extension->internal_recording = '1';
        $extension->extension_date = strftime('%Y-%m-%d %H:%M:%S', time());
        $extension->external_recording = '1';
        $extension->extension_status = '1';
        $extension->caller_id_number = $fields['extension_no'];
        $extension->ring_number = '1';
        $extension->username = $fields['username'];
        $extension->password = $fields['extension_no'];
        $extension->dst_option_id = '10';
        $extension->dst_option_sub_id = '';
        $extension->DSTOption = '';
        $extension->mac_address = '';
        $extension->protocol = 'sip-webrtc';
        $extension->fdst_option_id = '';
        $extension->fdst_option_sub_id = '7';
        $extension->fDSTOption = '';
        $extension->comp_id = $company_info['comp_id'];
        $extension->extension_type = '2';
        $extension->dialExtension = '';
        $extension->sub_dst = '';
        $extension->forward = '';
        $extension->trash = '0';
        $extension->container_user_id = $fields['user_id'];
        $extension->timezone = $fields['timezone'];

        $result = $extension->save();

        return $extension->fields;


    }

    public function editExtensionApi($fields)
    {
        /*//checkusername
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
        }*/


        $extension = AdminExstionNewModel::find($fields['extension_id']);

        $extension->setFields($fields);
        $result = $extension->save();
        return $extension->fields;
    }

    public function editExtensionForm($extensionId)
    {
        global $company_info;
        $fields = [];
        $extension = AdminExstionNewModel::find($extensionId);
        $fields = $this->reArrangeData($fields, $extension);

        $extensionOption = new TblDstOptionService();
        $dialExtension_list = $extensionOption->getExtensionSuccessOption($extensionId);
        $fields['dst_option_id'] = $extensionOption->getDialExtensionDetailByName($dialExtension_list, $extensionId);
        $FdialExtension_list = $extensionOption->getExtensionFailedOption($extensionId);
        $fields['fdst_option_id'] = $extensionOption->getDialExtensionDetailByName($FdialExtension_list, $extensionId);
        $i = 0;

        foreach ($fields['fdst_option_id'] as $key => $value) {
            if ($value['dst_option_id'] == 6) {
                foreach ($value['child'] as $k => $v) {
                    $fields['fdst_option_id'][$key]['child'][$k]['child'] = $this->voiceMailList;
                }
            }
        }

        include_once ROOT_DIR . "component/voipConfig/AdminVoipConfigModel.php";

        $voipConfig = AdminVoipConfigModel::getAll()
            ->select('`voipconfig`.*')
            ->leftJoin('tbl_extension', 'voipconfig.extension_id', '=', 'tbl_extension.extension_id')
            ->where('tbl_extension.extension_id', '=', $extensionId)
            ->getList()['export']['list'];


        $voipConfig = end($voipConfig);

        $fields['tc'][0]['macAddress'] = $voipConfig['macAddress'];
        $fields['tc'][0]['line1_shortname'] = $voipConfig['line1_shortname'];
        $fields['tc'][0]['proxy1_port'] = $voipConfig['proxy1_port'];
        $fields['tc'][0]['proxy1_address'] = $voipConfig['proxy1_address'];
        $fields['tc'][0]['path'] = $voipConfig['path'];


        $fields['chooseDevice_selected'] = $voipConfig['devicemodels'];


        $fields['chooseDevice'] =
            array(array('id' => '', 'name' => 'choose from list'),
                array('id' => '0', 'name' => 'Cisco7960'));
        $fields['protocol'] =
            array(
                /*  array('id' => '', 'name' => 'choose from list'),*/
                array('id' => 'sip', 'name' => 'sip'),
                array('id' => 'sccp', 'name' => 'sccp'),
                array('id' => 'sip-webrtc', 'name' => 'sip-webrtc'),
            );
        $fields['protocol_selected'] = $fields['tc'][0]['protocol'];

        $i = 0;

        /*foreach ( $fields['chooseDevice'] as $key => $value) {
            $fields['chooseDevice'][$i]['id'] = $value['id'];
            $fields['chooseDevice'][$i]['name'] = $value['name'];
            $i++;
        }*/
        $string = file_get_contents(ROOT_DIR. "common/timezones.json");
        $timezones = json_decode($string, true);
        $fields['timezones'] = $timezones;
        $fields['action'] = 'editExtension';
        $fields['form_action'] = 'edit';
        $fields['url'] = 'extension.php';
        $fields['comp_id'] = $company_info['comp_id'];
        $fields['msg'] = 'edit information';
        return $fields;

    }

    private function reArrangeData($fields, $extension)
    {

        $fields['tc'][0]['extension_status'] = $extension->extension_status;
        $fields['tc'][0]['extension_id'] = $extension->extension_id;
        $fields['tc'][0]['voicemail_status'] = $extension->voicemail_status;
        $fields['tc'][0]['voicemail_email'] = $extension->voicemail_email;
        $fields['tc'][0]['voicemail_pass'] = $extension->voicemail_pass;
        $fields['tc'][0]['extension_name'] = $extension->extension_name;
        $fields['tc'][0]['line1_name'] = $extension->extension_name;
        $fields['tc'][0]['line1_authname'] = $extension->extension_name;
        $fields['tc'][0]['line1_password'] = $extension->password;
        $fields['tc'][0]['extension_no'] = $extension->extension_no;
        $fields['tc'][0]['extension_date'] = $extension->extension_date;
        $fields['tc'][0]['internal_recording'] = $extension->internal_recording;
        $fields['tc'][0]['external_recording'] = $extension->external_recording;
        $fields['tc'][0]['caller_id_number'] = $extension->caller_id_number;
        $fields['tc'][0]['ring_number'] = $extension->ring_number;
        $fields['tc'][0]['username'] = $extension->username;
        $fields['tc'][0]['password'] = $extension->password;
        $fields['tc'][0]['secret'] = $extension->secret;
        $fields['tc'][0]['protocol'] = $extension->protocol;
        $fields['tc'][0]['mac_address'] = $extension->mac_address;
        $fields['tc'][0]['timezone'] = $extension->timezone;


        $fields['tc'][0]['dst_option_id_selected']['dst_option_id'] = $extension->dst_option_id;
        $fields['tc'][0]['dst_option_id_selected']['dst_option_sub_id'] = $extension->dst_option_sub_id;
        $fields['tc'][0]['dst_option_id_selected']['DSTOption'] = $extension->DSTOption;

        $fields['failTc'][0]['fdst_option_id_selected']['fdst_option_id'] = $extension->fdst_option_id;
        $fields['failTc'][0]['fdst_option_id_selected']['fdst_option_sub_id'] = $extension->fdst_option_sub_id;
        $fields['failTc'][0]['fdst_option_id_selected']['fDSTOption'] = $extension->fDSTOption;

        if ($extension->internal_recording == 1 or $extension->external_recording == 1) {
            $fields['tc'][0]['enable_recording'] = "1";
        } else {
            $fields['tc'][0]['enable_recording'] = "0";
        }
        return $fields;
    }


    //***********************   add by Sakhamanesh
    //***********************   for API
    //no run bellow function hear, correct ==> extension.presentation.class.php
    public function getAllExtensionsApi()
    {
        $extensionList = AdminExstionNewModel::getAll()
            ->select(AdminExstionNewModel::$extensionFillable)
            ->paginate(10000)->getList();
        return $extensionList;
    }


    public function registerApiExtention($fields)
    {
        //sample data
        $fields = $this->inputTest();

        $checkExtension = $this->checkExtensionApi($fields);

        $extentionObject = new AdminExstionNewModel();

        /*   $extentionObject->extension_status         = $fields['extension_status'];
       $extentionObject->voicemail_status         = $fields['voicemail_status'] ;
       $extentionObject->voicemail_email          = $fields['voicemail_email'] ;
       $extentionObject->voicemail_pass           = $fields['voicemail_pass'] ;
       $extentionObject->extension_name           = $fields['extension_name'] ;
       $extentionObject->extension_no             = $fields['extension_no']  ;
       $extentionObject->secret                   = $fields['secret'] ;
       $extentionObject->extension_date           = $fields['extension_date'] ;
       $extentionObject->internal_recording       = $fields['internal_recording'];
       $extentionObject->extension_date           = strftime('%Y-%m-%d %H:%M:%S', time());
       $extentionObject->external_recording       = $fields['external_recording'];
       $extentionObject->extension_status         = 1;
       $extentionObject->caller_id_number         = $fields['caller_id_number'];
       $extentionObject->ring_number              = $fields['ring_number'];
       $extentionObject->username                 = $fields['username'];
       $extentionObject->password                 = $fields['password'];
       $extentionObject->dst_option_id            = $fields['dst_option_id_selected']['dst_option_id'];
       $extentionObject->dst_option_sub_id        = $fields['dst_option_id_selected']['dst_option_sub_id'];
       $extentionObject->DSTOption                = $fields['dst_option_id_selected']['DSTOption'];
       $extentionObject->mac_address              = strtoupper(['mac_address']);
       $extentionObject->protocol                 = $fields['protocol'];
       $extentionObject->fdst_option_id           = $fields['fdst_option_id'];
       $extentionObject->fdst_option_sub_id       = $fields['fdst_option_sub_id'];
       $extentionObject->fDSTOption               = $fields['fDSTOption'];
       $extentionObject->comp_id                  = $fields['comp_id'];


       if ($fields['forward']    ==='customMessageByList') {
           $extentionObject->DSTOption    = $fields['dst_option_id_selected']['DSTOption'];
       }
       if ($fields['forward']    ==='internal') {
           $extentionObject->DSTOption    = $fields['dst_option_id_selected']['DSTOption'];
       }
       if ($fields['forward']    ==='external') {
           $extentionObject->DSTOption    =$fields['dst_option_id_selected']['DSTOption'];
       }
       if($extentionObject->internal_recording==''){
           $extentionObject->internal_recording=0;
       }
       if($extentionObject->external_recording==''){
           $extentionObject->external_recording=0;
       }*/

        $extentionObject->setFields($checkExtension);

        $result = $extentionObject->save();
        return $result;
    }


    //check dependency for add Extension in api
    public function checkExtensionApi($fields)
    {
        global $conn, $lang, $company_info, $mysql;
        if (!isset($fields['internal_recording'])) {
            $fields['internal_recording'] = 0;
        }

        if (!isset($fields['external_recording'])) {
            $fields['external_recording'] = 0;
        }

        if (!isset($fields['voicemail_email'])) {
            $fields['voicemail_email'] = 0;
        }

        if ($fields['forward'] == 'internal' && $fields['DSTOption'] == '') {
            $result['result'] = -1;
            $result['msg'] = 'this DSTOption is not exist';
            echo json_encode($result);
            die();
        }
        if ($fields['forward'] == 'Choose') {
            $result['result'] = -1;
            $result['msg'] = 'this DSTOption is not exist';
            echo json_encode($result);
            die();
        }

        $extensionNumberCheck = AdminExtensionModel::getBy_comp_id_and_extension_name($fields['comp_id'], $fields['extension_name'])->getList();

        if ($extensionNumberCheck['export']['recordsCount'] >= 1) {
            $result['result'] = -1;
            $result['msg'] = 'this extension name is exist';
            echo json_encode($result);
            die();
        }

        /*
        * check mac address in other database
        * */
        if ($fields['protocol'] == 'sccp') {

            if (isset($mysql['connections']['mysql2'])) {
                $checkMac = AdminExtensionModel2::getAll()
                    ->where('mac_address', '=', $fields['mac_address'])
                    ->getList();
                if ($checkMac['export']['recordsCount'] >= 1) {
                    $result['result'] = -1;
                    $result['msg'] = 'this mac address is exist in other system';
                    echo json_encode($result);
                    die();

                }

            }


            $checkMac = AdminExtensionModel::getAll()
                ->where('mac_address', '=', $fields['mac_address'])
                ->getList();
            if ($checkMac['export']['recordsCount'] >= 1) {
                $result['result'] = -1;
                $result['msg'] = 'this mac address is exist';
                echo json_encode($result);
                die();

            }

        }


        $extensionNumberCheck = AdminExtensionModel::getBy_comp_id_and_extension_no($fields['comp_id'], $fields['extension_no'])->getList();
        if ($extensionNumberCheck['export']['recordsCount'] >= 1) {
            $result['result'] = -1;
            $result['msg'] = 'this extension number is exist';
            echo json_encode($result);
            die();
        }

        //**********************
        //checkusername extention
        $usernameCheck = AdminExtensionModel::getBy_comp_id_and_username($fields['comp_id'], $fields['username'])->getList();
        if ($usernameCheck['export']['recordsCount'] >= 1) {
            $result['result'] = -1;
            $result['msg'] = 'this user name is exist';
            echo json_encode($result);
            die();
        }

        $queueNumberCheck = adminQueueModel::getBy_queue_ext_no($fields['extension_no'])->getList();
        if ($queueNumberCheck['export']['recordsCount'] >= 1) {
            $result['result'] = -1;
            $result['msg'] = 'this extension number is exist';
            echo json_encode($result);
            die();
        }

        //******************
        //check AdminUsername
        $checkAdminUsername = $this->checkAdminName($fields);
        if ($checkAdminUsername['export']['recordsCount'] >= 1) {
            $result['result'] = -1;
            $result['msg'] = 'this adminUsername is exist';
            echo json_encode($result);
            die();
        }


        if ($fields['username'] != '' & $fields['password'] == '') {
            $result['result'] = -1;
            $result['msg'] = 'Please fill required items';
            echo json_encode($result);
            die();
        }

        return $fields;
    }


    public function inputTest()
    {
        $fields['extension_status'] = 01;
        $fields['voicemail_status'] = 02;
        $fields['voicemail_email'] = 03;
        $fields['voicemail_pass'] = 04;
        $fields['extension_name'] = 'ext_1';
        $fields['extension_no'] = 06;
        $fields['secret'] = 07;
        $fields['extension_date'] = strftime('%Y-%m-%d %H:%M:%S', time());
        $fields['internal_recording'] = 1;
        $fields['external_recording'] = 1;
        $fields['caller_id_number'] = 1;
        $fields['ring_number'] = 1;
        $fields['username'] = 'moji';
        $fields['password'] = 123456;
        $fields['dst_option_id_selected']['dst_option_id'] = 1;
        $fields['dst_option_id_selected']['dst_option_sub_id'] = 2;
        $fields['dst_option_id_selected']['DSTOption'] = 3;
        $fields['protocol'] = 1;
        $fields['fdst_option_id'] = 1;
        $fields['fdst_option_sub_id'] = 1;
        $fields['fDSTOption'] = 1;
        $fields['comp_id'] = 1;


        if ($fields['forward'] === 'customMessageByList') {
            $fields['DSTOption'] = 1;
        }
        if ($fields['forward'] === 'internal') {
            $fields['DSTOption'] = 2;
        }
        if ($fields['forward'] === 'external') {
            $fields['DSTOption'] = 3;
        }
        if ($fields['internal_recording'] == '') {
            $fields['internal_recording'] = 0;
        }
        if ($fields['external_recording'] == '') {
            $fields['external_recording'] = 0;
        }
        return $fields;

    }

}