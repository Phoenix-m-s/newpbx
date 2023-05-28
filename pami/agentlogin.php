<?php

    $ext = $_GET['ext'];
    $rcod = $_GET['rcode'];
    $qnum = $_GET['qnum'];
    #$company='-zitel';
    #$qnum = $qnum$company;

    //exec("asterisk -rx \"channel originate sip/$ext extension ccli$ext$rcod$qnum@BSS-Custome-Code\"",$out1);
    //exec("asterisk -rx \"channel originate local/$ext@from-internal  extension ccli$ext$rcod$qnum@BSS-Custome-Code\"",$out1);
 
    //exec("asterisk -rx \"channel originate SIP/$ext@context-testmace  extension  ccli$ext$rcod$qnum@BSS-Custome-Code\"",$out1);
    //exec("asterisk -rx \"channel originate  SIP/$ext  extension  ccli$ext$rcod$qnum@BSS-Custome-Code\"",$out1);
    //exec("asterisk -rx \"channel originate  SIP/$ext  extension  ccli#$ext#$rcod#$qnum#@BSS-Custome-Code\"",$out1);
        if( isset( $ext ) ){
    exec("asterisk -rx \"channel originate  Local/$ext@context-zitel  extension  ccli#$ext#$rcod#$qnum#@BSS-Custome-Code\"",$out1);
	}
?>
