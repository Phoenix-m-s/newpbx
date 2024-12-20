<?php

include_once "server.inc.php";

include_once ROOT_DIR . "common/db.inc.php";
include_once ROOT_DIR . "common/init.inc.php";
include_once ROOT_DIR . "common/func.inc.php";
include_once ROOT_DIR . "component/db.inc.class.php";
include_once ROOT_DIR . "component/php-ami-class.php";

global $admin_info, $company_info;

function logAMIAllInclude($message,$isSuccessful) {
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

if ($company_info == -1) {
    if ($member_info != -1) {
        redirectPage(RELA_DIR, "You dont have the permission to this page");
    }
    redirectPage(RELA_DIR, '');
}

if (!file_exists('voip/'.$company_info['comp_name'])) {
    mkdir('voip/'.$company_info['comp_name'].'/', 0777, true);

}
if (!file_exists('voip/'.$company_info['comp_name'].'/monitor/')) {
    mkdir('voip/'.$company_info['comp_name'].'/'.'monitor/', 0777, true);

}

/*
| --------------------------------------------------------------------------------------
|
| Creating EXTENSION File
|
| --------------------------------------------------------------------------------------
*/
include_once ROOT_DIR . "component/fileGenerator_extension.php";
include_once ROOT_DIR . "component/fileGenerator_extension_webrtc.php";



/*
| --------------------------------------------------------------------------------------
| Fetches all the company from company database
| --------------------------------------------------------------------------------------
*/


$All_comp_list_new = Extention_fileGenerator::getCompanyList();
$extension_file_name = ROOT_DIR . 'voip/exten.conf';


if (file_exists($extension_file_name)) {
    unlink($extension_file_name);
}

$handle = fopen($extension_file_name, 'w');


ob_start();

foreach ($All_comp_list_new['list'] as $key => $comp_fields) {
    $file_name = $comp_fields['comp_name'] . '-exten.conf';

    echo '#include' .' '.ROOT_DIR . 'voip/' .$comp_fields['comp_name'].'/'.$file_name . PHP_EOL;
}

$buffer = ob_get_contents();

ob_end_clean();

fwrite($handle, $buffer);
logAMIAllInclude('create all exten.conf'.$company_info['comp_name'], true);

fclose($handle);


/*
| --------------------------------------------------------------------------------------

 Exten for company

| --------------------------------------------------------------------------------------
*/
$All_comp_list = Extention_fileGenerator::getCompany();


$extension_file_name = ROOT_DIR . 'voip/'. $company_info['comp_name'] . '/exten';


$handle = fopen($extension_file_name.'.conf', 'w');

ob_start();

foreach ($All_comp_list['list'] as $key => $comp_fields) {
    $file_name = $comp_fields['comp_name'] . '-exten.conf';

    echo '#include' .' '.ROOT_DIR . 'voip/' .$comp_fields['comp_name'].'/'.$file_name . PHP_EOL;
}

$buffer = ob_get_contents();

ob_end_clean();

fwrite($handle, $buffer);

logAMIAllInclude('create exten.conf'.$company_info['comp_name'], true);

fclose($handle);

/*
| --------------------------------------------------------------------------------------

create ExtensionWebrtc

| --------------------------------------------------------------------------------------
*/
$comp_list = Extention_fileGenerator::getCompany($company_info['comp_id']);


$comp_list = $comp_list['list'];

foreach ($comp_list as $key => $fields) {

    $extension = new Extention_fileGenerator($fields['comp_id']);

    $extension->debugMode = '0';

    $temp_file_name = $fields['comp_name'] . '-exten.conf';

    $extension->fileName = ROOT_DIR . 'voip/' .$fields['comp_name'].'/'. $temp_file_name;

    $extension->createExtensionFile();


    $extension_webrtc = new Extention_fileGenerator_webrtc($fields);

    $temp_file_name = $fields['comp_name'] . '-sip-webrtc.conf';

    $extension_webrtc->fileName = ROOT_DIR . 'voip/'.$company_info['comp_name'].'/'. $temp_file_name;

    $extension_webrtc->createExtensionWebrtcFile();

    logAMIAllInclude('ExtensionWebrtc.conf'.$company_info['comp_name'], true);


}

/*
| --------------------------------------------------------------------------------------
|
| Creating SIP File
|
| --------------------------------------------------------------------------------------
*/

include_once ROOT_DIR . "component/fileGenerator_sip_user.php";

/*
| --------------------------------------------------------------------------------------
| Defining the constants of the file generator for SIP
| --------------------------------------------------------------------------------------
*/

$defaultConfig['ALL']['1']['key'] = 'host';
$defaultConfig['ALL']['1']['value'] = 'dynamic';

$defaultConfig['ALL']['2']['key'] = ';trustrpid';
$defaultConfig['ALL']['2']['value'] = 'yes';

$defaultConfig['ALL']['3']['key'] = 'type';
$defaultConfig['ALL']['3']['value'] = 'friend';

$defaultConfig['ALL']['4']['key'] = 'nat';
$defaultConfig['ALL']['4']['value'] = 'force_rport,comedia';

$defaultConfig['ALL']['5']['key'] = 'qualify';
$defaultConfig['ALL']['5']['value'] = 'yes';

$defaultConfig['ALL']['6']['key'] = 'callcounter';
$defaultConfig['ALL']['6']['value'] = 'yes';


$sipObj = new sip_user_fileGenerator();

/*
| --------------------------------------------------------------------------------------
| if debugMode is set to 1 then it shows
| the array that filled with the data
| and if it sets to 0 then it
| wont show anything
| --------------------------------------------------------------------------------------
*/
$sipObj->debugMode = '0';
/*if (file_exists($extension_file_name)) {
    //unlink($extension_file_name);
}*/
$sipObj->fileName = ROOT_DIR . 'voip/' .$company_info['comp_name'].'/'. $company_info['comp_name']. '-sip-user'. '.conf';
$sipObj->defaultConfig = $defaultConfig;

$sipObj->createSipFile($company_info['comp_id']);
/*if (!file_exists($fields['comp_name'])) {
    mkdir($fields['comp_name'], 0777, true);
}*/
$sipObj->fileName = ROOT_DIR . 'voip/' .$company_info['comp_name'].'/'.$company_info['comp_name'] .'-sccp-user'.  '.conf';

$sipObj->defaultConfig = '';//$defaultConfig;

$sipObj->createSccpFile($company_info);
logAMIAllInclude('Creating SIP File'.$company_info['comp_name'], true);



/*
| --------------------------------------------------------------------------------------
|
| Creating All SipUserConf
|
| --------------------------------------------------------------------------------------
*/
$All_comp_list_new = Extention_fileGenerator::getCompanyList();
$sip_file_name = ROOT_DIR . 'voip/sip.conf';
if (file_exists($sip_file_name)) {
    unlink($sip_file_name);
}

$handle = fopen($sip_file_name, 'w');
ob_start();

foreach ($All_comp_list_new['list'] as $key => $comp_fields) {

    $file_name = $comp_fields['comp_name'] .'-sip-user'.'.conf';

    echo '#include  '.ROOT_DIR.'voip/'. $comp_fields['comp_name'] .'/'.$file_name . PHP_EOL;
}

$buffer = ob_get_contents();
ob_end_clean();
fwrite($handle, $buffer);
logAMIAllInclude('Creating All SipUserConf'.$company_info['comp_name'],true);
fclose($handle);



/*
| --------------------------------------------------------------------------------------
|
| Creating SIP TRUNK File
|
| --------------------------------------------------------------------------------------
*/

include_once ROOT_DIR . "component/fileGenerator_sip_trunk.php";

unset($defaultConfig);
/*$defaultConfig['ALL'][1]['key'] = 'dtmfmode';
$defaultConfig['ALL'][1]['value'] = 'inband';*/


$defaultConfig['ALL'][2]['key'] = 'qualify';

$defaultConfig['ALL'][2]['value'] = 'yes';

$sipTrunkObj = new sip_trunk_fileGenerator();

$sipTrunkObj->debugMode = '0';

$sipTrunkObj->fileName = ROOT_DIR . 'voip/'.$company_info['comp_name'] .'/'.$company_info['comp_name']. '-sip-trunk'.'.conf';

$sipTrunkObj->defaultConfig = $defaultConfig;

$sipTrunkObj->createSipFile($company_info['comp_id']);


$extension_file_name = ROOT_DIR . 'voip/'.$company_info['comp_name'] .'/'.$company_info['comp_name'].'/sip-trunk.conf';

if (file_exists($extension_file_name)) {
    unlink($extension_file_name);
}

$handle = fopen($extension_file_name, 'w');
ob_start();

foreach ($All_comp_list['list'] as $key => $comp_fields) {

    $file_name =  $comp_fields['comp_name'] .'-sip-trunk'.'.conf';
    echo '#include  ' .ROOT_DIR.'voip/'. $comp_fields['comp_name'] .'/'.$file_name . PHP_EOL;
}

$buffer = ob_get_contents();
ob_end_clean();
fwrite($handle, $buffer);

logAMIAllInclude('sip-trunk.conf'.$company_info['comp_name'],true);

fclose($handle);

/*
| --------------------------------------------------------------------------------------
|
| Creating TRUNK File
|
| --------------------------------------------------------------------------------------
*/
//include_once ROOT_DIR . "componet/fileGeneratorTrunk.php";

/*
| --------------------------------------------------------------------------------------
| Defining the constants of the file generator for SIP
| --------------------------------------------------------------------------------------
*/

$defaultConfig['ALL']['1']['key'] = 'host';
$defaultConfig['ALL']['1']['value'] = 'dynamic';

$defaultConfig['ALL']['2']['key'] = ';trustrpid';
$defaultConfig['ALL']['2']['value'] = 'yes';

$defaultConfig['ALL']['3']['key'] = 'type';
$defaultConfig['ALL']['3']['value'] = 'friend';

$defaultConfig['ALL']['4']['key'] = 'nat';
$defaultConfig['ALL']['4']['value'] = 'force_rport,comedia';

$defaultConfig['ALL']['5']['key'] = 'qualify';
$defaultConfig['ALL']['5']['value'] = 'yes';

$defaultConfig['ALL']['6']['key'] = 'callcounter';
$defaultConfig['ALL']['6']['value'] = 'yes';


$trunkObj = new sip_user_fileGenerator();



/*
| --------------------------------------------------------------------------------------
|
| Creating TRUNK File
|
| --------------------------------------------------------------------------------------
*/

include_once ROOT_DIR . "component/fileGeneratorTrunk.php";

unset($defaultConfig);
/*$defaultConfig['ALL'][1]['key'] = 'dtmfmode';
$defaultConfig['ALL'][1]['value'] = 'inband';*/


$defaultConfig['ALL'][2]['key'] = 'qualify';
$defaultConfig['ALL'][2]['value'] = 'yes';

$trunkObj = new fileGeneratorTrunk();

$trunkObj->debugMode = '0';

$trunkObj->fileName = ROOT_DIR . 'voip/' .$company_info['comp_name'].'/'. $company_info['comp_name'] .'-trunk' .'.conf';

$trunkObj->defaultConfig = $defaultConfig;

$trunkObj->createTrunkFile($company_info['comp_id']);

$extension_file_name = ROOT_DIR . 'voip/'.$company_info['comp_name'] .'/'.$company_info['comp_name'].'-trunk.conf';

if (file_exists($extension_file_name)) {
    unlink($extension_file_name);
}

$handle = fopen($extension_file_name, 'w');
ob_start();

foreach ($All_comp_list['list'] as $key => $comp_fields) {
    $file_name = '-trunk-' . $comp_fields['comp_name'] . '.conf';
    $file_name = $comp_fields['comp_name'] .'-trunk'.'.conf';
    echo '#include  ' . $file_name . PHP_EOL;
}

$buffer = ob_get_contents();

ob_end_clean();

fwrite($handle, $buffer);

logAMIAllInclude('trunk.conf',true);

fclose($handle);

/*
| --------------------------------------------------------------------------------------
|
| Creating AllTrunkFile File
|
| --------------------------------------------------------------------------------------
*/

include_once ROOT_DIR . "component/fileGeneratorTrunk.php";

$trunkObj = new fileGeneratorTrunk();


$All_comp_list_new = Extention_fileGenerator::getCompanyList();

$trunkObj_file_name = ROOT_DIR . 'voip/sip-trunk.conf';

if (file_exists($extension_file_name)) {
    unlink($extension_file_name);
}

$handle = fopen($trunkObj_file_name, 'w');

ob_start();

foreach ($All_comp_list_new['list'] as $key => $comp_fields) {
    $file_name = $comp_fields['comp_name'] .'-sip-user'.'.conf';
    //echo '#include  '.ROOT_DIR.'voip/'. $comp_fields['comp_name'] .'/'.$file_name . PHP_EOL;
    echo '#include  '.ROOT_DIR.'voip/'. $comp_fields['comp_name'] .'/'.$file_name . PHP_EOL;
}

$buffer = ob_get_contents();
ob_end_clean();
fwrite($handle, $buffer);
logAMIAllInclude('sip-trunk.conf'.$company_info['comp_name'],true);
fclose($handle);
/*
| --------------------------------------------------------------------------------------
|
| Creating Routing File
|
| --------------------------------------------------------------------------------------
*/

include_once ROOT_DIR . "component/fileGeneratorRouting.php";

unset($defaultConfig);

$routingObj = new fileGeneratorRouting();

$routingObj->debugMode = '0';
/*if (!file_exists($fields['comp_name'])) {
    mkdir($fields['comp_name'], 0777, true);
}*/
$routingObj->fileName = ROOT_DIR . 'voip/' .$company_info['comp_name'] .'/'. $company_info['comp_name'].'-routing'.'.conf';
//$routingObj->defaultConfig = $defaultConfig;

$routingObj->createRoutingFile($company_info['comp_id']);


$extension_file_name = ROOT_DIR . 'voip/'.$company_info['comp_name'].'/routing.conf';
if (file_exists($extension_file_name)) {
    unlink($extension_file_name);
}

$handle = fopen($extension_file_name, 'w');
ob_start();

foreach ($All_comp_list['list'] as $key => $comp_fields) {
    //$file_name = 'routing-' . $comp_fields['comp_name'] . '.conf';
    $file_name =  $comp_fields['comp_name'].'-routing'. '.conf';

    echo '#include  ' . $file_name . PHP_EOL;
}

$buffer = ob_get_contents();
ob_end_clean();
fwrite($handle, $buffer);
logAMIAllInclude('routing.conf'.$company_info['comp_name'],true);
fclose($handle);

/*
| --------------------------------------------------------------------------------------
|
| Creating VOICE MAIL File
|
| --------------------------------------------------------------------------------------
*/

include_once ROOT_DIR . "component/fileGenerator_voice_mail.php";

$voiceMailObj = new voice_mail_fileGenerator();

$voiceMailObj->debugMode = '0';
/*if (!file_exists($fields['comp_name'])) {
    mkdir($fields['comp_name'], 0777, true);
}*/
$voiceMailObj->fileName = ROOT_DIR . 'voip/'.$company_info['comp_name'].'/'. $company_info['comp_name'] . '-voicemail'.'.conf';
$voiceMailObj->defaultConfig = $defaultConfig;
$voiceMailObj->createVoiceMailFile($company_info['comp_id']);

$extension_file_name = ROOT_DIR . 'voip/'.$company_info['comp_name'].'/voicemail.conf';
if (file_exists($extension_file_name)) {
    unlink($extension_file_name);
}

$handle = fopen($extension_file_name, 'w');
ob_start();

foreach ($All_comp_list['list'] as $key => $comp_fields) {
    //$file_name = 'voicemail-' . $comp_fields['comp_name'] . '.conf';
    $file_name = $comp_fields['comp_name'].'-voicemail' . '.conf';
    echo '#include  ' .ROOT_DIR.'voip/'. $comp_fields['comp_name'] .'/'.$file_name . PHP_EOL;
}

$buffer = ob_get_contents();
ob_end_clean();
fwrite($handle, $buffer);
logAMIAllInclude('voicemail.conf'.$company_info['comp_name'],true);
fclose($handle);

/*
| --------------------------------------------------------------------------------------
|
| Creating AllVOICE MAIL File
|
| --------------------------------------------------------------------------------------
*/

include_once ROOT_DIR . "component/fileGenerator_voice_mail.php";

$voiceMailObj = new voice_mail_fileGenerator();


$All_comp_list_new = Extention_fileGenerator::getCompanyList();

$extension_file_name = ROOT_DIR . 'voip/voice_mail.conf';

if (file_exists($extension_file_name)) {
    unlink($extension_file_name);
}

$handle = fopen($extension_file_name, 'w');

ob_start();

foreach ($All_comp_list_new['list'] as $key => $comp_fields) {
    $file_name = $comp_fields['comp_name'] .'-sip-user'.'.conf';
    //echo '#include  '.ROOT_DIR.'voip/'. $comp_fields['comp_name'] .'/'.$file_name . PHP_EOL;
    echo '#include  '.ROOT_DIR.'voip/'. $comp_fields['comp_name'] .'/'.$file_name . PHP_EOL;
}

$buffer = ob_get_contents();
ob_end_clean();
fwrite($handle, $buffer);
logAMIAllInclude('create allvoice_mail.conf'.$company_info['comp_name'],true);
fclose($handle);





/*
| --------------------------------------------------------------------------------------
|
| Creating QUEUE File
|
| --------------------------------------------------------------------------------------
*/

include_once ROOT_DIR . "component/fileGenerator_queue.php";
unset($defaultConfig);
$voiceMailObj = new queue_fileGenerator();

$defaultConfig['ALL']['0']['key'] = 'autofill';
$defaultConfig['ALL']['0']['value'] = 'yes';

$defaultConfig['ALL']['1']['key'] = 'joinempty';
$defaultConfig['ALL']['1']['value'] = 'yes';

$defaultConfig['ALL']['2']['key'] = 'leavewhenempty';
$defaultConfig['ALL']['2']['value'] = 'no';

$defaultConfig['ALL']['3']['key'] = 'ringinuse';
$defaultConfig['ALL']['3']['value'] = 'no';

$defaultConfig['ALL']['4']['key'] = 'wrapuptime';
$defaultConfig['ALL']['4']['value'] = '10';

$defaultConfig['ALL']['5']['key'] = 'timeout';
$defaultConfig['ALL']['5']['value'] = '30';

$defaultConfig['ALL']['6']['key'] = 'maxlen';
$defaultConfig['ALL']['6']['value'] = '10';


$voiceMailObj->debugMode = '0';
$voiceMailObj->fileName = ROOT_DIR . 'voip/' . $company_info['comp_name'].'/'. $company_info['comp_name'] . '-queues'. '.conf';
$voiceMailObj->defaultConfig = $defaultConfig;
$voiceMailObj->createQueueFile($company_info['comp_id']);

$extension_file_name = ROOT_DIR . 'voip/'. $company_info['comp_name'] .'/queues.conf';
if (file_exists($extension_file_name)) {
    unlink($extension_file_name);
}

$handle = fopen($extension_file_name, 'w');
ob_start();

foreach ($All_comp_list['list'] as $key => $comp_fields) {

    //$file_name = 'voicemail-' . $comp_fields['comp_name'] . '.conf';
    $file_name ='queues-' .$comp_fields['comp_name'] . '.conf';
    echo '#include  '.ROOT_DIR.'voip/'. $comp_fields['comp_name'] .'/'.$file_name . PHP_EOL;
}
$buffer = ob_get_contents();
ob_end_clean();
fwrite($handle, $buffer);
logAMIAllInclude('Creating QUEUE File'.$company_info['comp_name'],true);
fclose($handle);
/*
| --------------------------------------------------------------------------------------
|
| Creating All QUEUE conf
|
| --------------------------------------------------------------------------------------
*/
$All_comp_list_new = Extention_fileGenerator::getCompanyList();
$extension_file_name = ROOT_DIR . 'voip/queues.conf';
if (file_exists($extension_file_name)) {
    unlink($extension_file_name);
}

$handle = fopen($extension_file_name, 'w');
ob_start();

foreach ($All_comp_list_new['list'] as $key => $comp_fields) {
    $file_name = $comp_fields['comp_name'] .'-queues' . '.conf';

    //echo '#include  '.ROOT_DIR.'voip/'. $comp_fields['comp_name'] .'/'.$file_name . PHP_EOL;
    echo '#include  '.ROOT_DIR.'voip/'. $comp_fields['comp_name'] .'/'.$file_name . PHP_EOL;
}

$buffer = ob_get_contents();
ob_end_clean();
fwrite($handle, $buffer);
logAMIAllInclude('Creating All QUEUE conf'.$company_info['comp_name'],true);
fclose($handle);

$conn = new AstMan;
$conn->amiHost = AMI_HOST;
$conn->amiPort = AMI_Port;
$conn->amiUsername = AMI_USER_NAME;
$conn->amiPassword = AMI_PASSWORD;


/*$result = $extension->getAllSipInfo();
while ($row = $result['rs']->fetch()) {
    $list[] = $row;
}*/

$ret = $conn->Login();
$addForward = $conn->addForward($list);

//$quesStatus = $conn->quesStatus();

$ret = $conn->Reload();

$conn = dbConn::getConnection();
$sql = "
                UPDATE tbl_company
                SET
                reload_alert =   '0'
                WHERE comp_id = '" . $company_info['comp_id'] . "' ";

$stmt = $conn->prepare($sql);
$stmt->execute();


//and do something else
//Command("Action: Command\r\nCommand: database put Ext $exten/Dst/ $value_opt\r\n\r\n");
//Command("Action: Command\r\nCommand: database put Ext extension_no/Dst/Finternal|Fexternal $value_opt\r\n\r\n");
//Ext/201/Dst/Fexternal/09123063658
//Ext/201/Dst/Finternal/201
/*$extensionData = $extension->getAllSipInfo();
print_r($extensionData);
die();
while ($row = $result['rs']->fetch()) {
    $list[] = $row;
}*/