<?php
include_once("server.inc.php");
include_once(ROOT_DIR . "common/db.inc.php");
include_once(ROOT_DIR . "common/init.inc.php");
include_once(ROOT_DIR . "common/func.inc.php");
include_once(ROOT_DIR . "component/db.inc.class.php");

include_once(ROOT_DIR . "component/fileGenerator_extension.php");
unset($defaultConfig);
echo '<pre/>';

$comp_list = Extention_fileGenerator::getCompany();
$comp_list = $comp_list['list'];

foreach ($comp_list as $key => $fields) {
    $extension=new Extention_fileGenerator($fields['comp_id']);
    $extension->debugMode = '1';

    $temp_file_name = $fields['comp_id'] . '-exten.conf';
    $extension->fileName = ROOT_DIR . 'voip/' . $temp_file_name;
    $list_file_name[] = $temp_file_name;
    $extension->createExtensionFile();
}

$extension_file_name = ROOT_DIR.'voip/' . 'exten.conf';
if (file_exists($extension_file_name)) {
    unlink($extension_file_name);
}

$handle = fopen($extension_file_name, 'w');
ob_start();
foreach ($list_file_name as $key => $file) {
    echo  'include => ' . $file.PHP_EOL;
}

$buffer	= ob_get_contents();
ob_end_clean();
fwrite($handle, $buffer);
fclose($handle);

include_once(ROOT_DIR . "component/fileGenerator_sip_user.php");

$defaultConfig['ALL']['1']['key'] = 'host';
$defaultConfig['ALL']['1']['value'] = 'dynamic';

$defaultConfig['ALL']['2']['key'] = 'trustrpid';
$defaultConfig['ALL']['2']['value'] = 'yes';

$defaultConfig['ALL']['3']['key'] = 'type';
$defaultConfig['ALL']['3']['value'] = 'friend';

$defaultConfig['ALL']['4']['key'] = 'nat';
$defaultConfig['ALL']['4']['value'] = 'force_rport,comedia';

$defaultConfig['ALL']['6']['key'] = 'qualify';
$defaultConfig['ALL']['6']['value'] = 'yes';

$defaultConfig['ALL']['7']['key'] = 'callcounter';
$defaultConfig['ALL']['7']['value'] = 'yes';

$sipObj= new sip_user_fileGenerator();

$sipObj->debugMode = '1';
$sipObj->fileName = ROOT_DIR.'voip/' . 'sip_user.conf';
$sipObj->defaultConfig = $defaultConfig;

$sipObj->createSipFile();

echo '<br/><hr><br/>';
include_once(ROOT_DIR . "component/fileGenerator_sip_trunk.php");

unset($defaultConfig);
$defaultConfig['ALL'][1]['key'] = 'qualify';
$defaultConfig['ALL'][1]['value'] = 'yes';

$sipTrunkObj = new sip_trunk_fileGenerator();

$sipTrunkObj->debugMode = '1';
$sipTrunkObj->fileName = ROOT_DIR.'voip/' . 'sip_trunk.conf';
$sipTrunkObj->defaultConfig = $defaultConfig;

$sipTrunkObj->createSipFile();

echo '<br/><hr><br/>';

include_once(ROOT_DIR . "component/fileGenerator_voice_mail.php");
unset($defaultConfig);
$voiceMailObj = new voice_mail_fileGenerator();

$defaultConfig['HEAD'][1]['key'] = '[default]';
$defaultConfig['HEAD'][1]['value'] = '';

$voiceMailObj->debugMode = '1';
$voiceMailObj->fileName = ROOT_DIR.'voip/' . 'voicemail.conf';
$voiceMailObj->defaultConfig = $defaultConfig;
$voiceMailObj->createVoiceMailFile();

echo '<br/><hr><br/>';

include_once(ROOT_DIR . "component/fileGenerator_queue.php");
unset($defaultConfig);
$voiceMailObj = new queue_fileGenerator();

$defaultConfig['ALL']['3']['key'] = 'wrapuptime';
$defaultConfig['ALL']['3']['value'] = '10';

$defaultConfig['ALL']['2']['key'] = 'maxlen';
$defaultConfig['ALL']['2']['value'] = '10';

$defaultConfig['ALL']['0']['key'] = 'joinempty';
$defaultConfig['ALL']['0']['value'] = 'no';

$defaultConfig['ALL']['1']['key'] = 'leavewhenempty';
$defaultConfig['ALL']['1']['value'] = 'yes';

$voiceMailObj->debugMode = '1';
$voiceMailObj->fileName = ROOT_DIR.'voip/' . 'queue.conf';
$voiceMailObj->defaultConfig = $defaultConfig;
$voiceMailObj->createQueueFile();