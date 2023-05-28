<?php
require_once "server.inc.php";
require_once "common/essential.inc.php";

//--------------------------------- login by token jahanbakhsh ---------------------------------//

if ($_GET['action'] == 'loginbytoken') {

    require_once "component/login/extension.member.login.controller.php";
    $member = new adminLoginController();
    $member->loginByToken($_GET);

}

//*** refresh_token
/*if ($_GET['action'] == 'loginbyreftoken') {

    require_once "component/login/extension.member.login.controller.php";
    $member = new adminLoginController();
    $member->loginByRefreshToken($_GET);

}*/

//*************************comment add by jahanbakhsh
//bellow condition for login is disable after run $_GET['action'] == 'loginbytoken'

if(isset($_GET['loginAs'])){

    $_POST['username']=$_GET['username'];
    $_POST['password']=$_GET['password'];
    $_POST['type']=$_GET['type'];
    $admin->login($_POST);
    die();
}

if ($_POST['action'] == 'login') {
    switch ($_POST['type']) {
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
    $page->loginform();
}