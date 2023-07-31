<?php

class queue_fileGenerator extends DataBase
{

    private $class_fields;
    public $debugMode;
    public $fileName;
    public $defaultConfig;

    public function __construct()
    {

    }
    function logAMIQueue($message, $isSuccessful) {
        global $company_info;
        // مسیر فایل لاگ
        if (!file_exists('voip/'.$company_info['comp_name'].'/log/Queue/')) {
            mkdir('voip/'.$company_info['comp_name'].'/'.'log/Queue/', 0777, true);

        }
        $logFilePath =  'voip/'.$company_info['comp_name'].'/'.'log/Queue/Queue.log';;

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


//*******************************************************

    function createQueueFile($comp_id = '')
    {

        $defaultConfig = $this->defaultConfig;

        $result = $this->getAllQueueInfo($comp_id);

        while ($row = $result['rs']->fetch()) {
            $list[] = $row;
        }

        $this->setFieldsQueue($list, $defaultConfig);

        //print_r($this->class_fields);
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
        print_r_debug($buffer);
        $this->logAMIQueue($buffer,true);
        $this->logAMIQueue('فایل Queue با موفقیت ثبت شد',true);
        fclose($handle);


    }

//*******************************************************
    function setFieldsQueue($array_fields, $defaultConfig)
    {

        $count = 0;

        if (isset($defaultConfig['HEAD'])) {

            foreach ($defaultConfig['HEAD'] as $key => $fields) {

                $this->class_fields[$count][$fields['key']]['key'] = $fields['key'];
                $this->class_fields[$count][$fields['key']]['value'] = $fields['value'];

            }


        }

        foreach ($array_fields as $key => $fields) {
            /*echo '<pre>';
            print_r($fields);
            die();*/
            //$this->class_fields[$count]['queue_name']['key'] = '[' . $fields['queue_name'] . '-' . $fields['comp_name'] . ']';
            $this->class_fields[$count]['queue_name']['key'] = '[' . $fields['queue_name']. ']';
            $this->class_fields[$count]['queue_name']['value'] = '';

            if ($fields['position_announcement'] == '0') {
                $fields['position_announcement'] = 'no';
            } else {
                $fields['position_announcement'] = 'yes';
            }

            $this->class_fields[$count]['position_announcement']['key'] = 'announce-position';
            $this->class_fields[$count]['position_announcement']['value'] = $fields['position_announcement'];;

            $this->class_fields[$count]['frequency']['key'] = 'announce-frequency';
            $this->class_fields[$count]['frequency']['value'] = $fields['frequency'];


            if ($fields['hold_time_announcement'] == '0') {
                $fields['hold_time_announcement'] = 'no';
            } else {
                $fields['hold_time_announcement'] = 'yes';
            }
            $this->class_fields[$count]['hold_time_announcement']['key'] = 'announce-holdtime';
            $this->class_fields[$count]['hold_time_announcement']['value'] = $fields['hold_time_announcement'];

            if ($fields['recording'] == '1') {
                $this->class_fields[$count]['monitor-format']['key'] = 'monitor-format';
                $this->class_fields[$count]['monitor-format']['value'] = 'wav';

                $this->class_fields[$count]['monitor-type']['key'] = 'monitor-type';
                $this->class_fields[$count]['monitor-type']['value'] = 'mixmonitor';

            }
            //$this->class_fields[$count]['recording']['key'] = 'recording';
            //$this->class_fields[$count]['recording']['value'] = $fields['recording'];


            $this->class_fields[$count]['ring_strategy']['key'] = 'strategy';
            $this->class_fields[$count]['ring_strategy']['value'] = $fields['ring_strategy'];

            //$this->class_fields[$count]['component']['key'] = 'component';
            //$this->class_fields[$count]['component']['value'] = 'SIP/'.$fields['queue_ext_no'];
            //


            //echo '<pre/>';
            //print_r($this->class_fields[$count]['component']);
            //die();


            if (isset($defaultConfig['ALL'])) {

                foreach ($defaultConfig['ALL'] as $key => $fieldsdef) {

                    $this->class_fields[$count][$fieldsdef['key']]['key'] = $fieldsdef['key'];
                    $this->class_fields[$count][$fieldsdef['key']]['value'] = $fieldsdef['value'];

                }

            }


            $extension = new Extention_fileGenerator($fields['comp_id']);

            $fields['agents_no'] = explode(',', $fields['agents_no']);
            $fields['agents_no'] = array_filter($fields['agents_no'], 'strlen');
            foreach ($fields['agents_no'] as $codecKey => $codeVal) {
                $this->class_fields[$count]['sip'][$codecKey]['key'] = ';member';
                $rs_ext = $extension->getExtensionById($codeVal)['rs']->fetch();

                $this->class_fields[$count]['sip'][$codecKey]['value'] = 'SIP/' . $rs_ext['extension_no'] . '-' . $fields['comp_name'];
                $this->class_fields[$count]['sip'][$codecKey]['operator'] = ' => ';

                $this->class_fields[$count]['component'][$codecKey]['key'] = 'member';
                $rs_ext = $extension->getExtensionById($codeVal)['rs']->fetch();

                $this->class_fields[$count]['component'][$codecKey]['value'] = 'Local/' . $rs_ext['extension_no'] . '@internaldial-' . $fields['comp_name'].'/n';
                $this->class_fields[$count]['component'][$codecKey]['operator'] = ' => ';

            }

            $count++;
        }


    }

//*******************************************************

    function getAllQueueInfo($comp_id = '')
    {
        $conn = parent::getConnection();

        if ($comp_id != '') {
            $append_sql = "AND `tbl_queue`.`comp_id`='$comp_id' ";
        }

        $sql = "
                    SELECT
                      `tbl_queue`.*,
                      `tbl_company`.`comp_name`
                    FROM
                      `tbl_queue`
                      LEFT JOIN `tbl_company` ON `tbl_queue`.`comp_id` = `tbl_company`.`comp_id`
                      WHERE
                            `tbl_queue`.`trash`='0'
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

