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

echo $myJSON;

//$wrets=trim($st);


#echo "\nSassan\n";

$st=json_decode($myJSON);
$st=trim($st);
$eventLIst=explode('Event:',$st);
unset($eventLIst['0']);
unset($eventLIst['1']);
unset($eventLIst['2']);

$count=0;
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
            $arrayEvent[$count][trim($temp[0])]=trim($temp[1]);

            // }
        }

    }else
    {
        unset($event[0]);
        $event = array_filter($event, 'strlen');
        /*foreach ($event as $key => $val)
        {
            $temp=explode(':',$val);
            //if(isset($temp[1]))
            //{
            $arrayEvent[$count]['QueueMember'][$countMember][trim($temp[0])]=trim($temp[1]);

            // }
        }*/
        foreach ($event as $key => $val)
        {
            $temp=explode(':',$val);

            if(trim($temp[1])=='Thanks for all the fish.')
            {
                unset($arrayEvent[$count]['QueueMember'][$countMember]);
                break;
            }
            //if(isset($temp[1]))
            //{
            $arrayEvent[$count]['QueueMember'][$countMember][trim($temp[0])]=trim($temp[1]);
            // }
        }
        $countMember++;

    }


}

//echo '<pre/>';
header("Content-Type: application/json;charset=utf-8");
$export=json_encode($arrayEvent);
#print_r($export);
#print_r($arrayEvent);





?>
