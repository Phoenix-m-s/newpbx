<?php



    $source = $_GET['uniqid'];
date_default_timezone_set('Asia/Tehran');
    //$source = $argv[1];
    $array=(explode(".",$source));
    $epoch=$array[0];

//	echo $source . "\n";
//	echo $epoch . "\n";
	//echo $m+"/n";
//    $source = $_GET['uniqid'];
	$y=date("Y", substr($epoch, 0, 10));
	$m=date("m", substr($epoch, 0, 10));
	$d=date("d", substr($epoch, 0, 10));

 //   exec("cd /var/spool/asterisk/monitor/; ls $y/$m/$d/*$source*",$out1);
    //exec("cd /var/www/voip/zitel/monitor/zitel/ ; ls $y/$m/$d/*$source*",$out1);
    //exec("cd /zitel-record/ ; ls $y/$m/$d/*$source*",$out1);
    //exec("cd /voip-records-nfs/ ; ls $y/$m/$d/*$source*",$out1);
    exec("cd /voip-records-nfs/ ;find   $y/$m/$d/* -name *$source* | head -n 1",$out1);
//	echo $out1[0] . "\n";
    $data = ($out1[0]);
    $data = ("http://localhost/records/".$out1[0]);
    //echo $data;
    //echo "<meta http-equiv=\"refresh\" content=\"0; url=".$data."\" />"
    $context = stream_context_create(
        array(
            'http' => array(
                'follow_location' => false
            )
        )
    );

    $html = file_get_contents($data, true, $context);
     header("Content-type:audio/x-wav");
     //var_dump($http_response_header);
    echo $html
?>
