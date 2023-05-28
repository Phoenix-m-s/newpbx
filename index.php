<?php
define("common/looeicConfig", 'api');
include_once("server.inc.php");

include_once("common/essential.inc.php");

include_once("services/CdrService.php");

//********************************************
if($admin_info == -1 and $member_info == -1)
{
    $page->loginform();
}

/*checkPermissions();*/

if(isset($_REQUEST['action'])) {
    $action = $_REQUEST['action'];
    switch ($action) {

        default :
            $page->showIndex();
            break;
    }

} else {
    //checkPermissions('show');
    $page->showIndex();
}
