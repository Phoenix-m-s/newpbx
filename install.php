<?php
include_once("server.inc.php");
include_once(ROOT_DIR . "common/db.inc.php");
include_once(ROOT_DIR . "common/init.inc.php");
include_once(ROOT_DIR . "common/func.inc.php");
include_once(ROOT_DIR . "component/admin.permission.class.php");

//$r=checkPermissions('showCustomerList','customer.controller6') ;
//print_r($r);
//die();


define('A00', 'admin list');
define('A01', 'admin');

//company.php config
$config['name'] = 'company';
$config['label'] = 'A001';
$config['point'] = '1';//har dafe yedone ++ mishe
$config['replace'] = '1';//sabet

$config['action']['1']['action'] = 'showAllCompany';
$config['action']['1']['label'] = 'Show All Company';

$config['action']['2']['action'] = 'addCompany';
$config['action']['2']['label'] = 'Add Company';

$config['action']['3']['action'] = 'showAllCompanyGroup';
$config['action']['3']['label'] = 'show All Company Group';

$config['action']['4']['action'] = 'addCompanyGroup';
$config['action']['4']['label'] = 'add Company Group';

$config['action']['5']['action'] = 'editCompany';
$config['action']['5']['label'] = 'edit Company';

$config['action']['6']['action'] = 'editCompanyGroup';
$config['action']['6']['label'] = 'edit Company Group';

$config['action']['7']['action'] = 'AddCompanyToGroup';
$config['action']['7']['label'] = 'Add Company To Group';

$config['action']['8']['action'] = 'ShowCompanyGroupMembers';
$config['action']['8']['label'] = 'Show Company Group Members';

$config['action']['9']['action'] = 'deleteCompanies';
$config['action']['9']['label'] = 'deleteCompanies';

$config['action']['10']['action'] = 'deleteCompanyFromGroup';
$config['action']['10']['label'] = 'deleteCompany From Group';

$config['action']['11']['action'] = 'changeStatus';
$config['action']['11']['label'] = 'change Status';

$config['action']['12']['action'] = 'changeGroupStatus';
$config['action']['12']['label'] = 'change Group Status';

$config['action']['13']['action'] = 'trashCompany';
$config['action']['13']['label'] = 'trash Company';

$config['action']['14']['action'] = 'recycleCompanies';
$config['action']['14']['label'] = 'recycle Companies';


$install_obj = new clsPermissionsPage();
$return = $install_obj->install($config);


//announce.php config
$config['name'] = 'announce';
$config['label'] = 'announce';
$config['point'] = '2';//har dafe yedone ++ mishe
$config['replace'] = '1';//sabet

$config['action']['1']['action'] = 'showAllAnnounce';
$config['action']['1']['label'] = 'show All Announce';

$config['action']['2']['action'] = 'addAnnounce';
$config['action']['2']['label'] = 'add Announce';

$config['action']['3']['action'] = 'editAnnounce';
$config['action']['3']['label'] = 'edit Announce';

$config['action']['4']['action'] = 'deleteAnnounce';
$config['action']['4']['label'] = 'delete Announce';

$config['action']['5']['action'] = 'trashAnnounces';
$config['action']['5']['label'] = 'trash Announces';

$config['action']['6']['action'] = 'recycleAnnounce';
$config['action']['6']['label'] = 'recycle Announce';

$config['action']['7']['action'] = 'changeStatus';
$config['action']['7']['label'] = 'change Status';

$install_obj = new clsPermissionsPage();
$return = $install_obj->install($config);


//extension.php config
$config['name'] = 'extension';
$config['label'] = 'extension';
$config['point'] = '3';//har dafe yedone ++ mishe
$config['replace'] = '1';//sabet

$config['action']['1']['action'] = 'showAllExtensions';
$config['action']['1']['label'] = 'show Extensions';

$config['action']['2']['action'] = 'addExtension';
$config['action']['2']['label'] = 'add Extension';

$config['action']['3']['action'] = 'editExtension';
$config['action']['3']['label'] = 'edit Extension';

$config['action']['4']['action'] = 'deleteExtensions';
$config['action']['4']['label'] = 'delete Extensions';

$config['action']['5']['action'] = 'trashExtension';
$config['action']['5']['label'] = 'trash Extension';

$config['action']['6']['action'] = 'recycleExtension';
$config['action']['6']['label'] = 'recycle Extension';

