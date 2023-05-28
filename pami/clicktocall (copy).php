<?php

    $ext = $_GET['ext'];
    $clicknum = $_GET['clicknum'];
    $socket = fsockopen("127.0.0.1","5038", $errno, $errstr, $timeout);
    fputs($socket, "Action: Login\r\n");
    fputs($socket, "UserName: tandis\r\n");
    fputs($socket, "Secret: tandiss@\r\n\r\n");
    fputs($socket, "Action: Originate\r\n");
    fputs($socket, "channel: sip/$ext\r\n");
    fputs($socket, "Application: Dial\r\n");
    fputs($socket, "Data: SIP/41598/$clicknum\r\n\r\n");
    fputs($socket, "Action: Logoff\r\n\r\n");

   while (!feof($socket)) {
     $wrets .= fread($socket, 8192);
   }
   fclose($socket);


?>
