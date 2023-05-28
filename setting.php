<?php
include_once("server.inc.php");
include_once("common/essential.inc.php");


    switch ($_REQUEST['action']) {

        case 'announce' :
            $announce= new announce();
            $announce->showAnnounce("");
            break;

        case 'addAnnounce' :
            $announce= new announce();
            $announce->addAnnounce("");
            break;

        case 'extension' :
            $extension = new extension();
            $extension->showExtension("");
            break;

        case 'addExtension' :
            $announce= new extension();
            $announce->addExtension("");
            break;

        case 'upload' :
            $upload = new upload();
            $upload->showUpload("");
            break;

        case 'addUpload' :
            $announce= new upload();
            $announce->addUpload("");
            break;

        case 'IVR' :
            $IVR = new IVR();
            $IVR->showIVR("");
            break;

        case 'addIVR' :
            $announce= new IVR();
            $announce->addIVR("");
            break;

        case 'queue' :
            $queue = new queue();
            $queue->showQueue("");
            break;

        case 'addQueue' :
            $announce= new queue();
            $announce->addQueue("");
            break;

        case 'SIP' :
            $SIP = new SIP();
            $SIP->showSIP("");
            break;

        case 'addSIP' :
            $announce= new SIP();
            $announce->addSIP("");
            break;

        case 'inbound' :
            $SIP = new inbound();
            $SIP->showInbound("");
            break;

        case 'addInbound' :
            $announce= new inbound();
            $announce->addInbound("");
            break;

        case 'outbound' :
            $SIP = new outbound();
            $SIP->showOutbound("");
            break;

        case 'addOutbound' :
            $announce= new outbound();
            $announce->addOutbound("");
            break;


        // Default
        default :
            break;

    }


?>
