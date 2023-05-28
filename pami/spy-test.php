<?php
// Manual: http://192.168.0.131/pami/spy.php?src=233-zitel&ext=232-zitel

    $source = $_GET['src'];
    $destination = $_GET['ext'];
        if( isset( $source ) ){
    #exec("asterisk -rx \"channel originate sip/$source application ChanSpy sip/$destination\"",$out1);
    exec("asterisk -rx \"channel originate sip/$source application ChanSpy Local/$destination@context-zitel\"",$out1);
	}
?>
