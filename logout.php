<?php
include_once("server.inc.php");
include_once("common/essential.inc.php");

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

if($_GET['type']=='user')
{
    $admin->userLogout();
}

$admin->logOut();