<?php
/**
 * Created by PhpStorm.
 * User: VeRJiL
 * Date: 2/4/2017
 * Time: 1:42 PM
 */

include_once ROOT_DIR . "component/upload/AdminUploadModel.php";
include_once ROOT_DIR . "services/TblDstOptionService.php";
include_once ROOT_DIR . "component/extension/AdminExstionNewModel.php";
include_once ROOT_DIR . "component/company/AdminCompanyModel.php";
include_once ROOT_DIR . "component/voip_config/AdminVoipConfigModel.php";
include_once ROOT_DIR . "component/voip_config/FileGenerator.php";
include_once ROOT_DIR . "common/init.inc.php";
include_once ROOT_DIR . "common/func.inc.php";



/**
 * @author VeRJiL
 * @version 0.0.1
 * @copyright 2017 The Imen Daba Parsian Co.
 */
class adminVoipConfigController
{
    /**
     * @var
     */
    private $error;
    /**
     * @var
     */
    private $fileName;
    /**
     * @var
     */
    private $exportType;

    /**
     * @var array
     */
    private $msg = [];

    /**
     * @Email :sakhamanesh@dabacenter.ir
     * @param $list
     * @param $message
     */
    private function template($list, $message)
    {
        switch ($this->exportType) {
            case 'html':
                include ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_start.tpl";
                include ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_header.tpl";
                include ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_rightMenu.tpl.php";
                include ROOT_DIR . "templates/" . CURRENT_SKIN . "/adminVoipConfigController.php";
                include ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_footer.tpl";
                include ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_end.tpl";
                break;
        }
    }

    /**
     *
     */
    public function showVoipConfig()
    {
      /*  $inboundDirty = AdminInboundModel::getAll()->getList();
        $inboundClean = $inboundDirty['export']['list'];*/
        $this->exportType = 'html';
        $this->fileName = '';
        $this->template('', '');
    }

    /**
     * @Email :sakhamanesh@dabacenter.ir
     * @param $fields
     * @param $message
     */
    public function createFile($fields, $message)
    {

        $companyObj = new AdminCompanyModel();
        $company = $companyObj->find($fields['comp_id'])->getList();
        $companyName = $company['export']['list'][0];
        $voip = new FileGenerator();
        $floderName =$fields['macAddress'];
        //macAddress
        //$macAddress='macAddress:'.$fields['macAddress'] ;
        //$voip->add($macAddress);
        //image_version
        $image_version='image_version:'.'" P0S3-8-12-00 "' ;
        $voip->add($image_version);



        //line1_name101
        $line1_name ='line1_name:' .'"'.$fields['line1_name'].'-'.$companyName['comp_name'].'"';
        $voip->add($line1_name);


        //line1_authname
        $line1_authname ='line1_authname:' .'"'.$fields['line1_authname'].'-'.$companyName['comp_name'].'"';
        $voip->add($line1_authname);


        //line1_password
        $line1_password ='line1_password: '.'"'.$fields['line1_password'].'"';
        $voip->add($line1_password);


        //line1_shortname
        $line1_shortname ='line1_shortname: '.'"'.$fields['line1_shortname'].'"';
        $voip->add($line1_shortname);

        //line1_displayname
        $line1_displayname ='line1_displayname:'.'"'.$fields['line1_shortname'].'"';
        $voip->add($line1_displayname);

        //proxy1_port
        $proxy1_port ='proxy1_port:'.'"'.$fields['proxy1_port'].'"';
        $voip->add($proxy1_port);

        //proxy1_address
        $proxy1_address ='proxy1_address:'.$fields['proxy1_address'];
        $voip->add($proxy1_address);

        //nat_enable
        $nat_enable ='nat_enable:'.'"1"';
        $voip->add($nat_enable);


        //proxy_register
        $proxy_register ='proxy_register:'.'"1"';
        $voip->add($proxy_register);

        //Phone Label
        $PhoneLabe ='# Phone Label (Text desired to be displayed in upper right corner)';
        $voip->add($PhoneLabe);

        //Phone Label1
        $PhoneLabe1 ='phone_label: " " ; add a space at the end, looks neater';
        $voip->add($PhoneLabe1);

        //Phone Label1


        //$phone_password
        $phone_password ='phone_password: "cisco" ; Limited to 31 characters (Default - cisco)';
        $voip->add($phone_password);


        //user_info

        $user_info ='user_info:'."none";
        $voip->add($user_info);

        //telnet_level
        $telnet_level ='telnet_level :'.'"2"';
        $voip->add($telnet_level);

        //logo_url

        $logo_url= 'logo_url:'.'" http://172.31.0.96/cisco.bmp"';
        $voip->add($logo_url);



        $res = $voip->create(UPLOAD_VOIPCONFIG_DIR.'SIP'.str_replace(":","",$floderName).'.cnf','SIP'.$floderName.'.cnf');
        // $res = $voip->create('ftp://192.168.110.160'.'SIP'.$floderName.'.cnf');

        $listExtension = AdminVoipConfigModel::getBy_macAddress($fields['macAddress'])->first();

        $fields['devicemodels']=$fields['chooseDevice'];
        if(is_object($listExtension)){
            $listExtension->setFields($fields);
            $listExtension->save();
        }
        else{
            $voipConfig = new AdminVoipConfigModel();
            $fields['path']='SIP'.str_replace(":","",$floderName).'.cnf';
            $voipConfig->setFields($fields);
            $voipConfig->save();
        }

        $fields['comp_id'] = $companyName['comp_id'];
        $result['deviceId']=$fields['chooseDevice'];

        $result['macAddress']=$fields['macAddress'];
        $result['path']='SIP'.str_replace(":","",$floderName).'.cnf';
        $result['result'] = 1;
        $result['msg'] = 'Successfully Update';
        echo json_encode($result);
        die();



    }

