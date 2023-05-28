<?php
 $varname = $_GET['varname'];
 $value = $_GET['value'];
 $socket = fsockopen("127.0.0.1","5038", $errno, $errstr, $timeout);
 fputs($socket, "Action: Login\r\n");
 fputs($socket, "UserName: tandis\r\n");
 fputs($socket, "Secret: tandiss@\r\n\r\n");
 fputs($socket, "Action: Setvar\r\n");
 //fputs($socket, "Value: 100\r\n");
 fputs($socket, "Value: $value\r\n");
 fputs($socket, "ActionID: 110\r\n");
 fputs($socket, "Channel: \r\n");
 fputs($socket, "Variable: $varname\r\n\r\n");

 fputs($socket, "Action: Logoff\r\n\r\n");

while (!feof($socket)) {
  $wrets .= fread($socket, 8192);
}
fclose($socket);
echo $wrets;

?>
