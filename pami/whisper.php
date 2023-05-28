<?php

    $source = $_GET['src'];
    $destination = $_GET['ext'];
    if( isset( $source ) ){
    //exec("asterisk -rx \"channel originate sip/$source application ChanSpy sip/$destination,w\"",$out1);
    //exec("asterisk -rx \"channel originate sip/$source application ChanSpy Local/$destination@context-zitel,w\"",$out1);


		if ( strlen($destination) > 3)
		{
    		exec("asterisk -rx \"channel originate sip/$source application ChanSpy Local/$destination@context-zitel,w\"",$out1);
		}

	else
		{
    		exec("asterisk -rx \"channel originate sip/$source application ChanSpy sip/$destination,w\"",$out1);


		}


    }
?>
