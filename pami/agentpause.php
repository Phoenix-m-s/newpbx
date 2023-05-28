<?php

    $ext = $_GET['ext'];
    $rcod = $_GET['rcode'];
    $qnum = $_GET['qnum'];
    exec("asterisk -rx \"channel originate sip/$ext extension cclp$ext$rcod$qnum@BSS-Custome-Code\"",$out1);


?>
