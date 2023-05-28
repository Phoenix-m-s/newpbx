<?php
 $qnum = $_GET['qnum'];
 $socket = fsockopen("127.0.0.1","5038", $errno, $errstr, $timeout);
 fputs($socket, "Action: Login\r\n");
 fputs($socket, "UserName: tandis\r\n");
 fputs($socket, "Secret: tandiss@\r\n\r\n");
 fputs($socket, "Action: QueueStatus\r\n\r\n");
 fputs($socket, "Action: Logoff\r\n\r\n");

while (!feof($socket)) {
  $wrets .= fread($socket, 8192);
}
fclose($socket);

//echo $wrets;
$myJSON = json_encode($wrets);

//echo $myJSON;

//$wrets=trim($st);

$st=json_decode($myJSON);
$st=trim($st);
$eventLIst=explode('Event:',$st);
unset($eventLIst['0']);
unset($eventLIst['1']);
unset($eventLIst['2']);

$count=-1;
$countMember=0;

$arayEvent=array();
$startMember=0;
foreach ($eventLIst as $id => $event)
{
    $event=explode(PHP_EOL,$event);
    if(trim($event[0])=='QueueParams')
    {
        $count++;
        $countMember=0;

        unset($event[0]);
        $event = array_filter($event, 'strlen');
        foreach ($event as $key => $val)
        {
            $temp=explode(':',$val);
            //if(isset($temp[1]))
            //{
            $arrayQueue[$count][trim($temp[0])]=trim($temp[1]);

            // }
        }

    }

}
header("Content-Type: application/json;charset=utf-8");
echo $export=json_encode($arrayQueue);
//echo ($export);
die();



?>
