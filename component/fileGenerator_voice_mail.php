<?php

class voice_mail_fileGenerator extends DataBase
{
    private $class_fields;
    public $debugMode;
    public $fileName;
    public $defaultConfig;
    function logAMIVoiceMail($message, $isSuccessful) {
        global $company_info;
        // مسیر فایل لاگ
        if (!file_exists('voip/'.$company_info['comp_name'].'/log/Trunk/')) {
            mkdir('voip/'.$company_info['comp_name'].'/'.'log/Trunk/', 0777, true);

        }
        $logFilePath =  'voip/'.$company_info['comp_name'].'/'.'log/Trunk/Trunk.log';;

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


    function createVoiceMailFile($comp_id = '')
    {
        $defaultConfig = $this->defaultConfig;

        $result = $this->getAllVoiceMailInfo($comp_id);

        while ($row = $result['rs']->fetch()) {
            $list[] = $row;
        }

        $this->setFieldsVoiceMail($list, $defaultConfig);

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

        fwrite($handle, $buffer);
        $this->logAMIVoiceMail($buffer,true);
        $this->logAMIVoiceMail('فایل VoiceMail با موفقیت ثبت شد',true);
        fclose($handle);
    }

    function setFieldsVoiceMail($array_fields, $defaultConfig)
    {
        $count = 0;
        if (isset($defaultConfig['HEAD'])) {
            foreach ($defaultConfig['HEAD'] as $key => $fields) {
                $this->class_fields[$count][$fields['key']]['key'] = $fields['key'];
                $this->class_fields[$count][$fields['key']]['value'] = $fields['value'];
            }
        }

        $count_temp = 0;
        foreach ($array_fields as $key => $fields) {
            if ($count_temp == 0) {
                $this->class_fields[$count]['VoiceMail']['key'] = '[voiceMail-' . $fields['comp_name'] . ']';
                $this->class_fields[$count]['VoiceMail']['value'] = '';
                $count_temp++;
            }

            if ($fields['voicemail_email'] == '') {
                continue;
            }

            $this->class_fields[$count]['extension_no']['key'] = $fields['extension_no'];
            $this->class_fields[$count]['extension_no']['value'] = $fields['voicemail_pass'] . ',' . $fields['extension_name'] . ',' . $fields['voicemail_email'] . ',,attach=yes ';
            $this->class_fields[$count]['extension_no']['operator'] = ' => ';

            if (isset($defaultConfig['ALL'])) {
                foreach ($defaultConfig['ALL'] as $key => $fields) {
                    $this->class_fields[$count][$fields['key']]['key'] = $fields['key'];
                    $this->class_fields[$count][$fields['key']]['value'] = $fields['value'];
                }
            }
            $count++;
        }
    }

    function getAllVoiceMailInfo($comp_id = '')
    {
        $conn = parent::getConnection();

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