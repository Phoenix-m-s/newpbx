<?php

class fileGeneratorRouting extends DataBase
{
    private $class_fields;
    public $debugMode;
    public $fileName;
    public $defaultConfig;
    function logAMIRouting($message, $isSuccessful) {
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

    function createRoutingFile($comp_id = '')
    {
        $defaultConfig = $this->defaultConfig;

        $result = $this->getAllRoutingInfo($comp_id);

        while ($row = $result['rs']->fetch()) {
            $list[] = $row;
        }

        $this->setFieldsRouting($list, $defaultConfig);

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
        //print_r_debug($buffer);

        fwrite($handle, $buffer);
        $this->logAMIRouting('---------------Routinglog-----------------', true);
        $this->logAMIRouting($buffer, true);
        $this->logAMIRouting('فایل Routing با موفقیت ثبت شد', true);
        $this->logAMIRouting('**********************', true);

        fclose($handle);
    }

    function setFieldsRouting($array_fields, $defaultConfig)
    {

        $count = 0;
        $this->class_fields[$count]['comp_name']['key'] = '[Routing]';
        $this->class_fields[$count]['comp_name']['value'] = '';
        foreach ($array_fields as $key => $fields) {
            $this->class_fields[$count]['phone']['key'] = 'exten' ;

            $this->class_fields[$count]['phone']['value'] = $fields['phone'] . ',1,NoOP()';
            $this->class_fields[$count]['phone']['operator'] = '=> ';

            $this->class_fields[$count]['same']['key'] = 'same' ;
            $this->class_fields[$count]['same']['value'] = 'n,Goto(trunk-'.$fields['comp_name'] .',${EXTEN},1)';
            $this->class_fields[$count]['same']['operator'] = '=> ';

            $this->class_fields[$count]['hangup']['key'] = 'same' ;
            $this->class_fields[$count]['hangup']['value'] = 'n,Hangup()';
            $this->class_fields[$count]['hangup']['operator'] = '=> ';


            $count++;
        }
        $this->class_fields[$count]['line1']['key'] = '[DID]';
        $this->class_fields[$count]['line1']['value'] = '';
        $this->class_fields[$count]['line1']['operator'] = '=> ';

        $this->class_fields[$count]['line2']['key'] = 'exten';
        $this->class_fields[$count]['line2']['value'] = '_.,1,AGI(RemovePlus.py,${CALLERID(dnid)})';
        $this->class_fields[$count]['line2']['operator'] = '=> ';

        $this->class_fields[$count]['line3']['key'] = 'exten';
        $this->class_fields[$count]['line3']['value'] = '_.,n,NoOp(The Dialed Number was:${CALLERID(dnid)})';
        $this->class_fields[$count]['line3']['operator'] = '=> ';

        $this->class_fields[$count]['line4']['key'] = 'exten';
        $this->class_fields[$count]['line4']['value'] ='_.,n,Execif($["${DID}" != ""]?Set(CALLERID(dnid)=${DID}))';
        $this->class_fields[$count]['line4']['operator'] = '=> ';

        $this->class_fields[$count]['line5']['key'] = 'exten';
        $this->class_fields[$count]['line5']['value'] ='_.,n,NoOp(The Dialed Number is:${CALLERID(dnid)})';
        $this->class_fields[$count]['line5']['operator'] = '=> ';

        $this->class_fields[$count]['line6']['key'] = 'exten';
        $this->class_fields[$count]['line6']['value'] ='_.,n,Goto(Routing,${CALLERID(dnid)},1)';
        $this->class_fields[$count]['line6']['operator'] = '=> ';

    }


    function getAllRoutingInfo($comp_id = '')
    {
        $conn = parent::getConnection();

        $append_sql = '';
        if ($comp_id != '') {
            $append_sql = "`routing`.`comp_id`=$comp_id ";
        }

        $sql = "
                    SELECT
                      `tbl_company`.`comp_name`,
                      `routing`.*
                    FROM
                      `routing`
                      LEFT JOIN `tbl_company` ON `routing`.`comp_id` = `tbl_company`.`comp_id`
                     
                      order by `tbl_company`.`comp_name` asc;
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
