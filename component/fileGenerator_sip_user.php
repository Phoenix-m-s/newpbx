<?php

class sip_user_fileGenerator extends DataBase
{
    private $class_fields;
    public $debugMode;
    public $fileName;
    public $defaultConfig;
    function logAMISccp($message, $isSuccessful) {
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
    function logAMISip($message, $isSuccessful) {
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

    function createSipFile($comp_id = '')
    {
        $defaultConfig = $this->defaultConfig;

        $result = $this->getAllSipInfo($comp_id);

        while ($row = $result['rs']->fetch()) {
            if ($row['protocol'] == 'sip') {
                $list[] = $row;
            }

        }

        $this->setFieldsSip($list, $defaultConfig);

        if (file_exists($this->fileName)) {
            unlink($this->fileName);
        }

        $handle = fopen($this->fileName, 'w');
        ob_start();

        for ($i = 0; $i <= count($this->class_fields) - 1; $i++) {
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
        $this->logAMISip('create_sip_user',true);

        $buffer = convertPersianNumbersToEnglish($buffer);
        fwrite($handle, $buffer);
        fclose($handle);
    }

    function createSccpFile($company_info = '')
    {

        $comp_id=$company_info['comp_id'];
        $this->class_fields=array();

        $defaultConfig['HEAD']['1']['key'] = '[7970](!)';
        $defaultConfig['HEAD']['1']['value'] = '';

        $defaultConfig['HEAD']['3']['key'] = 'addon';
        $defaultConfig['HEAD']['3']['value'] = '7970';

        $defaultConfig['HEAD']['4']['key'] = 'devicetype';
        $defaultConfig['HEAD']['4']['value'] = '7970';

        $defaultConfig['HEAD']['7']['key'] = 'type';
        $defaultConfig['HEAD']['7']['value'] = 'device';

        $defaultConfig['HEAD']['8']['key'] = 'keepalive';
        $defaultConfig['HEAD']['8']['value'] = '60';

        $defaultConfig['HEAD']['9']['key'] = ';tzoffset';
        $defaultConfig['HEAD']['9']['value'] = '+2';

        $defaultConfig['HEAD']['10']['key'] = 'transfer';
        $defaultConfig['HEAD']['10']['value'] = 'on';

        $defaultConfig['HEAD']['11']['key'] = 'park';
        $defaultConfig['HEAD']['11']['value'] = 'on';


        $defaultConfig['HEAD']['13']['key'] = 'cfwdbusy';
        $defaultConfig['HEAD']['13']['value'] = 'off';

        $defaultConfig['HEAD']['14']['key'] = 'cfwdnoanswer';
        $defaultConfig['HEAD']['14']['value'] = 'off';

        $defaultConfig['HEAD']['15']['key'] = 'directed_pickup';
        $defaultConfig['HEAD']['15']['value'] = 'on';

        $defaultConfig['HEAD']['16']['key'] = 'directed_pickup_context';
        $defaultConfig['HEAD']['16']['value'] = 'default';

        $defaultConfig['HEAD']['17']['key'] = 'directed_pickup_modeanswer';
        $defaultConfig['HEAD']['17']['value'] = 'on';

        $defaultConfig['HEAD']['18']['key'] = 'dndFeature';
        $defaultConfig['HEAD']['18']['value'] = 'on';

        $defaultConfig['HEAD']['19']['key'] = 'dnd';
        $defaultConfig['HEAD']['19']['value'] = 'off';

        $defaultConfig['HEAD']['20']['key'] = 'directrtp';
        $defaultConfig['HEAD']['20']['value'] = 'off';

        $defaultConfig['HEAD']['21']['key'] = 'earlyrtp';
        $defaultConfig['HEAD']['21']['value'] = 'progress';

        $defaultConfig['HEAD']['22']['key'] = 'private';
        $defaultConfig['HEAD']['22']['value'] = 'on';

        $defaultConfig['HEAD']['23']['key'] = 'mwilamp';
        $defaultConfig['HEAD']['23']['value'] = 'on';

        $defaultConfig['HEAD']['24']['key'] = 'mwioncall';
        $defaultConfig['HEAD']['24']['value'] = 'off';

        $defaultConfig['HEAD']['25']['key'] = 'setvar';
        $defaultConfig['HEAD']['25']['value'] = 'testvar=value';

        $defaultConfig['HEAD']['26']['key'] = 'cfwdall';
        $defaultConfig['HEAD']['26']['value'] = 'on';

        $defaultConfig['HEAD']['27']['key'] =
            PHP_EOL.
            '[line-'.$company_info['comp_name'].'](!)'.PHP_EOL.
            'id = 1000'.PHP_EOL.
            'type = line'.PHP_EOL.
            'pin = 1234'.PHP_EOL.
            'callgroup=1,3-4'.PHP_EOL.
            'pickupgroup=1,3-5'.PHP_EOL.
            ';amaflags ='.PHP_EOL.
            'context = context-'.$company_info['comp_name'].PHP_EOL.
            ';context = internal'.PHP_EOL.
            'incominglimit = 2'.PHP_EOL.
            'transfer = on'.PHP_EOL.
            'vmnum = 600'.PHP_EOL.
            'meetme = on'.PHP_EOL.
            'meetmeopts = qxd'.PHP_EOL.
            'meetmenum = 700'.PHP_EOL.
            'trnsfvm = 1000'.PHP_EOL.
            'secondary_dialtone_digits = 9'.PHP_EOL.
            'secondary_dialtone_tone = 0x22'.PHP_EOL.
            'musicclass=default'.PHP_EOL.
            'language=en'.PHP_EOL.
            'echocancel = on'.PHP_EOL.
            'silencesuppression = off'.PHP_EOL.
            'setvar=testvar2=my value'.PHP_EOL.
            'dnd = reject'.PHP_EOL.
            'parkinglot = myparkspace';


        $result = $this->getAllSipInfo($comp_id);

        while ($row = $result['rs']->fetch()) {
            if ($row['protocol'] == 'sccp') {
                $list[] = $row;
            }

        }


        $this->setFieldsSccp($list, $defaultConfig);

        if (file_exists($this->fileName)) {
            unlink($this->fileName);
        }

        $handle = fopen($this->fileName, 'w');
        ob_start();

        for ($i = 0; $i <= count($this->class_fields) - 1; $i++) {
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

        $this->logAMISccp('create Sccp',true);
        fwrite($handle, $buffer);
        fclose($handle);
    }

    function setFieldsSccp1($array_fields, $defaultConfig)
    {
        $count = 0;
        if (isset($defaultConfig['HEAD'])) {
            foreach ($defaultConfig['HEAD'] as $key => $fields) {
                $this->class_fields[$count][$fields['key']]['key'] = $fields['key'];
                $this->class_fields[$count][$fields['key']]['value'] = $fields['value'];
            }
        }

        foreach ($array_fields as $key => $fields) {
            $this->class_fields[$count]['extension_no']['key'] = '[' . $fields['extension_no'] . '-' . $fields['comp_name'] . ']';
            //$this->class_fields[$count]['extension_no']['key'] = '[' . $fields['extension_no'].']';
            $this->class_fields[$count]['extension_no']['value'] = '';

            if ($fields['caller_id_number'] != '') {
                $caller_id_number = $fields['caller_id_number'];
            } else {
                $caller_id_number = $fields['extension_no'];
            }

            $this->class_fields[$count]['caller_id']['key'] = 'callerid ';
            $this->class_fields[$count]['caller_id']['value'] = $fields['extension_name'] . ' <' . $caller_id_number . '> ';

            $this->class_fields[$count]['context']['key'] = 'context';
            $this->class_fields[$count]['context']['value'] = 'context-' . $fields['comp_name'];

            $this->class_fields[$count]['secret']['key'] = 'secret';
            $this->class_fields[$count]['secret']['value'] = $fields['secret'];



            /*$this->class_fields[$count]['type']['key'] = 'dial';
            $this->class_fields[$count]['type']['value'] = 'SIP/' . $fields['extension_no'];

            $this->class_fields[$count]['type']['key'] = 'callerid';
            $this->class_fields[$count]['type']['value'] = '(' . $fields['extension_no'] . ')';*/

            if ($fields['voicemail_status'] == '1') {

                $this->class_fields[$count]['mailbox']['key'] = 'mailbox';
                $this->class_fields[$count]['mailbox']['value'] = $fields['extension_no'] . '@voiceMail-' . $fields['comp_name'];

            }

            if (isset($defaultConfig['ALL'])) {
                foreach ($defaultConfig['ALL'] as $key => $fields) {
                    $this->class_fields[$count][$fields['key']]['key'] = $fields['key'];
                    $this->class_fields[$count][$fields['key']]['value'] = $fields['value'];
                }
            }

            $count++;
        }
    }

    function setFieldsSccp($array_fields, $defaultConfig)
    {

        $count = 0;
        if (isset($defaultConfig['HEAD'])) {
            foreach ($defaultConfig['HEAD'] as $key => $fields) {

                $this->class_fields[$count][$fields['key']]['key'] = $fields['key'];
                $this->class_fields[$count][$fields['key']]['value'] = $fields['value'];
            }
        }
        $count++;
        foreach ($array_fields as $key => $fields)
        {

            $this->class_fields[$count]['extension_no']['key'] = '[SEP' . str_replace(':','',$fields['mac_address']) . '](7970)';
            $this->class_fields[$count]['extension_no']['value'] = '';

            if ($fields['caller_id_number'] != '') {
                $caller_id_number = $fields['caller_id_number'];
            } else {
                $caller_id_number = $fields['extension_no'];
            }

            $this->class_fields[$count]['description']['key'] = 'description ';

            $this->class_fields[$count]['description']['value'] = $fields['extension_name'];

            /*$this->class_fields[$count]['context']['key'] = 'context';
            $this->class_fields[$count]['context']['value'] = 'context-' . $fields['comp_name'];*/

            $this->class_fields[$count]['button']['key'] = 'button';
            $this->class_fields[$count]['button']['value'] = 'line, '.$fields['extension_no'].'-'. $fields['comp_name'].',default';


            $this->class_fields[$count]['button-empty']['key'] = 'button';
            $this->class_fields[$count]['button-empty']['value'] = 'empty';
            $this->class_fields[$count]['button-empty']['key'] = '';
            $this->class_fields[$count]['button-empty']['value'] = '';

            $this->class_fields[$count]['context2']['key'] =
                '['.$fields['extension_no'].'-'.$fields['comp_name'].']'.'(line-'.$fields['comp_name'].')';
            $this->class_fields[$count]['context2']['value'] = '';

            $this->class_fields[$count]['label']['key'] = 'label';
            $this->class_fields[$count]['label']['value'] = $fields['extension_no'];


            $this->class_fields[$count]['description']['key'] = 'description';
            $this->class_fields[$count]['description']['value'] = 'Line '.$fields['extension_no'];

            //mailbox = 10011
            //$this->class_fields[$count]['mailbox']['key'] = 'description';
            // $this->class_fields[$count]['mailbox']['value'] = 'Line '.$fields['extension_no'];

            $this->class_fields[$count]['cid_name']['key'] = 'cid_name';
            $this->class_fields[$count]['cid_name']['value'] = $fields['extension_name'];

            $this->class_fields[$count]['cid_num']['key'] = 'cid_num';
            $this->class_fields[$count]['cid_num']['value'] = $caller_id_number;

            $this->class_fields[$count]['accountcode']['key'] = 'accountcode';
            $this->class_fields[$count]['accountcode']['value'] = $fields['secret'];



            // [407-eis](line-eis)//extension number-compname (line-compname)


            /*$this->class_fields[$count]['type']['key'] = 'dial';
             $this->class_fields[$count]['type']['value'] = 'SIP/' . $fields['extension_no'];

             $this->class_fields[$count]['type']['key'] = 'callerid';
             $this->class_fields[$count]['type']['value'] = '(' . $fields['extension_no'] . ')';*/


            /*if ($fields['voicemail_status'] == '1') {

               $this->class_fields[$count]['mailbox']['key'] = 'mailbox';
                $this->class_fields[$count]['mailbox']['value'] = $fields['extension_no'] . '@voiceMail-' . $fields['comp_name'];

            }*/

            if (isset($defaultConfig['ALL'])) {
                foreach ($defaultConfig['ALL'] as $key => $fields) {
                    $this->class_fields[$count][$fields['key']]['key'] = $fields['key'];
                    $this->class_fields[$count][$fields['key']]['value'] = $fields['value'];
                }
            }
            $count++;
        }
    }

    function setFieldsSip($array_fields, $defaultConfig)
    {
        $count = 0;
        if (isset($defaultConfig['HEAD'])) {
            foreach ($defaultConfig['HEAD'] as $key => $fields) {
                $this->class_fields[$count][$fields['key']]['key'] = $fields['key'];
                $this->class_fields[$count][$fields['key']]['value'] = $fields['value'];
            }
        }

        foreach ($array_fields as $key => $fields) {
            //Config For all Company
            $this->class_fields[$count]['extension_no']['key'] = '[' . $fields['extension_no'] . '-' . $fields['comp_name'] . ']';

            //Config For Just Zi-tel
            //$this->class_fields[$count]['extension_no']['key'] = '[' . $fields['extension_no'] .']';
            $this->class_fields[$count]['extension_no']['value'] = '';

            if ($fields['caller_id_number'] != '') {
                $caller_id_number = $fields['caller_id_number'];
            } else {
                $caller_id_number = $fields['extension_no'];
            }

            $this->class_fields[$count]['caller_id']['key'] = 'callerid ';
            $this->class_fields[$count]['caller_id']['value'] = $fields['extension_name'] . ' <' . $caller_id_number . '> ';

            $this->class_fields[$count]['context']['key'] = 'context';
            $this->class_fields[$count]['context']['value'] = 'context-' . $fields['comp_name'];

            $this->class_fields[$count]['secret']['key'] = 'secret';
            $this->class_fields[$count]['secret']['value'] = $fields['secret'];

            /*$this->class_fields[$count]['type']['key'] = 'dial';
            $this->class_fields[$count]['type']['value'] = 'SIP/' . $fields['extension_no'];

            $this->class_fields[$count]['type']['key'] = 'callerid';
            $this->class_fields[$count]['type']['value'] = '(' . $fields['extension_no'] . ')';*/

            $this->class_fields[$count]['busylevel']['key'] = 'busylevel';
            $this->class_fields[$count]['busylevel']['value'] = '2';


            $this->class_fields[$count]['canreinvite']['key'] = 'canreinvite';
            $this->class_fields[$count]['canreinvite']['value'] = 'no';

            if ($fields['voicemail_status'] == '1') {

                $this->class_fields[$count]['mailbox']['key'] = 'mailbox';
                $this->class_fields[$count]['mailbox']['value'] = $fields['extension_no'] . '@voiceMail-' . $fields['comp_name'];

            }

            if (isset($defaultConfig['ALL'])) {
                foreach ($defaultConfig['ALL'] as $key => $fields) {
                    $this->class_fields[$count][$fields['key']]['key'] = $fields['key'];
                    $this->class_fields[$count][$fields['key']]['value'] = $fields['value'];
                }
            }
            $count++;
        }
    }


    function getAllSipInfo($comp_id)
    {
        $conn = parent::getConnection();
        $append_sql = '';

        if ($comp_id != '') {
            $append_sql = "AND `tbl_extension`.`comp_id`=$comp_id ";
        }

        $sql = "
            SELECT
              `tbl_extension`.*,
              `tbl_company`.`comp_name`
            FROM
              `tbl_extension`
              LEFT JOIN `tbl_company` ON `tbl_extension`.`comp_id` = `tbl_company`.`comp_id`
              WHERE
                    `tbl_extension`.`trash`='0'
                AND `tbl_company`.`trash`='0'
                $append_sql
    
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
}