$config['action']['7']['action'] = 'changeStatus';
$config['action']['7']['label'] = 'change Status';

$install_obj = new clsPermissionsPage();
$return = $install_obj->install($config);


//upload.php config
$config['name'] = 'upload';
$config['label'] = 'upload';
$config['point'] = '4';//har dafe yedone ++ mishe
$config['replace'] = '1';//sabet

$config['action']['1']['action'] = 'showAllUploads';
$config['action']['1']['label'] = 'show All Uploads';

$config['action']['2']['action'] = 'addFile';
$config['action']['2']['label'] = 'add File';

$config['action']['3']['action'] = 'deleteFiles';
$config['action']['3']['label'] = 'delete Files';

$config['action']['4']['action'] = 'trashFiles';
$config['action']['4']['label'] = 'trash Files';

$config['action']['5']['action'] = 'recycleFiles';
$config['action']['5']['label'] = 'recycle Files';

$config['action']['6']['action'] = 'showAllUploads';
$config['action']['6']['label'] = 'show All Uploads';

$install_obj = new clsPermissionsPage();
$return = $install_obj->install($config);


//ivr.php config
$config['name'] = 'ivr';
$config['label'] = 'ivr';
$config['point'] = '5';//har dafe yedone ++ mishe
$config['replace'] = '1';//sabet

$config['action']['1']['action'] = 'showAllIvr';
$config['action']['1']['label'] = 'show All Ivr';

$config['action']['2']['action'] = 'showAllDST';
$config['action']['2']['label'] = 'show All DST';

$config['action']['3']['action'] = 'addIvr';
$config['action']['3']['label'] = 'add Ivr';

$config['action']['4']['action'] = 'editIvr';
$config['action']['4']['label'] = 'edit Ivr';

$config['action']['5']['action'] = 'changeStatus';
$config['action']['5']['label'] = 'change Status';

$config['action']['6']['action'] = 'deleteIvr';
$config['action']['6']['label'] = 'deleteIvr';

$config['action']['7']['action'] = 'trashIvr';
$config['action']['7']['label'] = 'trash Ivr';

$config['action']['8']['action'] = 'recycleIvr';
$config['action']['8']['label'] = 'recycle Ivr';

$install_obj = new clsPermissionsPage();
$return = $install_obj->install($config);


//queue.php config
$config['name'] = 'queue';
$config['label'] = 'queue';
$config['point'] = '6';//har dafe yedone ++ mishe
$config['replace'] = '1';//sabet

$config['action']['1']['action'] = 'showAllQueues';
$config['action']['1']['label'] = 'show All Queues';

$config['action']['2']['action'] = 'showAllAgents';
$config['action']['2']['label'] = 'show All Agents';

$config['action']['3']['action'] = 'addQueue';
$config['action']['3']['label'] = 'add Queue';

$config['action']['4']['action'] = 'editQueue';
$config['action']['4']['label'] = 'edit Queue';

$config['action']['5']['action'] = 'deleteQueues';
$config['action']['5']['label'] = 'delete Queues';

$config['action']['6']['action'] = 'trashQueues';
$config['action']['6']['label'] = 'trash Queues';

$config['action']['7']['action'] = 'recycleQueues';
$config['action']['7']['label'] = 'recycle Queues';

$config['action']['8']['action'] = 'unTrashQueues';
$config['action']['8']['label'] = 'unTrash Queues';

$config['action']['9']['action'] = 'changeStatus';
$config['action']['9']['label'] = 'changeStatus';

$config['action']['10']['action'] = 'showAllTrashes';
$config['action']['10']['label'] = 'showAllTrashes';

$install_obj = new clsPermissionsPage();
$return = $install_obj->install($config);


//sip.php config
$config['name'] = 'sip';
$config['label'] = 'sip';
$config['point'] = '7';//har dafe yedone ++ mishe
$config['replace'] = '1';//sabet

$config['action']['1']['action'] = 'showAllSip';
$config['action']['1']['label'] = 'show All Sip';

$config['action']['2']['action'] = 'addSip';
$config['action']['2']['label'] = 'add Sip';

$config['action']['3']['action'] = 'editSip';
$config['action']['3']['label'] = 'edit Sip';

$config['action']['4']['action'] = 'deleteSip';
$config['action']['4']['label'] = 'delete Sip';

