<?php
header("Content-Type: application/json;charset=utf-8");
$num1 = $_GET['num'];

//$rcod = $_GET['rcode'];
//$qnum = $_GET['qnum'];
$socket = fsockopen("127.0.0.1","5038", $errno, $errstr, $timeout);
fputs($socket, "Action: Login\r\n");
fputs($socket, "UserName: tandis\r\n");
fputs($socket, "Secret: tandiss@\r\n\r\n");
fputs($socket, "Action: Status\r\n\r\n");
//fputs($socket, "Variables: UNIQUEID, CallerIDNum, HANGUPCAUSE, CHANNEL, DIALEDPEERNUMBER\r\n\r\n");
fputs($socket, "Action: Logoff\r\n\r\n");

while (!feof($socket)) {
$wrets .= fread($socket, 8192);
}
fclose($socket);

//echo $wrets;

//$wrets= $_POST['a'];
//$st=json_decode($wrets);
$st=$wrets;
$st=trim($st);
$eventLIst=explode('Event:',$st);
unset($eventLIst['0']);
unset($eventLIst['1']);
//unset($eventLIst['2']);

$count=-1;
$countMember=0;




$arayEvent=array();
$startMember=0;

foreach ($eventLIst as $id => $event)
{
  $event=explode(PHP_EOL,$event);
  //print_r($event);
  //die();

  if(trim($event[0])=='Status')
  {
      $count++;
      $countMember=0;

      unset($event[0]);
      $event = array_filter($event, 'strlen');
      foreach ($event as $key => $val)
      {
          $temp=explode(':',$val);
          if(trim($temp[0])=='CallerIDNum' or trim($temp[0])=='CallerIDName' or trim($temp[0])=='ConnectedLineNum'or trim($temp[0])=='ConnectedLineName' or trim($temp[0])=='Seconds')
          {
              $arrayQueue[$count][trim($temp[0])]=trim($temp[1]);
          }
      }

  }

}
//print_r($arrayQueue);
//$myJSON = json_encode($arrayQueue);
//echo $myJSON;

function searchq($searchnumber,$arrayQueue)
{
  $found_key = array_search($searchnumber, array_column($arrayQueue, 'CallerIDNum'));
  if (isset($found_key) and is_int($found_key)) {

      $result = $arrayQueue[$found_key];
  } else {
      $result = null;

  }
  return $result;


}
$result[]=searchq("$num1",$arrayQueue);


$myJSO = json_encode($result);
echo $myJSO;


?>
