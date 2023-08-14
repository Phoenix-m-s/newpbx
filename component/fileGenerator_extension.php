<?php

/**
 * Class Extention_fileGenerator
 * Created by DNA
 */
class Extention_fileGenerator extends DataBase
{
    /**
     * @var
     */
    private $class_fields;

    /**
     * @var
     */
    public $debugMode;

    /**
     * @var
     */
    public $fileName;

    /**
     * @var
     */
    public $defaultConfig;

    /**
     * @var
     */
    public $comp_id;

    /**
     * @param $comp_id
     */
    public function __construct($comp_id)
    {
        $this->comp_id = $comp_id;
    }
    function logAMIExtension($message, $isSuccessful) {
        global $company_info;
        // مسیر فایل لاگ
        if (!file_exists('voip/'.$company_info['comp_name'].'/log/')) {
            mkdir('voip/'.$company_info['comp_name'].'/'.'log/', 0777, true);

        }
        $logFilePath =  'voip/'.$company_info['comp_name'].'/'.'log/fileGenerator.log';

        // سطح لاگ‌گذاری: INFO برای موفقیت و ERROR برای خطا
        $logLevel = $isSuccessful ? 'INFO' : 'ERROR';

        // تاریخ و زمان کنونی
        $dateTime = date('Y-m-d H:i:s');

        // متن کامل لاگ (تاریخ و زمان + سطح + پیام)
        $logMessage = "[$dateTime] [$logLevel] $message\n";

        // ایجاد یا باز کردن فایل لاگ
        $fileHandle = fopen($logFilePath, 'a');
        // نوشتن لاگ در فایل
        fwrite($fileHandle, $logMessage);

        // بستن فایل لاگ
        fclose($fileHandle);
    }


    /**
     * @param $did_name
     * @param $cid_name
     * @return string
     */
    public function setDidCid($did_name, $cid_name)
    {
        if (strtolower($did_name) == '' and strtolower($cid_name) == '') {
            //$did_cid = '_[*|#|+|X].';
            $did_cid = 's';
        } else if (strtolower($did_name) == '' and strtolower($cid_name) != '') {
            $did_cid = '_X./' . $this->change_did_cid($cid_name);

        } else if (strtolower($did_name) != '' and strtolower($cid_name) == '') {
            $did_cid = $this->change_did_cid($did_name);

        } else if (strtolower($did_name) != '' and strtolower($cid_name) != '') {

            $did_cid = $this->change_did_cid($did_name) . '/' . $this->change_did_cid($cid_name);
        }
        return $did_cid;

    }


    /**
     * @param string $comp_id
     * @return mixed
     */
    public static function getCompany($comp_id = '')
    {
        global $company_info;
        $comp_id=$company_info['comp_id'];
        $conn = parent::getConnection();
        $append_sql = '';
        if ($comp_id != '') {
            $append_sql = 'and comp_id=' . $comp_id;
        }

        $sql = "SELECT * FROM tbl_company WHERE `trash`='0' $append_sql";

        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        if (!$stmt) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }

        $stmTp = $conn->prepare($sql);
        $stmTp->setFetchMode(PDO::FETCH_ASSOC);
        $stmTp->execute();

        while ($row = $stmt->fetch()) {
            $companyList[$row['comp_id']] = $row;
        }

