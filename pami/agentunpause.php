<?php

    //$auth = $_GET['auth'];
    $ext = $_GET['ext'];
    $rcod = $_GET['rcode'];
    $qnum = $_GET['qnum'];
    //echo $ext, $rcod, $qnum;
    //echo whuhwuo;
    exec("asterisk -rx \"channel originate sip/$ext extension cclu$ext$rcod$qnum@BSS-Custome-Code\"",$out1);


?>