$config['action']['5']['action'] = 'changeStatus';
$config['action']['5']['label'] = 'change Status';

$config['action']['6']['action'] = 'trashSips';
$config['action']['6']['label'] = 'trash Sips';

$config['action']['7']['action'] = 'recycleSips';
$config['action']['7']['label'] = 'recycle Sips';


$install_obj = new clsPermissionsPage();
$return = $install_obj->install($config);

//inbound.php config
$config['name'] = 'inbound';
$config['label'] = 'inbound';
$config['point'] = '8';//har dafe yedone ++ mishe
$config['replace'] = '1';//sabet

$config['action']['1']['action'] = 'showAllInbound';
$config['action']['1']['label'] = 'show All Inbound';

$config['action']['2']['action'] = 'addInbound';
$config['action']['2']['label'] = 'add Inbound';

$config['action']['3']['action'] = 'editInbound';
$config['action']['3']['label'] = 'edit Inbound';

$config['action']['4']['action'] = 'deleteInbound';
$config['action']['4']['label'] = 'delete Inbound';

$config['action']['5']['action'] = 'trashInbounds';
$config['action']['5']['label'] = 'trash Inbounds';

$config['action']['6']['action'] = 'recycleInbounds';
$config['action']['6']['label'] = 'recycle Inbounds';

$config['action']['7']['action'] = 'changeStatus';
$config['action']['7']['label'] = 'change Status';


$install_obj = new clsPermissionsPage();
$return = $install_obj->install($config);

//outbound.php config
$config['name'] = 'outbound';
$config['label'] = 'outbound';
$config['point'] = '9';//har dafe yedone ++ mishe
$config['replace'] = '1';//sabet

$config['action']['1']['action'] = 'showAllOutbound';
$config['action']['1']['label'] = 'show All Outbound';

$config['action']['2']['action'] = 'showDialPattern';
$config['action']['2']['label'] = 'show All Dial Pattern';

$config['action']['3']['action'] = 'addOutbound';
$config['action']['3']['label'] = 'add Outbound';

$config['action']['4']['action'] = 'editOutbound';
$config['action']['4']['label'] = 'edit Outbound';

$config['action']['5']['action'] = 'deleteOutbound';
$config['action']['5']['label'] = 'delete Outbound';

$config['action']['6']['action'] = 'trashOutbound';
$config['action']['6']['label'] = 'trash Outbound';

$config['action']['7']['action'] = 'recycleOutbound';
$config['action']['7']['label'] = 'recycle Outbound';

$config['action']['8']['action'] = 'changeStatus';
$config['action']['8']['label'] = 'changeStatus';

$config['action']['9']['action'] = 'changeStatus';
$config['action']['9']['label'] = 'changeStatus';

$config['action']['10']['action'] = 'showAllOutbound';
$config['action']['10s']['label'] = 'show All Outbound';

$install_obj = new clsPermissionsPage();
$return = $install_obj->install($config);

//package.php config
$config['name'] = 'package';
$config['label'] = 'package';
$config['point'] = '10';//har dafe yedone ++ mishe
$config['replace'] = '1';//sabet

$config['action']['1']['action'] = 'buyPackage';
$config['action']['1']['label'] = 'buy Package';

$config['action']['2']['action'] = 'buyPackageForCompany';
$config['action']['2']['label'] = 'buy Package For Company';

$config['action']['3']['action'] = 'showAllCompanyPackages';
$config['action']['3']['label'] = 'show All Company Packages';

$config['action']['4']['action'] = 'showAllCompanyPackages';
$config['action']['4']['label'] = 'show All Company Packages';


$install_obj = new clsPermissionsPage();
$return = $install_obj->install($config);

//packageLog.php config
$config['name'] = 'packageLog';
$config['label'] = 'packageLog';
$config['point'] = '11';//har dafe yedone ++ mishe
$config['replace'] = '1';//sabet

$config['action']['1']['action'] = 'showAllPackageLog';
$config['action']['1']['label'] = 'show All Package Log';

$config['action']['2']['action'] = 'getLastPackage';
$config['action']['2']['label'] = 'get Last Package';

$config['action']['3']['action'] = 'checkStartDate';
$config['action']['3']['label'] = 'check Start Date';

$config['action']['4']['action'] = 'getLastPackageByOrderFor';
$config['action']['4']['label'] = 'get Last Package By Order For';

