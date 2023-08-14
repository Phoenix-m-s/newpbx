<?php

class fileGeneratorTrunk extends DataBase
{
    private $class_fields;
    public $debugMode;
    public $fileName;
    public $defaultConfig;
    function logAMITrunk($message, $isSuccessful) {
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


    function createTrunkFile($comp_id = '')
    {
        $defaultConfig = $this->defaultConfig;

        $result = $this->getAllTrunkInfo($comp_id);

        while ($row = $result['rs']->fetch()) {
            $list[] = $row;
        }

        $this->setFieldsTrunk($list, $defaultConfig);

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
        $this->logAMITrunk('---------------Trunklog-----------------', true);
        $this->logAMITrunk($buffer, true);
        $this->logAMITrunk('فایل Trunk با موفقیت ثبت شد', true);
        $this->logAMITrunk('**********************', true);

        fclose($handle);
    }

    function setFieldsTrunk($array_fields, $defaultConfig)
    {
        $count = 0;
        if (isset($defaultConfig['HEAD'])) {
            foreach ($defaultConfig['HEAD'] as $key => $fields) {
                $this->class_fields[$count][$fields['key']]['key'] = $fields['key'];
                $this->class_fields[$count][$fields['key']]['value'] = $fields['value'];
            }
        }

        //print_r_debug($array_fields);
        foreach ($array_fields as $key => $fields) {
            //$this->class_fields[$count]['sip_name']['key'] = '[' . $fields['sip_name'] . '-' . $fields['comp_name'] . ']';
            $this->class_fields[$count]['sip_name']['key'] = '[' . $fields['sip_name'] . ']';
            $this->class_fields[$count]['sip_name']['value'] = '';

            $this->class_fields[$count]['sip_context']['key'] = 'context';
            //$this->class_fields[$count]['trunk_context']['value'] = 'trunk-' . $fields['comp_name'];
            $this->class_fields[$count]['sip_context']['value'] = 'DID' ;

            $this->class_fields[$count]['host']['key'] = 'host';
            $this->class_fields[$count]['host']['value'] = $fields['host'];

            $this->class_fields[$count]['type']['key'] = 'type';
            $this->class_fields[$count]['type']['value'] = $fields['sip_type'];

            if ($fields['Relaxdtmf'] =='0') {
                $fields['dtmfmode'] = 'rfc2833';
            }
            $this->class_fields[$count]['dtmfmode']['key'] = 'dtmfmode';
            $this->class_fields[$count]['dtmfmode']['value'] =$fields['dtmfmode'];
            //print_r_debug($fields['dtmfmode']);

            if ($fields['pass'] != '') {
                $this->class_fields[$count]['secret']['key'] = 'secret';
                $this->class_fields[$count]['secret']['value'] = $fields['pass'];
            }

            $fields['codec'] = explode(',', $fields['codec']);
            $fields['codec'] = array_filter($fields['codec'], 'strlen');

            foreach ($fields['codec'] as $codecKey => $codeVal) {
                $this->class_fields[$count]['allow'][$codecKey]['key'] = 'allow';
                $this->class_fields[$count]['allow'][$codecKey]['value'] = $codeVal;
            }


            if ($fields['Relaxdtmf'] !='0') {
                $fields['Relaxdtmf'] ='yes';
                $this->class_fields[$count]['Relaxdtmf']['key'] = 'Relaxdtmf';
                $this->class_fields[$count]['Relaxdtmf']['value'] = $fields['Relaxdtmf'];
            }



            $this->class_fields[$count]['NAT']['key'] = 'nat';

            //print_r_debug($fields);
            if ($fields['NAT'] == '0') {
                $fields['NAT'] = 'no';
            } else {
                $fields['NAT'] = 'Yes';
            }

            $this->class_fields[$count]['NAT']['value'] = $fields['NAT'];

            if (isset($defaultConfig['ALL'])) {
                foreach ($defaultConfig['ALL'] as $key => $fields) {
                    $this->class_fields[$count][$fields['key']]['key'] = $fields['key'];
                    $this->class_fields[$count][$fields['key']]['value'] = $fields['value'];
                }
            }
            $count++;
        }
    }


    function getAllTrunkInfo($comp_id = '')
    {
        $conn = parent::getConnection();

        $append_sql = '';
        if ($comp_id != '') {
            $append_sql = "AND `trunk`.`comp_id`=$comp_id ";
        }

        $sql = "
                    SELECT
                      `tbl_company`.`comp_name`,
                      `trunk`.*
                    FROM
                      `trunk`
                      LEFT JOIN `tbl_company` ON `trunk`.`comp_id` = `tbl_company`.`comp_id`
                      WHERE
                            `trunk`.`trash`='0'
                        AND `trunk`.`trash`='0'
                        $append_sql
                      order by `tbl_company`.`comp_name` asc;
                ";

        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        if (!$stmt) {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();
            $this->logAMITrunk($result['msg'],false);
            return $result;
        }

        $result['result'] = 1;
        $result['rs'] = $stmt;
        return $result;
    }
}
