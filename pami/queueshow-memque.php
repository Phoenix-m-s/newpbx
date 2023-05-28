<?php

$company='-zitel';
$qnum = $_GET['qnum'];
//$qnum = $qnum.$company;
//$qnum = 360; 
$socket = fsockopen("127.0.0.1","5038", $errno, $errstr, $timeout);
fputs($socket, "Action: Login\r\n");
fputs($socket, "UserName: tandis\r\n");
fputs($socket, "Secret: tandiss@\r\n\r\n");
fputs($socket, "Action: QueueStatus\r\n");
fputs($socket, "queue: $qnum\r\n\r\n");
fputs($socket, "Action: Logoff\r\n\r\n");

while (!feof($socket)) {
    $wrets .= fread($socket, 8192);
}
fclose($socket);

//echo $wrets;

$myJSON = json_encode($wrets);
$st = json_decode($myJSON);

//echo $myJSON;
//print_r($st);

//$wrets=trim($st);
//$st=json_decode($myJSON);

function filterBy($st,$filter='QueueMember')
{
    $st = trim($st);
    $eventLIst = explode('Event:', $st);
    unset($eventLIst['0']);
    unset($eventLIst['1']);
    //unset($eventLIst['2']);
    #print_r($eventLIst);

    $count = -1;
    $countMember = 0;

    $arayEvent = array();
    $startMember = 0;


    foreach ($eventLIst as $id => $event)
    {
        $event = explode(PHP_EOL, $event);
        //echo '****';

        if (trim($event[0]) == 'QueueParams') {
            $count++;
            $countMember = 0;

            unset($event[0]);
            $event = array_filter($event, 'strlen');
            foreach ($event as $key => $val) {
                $temp = explode(':', $val);
		
                //if(isset($temp[1]))
                //{
                $arrayEvent[$count][trim($temp[0])] = trim($temp[1]);

                // }
            }

        } else {

            if(trim($event[0])==trim($filter))
            {

                unset($event[0]);
                $event = array_filter($event, 'strlen');
                foreach ($event as $key => $val) {
                    $temp = explode(':', $val);

                    if (trim($temp[1]) == 'Thanks for all the fish.') {
                        unset($arrayEvent[$count]['QueueMember'][$countMember]);
                        break;
                    }
                    //if(isset($temp[1]))
                    //{
                    $arrayEvent[$count]['QueueMember'][$countMember][trim($temp[0])] = trim($temp[1]);
                    // }
                }
                $countMember++;
            }



            if(trim($event[0])=='QueueEntry')
            {

                unset($event[0]);
                $event = array_filter($event, 'strlen');
                foreach ($event as $key => $val) {
                    $temp = explode(':', $val);

                    if (trim($temp[1]) == 'Thanks for all the fish.') {
                        unset($arrayEvent[$count]['QueueMember'][$countMember]);
                        break;
		    }


                    //if(isset($temp[1]))
                    //{
                    $arrayEvent[$count]['QueueEntry'][$countMember][trim($temp[0])] = trim($temp[1]);
                    // }
	       
		}
                $countMember++;
            }





        }

    }
    return $arrayEvent;
}




//$st = json_decode($myJSON);
header("Content-Type: application/json;charset=utf-8");
$arrayEvent=filterBy($st,'QueueMember');//sample1
//print_r($arrayEvent);
$export=json_encode($arrayEvent);
print_r($export);


//$arrayEvent=filterBy($st,'QueueEntry');//sample2
//print_r($arrayEvent);

die();

?>