$config['action']['5']['action'] = 'showAllPackageLog';
$config['action']['5']['label'] = 'show All PackageLog';


$install_obj = new clsPermissionsPage();
$return = $install_obj->install($config);

//admin.package.php config
$config['name'] = 'admin.package';
$config['label'] = 'admin.package';
$config['point'] = '12';//har dafe yedone ++ mishe
$config['replace'] = '1';//sabet

$config['action']['1']['action'] = 'showAllPackages';
$config['action']['1']['label'] = 'show All Packages';

$config['action']['2']['action'] = 'showAllGroupPackages';
$config['action']['2']['label'] = 'show All Group Packages';

$config['action']['3']['action'] = 'calculate';
$config['action']['3']['label'] = 'calculate';

$config['action']['4']['action'] = 'addGroupPackage';
$config['action']['4']['label'] = 'add Group Package';

$config['action']['5']['action'] = 'addPackage';
$config['action']['5']['label'] = 'add Package';

$config['action']['6']['action'] = 'addPackageToCompany';
$config['action']['6']['label'] = 'add Package To Company';

$config['action']['7']['action'] = 'addGroupPackageToCompany';
$config['action']['7']['label'] = 'add Group Package To Company';

$config['action']['8']['action'] = 'removeGroupPackageFromCompany';
$config['action']['8']['label'] = 'remove Group Package From Company';

$config['action']['9']['action'] = 'editGroupPackage';
$config['action']['9']['label'] = 'edit Group Package';

$config['action']['10']['action'] = 'editPackage';
$config['action']['10']['label'] = 'editPackage';

$config['action']['11']['action'] = 'deleteGroupPackage';
$config['action']['11']['label'] = 'delete Group Package';

$config['action']['12']['action'] = 'deletePackage';
$config['action']['12']['label'] = 'delete Package';

$config['action']['13']['action'] = 'changeStatus';
$config['action']['13']['label'] = 'change Status';

$config['action']['14']['action'] = 'changePackageStatus';
$config['action']['14']['label'] = 'change Package Status';

$config['action']['15']['action'] = 'showAllPackages';
$config['action']['15']['label'] = 'show All Packages';

$install_obj = new clsPermissionsPage();
$return = $install_obj->install($config);

//report.php config
$config['name'] = 'report';
$config['label'] = 'report';
$config['point'] = '13';//har dafe yedone ++ mishe
$config['replace'] = '1';//sabet

$config['action']['1']['action'] = 'showReport';
$config['action']['1']['label'] = 'show Report';

$config['action']['2']['action'] = 'showPaymentReport';
$config['action']['2']['label'] = 'show Payment Report';

$install_obj = new clsPermissionsPage();
$return = $install_obj->install($config);

//trash.php config
$config['name'] = 'trash';
$config['label'] = 'trash';
$config['point'] = '14';//har dafe yedone ++ mishe
$config['replace'] = '1';//sabet

$config['action']['1']['action'] = 'showQueueTrash';
$config['action']['1']['label'] = 'show Queue Trash';

$config['action']['2']['action'] = 'showIvrTrash';
$config['action']['2']['label'] = 'show Ivr Trash';

$config['action']['3']['action'] = 'showSipTrash';
$config['action']['3']['label'] = 'show Sip Trash';

$config['action']['4']['action'] = 'showAnnounceTrash';
$config['action']['4']['label'] = 'showAnnounceTrash';

$config['action']['5']['action'] = 'showExtensionTrash';
$config['action']['5']['label'] = 'showExtensionTrash';

$config['action']['6']['action'] = 'showInboundTrash';
$config['action']['6']['label'] = 'showInboundTrash';

$config['action']['7']['action'] = 'showOutboundTrash';
$config['action']['7']['label'] = 'showOutboundTrash';

$config['action']['8']['action'] = 'showUploadTrash';
$config['action']['8']['label'] = 'showUploadTrash';

$config['action']['9']['action'] = 'showCompanyTrash';
$config['action']['9']['label'] = 'show Company Trash';

$install_obj = new clsPermissionsPage();
$return = $install_obj->install($config);


//******************************************
//admin.list.php config
$config['name'] = 'admin.list';
$config['label'] = 'admin.list';
$config['point'] = '15';//har dafe yedone ++ mishe
$config['replace'] = '1';//sabet