    public function addVoipConfigForm($id)
    {
        $extenList = new AdminExstionNewModel();
        $listExtension = AdminExstionNewModel::getBy_extension_id($id)->getList();
        $res = $list['voipConfigList'] = $listExtension['export']['list'][0];
        $this->exportType = 'html';
        $this->fileName = 'add.voipConfigNew.php';
        $this->template($res, $message='');
        die();
    }
    public function addNewVoipConfigForm($id)
    {
        $extenList = new AdminExstionNewModel();
        $listExtension = AdminExstionNewModel::getBy_extension_id($id)->getList();
        $res = $list['voipConfigList'] = $listExtension['export']['list'][0];
        $this->exportType = 'html';
        $this->fileName = 'add.extesionNew.php';
        $this->template($res, $message='');
        die();
    }



    /**
     * @Email :sakhamanesh@dabacenter.ir
     * @param $inboundID
     * @param $message
     * @param array $fields
     */
    public function UpdateFile($fields, $message,$companyName)
    {
        $fields['comp_id']=$companyName['comp_id'];
      /*  $listExtension = AdminVoipConfigModel::($fields['deviceId'])->get()['export']['list'][0];*/
        $listExtension ='';
        $listExtension->setFields($fields);
        $listExtension->save();
        $result['result'] = 1;
        $result['msg'] = 'Successfully Update';
        $result['deviceId']=$listExtension->id;
        $result['path']=$listExtension->path;
        echo json_encode($result);
        die();


/*
        $this->exportType = 'html';
        $this->fileName = 'VoipConfig.form.php';
        $this->template($list, $message);
        die();*/
    }
    public function download($name){
        $path = UPLOAD_VOIPCONFIG_DIR.$name;

        if (file_exists($path)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($path).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($path));
            readfile($path);
            exit;
        }

    }

    public function downloadSccp($mac){
        $server=SERVER_IP;

        $buffer = "<device>
                 <devicePool>
                  <callManagerGroup>
                   <members>
                    <member  priority=\"0\">
                     <callManager>
                      <ports>
                       <ethernetPhonePort>2000</ethernetPhonePort>
                      </ports>
                      <processNodeName>$server</processNodeName>
                     </callManager>
                    </member>
                   </members>
                  </callManagerGroup>
                 </devicePool>
                 <versionStamp>{Jan 01 2002 00:00:00}</versionStamp>
                 <loadInformation></loadInformation>
                 <userLocale>
                  <name>English_United_States</name>
                  <langCode>en</langCode>
                 </userLocale>
                 <networkLocale>United_States</networkLocale>
                 <idleTimeout>0</idleTimeout>
                 <authenticationURL></authenticationURL>
                 <directoryURL></directoryURL>
                 <idleURL></idleURL>
                 <informationURL></informationURL>
                 <messagesURL></messagesURL>
                 <proxyServerURL></proxyServerURL>
                 <servicesURL></servicesURL>
                </device>";


        $mac=str_replace(' ','',$mac);
        $mac=str_replace(':','',$mac);

        $fileName='SEP'.$mac.'.cnf.xml';
        $path = ROOT_DIR.'voip/' .'SEP'.$mac.'.cnf.xml';

        if (file_exists($path)) {
            unlink($path);
        }

        $handle = fopen($path, 'w');

        fwrite($handle, $buffer);
        fclose($handle);

        //$a=readfile($path);
        //print_r_debug($a);

        //if (file_exists($path)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($path).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($path));
            readfile($path);
            exit;
        //}

    }

}