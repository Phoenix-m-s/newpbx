<?php

    $ext = $_GET['ext'];
    $clicknum = $_GET['clicknum'];
    $interactionid=$_GET['interaction-id'];
    //$comp='-zitel';
    //exec("asterisk -rx \"channel originate sip/$ext extension 8*$clicknum@from-internal\"",$out1);
   
    //exec("asterisk -rx \"channel originate local/$ext@from-internal extension 8*$clicknum@from-internal\"",$out1);
    //exec("asterisk -rx \"channel originate Local/100@context-testmace extension 8*$clicknum@from-internal\"",$out1);
    //exec("asterisk -rx \"channel originate SIP/$ext$comp  extension 8*$clicknum@from-internal\"",$out1);
        if( isset( $ext ) ){
    //exec("asterisk -rx \"channel originate Local/$ext@context-zitel  extension 8*$clicknum@zitel-out\"",$out1);


      exec("asterisk -rx \"dialplan set global ctl$clicknum   $interactionid \"");
            exec("asterisk -rx \"channel originate Local/$ext@context-zitel  extension 8*$clicknum@zitel-out\"",$out1);

	}
?>