$config['action']['1']['action'] = 'view';
$config['action']['1']['label'] = 'Show Manager List';

$config['action']['2']['action'] = 'add';
$config['action']['2']['label'] = 'Add Manager';

$config['action']['3']['action'] = 'edit';
$config['action']['3']['label'] = 'Edit Manager';

$config['action']['4']['action'] = 'remove';
$config['action']['4']['label'] = 'Delete Manager';

$config['action']['5']['action'] = 'settask';
$config['action']['5']['label'] = 'Access Level';


$install_obj = new clsPermissionsPage();
$return = $install_obj->install($config);


//******************************************
//groupSchedule.php config
$config['name'] = 'groupSchedule';
$config['label'] = 'groupSchedule';
$config['point'] = '16';//har dafe yedone ++ mishe
$config['replace'] = '1';//sabet

$config['action']['1']['action'] = 'groupScheduleList';
$config['action']['1']['label'] = 'Schedule Groups List';

$config['action']['2']['action'] = 'showSchedule';
$config['action']['2']['label'] = 'Schedule List';

$config['action']['3']['action'] = 'showAddSchedule';
$config['action']['3']['label'] = 'Add Schedule';

$config['action']['4']['action'] = 'showEditSchedule';
$config['action']['4']['label'] = 'Edit Schedule';

$config['action']['5']['action'] = 'deleteSchedule';
$config['action']['5']['label'] = 'Delete Schedule';

$config['action']['6']['action'] = 'addGroup';
$config['action']['6']['label'] = 'Add Schedule Group';

$config['action']['7']['action'] = 'editGroup';
$config['action']['7']['label'] = 'Edit Schedule Group';


$install_obj = new clsPermissionsPage();
$return = $install_obj->install($config);


//******************************************
//Campaign.php config
$config['name'] = 'campaign';
$config['label'] = 'campaign';
$config['point'] = '17';//har dafe yedone ++ mishe
$config['replace'] = '1';//sabet

$config['action']['1']['action'] = 'campaignList';
$config['action']['1']['label'] = 'Campaign List';

$config['action']['2']['action'] = 'showAddCamp';
$config['action']['2']['label'] = 'Add to Campaign';

$config['action']['3']['action'] = 'deleteCampaign';
$config['action']['3']['label'] = 'Campaign List';


$install_obj = new clsPermissionsPage();
$return = $install_obj->install($config);


//******************************************
//blackList.php config
$config['name'] = 'blackList';
$config['label'] = 'blackList';
$config['point'] = '18';//har dafe yedone ++ mishe
$config['replace'] = '1';//sabet

$config['action']['1']['action'] = 'blackList';
$config['action']['1']['label'] = 'Black List';

$config['action']['2']['action'] = 'add';
$config['action']['2']['label'] = 'Add';

$config['action']['3']['action'] = 'edit';
$config['action']['3']['label'] = 'Edit';

$config['action']['3']['action'] = 'delete';
$config['action']['3']['label'] = 'Delete';


$install_obj = new clsPermissionsPage();
$return = $install_obj->install($config);


//******************************************
//numbers.php config
$config['name'] = 'numbers';
$config['label'] = 'numbers';
$config['point'] = '19';//har dafe yedone ++ mishe
$config['replace'] = '1';//sabet

$config['action']['1']['action'] = 'numbers';
$config['action']['1']['label'] = 'Number List';

$install_obj = new clsPermissionsPage();
$return = $install_obj->install($config);


print_r($return);

die();
//echo $return;die();
if ($return['result'] != 1) {
    showAccessError();
}
return 1;
print_r($install_obj);
//$this->_setAction
die();
//$result=$install_obj->install($config);

$install_obj->GetConfigByName('customer.controller6');


echo '<pre/> <br/>';
print_r($result);
die('end');

$install_obj->install($config);


function usePermission($config, $index)
{

    include_once(ROOT_DIR . "component/admin.permission.class.php");

    $page_name = $config['name'];
    $PagePermission[$page_name] = new clsPermissionsPage($index, $base, $config['name']);
    foreach ($config['action'] as $key => $val) {
        $PagePermission[$page_name]->addAction(array('action' => $val['action'], 'code' => $key, 'label' => constant($val['label'])));

    }
    echo '<pre/>';
    print_r($PagePermission);

}


usePermission($config, 1);

?>