        $result['list'] = $companyList;
        $result['result'] = 1;
        $result['no'] = 2;
        return $result;

    }

    /**
     *
     */

    public function getFristOutboundPrefix()
    {

        $conn = parent::getConnection();


        $sql = "SELECT
                `tbl_outbound`.`outbound_id`,
                `tbl_outbound`.`priority`,
                `tbl_dialpattern`.*
                FROM
                `tbl_outbound`
                LEFT JOIN `tbl_dialpattern` ON `tbl_dialpattern`.`outbound_id` =
                `tbl_outbound`.`outbound_id`
                WHERE
                        `tbl_outbound`.`comp_id` = '" . $this->comp_id . "'
                ORDER BY
                `tbl_outbound`.`priority` LIMIT 1
        ";


        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        if (!$stmt) {
            $result['result'] = -1;

            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }
        $fields = $stmt->fetch();
        $fields = explode(',', $fields['prefix']);
        return $fields['1'];

    }


    function createExtensionFile()
    {

        $defaultConfig = $this->defaultConfig;


        $list = array();
        $result = $this->getAllSipInfo();

        while ($row = $result['rs']->fetch()) {
            $list[] = $row;
        }

        if (count($list) > 0) {
            $count = $this->setFieldsSip($list, $defaultConfig);
        }

        $comp_list = $this->getCompany($this->comp_id);
        $list = array();
        $count = $this->setFieldsConfBridge($comp_list, $defaultConfig, $count);


        $list = array();
        $comp_list = $this->getCompany($this->comp_id);
        $count = $this->setFieldsMacroDial($comp_list, $defaultConfig, $count);
        $list = array();
        $comp_list = $this->getCompany($this->comp_id);
        $count = $this->setFieldsMacroRecord($comp_list, $defaultConfig, $count);


        $list = array();
        $result = $this->getAllSipInfo();
        while ($row = $result['rs']->fetch()) {
            $list[] = $row;
        }

        if (count($list) > 0) {
            $count = $this->setFieldsExtensionDialDestination($list, $defaultConfig, $count);
        }


        $result = $this->getAllAnnounceInfo();
        $list = array();
        while ($row = $result['rs']->fetch()) {
            $list[] = $row;
        }

        if (count($list) > 0) {
            $count = $this->setFieldsAnnounce($list, '', $count);
        }


        $result = $this->getAllOutboundInfo();
        $list = array();

        $i = 0;
        while ($row = $result['rs']->fetch()) {
            $list[$i] = $row;
            $list[$i]['siptrunk'] = $this->getAllSipTrunckInfo($row);
            $i++;
        }

        if (count($list) > 0) {

            $count = $this->setFieldsOutpattern($list, '', $count);

            $count = $this->setFieldsOutbound($list, '', $count);
        }

        $result = $this->getAllIvrInfo();

        $list = array();
        while ($row = $result['rs']->fetch()) {
            $list[] = $row;
        }

        if (count($list) > 0) {
            $count = $this->setFieldsIvr($list, '', $count);
        }

        $list = $this->getCompany($this->comp_id)['list'][$this->comp_id];
        $count = $this->setFieldsTrunk($list, '', $count);


        //$list = $this->getCompany($this->comp_id)['list'][$this->comp_id];
        //$count = $this->setFieldsallDID($list, '', $count);


        $result = $this->getAllInboundInfo();

        $list = array();
        while ($row = $result['rs']->fetch()) {
            $list[] = $row;
        }

        if (count($list) > 0) {

            $count = $this->setFieldsInbound($list, '', $count);

            $count = $this->setFieldsallDID($list, '', $count);

            $comp_fax_list = $this->getCompany($this->comp_id);
            $count = $this->setFieldsFax($comp_fax_list, '', $count);

        }


        $list = $this->getCompany($this->comp_id)['list'][$this->comp_id];
        $count = $this->setFieldsVoicemailMain($list, '', $count);

        $list = array();

        $result = $this->getCompany($this->comp_id);
        $list = $result['list'][$this->comp_id];

        if (count($list) > 0) {
            $count = $this->setFieldsPlayVocieMail($list, '', $count);
        }


        //timecondition
        $result = $this->getAlltimeCondition();
        $list = array();

        while ($row = $result['rs']->fetch()) {

            $list[$row['id']] = $row;

            $detail = $this->getAlltimeConditionDetail($row['id']);

            while ($rowDetail = $detail['rs']->fetch()) {

                $list[$row['id']]['detail'][$rowDetail['id']] = $rowDetail;

            }
        }

        if (count($list) > 0) {
            $count = $this->setFieldsTimeconditonMain($list, '', $count);
        }
        //  end time conditon


        //extension timecondition
        $result = $this->getAllExtensionTimeCondition();

        $list = array();

        while ($row = $result['rs']->fetch()) {

            $list[$row['id']] = $row;

            $detail = $this->getExtensionTimeConditionDetail($row['id']);

            while ($rowDetail = $detail['rs']->fetch()) {

                $list[$row['id']]['detail'][$rowDetail['id']] = $rowDetail;
            }
        }

        if (count($list) > 0) {
            $count = $this->setFieldsExtensionTimeconditon($list, '', $count);
        }
        //  end extension timecondition


        $list = $this->getCompany($this->comp_id)['list'][$this->comp_id];

        $count = $this->setFieldsfeatureCodes($list, '', $count);

        $count = $this->setFieldsCallPickUp($list, '', $count);

        $count = $this->setFieldsEnableDnD($list, '', $count);

        $count = $this->setFieldsDisableDnD($list, '', $count);

        $count = $this->setFieldsWrongNumber($list, '', $count);

        $result = $this->getQueueByCompId();


        $list = array();
        while ($row = $result['rs']->fetch()) {
            $list[] = $row;
        }

        if (count($list) > 0) {
            $count = $this->setFieldsQueue($list, '', $count);
        }


        if (file_exists($this->fileName)) {
            unlink($this->fileName);
        }

        $handle = fopen($this->fileName, 'w');
        ob_start();

        foreach ($this->class_fields as $i => $class_fieldsVal) {
            foreach ($this->class_fields[$i] as $key => $config) {
                if (!isset($config['key']) and is_array($config)) {
                    foreach ($config as $arrkey => $arrConfig) {
                        echo $arrConfig['key'];
                        if (strlen($arrConfig['value'])) {
                            if (!isset($arrConfig['operator'])) {
                                $arrConfig['operator'] = ' = ';
                            }
                            echo $arrConfig['operator'] . $arrConfig['value'] . PHP_EOL;
                        } else {
                            echo PHP_EOL;
                        }
                    }
                } else {
                    echo $config['key'];
                    if (strlen($config['value'])) {
                        if (!isset($config['operator'])) {
                            $config['operator'] = ' = ';
                        }
                        echo $config['operator'] . $config['value'] . PHP_EOL;
                    } else {
                        echo PHP_EOL;
                    }
                }
            }
            echo PHP_EOL . ';-------------------------------';
            echo PHP_EOL . PHP_EOL;

        }

        $buffer = ob_get_contents();
        ob_end_clean();

        if ($this->debugMode == '1') {
            echo '<pre/>';
            echo $buffer;
        }

        fwrite($handle, $buffer);
        fwrite($handle, $buffer);
        $this->logAMIExtension('create extension', true);
        fclose($handle);
    }

    /**
     * @param $array_fields
     * @param $defaultConfig
     * @param $count
     * @return mixed
     */
    function setFieldsIvr($array_fields, $defaultConfig, $count)
    {
        //include(ROOT_DIR . "component/timeCondition/AdminNewNameExstionModel.php");


        $temp_count = 1;
        $newName = '';
        $SipTrunk = 1;

        foreach ($array_fields as $key => $fields) {

            if (strtolower($fields['ivr_menu_no']) == 'invalid') {
                $fields['ivr_menu_no'] = 'i';
            }

            if (strtolower($fields['ivr_menu_no']) == 'timeout') {
                $fields['ivr_menu_no'] = 't';
            }

            if ($newName != $fields['ivr_name']) {
                $count++;

                $newName = $fields['ivr_name'];
                $this->class_fields[$count]['context_ivr']['key'] = '[ivr-' . $fields['ivr_name'] . '-' . $fields['comp_name'] . ']';
                $this->class_fields[$count]['context_ivr']['value'] = '';

                $this->class_fields[$count]['exten-Answer' . $temp_count]['key'] = 'exten';
                $this->class_fields[$count]['exten-Answer' . $temp_count]['value'] = 's,1,Answer()';
                $this->class_fields[$count]['exten-Answer' . $temp_count]['operator'] = ' => ';

                $this->class_fields[$count]['exten-Wait' . $temp_count]['key'] = 'exten';
                $this->class_fields[$count]['exten-Wait' . $temp_count]['value'] = 's,n,Wait(1)';
                $this->class_fields[$count]['exten-Wait' . $temp_count]['operator'] = ' => ';

                /*$this->class_fields[$count]['exten-contextid' . $temp_count]['key'] = ';exten';
                $this->class_fields[$count]['exten-contextid' . $temp_count]['value'] = 's,n,Set(contextid=${CONTEXT})';
                $this->class_fields[$count]['exten-contextid' . $temp_count]['operator'] = ' => ';*/

                $conn = parent::getConnection();


                $this->class_fields[$count]['exten_Background' . $temp_count]['key'] = 'exten';
                $this->class_fields[$count]['exten_Background' . $temp_count]['value'] = 's,n,Background(' . UPLOAD_IVR_ROOT . $fields['comp_id'] . '/' . $fields['upload_id'] . ')';
                $this->class_fields[$count]['exten_Background' . $temp_count]['operator'] = ' => ';


                $this->class_fields[$count]['WaitExten' . $temp_count]['key'] = 'exten';
                $this->class_fields[$count]['WaitExten' . $temp_count]['value'] = 's,n,WaitExten(' . $fields['timeout'] . ')';
                $this->class_fields[$count]['WaitExten' . $temp_count]['operator'] = ' => ';

            }


            /*if ($fields['dst_option_id'] == 1) {
                $conn = parent::getConnection();

                $sql = "
                             SELECT
                              `tbl_sip`.* FROM `tbl_sip`
                             WHERE
                                `tbl_sip`.`sip_id` = '" . $fields['dst_option_sub_id'] . "' AND  `trash`='0' ";

                $stmt_sipTrunk = $conn->prepare($sql);
                $stmt_sipTrunk->setFetchMode(PDO::FETCH_ASSOC);
                $stmt_sipTrunk->execute();

                if (!$stmt_sipTrunk) {
                    $result['result'] = -1;
                    $result['no'] = 1;
                    $result['msg'] = $conn->errorInfo();
                    return $result;
                }

                $result['result'] = 1;
                $subRowSipTrunk = $stmt_sipTrunk->fetch();

                $this->class_fields[$count]['SipTrunk' . $temp_count]['key'] = 'exten';
                $this->class_fields[$count]['SipTrunk' . $temp_count]['value'] =
                    $fields['ivr_menu_no'] . ',1,Dial(SIP/@' . $subRowSipTrunk['sip_name'] . '-' . $fields['comp_name'] . ')';
                $this->class_fields[$count]['SipTrunk' . $temp_count]['operator'] = ' => ';

            } */
            if ($fields['dst_option_id'] == 2) {
                $conn = parent::getConnection();

                $sql = "
                             SELECT
                              `tbl_queue`.* FROM `tbl_queue`
                             WHERE
                                `tbl_queue`.`queue_id` = '" . $fields['dst_option_sub_id'] . "' AND  `trash`='0'";

                $stmt_queue = $conn->prepare($sql);
                $stmt_queue->setFetchMode(PDO::FETCH_ASSOC);
                $stmt_queue->execute();

                if (!$stmt_queue) {
                    $result['result'] = -1;
                    $result['no'] = 1;
                    $result['msg'] = $conn->errorInfo();
                    return $result;
                }

                $result['result'] = 1;
                $subRowSip = $stmt_queue->fetch();

                /*$this->class_fields[$count]['Queue' . $temp_count . '-Answer']['key'] = ';exten';
                $this->class_fields[$count]['Queue' . $temp_count . '-Answer']['value'] = $fields['ivr_menu_no'] . ',1,Answer()';
                $this->class_fields[$count]['Queue' . $temp_count . '-Answer']['operator'] = ' => ';

                if (isset($subRowSip['max_wait_time']) and $subRowSip['max_wait_time'] == '') {
                    $subRowSip['max_wait_time'] = 60;
                }

                if ($subRowSip['instead'] == '1') {
                    $instead = 'r';
                } else {
                    $instead = '';
                }

                $this->class_fields[$count]['Queue' . $temp_count]['key'] = ';exten';
                $this->class_fields[$count]['Queue' . $temp_count]['value'] =
                    $fields['ivr_menu_no'] . ',n,Queue(' . $subRowSip['queue_name'] . '-' . $fields['comp_name'] . ',' . $instead . ',,,' . $subRowSip['max_wait_time'] . ')';
                $this->class_fields[$count]['Queue' . $temp_count]['operator'] = ' => ';*/


                $this->class_fields[$count]['Queue2' . $temp_count]['key'] = 'exten';
                $this->class_fields[$count]['Queue2' . $temp_count]['value'] =
                    $fields['ivr_menu_no'] . ',1,Goto(queue-' . $fields['comp_name'] . ',' . $subRowSip['queue_ext_no'] . ',1' . ')';
                $this->class_fields[$count]['Queue2' . $temp_count]['operator'] = ' => ';


                //$result = $this->queueDstOption($subRowSip, $count, $temp_count, 'IVR', $fields);

            } elseif ($fields['dst_option_id'] == 3 and $fields['dst_option_sub_id'] != '0') {
                $conn = parent::getConnection();

                $sql = "
                              SELECT
                                `tbl_extension`.* FROM `tbl_extension`
                              WHERE
                                `tbl_extension`.`extension_id` = '" . $fields['dst_option_sub_id'] . "' AND  `trash`='0' ";

                $stmt_extension = $conn->prepare($sql);
                $stmt_extension->setFetchMode(PDO::FETCH_ASSOC);
                $stmt_extension->execute();

                if (!$stmt_extension) {
                    $result['result'] = -1;
                    $result['no'] = 1;
                    $result['msg'] = $conn->errorInfo();
                    return $result;
                }

                $result['result'] = 1;
                $subRowSip = $stmt_extension->fetch();

                if ($subRowSip['ring_number'] == '' or strlen($subRowSip['ring_number']) == 0) {

                    $subRowSip['ring_number'] = '30';
                }

                //$ring_time = ONE_RING_TIME * $subRowSip['ring_number'];


                //*************DNA****************Start
                //Commented by DNA
                /*$this->class_fields[$count]['extension_t' . $temp_count]['key'] = 'exten';
                $this->class_fields[$count]['extension_t' . $temp_count]['value'] =
                    $fields['ivr_menu_no'] . ',1,Dial(SIP/' . $subRowSip['extension_no'] . '-' . $fields['comp_name'] . ',' . $ring_time . ')';
                $this->class_fields[$count]['extension_t' . $temp_count]['operator'] = ' => ';*/


                //Added By DNA
                $this->class_fields[$count]['extension_t' . $temp_count]['key'] = 'exten';
                $this->class_fields[$count]['extension_t' . $temp_count]['value'] =
                    $fields['ivr_menu_no'] . ',1,Goto(internaldial-' . $fields['comp_name'] . ',' . $subRowSip['extension_no'] . ',1)';
                $this->class_fields[$count]['extension_t' . $temp_count]['operator'] = ' => ';


                //Commented by DNA
                /*if ($subRowSip['voicemail_status'] == '1') {

                    $this->class_fields[$count]['DIALSTATUS' . $temp_count]['key'] = 'exten';
                    $this->class_fields[$count]['DIALSTATUS' . $temp_count]['value'] = $fields['ivr_menu_no'] . ',n,Gotoif($[${DIALSTATUS}=CHANUNAVAIL | BUSY | NOANSWER]?next:hangup)';
                    $this->class_fields[$count]['DIALSTATUS' . $temp_count]['operator'] = ' => ';

                    $this->class_fields[$count]['VoiceMail' . $temp_count]['key'] = 'exten';
                    $this->class_fields[$count]['VoiceMail' . $temp_count]['value'] = $fields['ivr_menu_no'] . ',n(next),VoiceMail(' . $subRowSip['extension_no'] . '@voiceMail-' . $fields['comp_name'] . ')';
                    $this->class_fields[$count]['VoiceMail' . $temp_count]['operator'] = ' => ';
                    //[record-internaldial
                    $this->class_fields[$count]['VoiceMail_exten' . $temp_count]['key'] = 'exten';
                    $this->class_fields[$count]['VoiceMail_exten' . $temp_count]['value'] = $fields['ivr_menu_no'] . ',n,Set(voicemailfile=${VM_MESSAGEFILE})';
                    $this->class_fields[$count]['VoiceMail_exten' . $temp_count]['operator'] = ' => ';

                    $this->class_fields[$count]['VoiceMail_exten1' . $temp_count]['key'] = 'exten';
                    $this->class_fields[$count]['VoiceMail_exten1' . $temp_count]['value'] = $fields['ivr_menu_no'] . ',n,System(cp ${voicemailfile}.wav /' . VOICEMAIL_PATH . '${UNIQUEID}.wav)';
                    $this->class_fields[$count]['VoiceMail_exten1' . $temp_count]['operator'] = ' => ';

                }

                $this->class_fields[$count]['ivr' . $temp_count]['key'] = 'exten';
                $this->class_fields[$count]['ivr' . $temp_count]['value'] = $fields['ivr_menu_no'] . ',n(hangup),Hangup()';
                $this->class_fields[$count]['ivr' . $temp_count]['operator'] = ' => ';*/

                //*************DNA****************END

            } elseif ($fields['dst_option_id'] == 4 and $fields['dst_option_sub_id'] != '0') {
                $conn = parent::getConnection();

                $sql = "
                              SELECT
                                `tbl_announce`.* FROM `tbl_announce`
                              WHERE
                                `tbl_announce`.`announce_id` = '" . $fields['dst_option_sub_id'] . "' AND  `trash`='0' ";

                $stmt_announce = $conn->prepare($sql);
                $stmt_announce->setFetchMode(PDO::FETCH_ASSOC);
                $stmt_announce->execute();

                if (!$stmt_announce) {
                    $result['result'] = -1;
                    $result['no'] = 1;
                    $result['msg'] = $conn->errorInfo();
                    return $result;
                }

                $result['result'] = 1;
                $subRowAnnounce = $stmt_announce->fetch();

                if ($subRowAnnounce['announce_name'] != '') {
                    $this->class_fields[$count]['extension_t' . $temp_count]['key'] = 'exten';
                    $this->class_fields[$count]['extension_t' . $temp_count]['value'] =
                        $fields['ivr_menu_no'] . ',1,Goto(announce-' . $subRowAnnounce['announce_name'] . '-' . $fields['comp_name'] . ',s,1)';
                    $this->class_fields[$count]['extension_t' . $temp_count]['operator'] = ' => ';
                }


            } else if ($fields['dst_option_id'] == 5) {
                $conn = parent::getConnection();

                $sql = "
                    SELECT
                    *
                    FROM
                      `tbl_ivr`
                    WHERE
                      `tbl_ivr`.`ivr_id` ='" . $fields['dst_option_sub_id'] . "' AND  `trash`='0' ";

                $stmt_ivr = $conn->prepare($sql);
                $stmt_ivr->setFetchMode(PDO::FETCH_ASSOC);
                $stmt_ivr->execute();

                if (!$stmt_ivr) {
                    $result['result'] = -1;
                    $result['no'] = 1;
                    $result['msg'] = $conn->errorInfo();
                    return $result;
                }

                $result['result'] = 1;
                $subRowIvr = $stmt_ivr->fetch();

                $this->class_fields[$count]['ivr' . $temp_count]['key'] = 'exten';
                $this->class_fields[$count]['ivr' . $temp_count]['value'] =
                    $fields['ivr_menu_no'] . ',1,Goto(ivr-' . $subRowIvr['ivr_name'] . '-' . $fields['comp_name'] . ',s,1)';
                $this->class_fields[$count]['ivr' . $temp_count]['operator'] = ' => ';


            } elseif ($fields['dst_option_id'] == 6) {

                $conn = parent::getConnection();

                $sql = "
                              SELECT
                                `tbl_extension`.* FROM `tbl_extension`
                              WHERE
                                `tbl_extension`.`extension_id` = '" . $fields['dst_option_sub_id'] . "' AND  `trash`='0' ";

                $stmt_extension = $conn->prepare($sql);
                $stmt_extension->setFetchMode(PDO::FETCH_ASSOC);
                $stmt_extension->execute();

                if (!$stmt_extension) {
                    $result['result'] = -1;
                    $result['no'] = 1;
                    $result['msg'] = $conn->errorInfo();
                    return $result;
                }

                $result['result'] = 1;
                $subRowSip = $stmt_extension->fetch();

                if ($subRowSip['extension_no'] != '') {

                    //*************DNA****************Start
                    //Commented by DNA
                    /*$this->class_fields[$count]['VoiceMail' . $temp_count]['key'] = 'exten';
                    $this->class_fields[$count]['VoiceMail' . $temp_count]['value'] =
                        $fields['ivr_menu_no'] . ',1,VoiceMail(' . $subRowSip['extension_no'] . '@voiceMail-' . $fields['comp_name'] . ')';
                    $this->class_fields[$count]['VoiceMail' . $temp_count]['operator'] = ' => ';

                    $this->class_fields[$count]['VoiceMail_exten' . $temp_count]['key'] = 'exten';
                    $this->class_fields[$count]['VoiceMail_exten' . $temp_count]['value'] = $fields['ivr_menu_no'] . ',n,Set(voicemailfile=${VM_MESSAGEFILE})';
                    $this->class_fields[$count]['VoiceMail_exten' . $temp_count]['operator'] = ' => ';

                    $this->class_fields[$count]['VoiceMail_exten1' . $temp_count]['key'] = 'exten';
                    $this->class_fields[$count]['VoiceMail_exten1' . $temp_count]['value'] = $fields['ivr_menu_no'] . ',n,System(cp ${voicemailfile}.wav /' . VOICEMAIL_PATH . '${UNIQUEID}.wav)';
                    $this->class_fields[$count]['VoiceMail_exten1' . $temp_count]['operator'] = ' => ';

                    $this->class_fields[$count]['VoiceMail_exten2' . $temp_count]['key'] = 'exten';
                    $this->class_fields[$count]['VoiceMail_exten2' . $temp_count]['value'] = $fields['ivr_menu_no'] . ',n,Hangup()';
                    $this->class_fields[$count]['VoiceMail_exten2' . $temp_count]['operator'] = ' => ';*/

                    //Added by DNA
                    $this->class_fields[$count]['Goto' . $temp_count]['key'] = 'exten';
                    $this->class_fields[$count]['Goto' . $temp_count]['value'] =
                        $fields['ivr_menu_no'] . ',1,Macro(VoicemailPlay-' . $fields['comp_name'] . ',noMSG,' . $subRowSip['extension_no'] . ')';
                    $this->class_fields[$count]['Goto' . $temp_count]['operator'] = ' => ';

                    //*************DNA****************End

                }


            } elseif ($fields['dst_option_id'] == 7) {

                $this->class_fields[$count]['Hangup' . $temp_count]['key'] = 'exten';
                $this->class_fields[$count]['Hangup' . $temp_count]['value'] = $fields['ivr_menu_no'] . ',1,Hangup()';
                $this->class_fields[$count]['Hangup' . $temp_count]['operator'] = ' => ';

            } elseif ($fields['dst_option_id'] == 8) {
                $conn = parent::getConnection();


                $sql = "
                        SELECT
                            `main_time_condition`.`name`
                        FROM `main_time_condition`
                        WHERE `main_time_condition`.`id` = '" . $fields['dst_option_sub_id'] . "' ";


                $stmt_extension = $conn->prepare($sql);
                $stmt_extension->setFetchMode(PDO::FETCH_ASSOC);
                $stmt_extension->execute();

                if (!$stmt_extension) {
                    $result['result'] = -1;
                    $result['no'] = 1;
                    $result['msg'] = $conn->errorInfo();
                    return $result;
                }

                $result['result'] = 1;
                $subRowSip = $stmt_extension->fetch();

                $this->class_fields[$count]['timecondition' . $temp_count]['key'] = 'exten';
                $this->class_fields[$count]['timecondition' . $temp_count]['value'] = $fields['ivr_menu_no'] . ',1,Goto(timeCondition-' . $subRowSip['name'] . '-' . $fields['comp_name'] . ',s,1)';
                $this->class_fields[$count]['timecondition' . $temp_count]['operator'] = ' => ';


            } elseif ($fields['dst_option_id'] == 9) {


                if ($fields['dst_option_sub_id'] == '1') {

                    $forwardResult = $this->getExtensionById($fields['DSTOption']);
                    $forwardRow = $forwardResult['rs']->fetch();

                    $this->class_fields[$count]['ForwardI' . $temp_count]['key'] = 'exten';
                    $this->class_fields[$count]['ForwardI' . $temp_count]['value'] = $fields['ivr_menu_no'] . ',1,Goto(internaldial-' . $fields['comp_name'] . ',' . $forwardRow['extension_no'] . ',1)';
                    $this->class_fields[$count]['ForwardI' . $temp_count]['operator'] = ' => ';

                } else if ($fields['dst_option_sub_id'] == '2') {


                    $this->class_fields[$count]['ForwardE' . $temp_count]['key'] = 'exten';
                    $this->class_fields[$count]['ForwardE' . $temp_count]['value'] = $fields['ivr_menu_no'] . ',1,Goto(outpattern-' . $fields['comp_name'] . ',' . $this->getFristOutboundPrefix() . $fields['DSTOption'] . ',1)';
                    $this->class_fields[$count]['ForwardE' . $temp_count]['operator'] = ' => ';

                } else {

                    die("Destination of IVR has error");

                }

            } elseif ($fields['dst_option_id'] == 10) {

                die("Check dial destination id of fax");
                $this->class_fields[$count]['email' . $temp_count]['key'] = 'exten';
                $this->class_fields[$count]['email' . $temp_count]['value'] = $fields['ivr_menu_no'] . ',1,Set(email=' . $fields['dst_option_sub_id'] . ')';
                $this->class_fields[$count]['email' . $temp_count]['operator'] = ' => ';
                $this->class_fields[$count]['FAX-recive' . $temp_count]['key'] = 'exten';
                $this->class_fields[$count]['FAX-recive' . $temp_count]['value'] = $fields['ivr_menu_no'] . ',n,Goto(FAX-recive-' . $fields['comp_name'] . ',s,1)';
                $this->class_fields[$count]['FAX-recive' . $temp_count]['operator'] = ' => ';

            } else {

                die("Destination of IVR has error");

            }


            if ($array_fields[$key + 1]['ivr_name'] != $fields['ivr_name']) {
                if ($fields['direct_dial'] == 1) {

                    $this->class_fields[$count]['exten_direct_dial' . $temp_count]['key'] = 'include';
                    $this->class_fields[$count]['exten_direct_dial' . $temp_count]['value'] = 'directdial-' . $fields['comp_name'];
                    $this->class_fields[$count]['exten_direct_dial' . $temp_count]['operator'] = ' => ';


                    $this->class_fields[$count]['custome' . $temp_count]['key'] = 'include';
                    $this->class_fields[$count]['custome' . $temp_count]['value'] = 'ivr-' . $fields['ivr_name'] . '-' . $fields['comp_name'] . '-custome';
                    $this->class_fields[$count]['custome' . $temp_count]['operator'] = ' => ';


                    /*$this->class_fields[$count]['exten_direct_dial' . $temp_count]['key'] = 'exten';
                    $this->class_fields[$count]['exten_direct_dial' . $temp_count]['value'] = '_X.,1,Set(CALLERID(dnid)=${EXTEN})';
                    $this->class_fields[$count]['exten_direct_dial' . $temp_count]['operator'] = ' => ';
                    $this->class_fields[$count]['direct_dial' . $temp_count]['key'] = 'exten';
                    $this->class_fields[$count]['direct_dial' . $temp_count]['value'] = '_X.,2,Goto(Extension-DST-DirectDial-' . $fields['comp_name'] . ',${CALLERID(dnid)},1)';
                    $this->class_fields[$count]['direct_dial' . $temp_count]['operator'] = ' => ';*/

                }
            }

            $temp_count++;
        }


        return $count;
    }

    /**
     * @param $array_fields
     * @param $defaultConfig
     * @param $count
     * @return mixed
     */

    //DNA:????
    function setFieldsInboundAddPattern($array_fields, $defaultConfig, $count)
    {
        $result['result'] = 1;
        $result['no'] = 2;
        return $result;

        $this->class_fields[$count]['context_ivr']['key'] =
            '[inbound-' . $fields['inbound_name'] . '-' . $fields['comp_name'] . ']';
        $this->class_fields[$count]['context_ivr']['value'] = '';
    }

    function setFieldsTrunk($array_fields, $defaultConfig, $count)
    {

        $count++;

        $comp_name = $array_fields['comp_name'];

        $this->class_fields[$count]['trunk']['key'] = '[trunk-' . $comp_name . ']';
        $this->class_fields[$count]['trunk']['value'] = '';

        $this->class_fields[$count]['inbound']['key'] = 'include';
        $this->class_fields[$count]['inbound']['value'] = 'inbound-' . $comp_name;
        $this->class_fields[$count]['inbound']['operator'] = ' => ';

        $this->class_fields[$count]['internaldial']['key'] = 'include';
        $this->class_fields[$count]['internaldial']['value'] = 'internaldial-' . $comp_name;
        $this->class_fields[$count]['internaldial']['operator'] = ' => ';

        $this->class_fields[$count]['allDID']['key'] = 'include';
        $this->class_fields[$count]['allDID']['value'] = 'allDID-' . $comp_name;
        $this->class_fields[$count]['allDID']['operator'] = ' => ';

        $this->class_fields[$count]['allDID']['key'] = 'include';
        $this->class_fields[$count]['allDID']['value'] = 'allDID-' . $comp_name;
        $this->class_fields[$count]['allDID']['operator'] = ' => ';


        $this->class_fields[$count]['custome']['key'] = 'include';
        $this->class_fields[$count]['custome']['value'] = 'trunk-' . $comp_name . '-custome';
        $this->class_fields[$count]['custome']['operator'] = ' => ';


        return $count;
    }

    public function getConfranceList()
    {
        $this->comp_id;
        include_once ROOT_DIR . 'component/conference/model/ConferenceModel.php';
        return ConferenceModel::getAll()
            ->where('`conference`.`comp_id`', '=', $this->comp_id)
            ->getList();

    }

    function setFieldsConfBridge($array_fields, $defaultConfig, $count)
    {
        $array_fields = $array_fields['list'][$this->comp_id];


        include_once ROOT_DIR . 'component/conference/model/ConferenceModel.php';

        $confList = ConferenceModel::getAll()
            ->where('`conference`.`comp_id`', '=', $array_fields['comp_id'])
            ->keyBy('conf_number')
            ->getList()['export']['list'];

        $confListExtension = ConferenceModel::getAll()
            ->select('`conference`.`conf_number`,
              `conference`.`comp_id`,
              `conference`.`conf_name`,
              `conference_pivote`.`number_id`,
              `conference_pivote`.`number_type`,
              `tbl_extension`.`extension_no`,
              `tbl_extension`.`extension_name`')
            ->leftJoin('conference_pivote', '`conference`.`conf_id`', '=', ' `conference_pivote`.`conf_id`')
            ->leftJoin('tbl_extension', '`conference_pivote`.`number_id`', '=', '`tbl_extension`.`extension_id`')
            ->where('`conference`.`comp_id`', '=', $array_fields['comp_id'])
            ->where('`conference_pivote`.`number_type`', '=', '1')
            ->keyBy('conf_number', 0)
            ->getList()['export']['list'];


        $confListNumber = ConferenceModel::getAll()
            ->select('`conference`.`conf_number`,
              `conference`.`comp_id`,
              `conference`.`conf_name`,
              `conference_pivote`.`number_id`,
              `conference_pivote`.`number_type`,
              `phone`.`phone_id`,
              `phone`.`phone_number`')
            ->rightJoin('conference_pivote', '`conference`.`conf_id`', '=', ' `conference_pivote`.`conf_id`')
            ->rightJoin('phone', '`conference_pivote`.`number_id`', '=', '`phone`.`phone_id`')
            ->where('`conference`.`comp_id`', '=', $array_fields['comp_id'])
            ->where('`conference_pivote`.`number_type`', '=', '2')
            ->keyBy('conf_number', 0)
            ->getList()['export']['list'];
        //dd($confList);

        $confListNumberAll = ConferenceModel::getAll()
            ->select('`conference`.`conf_number`,
              `conference`.`comp_id`,
              `conference`.`conf_name`,
              `conference_pivote`.`number_id`,
              `conference_pivote`.`number_type`,
              `tbl_extension`.`extension_no`,
              `tbl_extension`.`extension_name`')
            ->leftJoin('conference_pivote', '`conference`.`conf_id`', '=', ' `conference_pivote`.`conf_id`')
            ->leftJoin('tbl_extension', '`conference_pivote`.`number_id`', '=', '`tbl_extension`.`extension_id`')
            ->where('`conference`.`comp_id`', '=', $array_fields['comp_id'])
            ->where('`conference_pivote`.`number_type`', '=', '3')
            ->keyBy('conf_number', 0)
            ->getList()['export']['list'];
        $count++;
        $password = $array_fields['password'];
        $comp_name = $array_fields['comp_name'];
        $this->class_fields[$count]['Confbridge']['key'] = '[Confbridge-' . $comp_name . ']';
        $this->class_fields[$count]['Confbridge']['value'] = '';


        //dd($confList);

        foreach ($confList as $confNumber => $conf) {
            /*print_r_debug($conf['password']);*/

            $this->class_fields[$count]['noop']['key'] = 'exten';
            $this->class_fields[$count]['noop']['value'] = $confNumber . ',1,NoOp()';
            $this->class_fields[$count]['noop']['operator'] = ' => ';
            if($conf['password']!=''){
                $this->class_fields[$count]['Authenticate']['key'] = 'exten';
                $this->class_fields[$count]['Authenticate']['value'] = $confNumber .',n,Authenticate('.$conf['password'].')';
                $this->class_fields[$count]['Authenticate']['operator'] = ' => ';
            }




            if (!isset($confListNumberAll[$confNumber])) {


                foreach ($confListExtension[$confNumber] as $key => $fields) {
                    if($fields['extension_no']!=''){
                        $this->class_fields[$count]['a' . $key]['key'] = 'exten';
                        $this->class_fields[$count]['a' . $key]['value'] = $confNumber . ',n,Gotoif($["${CALLERID(num)}"="' . $fields['extension_no'] . '"]?conf)';
                        $this->class_fields[$count]['a' . $key]['operator'] = ' => ';
                    }

                }

                foreach ($confListNumber[$confNumber] as $key => $fields) {
                    if($fields['phone_number']!=''){
                        $this->class_fields[$count]['b' . $key]['key'] = 'exten';
                        $this->class_fields[$count]['b' . $key]['value'] = $confNumber . ',n,Gotoif($["${CALLERID(num)}"="' . $fields['phone_number'] . '"]?conf)';
                        $this->class_fields[$count]['b' . $key]['operator'] = ' => ';
                    }
                }

                $this->class_fields[$count]['2']['key'] = 'exten';
                $this->class_fields[$count]['2']['value'] = $confNumber . ',n,Playback(accesse-denie)';
                $this->class_fields[$count]['2']['operator'] = ' => ';

                $this->class_fields[$count]['3']['key'] = 'exten';
                $this->class_fields[$count]['3']['value'] = $confNumber . ',n,Hangup()';
                $this->class_fields[$count]['3']['operator'] = ' => ';



            }


            $this->class_fields[$count]['4']['key'] = 'exten';
            $this->class_fields[$count]['4']['value'] = $confNumber . ',n(conf),Gosub(conf-' . $comp_name . ',${EXTEN})';
            $this->class_fields[$count]['4']['operator'] = ' => ';

            $count++;
        }
        /*$comp_name = $array_fields['comp_name'];
        $this->class_fields[$count]['Confbridge']['key'] = '[Confbridge-' . $comp_name . ']';
        $this->class_fields[$count]['Confbridge']['value'] = '';*/
        /*foreach ($confListNumberAll as $confNumber => $confList) {

            $this->class_fields[$count]['noop']['key'] = 'exten';
            $this->class_fields[$count]['noop']['value'] = $confNumber.',1,NoOP()';
            $this->class_fields[$count]['noop']['operator'] = ' => ';

            $this->class_fields[$count]['5']['key'] = 'exten';
            $this->class_fields[$count]['5']['value'] = $confNumber . ',n(conf),Macro(conf-'.$comp_name.',${EXTEN})';
            $this->class_fields[$count]['5']['operator'] = ' => ';
            $count++;
        }*/

        $this->class_fields[$count - 1]['6']['key'] = 'include';
        $this->class_fields[$count - 1]['6']['value'] = 'Confbridge-' . $comp_name . '-custome';
        $this->class_fields[$count - 1]['6']['operator'] = ' => ';

        $count++;
        $this->class_fields[$count]['macro']['key'] = '[conf-' . $comp_name . ']';
        $this->class_fields[$count]['macro']['value'] = '';

        $this->class_fields[$count]['noop']['key'] = 'exten';
        $this->class_fields[$count]['noop']['value'] = 's,1,NoOp()';
        $this->class_fields[$count]['noop']['operator'] = ' => ';

        $this->class_fields[$count]['same1']['key'] = 'same';
        $this->class_fields[$count]['same1']['value'] = 'n,SET(CONFBRIDGE(bridge,record_conference)=yes)';
        $this->class_fields[$count]['same1']['operator'] = ' => ';

        $this->class_fields[$count]['mkdir']['key'] = 'same';
        $this->class_fields[$count]['mkdir']['value'] = 'n,system(mkdir -p ' . RECORD_PATH . $comp_name . DS . 'monitor' . DS . 'conf' . DS . ')';
        $this->class_fields[$count]['mkdir']['operator'] = ' => ';


        $this->class_fields[$count]['same2']['key'] = 'same';
        $this->class_fields[$count]['same2']['value'] = 'n,SET(CONFBRIDGE(bridge,record_file)=' . RECORD_PATH . $comp_name . DS . 'monitor' . DS . 'conf' . DS . 'Conf-${EXTEN}-${STRFTIME(${EPOCH},,%Y%m%d-%H%M%S)}-${UNIQUEID}.wav)';
        $this->class_fields[$count]['same2']['operator'] = ' => ';

        $this->class_fields[$count]['same3']['key'] = 'same';
        $this->class_fields[$count]['same3']['value'] = 'n,Confbridge(${ARG1})';
        $this->class_fields[$count]['same3']['operator'] = ' => ';

        $this->class_fields[$count]['same4']['key'] = 'same';
        $this->class_fields[$count]['same4']['value'] = 'n,Hangup()';
        $this->class_fields[$count]['same4']['operator'] = ' => ';

        /*$this->class_fields[$count]['internaldial']['key'] = 'exten';
        $this->class_fields[$count]['internaldial']['value'] = 's,1,NoOp()';
        $this->class_fields[$count]['internaldial']['operator'] = ' => ';*/

        return $count;
    }

    function setFieldsallDID($array_fields, $defaultConfig, $count)
    {

        $count++;
        $comp_name = $array_fields[0]['comp_name'];

        $this->class_fields[$count]['allDID']['key'] = '[allDID-' . $comp_name . ']';
        $this->class_fields[$count]['allDID']['value'] = '';

        $this->class_fields[$count]['Goto']['key'] = 'exten';
        $this->class_fields[$count]['Goto']['value'] = '_X.,1,Goto(s,1)';
        $this->class_fields[$count]['Goto']['operator'] = ' => ';

        foreach ($array_fields as $key => $fields) {

            if ($fields['did_name'] == '' and $fields['cid_name'] == '') {

                $anylag = True;
            }
        }
        if ($anylag) {

            $this->class_fields[$count]['inbound']['key'] = 'exten';
            $this->class_fields[$count]['inbound']['value'] = 's,1,Goto(inbound-' . $fields['comp_name'] . ',s,1)';
            $this->class_fields[$count]['inbound']['operator'] = ' => ';

        } else {

            $this->class_fields[$count]['Answer']['key'] = 'exten';
            $this->class_fields[$count]['Answer']['value'] = 's,1,Answer()';
            $this->class_fields[$count]['Answer']['operator'] = ' => ';

            $this->class_fields[$count]['wait']['key'] = 'exten';
            $this->class_fields[$count]['wait']['value'] = 's,n,wait(2)';
            $this->class_fields[$count]['wait']['operator'] = ' => ';

            $this->class_fields[$count]['playback']['key'] = 'exten';
            $this->class_fields[$count]['playback']['value'] = 's,n,playback(ss-noservice)';
            $this->class_fields[$count]['playback']['operator'] = ' => ';

            $this->class_fields[$count]['hangup']['key'] = 'exten';
            $this->class_fields[$count]['hangup']['value'] = 's,n,hangup()';
            $this->class_fields[$count]['hangup']['operator'] = ' => ';

        }


        /*$this->class_fields[$count]['internaldial']['key'] = 'exten';
        $this->class_fields[$count]['internaldial']['value'] = 's,1,NoOp()';
        $this->class_fields[$count]['internaldial']['operator'] = ' => ';*/

        return $count;
    }


    function setFieldsPlayVocieMail($array_fields, $defaultConfig, $count)
    {
        $count++;
        $comp_name = $array_fields['comp_name'];

        $this->class_fields[$count]['VoicemailPlay']['key'] = '[VoicemailPlay-' . $comp_name . ']';
        $this->class_fields[$count]['VoicemailPlay']['value'] = '';

        $this->class_fields[$count]['VoiceMail_s']['key'] = 'exten';
        $this->class_fields[$count]['VoiceMail_s']['value'] = 's,1,Goto(${ARG1},1)';
        $this->class_fields[$count]['VoiceMail_s']['operator'] = ' => ';

        $this->class_fields[$count]['VoiceMail_b1']['key'] = ';exten';
        $this->class_fields[$count]['VoiceMail_b1']['value'] = 'busy,1,MailboxExists(${ARG2}@voiceMail-' . $comp_name . ')';
        $this->class_fields[$count]['VoiceMail_b1']['operator'] = ' => ';

        $this->class_fields[$count]['VoiceMail_b22']['key'] = ';exten';
        $this->class_fields[$count]['VoiceMail_b22']['value'] = 'busy,1,GotoIf($["${VMBOXEXISTSSTATUS}" != "SUCCESS"]?d,hangup)';
        $this->class_fields[$count]['VoiceMail_b22']['operator'] = ' => ';

        $this->class_fields[$count]['VoiceMail_b2']['key'] = 'exten';
        $this->class_fields[$count]['VoiceMail_b2']['value'] = 'busy,1,GotoIf($["${VM_INFO(${ARG2}@voiceMail-' . $comp_name . ',exists)}" != "1"]?d,1)';
        $this->class_fields[$count]['VoiceMail_b2']['operator'] = ' => ';

        $this->class_fields[$count]['VoiceMail_b3']['key'] = 'exten';
        $this->class_fields[$count]['VoiceMail_b3']['value'] = 'busy,n,VoiceMail(${ARG2}@voiceMail-' . $comp_name . ',b)';
        $this->class_fields[$count]['VoiceMail_b3']['operator'] = ' => ';

        $this->class_fields[$count]['VoiceMail_b4']['key'] = 'exten';
        $this->class_fields[$count]['VoiceMail_b4']['value'] = 'busy,n,Goto(d,hangup)';
        $this->class_fields[$count]['VoiceMail_b4']['operator'] = ' => ';


        $this->class_fields[$count]['VoiceMail_u1']['key'] = ';exten';
        $this->class_fields[$count]['VoiceMail_u1']['value'] = 'unavail,1,MailboxExists(${ARG2}@voiceMail-' . $comp_name . ')';
        $this->class_fields[$count]['VoiceMail_u1']['operator'] = ' => ';

        $this->class_fields[$count]['VoiceMail_u2']['key'] = 'exten';
        $this->class_fields[$count]['VoiceMail_u2']['value'] = 'unavail,1,GotoIf($["${VM_INFO(${ARG2}@voiceMail-' . $comp_name . ',exists)}" != "1"]?d,1)';
        $this->class_fields[$count]['VoiceMail_u2']['operator'] = ' => ';

        $this->class_fields[$count]['VoiceMail_u3']['key'] = 'exten';
        $this->class_fields[$count]['VoiceMail_u3']['value'] = 'unavail,n,VoiceMail(${ARG2}@voiceMail-' . $comp_name . ',u)';
        $this->class_fields[$count]['VoiceMail_u3']['operator'] = ' => ';

        $this->class_fields[$count]['VoiceMail_u4']['key'] = 'exten';
        $this->class_fields[$count]['VoiceMail_u4']['value'] = 'unavail,n,Goto(d,hangup)';
        $this->class_fields[$count]['VoiceMail_u4']['operator'] = ' => ';

        $this->class_fields[$count]['VoiceMail_n1']['key'] = ';exten';
        $this->class_fields[$count]['VoiceMail_n1']['value'] = 'noMSG,1,MailboxExists(${ARG2}@voiceMail-' . $comp_name . ')';
        $this->class_fields[$count]['VoiceMail_n1']['operator'] = ' => ';

        $this->class_fields[$count]['VoiceMail_n2']['key'] = 'exten';
        $this->class_fields[$count]['VoiceMail_n2']['value'] = 'noMSG,1,GotoIf($["${VM_INFO(${ARG2}@voiceMail-' . $comp_name . ',exists)}" != "1"]?d,1)';
        $this->class_fields[$count]['VoiceMail_n2']['operator'] = ' => ';

        $this->class_fields[$count]['VoiceMail_n3']['key'] = 'exten';
        $this->class_fields[$count]['VoiceMail_n3']['value'] = 'noMSG,n,VoiceMail(${ARG2}@voiceMail-' . $comp_name . ')';
        $this->class_fields[$count]['VoiceMail_n3']['operator'] = ' => ';

        $this->class_fields[$count]['VoiceMail_n4']['key'] = 'exten';
        $this->class_fields[$count]['VoiceMail_n4']['value'] = 'noMSG,n,Goto(d,hangup)';
        $this->class_fields[$count]['VoiceMail_n4']['operator'] = ' => ';


        $this->class_fields[$count]['VoiceMail_exten']['key'] = ';exten';
        $this->class_fields[$count]['VoiceMail_exten']['value'] = 'd,1,Set(voicemailfile=${VM_MESSAGEFILE})';
        $this->class_fields[$count]['VoiceMail_exten']['operator'] = ' => ';

        $this->class_fields[$count]['VoiceMail_exten1']['key'] = ';exten';
        $this->class_fields[$count]['VoiceMail_exten1']['value'] = 'd,n,System(cp ${voicemailfile}.wav ' . VOICEMAIL_PATH . '${UNIQUEID}.wav)';
        $this->class_fields[$count]['VoiceMail_exten1']['operator'] = ' => ';

        $this->class_fields[$count]['VoiceMail_exten2']['key'] = 'exten';
        $this->class_fields[$count]['VoiceMail_exten2']['value'] = 'd,1,Playback(im-sorry&an-error-has-occured)';
        $this->class_fields[$count]['VoiceMail_exten2']['operator'] = ' => ';

        $this->class_fields[$count]['VoiceMail_exten3']['key'] = 'exten';
        $this->class_fields[$count]['VoiceMail_exten3']['value'] = 'd,n,Congestion(2)';
        $this->class_fields[$count]['VoiceMail_exten3']['operator'] = ' => ';

        $this->class_fields[$count]['VoiceMail_exten4']['key'] = 'exten';
        $this->class_fields[$count]['VoiceMail_exten4']['value'] = 'd,n(hangup),Hangup()';
        $this->class_fields[$count]['VoiceMail_exten4']['operator'] = ' => ';


        return $count++;
    }

    /**
     * @param $array_fields
     * @param $defaultConfig
     * @param $count
     * @return mixed
     */
    function setFieldsVoicemailMain($array_fields, $defaultConfig, $count)
    {
        $count++;
        $comp_name = $array_fields['comp_name'];

        $this->class_fields[$count]['VoicemailMain']['key'] = '[VoicemailMain-' . $comp_name . ']';
        $this->class_fields[$count]['VoicemailMain']['value'] = '';

        $this->class_fields[$count]['VoicemailMain_exten1']['key'] = 'exten';
        $this->class_fields[$count]['VoicemailMain_exten1']['value'] = '*98,1,VoicemailMain(@voiceMail-' . $comp_name . ')';
        $this->class_fields[$count]['VoicemailMain_exten1']['operator'] = ' => ';

        $this->class_fields[$count]['VoicemailMain_exten2']['key'] = 'exten';
        $this->class_fields[$count]['VoicemailMain_exten2']['value'] = '*98,2,Hangup()';
        $this->class_fields[$count]['VoicemailMain_exten2']['operator'] = ' => ';
        return $count;
    }

    function setFieldsEnableDnD($array_fields, $defaultConfig, $count)
    {

        $count++;
        $this->class_fields[$count]['context_company']['key'] = '[enable-DnD-' . $array_fields['comp_name'] . ']';
        $this->class_fields[$count]['context_company']['value'] = '';

        $this->class_fields[$count]['enable1']['key'] = 'exten';
        $this->class_fields[$count]['enable1']['value'] = '*78,1,Answer';
        $this->class_fields[$count]['enable1']['operator'] = ' => ';

        $this->class_fields[$count]['enable2']['key'] = 'exten';
        $this->class_fields[$count]['enable2']['value'] = '*78,n,Set(DB(Ext/${CALLERID(num)}-' . $array_fields['comp_name'] . '/DND)=1)';
        $this->class_fields[$count]['enable2']['operator'] = ' => ';

        $this->class_fields[$count]['enable3']['key'] = 'exten';
        $this->class_fields[$count]['enable3']['value'] = '*78,n,Playback(do-not-disturb&activated)';
        $this->class_fields[$count]['enable3']['operator'] = ' => ';

        $this->class_fields[$count]['enable4']['key'] = 'exten';
        $this->class_fields[$count]['enable4']['value'] = '*78,n,Wait(2)';
        $this->class_fields[$count]['enable4']['operator'] = ' => ';

        $this->class_fields[$count]['enable5']['key'] = 'exten';
        $this->class_fields[$count]['enable5']['value'] = '*78,n,Hangup()';
        $this->class_fields[$count]['enable5']['operator'] = ' => ';
        return $count;
    }

    function setFieldsDisableDnD($array_fields, $defaultConfig, $count)
    {

        $count++;
        $this->class_fields[$count]['context_company']['key'] = '[disable-DnD-' . $array_fields['comp_name'] . ']';
        $this->class_fields[$count]['context_company']['value'] = '';

        $this->class_fields[$count]['disable1']['key'] = 'exten';
        $this->class_fields[$count]['disable1']['value'] = '*79,1,Answer';
        $this->class_fields[$count]['disable1']['operator'] = ' => ';

        $this->class_fields[$count]['disable2']['key'] = 'exten';
        $this->class_fields[$count]['disable2']['value'] = '*79,n,Set(DB(Ext/${CALLERID(num)}-' . $array_fields['comp_name'] . '/DND)=0)';
        $this->class_fields[$count]['disable2']['operator'] = ' => ';

        $this->class_fields[$count]['disable3']['key'] = 'exten';
        $this->class_fields[$count]['disable3']['value'] = '*79,n,Playback(do-not-disturb&de-activated)';
        $this->class_fields[$count]['disable3']['operator'] = ' => ';

        $this->class_fields[$count]['disable4']['key'] = 'exten';
        $this->class_fields[$count]['disable4']['value'] = '*79,n,Wait(2)';
        $this->class_fields[$count]['disable4']['operator'] = ' => ';

        $this->class_fields[$count]['disable5']['key'] = 'exten';
        $this->class_fields[$count]['disable5']['value'] = '*79,n,Hangup()';
        $this->class_fields[$count]['disable5']['operator'] = ' => ';
        return $count;
    }


    function setFieldsfeatureCodes($array_fields, $defaultConfig, $count)
    {

        $count++;
        $this->class_fields[$count]['context_company']['key'] = '[feature-codes-' . $array_fields['comp_name'] . ']';
        $this->class_fields[$count]['context_company']['value'] = '';

        $this->class_fields[$count]['feature-codes-voicemail']['key'] = 'include';
        $this->class_fields[$count]['feature-codes-voicemail']['value'] = 'VoicemailMain-' . $array_fields['comp_name'];
        $this->class_fields[$count]['feature-codes-voicemail']['operator'] = ' => ';

        $this->class_fields[$count]['feature-codes-CallPickUp']['key'] = 'include';
        $this->class_fields[$count]['feature-codes-CallPickUp']['value'] = 'CallPickUp-' . $array_fields['comp_name'];
        $this->class_fields[$count]['feature-codes-CallPickUp']['operator'] = ' => ';

        $this->class_fields[$count]['feature-codes-enable-DnD']['key'] = 'include';
        $this->class_fields[$count]['feature-codes-enable-DnD']['value'] = 'enable-DnD-' . $array_fields['comp_name'];
        $this->class_fields[$count]['feature-codes-enable-DnD']['operator'] = ' => ';

        $this->class_fields[$count]['feature-codes-disable-DnD']['key'] = 'include';
        $this->class_fields[$count]['feature-codes-disable-DnD']['value'] = 'disable-DnD-' . $array_fields['comp_name'];
        $this->class_fields[$count]['feature-codes-disable-DnD']['operator'] = ' => ';


        $this->class_fields[$count]['custome']['key'] = 'include';
        $this->class_fields[$count]['custome']['value'] = 'feature-codes-' . $array_fields['comp_name'] . '-custome';
        $this->class_fields[$count]['custome']['operator'] = ' => ';


        return $count;
    }

    function setFieldsCallPickUp($array_fields, $defaultConfig, $count)
    {

        $count++;
        $this->class_fields[$count]['context_company']['key'] = '[CallPickUp-' . $array_fields['comp_name'] . ']';
        $this->class_fields[$count]['context_company']['value'] = '';

        $this->class_fields[$count]['cCallPickUp1']['key'] = 'exten';
        $this->class_fields[$count]['cCallPickUp1']['value'] = '_**.,1,Pickup(${EXTEN:2}-' . $array_fields['comp_name'] . '@PICKUPMARK)';
        $this->class_fields[$count]['cCallPickUp1']['operator'] = ' => ';

        $this->class_fields[$count]['cCallPickUp2']['key'] = 'exten';
        $this->class_fields[$count]['cCallPickUp2']['value'] = '_**.,n,Hangup()';
        $this->class_fields[$count]['cCallPickUp2']['operator'] = ' => ';

        return $count;
    }

    function setFieldsWrongNumber($array_fields, $defaultConfig, $count)
    {

        $count++;
        $this->class_fields[$count]['context_company']['key'] = '[wrongNumber-' . $array_fields['comp_name'] . ']';
        $this->class_fields[$count]['context_company']['value'] = '';

        $this->class_fields[$count]['Wait1']['key'] = 'exten';
        $this->class_fields[$count]['Wait1']['value'] = '_X.,1,Wait(1)';
        $this->class_fields[$count]['Wait1']['operator'] = ' => ';

        $this->class_fields[$count]['playback']['key'] = 'exten';
        $this->class_fields[$count]['playback']['value'] = '_X.,n,Playback(silence/2&you-dialed-wrong-number&check-number-dial-again)';
        $this->class_fields[$count]['playback']['operator'] = ' => ';

        $this->class_fields[$count]['Wait2']['key'] = 'exten';
        $this->class_fields[$count]['Wait2']['value'] = '_X.,n,Wait(1)';
        $this->class_fields[$count]['Wait2']['operator'] = ' => ';

        $this->class_fields[$count]['congestion']['key'] = 'exten';
        $this->class_fields[$count]['congestion']['value'] = '_X.,n,Congestion(20)';
        $this->class_fields[$count]['congestion']['operator'] = ' => ';

        $this->class_fields[$count]['Hangup']['key'] = 'exten';
        $this->class_fields[$count]['Hangup']['value'] = '_X.,n,Hangup()';
        $this->class_fields[$count]['Hangup']['operator'] = ' => ';

        return $count;
    }

    /**
     * @param $array_fields
     * @param $defaultConfig
     * @param $count
     * @return mixed
     */
    function setFieldsExtensionTimeconditon($array_fields, $defaultConfig, $count)
    {


        $daysName['0'] = 'sat';
        $daysName['1'] = 'sun';
        $daysName['2'] = 'mon';
        $daysName['3'] = 'tus';
        $daysName['4'] = 'wed';
        $daysName['5'] = 'thu';
        $daysName['6'] = 'fri';

        $monthName['0'] = 'jan';
        $monthName['1'] = 'feb';
        $monthName['2'] = 'mar';
        $monthName['3'] = 'apr';
        $monthName['4'] = 'may';
        $monthName['5'] = 'jun';
        $monthName['6'] = 'jul';
        $monthName['7'] = 'aug';
        $monthName['8'] = 'sep';
        $monthName['9'] = 'oct';
        $monthName['10'] = 'nov';
        $monthName['11'] = 'dec';


        /*[TimeCondition-$timename-$compname]
        exten => s,1,GotoIfTime(17:00-18:00,sat-wed,*,*?truestate)
        exten => s,1,GotoIfTime(17:00-18:00,sat-wed,roz az 0 ta 31 ,*?truestate)
        exten => s,n,GotoIfTime(17:00-18:30,thu,*,*?truestate)
        ;exten => s,n,Set(CALLERID(dnid)=110)
		exten => s,n(truestate),Goto(internaldial-dabapbx,110,1)
        exten => s,n(truestate),Playback(hello)*/

        //$count++;

        function concatInputExt($start, $end, $pattern = '')
        {

            if ($pattern != '') {
                $result = $pattern[$start] . '-' . $pattern[$end];
                if ($start == '' and $end == '') {
                    $result = '*';
                } else if ($start != '' and $end == '') {

                    $result = $pattern[$start] . '-' . $pattern[$start];
                } else if ($start == '' and $end != '') {

                    $result = $pattern[$end] . '-' . $pattern[$end];
                }
                return $result;

            }

            $result = $start . '-' . $end;

            if ($start == '' and $end == '') {
                $result = '*';
            } else if ($start != '' and $end == '') {

                $result = $start . '-' . $start;
            } else if ($start == '' and $end != '') {

                $result = $end . '-' . $end;
            }

            return $result;

        }


        $timeConditionID = '';
        $temp_count = 1;
        foreach ($array_fields as $key => $fields) {
            $comp_name = $fields['comp_name'];
            $temp_count = 1;
            $count++;
            $this->class_fields[$count]['context_company']['key'] = '[timeCondition-extension-' . $fields['name'] . '-' . $fields['extension_no'] . '-' . $comp_name . ']';
            $this->class_fields[$count]['context_company']['value'] = '';

            foreach ($fields['detail'] as $key2 => $detailFields) {


                $weekDay = concatInputExt($detailFields['weekDayStart'], $detailFields['weekDayEnd'], $daysName);
                $days = concatInputExt($detailFields['dayStart'], $detailFields['dayEnd']);
                $monthDays = concatInputExt($detailFields['monthStart'], $detailFields['monthEnd'], $monthName);

                $this->class_fields[$count]['timeCondition' . $temp_count]['key'] = 'exten';
                if ($temp_count == 1) {
                    $number = '1';
                } else {
                    $number = 'n';
                }
                $this->class_fields[$count]['timeCondition' . $temp_count]['value'] = 's,' . $number . ',GotoIfTime(' . $detailFields['hourStart'] . '-' . $detailFields['hourEnd'] . ',' . $weekDay . ',' . $days . ',' . $monthDays . '?t-' . $detailFields['id'] . ')';
                $this->class_fields[$count]['timeCondition' . $temp_count]['operator'] = ' => ';
                $temp_count++;
            }

            foreach ($fields['detail'] as $key2 => $detailFields) {


                //exten => s,n(truestate),Goto(ivrName,s,1)
                //ivr - Name: ivr - Daba - IVR - dabapbx
                $weekDay = concatInputExt($detailFields['weekDayStart'], $detailFields['weekDayEnd'], $daysName);
                $days = concatInputExt($detailFields['dayStart'], $detailFields['dayEnd']);
                $monthDays = concatInputExt($detailFields['monthStart'], $detailFields['monthEnd'], $monthName);

                $this->class_fields[$count][$detailFields[comp_id] . $temp_count]['key'] = 'exten';

                if ($temp_count == 1) {
                    $number = '1';
                } else {
                    $number = 'n';
                }

                //if ($detailFields['FDialExtension'] == 'IVR') {
                if ($detailFields['fdst_option_id'] == '5') {
                    die("cant has ivr in DST");

                    //IVR
                    $ivrResult = $this->getIvrById($detailFields['fdst_option_sub_id']);
                    $ivrRow = $ivrResult['rs']->fetch();

                    $this->class_fields[$count][$detailFields[comp_id] . $temp_count]['value'] = 's,n,Goto(ivr-' . $ivrRow['ivr_name'] . '-' . $comp_name . ',s,1)';


                } else if ($detailFields['FDialExtension'] == 'Queue') {
                    die("cant has queue in DST");


                    //Queue
                    $QueueResult = $this->getQueueByid($detailFields['FForward']);
                    $QueueRow = $QueueResult['rs']->fetch();


                    //$this->class_fields[$count]['timeCondition' . $temp_count]['value'] = 's,n,Queue(' . $QueueRow['queue_name'] . '-' . $comp_name . ',,,,15)';


                    //$this->class_fields[$count]['Queue2' . $temp_count]['key'] = 'exten';
                    $this->class_fields[$count][$detailFields[comp_id] . $temp_count]['value'] = 's,n,Goto(queue-' . $comp_name . ',' . $QueueRow['queue_ext_no'] . ',1)';
                    //$this->class_fields[$count]['Queue2' . $temp_count]['operator'] = ' => ';


                    //} else if ($detailFields['FDialExtension'] == 'Announce') {
                } else if ($detailFields['fdst_option_id'] == '4') {

                    //Announce
                    $announceResult = $this->getAnnounceById($detailFields['fdst_option_sub_id']);
                    $announceRow = $announceResult['rs']->fetch();

                    $this->class_fields[$count][$detailFields[comp_id] . $temp_count]['value'] = 's,n,Goto(' . $announceRow['announce_name'] . '-' . $comp_name . ',s,1)';


                    //} else if ($detailFields['FDialExtension'] == 'HangUp') {
                } else if ($detailFields['fdst_option_id'] == '7') {

                    $this->class_fields[$count][$detailFields[comp_id] . $temp_count]['value'] = 's,n,Hangup()';

                    //} else if ($detailFields['FDialExtension'] == 'voiceMail') {
                } else if ($detailFields['fdst_option_id'] == '6') {

                    //voiceMail
                    $voiceMailResult = $this->getExtensionById($detailFields['fdst_option_sub_id']);
                    $voiceMailRow = $voiceMailResult['rs']->fetch();


                    $this->class_fields[$count][$detailFields[comp_id] . $temp_count]['value'] = 's,n,Gosub(VoicemailPlay-' . $comp_name . ',noMSG,' . $voiceMailRow[extension_no] . ')';

                    //} else if ($detailFields['FDialExtension'] == 'forward') {
                } else if ($detailFields['fdst_option_id'] == '9') {

                    //forward
                    //if ($detailFields['FForward'] == 'internal') {
                    if ($detailFields['fdst_option_sub_id'] == '1') {

                        $forwardResult = $this->getExtensionById($detailFields['fDSTOption']);
                        $forwardRow = $forwardResult['rs']->fetch();
                        $this->class_fields[$count][$detailFields[comp_id] . $temp_count]['value'] = 's,n,Goto(internaldial-' . $comp_name . ',' . $forwardRow['extension_no'] . ',1)';

                    } else if ($detailFields['fdst_option_sub_id'] == '2') {

                        $this->class_fields[$count][$detailFields[comp_id] . $temp_count]['value'] = 's,n,Goto(outpattern-' . $comp_name . ',' . $this->getFristOutboundPrefix() . $detailFields['fDSTOption'] . ',1)';

                    } else {

                        die("Failed Destination of Extension Time Condition has error");

                    }

                    //} else if ($detailFields['dialExtension'] == 'Direct Dial'){
                } else if ($detailFields['fdst_option_id'] == '10') {

                    $forwardResult = $this->getExtensionById($detailFields['extension_id']);
                    $forwardRow = $forwardResult['rs']->fetch();
                    $this->class_fields[$count][$detailFields[comp_id] . $temp_count]['value'] = 's,n,Goto(internaldial-' . $comp_name . ',' . $forwardRow['extension_no'] . ',time)';

                } else if ($detailFields['fdst_option_id'] == '11') {

                    die("Error Failed DST id 11 ");

                } else {

                    die("check the dst id of failed dst of extension time condition");

                }


                $this->class_fields[$count][$detailFields[comp_id] . $temp_count]['operator'] = ' => ';
                $temp_count++;
                break;
            }
            foreach ($fields['detail'] as $key2 => $detailFields) {


                //exten => s,n(truestate),Goto(ivrName,s,1)
                //ivr - Name: ivr - Daba - IVR - dabapbx
                $weekDay = concatInputExt($detailFields['weekDayStart'], $detailFields['weekDayEnd'], $daysName);
                $days = concatInputExt($detailFields['dayStart'], $detailFields['dayEnd']);
                $monthDays = concatInputExt($detailFields['monthStart'], $detailFields['monthEnd'], $monthName);

                $this->class_fields[$count][$detailFields['id'] . $temp_count]['key'] = 'exten';

                if ($temp_count == 1) {
                    $number = '1';
                } else {
                    $number = 'n';
                }

                if ($detailFields['dialExtension'] == 'IVR') {
                    die("cant has ivr in DST");
                    //IVR
                    $ivrResult = $this->getIvrById($detailFields['forward']);
                    $ivrRow = $ivrResult['rs']->fetch();

                    $this->class_fields[$count][$detailFields['id'] . $temp_count]['value'] = 's,n(t-' . $detailFields['id'] . '),Goto(ivr-' . $ivrRow['ivr_name'] . '-' . $comp_name . ',s,1)';


                } else if ($detailFields['dialExtension'] == 'Queue') {
                    die("cant has queue in DST");

                    //Queue
                    $QueueResult = $this->getQueueByid($detailFields['forward']);
                    $QueueRow = $QueueResult['rs']->fetch();

                    //$this->class_fields[$count]['timeCondition' . $temp_count]['value'] = 's,n(' . $detailFields['id'] . '),Queue(' . $QueueRow['queue_name'] . '-' . $comp_name . ',,,,15)';


                    //$this->class_fields[$count]['Queue2' . $temp_count]['key'] = 'exten';
                    $this->class_fields[$count][$detailFields['id'] . $temp_count]['value'] = 's,n(t-' . $detailFields['id'] . '),Goto(queue-' . $comp_name . ',' . $QueueRow['queue_ext_no'] . ',1)';
                    //$this->class_fields[$count]['Queue2' . $temp_count]['operator'] = ' => ';


                    //} else if ($detailFields['dialExtension'] == 'Announce') {
                } else if ($detailFields['dst_option_id'] == '4') {

                    //Announce
                    $announceResult = $this->getAnnounceById($detailFields['dst_option_sub_id']);
                    $announceRow = $announceResult['rs']->fetch();

                    $this->class_fields[$count][$detailFields['id'] . $temp_count]['value'] = 's,n(t-' . $detailFields['id'] . '),Goto(' . $announceRow['announce_name'] . '-' . $comp_name . ',s,1)';


                    //} else if ($detailFields['dialExtension'] == 'HangUp') {
                } else if ($detailFields['dst_option_id'] == '7') {

                    $this->class_fields[$count][$detailFields['id'] . $temp_count]['value'] = 's,n(t-' . $detailFields['id'] . '),Hangup()';

                    //} else if ($detailFields['dialExtension'] == 'voiceMail') {
                } else if ($detailFields['dst_option_id'] == '6') {

                    //voiceMail
                    $voiceMailResult = $this->getExtensionById($detailFields['dst_option_sub_id']);

                    $voiceMailRow = $voiceMailResult['rs']->fetch();

                    $this->class_fields[$count][$detailFields['id'] . $temp_count]['value'] = 's,n(t-' . $detailFields['id'] . '),Macro(VoicemailPlay-' . $comp_name . ',noMSG,' . $voiceMailRow['extension_no'] . ')';


                    //} else if ($detailFields['dialExtension'] == 'forward') {
                } else if ($detailFields['dst_option_id'] == '9') {

                    //forward
                    //if ($detailFields['forward'] == 'internal') {
                    if ($detailFields['dst_option_sub_id'] == '1') {
                        $forwardResult = $this->getExtensionById($detailFields['DSTOption']);
                        $forwardRow = $forwardResult['rs']->fetch();
                        $this->class_fields[$count][$detailFields['id'] . $temp_count]['value'] = 's,n(t-' . $detailFields['id'] . '),Goto(internaldial-' . $comp_name . ',' . $forwardRow['extension_no'] . ',1)';

                    } else if ($detailFields['dst_option_sub_id'] == '2') {


                        $this->class_fields[$count][$detailFields['id'] . $temp_count]['value'] = 's,n(t-' . $detailFields['id'] . '),Goto(outpattern-' . $comp_name . ',' . $this->getFristOutboundPrefix() . $detailFields['DSTOption'] . ',1)';

                    } else {

                        die("Success Destination of Extension Time Condition has error");

                    }

                    //} else if ($detailFields['dialExtension'] == 'Direct Dial'){
                } else if ($detailFields['dst_option_id'] == '10') {

                    $forwardResult = $this->getExtensionById($detailFields['extension_id']);
                    $forwardRow = $forwardResult['rs']->fetch();
                    $this->class_fields[$count][$detailFields['id'] . $temp_count]['value'] = 's,n(t-' . $detailFields['id'] . '),Goto(internaldial-' . $comp_name . ',' . $forwardRow['extension_no'] . ',time)';

                } else if ($detailFields['fdst_option_id'] == '11') {

                    die("Error Success DST id 11 ");

                } else {

                    die("check the dst id of extension time condition");

                }


                $this->class_fields[$count][$detailFields['id'] . $temp_count]['operator'] = ' => ';
                $temp_count++;
            }


        }

        return $count;
    }

    function setFieldsTimeconditonMain($array_fields, $defaultConfig, $count)
    {

        $daysName['1'] = 'sat';
        $daysName['2'] = 'sun';
        $daysName['3'] = 'mon';
        $daysName['4'] = 'tus';
        $daysName['5'] = 'wed';
        $daysName['6'] = 'thu';
        $daysName['7'] = 'fri';

        $monthName['1'] = 'jan';
        $monthName['2'] = 'feb';
        $monthName['3'] = 'mar';
        $monthName['4'] = 'apr';
        $monthName['5'] = 'may';
        $monthName['6'] = 'jun';
        $monthName['7'] = 'jul';
        $monthName['8'] = 'aug';
        $monthName['9'] = 'sep';
        $monthName['10'] = 'oct';
        $monthName['11'] = 'nov';
        $monthName['12'] = 'dec';


        /*[TimeCondition-$timename-$compname]
        exten => s,1,GotoIfTime(17:00-18:00,sat-wed,*,*?truestate)
        exten => s,1,GotoIfTime(17:00-18:00,sat-wed,roz az 0 ta 31 ,*?truestate)
        exten => s,n,GotoIfTime(17:00-18:30,thu,*,*?truestate)
        ;exten => s,n,Set(CALLERID(dnid)=110)
		exten => s,n(truestate),Goto(internaldial-dabapbx,110,1)
        exten => s,n(truestate),Playback(hello)*/

        //$count++;

        function concatInput($start, $end, $pattern = '')
        {

            if ($pattern != '') {
                $result = $pattern[$start] . '-' . $pattern[$end];
                if ($start == '' and $end == '') {
                    $result = '*';
                } else if ($start != '' and $end == '') {

                    $result = $pattern[$start] . '-' . $pattern[$start];
                } else if ($start == '' and $end != '') {

                    $result = $pattern[$end] . '-' . $pattern[$end];
                }
                return $result;

            }

            $result = $start . '-' . $end;

            if ($start == '' and $end == '') {
                $result = '*';
            } else if ($start != '' and $end == '') {

                $result = $start . '-' . $start;
            } else if ($start == '' and $end != '') {

                $result = $end . '-' . $end;
            }

            return $result;

        }


        $timeConditionID = '';
        $temp_count = 1;

        foreach ($array_fields as $key => $fields) {
            $comp_name = $fields['comp_name'];
            $temp_count = 1;
            $count++;
            $this->class_fields[$count]['context_company']['key'] = '[timeCondition-' . $fields['name'] . '-' . $comp_name . ']';
            $this->class_fields[$count]['context_company']['value'] = '';

            foreach ($fields['detail'] as $key2 => $detailFields) {

                $weekDay = concatInput($detailFields['weekDayStart'], $detailFields['weekDayEnd'], $daysName);
                $days = concatInput($detailFields['dayStart'], $detailFields['dayEnd']);
                $monthDays = concatInput($detailFields['monthStart'], $detailFields['monthEnd'], $monthName);

                $this->class_fields[$count]['timeCondition' . $temp_count]['key'] = 'exten';
                if ($temp_count == 1) {
                    $number = '1';
                } else {
                    $number = 'n';
                }
                $this->class_fields[$count]['timeCondition' . $temp_count]['value'] = 's,' . $number . ',GotoIfTime(' . $detailFields['hourStart'] . '-' . $detailFields['hourEnd'] . ',' . $weekDay . ',' . $days . ',' . $monthDays . '?t-' . $detailFields['id'] . ')';
                $this->class_fields[$count]['timeCondition' . $temp_count]['operator'] = ' => ';
                $temp_count++;
            }

            foreach ($fields['detail'] as $key2 => $detailFields) {


                //exten => s,n(truestate),Goto(ivrName,s,1)
                //ivr - Name: ivr - Daba - IVR - dabapbx
                $weekDay = concatInput($detailFields['weekDayStart'], $detailFields['weekDayEnd'], $daysName);
                $days = concatInput($detailFields['dayStart'], $detailFields['dayEnd']);
                $monthDays = concatInput($detailFields['monthStart'], $detailFields['monthEnd'], $monthName);

                $this->class_fields[$count][$detailFields[comp_id] . $temp_count]['key'] = 'exten';

                if ($temp_count == 1) {
                    $number = '1';
                } else {
                    $number = 'n';
                }


                //if ($detailFields['FDialExtension'] == 'IVR') {
                if ($detailFields['fdst_option_id'] == '5') {


                    //$ivrResult = $this->getIvrById($detailFields['FForward']);
                    $ivrResult = $this->getIvrById($detailFields['fdst_option_sub_id']);

                    $ivrRow = $ivrResult['rs']->fetch();

                    $this->class_fields[$count][$detailFields[comp_id] . $temp_count]['value'] = 's,n,Goto(ivr-' . $ivrRow['ivr_name'] . '-' . $comp_name . ',s,1)';


                    //} else if ($detailFields['FDialExtension'] == 'Queue') {
                } else if ($detailFields['fdst_option_id'] == '2') {


                    //$QueueResult = $this->getQueueByid($detailFields['FForward']);
                    $QueueResult = $this->getQueueByid($detailFields['fdst_option_sub_id']);
                    $QueueRow = $QueueResult['rs']->fetch();


                    //$this->class_fields[$count]['timeCondition' . $temp_count]['value'] = 's,n,Queue(' . $QueueRow['queue_name'] . '-' . $comp_name . ',,,,15)';


                    //;exten => 1,n,Goto(Sales-Q-dabapbx,100,1)
                    //$this->class_fields[$count]['Queue2' . $temp_count]['key'] = 'exten';
                    $this->class_fields[$count][$detailFields[comp_id] . $temp_count]['value'] = 's,n,Goto(queue-' . $comp_name . ',' . $QueueRow['queue_ext_no'] . ',1)';
                    // $this->class_fields[$count]['Queue2' . $temp_count]['operator'] = ' => ';


                    //} else if ($detailFields['FDialExtension'] == 'Announce') {
                } else if ($detailFields['fdst_option_id'] == '4') {

                    //Announce
                    //$announceResult = $this->getAnnounceById($detailFields['FForward']);
                    $announceResult = $this->getAnnounceById($detailFields['fdst_option_sub_id']);
                    $announceRow = $announceResult['rs']->fetch();

                    $this->class_fields[$count][$detailFields[comp_id] . $temp_count]['value'] = 's,n,Goto(announce-' . $announceRow['announce_name'] . '-' . $comp_name . ',s,1)';


                    //} else if ($detailFields['FDialExtension'] == 'HangUp') {
                } else if ($detailFields['fdst_option_id'] == '7') {

                    $this->class_fields[$count][$detailFields[comp_id] . $temp_count]['value'] = 's,n,Hangup()';

                    //} else if ($detailFields['FDialExtension'] == 'voiceMail') {
                } else if ($detailFields['fdst_option_id'] == '6') {
                    //voiceMail
                    //$voiceMailResult = $this->getExtensionById($detailFields['FSub_dst']);
                    $voiceMailResult = $this->getExtensionById($detailFields['fdst_option_sub_id']);
                    $voiceMailRow = $voiceMailResult['rs']->fetch();


                    $this->class_fields[$count][$detailFields[comp_id] . $temp_count]['value'] = 's,n,Gosub(VoicemailPlay-' . $comp_name . ',noMSG,' . $voiceMailRow[extension_no] . ')';


                    //} else if ($detailFields['FDialExtension'] == 'forward') {
                } else if ($detailFields['fdst_option_id'] == '9') {

                    //if ($detailFields['FForward'] == 'internal') {
                    if ($detailFields['fdst_option_sub_id'] == '1') {

                        $forwardResult = $this->getExtensionById($detailFields['fDSTOption']);
                        $forwardRow = $forwardResult['rs']->fetch();

                        $this->class_fields[$count][$detailFields[comp_id] . $temp_count]['value'] = 's,n,Goto(internaldial-' . $comp_name . ',' . $forwardRow['extension_no'] . ',1)';

                    } else if ($detailFields['fdst_option_sub_id'] == '2') {

                        $this->class_fields[$count][$detailFields[comp_id] . $temp_count]['value'] = 's,n,Goto(outpattern-' . $comp_name . ',' . $this->getFristOutboundPrefix() . $detailFields['fDSTOption'] . ',1)';

                    } else {

                        die("Destination of Time Condition has error");

                    }

                    //} elseif ($detailFields['FDialExtension'] == 'timecondition') {
                } elseif ($detailFields['fdst_option_id'] == '8') {

                    $conn = parent::getConnection();

                    $sql = "
                        SELECT
                            `main_time_condition`.`name`
                        FROM `main_time_condition`
                        WHERE `main_time_condition`.`id` = '" . $detailFields['fdst_option_sub_id'] . "' ";

                    $stmt_TimeCondition = $conn->prepare($sql);
                    $stmt_TimeCondition->setFetchMode(PDO::FETCH_ASSOC);
                    $stmt_TimeCondition->execute();

                    if (!$stmt_TimeCondition) {
                        $result['result'] = -1;
                        $result['no'] = 1;
                        $result['msg'] = $conn->errorInfo();
                        return $result;
                    }

                    $result['result'] = 1;
                    $subRowTimeCondition = $stmt_TimeCondition->fetch();

                    /*$this->class_fields[$count]['timecondition' . $temp_count]['key'] = 'exten';
                    $this->class_fields[$count]['timecondition' . $temp_count]['value'] = $fields['ivr_menu_no'] . ',1,Goto(TimeCondition-' . $subRowTimeCondition['name'] . '-' . $fields['comp_name'] . ',s,1)';
                    $this->class_fields[$count]['timecondition' . $temp_count]['operator'] = ' => ';*/

                    $this->class_fields[$count][$detailFields[comp_id] . $temp_count]['value'] = 's,n,Goto(timeCondition-' . $subRowTimeCondition['name'] . '-' . $fields['comp_name'] . ',s,1)';

                } elseif ($detailFields['fdst_option_id'] == '3') {


                    $forwardResult = $this->getExtensionById($detailFields['fdst_option_sub_id']);
                    $forwardRow = $forwardResult['rs']->fetch();
                    $this->class_fields[$count][$detailFields[comp_id] . $temp_count]['value'] = 's,n,Goto(internaldial-' . $comp_name . ',' . $forwardRow['extension_no'] . ',1)';

                } else {

                    die("Destination of Time Condition has error");

                }


                $this->class_fields[$count][$detailFields[comp_id] . $temp_count]['operator'] = ' => ';
                $temp_count++;
                break;
            }
            foreach ($fields['detail'] as $key2 => $detailFields) {


                //exten => s,n(truestate),Goto(ivrName,s,1)
                //ivr - Name: ivr - Daba - IVR - dabapbx
                $weekDay = concatInput($detailFields['weekDayStart'], $detailFields['weekDayEnd'], $daysName);
                $days = concatInput($detailFields['dayStart'], $detailFields['dayEnd']);
                $monthDays = concatInput($detailFields['monthStart'], $detailFields['monthEnd'], $monthName);

                $this->class_fields[$count][$detailFields['id'] . $temp_count]['key'] = 'exten';

                if ($temp_count == 1) {
                    $number = '1';
                } else {
                    $number = 'n';
                }


                //if ($detailFields['FDialExtension'] == 'IVR') {
                if ($detailFields['dst_option_id'] == '5') {


                    //IVR
                    //$ivrResult = $this->getIvrById($detailFields['forward']);
                    $ivrResult = $this->getIvrById($detailFields['dst_option_sub_id']);
                    $ivrRow = $ivrResult['rs']->fetch();

                    $this->class_fields[$count][$detailFields['id'] . $temp_count]['value'] = 's,n(t-' . $detailFields['id'] . '),Goto(ivr-' . $ivrRow['ivr_name'] . '-' . $comp_name . ',s,1)';


                    //} else if ($detailFields['dialExtension'] == 'Queue') {
                } else if ($detailFields['dst_option_id'] == '2') {


                    //Queue
                    //$QueueResult = $this->getQueueByid($detailFields['forward']);
                    $QueueResult = $this->getQueueByid($detailFields['dst_option_sub_id']);
                    $QueueRow = $QueueResult['rs']->fetch();

                    //$this->class_fields[$count]['timeCondition' . $temp_count]['value'] = 's,n(' . $detailFields['id'] . '),Queue(' . $QueueRow['queue_name'] . '-' . $comp_name . ',,,,15)';


                    //;exten => 1,n,Goto(Sales-Q-dabapbx,100,1)
                    //$this->class_fields[$count]['Queue2' . $temp_count]['key'] = 'exten';
                    $this->class_fields[$count][$detailFields['id'] . $temp_count]['value'] = 's,n(t-' . $detailFields['id'] . '),Goto(queue-' . $comp_name . ',' . $QueueRow['queue_ext_no'] . ',1)';
                    //$this->class_fields[$count]['Queue2' . $temp_count]['operator'] = ' => ';


                    //} else if ($detailFields['dialExtension'] == 'Announce') {
                } else if ($detailFields['dst_option_id'] == '4') {

                    //Announce
                    //$announceResult = $this->getAnnounceById($detailFields['forward']);
                    $announceResult = $this->getAnnounceById($detailFields['dst_option_sub_id']);
                    $announceRow = $announceResult['rs']->fetch();

                    $this->class_fields[$count][$detailFields['id'] . $temp_count]['value'] = 's,n(t-' . $detailFields['id'] . '),Goto(announce-' . $announceRow['announce_name'] . '-' . $comp_name . ',s,1)';


                    //} else if ($detailFields['dialExtension'] == 'HangUp') {
                } else if ($detailFields['dst_option_id'] == '7') {

                    $this->class_fields[$count][$detailFields['id'] . $temp_count]['value'] = 's,n(t-' . $detailFields['id'] . '),Hangup()';

                    //} else if ($detailFields['dialExtension'] == 'voiceMail') {
                } else if ($detailFields['dst_option_id'] == '6') {

                    //voiceMail
                    //$voiceMailResult = $this->getExtensionById($detailFields['sub_dst']);
                    $voiceMailResult = $this->getExtensionById($detailFields['dst_option_sub_id']);
                    $voiceMailRow = $voiceMailResult['rs']->fetch();

                    $this->class_fields[$count][$detailFields['id'] . $temp_count]['value'] = 's,n(t-' . $detailFields['id'] . '),Macro(VoicemailPlay-' . $comp_name . ',noMSG,' . $voiceMailRow['extension_no'] . ')';


                    //} else if ($detailFields['dialExtension'] == 'forward') {
                } else if ($detailFields['dst_option_id'] == '9') {

                    //forward
                    //if ($detailFields['forward'] == 'internal') {
                    if ($detailFields['dst_option_sub_id'] == '1') {

                        $forwardResult = $this->getExtensionById($detailFields['DSTOption']);
                        $forwardRow = $forwardResult['rs']->fetch();
                        $this->class_fields[$count][$detailFields['id'] . $temp_count]['value'] = 's,n(t-' . $detailFields['id'] . '),Goto(internaldial-' . $comp_name . ',' . $forwardRow['extension_no'] . ',1)';


                    } else if ($detailFields['dst_option_sub_id'] == '2') {

                        $this->class_fields[$count][$detailFields['id'] . $temp_count]['value'] = 's,n(t-' . $detailFields['id'] . '),Goto(outpattern-' . $comp_name . ',' . $this->getFristOutboundPrefix() . $detailFields['DSTOption'] . ',1)';

                    } else {

                        die("Destination of time condition has error");

                    }

                    //} elseif ($detailFields['FDialExtension'] == 'timecondition') {
                } elseif ($detailFields['dst_option_id'] == '8') {

                    $conn = parent::getConnection();

                    $sql = "
                        SELECT
                            `main_time_condition`.`name`
                        FROM `main_time_condition`
                        WHERE `main_time_condition`.`id` = '" . $detailFields['dst_option_sub_id'] . "' ";

                    $stmt_TimeCondition = $conn->prepare($sql);
                    $stmt_TimeCondition->setFetchMode(PDO::FETCH_ASSOC);
                    $stmt_TimeCondition->execute();

                    if (!$stmt_TimeCondition) {
                        $result['result'] = -1;
                        $result['no'] = 1;
                        $result['msg'] = $conn->errorInfo();
                        return $result;
                    }

                    $result['result'] = 1;
                    $subRowTimeCondition = $stmt_TimeCondition->fetch();

                    $this->class_fields[$count][$detailFields['id'] . $temp_count]['value'] = 's,n(t-' . $detailFields['id'] . '),Goto(timeCondition-' . $subRowTimeCondition['name'] . '-' . $fields['comp_name'] . ',s,1)';

                } elseif ($detailFields['dst_option_id'] == '3') {


                    $forwardResult = $this->getExtensionById($detailFields['dst_option_sub_id']);
                    $forwardRow = $forwardResult['rs']->fetch();
                    $this->class_fields[$count][$detailFields['id'] . $temp_count]['value'] = 's,n(t-' . $detailFields['id'] . '),Goto(internaldial-' . $comp_name . ',' . $forwardRow['extension_no'] . ',1)';

                } else {

                    die("Destination of Time Condition has error");

                }

                $this->class_fields[$count][$detailFields['id'] . $temp_count]['operator'] = ' => ';
                $temp_count++;
            }


        }

        return $count;
    }

    function setFieldsQueue($array_fields, $defaultConfig, $count)
    {

        $temp_count = 0;
        $count++;


        foreach ($array_fields as $key => $fields) {

            $temp_count++;
            $comp_name = $fields['comp_name'];
            if ($temp_count == 1) {
                $this->class_fields[$count]['context_company']['key'] = '[queue-' . $comp_name . ']';
                $this->class_fields[$count]['context_company']['value'] = '';
            }

            $max_wait_time = $fields['max_wait_time'];
            if (isset($max_wait_time) and $max_wait_time == '') {
                $max_wait_time = 60;
            }

            if ($fields['instead'] == '1') {
                $instead = 'r';
            } else {
                $instead = '';
            }


            $this->class_fields[$count]['queue5' . $temp_count]['key'] = 'exten';
            $this->class_fields[$count]['queue5' . $temp_count]['operator'] = ' => ';
            $this->class_fields[$count]['queue5' . $temp_count]['value'] = $fields['queue_ext_no'] . ',1,Answer()';


	    $this->class_fields[$count]['queue55' . $temp_count]['key'] = 'exten';
	    $this->class_fields[$count]['queue55' . $temp_count]['operator'] = ' => ';
	    $this->class_fields[$count]['queue55' . $temp_count]['value'] = $fields['queue_ext_no'] .',n,set(Master=${MASTER_CHANNEL(UNIQUEID)})';

	    $this->class_fields[$count]['queue56' . $temp_count]['key'] = 'exten';
	    $this->class_fields[$count]['queue56' . $temp_count]['operator'] = ' => ';
	    $this->class_fields[$count]['queue56' . $temp_count]['value'] = $fields['queue_ext_no'] .',n,QueueLog('.$fields['queue_ext_no'] . ',${UNIQUEID},NONE,FORUPDATE,${Master})';


            if ($fields['recording'] == 1) {

                $this->class_fields[$count]['queue0' . $temp_count]['key'] = 'exten';
                $this->class_fields[$count]['queue0' . $temp_count]['operator'] = ' => ';
                $this->class_fields[$count]['queue0' . $temp_count]['value'] = $fields['queue_ext_no'] . ',n,Set(__fromQueue=1)';

            }

            $this->class_fields[$count]['queue1' . $temp_count]['key'] = 'exten';
            $this->class_fields[$count]['queue1' . $temp_count]['operator'] = ' => ';
            //$this->class_fields[$count]['queue1' . $temp_count]['value'] = $fields['queue_ext_no'] . ',n,Queue(' . $fields['queue_name'] . '-' . $comp_name . ',' . $instead . ',,,' . $max_wait_time . ')';
            $this->class_fields[$count]['queue1' . $temp_count]['value'] = $fields['queue_ext_no'] . ',n,Queue(' . $fields['queue_name']. $instead . ',,,,' . $max_wait_time . ')';

            $this->class_fields[$count]['queue2' . $temp_count]['key'] = 'exten';
            $this->class_fields[$count]['queue2' . $temp_count]['operator'] = ' => ';


            if ($fields['dst_option_id'] == '2') {

                $conn = parent::getConnection();

                $sql = "
                             SELECT
                              `tbl_queue`.`queue_ext_no`
                               FROM `tbl_queue`
                             WHERE
                                `tbl_queue`.`queue_id` = '" . $fields['dst_option_sub_id'] . "' ";

                $stmt_queue = $conn->prepare($sql);
                $stmt_queue->setFetchMode(PDO::FETCH_ASSOC);
                $stmt_queue->execute();

                if (!$stmt_queue) {
                    $result['result'] = -1;
                    $result['no'] = 1;
                    $result['msg'] = $conn->errorInfo();
                    return $result;
                }
                $result['result'] = 1;
                $subRowQueue = $stmt_queue->fetch();

                $this->class_fields[$count]['queue2' . $temp_count]['value'] = $fields['queue_ext_no'] . ',n,Goto(queue-' . $comp_name . ',' . $subRowQueue['queue_ext_no'] . ',1)';


            } elseif ($fields['dst_option_id'] == '3') {

                $conn = parent::getConnection();

                $sql = "
                      SELECT
                        `tbl_extension`.`extension_no`
                         FROM `tbl_extension`
                      WHERE
                        `tbl_extension`.`extension_id` = '" . $fields['dst_option_sub_id'] . "' ";

                $stmt_extension = $conn->prepare($sql);
                $stmt_extension->setFetchMode(PDO::FETCH_ASSOC);
                $stmt_extension->execute();

                if (!$stmt_extension) {
                    $result['result'] = -1;
                    $result['no'] = 1;
                    $result['msg'] = $conn->errorInfo();
                    return $result;
                }
                $result['result'] = 1;
                $subRowExtension = $stmt_extension->fetch();

                $this->class_fields[$count]['queue2' . $temp_count]['value'] = $fields['queue_ext_no'] . ',n,Goto(internaldial-' . $comp_name . ',' . $subRowExtension['extension_no'] . ',1)';

            } elseif ($fields['dst_option_id'] == '4') {

                $conn = parent::getConnection();

                $sql = "
                              SELECT
                                `tbl_announce`.`announce_name` 
                              FROM `tbl_announce`
                              WHERE
                                `tbl_announce`.`announce_id` = '" . $fields['dst_option_sub_id'] . "' ";

                $stmt_announcement = $conn->prepare($sql);
                $stmt_announcement->setFetchMode(PDO::FETCH_ASSOC);
                $stmt_announcement->execute();

                if (!$stmt_announcement) {
                    $result['result'] = -1;
                    $result['no'] = 1;
                    $result['msg'] = $conn->errorInfo();
                    return $result;
                }
                $result['result'] = 1;
                $subRowAnnouncement = $stmt_announcement->fetch();


                $this->class_fields[$count]['queue2' . $temp_count]['value'] = $fields['queue_ext_no'] . ',n,Goto(announce-' . $subRowAnnouncement['announce_name'] . '-' . $comp_name . ',s,1)';

            } elseif ($fields['dst_option_id'] == '5') {

                $conn = parent::getConnection();

                $sql = "
                    SELECT
                      `tbl_ivr`.`ivr_name`
                    FROM
                      `tbl_ivr`
                    WHERE
                      `tbl_ivr`.`ivr_id` ='" . $fields['dst_option_sub_id'] . "' ";

                $stmt_ivr = $conn->prepare($sql);
                $stmt_ivr->setFetchMode(PDO::FETCH_ASSOC);
                $stmt_ivr->execute();

                if (!$stmt_ivr) {
                    $result['result'] = -1;
                    $result['no'] = 1;
                    $result['msg'] = $conn->errorInfo();
                    return $result;
                }
                $result['result'] = 1;
                $subRowIvr = $stmt_ivr->fetch();


                $this->class_fields[$count]['queue2' . $temp_count]['value'] = $fields['queue_ext_no'] . ',n,Goto(ivr-' . $subRowIvr['ivr_name'] . '-' . $comp_name . ',s,1)';

            } elseif ($fields['dst_option_id'] == '6') {

                $conn = parent::getConnection();

                $sql = "
                              SELECT
                                `tbl_extension`.`extension_no` 
                              FROM `tbl_extension`
                              WHERE
                                `tbl_extension`.`extension_id` = '" . $fields['dst_option_sub_id'] . "' ";

                $stmt_vm = $conn->prepare($sql);
                $stmt_vm->setFetchMode(PDO::FETCH_ASSOC);
                $stmt_vm->execute();

                if (!$stmt_vm) {
                    $result['result'] = -1;
                    $result['no'] = 1;
                    $result['msg'] = $conn->errorInfo();
                    return $result;
                }
                $result['result'] = 1;
                $subRowVM = $stmt_vm->fetch();


                $this->class_fields[$count]['queue2' . $temp_count]['value'] = $fields['queue_ext_no'] . ',n,Macro(VoicemailPlay-' . $comp_name . ',noMSG,' . $subRowVM['extension_no'] . ')';

            } elseif ($fields['dst_option_id'] == '7') {

                $this->class_fields[$count]['queue2' . $temp_count]['value'] = $fields['queue_ext_no'] . ',n,Hangup()';

            } elseif ($fields['dst_option_id'] == '8') {

                $conn = parent::getConnection();


                $sql = "
                        SELECT
                            `main_time_condition`.`name`
                        FROM `main_time_condition`
                        WHERE `main_time_condition`.`id` = '" . $fields['dst_option_sub_id'] . "' ";


                $stmt_TimeCondition = $conn->prepare($sql);
                $stmt_TimeCondition->setFetchMode(PDO::FETCH_ASSOC);
                $stmt_TimeCondition->execute();

                if (!$stmt_TimeCondition) {
                    $result['result'] = -1;
                    $result['no'] = 1;
                    $result['msg'] = $conn->errorInfo();
                    return $result;
                }

                $result['result'] = 1;
                $subRowtimecondition = $stmt_TimeCondition->fetch();


                //$fields['ivr_menu_no'] . ',1,Goto(TimeCondition-'.$subRowSip['name'].'-'.$fields['comp_name'] .'s,1)';

                $this->class_fields[$count]['queue2' . $temp_count]['value'] = $fields['queue_ext_no'] . ',n,Goto(timeCondition-' . $subRowtimecondition['name'] . '-' . $comp_name . ',s,1)';

            } elseif ($fields['dst_option_id'] == 9) {

                if ($fields['dst_option_sub_id'] == '1') {

                    $forwardResult = $this->getExtensionById($fields['DSTOption']);
                    $forwardRow = $forwardResult['rs']->fetch();

                    //$this->class_fields[$count]['ForwardI' . $temp_count]['key'] = 'exten';
                    $this->class_fields[$count]['queue2' . $temp_count]['value'] = $fields['queue_ext_no'] . ',n,Goto(internaldial-' . $comp_name . ',' . $forwardRow['extension_no'] . ',1)';
                    //$this->class_fields[$count]['ForwardI' . $temp_count]['operator'] = ' => ';

                } else if ($fields['dst_option_sub_id'] == '2') {


                    //$this->class_fields[$count]['ForwardE' . $temp_count]['key'] = 'exten';
                    $this->class_fields[$count]['queue2' . $temp_count]['value'] = $fields['queue_ext_no'] . ',n,Goto(outpattern-' . $comp_name . ',' . $this->getFristOutboundPrefix() . $fields['DSTOption'] . ',1)';
                    //$this->class_fields[$count]['ForwardE' . $temp_count]['operator'] = ' => ';

                } else {

                    die("Destination of Queue has error");

                }

            } else {

                die("Destination of Queue has error");

            }


            //$this->class_fields[$count]['queue2' . $temp_count]['value'] = $fields['queue_ext_no'] . ',n,Hangup()';

        }

        /*$this->class_fields[$count]['queue3' . $temp_count]['key'] = 'exten';
        $this->class_fields[$count]['queue3' . $temp_count]['operator'] = ' => ';
        $this->class_fields[$count]['queue3' . $temp_count]['value'] = 'h,1,Hangup()';*/


        $this->class_fields[$count]['customeend']['key'] = '#include';

        $this->class_fields[$count]['customeend']['value'] = RECORD_PATH . 'voip' . constant("DS") . $comp_name . '-custom-exten.conf';
        $this->class_fields[$count]['customeend']['operator'] = '  ';


        $count++;
        return $count;
    }


    /**
     * @param $array_fields
     * @param $defaultConfig
     * @param $count
     * @return mixed
     */
    function setFieldsFax($array_fields, $defaultConfig, $count)
    {
        $count++;
        foreach ($array_fields['list'] as $key => $fields) {
            $comp_name = $fields['comp_name'];
            $this->class_fields[$count]['context_company']['key'] = '[faxdetect-' . $comp_name . ']';
            $this->class_fields[$count]['context_company']['value'] = '';

            $this->class_fields[$count]['Fax-exten1']['key'] = 'exten';
            $this->class_fields[$count]['Fax-exten1']['value'] = 's,1,Answer';
            $this->class_fields[$count]['Fax-exten1']['operator'] = ' => ';

            $this->class_fields[$count]['Fax-exten2']['key'] = 'exten';
            $this->class_fields[$count]['Fax-exten2']['value'] = 's,n,Ringing';
            $this->class_fields[$count]['Fax-exten2']['operator'] = ' => ';

            $this->class_fields[$count]['Fax-exten3']['key'] = 'exten';
            $this->class_fields[$count]['Fax-exten3']['value'] = 's,n,NVFaxDetect(5)';
            $this->class_fields[$count]['Fax-exten3']['operator'] = ' => ';

            $this->class_fields[$count]['Fax-exten4']['key'] = 'exten';
            $this->class_fields[$count]['Fax-exten4']['value'] = 's,n,Goto(${inbound_name},${exten_id},continue)';
            $this->class_fields[$count]['Fax-exten4']['operator'] = ' => ';

            $this->class_fields[$count]['Fax-exten5']['key'] = 'exten';
            $this->class_fields[$count]['Fax-exten5']['value'] = 'fax,1,Goto(FAX-recive-' . $comp_name . ',s,1)';
            $this->class_fields[$count]['Fax-exten5']['operator'] = ' => ';

            $count++;

            $this->class_fields[$count]['FAX-recive-context']['key'] = '[FAX-recive-' . $comp_name . ']';
            $this->class_fields[$count]['FAX-recive-contex']['value'] = '';

            $this->class_fields[$count]['FAX-recive-exten1']['key'] = 'exten';
            $this->class_fields[$count]['FAX-recive-exten1']['value'] = 's,1,Set(CHANNEL(hangup_handler_push)=s,3)';
            $this->class_fields[$count]['FAX-recive-exten1']['operator'] = ' => ';

            $this->class_fields[$count]['FAX-recive-receivefax']['key'] = 'exten';
            $this->class_fields[$count]['FAX-recive-receivefax']['value'] = 's,n(receivefax),StopPlaytones';
            $this->class_fields[$count]['FAX-recive-receivefax']['operator'] = ' => ';

            $this->class_fields[$count]['FAX-recive-receivefax1']['key'] = 'exten';
            $this->class_fields[$count]['FAX-recive-receivefax1']['value'] = 's,n,ReceiveFAX(/tmp/${UNIQUEID}.tif,Fd)';
            $this->class_fields[$count]['FAX-recive-receivefax1']['operator'] = ' => ';

            $this->class_fields[$count]['FAX-recive-System']['key'] = 'exten';
            $this->class_fields[$count]['FAX-recive-System']['value'] = 'h,1,System(tiff2pdf -o /tmp/${UNIQUEID}.pdf /tmp/${UNIQUEID}.tif)';
            $this->class_fields[$count]['FAX-recive-System']['operator'] = ' => ';

            $this->class_fields[$count]['FAX-recive-Verbose']['key'] = 'exten';
            $this->class_fields[$count]['FAX-recive-Verbose']['value'] = 'h,n,Verbose(Fax receipt completed with status: ${FAXSTATUS})';
            $this->class_fields[$count]['FAX-recive-Verbose']['operator'] = ' => ';

            $this->class_fields[$count]['FAX-recive-System2']['key'] = 'exten';
            $this->class_fields[$count]['FAX-recive-System2']['value'] = 'h,n,System(mpack -s fax-attachment /tmp/${UNIQUEID}.pdf ${email})';
            $this->class_fields[$count]['FAX-recive-System2']['operator'] = ' => ';

            $this->class_fields[$count]['FAX-recive-Hangup']['key'] = 'exten';
            $this->class_fields[$count]['FAX-recive-Hangup']['value'] = 'h,n,Hangup()';
            $this->class_fields[$count]['FAX-recive-Hangup']['operator'] = ' => ';

            $count;
        }

        return $count;
    }

    /**
     * @param $_input
     * @return string
     */
    function change_did_cid($_input)
    {
        if ((strpos($_input, 'x') !== false) or (strpos($_input, 'X') !== false) or (strpos($_input, 'n') !== false) or (strpos($_input, 'N') !== false) or (strpos($_input, 'z') !== false) or (strpos($_input, 'Z') !== false)) {
            $result = '_' . $_input;
        } else {
            $result = $_input;
        }
        return $result;

    }

    /**
     * @param $array_fields
     * @param $defaultConfig
     * @param $count
     * @return mixed
     */
    function setFieldsInbound($array_fields, $defaultConfig, $count)
    {
        $newName = '';
        $temp_count = 1;
        $count++;
        foreach ($array_fields as $key => $fields) {
            if ($fields['did_name'] == '' and $fields['cid_name'] == '') {
                $new_array_fields[4][] = $fields;
            } else if ($fields['did_name'] == '' and $fields['cid_name'] != '') {
                $new_array_fields[3][] = $fields;
            } else if ($fields['did_name'] != '' and $fields['cid_name'] == '') {
                $new_array_fields[2][] = $fields;
            } else if ($fields['did_name'] != '' and $fields['cid_name'] != '') {
                $new_array_fields[1][] = $fields;
            }
        }

        include_once(ROOT_DIR . "component/inbound.sort.class.php");


        for ($i = 1; $i <= 4; $i++) {

            $fieldCheck = '!={}=--*6';
            /*if($i==2)
            {
                $fieldCheck='did_name';

            }else if($i==1 or $i==4)
            {
                $fieldCheck='did_name';

            }if($i==3)
            {
                $fieldCheck='cid_name';

            }*/

            if (count($new_array_fields[$i]) == 0) {
                continue;
            }


            $result = InboundSort::sort($new_array_fields[$i]);

            $sort[$i] = $result;


        }

        for ($i = 1; $i <= 4; $i++) {
            if (count($sort[$i]) == 0) {
                continue;
            }
            foreach ($sort[$i] as $key => $arrays) {
                $array_inbound[] = $arrays;


            }

        }

        $this->class_fields[$count]['context_inbound']['key'] = '[inbound-' . $fields['comp_name'] . ']';
        $this->class_fields[$count]['context_inbound']['value'] = '';

        $temp_count = 1;

        foreach ($array_inbound as $key => $fields) {

            $this->class_fields[$count]['include_inbound' . $temp_count]['key'] = 'include';
            $this->class_fields[$count]['include_inbound' . $temp_count]['value'] = 'inbound-' . $fields['inbound_name'] . '-' . $fields['comp_name'];
            $this->class_fields[$count]['include_inbound' . $temp_count]['operator'] = ' => ';

            $temp_count++;
        }

        $this->class_fields[$count]['include_inbound' . $temp_count]['key'] = 'include';
        $this->class_fields[$count]['include_inbound' . $temp_count]['value'] = 'inbound-' . $fields['comp_name'] . '-custome';
        $this->class_fields[$count]['include_inbound' . $temp_count]['operator'] = ' => ';

        foreach ($array_inbound as $key => $fields) {

            $count++;
            $this->class_fields[$count]['context_ivr']['key'] =
                '[inbound-' . $fields['inbound_name'] . '-' . $fields['comp_name'] . ']';
            $this->class_fields[$count]['context_ivr']['value'] = '';

            $conn = parent::getConnection();

            $did_cid = $this->setDidCid($fields['did_name'], $fields['cid_name']);

            $sign_fax = '1';
            if ($fields['fax_email'] != '') {
                $sign_fax = 'n';

                $this->class_fields[$count]['fax1' . $temp_count]['key'] = 'exten';
                $this->class_fields[$count]['fax1' . $temp_count]['value'] =
                    $did_cid . ',1,Set(email=' . $fields['fax_email'] . ')';
                $this->class_fields[$count]['fax1' . $temp_count]['operator'] = ' => ';

                $this->class_fields[$count]['fax2' . $temp_count]['key'] = 'exten';
                $this->class_fields[$count]['fax2' . $temp_count]['value'] =
                    $did_cid . ',n,Set(inbound_name=inbound-' . $fields['inbound_name'] . '-' . $fields['comp_name'] . ')';
                $this->class_fields[$count]['fax2' . $temp_count]['operator'] = ' => ';

                $this->class_fields[$count]['fax3' . $temp_count]['key'] = 'exten';
                $this->class_fields[$count]['fax3' . $temp_count]['value'] =
                    $did_cid . ',n,Set(exten_id=${CALLERID(dnid)})';
                $this->class_fields[$count]['fax3' . $temp_count]['operator'] = ' => ';

                $this->class_fields[$count]['fax4' . $temp_count]['key'] = 'exten';
                $this->class_fields[$count]['fax4' . $temp_count]['value'] =
                    $did_cid . ',n,Macro(faxdetect-' . $fields['comp_name'] . ',${email})';
                $this->class_fields[$count]['fax4' . $temp_count]['operator'] = ' => ';
            }


            /*if ($fields['dst_option_id'] == 1) {

                $conn = parent::getConnection();

                $sql = "
                             SELECT
                              `tbl_sip`.* FROM `tbl_sip`
                             WHERE
                                `tbl_sip`.`sip_id` = '" . $fields['dst_option_sub_id'] . "' AND  `trash`='0' ";

                $stmt_sipTrunk = $conn->prepare($sql);
                $stmt_sipTrunk->setFetchMode(PDO::FETCH_ASSOC);
                $stmt_sipTrunk->execute();

                if (!$stmt_sipTrunk) {
                    $result['result'] = -1;
                    $result['no'] = 1;
                    $result['msg'] = $conn->errorInfo();
                    return $result;
                }
                $result['result'] = 1;
                $subRowSipTrunk = $stmt_sipTrunk->fetch();

                //exten => 8,1,Dial(SIP/@trunk100-c)
                $this->class_fields[$count]['SipTrunk' . $temp_count]['key'] = 'exten';
                $this->class_fields[$count]['SipTrunk' . $temp_count]['value']
                    = $did_cid . ',' . $sign_fax . '(continue),Dial(SIP/@' . $subRowSipTrunk['sip_name'] . '-' . $fields['comp_name'] . ')';
                $this->class_fields[$count]['SipTrunk' . $temp_count]['operator'] = ' => ';

            } */
            if ($fields['dst_option_id'] == 2) {


                $conn = parent::getConnection();

                $sql = "
                             SELECT
                              `tbl_queue`.* FROM `tbl_queue`
                             WHERE
                                `tbl_queue`.`queue_id` = '" . $fields['dst_option_sub_id'] . "' AND  `trash`='0' ";

                $stmt_queue = $conn->prepare($sql);
                $stmt_queue->setFetchMode(PDO::FETCH_ASSOC);
                $stmt_queue->execute();

                if (!$stmt_queue) {
                    $result['result'] = -1;
                    $result['no'] = 1;
                    $result['msg'] = $conn->errorInfo();
                    return $result;
                }
                $result['result'] = 1;
                $subRowSip = $stmt_queue->fetch();


                /*$this->class_fields[$count]['Queue' . $temp_count . '-Answer']['key'] = 'exten';
                $this->class_fields[$count]['Queue' . $temp_count . '-Answer']['value'] = $did_cid . ',' . $sign_fax . ',Answer()';
                $this->class_fields[$count]['Queue' . $temp_count . '-Answer']['operator'] = ' => ';


                if ($subRowSip['max_wait_time'] == '') {
                    $subRowSip['max_wait_time'] = 60;
                }

                if ($subRowSip['instead'] == '1') {
                    $instead = 'r';
                } else {
                    $instead = '';
                }

                $this->class_fields[$count]['Queue' . $temp_count]['key'] = 'exten';
                $this->class_fields[$count]['Queue' . $temp_count]['value'] = $did_cid . ',n,Queue(' . $subRowSip['queue_name'] . '-' . $fields['comp_name'] . ',' . $instead . ',,,' . $subRowSip['max_wait_time'] . ')';
                $this->class_fields[$count]['Queue' . $temp_count]['operator'] = ' => ';


                //;exten => 1,n,Goto(Sales-Q-dabapbx,100,1)




                $result = $this->queueDstOption($subRowSip, $count, $temp_count, 'inbound', $fields);*/

                $this->class_fields[$count]['Queue2' . $temp_count]['key'] = 'exten';
                $this->class_fields[$count]['Queue2' . $temp_count]['value']
                    = $did_cid . ',1,Goto(queue-' . $fields['comp_name'] . ',' . $subRowSip['queue_ext_no'] . ',1)';
                $this->class_fields[$count]['Queue2' . $temp_count]['operator'] = ' => ';

                /*$this->class_fields[$count]['Queue2' . $temp_count]['key'] = 'exten';
                $this->class_fields[$count]['Queue2' . $temp_count]['value'] = $did_cid . ',n,Goto(queue-' . $fields['comp_name'] . ',' . $instead . ',,,' . $subRowSip['max_wait_time'] . ')';
                $this->class_fields[$count]['Queue2' . $temp_count]['operator'] = ' => ';*/

            }
            else if ($fields['dst_option_id'] == 3)
            {
                $conn = parent::getConnection();

                $sql = "
                              SELECT
                                `tbl_extension`.* FROM `tbl_extension`
                              WHERE
                                `tbl_extension`.`extension_id` = '" . $fields['dst_option_sub_id'] . "' AND  `trash`='0' ";

                $stmt_extension = $conn->prepare($sql);
                $stmt_extension->setFetchMode(PDO::FETCH_ASSOC);
                $stmt_extension->execute();

                if (!$stmt_extension) {
                    $result['result'] = -1;
                    $result['no'] = 1;
                    $result['msg'] = $conn->errorInfo();
                    return $result;
                }

                $result['result'] = 1;
                $subRowSip = $stmt_extension->fetch();

                /*if ($subRowSip['ring_number'] == '' or strlen($subRowSip['ring_number']) == 0) {
                    $subRowSip['ring_number'] = '7';
                }

                $ring_time = ONE_RING_TIME * $subRowSip['ring_number'];*/

                $this->class_fields[$count]['extension_t' . $temp_count]['key'] = 'exten';
                $this->class_fields[$count]['extension_t' . $temp_count]['value'] =
                    $did_cid . ',' . $sign_fax . '(continue),Goto(internaldial-' . $fields['comp_name'] . ',' . $subRowSip['extension_no'] . ',1)';
                $this->class_fields[$count]['extension_t' . $temp_count]['operator'] = ' => ';

                //
                /*if ($subRowSip['voicemail_status'] == '1') {

                    $this->class_fields[$count]['DIALSTATUS' . $temp_count]['key'] = 'exten';
                    $this->class_fields[$count]['DIALSTATUS' . $temp_count]['value'] = $did_cid . ',n,Gotoif($[${DIALSTATUS}=CHANUNAVAIL | BUSY | NOANSWER]?next:hangup)';
                    $this->class_fields[$count]['DIALSTATUS' . $temp_count]['operator'] = ' => ';

                    $this->class_fields[$count]['VoiceMail' . $temp_count]['key'] = 'exten';
                    $this->class_fields[$count]['VoiceMail' . $temp_count]['value'] = $did_cid . ',n(next),VoiceMail(' . $subRowSip['extension_no'] . '@voiceMail-' . $fields['comp_name'] . ')';
                    $this->class_fields[$count]['VoiceMail' . $temp_count]['operator'] = ' => ';

                    //[record-internaldial
                    $this->class_fields[$count]['VoiceMail_exten' . $temp_count]['key'] = 'exten';
                    $this->class_fields[$count]['VoiceMail_exten' . $temp_count]['value'] = $did_cid . ',n,Set(voicemailfile=${VM_MESSAGEFILE})';
                    $this->class_fields[$count]['VoiceMail_exten' . $temp_count]['operator'] = ' => ';

                    $this->class_fields[$count]['VoiceMail_exten1' . $temp_count]['key'] = 'exten';
                    $this->class_fields[$count]['VoiceMail_exten1' . $temp_count]['value'] = $did_cid . ',n,System(cp ${voicemailfile}.wav /' . VOICEMAIL_PATH . '${UNIQUEID}.wav)';
                    $this->class_fields[$count]['VoiceMail_exten1' . $temp_count]['operator'] = ' => ';

                }
                //

                $this->class_fields[$count]['ivr' . $temp_count]['key'] = 'exten';
                $this->class_fields[$count]['ivr' . $temp_count]['value'] =
                    $did_cid . ',n(hangup),Hangup()';
                $this->class_fields[$count]['ivr' . $temp_count]['operator'] = ' => ';*/

            }
            else if ($fields['dst_option_id'] == 4 and $fields['dst_option_sub_id'] != '0') {
                $conn = parent::getConnection();

                $sql = "
                              SELECT
                                `tbl_announce`.* FROM `tbl_announce`
                              WHERE
                                `tbl_announce`.`announce_id` = '" . $fields['dst_option_sub_id'] . "' AND  `trash`='0' ";

                $stmt_announce = $conn->prepare($sql);
                $stmt_announce->setFetchMode(PDO::FETCH_ASSOC);
                $stmt_announce->execute();

                if (!$stmt_announce) {
                    $result['result'] = -1;
                    $result['no'] = 1;
                    $result['msg'] = $conn->errorInfo();
                    return $result;
                }
                $result['result'] = 1;
                $subRowAnnounce = $stmt_announce->fetch();

                //exten => 4,1,Goto(announce-10-daba,s,1)

                $this->class_fields[$count]['extension_t' . $temp_count]['key'] = 'exten';
                $this->class_fields[$count]['extension_t' . $temp_count]['value'] =
                    $did_cid . ',' . $sign_fax . '(continue),Goto(announce-' . $subRowAnnounce['announce_name'] . '-' . $fields['comp_name'] . ',s,1)';
                $this->class_fields[$count]['extension_t' . $temp_count]['operator'] = ' => ';

            }
            else if ($fields['dst_option_id'] == 5) {
                $conn = parent::getConnection();

                $sql = "
                    SELECT
                    *
                    FROM
                      `tbl_ivr`
                    WHERE
                      `tbl_ivr`.`ivr_id` ='" . $fields['dst_option_sub_id'] . "' AND  `trash`='0'";

                $stmt_ivr = $conn->prepare($sql);
                $stmt_ivr->setFetchMode(PDO::FETCH_ASSOC);
                $stmt_ivr->execute();

                if (!$stmt_ivr) {
                    $result['result'] = -1;
                    $result['no'] = 1;
                    $result['msg'] = $conn->errorInfo();
                    return $result;
                }
                $result['result'] = 1;
                $subRowIvr = $stmt_ivr->fetch();

                $this->class_fields[$count]['ivr' . $temp_count]['key'] = 'exten';
                $this->class_fields[$count]['ivr' . $temp_count]['value'] =
                    $did_cid . ',' . $sign_fax . '(continue),Goto(ivr-' . $subRowIvr['ivr_name'] . '-' . $fields['comp_name'] . ',s,1)';
                $this->class_fields[$count]['ivr' . $temp_count]['operator'] = ' => ';

            }
            else if ($fields['dst_option_id'] == 6) {
                $conn = parent::getConnection();

                $sql = "
                              SELECT
                                `tbl_extension`.* FROM `tbl_extension`
                              WHERE
                                `tbl_extension`.`extension_id` = '" . $fields['dst_option_sub_id'] . "' ";

                $stmt_extension = $conn->prepare($sql);
                $stmt_extension->setFetchMode(PDO::FETCH_ASSOC);
                $stmt_extension->execute();

                if (!$stmt_extension) {
                    $result['result'] = -1;
                    $result['no'] = 1;
                    $result['msg'] = $conn->errorInfo();
                    return $result;
                }
                $result['result'] = 1;
                $subRowSip = $stmt_extension->fetch();

                if ($subRowSip['extension_no'] != '') {

                    //' . $fields['comp_name'] . ',noMSG,'.$subRowSip['extension_no'].')';
                    $this->class_fields[$count]['VoiceMail' . $temp_count]['key'] = 'exten';
                    $this->class_fields[$count]['VoiceMail' . $temp_count]['value'] =
                        $did_cid . ',' . $sign_fax . '(continue),Macro(VoicemailPlay-' . $fields['comp_name'] . ',noMSG,' . $subRowSip['extension_no'] . ')';
                    $this->class_fields[$count]['VoiceMail' . $temp_count]['operator'] = ' => ';

                    /*$this->class_fields[$count]['VoiceMail' . $temp_count]['key'] = 'exten';
                    $this->class_fields[$count]['VoiceMail' . $temp_count]['value'] =
                        $did_cid . ',' . $sign_fax . '(continue),VoiceMail(' . $subRowSip['extension_no'] . '@voiceMail-' . $fields['comp_name'] . ')';
                    $this->class_fields[$count]['VoiceMail' . $temp_count]['operator'] = ' => ';

                    $this->class_fields[$count]['VoiceMail_exten' . $temp_count]['key'] = 'exten';
                    $this->class_fields[$count]['VoiceMail_exten' . $temp_count]['value'] = $did_cid . ',n,Set(voicemailfile=${VM_MESSAGEFILE})';
                    $this->class_fields[$count]['VoiceMail_exten' . $temp_count]['operator'] = ' => ';

                    $this->class_fields[$count]['VoiceMail_exten1' . $temp_count]['key'] = 'exten';
                    $this->class_fields[$count]['VoiceMail_exten1' . $temp_count]['value'] = $did_cid . ',n,System(cp ${voicemailfile}.wav /' . VOICEMAIL_PATH . '${UNIQUEID}.wav)';
                    $this->class_fields[$count]['VoiceMail_exten1' . $temp_count]['operator'] = ' => ';*/

                }

            } elseif ($fields['dst_option_id'] == 7) {
                // exten => 7,1,Hangup()

                $this->class_fields[$count]['Hangup' . $temp_count]['key'] = 'exten';
                $this->class_fields[$count]['Hangup' . $temp_count]['value'] = $did_cid . ',' . $sign_fax . '(continue),Hangup()';
                $this->class_fields[$count]['Hangup' . $temp_count]['operator'] = ' => ';

            } elseif ($fields['dst_option_id'] == 8) {

                $conn = parent::getConnection();

                $sql = "
                        SELECT
                            `main_time_condition`.`name`
                        FROM `main_time_condition`
                        WHERE `main_time_condition`.`id` = '" . $fields['dst_option_sub_id'] . "' ";

                $stmt_TimeCondition = $conn->prepare($sql);
                $stmt_TimeCondition->setFetchMode(PDO::FETCH_ASSOC);
                $stmt_TimeCondition->execute();

                if (!$stmt_TimeCondition) {
                    $result['result'] = -1;
                    $result['no'] = 1;
                    $result['msg'] = $conn->errorInfo();
                    return $result;
                }

                $result['result'] = 1;
                $subRowTimeCondition = $stmt_TimeCondition->fetch();

                $this->class_fields[$count]['timecondition' . $temp_count]['key'] = 'exten';
                $this->class_fields[$count]['timecondition' . $temp_count]['value'] = $fields['ivr_menu_no'] . ',1,Goto(timeCondition-' . $subRowTimeCondition['name'] . '-' . $fields['comp_name'] . ',s,1)';
                $this->class_fields[$count]['timecondition' . $temp_count]['operator'] = ' => ';


            } elseif ($fields['dst_option_id'] == 9) {

                if ($fields['dst_option_sub_id'] == '1') {

                    $forwardResult = $this->getExtensionById($fields['DSTOption']);
                    $forwardRow = $forwardResult['rs']->fetch();

                    $this->class_fields[$count]['ForwardI' . $temp_count]['key'] = 'exten';
                    $this->class_fields[$count]['ForwardI' . $temp_count]['value'] = 's,n,Goto(internaldial-' . $fields['comp_name'] . ',' . $forwardRow['extension_no'] . ',1)';
                    $this->class_fields[$count]['ForwardI' . $temp_count]['operator'] = ' => ';

                } else if ($fields['dst_option_sub_id'] == '2') {

                    $this->class_fields[$count]['ForwardE' . $temp_count]['key'] = 'exten';
                    $this->class_fields[$count]['ForwardE' . $temp_count]['value'] = 's,n,Goto(outpattern-' . $fields['comp_name'] . ',' . $this->getFristOutboundPrefix() . $fields['DSTOption'] . ',1)';
                    $this->class_fields[$count]['ForwardE' . $temp_count]['operator'] = ' => ';

                } else {

                    die("Destination of Inbound has error");

                }

            } elseif ($fields['dst_option_id'] == 10) {

                die("Check Destination id 10");
                $this->class_fields[$count]['email' . $temp_count]['key'] = 'exten';
                $this->class_fields[$count]['email' . $temp_count]['value'] = $did_cid . ',1,Set(email=' . $fields['dst_option_sub_id'] . ')';
                $this->class_fields[$count]['email' . $temp_count]['operator'] = ' => ';

                $this->class_fields[$count]['FAX-recive' . $temp_count]['key'] = 'exten';
                $this->class_fields[$count]['FAX-recive' . $temp_count]['value'] = $did_cid . ',n,Goto(FAX-recive-' . $fields['comp_name'] . ',s,1)';
                $this->class_fields[$count]['FAX-recive' . $temp_count]['operator'] = ' => ';
            } elseif ($fields['dst_option_id'] == 14) {

            $this->class_fields[$count]['email' . $temp_count]['key'] = 'exten55';
            $this->class_fields[$count]['email' . $temp_count]['value'] =  ',1,Set(email=' . $fields['dst_option_sub_id'] . ')';
            $this->class_fields[$count]['email' . $temp_count]['operator'] = ' => ';

            $this->class_fields[$count]['FAX-recive' . $temp_count]['key'] = 'exten';
            $this->class_fields[$count]['FAX-recive' . $temp_count]['value'] =  ',n,Goto(FAX-recive-' . $fields['comp_name'] . ',s,1)';
            $this->class_fields[$count]['FAX-recive' . $temp_count]['operator'] = ' => ';
        } else  {

                die("Destination of Inbound has error");

            }

            $temp_count++;
        }

        $count++;

        return $count;


    }

    function setFieldsOutpattern($array_fields, $defaultConfig, $count)
    {

        $temp_count = 1;
        $count++;

        $temp_count = 1;
        foreach ($array_fields as $key => $fields) {

            $comp_name = $fields['comp_name'];
            $outbound_name = $fields['outbound_name'];

            if ($temp_count == 1) {
                $this->class_fields[$count]['context_company_out' . $temp_count]['key'] = '[outpattern-' . $comp_name . ']';
                $this->class_fields[$count]['context_company_out' . $temp_count]['value'] = '';

                $this->class_fields[$count][$temp_count . 'foo']['key'] = ';exten';
                $this->class_fields[$count][$temp_count . 'foo']['value'] = '_X.,1,Set(foo=${CALLERID(num)})';
                $this->class_fields[$count][$temp_count . 'foo']['operator'] = ' => ';

                $this->class_fields[$count][$temp_count . 'CALLERID']['key'] = ';exten';
                $this->class_fields[$count][$temp_count . 'CALLERID']['value'] = '_X.,n,Set(CALLERID(num)=${CUT(foo,,1)})';
                $this->class_fields[$count][$temp_count . 'CALLERID']['operator'] = ' => ';

            }

            $this->class_fields[$count]['include' . $temp_count]['key'] = 'include';
            $this->class_fields[$count]['include' . $temp_count]['value'] = 'outpattern-' . $fields['outbound_name'] . '-' . $comp_name;
            $this->class_fields[$count]['include' . $temp_count]['operator'] = ' => ';


            $temp_count++;
        }


        $count++;

        return $count;
    }

    /**
     * @param $array_fields
     * @param $defaultConfig
     * @param $count
     * @return mixed
     */
    function setFieldsOutbound($array_fields, $defaultConfig, $count)
    {
        $temp_count = 1;
        $count++;

        $temp_count = 1;
        foreach ($array_fields as $key => $fields) {
            $comp_name = $fields['comp_name'];
            $outbound_name = $fields['outbound_name'];

            $this->class_fields[$count]['context_company_out' . $temp_count]['key'] = '[outpattern-' . $outbound_name . '-' . $comp_name . ']';
            $this->class_fields[$count]['context_company_out' . $temp_count]['value'] = '';

            $prependList = explode(',', $fields['prepend']);
            $prefixList = explode(',', $fields['prefix']);
            $match_patternList = explode(',', $fields['match_pattern']);
            $caller_idList = explode(',', $fields['caller_id']);

            for ($i = 1; $i <= count($prependList) - 2; $i++) {
                $fields['caller_id_append'] = '';
                if ($caller_idList[$i] != '') {
                    $fields['caller_id_append'] = '/' . $caller_idList[$i];
                }

                $countPerfix = strlen($prefixList[$i]);
                /*$this->class_fields[$count]['exten-external_check' . $temp_count . $i]['key'] = 'exten';
                $this->class_fields[$count]['exten-external_check' . $temp_count . $i]['value'] = '_' . $prefixList[$i] . $match_patternList[$i] . $fields['caller_id_append'] . ',1,Set(external_check=1)';
                $this->class_fields[$count]['exten-external_check' . $temp_count . $i]['operator'] = ' => ';*/

                /*$n = "3";
                if ($fields['caller_id_number'] != '') {
                    $this->class_fields[$count]['exten-external_caller_idNumber' . $temp_count . $i]['key'] = 'exten';
                    $this->class_fields[$count]['exten-external_caller_idNumber' . $temp_count . $i]['value'] = '_' . $prefixList[$i] . $match_patternList[$i] . $fields['caller_id_append'] . ',' . $n . ',Set(CALLERID(all)="' . $fields['caller_id_name'] . '" <' . $fields['caller_id_number'] . '>)';
                    $this->class_fields[$count]['exten-external_caller_idNumber' . $temp_count . $i]['operator'] = ' => ';
                    $n = "n";
                }*/

                $this->class_fields[$count]['exten-external_If' . $temp_count . $i]['key'] = 'exten';
                $this->class_fields[$count]['exten-external_If' . $temp_count . $i]['value'] = '_' . $prefixList[$i] . $match_patternList[$i] . $fields['caller_id_append'] . ',1,Execif($["${DB(Ext/${CALLERID(num)}-' . $fields[comp_name] . '/Rec/External)}" = "yes"]?Gosub(record-' . $fields['comp_name'] . ',s,1))';
                $this->class_fields[$count]['exten-external_If' . $temp_count . $i]['operator'] = ' => ';

                /*$this->class_fields[$count]['exten-external_not_record' . $temp_count . $i]['key'] = 'exten';
                $this->class_fields[$count]['exten-external_not_record' . $temp_count . $i]['value'] = '_' . $prefixList[$i] . $match_patternList[$i] . $fields['caller_id_append'] . ',n,Macro(dialout-' . $fields['sip_name'] . '-' . $fields['comp_name'] . ',' . $prependList[$i] . '${EXTEN:' . $countPerfix . '})';
                $this->class_fields[$count]['exten-external_not_record' . $temp_count . $i]['operator'] = ' => ';*/

                foreach ($fields['siptrunk'] as $key => $sip_trunk) {

                    $this->class_fields[$count][$sip_trunk['sip_id'] . $temp_count . $i]['key'] = 'exten';
                    //$this->class_fields[$count][$sip_trunk['sip_id'] . $temp_count . $i]['value'] = '_' . $prefixList[$i] . $match_patternList[$i] . $fields['caller_id_append'] . ',n,Gosub(dialout-' . $sip_trunk['sip_name'] . '-' . $fields['comp_name'] . ',' . $prependList[$i] . 's,1(${EXTEN:' . $countPerfix . '}))';
                    $this->class_fields[$count][$sip_trunk['sip_id'] . $temp_count . $i]['value'] = '_' . $prefixList[$i] . $match_patternList[$i] . $fields['caller_id_append'] . ',n,Gosub(dialout-' . $sip_trunk['sip_name'] . '-' . $fields['comp_name'] .',s,1(${EXTEN:' . $countPerfix . '}))';
                    $this->class_fields[$count][$sip_trunk['sip_id'] . $temp_count . $i]['operator'] = ' => ';

                }

            }

            $this->class_fields[$count]['custome' . $temp_count]['key'] = 'include';
            $this->class_fields[$count]['custome' . $temp_count]['value'] = 'outpattern-' . $outbound_name . '-' . $comp_name . '-custome';
            $this->class_fields[$count]['custome' . $temp_count]['operator'] = ' => ';
            $temp_count++;
            $count++;
        }

        $count++;

        $temp_count = 1;

        include_once(ROOT_DIR . "component/fileGenerator_sip_trunk.php");
        $tmpSipTrunkObj = new sip_trunk_fileGenerator();

        $rsSipTrunk = $tmpSipTrunkObj->getAllSipInfo($this->comp_id);
        while ($row = $rsSipTrunk['rs']->fetch()) {
            $fieldsSipTrunk[] = $row;
        }

        /*foreach ($fieldsSipTrunk as $key => $fields) {
            $count++;
            $this->class_fields[$count]['record-macro-record-dialout-trunk1' . $temp_count]['key'] = '[macro-record-dialout-' . $fields['sip_name'] . '-' . $fields['comp_name'] . ']';
            $this->class_fields[$count]['record-macro-record-dialout-trunk1' . $temp_count]['value'] = '';



            $this->class_fields[$count]['Macro' . $temp_count]['key'] = 'exten';
            $this->class_fields[$count]['Macro' . $temp_count]['value'] = 's,1,Macro(record-' . $fields['comp_name'] . ',s,1)';
            $this->class_fields[$count]['Macro' . $temp_count]['operator'] = ' => ';

            $this->class_fields[$count]['record-macro-record-s-n-Set1' . $temp_count]['key'] = 'exten';
            $this->class_fields[$count]['record-macro-record-s-n-Set1' . $temp_count]['value'] = 's,1,Set(path=/' . RECORD_PATH . ')';
            $this->class_fields[$count]['record-macro-record-s-n-Set1' . $temp_count]['operator'] = ' => ';

            $this->class_fields[$count]['record-macro-record-s-n-Set2' . $temp_count]['key'] = 'exten';
            $this->class_fields[$count]['record-macro-record-s-n-Set2' . $temp_count]['value'] = 's,n,Set(company=' . $fields['comp_name'] . ')';
            $this->class_fields[$count]['record-macro-record-s-n-Set2' . $temp_count]['operator'] = ' => ';

            $this->class_fields[$count]['exten_set_year' . $temp_count]['key'] = 'exten';
            $this->class_fields[$count]['exten_set_year' . $temp_count]['value'] = 's,n,Set(year=${STRFTIME(${EPOCH},Asia/Tehran,%C%y)})';
            $this->class_fields[$count]['exten_set_year' . $temp_count]['operator'] = ' => ';

            $this->class_fields[$count]['exten_set_month' . $temp_count]['key'] = 'exten';
            $this->class_fields[$count]['exten_set_month' . $temp_count]['value'] = 's,n,Set(month=${STRFTIME(${EPOCH},Asia/Tehran,%m)})';
            $this->class_fields[$count]['exten_set_month' . $temp_count]['operator'] = ' => ';

            $this->class_fields[$count]['exten_set_day' . $temp_count]['key'] = 'exten';
            $this->class_fields[$count]['exten_set_day' . $temp_count]['value'] = 's,n,Set(day=${STRFTIME(${EPOCH},Asia/Tehran,%d)})';
            $this->class_fields[$count]['exten_set_day' . $temp_count]['operator'] = ' => ';

            $this->class_fields[$count]['exten_set_recordpath' . $temp_count]['key'] = 'exten';
            $this->class_fields[$count]['exten_set_recordpath' . $temp_count]['value'] = 's,n,Set(recordpath=/' . RECORD_PATH . '${company}/${year}/${month}/${day})';
            $this->class_fields[$count]['exten_set_recordpath' . $temp_count]['operator'] = ' => ';

            $this->class_fields[$count]['MixMonitor' . $temp_count]['key'] = 'exten';
            $this->class_fields[$count]['MixMonitor' . $temp_count]['value'] = 's,n,MixMonitor(${recordpath}/${UNIQUEID}.wav,${CALLERID(dnid)})';
            $this->class_fields[$count]['MixMonitor' . $temp_count]['operator'] = ' => ';

            $this->class_fields[$count]['Dial' . $temp_count]['key'] = 'exten';
            $this->class_fields[$count]['Dial' . $temp_count]['value'] = 's,n,Dial(SIP/${ARG1}@' . $fields['sip_name'] . '-' . $fields['comp_name'] . ')';
            $this->class_fields[$count]['Dial' . $temp_count]['operator'] = ' => ';

            $temp_count++;

        }*/

        $temp_count = 1;

        foreach ($fieldsSipTrunk as $key => $fields) {
            $count++;
            //$this->class_fields[$count]['record-macro-record-dialout-trunk' . $temp_count]['key'] = '[macro-dialout-' . $fields['sip_name'] . '-' . $fields['comp_name'] . ']';
            $this->class_fields[$count]['record-macro-record-dialout-trunk' . $temp_count]['key'] = '[dialout-'.$fields['sip_name'] . '-' . $fields['comp_name'] . ']';
            $this->class_fields[$count]['record-macro-record-dialout-trunk' . $temp_count]['value'] = '';

            $this->class_fields[$count]['Dial' . $temp_count]['key'] = 'exten';
            $this->class_fields[$count]['Dial' . $temp_count]['value'] = 's,1,Dial(SIP/${ARG1}@' . $fields['sip_name'] . '-' . $fields['comp_name'] . ')';
            $this->class_fields[$count]['Dial' . $temp_count]['operator'] = ' => ';
            $temp_count++;

        }
        $count++;

        return $count;
    }

    /**
     * @param $array_fields
     * @param $defaultConfig
     * @param $count
     * @return mixed
     */
    function setFieldsAnnounce($array_fields, $defaultConfig, $count)
    {
        $temp_count = 1;
        $count++;

        foreach ($array_fields as $key => $fields) {
            $temp = array_keys($array_fields);
            $comp_name = $array_fields[$temp[0]]['comp_name'];

            $this->class_fields[$count]['context_company']['key'] = '[announce-' . $fields['announce_name'] . '-' . $comp_name . ']';
            $this->class_fields[$count]['context_company']['value'] = '';

            $this->class_fields[$count]['exten-Answer']['key'] = 'exten';
            $this->class_fields[$count]['exten-Answer']['value'] = 's,1,Set(count=' . $fields['repeat_input'] .')';

            $this->class_fields[$count]['exten-Answer']['operator'] = ' => ';

            $this->class_fields[$count]['exten-Answer-Answer']['key'] = 'exten';
            $this->class_fields[$count]['exten-Answer-Answer']['value'] = 's,n,Answer';
            $this->class_fields[$count]['exten-Answer-Answer']['operator'] = ' => ';

            $this->class_fields[$count]['exten-play']['key'] = 'exten';
            $this->class_fields[$count]['exten-play']['value'] = 's,n(play),Background(' . UPLOAD_IVR_ROOT . $fields['comp_id'] . DS . $fields['upload_id'] . ')';
            $this->class_fields[$count]['exten-play']['operator'] = ' => ';

            $this->class_fields[$count]['exten-play-count']['key'] = 'exten';
            $this->class_fields[$count]['exten-play-count']['value'] = 's,n,Set(count=$[${count} - 1])';
            $this->class_fields[$count]['exten-play-count']['operator'] = ' => ';

            $this->class_fields[$count]['exten-play-if']['key'] = 'exten';
            $this->class_fields[$count]['exten-play-if']['value'] = 's,n,GotoIf($["${count}" = "0"]?continue:play)';
            $this->class_fields[$count]['exten-play-if']['operator'] = ' => ';

            /*if ($fields['dst_option_id'] == 1) {
                $conn = parent::getConnection();

                $sql = "
                             SELECT
                              `tbl_sip`.* FROM `tbl_sip`
                             WHERE
                                `tbl_sip`.`sip_id` = '" . $fields['dst_option_sub_id'] . "' ";

                $stmt_sipTrunk = $conn->prepare($sql);
                $stmt_sipTrunk->setFetchMode(PDO::FETCH_ASSOC);
                $stmt_sipTrunk->execute();

                if (!$stmt_sipTrunk) {
                    $result['result'] = -1;
                    $result['no'] = 1;
                    $result['msg'] = $conn->errorInfo();
                    return $result;
                }

                $result['result'] = 1;
                $subRowSipTrunk = $stmt_sipTrunk->fetch();

                $this->class_fields[$count]['SipTrunk' . $temp_count]['key'] = 'exten';
                $this->class_fields[$count]['SipTrunk' . $temp_count]['value']
                    = 's,n(continue),Dial(SIP/@' . $subRowSipTrunk['sip_name'] . '-' . $fields['comp_name'] . ')';
                $this->class_fields[$count]['SipTrunk' . $temp_count]['operator'] = ' => ';

            } */
            if ($fields['dst_option_id'] == 2) {
                $conn = parent::getConnection();
                $sql = "
                             SELECT
                              `tbl_queue`.* FROM `tbl_queue`
                             WHERE
                                `tbl_queue`.`queue_id` = '" . $fields['dst_option_sub_id'] . "' ";

                $stmt_queue = $conn->prepare($sql);
                $stmt_queue->setFetchMode(PDO::FETCH_ASSOC);
                $stmt_queue->execute();

                if (!$stmt_queue) {
                    $result['result'] = -1;
                    $result['no'] = 1;
                    $result['msg'] = $conn->errorInfo();
                    return $result;
                }
                $result['result'] = 1;
                $subRowSip = $stmt_queue->fetch();

                /*$this->class_fields[$count]['Queue' . $temp_count . '-Answer']['key'] = ';exten';
                $this->class_fields[$count]['Queue' . $temp_count . '-Answer']['value'] = 's,n(continue),Answer()';
                $this->class_fields[$count]['Queue' . $temp_count . '-Answer']['operator'] = ' => ';

                if ($subRowSip['max_wait_time'] == '') {
                    $subRowSip['max_wait_time'] = 60;
                }

                if ($subRowSip['instead'] == '1') {
                    $instead = 'r';
                } else {
                    $instead = '';
                }

                $this->class_fields[$count]['Queue' . $temp_count]['key'] = ';exten';
                $this->class_fields[$count]['Queue' . $temp_count]['value']
                    = 's,n,Queue(' . $subRowSip['queue_name'] . '-' . $fields['comp_name'] . ',' . $instead . ',,,' . $subRowSip['max_wait_time'] . ')';
                $this->class_fields[$count]['Queue' . $temp_count]['operator'] = ' => ';



                $result = $this->queueDstOption($subRowSip, $count, $temp_count, 'announce', $fields);*/

                $this->class_fields[$count]['Queue2' . $temp_count]['key'] = 'exten';
                $this->class_fields[$count]['Queue2' . $temp_count]['value']
                    = 's,n(continue),Goto(queue-' . $fields['comp_name'] . ',' . $subRowSip['queue_ext_no'] . ',1)';
                $this->class_fields[$count]['Queue2' . $temp_count]['operator'] = ' => ';


            } elseif ($fields['dst_option_id'] == 3 and $fields['dst_option_sub_id'] != '0') {
                $conn = parent::getConnection();

                $sql = "
                              SELECT
                                `tbl_extension`.* FROM `tbl_extension`
                              WHERE
                                `tbl_extension`.`extension_id` = '" . $fields['dst_option_sub_id'] . "' ";

                $stmt_extension = $conn->prepare($sql);
                $stmt_extension->setFetchMode(PDO::FETCH_ASSOC);
                $stmt_extension->execute();

                if (!$stmt_extension) {
                    $result['result'] = -1;
                    $result['no'] = 1;
                    $result['msg'] = $conn->errorInfo();
                    return $result;
                }

                $result['result'] = 1;
                $subRowSip = $stmt_extension->fetch();

                /*if ($subRowSip['ring_number'] == '' or strlen($subRowSip['ring_number']) == 0) {
                    $subRowSip['ring_number'] = '7';
                }

                $ring_time = ONE_RING_TIME * $subRowSip['ring_number'];*/


                $this->class_fields[$count]['extension_t' . $temp_count]['key'] = 'exten';
                $this->class_fields[$count]['extension_t' . $temp_count]['value'] = 's,n(continue),Goto(internaldial-' . $fields['comp_name'] . ',' . $subRowSip['extension_no'] . ',1)';
                $this->class_fields[$count]['extension_t' . $temp_count]['operator'] = ' => ';

                //DNA: che niazi bode be in...!?!?!?!?!?
                /*if ($subRowSip['voicemail_status'] == '1') {

                    $this->class_fields[$count]['DIALSTATUS' . $temp_count]['key'] = 'exten';
                    $this->class_fields[$count]['DIALSTATUS' . $temp_count]['value'] = 's,n,Gotoif($[${DIALSTATUS}=CHANUNAVAIL | BUSY | NOANSWER]?next:hangup)';
                    $this->class_fields[$count]['DIALSTATUS' . $temp_count]['operator'] = ' => ';

                    $this->class_fields[$count]['VoiceMail' . $temp_count]['key'] = 'exten';
                    $this->class_fields[$count]['VoiceMail' . $temp_count]['value'] = 's,n(next),VoiceMail(' . $subRowSip['extension_no'] . '@voiceMail-' . $fields['comp_name'] . ')';
                    $this->class_fields[$count]['VoiceMail' . $temp_count]['operator'] = ' => ';

                    $this->class_fields[$count]['VoiceMail_exten' . $temp_count]['key'] = 'exten';
                    $this->class_fields[$count]['VoiceMail_exten' . $temp_count]['value'] = 's,n,Set(voicemailfile=${VM_MESSAGEFILE})';
                    $this->class_fields[$count]['VoiceMail_exten' . $temp_count]['operator'] = ' => ';

                    $this->class_fields[$count]['VoiceMail_exten1' . $temp_count]['key'] = 'exten';
                    $this->class_fields[$count]['VoiceMail_exten1' . $temp_count]['value'] = 's,n,System(cp ${voicemailfile}.wav /' . VOICEMAIL_PATH . '${UNIQUEID}.wav)';
                    $this->class_fields[$count]['VoiceMail_exten1' . $temp_count]['operator'] = ' => ';

                }

                $this->class_fields[$count]['ivr' . $temp_count]['key'] = 'exten';
                $this->class_fields[$count]['ivr' . $temp_count]['value'] = 's,n(hangup),Hangup()';
                $this->class_fields[$count]['ivr' . $temp_count]['operator'] = ' => ';*/

            } elseif ($fields['dst_option_id'] == 4 and $fields['dst_option_sub_id'] != '0') {
                $conn = parent::getConnection();

                $sql = "
                              SELECT
                                `tbl_announce`.* FROM `tbl_announce`
                              WHERE
                                `tbl_announce`.`announce_id` = '" . $fields['dst_option_sub_id'] . "' ";

                $stmt_announce = $conn->prepare($sql);
                $stmt_announce->setFetchMode(PDO::FETCH_ASSOC);
                $stmt_announce->execute();

                if (!$stmt_announce) {
                    $result['result'] = -1;
                    $result['no'] = 1;
                    $result['msg'] = $conn->errorInfo();
                    return $result;
                }

                $result['result'] = 1;
                $subRowAnnounce = $stmt_announce->fetch();


                $this->class_fields[$count]['extension_t' . $temp_count]['key'] = 'exten';
                $this->class_fields[$count]['extension_t' . $temp_count]['value'] =
                    's,n(continue),Goto(announce-' . $subRowAnnounce['announce_name'] . '-' . $fields['comp_name'] . ',s,1)';
                $this->class_fields[$count]['extension_t' . $temp_count]['operator'] = ' => ';

            } elseif ($fields['dst_option_id'] == 5) {
                $conn = parent::getConnection();

                $sql = "
                    SELECT
                    *
                    FROM
                      `tbl_ivr`
                    WHERE
                      `tbl_ivr`.`ivr_id` ='" . $fields['dst_option_sub_id'] . "' ";

                $stmt_ivr = $conn->prepare($sql);
                $stmt_ivr->setFetchMode(PDO::FETCH_ASSOC);
                $stmt_ivr->execute();

                if (!$stmt_ivr) {
                    $result['result'] = -1;
                    $result['no'] = 1;
                    $result['msg'] = $conn->errorInfo();
                    return $result;
                }

                $result['result'] = 1;
                $subRowIvr = $stmt_ivr->fetch();

                $this->class_fields[$count]['ivr' . $temp_count]['key'] = 'exten';
                $this->class_fields[$count]['ivr' . $temp_count]['value'] =
                    's,n(continue),Goto(ivr-' . $subRowIvr['ivr_name'] . '-' . $fields['comp_name'] . ',s,1)';
                $this->class_fields[$count]['ivr' . $temp_count]['operator'] = ' => ';


            } elseif ($fields['dst_option_id'] == 6) {
                $conn = parent::getConnection();

                $sql = "
                              SELECT
                                `tbl_extension`.* FROM `tbl_extension`
                              WHERE
                                `tbl_extension`.`extension_id` = '" . $fields['dst_option_sub_id'] . "' ";

                $stmt_extension = $conn->prepare($sql);
                $stmt_extension->setFetchMode(PDO::FETCH_ASSOC);
                $stmt_extension->execute();

                if (!$stmt_extension) {
                    $result['result'] = -1;
                    $result['no'] = 1;
                    $result['msg'] = $conn->errorInfo();
                    return $result;
                }

                $result['result'] = 1;
                $subRowSip = $stmt_extension->fetch();

                if ($subRowSip['extension_no'] != '') {


                    //

                    $this->class_fields[$count]['VoiceMail' . $temp_count]['key'] = 'exten';
                    $this->class_fields[$count]['VoiceMail' . $temp_count]['value'] =
                        's,n(continue),Macro(VoicemailPlay-' . $fields['comp_name'] . ',noMSG,' . $subRowSip['extension_no'] . ')';
                    $this->class_fields[$count]['VoiceMail' . $temp_count]['operator'] = ' => ';

                    /*$this->class_fields[$count]['VoiceMail' . $temp_count]['key'] = 'exten';
                    $this->class_fields[$count]['VoiceMail' . $temp_count]['value'] =
                        's,n(continue),VoiceMail(' . $subRowSip['extension_no'] . '@voiceMail-' . $fields['comp_name'] . ')';
                    $this->class_fields[$count]['VoiceMail' . $temp_count]['operator'] = ' => ';

                    $this->class_fields[$count]['VoiceMail_exten' . $temp_count]['key'] = 'exten';
                    $this->class_fields[$count]['VoiceMail_exten' . $temp_count]['value'] = 's,n,Set(voicemailfile=${VM_MESSAGEFILE})';
                    $this->class_fields[$count]['VoiceMail_exten' . $temp_count]['operator'] = ' => ';

                    $this->class_fields[$count]['VoiceMail_exten1' . $temp_count]['key'] = 'exten';
                    $this->class_fields[$count]['VoiceMail_exten1' . $temp_count]['value'] = 's,n,System(cp ${voicemailfile}.wav /' . VOICEMAIL_PATH . '${UNIQUEID}.wav)';
                    $this->class_fields[$count]['VoiceMail_exten1' . $temp_count]['operator'] = ' => ';

                    $this->class_fields[$count]['VoiceMail_exten2' . $temp_count]['key'] = 'exten';
                    $this->class_fields[$count]['VoiceMail_exten2' . $temp_count]['value'] = 's,n,Hangup()';
                    $this->class_fields[$count]['VoiceMail_exten2' . $temp_count]['operator'] = ' => ';*/
                }

            } elseif ($fields['dst_option_id'] == 7) {
                $this->class_fields[$count]['Hangup1' . $temp_count]['key'] = 'exten';
                $this->class_fields[$count]['Hangup1' . $temp_count]['value'] = 's,n(continue),Hangup()';
                $this->class_fields[$count]['Hangup1' . $temp_count]['operator'] = ' => ';
            } elseif ($fields['dst_option_id'] == 8) {

                $conn = parent::getConnection();

                $sql = "
                        SELECT
                            `main_time_condition`.`name`
                        FROM `main_time_condition`
                        WHERE `main_time_condition`.`id` = '" . $fields['dst_option_sub_id'] . "' ";

                $stmt_TimeCondition = $conn->prepare($sql);
                $stmt_TimeCondition->setFetchMode(PDO::FETCH_ASSOC);
                $stmt_TimeCondition->execute();

                if (!$stmt_TimeCondition) {
                    $result['result'] = -1;
                    $result['no'] = 1;
                    $result['msg'] = $conn->errorInfo();
                    return $result;
                }

                $result['result'] = 1;
                $subRowTimeCondition = $stmt_TimeCondition->fetch();

                $this->class_fields[$count]['timecondition' . $temp_count]['key'] = 'exten';
                $this->class_fields[$count]['timecondition' . $temp_count]['value'] = 's,n(continue),Goto(timeCondition-' . $subRowTimeCondition['name'] . '-' . $fields['comp_name'] . ',s,1)';
                $this->class_fields[$count]['timecondition' . $temp_count]['operator'] = ' => ';

            } elseif ($fields['dst_option_id'] == 9) {

                if ($fields['dst_option_sub_id'] == '1') {

                    $forwardResult = $this->getExtensionById($fields['DSTOption']);
                    $forwardRow = $forwardResult['rs']->fetch();

                    $this->class_fields[$count]['ForwardI' . $temp_count]['key'] = 'exten';
                    $this->class_fields[$count]['ForwardI' . $temp_count]['value'] = 's,n(continue),Goto(internaldial-' . $comp_name . ',' . $forwardRow['extension_no'] . ',1)';
                    $this->class_fields[$count]['ForwardI' . $temp_count]['operator'] = ' => ';

                } else if ($fields['dst_option_sub_id'] == '2') {


                    $this->class_fields[$count]['ForwardE' . $temp_count]['key'] = 'exten';
                    $this->class_fields[$count]['ForwardE' . $temp_count]['value'] = 's,n(continue),Goto(outpattern-' . $comp_name . ',' . $this->getFristOutboundPrefix() . $fields['DSTOption'] . ',1)';
                    $this->class_fields[$count]['ForwardE' . $temp_count]['operator'] = ' => ';

                } else {

                    die("Destination of announcement has error");

                }

            } else {

                die("Destination of announcement has error");

            }


            $temp_count++;
            $count++;
        }

        return $count;
    }

    /**
     * @param $array_fields
     * @param $defaultConfig
     * @return int
     */
    function setFieldsExtensionDialDestination($array_fields, $defaultConfig, $count)
    {
        $count++;
        $temp = array_keys($array_fields);
        $comp_name = $array_fields[$temp[0]]['comp_name'];

        $this->class_fields[$count]['feature-codes']['key'] = '[extension-DST-' . $comp_name . ']';
        $this->class_fields[$count]['feature-codes']['value'] = '';

        $temp_count = 1;

        $this->class_fields[$count]['NoOp' . $temp_count]['key'] = 'exten';
        $this->class_fields[$count]['NoOp' . $temp_count]['value'] = 's,1,NoOp()';
        $this->class_fields[$count]['NoOp' . $temp_count]['operator'] = ' => ';


        foreach ($array_fields as $key => $fields) {

            /*if ($temp_count == 1) {
                $sign = '1';
            } else {
                $sign = 'n';
            }*/


            if ($fields['dst_option_id'] == '12') {

                $timeConditionsDetail = $this->getExtensionTimeConditionByExtensionID($fields['dst_option_sub_id'])['rs']->fetch();
                $timeExteName = 'timeCondition-extension-' . $timeConditionsDetail['name'] . '-' . $fields['extension_no'] . '-' . $fields['comp_name'];

                $this->class_fields[$count]['exten_' . $temp_count]['key'] = 'exten';
                $this->class_fields[$count]['exten_' . $temp_count]['value'] = 's,n,GotoIf($["${CALLERID(dnid)}" = "' . $fields['extension_no'] . '" | " ${CALLERID(dnid)}" = "' . $fields['extension_no'] . '-' . $fields['comp_name'] . '"]?' . $timeExteName . ',s,1)';
                $this->class_fields[$count]['exten_' . $temp_count]['operator'] = ' => ';

            } elseif ($fields['dst_option_id'] == '9') {

                $this->class_fields[$count]['exten_' . $temp_count]['key'] = 'exten';
                $this->class_fields[$count]['exten_' . $temp_count]['operator'] = ' => ';

                if ($fields['dst_option_sub_id'] == '1') {

                    $this->class_fields[$count]['exten_' . $temp_count]['value'] = 's,n,GotoIf($["${CALLERID(dnid)}" = "' . $fields['extension_no'] . '" | " ${CALLERID(dnid)}" = "' . $fields['extension_no'] . '-' . $fields['comp_name'] . '"]?Finternal)';

                } elseif ($fields['dst_option_sub_id'] == '2') {

                    $this->class_fields[$count]['exten_' . $temp_count]['value'] = 's,n,GotoIf($["${CALLERID(dnid)}" = "' . $fields['extension_no'] . '" | " ${CALLERID(dnid)}" = "' . $fields['extension_no'] . '-' . $fields['comp_name'] . '"]?Fexternal)';
                }

            } elseif ($fields['dst_option_id'] == '6') {

                $this->class_fields[$count]['exten_' . $temp_count]['key'] = 'exten';
                $this->class_fields[$count]['exten_' . $temp_count]['value'] = 's,n,GotoIf($["${CALLERID(dnid)}" = "' . $fields['extension_no'] . '" | " ${CALLERID(dnid)}" = "' . $fields['extension_no'] . '-' . $fields['comp_name'] . '"]?vm)';
                $this->class_fields[$count]['exten_' . $temp_count]['operator'] = ' => ';

            } elseif ($fields['dst_option_id'] == '10') {
                continue;
            } elseif ($fields['dst_option_id'] == '4') {

                $announcDetail = $this->getAnnounceById($fields['dst_option_sub_id'])['rs']->fetch();
                $announceContex = 'announce-' . $announcDetail['announce_name'] . '-' . $fields['comp_name'];
                $this->class_fields[$count]['exten_' . $temp_count]['key'] = 'exten';
                $this->class_fields[$count]['exten_' . $temp_count]['value'] = 's,n,GotoIf($["${CALLERID(dnid)}" = "' . $fields['extension_no'] . '" | " ${CALLERID(dnid)}" = "' . $fields['extension_no'] . '-' . $fields['comp_name'] . '"]?' . $announceContex . ',s,1)';
                $this->class_fields[$count]['exten_' . $temp_count]['operator'] = ' => ';

            } elseif (($fields['dst_option_id'] == '7')) {

                $this->class_fields[$count]['exten_' . $temp_count]['key'] = 'exten';
                $this->class_fields[$count]['exten_' . $temp_count]['value'] = 's,n,GotoIf($["${CALLERID(dnid)}" = "' . $fields['extension_no'] . '" | " ${CALLERID(dnid)}" = "' . $fields['extension_no'] . '-' . $fields['comp_name'] . '"]?hangup)';
                $this->class_fields[$count]['exten_' . $temp_count]['operator'] = ' => ';

            } else {


                die("Check DST id in Success DST of Extension");

            }

            $temp_count++;
        }

        $this->class_fields[$count]['feature-codes1' . $temp_count]['key'] = 'exten';
        $this->class_fields[$count]['feature-codes1' . $temp_count]['value'] = 's,n,GotoIf($["${DB(Ext/${CALLERID(dnid)}-' . $fields['comp_name'] . '/DND)}" = "yes"]?dnd)';
        $this->class_fields[$count]['feature-codes1' . $temp_count]['operator'] = ' => ';
        $temp_count++;

        $this->class_fields[$count]['feature-codes1' . $temp_count]['key'] = 'exten';
        $this->class_fields[$count]['feature-codes1' . $temp_count]['value'] = 's,n,Return()';
        $this->class_fields[$count]['feature-codes1' . $temp_count]['operator'] = ' => ';
        $temp_count++;


        $this->class_fields[$count]['feature-codes1' . $temp_count]['key'] = 'exten';
        $this->class_fields[$count]['feature-codes1' . $temp_count]['value'] = 's,n(vm),Gosub(VoicemailPlay-' . $fields['comp_name'] . ',s,1(noMSG,${CALLERID(dnid)}))';
        $this->class_fields[$count]['feature-codes1' . $temp_count]['operator'] = ' => ';
        $temp_count++;

        $this->class_fields[$count]['feature-codes1' . $temp_count]['key'] = 'exten';
        $this->class_fields[$count]['feature-codes1' . $temp_count]['value'] = 's,n(Fexternal),Goto(outpattern-' . $fields['comp_name'] . ',' . $this->getFristOutboundPrefix() . '${DB(Ext/${CALLERID(dnid)}-' . $fields['comp_name'] . '/Dst/Fexternal)},1)';
        $this->class_fields[$count]['feature-codes1' . $temp_count]['operator'] = ' => ';
        $temp_count++;


        $this->class_fields[$count]['feature-codes1' . $temp_count]['key'] = 'exten';
        $this->class_fields[$count]['feature-codes1' . $temp_count]['value'] = 's,n(Finternal),Goto(internaldial-' . $fields['comp_name'] . ',${DB(Ext/${CALLERID(dnid)}-' . $fields['comp_name'] . '/Dst/Finternal)},1)';
        $this->class_fields[$count]['feature-codes1' . $temp_count]['operator'] = ' => ';
        $temp_count++;


        /*$this->class_fields[$count]['feature-codes1' . $temp_count]['key'] = 'exten';
        $this->class_fields[$count]['feature-codes1' . $temp_count]['value'] = 's,n,Set(CALLERID(dnid)=${DB(Ext/${dst}-' . $fields['comp_name'] . '/Dst/Finternal)})';
        $this->class_fields[$count]['feature-codes1' . $temp_count]['operator'] = ' => ';
        $temp_count++;

        $this->class_fields[$count]['feature-codes1' . $temp_count]['key'] = 'exten';
        $this->class_fields[$count]['feature-codes1' . $temp_count]['value'] = 's,n,Goto(${DB(Ext/${dst}-' . $fields['comp_name'] . '/Dst/Finternal)},1)';
        $this->class_fields[$count]['feature-codes1' . $temp_count]['operator'] = ' => ';
        $temp_count++;*/

        $this->class_fields[$count]['feature-codes1' . $temp_count]['key'] = 'exten';
        $this->class_fields[$count]['feature-codes1' . $temp_count]['value'] = 's,n(dnd),Playback(do-not-disturb)';
        $this->class_fields[$count]['feature-codes1' . $temp_count]['operator'] = ' => ';
        $temp_count++;

        $this->class_fields[$count]['feature-codes1' . $temp_count]['key'] = 'exten';
        $this->class_fields[$count]['feature-codes1' . $temp_count]['value'] = 's,n(hangup),Hangup()';
        $this->class_fields[$count]['feature-codes1' . $temp_count]['operator'] = ' => ';
        $temp_count++;

        $this->class_fields[$count]['custome' . $temp_count]['key'] = 'include';
        $this->class_fields[$count]['custome' . $temp_count]['value'] = 'extension-DST-' . $comp_name . '-custome';
        $this->class_fields[$count]['custome' . $temp_count]['operator'] = ' => ';
        $temp_count++;


        $count++;

        return $count++;
    }


    function setFieldsSip($array_fields, $defaultConfig)
    {
        $count = 0;



        $temp = array_keys($array_fields);
        $comp_name = $array_fields[$temp[0]]['comp_name'];

        $this->class_fields[$count]['context_company']['key'] = '[context-' . $comp_name . ']';
        $this->class_fields[$count]['context_company']['value'] = '';



        $this->class_fields[$count]['queue']['key'] = 'include';
        $this->class_fields[$count]['queue']['value'] = 'queue-' . $comp_name;
        $this->class_fields[$count]['queue']['operator'] = ' => ';

        $this->class_fields[$count]['feature-codes']['key'] = 'include';
        $this->class_fields[$count]['feature-codes']['value'] = 'feature-codes-' . $comp_name;
        $this->class_fields[$count]['feature-codes']['operator'] = ' => ';


        $this->class_fields[$count]['Confbridge']['key'] = 'include';
        $this->class_fields[$count]['Confbridge']['value'] = 'Confbridge-' . $comp_name;
        $this->class_fields[$count]['Confbridge']['operator'] = ' => ';

        $this->class_fields[$count]['internaldial']['key'] = 'include';
        $this->class_fields[$count]['internaldial']['value'] = 'internaldial-' . $comp_name;
        $this->class_fields[$count]['internaldial']['operator'] = ' => ';

        $this->class_fields[$count]['outpattern']['key'] = 'include';
        $this->class_fields[$count]['outpattern']['value'] = 'outpattern-' . $comp_name;
        $this->class_fields[$count]['outpattern']['operator'] = ' => ';

        $this->class_fields[$count]['wrongNumber']['key'] = 'include';
        $this->class_fields[$count]['wrongNumber']['value'] = 'wrongNumber-' . $comp_name;
        $this->class_fields[$count]['wrongNumber']['operator'] = ' => ';


        $this->class_fields[$count]['Confbridgecustome']['key'] = 'include';
        $this->class_fields[$count]['Confbridgecustome']['value'] = 'context-' . $comp_name . 'custome';
        $this->class_fields[$count]['Confbridgecustome']['operator'] = ' => ';
        //$count++;

        /*$this->class_fields[$count]['check-record']['key'] = '[check-record-' . $comp_name . ']';
        $this->class_fields[$count]['check-record']['value'] = '';*/


        //success dst
        /*$this->class_fields[$count]['exten_' . 1]['key'] = 'exten';
        $this->class_fields[$count]['exten_' . 1]['value'] = '_X.,' . 1 . ',GotoIf($["${CALLERID(number)}" = "' . $fields['extension_no'] . '" | "${CALLERID(number)}" = "' . $fields['extension_no'] . '-' . $fields['comp_name'] . '"]?record-internaldial' . '-' . $fields['comp_name'] . ',${CALLERID(dnid)},1)';
        $this->class_fields[$count]['exten_' . 1]['operator'] = ' => ';*/
        //end success dst


        //$temp_count = 1;

        /*foreach ($array_fields as $key => $fields) {
            if ($fields['internal_recording'] == '0') {
                continue;
            }

            if ($temp_count == 1) {
                $sign = '1';
            } else {
                $sign = 'n';
            }

            $this->class_fields[$count]['exten_' . $temp_count]['key'] = 'exten';
            $this->class_fields[$count]['exten_' . $temp_count]['value'] = '_X.,' . $sign . ',GotoIf($["${CALLERID(number)}" = "' . $fields['extension_no'] . '" | "${CALLERID(number)}" = "' . $fields['extension_no'] . '-' . $fields['comp_name'] . '"]?record-internaldial' . '-' . $fields['comp_name'] . ',${CALLERID(dnid)},1)';

            $this->class_fields[$count]['exten_' . $temp_count]['operator'] = ' => ';
            $temp_count++;
        }*/

        /*$this->class_fields[$count]['exten_' . $temp_count]['key'] = 'exten';
        $this->class_fields[$count]['exten_' . $temp_count]['value'] = '_X.,n,Goto(internaldial-' . $comp_name . ',${CALLERID(dnid)},1)';
        $this->class_fields[$count]['exten_' . $temp_count]['operator'] = ' => ';*/


        //**************************Internal Dial**************************
        /*$count++;
        $this->class_fields[$count]['internaldial']['key'] = '[internaldial-' . $comp_name . ']';
        $this->class_fields[$count]['internaldial']['value'] = '';*/

        /*
        | ---------------------------------------------------------------------------------------------
        | inja bayad if bezarim onayi ke tik voice mail nakhorde  bod
        | ---------------------------------------------------------------------------------------------
        */
        //$temp_count = 1;

        /*foreach ($array_fields as $key => $fields) {
            if ($fields['ring_number'] == '' or strlen($fields['ring_number']) == 0) {
                $fields['ring_number'] = '7';
            }


            $this->class_fields[$count]['exten_set_ring_time_' . $temp_count]['key'] = 'exten';
            $this->class_fields[$count]['exten_set_ring_time_' . $temp_count]['value'] = $fields['extension_no'] . ',1,Set(ringTime=' . $fields['ring_number'] * ONE_RING_TIME . ')';
            $this->class_fields[$count]['exten_set_ring_time_' . $temp_count]['operator'] = ' => ';

            $this->class_fields[$count]['exten_ringTime_' . $temp_count]['key'] = 'exten';
            $this->class_fields[$count]['exten_ringTime_' . $temp_count]['value'] = $fields['extension_no'] . ',n,Set(__PICKUPMARK=' . $fields['extension_no'] . '-' . $fields['comp_name'] . ')';
            $this->class_fields[$count]['exten_ringTime_' . $temp_count]['operator'] = ' => ';

            $this->class_fields[$count]['dnid' . $temp_count]['key'] = 'exten';
            $this->class_fields[$count]['dnid' . $temp_count]['value'] = $fields['extension_no'] . ',n,Set(CALLERID(dnid)=${EXTEN})';
            $this->class_fields[$count]['dnid' . $temp_count]['operator'] = ' => ';

            $this->class_fields[$count]['exten_internal_Dial_' . $temp_count]['key'] = 'exten';
            $this->class_fields[$count]['exten_internal_Dial_' . $temp_count]['value'] = $fields['extension_no'] . ',n,Goto(s,1)';
            $this->class_fields[$count]['exten_internal_Dial_' . $temp_count]['operator'] = ' => ';
            $temp_count++;
        }

        $this->class_fields[$count]['Dial']['key'] = 'exten';
        $this->class_fields[$count]['Dial']['value'] = 's,1,Dial(Sip/${CALLERID(dnid)}-' . $fields['comp_name'] . ',${ringTime})';
        $this->class_fields[$count]['Dial']['operator'] = ' => ';

        $this->class_fields[$count]['MailboxExists']['key'] = 'exten';
        $this->class_fields[$count]['MailboxExists']['value'] = 's,n,MailboxExists(${CALLERID(dnid)}@voiceMail-' . $fields['comp_name'] . ')';
        $this->class_fields[$count]['MailboxExists']['operator'] = ' => ';

        $this->class_fields[$count]['VMBOXEXISTSSTATUS']['key'] = 'exten';
        $this->class_fields[$count]['VMBOXEXISTSSTATUS']['value'] = 's,n,GotoIf($["${VMBOXEXISTSSTATUS}" = "SUCCESS"]?exists)';
        $this->class_fields[$count]['VMBOXEXISTSSTATUS']['operator'] = ' => ';

        $this->class_fields[$count]['is-curntly-busy']['key'] = 'exten';
        $this->class_fields[$count]['is-curntly-busy']['value'] = 's,n,Playback(is-curntly-busy)';
        $this->class_fields[$count]['is-curntly-busy']['operator'] = ' => ';

        $this->class_fields[$count]['hangup']['key'] = 'exten';
        $this->class_fields[$count]['hangup']['value'] = 's,n(hangup),Hangup()';
        $this->class_fields[$count]['hangup']['operator'] = ' => ';

        $this->class_fields[$count]['DIALSTATUS']['key'] = 'exten';
        $this->class_fields[$count]['DIALSTATUS']['value'] = 's,n(exists),Gotoif($[${DIALSTATUS}=CHANUNAVAIL | BUSY | NOANSWER]?continue:hangup)';
        $this->class_fields[$count]['DIALSTATUS']['operator'] = ' => ';


        $this->class_fields[$count]['VoiceMail']['key'] = 'exten';
        $this->class_fields[$count]['VoiceMail']['value'] = 's,n(continue),VoiceMail(${CALLERID(dnid)}@voiceMail-' . $fields['comp_name'] . ')';
        $this->class_fields[$count]['VoiceMail']['operator'] = ' => ';
        //[record-internaldial
        $this->class_fields[$count]['VoiceMail_exten']['key'] = 'exten';
        $this->class_fields[$count]['VoiceMail_exten']['value'] = 's,n,Set(voicemailfile=${VM_MESSAGEFILE})';
        $this->class_fields[$count]['VoiceMail_exten']['operator'] = ' => ';

        $this->class_fields[$count]['VoiceMail_exten1']['key'] = 'exten';
        $this->class_fields[$count]['VoiceMail_exten1']['value'] = 's,n,System(cp ${voicemailfile}.wav /' . VOICEMAIL_PATH . '${UNIQUEID}.wav)';
        $this->class_fields[$count]['VoiceMail_exten1']['operator'] = ' => ';

        $this->class_fields[$count]['VoiceMail_exten2']['key'] = 'exten';
        $this->class_fields[$count]['VoiceMail_exten2']['value'] = 's,n,Hangup()';
        $this->class_fields[$count]['VoiceMail_exten2']['operator'] = ' => ';


        $this->class_fields[$count]['outpattern-internaldial' . $count . 'include']['key'] = 'include';
        $this->class_fields[$count]['outpattern-internaldial' . $count . 'include']['value'] ='outpattern-' .$comp_name . ' ';
        $this->class_fields[$count]['outpattern-internaldial' . $count . 'include']['operator'] = ' => ';*/

        /*$Outbound_list = $this->getAllOutboundInfo();
        $list = '';
        $count_out_pattern = 0;

        while ($row = $Outbound_list['rs']->fetch()) {
            $count_out_pattern++;
            $this->class_fields[$count]['outpattern-internaldial' . $count . $count_out_pattern]['key'] = 'include';
            $this->class_fields[$count]['outpattern-internaldial' . $count . $count_out_pattern]['value'] =
                'outpattern-' . $row['outbound_name'] . '-' . $row['comp_name'] . ' ';
            $this->class_fields[$count]['outpattern-internaldial' . $count . $count_out_pattern]['operator'] = ' => ';
        }*/


        $count++;

        $this->class_fields[$count]['Bss']['key'] = 'include';
        $this->class_fields[$count]['Bss']['value'] = 'Bss-Custome-Code';
        $this->class_fields[$count]['Bss']['operator'] = ' => ';


        //$this->class_fields[$count]['record-internaldial']['key'] = '[record-internaldial-' . $comp_name . ']';
        $this->class_fields[$count]['internaldial']['key'] = '[internaldial-' . $comp_name . ']';
        $this->class_fields[$count]['internaldial']['value'] = '';
        $temp_count = 1;


        foreach ($array_fields as $key => $fields) {
            if ($fields['ring_number'] == '' or strlen($fields['ring_number']) == 0) {
                $fields['ring_number'] = '7';
            }


            $faild_DST = "";
            if ($fields['fdst_option_id'] != "") {

                $faild_DST = "1";

            }

            $this->class_fields[$count]['exten_record_set_ring_time_' . $temp_count]['key'] = 'exten';
            $this->class_fields[$count]['exten_record_set_ring_time_' . $temp_count]['value'] = $fields['extension_no'] . ',1,Set(ringTime=' . $fields['ring_number'] * ONE_RING_TIME . ')';
            $this->class_fields[$count]['exten_record_set_ring_time_' . $temp_count]['operator'] = ' => ';

            $this->class_fields[$count]['exten_pickUp_' . $temp_count]['key'] = 'exten';
            $this->class_fields[$count]['exten_pickUp_' . $temp_count]['value'] = $fields['extension_no'] . ',n,Set(__PICKUPMARK=' . $fields['extension_no'] . '-' . $fields['comp_name'] . ')';
            $this->class_fields[$count]['exten_pickUp_' . $temp_count]['operator'] = ' => ';

            $this->class_fields[$count]['exten_CUT' . $temp_count]['key'] = ';exten';
            $this->class_fields[$count]['exten_CUT' . $temp_count]['value'] = $fields['extension_no'] . ',n,Set(CALLERID(num)=${CUT(CALLERID(num),,1)})';
            $this->class_fields[$count]['exten_CUT' . $temp_count]['operator'] = ' => ';

            $this->class_fields[$count]['exten_dnid' . $temp_count]['key'] = 'exten';
            $this->class_fields[$count]['exten_dnid' . $temp_count]['value'] = $fields['extension_no'] . ',n,Set(CALLERID(dnid)=${EXTEN})';
            $this->class_fields[$count]['exten_dnid' . $temp_count]['operator'] = ' => ';


//            $this->class_fields[$count]['exten_clrid' . $temp_count]['key'] = 'exten';
//            $this->class_fields[$count]['exten_clrid' . $temp_count]['value'] = $fields['extension_no'] . ',n,Set(CALLERID(num)=${EXTEN})';
//            $this->class_fields[$count]['exten_clrid' . $temp_count]['operator'] = ' => ';
//


            $this->class_fields[$count]['exten_Gosub' . $temp_count]['key'] = 'exten';
            $this->class_fields[$count]['exten_Gosub' . $temp_count]['value'] =
                $fields['extension_no'] . ',n,Gosub(extension-DST-' . $fields['comp_name'] . ',s,1)';
            $this->class_fields[$count]['exten_Gosub' . $temp_count]['operator'] = ' => ';


            $this->class_fields[$count]['exten_Macro' . $temp_count]['key'] = 'exten';

            if($fields['protocol']=="sip-webrtc")
            {
                $this->class_fields[$count]['exten_Macro' . $temp_count]['value'] = $fields['extension_no'] . ',n(time),Gosub(dial-' . $fields['comp_name'] . ',' . $fields['extension_no'] . ',' . $faild_DST . ',${fromQueue},' . $str = strtoupper($fields['sip'])
                        . ')';
            }
            else{
                $this->class_fields[$count]['exten_Macro' . $temp_count]['value'] = $fields['extension_no'] . ',n(time),Gosub(dial-' . $fields['comp_name'] . ',' . 's,1('. $fields['extension_no'].','. $faild_DST . ',${fromQueue},' . $str = strtoupper('sip')
                        . '))';

            }

            $this->class_fields[$count]['exten_Macro' . $temp_count]['operator'] = ' => ';


            if ($faild_DST == "1") {

                $this->class_fields[$count]['exten_FDST' . $temp_count]['key'] = 'exten';


                if ($fields['fdst_option_id'] == "7") {

                    $this->class_fields[$count]['exten_FDST' . $temp_count]['value'] = $fields['extension_no'] . ',n,Hangup()';

                } elseif ($fields['fdst_option_id'] == "9") {

                    if ($fields['fdst_option_sub_id'] == '1') {

                        $ExtResult = $this->getExtensionById($fields['fDSTOption']);
                        $Ext = $ExtResult['rs']->fetch();

                        $this->class_fields[$count]['exten_FDST' . $temp_count]['value'] = $fields['extension_no'] . ',n,Goto(internaldial-' . $fields['comp_name'] . ',' . $Ext['extension_no'] . ',1)';

                    } elseif ($fields['fdst_option_sub_id'] == '2') {

                        $this->class_fields[$count]['exten_FDST' . $temp_count]['value'] = $fields['extension_no'] . ',n,Goto(outpattern-' . $fields['comp_name'] . ',' . $this->getFristOutboundPrefix() . $fields['fDSTOption'] . ',1)';

                    }

                } elseif ($fields['fdst_option_id'] == "6") {

                    $ExtResult = $this->getExtensionById($fields['fdst_option_sub_id'])['rs']->fetch();

                    if ($fields['fDSTOption'] == "withOutMessage") {

                        $this->class_fields[$count]['exten_FDST' . $temp_count]['value'] = $fields['extension_no'] . ',n,Macro(VoicemailPlay-' . $fields['comp_name'] . ',noMSG,' . $ExtResult['extension_no'] . ')';

                    } elseif ($fields['fDSTOption'] == "defaultMessage") {

                        $this->class_fields[$count]['exten_FDST' . $temp_count]['value'] = $fields['extension_no'] . ',n,Gotoif($[${DIALSTATUS} = "BUSY"]?Macro(VoicemailPlay-' . $fields['comp_name'] . ',busy,' . $ExtResult['extension_no'] . ')';
                        $this->class_fields[$count]['Gotoif' . $temp_count]['operator'] = ' => ';
                        $this->class_fields[$count]['Gotoif' . $temp_count]['key'] = 'exten';
                        $this->class_fields[$count]['Gotoif' . $temp_count]['value'] = $fields['extension_no'] . ',n,Gotoif($[${DIALSTATUS} = "CHANUNAVAIL"]?Macro(VoicemailPlay-' . $fields['comp_name'] . ',unavail,' . $ExtResult['extension_no'] . ')';
                        $this->class_fields[$count]['Macro' . $temp_count]['operator'] = ' => ';
                        $this->class_fields[$count]['Macro' . $temp_count]['key'] = 'exten';
                        $this->class_fields[$count]['Macro' . $temp_count]['value'] = $fields['extension_no'] . ',n,Gosub(VoicemailPlay-' . $fields['comp_name'] . ',s,1(noMSG,' . $ExtResult['extension_no'] . '))';

                    }

                } else if ($fields['fdst_option_id'] == "4") {

                    $announceDetail = $this->getAnnounceById($fields['fdst_option_sub_id'])['rs']->fetch();

                    $this->class_fields[$count]['exten_FDST' . $temp_count]['value'] = $fields['extension_no'] . ',n,Goto(announce-' . $announceDetail['announce_name'] . '-' . $fields['comp_name'] . ',s,1)';

                }

                else if ($fields['fdst_option_id'] == "12") {

                    $TimeConditionByExtensionDetail = $this->getExtensionTimeConditionByExtensionID($fields['fdst_option_sub_id'])['rs']->fetch();

                    $this->class_fields[$count]['exten_FDST' . $temp_count]['value'] = $fields['extension_no'] . ',n,Goto(ExtensionTimeCondition-' . $TimeConditionByExtensionDetail['announce_name'] . '-' . $fields['comp_name'] . ',s,1)';

                }
                else {

                    die(" Check the id of DST in Failed DTS of Extension");

                }

                //$this->class_fields[$count]['exten_FDST' . $temp_count]['value'] = $fields['extension_no'] . ',n,Macro(dial-dabapbx,' . $fields['extension_no'] . ','.$faild_DST.',${fromQueue})';
                $this->class_fields[$count]['exten_FDST' . $temp_count]['operator'] = ' => ';

            }


            /*$this->class_fields[$count]['exten_record' . $temp_count]['key'] = 'exten';
            $this->class_fields[$count]['exten_record' . $temp_count]['value'] = $fields['extension_no'] . ',n,Goto(h,1)';
            $this->class_fields[$count]['exten_record' . $temp_count]['operator'] = ' => ';*/
            $temp_count++;
        }

        $this->class_fields[$count]['exten_set_Hangup']['key'] = 'exten';
        $this->class_fields[$count]['exten_set_Hangup']['value'] = 'h,1,Hangup()';
        $this->class_fields[$count]['exten_set_Hangup']['operator'] = ' => ';

        $this->class_fields[$count]['custom']['key'] = 'include';
        $this->class_fields[$count]['custom']['value'] = 'internaldial-' . $comp_name . '-custome';
        $this->class_fields[$count]['custom']['operator'] = ' => ';


        /*$this->class_fields[$count]['exten_set_macro']['key'] = 'exten';
        $this->class_fields[$count]['exten_set_macro']['value'] = 's,1,Macro(Extension-DST-'.$fields['comp_name'].')';
        $this->class_fields[$count]['exten_set_macro']['operator'] = ' => ';

        $this->class_fields[$count]['exten_set_gotoIf']['key'] = 'exten';
        $this->class_fields[$count]['exten_set_gotoIf']['value'] = 's,n(start),GotoIf($["${DB(Ext/${CALLERID(dnid)}-'.$fields['comp_name'].'/Rec/Internal)}" = "Yes"]?record:not_record)';
        $this->class_fields[$count]['exten_set_gotoIf']['operator'] = ' => ';

        $this->class_fields[$count]['exten_set_path']['key'] = 'exten';
        $this->class_fields[$count]['exten_set_path']['value'] = 's,n(record),Set(path=/' . RECORD_PATH . ')';
        $this->class_fields[$count]['exten_set_path']['operator'] = ' => ';

        $this->class_fields[$count]['exten_set_company']['key'] = 'exten';
        $this->class_fields[$count]['exten_set_company']['value'] = 's,n,Set(company=' . $fields['comp_name'] . ')';
        $this->class_fields[$count]['exten_set_company']['operator'] = ' => ';

        $this->class_fields[$count]['exten_set_year']['key'] = 'exten';
        $this->class_fields[$count]['exten_set_year']['value'] = 's,n,Set(year=${STRFTIME(${EPOCH},Asia/Tehran,%C%y)})';
        $this->class_fields[$count]['exten_set_year']['operator'] = ' => ';

        $this->class_fields[$count]['exten_set_month']['key'] = 'exten';
        $this->class_fields[$count]['exten_set_month']['value'] = 's,n,Set(month=${STRFTIME(${EPOCH},Asia/Tehran,%m)})';
        $this->class_fields[$count]['exten_set_month']['operator'] = ' => ';

        $this->class_fields[$count]['exten_set_day']['key'] = 'exten';
        $this->class_fields[$count]['exten_set_day']['value'] = 's,n,Set(day=${STRFTIME(${EPOCH},Asia/Tehran,%d)})';
        $this->class_fields[$count]['exten_set_day']['operator'] = ' => ';

        $this->class_fields[$count]['exten_set_recordpath']['key'] = 'exten';
        $this->class_fields[$count]['exten_set_recordpath']['value'] = 's,n,Set(recordpath=/' . RECORD_PATH . '${company}/${year}/${month}/${day})';
        $this->class_fields[$count]['exten_set_recordpath']['operator'] = ' => ';

        $this->class_fields[$count]['MixMonitor']['key'] = 'exten';
        $this->class_fields[$count]['MixMonitor']['value'] = 's,n,MixMonitor(${recordpath}/${UNIQUEID}.wav,${CALLERID(dnid)})';
        $this->class_fields[$count]['MixMonitor']['operator'] = ' => ';

        $this->class_fields[$count]['Dial']['key'] = 'exten';
        $this->class_fields[$count]['Dial']['value'] = 's,n(not_record),Dial(Sip/${CALLERID(dnid)}-' . $fields['comp_name'] . ',${ringTime})';
        $this->class_fields[$count]['Dial']['operator'] = ' => ';

        $this->class_fields[$count]['MailboxExists']['key'] = 'exten';
        $this->class_fields[$count]['MailboxExists']['value'] = 's,n,MailboxExists(${CALLERID(dnid)}@voiceMail-' . $fields['comp_name'] . ')';
        $this->class_fields[$count]['MailboxExists']['operator'] = ' => ';

        $this->class_fields[$count]['VMBOXEXISTSSTATUS']['key'] = 'exten';
        $this->class_fields[$count]['VMBOXEXISTSSTATUS']['value'] = 's,n,GotoIf($["${VMBOXEXISTSSTATUS}" = "SUCCESS"]?exists)';
        $this->class_fields[$count]['VMBOXEXISTSSTATUS']['operator'] = ' => ';

        $this->class_fields[$count]['is-curntly-busy']['key'] = 'exten';
        $this->class_fields[$count]['is-curntly-busy']['value'] = 's,n,Playback(is-curntly-busy)';
        $this->class_fields[$count]['is-curntly-busy']['operator'] = ' => ';

        $this->class_fields[$count]['hangup']['key'] = 'exten';
        $this->class_fields[$count]['hangup']['value'] = 's,n(hangup),Hangup()';
        $this->class_fields[$count]['hangup']['operator'] = ' => ';

        $this->class_fields[$count]['DIALSTATUS']['key'] = 'exten';
        $this->class_fields[$count]['DIALSTATUS']['value'] = 's,n(exists),Gotoif($[${DIALSTATUS}=CHANUNAVAIL | BUSY | NOANSWER]?continue:hangup)';
        $this->class_fields[$count]['DIALSTATUS']['operator'] = ' => ';

        $this->class_fields[$count]['VoiceMail']['key'] = 'exten';
        $this->class_fields[$count]['VoiceMail']['value'] = 's,n(continue),VoiceMail(${CALLERID(dnid)}@voiceMail-' . $fields['comp_name'] . ')';
        $this->class_fields[$count]['VoiceMail']['operator'] = ' => ';

        $this->class_fields[$count]['VoiceMail_exten']['key'] = 'exten';
        $this->class_fields[$count]['VoiceMail_exten']['value'] = 's,n,Set(voicemailfile=${VM_MESSAGEFILE})';
        $this->class_fields[$count]['VoiceMail_exten']['operator'] = ' => ';

        $this->class_fields[$count]['VoiceMail_exten1']['key'] = 'exten';
        $this->class_fields[$count]['VoiceMail_exten1']['value'] = 's,n,System(cp ${voicemailfile}.wav /' . VOICEMAIL_PATH . '${UNIQUEID}.wav)';
        $this->class_fields[$count]['VoiceMail_exten1']['operator'] = ' => ';

        $this->class_fields[$count]['VoiceMail_exten2']['key'] = 'exten';
        $this->class_fields[$count]['VoiceMail_exten2']['value'] = 's,n,Hangup()';
        $this->class_fields[$count]['VoiceMail_exten2']['operator'] = ' => ';*/

        /*$this->class_fields[$count]['outpattern-internaldial' . $count . 'include']['key'] = 'include';
        $this->class_fields[$count]['outpattern-internaldial' . $count . 'include']['value'] ='outpattern-' .$comp_name . ' ';
        $this->class_fields[$count]['outpattern-internaldial' . $count . 'include']['operator'] = ' => ';*/

        /*$Outbound_list = $this->getAllOutboundInfo();
        $list = '';
        $count_out_pattern = 0;
        while ($row = $Outbound_list['rs']->fetch()) {
            $count_out_pattern++;
            $this->class_fields[$count]['outpattern-internaldial' . $count . $count_out_pattern]['key'] = 'include';
            $this->class_fields[$count]['outpattern-internaldial' . $count . $count_out_pattern]['value'] =
                'outpattern-' . $row['outbound_name'] . '-' . $row['comp_name'] . ' ';
            $this->class_fields[$count]['outpattern-internaldial' . $count . $count_out_pattern]['operator'] = ' => ';
        }*/
        $count++;

        $this->class_fields[$count]['directdial']['key'] = '[directdial-' . $comp_name . ']';
        $this->class_fields[$count]['directdial']['value'] = '';
        $temp_count = 1;
        foreach ($array_fields as $key => $fields) {

            if ($fields['ring_number'] == '' or strlen($fields['ring_number']) == 0) {
                $fields['ring_number'] = '7';
            }

            //exten => 110,1,Goto(internaldial-dabapbx,110,1)


            //add direct dial
            $confranceList = $this->getConfranceList();
            foreach ($confranceList['export']['list'] as $confkey => $confFields) {
                // exten => 9999,1,Goto(Confbridge - eis,9999,1)
                //dd($fields);


                $this->class_fields[$count]['confrance' . $confkey]['key'] = 'exten';
                $this->class_fields[$count]['confrance' . $confkey]['value'] = $confFields['conf_number'] . ',1,Goto(Confbridge-' . $comp_name . ',' . $confFields['conf_number'] . ',1)';
                $this->class_fields[$count]['confrance' . $confkey]['operator'] = ' => ';

            }


            //


            $this->class_fields[$count]['directdial_goto' . $temp_count]['key'] = 'exten';
            $this->class_fields[$count]['directdial_goto' . $temp_count]['value'] = $fields['extension_no'] . ',1,Goto(internaldial-' . $fields['comp_name'] . ',' . $fields['extension_no'] . ',1)';
            $this->class_fields[$count]['directdial_goto' . $temp_count]['operator'] = ' => ';

            /*$this->class_fields[$count]['exten_record_set_ring_time_' . $temp_count]['key'] = 'exten';
            $this->class_fields[$count]['exten_record_set_ring_time_' . $temp_count]['value'] = $fields['extension_no'] . ',n,Set(ringTime=' . $fields['ring_number'] * ONE_RING_TIME . ')';
            $this->class_fields[$count]['exten_record_set_ring_time_' . $temp_count]['operator'] = ' => ';

            $this->class_fields[$count]['exten_ringTime_' . $temp_count]['key'] = 'exten';
            $this->class_fields[$count]['exten_ringTime_' . $temp_count]['value'] = $fields['extension_no'] . ',n,Set(__PICKUPMARK=' . $fields['extension_no'] . '-' . $fields['comp_name'] . ')';
            $this->class_fields[$count]['exten_ringTime_' . $temp_count]['operator'] = ' => ';

            $this->class_fields[$count]['dnid' . $temp_count]['key'] = 'exten';
            $this->class_fields[$count]['dnid' . $temp_count]['value'] = $fields['extension_no'] . ',n,Set(CALLERID(dnid)=${EXTEN})';
            $this->class_fields[$count]['dnid' . $temp_count]['operator'] = ' => ';


            $this->class_fields[$count]['exten_record' . $temp_count]['key'] = 'exten';
            $this->class_fields[$count]['exten_record' . $temp_count]['value'] = $fields['extension_no'] . ',n,Goto(s,1)';
            $this->class_fields[$count]['exten_record' . $temp_count]['operator'] = ' => ';*/
            $temp_count++;
        }


        $this->class_fields[$count]['custom' . $temp_count]['key'] = 'include';
        $this->class_fields[$count]['custom' . $temp_count]['value'] = 'directdial-' . $comp_name . '-custome';
        $this->class_fields[$count]['custom' . $temp_count]['operator'] = ' => ';
        $temp_count++;


        /*$this->class_fields[$count]['exten_set_invalid']['key'] = 'exten';
        $this->class_fields[$count]['exten_set_invalid']['value'] = '_X.,1,Goto(${contextid},i,1)';
        $this->class_fields[$count]['exten_set_invalid']['operator'] = ' => ';

        $this->class_fields[$count]['exten_set_path']['key'] = 'exten';
        $this->class_fields[$count]['exten_set_path']['value'] = 's,1,Set(path=/' . RECORD_PATH . ')';
        $this->class_fields[$count]['exten_set_path']['operator'] = ' => ';

        $this->class_fields[$count]['exten_set_company']['key'] = 'exten';
        $this->class_fields[$count]['exten_set_company']['value'] = 's,n,Set(company=' . $fields['comp_name'] . ')';
        $this->class_fields[$count]['exten_set_company']['operator'] = ' => ';

        $this->class_fields[$count]['exten_set_year']['key'] = 'exten';
        $this->class_fields[$count]['exten_set_year']['value'] = 's,n,Set(year=${STRFTIME(${EPOCH},Asia/Tehran,%C%y)})';
        $this->class_fields[$count]['exten_set_year']['operator'] = ' => ';

        $this->class_fields[$count]['exten_set_month']['key'] = 'exten';
        $this->class_fields[$count]['exten_set_month']['value'] = 's,n,Set(month=${STRFTIME(${EPOCH},Asia/Tehran,%m)})';
        $this->class_fields[$count]['exten_set_month']['operator'] = ' => ';

        $this->class_fields[$count]['exten_set_day']['key'] = 'exten';
        $this->class_fields[$count]['exten_set_day']['value'] = 's,n,Set(day=${STRFTIME(${EPOCH},Asia/Tehran,%d)})';
        $this->class_fields[$count]['exten_set_day']['operator'] = ' => ';

        $this->class_fields[$count]['exten_set_recordpath']['key'] = 'exten';
        $this->class_fields[$count]['exten_set_recordpath']['value'] = 's,n,Set(recordpath=/' . RECORD_PATH . '${company}/${year}/${month}/${day})';
        $this->class_fields[$count]['exten_set_recordpath']['operator'] = ' => ';

        $this->class_fields[$count]['MixMonitor']['key'] = 'exten';
        $this->class_fields[$count]['MixMonitor']['value'] = 's,n,MixMonitor(${recordpath}/${UNIQUEID}.wav,${CALLERID(dnid)})';
        $this->class_fields[$count]['MixMonitor']['operator'] = ' => ';

        $this->class_fields[$count]['Dial']['key'] = 'exten';
        $this->class_fields[$count]['Dial']['value'] = 's,n,Dial(Sip/${CALLERID(dnid)}-' . $fields['comp_name'] . ',${ringTime})';
        $this->class_fields[$count]['Dial']['operator'] = ' => ';

        $this->class_fields[$count]['MailboxExists']['key'] = 'exten';
        $this->class_fields[$count]['MailboxExists']['value'] = 's,n,MailboxExists(${CALLERID(dnid)}@voiceMail-' . $fields['comp_name'] . ')';
        $this->class_fields[$count]['MailboxExists']['operator'] = ' => ';

        $this->class_fields[$count]['VMBOXEXISTSSTATUS']['key'] = 'exten';
        $this->class_fields[$count]['VMBOXEXISTSSTATUS']['value'] = 's,n,GotoIf($["${VMBOXEXISTSSTATUS}" = "SUCCESS"]?exists)';
        $this->class_fields[$count]['VMBOXEXISTSSTATUS']['operator'] = ' => ';

        $this->class_fields[$count]['is-curntly-busy']['key'] = 'exten';
        $this->class_fields[$count]['is-curntly-busy']['value'] = 's,n,Playback(is-curntly-busy)';
        $this->class_fields[$count]['is-curntly-busy']['operator'] = ' => ';

        $this->class_fields[$count]['hangup']['key'] = 'exten';
        $this->class_fields[$count]['hangup']['value'] = 's,n(hangup),Hangup()';
        $this->class_fields[$count]['hangup']['operator'] = ' => ';

        $this->class_fields[$count]['DIALSTATUS']['key'] = 'exten';
        $this->class_fields[$count]['DIALSTATUS']['value'] = 's,n(exists),Gotoif($[${DIALSTATUS}=CHANUNAVAIL | BUSY | NOANSWER]?continue:hangup)';
        $this->class_fields[$count]['DIALSTATUS']['operator'] = ' => ';


        $this->class_fields[$count]['VoiceMail']['key'] = 'exten';
        $this->class_fields[$count]['VoiceMail']['value'] = 's,n(continue),VoiceMail(${CALLERID(dnid)}@voiceMail-' . $fields['comp_name'] . ')';
        $this->class_fields[$count]['VoiceMail']['operator'] = ' => ';

        $this->class_fields[$count]['VoiceMail_exten']['key'] = 'exten';
        $this->class_fields[$count]['VoiceMail_exten']['value'] = 's,n,Set(voicemailfile=${VM_MESSAGEFILE})';
        $this->class_fields[$count]['VoiceMail_exten']['operator'] = ' => ';

        $this->class_fields[$count]['VoiceMail_exten1']['key'] = 'exten';
        $this->class_fields[$count]['VoiceMail_exten1']['value'] = 's,n,System(cp ${voicemailfile}.wav /' . VOICEMAIL_PATH . '${UNIQUEID}.wav)';
        $this->class_fields[$count]['VoiceMail_exten1']['operator'] = ' => ';

        $this->class_fields[$count]['VoiceMail_exten2']['key'] = 'exten';
        $this->class_fields[$count]['VoiceMail_exten2']['value'] = 's,n,Hangup()';
        $this->class_fields[$count]['VoiceMail_exten2']['operator'] = ' => ';*/

        return $count++;
    }


    function setFieldsMacroDial($array_fields, $defaultConfig, $count)
    {

        $array_fields = $array_fields['list'][$this->comp_id];

        $count++;
        $comp_name = $array_fields['comp_name'];

        $this->class_fields[$count]['context_company']['key'] = '[dial-' . $comp_name . ']';
        $this->class_fields[$count]['context_company']['value'] = '';

        $this->class_fields[$count]['exten_Execif']['key'] = 'exten';
        #$this->class_fields[$count]['exten_Execif']['value'] = 's,1,Execif($[$["${DB(Ext/${ARG1}-' . $comp_name . '/Rec/Internal)}" = "yes" ] & $["${fromQueue}" = ""]]?Gosub(record-' . $comp_name . ',s,1))';
        $this->class_fields[$count]['exten_Execif']['value'] = 's,1,Execif($[$["${DB(Ext/${ARG1}-' . $comp_name . '/Rec/Internal)}" = "yes" ] | $["${fromQueue}" = "1"]]?Gosub(record-' . $comp_name . ',s,1))';
        $this->class_fields[$count]['exten_Execif']['operator'] = ' => ';

        $this->class_fields[$count]['exten_Set']['key'] = 'exten';
        $this->class_fields[$count]['exten_Set']['value'] = 's,n,Set(ringTime=${IF($["${ARG2}"="1"&"${ARG3}"=""]?${ringTime}:)})';
        $this->class_fields[$count]['exten_Set']['operator'] = ' => ';

        $this->class_fields[$count]['exten_Dial']['key'] = 'exten';
        //$this->class_fields[$count]['exten_Dial']['value'] = 's,n,Dial(${ARG4}/${ARG1}-' . $array_fields['comp_name'] . ',${ringTime})';
        $this->class_fields[$count]['exten_Dial']['value'] = 's,n,Dial(${ARG4}/${ARG1},${ringTime})';
        $this->class_fields[$count]['exten_Dial']['operator'] = ' => ';

        return $count++;
    }

    function setFieldsMacroRecord($array_fields, $defaultConfig, $count)
    {

        $array_fields = $array_fields['list'][$this->comp_id];

        $count++;
        $comp_name = $array_fields['comp_name'];

        $this->class_fields[$count]['context_company']['key'] = '[record-' . $comp_name . ']';
        $this->class_fields[$count]['context_company']['value'] = '';


        $this->class_fields[$count]['exten_set_path']['key'] = 'exten';
        $this->class_fields[$count]['exten_set_path']['value'] = 's,1,Set(path=' . RECORD_PATH .'voip/'. $comp_name . DS . "monitor" . DS . ')';
        $this->class_fields[$count]['exten_set_path']['operator'] = ' => ';

        $this->class_fields[$count]['exten_set_company']['key'] = 'exten';
        $this->class_fields[$count]['exten_set_company']['value'] = 's,n,Set(company=' . $comp_name . ')';
        $this->class_fields[$count]['exten_set_company']['operator'] = ' => ';

        $this->class_fields[$count]['exten_set_year']['key'] = 'exten';
        $this->class_fields[$count]['exten_set_year']['value'] = 's,n,Set(year=${STRFTIME(${EPOCH},Asia/Tehran,%C%y)})';
        $this->class_fields[$count]['exten_set_year']['operator'] = ' => ';

        $this->class_fields[$count]['exten_set_month']['key'] = 'exten';
        $this->class_fields[$count]['exten_set_month']['value'] = 's,n,Set(month=${STRFTIME(${EPOCH},Asia/Tehran,%m)})';
        $this->class_fields[$count]['exten_set_month']['operator'] = ' => ';

        $this->class_fields[$count]['exten_set_day']['key'] = 'exten';
        $this->class_fields[$count]['exten_set_day']['value'] = 's,n,Set(day=${STRFTIME(${EPOCH},Asia/Tehran,%d)})';
        $this->class_fields[$count]['exten_set_day']['operator'] = ' => ';

        $this->class_fields[$count]['exten_set_recordpath']['key'] = 'exten';
        $this->class_fields[$count]['exten_set_recordpath']['value'] = 's,n,Set(recordpath=${path}${company}/${year}/${month}/${day})';
        $this->class_fields[$count]['exten_set_recordpath']['operator'] = ' => ';

        $this->class_fields[$count]['exten_set_fileName']['key'] = 'exten';
        $this->class_fields[$count]['exten_set_fileName']['value'] = 's,n,Set(fileName=${CALLERID(num)}-${CALLERID(dnid)}-)';
        $this->class_fields[$count]['exten_set_fileName']['operator'] = ' => ';

        $this->class_fields[$count]['mkdir']['key'] = 'exten';
        $this->class_fields[$count]['mkdir']['value'] = 's,n,system(mkdir -p ${recordpath})';
        $this->class_fields[$count]['mkdir']['operator'] = ' => ';

        $this->class_fields[$count]['MixMonitor']['key'] = 'exten';
        #$this->class_fields[$count]['MixMonitor']['value'] = 's,n,MixMonitor(${recordpath}/${fileName}${UNIQUEID}.wav)';
        $this->class_fields[$count]['MixMonitor']['value'] = 's,n,MixMonitor(${recordpath}/recordfile-${fileName}${MASTER_CHANNEL(UNIQUEID)}.wav,b)';
        $this->class_fields[$count]['MixMonitor']['operator'] = ' => ';

        $this->class_fields[$count]['CDR']['key'] = ';exten';
        $this->class_fields[$count]['CDR']['value'] = 's,n,Set(CDR(voice)=${recordpath}/${fileName}${UNIQUEID})';
        $this->class_fields[$count]['CDR']['operator'] = ' => ';


        $this->class_fields[$count]['feature-codes1_1' . $temp_count]['key'] = 'exten';
        $this->class_fields[$count]['feature-codes1_1' . $temp_count]['value'] = 's,n,Return()';
        $this->class_fields[$count]['feature-codes1_1' . $temp_count]['operator'] = ' => ';

        $temp_count++;

        return $count++;
    }


    /**
     * @return mixed
     */
    function getAllSipInfo()
    {
        $conn = parent::getConnection();

        $sql = "
                    SELECT
                      `tbl_extension`.*,
                      `tbl_company`.`comp_name`
                    FROM
                      `tbl_extension`
                      LEFT JOIN `tbl_company` ON `tbl_extension`.`comp_id` = `tbl_company`.`comp_id`
                      WHERE
                        `tbl_company`.`comp_id` = '" . $this->comp_id . "'
                      order by  `tbl_company`.`comp_name`;
                ";

        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        if (!$stmt) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }

        $result['result'] = 1;

        $result['rs'] = $stmt;
        return $result;

    }

    /**
     * @return mixed
     */
    function getAllAnnounceInfo()
    {
        $conn = parent::getConnection();

        $sql = "
                        SELECT
                          `tbl_announce`.*,
                          `tbl_company`.`comp_name`,
                          `tbl_upload`.`file_extension`
                        FROM
                          `tbl_announce`
                          LEFT JOIN `tbl_company` ON `tbl_announce`.`comp_id` = `tbl_company`.`comp_id`
                          LEFT JOIN `tbl_upload` ON `tbl_announce`.`upload_id` =
                            `tbl_upload`.`upload_id`
                        WHERE
                          `tbl_company`.`comp_id` = '" . $this->comp_id . "'
                          AND  `tbl_announce`.`trash` = '0'
                           AND `tbl_company`.`trash` = '0'
                        ORDER BY
                          `tbl_company`.`comp_name`

                                        ";

        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        if (!$stmt) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }

        $result['result'] = 1;
        $result['rs'] = $stmt;
        return $result;

    }

    function getAllExtensionTimeCondition()
    {
        $conn = parent::getConnection();

        $sql = "
                    SELECT
          `time_condition`.*,
          `tbl_extension`.`extension_name`,
          `tbl_extension`.`voicemail_pass`,
          `tbl_extension`.`voicemail_email`,
          `tbl_extension`.`voicemail_status`,
          `tbl_extension`.`extension_status`,
          `time_condition_name`.`name`
        FROM
          `time_condition_name`
          INNER JOIN `tbl_extension` ON `time_condition_name`.`extension_id` =
        `tbl_extension`.`extension_id`
          INNER JOIN `time_condition` ON `time_condition_name`.`id` =
        `time_condition`.`time_condtion_name_id`
                    ";
        $sql = "
            SELECT
              `time_condition_name`.*,`tbl_extension`.`extension_no`,
              `tbl_company`.`comp_name`
            FROM
              `time_condition_name`
              LEFT JOIN `tbl_company` ON `time_condition_name`.`comp_id` =
            `tbl_company`.`comp_id`
              LEFT JOIN `tbl_extension` ON `time_condition_name`.`extension_id` =
            `tbl_extension`.`extension_id`
            ";


        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        if (!$stmt) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }

        $result['result'] = 1;
        $result['rs'] = $stmt;
        return $result;

    }

    function getExtensionTimeConditionByExtensionID($time_condtion_name_id)
    {
        $conn = parent::getConnection();

        $sql = "
            SELECT
              `time_condition`.*,
              `time_condition_name`.`name`
            FROM
              `time_condition_name`
              LEFT JOIN `time_condition` ON `time_condition_name`.`id` =
            `time_condition`.`time_condtion_name_id`
             WHERE `time_condition`.time_condtion_name_id =  $time_condtion_name_id
             ORDER BY id ASC
            ";

        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        if (!$stmt) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }

        $result['result'] = 1;
        $result['rs'] = $stmt;
        return $result;

    }

    function getExtensionTimeConditionDetail($timeConditionID)
    {
        $conn = parent::getConnection();

        $sql = "
            SELECT
             *
            FROM time_condition
             WHERE time_condtion_name_id =  $timeConditionID
             ORDER BY id ASC
            ";

        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        if (!$stmt) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }

        $result['result'] = 1;
        $result['rs'] = $stmt;
        return $result;

    }


    /**
     * @return mixed
     */
    function getAlltimeCondition()
    {
        $conn = parent::getConnection();

        /*$sql = "
            SELECT
              `main_time_condition`.`name`,
              `main_time_condition_detail`.*
            FROM
              `main_time_condition`
              LEFT JOIN `main_time_condition_detail` ON `main_time_condition`.`id` =
            `main_time_condition_detail`.`timeConditionID` ORDER BY timeConditionID ASC
            ";*/


        $sql = "
            SELECT
             `main_time_condition`.*,  `tbl_company`.`comp_name`
            FROM
              `main_time_condition` LEFT JOIN `tbl_company` ON `main_time_condition`.`comp_id` = `tbl_company`.`comp_id`
            ";


        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        if (!$stmt) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }

        $result['result'] = 1;
        $result['rs'] = $stmt;
        return $result;

    }

    function getAlltimeConditionDetail($timeConditionID)
    {
        $conn = parent::getConnection();

        $sql = "
            SELECT
             *
            FROM main_time_condition_detail
             WHERE timeConditionID =  $timeConditionID
             ORDER BY id ASC
            ";

        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        if (!$stmt) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }

        $result['result'] = 1;
        $result['rs'] = $stmt;
        return $result;

    }

    /**
     * @return mixed
     */
    function getQueueByid($id)
    {
        $conn = parent::getConnection();

        $sql = "
                        SELECT
                          `tbl_queue`.*
                           FROM
                          `tbl_queue`
                        WHERE
                          queue_id = '" . $id . "'
                ";

        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        if (!$stmt) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }


        $result['result'] = 1;
        $result['rs'] = $stmt;

        return $result;

    }

    /**
     * @return mixed
     */
    function getIvrById($id)
    {
        $conn = parent::getConnection();

        $sql = "
                        SELECT
                          `tbl_ivr`.*
                           FROM
                          `tbl_ivr`
                        WHERE
                          ivr_id = '" . $id . "'
                ";

        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        if (!$stmt) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }

        $result['result'] = 1;
        $result['rs'] = $stmt;
        return $result;

    }

    function getAnnounceById($id)
    {
        $conn = parent::getConnection();

        $sql = "
                        SELECT
                          `tbl_announce`.*
                           FROM
                          `tbl_announce`
                        WHERE
                          announce_id = '" . $id . "'
                ";

        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        if (!$stmt) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }

        $result['result'] = 1;
        $result['rs'] = $stmt;
        return $result;

    }

    function getExtensionById($id)
    {
        $conn = parent::getConnection();

        $sql = "
                        SELECT
                          `tbl_extension`.*
                           FROM
                          `tbl_extension`
                        WHERE
                          extension_id = '" . $id . "'
                ";

        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        if (!$stmt) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }

        $result['result'] = 1;
        $result['rs'] = $stmt;
        return $result;

    }

    /**
     * @return mixed
     */
    function getAllIvrInfo()
    {
        $conn = parent::getConnection();

        $sql = "
                        SELECT
                          `tbl_ivr`.*,
                          `tbl_company`.`comp_name`,
                          `tbl_ivr_dst_menu`.`dst_option_id`,
                          `tbl_ivr_dst_menu`.`dst_option_sub_id`,
                          `tbl_ivr_dst_menu`.`ivr_menu_no`,
                          `tbl_ivr_dst_menu`.`forward`,
                          `tbl_ivr_dst_menu`.`DSTOption`
                        FROM
                          `tbl_ivr`
                          INNER JOIN `tbl_company` ON `tbl_ivr`.`comp_id` = `tbl_company`.`comp_id`
                          INNER JOIN `tbl_ivr_dst_menu` ON `tbl_ivr_dst_menu`.`ivr_id` =
                            `tbl_ivr`.`ivr_id`
                        WHERE
                          `tbl_company`.`comp_id`  = '" . $this->comp_id . "'
                          order by  `tbl_ivr`.`ivr_id` , `tbl_ivr_dst_menu`.`ivr_menu_no`

                ";

        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        if (!$stmt) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }

        $result['result'] = 1;
        $result['rs'] = $stmt;
        return $result;

    }

    function getQueueByCompId()
    {
        $conn = parent::getConnection();

        $sql = "
                        SELECT
                          `tbl_company`.`comp_name`,
                          `tbl_queue`.*
                        FROM
                          `tbl_company`
                          INNER JOIN `tbl_queue` ON `tbl_company`.`comp_id` = `tbl_queue`.`comp_id`
                        WHERE
                          `tbl_company`.`comp_id`  = '" . $this->comp_id . "'
                        ORDER BY
                          `tbl_company`.`comp_id`,
                          `tbl_queue`.`queue_id`;

                ";

        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        if (!$stmt) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }

        $result['result'] = 1;
        $result['rs'] = $stmt;
        return $result;

    }


    /**
     * @return mixed
     */
    function getAllInboundInfo()
    {
        $conn = parent::getConnection();

        $sql = "
                        SELECT
                          `tbl_company`.`comp_name`,
                          `tbl_inbound`.*
                        FROM
                          `tbl_company`
                          INNER JOIN `tbl_inbound` ON `tbl_company`.`comp_id` = `tbl_inbound`.`comp_id`
                        WHERE
                          `tbl_company`.`comp_id`  = '" . $this->comp_id . "'
                        ORDER BY
                          `tbl_company`.`comp_id`,
                          `tbl_inbound`.`dst_option_id`;

                ";

        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        if (!$stmt) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }

        $result['result'] = 1;
        $result['rs'] = $stmt;
        return $result;

    }

    /**
     * @return mixed
     */
    function getAllOutboundInfo()
    {
        $conn = parent::getConnection();

        $sql = "
                    SELECT
                      `tbl_outbound`.*,
                      `tbl_company`.`comp_name`,
                      `tbl_dialpattern`.`prepend`,
                      `tbl_dialpattern`.`prefix`,
                      `tbl_dialpattern`.`match_pattern`,
                      `tbl_dialpattern`.`caller_id`
                    FROM
                      `tbl_outbound`
                      LEFT JOIN `tbl_company` ON `tbl_outbound`.`comp_id` = `tbl_company`.`comp_id`
                      LEFT JOIN `tbl_dialpattern` ON `tbl_dialpattern`.`outbound_id` =`tbl_outbound`.`outbound_id`
                      WHERE
                            `tbl_company`.`comp_id` = '" . $this->comp_id . "'
                        AND `tbl_outbound`.`trash`='0'
                        AND `tbl_company`.`trash`='0'
                        
                    ORDER BY
                      `tbl_outbound`.`priority`;
                ";
        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        if (!$stmt) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }
        $result['result'] = 1;
        $result['rs'] = $stmt;
        return $result;

    }

    function getAllSipTrunckInfo($outbound)
    {

        include_once ROOT_DIR . 'component/outbound_siptrunk/adminOutboundSiptrunkModel.php';
        $result = adminOutboundSiptrunkModel::getAll()
            ->select('`tbl_sip`.*')
            ->leftJoin('tbl_sip', 'outbound_siptrunk.siptrunk_id', '=', 'tbl_sip.sip_id')
            ->where('outbound_id', '=', $outbound['outbound_id'])
            ->getList()['export']['list'];
        return $result;

    }

    /**
     * @param $fields
     * @param $count
     * @param $temp_count
     * @param $dstName
     * @param $otherFields
     * @return mixed
     */
    function queueDstOption($fields, $count, $temp_count, $dstName, $otherFields)
    {
        if ($fields['dst_option_id'] == 1) {
            $conn = parent::getConnection();
            $sql = "
                             SELECT
                              `tbl_sip`.* FROM `tbl_sip`
                             WHERE
                                `tbl_sip`.`sip_id` = '" . $fields['dst_option_sub_id'] . "' ";

            $stmt_sipTrunk = $conn->prepare($sql);
            $stmt_sipTrunk->setFetchMode(PDO::FETCH_ASSOC);
            $stmt_sipTrunk->execute();

            if (!$stmt_sipTrunk) {
                $result['result'] = -1;
                $result['no'] = 1;
                $result['msg'] = $conn->errorInfo();
                return $result;
            }
            $result['result'] = 1;
            $subRowSipTrunk = $stmt_sipTrunk->fetch();

            $appendString = 's';
            if ($dstName == 'IVR') {
                $appendString = $otherFields['ivr_menu_no'];
            } elseif ($dstName == 'inbound') {
                $appendString = $this->setDidCid($otherFields['did_name'], $otherFields['cid_name']);
            }

            $this->class_fields[$count]['HangupDst1' . $temp_count]['key'] = 'exten';
            $this->class_fields[$count]['HangupDst1' . $temp_count]['value'] = $appendString . ',n,Dial(SIP/@' . $subRowSipTrunk['sip_name'] . '-' . $otherFields['comp_name'] . ')';
            $this->class_fields[$count]['HangupDst1' . $temp_count]['operator'] = ' => ';

        } elseif ($fields['dst_option_id'] == 2) {


            $conn = parent::getConnection();

            $sql = "
                             SELECT
                              `tbl_queue`.* FROM `tbl_queue`
                             WHERE
                                `tbl_queue`.`queue_id` = '" . $fields['dst_option_sub_id'] . "' ";

            $stmt_queue = $conn->prepare($sql);
            $stmt_queue->setFetchMode(PDO::FETCH_ASSOC);
            $stmt_queue->execute();

            if (!$stmt_queue) {
                $result['result'] = -1;
                $result['no'] = 1;
                $result['msg'] = $conn->errorInfo();
                return $result;
            }
            $result['result'] = 1;
            $subRowSip = $stmt_queue->fetch();

            $appendString = 's';
            if ($dstName == 'IVR') {
                $appendString = $otherFields['ivr_menu_no'];
            } elseif ($dstName == 'inbound') {
                $appendString = $this->setDidCid($otherFields['did_name'], $otherFields['cid_name']);
            }

            if ($subRowSip['max_wait_time'] == '') {
                $subRowSip['max_wait_time'] = 60;
            }

            if ($subRowSip['instead'] == '1') {
                $instead = 'r';
            } else {
                $instead = '';
            }


            /*$this->class_fields[$count]['QueueDst' . $temp_count]['key'] = ';exten';
            $this->class_fields[$count]['QueueDst' . $temp_count]['value']
                = $appendString . ',n,Queue(' . $subRowSip['queue_name'] . '-' . $otherFields['comp_name'] . ',' . $instead . ',,,' . $subRowSip['max_wait_time'] . ')';
            $this->class_fields[$count]['QueueDst' . $temp_count]['operator'] = ' => ';*/


            //;exten => 1,n,Goto(Sales-Q-dabapbx,100,1)
            $this->class_fields[$count]['Queue2' . $temp_count]['key'] = 'exten';
            $this->class_fields[$count]['Queue2' . $temp_count]['value']
                = $appendString . ',n,Goto(queue-' . $otherFields['comp_name'] . ',' . $subRowSip['queue_ext_no'] . ',1)';
            $this->class_fields[$count]['Queue2' . $temp_count]['operator'] = ' => ';


        } elseif ($fields['dst_option_id'] == 3 and $fields['dst_option_sub_id'] != '0') {
            $conn = parent::getConnection();

            $sql = "
                      SELECT
                        `tbl_extension`.* FROM `tbl_extension`
                      WHERE
                        `tbl_extension`.`extension_id` = '" . $fields['dst_option_sub_id'] . "' ";

            $stmt_extension = $conn->prepare($sql);
            $stmt_extension->setFetchMode(PDO::FETCH_ASSOC);
            $stmt_extension->execute();

            if (!$stmt_extension) {
                $result['result'] = -1;
                $result['no'] = 1;
                $result['msg'] = $conn->errorInfo();
                return $result;
            }
            $result['result'] = 1;
            $subRowSip = $stmt_extension->fetch();


            $appendString = 's';
            if ($dstName == 'IVR') {
                $appendString = $otherFields['ivr_menu_no'];
            } elseif ($dstName == 'inbound') {
                $appendString = $this->setDidCid($otherFields['did_name'], $otherFields['cid_name']);
            }

            if ($subRowSip['timeout'] == '') {
                $subRowSip['timeout'] = 60;
            }

            if ($subRowSip['ring_number'] == '' or strlen($subRowSip['ring_number']) == 0) {
                $subRowSip['ring_number'] = '30';
            }

            $ring_time = ONE_RING_TIME * $subRowSip['ring_number'];

            $this->class_fields[$count]['extension_tDst' . $temp_count]['key'] = 'exten';
            $this->class_fields[$count]['extension_tDst' . $temp_count]['value'] =
                $appendString . ',n,Dial(SIP/' . $subRowSip['extension_no'] . '-' . $otherFields['comp_name'] . ',' . $ring_time . ')';
            $this->class_fields[$count]['extension_tDst' . $temp_count]['operator'] = ' => ';

            if ($subRowSip['voicemail_status'] == '1') {

                $this->class_fields[$count]['DIALSTATUS' . $temp_count]['key'] = 'exten';
                $this->class_fields[$count]['DIALSTATUS' . $temp_count]['value'] = $appendString . ',n,Gotoif($[${DIALSTATUS}=CHANUNAVAIL | BUSY | NOANSWER]?next:hangup)';
                $this->class_fields[$count]['DIALSTATUS' . $temp_count]['operator'] = ' => ';

                $this->class_fields[$count]['VoiceMail' . $temp_count]['key'] = 'exten';
                $this->class_fields[$count]['VoiceMail' . $temp_count]['value'] = $appendString . ',n(next),VoiceMail(' . $subRowSip['extension_no'] . '@voiceMail-' . $otherFields['comp_name'] . ')';
                $this->class_fields[$count]['VoiceMail' . $temp_count]['operator'] = ' => ';

                //[record-internaldial
                $this->class_fields[$count]['VoiceMail_exten' . $temp_count]['key'] = 'exten';
                $this->class_fields[$count]['VoiceMail_exten' . $temp_count]['value'] = $appendString . ',n,Set(voicemailfile=${VM_MESSAGEFILE})';
                $this->class_fields[$count]['VoiceMail_exten' . $temp_count]['operator'] = ' => ';

                $this->class_fields[$count]['VoiceMail_exten1' . $temp_count]['key'] = 'exten';
                $this->class_fields[$count]['VoiceMail_exten1' . $temp_count]['value'] = $appendString . ',n,System(cp ${voicemailfile}.wav /' . VOICEMAIL_PATH . '${UNIQUEID}.wav)';
                $this->class_fields[$count]['VoiceMail_exten1' . $temp_count]['operator'] = ' => ';

            }

            $this->class_fields[$count]['ivr' . $temp_count]['key'] = 'exten';
            $this->class_fields[$count]['ivr' . $temp_count]['value'] = $appendString . ',n(hangup),Hangup()';
            $this->class_fields[$count]['ivr' . $temp_count]['operator'] = ' => ';


        } else if ($fields['dst_option_id'] == 4 and $fields['dst_option_sub_id'] != '0') {
            $conn = parent::getConnection();

            $sql = "
                              SELECT
                                `tbl_announce`.* FROM `tbl_announce`
                              WHERE
                                `tbl_announce`.`announce_id` = '" . $fields['dst_option_sub_id'] . "' ";

            $stmt_announce = $conn->prepare($sql);
            $stmt_announce->setFetchMode(PDO::FETCH_ASSOC);
            $stmt_announce->execute();

            if (!$stmt_announce) {
                $result['result'] = -1;
                $result['no'] = 1;
                $result['msg'] = $conn->errorInfo();
                return $result;
            }
            $result['result'] = 1;
            $subRowAnnounce = $stmt_announce->fetch();

            $appendString = 's';
            if ($dstName == 'IVR') {
                $appendString = $otherFields['ivr_menu_no'];
            } elseif ($dstName == 'inbound') {
                $appendString = $this->setDidCid($otherFields['did_name'], $otherFields['cid_name']);
            }

            if ($subRowAnnounce['timeout'] == '') {
                $subRowAnnounce['timeout'] = 60;
            }


            $this->class_fields[$count]['extension_tDst' . $temp_count]['key'] = 'exten';
            $this->class_fields[$count]['extension_tDst' . $temp_count]['value'] =
                $appendString . ',n,Goto(announce-' . $subRowAnnounce['announce_name'] . '-' . $otherFields['comp_name'] . ',s,1)';
            $this->class_fields[$count]['extension_tDst' . $temp_count]['operator'] = ' => ';

        } elseif ($fields['dst_option_id'] == 5) {
            $conn = parent::getConnection();

            $sql = "
                    SELECT
                    *
                    FROM
                      `tbl_ivr`
                    WHERE
                      `tbl_ivr`.`ivr_id` ='" . $fields['dst_option_sub_id'] . "' ";

            $stmt_ivr = $conn->prepare($sql);
            $stmt_ivr->setFetchMode(PDO::FETCH_ASSOC);
            $stmt_ivr->execute();

            if (!$stmt_ivr) {
                $result['result'] = -1;
                $result['no'] = 1;
                $result['msg'] = $conn->errorInfo();
                return $result;
            }
            $result['result'] = 1;
            $subRowIvr = $stmt_ivr->fetch();

            $appendString = 's';
            if ($dstName == 'IVR') {
                $appendString = $otherFields['ivr_menu_no'];
            } elseif ($dstName == 'inbound') {
                $appendString = $this->setDidCid($otherFields['did_name'], $otherFields['cid_name']);
            }

            $this->class_fields[$count]['ivrDst' . $temp_count]['key'] = 'exten';
            $this->class_fields[$count]['ivrDst' . $temp_count]['value'] =
                $appendString . ',n,Goto(ivr-' . $subRowIvr['ivr_name'] . '-' . $otherFields['comp_name'] . ',s,1)';
            $this->class_fields[$count]['ivrDst' . $temp_count]['operator'] = ' => ';


        } elseif ($fields['dst_option_id'] == 6) {
            $conn = parent::getConnection();

            $sql = "
                              SELECT
                                `tbl_extension`.* FROM `tbl_extension`
                              WHERE
                                `tbl_extension`.`extension_id` = '" . $fields['dst_option_sub_id'] . "' ";

            $stmt_extension = $conn->prepare($sql);
            $stmt_extension->setFetchMode(PDO::FETCH_ASSOC);
            $stmt_extension->execute();

            if (!$stmt_extension) {
                $result['result'] = -1;
                $result['no'] = 1;
                $result['msg'] = $conn->errorInfo();
                return $result;
            }
            $result['result'] = 1;
            $subRowSip = $stmt_extension->fetch();

            $appendString = 's';
            if ($dstName == 'IVR') {
                $appendString = $otherFields['ivr_menu_no'];
            } elseif ($dstName == 'inbound') {
                $appendString = $this->setDidCid($otherFields['did_name'], $otherFields['cid_name']);
            }


            if ($subRowSip['extension_no'] != '') {
                $this->class_fields[$count]['VoiceMailDst' . $temp_count]['key'] = 'exten';
                $this->class_fields[$count]['VoiceMailDst' . $temp_count]['value'] = $appendString . ',n,VoiceMail(' . $subRowSip['extension_no'] . '@voiceMail-' . $otherFields['comp_name'] . ')';
                $this->class_fields[$count]['VoiceMailDst' . $temp_count]['operator'] = ' => ';

                $this->class_fields[$count]['VoiceMail_extenDst' . $temp_count]['key'] = 'exten';
                $this->class_fields[$count]['VoiceMail_extenDst' . $temp_count]['value'] = $appendString . ',n,Set(voicemailfile=${VM_MESSAGEFILE})';
                $this->class_fields[$count]['VoiceMail_extenDst' . $temp_count]['operator'] = ' => ';

                $this->class_fields[$count]['VoiceMail_exten1Dst' . $temp_count]['key'] = 'exten';
                $this->class_fields[$count]['VoiceMail_exten1Dst' . $temp_count]['value'] = $appendString . ',n,System(cp ${voicemailfile}.wav /' . VOICEMAIL_PATH . '${UNIQUEID}.wav)';
                $this->class_fields[$count]['VoiceMail_exten1Dst' . $temp_count]['operator'] = ' => ';

                $this->class_fields[$count]['VoiceMail_exten2Dst' . $temp_count]['key'] = 'exten';
                $this->class_fields[$count]['VoiceMail_exten2Dst' . $temp_count]['value'] = $appendString . ',n,Hangup()';
                $this->class_fields[$count]['VoiceMail_exten2Dst' . $temp_count]['operator'] = ' => ';

            }

        } elseif ($fields['dst_option_id'] == 7) {
            // exten => 7,1,Hangup()

            $appendString = 's';
            if ($dstName == 'IVR') {
                $appendString = $otherFields['ivr_menu_no'];
            } elseif ($dstName == 'inbound') {
                $appendString = $this->setDidCid($otherFields['did_name'], $otherFields['cid_name']);
            }
            $this->class_fields[$count]['Hangup1Dst' . $temp_count]['key'] = 'exten';
            $this->class_fields[$count]['Hangup1Dst' . $temp_count]['value'] = $appendString . ',n,Hangup()';
            $this->class_fields[$count]['Hangup1Dst' . $temp_count]['operator'] = ' => ';
        }

    }

}
