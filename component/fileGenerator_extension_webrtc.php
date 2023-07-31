<?php

/**
 * Class Extention_fileGenerator
 * Created by DNA
 */
//include_once ROOT_DIR . "component/voip_config/FileGenerator.php";
include_once ROOT_DIR . "component/extension/AdminExstionNewModel.php";


class Extention_fileGenerator_webrtc
{

    public $fileName;

    public $company_info;

    public $class_fields;

    /**
     * @param $comp_id
     */
    public function __construct($company_info)
    {
        $this->company_info = $company_info;

    }
    public function add($data)
    {
        $this->class_fields[] = $data;
    }
   function logAMIExtensionWebrtc($message, $isSuccessful) {
        global $company_info;
        // مسیر فایل لاگ
        if (!file_exists('voip/'.$company_info['comp_name'].'/log/ExtensionWebrtc/')) {
            mkdir('voip/'.$company_info['comp_name'].'/'.'log/ExtensionWebrtc/', 0777, true);

        }
        $logFilePath =  'voip/'.$company_info['comp_name'].'/'.'log/ExtensionWebrtc/ExtensionWebrtc.log';;

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


    public function createExtensionWebrtcFile()
    {
        $listExtension = AdminExstionNewModel::getBy_extension_type('2')->getList();


        foreach ($listExtension['export']['list'] as $key => $fields)
        {

            $str = '['.$fields['extension_no'] . '-'.$this->company_info['comp_name'].']';
            $this->add($str);

            $this->add('host=dynamic');

            $str = 'secret='.$fields['extension_no'];
            $this->add($str);

            $str = 'context=context-'.$this->company_info['comp_name'];
            $this->add($str);
            $this->add('type=friend');
            $this->add('encryption=yes');
            $this->add('avpf=yes');
            $this->add('force_avp=yes');
            $this->add('icesupport=yes');
            $this->add('directmedia=no');
            $this->add('disallow=all');
            $this->add('allow=opus');
            $this->add(';allow=ulaw');
            $this->add('dtlsenable=yes');
            $this->add('dtlsverify=fingerprint');
            $this->add('dtlscertfile=/etc/asterisk/keys/asterisk.pem');
            $this->add('dtlscafile=/etc/asterisk/keys/ca.crt');
            $this->add('dtlssetup=actpass');
            $this->add('rtcp_mux=yes');
            $this->add('qualify=yes');
            $strCallerId = 'callerid='.$fields['extension_name'] .' <' . $fields['caller_id_number'] . '> ';
            $this->add($strCallerId);
            $this->add('');
            $this->add(';-------------------------------');
            $this->add('');
        }
        $this->create();
    }




    public function create()
    {
        $content = '';
        foreach ($this->class_fields as $key => $value) {
            $content .= PHP_EOL . $value;


        }
        //$this->logAMIExtensionWebrtc($content,true);
        //$this->createExtensionWebrtcFile('فایل اکستنشن وب ارت سی',true);

        if (file_put_contents($this->fileName, $content)) {
            $result['result'] = 1;
            $svgContent = '';
            $result['content'] = $svgContent;
            //print_r_debug($result);
            return $result;
        }

    }


}