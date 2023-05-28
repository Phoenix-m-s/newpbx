<?php
include_once("server.inc.php");
include_once(ROOT_DIR . "common/db.inc.php");
include_once(ROOT_DIR . "common/init.inc.php");
include_once(ROOT_DIR . "common/func.inc.php");
include_once(ROOT_DIR . "component/db.inc.class.php");
include_once(ROOT_DIR . "component/trash.presentation.class.php");

global $admin_info;
if ($admin_info == -1)
{
    if( $member_info != -1 ) {
        redirectPage ( RELA_DIR, "You dont have the permission to this page" );
    }
    header("location:".RELA_DIR."login.php");
    die();
}

$trash = new trash_presentation();

switch($_GET['action'])
{
    case 'searchQueueTrash' :
        $trash->searchQueueTrash($_GET);
        break;

    case 'searchIvrTrash' :
        $trash->searchIvrTrash($_GET);
        break;

    case 'searchSipTrash' :
        $trash->searchSipTrash($_GET);
        break;

    case 'searchExtensionTrash' :
        $trash->searchExtensionTrash($_GET);
        break;

    case 'searchCompanyTrash' :
        $trash->searchCompanyTrash($_GET);
        break;

    case 'searchAnnounceTrash' :
        $trash->searchAnnounceTrash($_GET);
        break;

    case 'searchInboundTrash' :
        $trash->searchInboundTrash($_GET);
        break;

    case 'searchOutboundTrash' :
        $trash->searchOutboundTrash($_GET);
        break;

   case 'searchUploadTrash' :
        $trash->searchUploadTrash($_GET);
        break;

    case 'showQueueTrash' :
        checkPermissions('showQueueTrash','trash');
        $trash->showQueueTrash('','');
        break;

  case 'showIvrTrash' :
      checkPermissions('showIvrTrash','trash');
        $trash->showIvrTrash('','');
        break;

    case 'showSipTrash' :
        checkPermissions('showSipTrash','trash');
        $trash->showSipTrash('','');
        break;

    case 'showAnnounceTrash' :
        checkPermissions('showAnnounceTrash','trash');
        $trash->showAnnounceTrash('','');
        break;

    case 'showExtensionTrash' :
        checkPermissions('showExtensionTrash','trash');
        $trash->showExtensionTrash('','');
        break;

    case 'showInboundTrash' :
        checkPermissions('showInboundTrash','trash');
        $trash->showInboundTrash('','');
        break;

    case 'showOutboundTrash' :
        checkPermissions('showOutboundTrash','trash');
        $trash->showOutboundTrash('','');
        break;

    case 'showUploadTrash' :
        checkPermissions('showUploadTrash','trash');
        $trash->showUploadTrash('','');
        break;

    case 'showCompanyTrash' :
        checkPermissions('showCompanyTrash','trash');
        $trash->showCompanyTrash('');
        break;
}
