<?php
header("Content-Type: application/json;charset=utf-8");
$num1 = $_GET['uniqueid'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bss_log";

// Create connection
$conn = mysql_connect($servername, $username, $password);
//$query = ("SELECT * FROM asteriskcdrdb.cdr where uniqueid='$num1';");
//$query = ("SELECT calldate,src,dst,duration,userfield,recordingfile,uniqueid FROM asteriskcdrdb.cdr where uniqueid='1510747349.222';");
$query = ("SELECT uniqueid,queue_num,date,start_ans,agent,agent_end,rank,die_channel FROM bss_log.uniq where uniqueid=$num1;");
$result = mysql_db_query($dbname,$query,$conn);
$row = mysql_fetch_array($result);
//$time = $row['calldate'];
//echo $path;
$arrayName = array( "uniqueid" => $row['uniqueid'],  "queue_num" => $row['queue_num'], "DateTime" => $row['date'] , "Agent Answer Start" => $row['start_ans'] , "Agent" => $row['agent'] , "Agent Answer End" => $row['agent_end'] , "Rank" => $row['rank'] ,"Hangup Channel" => $row['die_channel']);
//print_r($arrayName);
$export=json_encode($arrayName);
print_r ($export);


?>
