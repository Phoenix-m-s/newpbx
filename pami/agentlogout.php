<?php

    //$auth = $_GET['auth'];
    $ext = $_GET['ext'];
    $rcod = $_GET['rcode'];
    $qnum = $_GET['qnum'];
    //echo $ext, $rcod, $qnum;
    //echo whuhwuo;
    exec("asterisk -rx \"channel originate sip/$ext extension cclo$ext$qnum@BSS-Custome-Code\"",$out1);


?>
