<?php

require_once "server.inc.php" ;
require_once "common/essential.inc.php";
if( $_POST[ 'action' ] == 'login' ) {
    switch ( $_POST[ 'type' ] ) {
        case 'admin' :
            $admin->login();
            break;

        case 'member' :
            require_once "component/login/extension.member.login.controller.php";
            $member = new adminLoginController();
            $member->login($_REQUEST);
            break;

        default :
            break;
    }
} else {
    $page->userLoginForm();
}