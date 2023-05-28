  <?php
 $ext = $_GET['ext'];
 //$rcod = $_GET['rcode'];
 $qnum = $_GET['qnum'];
 $socket = fsockopen("127.0.0.1","5038", $errno, $errstr, $timeout);
 fputs($socket, "Action: Login\r\n");
 fputs($socket, "UserName: tandis\r\n");
 fputs($socket, "Secret: tandiss@\r\n\r\n");
 fputs($socket, "Action: SIPshowpeer\r\n");
 fputs($socket, "peer: $ext\r\n\r\n");
 fputs($socket, "Action: Logoff\r\n\r\n");

while (!feof($socket)) {
  $wrets .= fread($socket, 8192);
}
fclose($socket);

//echo $wrets;

preg_match('/Callerid: "(.*)"/', $wrets, $CID);
//echo $CID[1];
$CNAME = $CID[1];
//echo $CNAME;
$socket2 = fsockopen("127.0.0.1","5038", $errno, $errstr, $timeout);
fputs($socket2, "Action: Login\r\n");
fputs($socket2, "UserName: tandis\r\n");
fputs($socket2, "Secret: tandiss@\r\n\r\n");
fputs($socket2, "Action: QueuePause\r\n");
//fputs($socket2, "Interface: Local/${ext}@from-queue/n\r\n");
fputs($socket2, "Interface: Local/${ext}@context-zitel\r\n");
//fputs($socket2, "Interface: sip/$ext\r\n");
fputs($socket2, "stateinterface: hint:$ext@ext-local\r\n");
fputs($socket2, "MemberName: $CNAME\r\n");
fputs($socket2, "Paused: true\r\n\r\n");
fputs($socket2, "Action: Logoff\r\n\r\n");
while (!feof($socket2)) {
  $wrets2 .= fread($socket2, 8192);
}
fclose($socket2);
echo $wrets2;

?>
