<?php
/**
 * Created by PhpStorm.
 * User: FaridCS
 * Date: 11/1/2014
 * Time: 2:30 PM
 */

include_once("server.inc.php");
include_once("common/essential.inc.php");

if($admin_info == -1) {
    if( $member_info != -1 ) {
        redirectPage ( RELA_DIR, "You dont have the permission to this page" );
    }
    $page->loginform();
}

//checkPermissions('campaignList');

$campaign = new campaign();

if(isset($_REQUEST['action'])) {
    switch ($_REQUEST['action']) {

        // show add campaign page
        case 'showAddCamp' :
            //checkPermissions('showAddCamp');
            $result = $campaign->showAddCamp();
            $page->showAddCamp($result);
            break;

        // show edit campaign page
        case 'editCampaign' :
            $id = handleData($_GET['id']);
            $result = $campaign->showEditCamp($id);
            $page->showEditCamp($result);
            break;

        // edit campaign
        case 'edit' :
            $campaign->addCampaignInfo = $_POST;
            $result = $campaign->editCampaign();
            break;

        // add Campaign
        case 'addCampaign' :
//            echo "<pre>";
//            print_r($_POST);
//            die();
            $campaign->addCampaignFiles   = $_FILES['fileinput_inline'];
            $campaign->addCampaignInfo = $_POST;
            $result = $campaign->addCampaign();
            $page->addCampaign($result);
            break;

        // enable campaign
        case 'setEnable' :
            $id = handleData($_GET['id']);
            $campaign->enableCampaign($id);
            break;

        // delete campaign
        case 'deleteCampaign' :
            //heckPermissions('deleteCampaign');
            $id = handleData($_GET['id']);
            $campaign->deleteCampaign($id);
            break;

        // run campaign
        case 'runCampaign' :
            $campaign->runCampaign();
            break;

        // Group Schedule List
        default :
            //checkPermissions('campaignList');
            $result = $campaign->campList();
            $page->campList($result);
            break;
    }
} else {

    // Group Schedule List
   // checkPermissions('campaignList');
    $result = $campaign->campList();
    $page->campList($result);
}
