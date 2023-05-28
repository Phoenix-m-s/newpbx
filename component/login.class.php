<?php

class memberLogIn
{
    private static function GetHash ()
    {
        return '%%1^^@@REWcmv21))--';
    }

    function encrypt ( $string , $key )
    {
        $result = '';
        for ($i = 0; $i < strlen ( $string ); $i ++) {
            $char = substr ( $string , $i , 1 );
            $keychar = substr ( $key , ( $i % strlen ( $key ) ) - 1 , 1 );
            $char = chr ( ord ( $char ) + ord ( $keychar ) );
            $result .= $char;
        }

        return base64_encode ( $result );
    }

    function decrypt ( $string , $key )
    {
        $result = '';
        $string = base64_decode ( $string );

        for ($i = 0; $i < strlen ( $string ); $i ++) {
            $char = substr ( $string , $i , 1 );
            $keychar = substr ( $key , ( $i % strlen ( $key ) ) - 1 , 1 );
            $char = chr ( ord ( $char ) - ord ( $keychar ) );
            $result .= $char;
        }

        return $result;
    }

    function showLogInForm ( $redirect = 0 , $message )
    {

        global $conn , $member_info;

        if ( $redirect ) {
            echo "0 $message";
        } else {

            $help = LOGIN_001 . '<br><br> ' . LOGIN_002 . ' , <a href="' . RELA_DIR . 'register.php">' . LOGIN_003 . '</a>' . LOGIN_004;
            ///'Please login to use our 				services<br><br> If you not register yet , <a href="'.RELA_DIR.'register.php">Register</a> now'
            include ( ROOT_DIR . "templates/" . CURRENT_SKIN . "/login.php" );
        }

    }

    function logInForm ( $redirect = 0 , $message )
    {

        global $conn , $member_info;

        if ( $redirect ) {
            echo "0 $message";
        } else {
            $help = 'login.php';
            ///'Please login to use our services<br><br> If you not register yet , <a href="'.RELA_DIR.'register.php">Register</a> now'
            include ( ROOT_DIR . "templates/" . CURRENT_SKIN . "/component.title.inc.php" );
            include ( ROOT_DIR . "templates/" . CURRENT_SKIN . "/login.php" );
            include ( ROOT_DIR . "templates/" . CURRENT_SKIN . "/component.tail.inc.php" );
        }
        die();
    }

    function NewlogIn ( $username = '' , $password = '' , $remember_me = '0' )
    {
        global $conn , $member_info;

        if ( $username == "Email" || strlen ( $username ) <= 0 )
            return ( LOGIN_022 );
        if ( strlen ( $username ) > 40 || checkUser ( $username ) )
            return ( LOGIN_005 );

        if ( $password == "" )
            return ( LOGIN_006 );

        if ( strlen ( $password ) < 4 || strlen ( $password ) > 20 )
            return ( ACCOUNT_025 );

        $sql = "DELETE FROM sessions WHERE last_access_time < (NOW()-3000000) ";
        $rs = $conn->Execute ( $sql );
        if ( !$rs ) {
            showErrorMsg ( $conn->ErrorMsg () );
        }

        $sql = "SELECT member_id,
		status FROM members WHERE email='" . handleSQLData ( $username ) . "' AND password='" . md5 ( handleSQLData ( $password ) ) . "'";
        $member_rs = $conn->Execute ( $sql );
        if ( !$member_rs ) {
            showErrorMsg ( $conn->ErrorMsg () );
        }

        if ( $member_rs->RecordCount () == 1 && $member_rs->fields[ 'status' ] == 1 ) {
            $sql = "DELETE FROM sessions WHERE member_id='" . $member_rs->fields[ 'member_id' ] . "'";
            $rs = $conn->Execute ( $sql );
            if ( !$rs ) {
                return ( "Add data error" );
            }

            $sql = "INSERT into sessions (member_id,
										remote_addr,login_type , 
										last_access_time , 
										remember_me) 
										values (" . $member_rs->fields[ 'member_id' ] . ",'" . $_SERVER[ "REMOTE_ADDR" ]
                . "', '" . $member_rs->fields[ 'type' ] . "', '" . getDateTime () . "' , '" . $remember_me . "' )";

            $rs = $conn->Execute ( $sql );
            if ( !$rs ) {
                $this->logInForm ( $redirect , LOGIN_007 );
            }

            $_SESSION[ "sessionID" ] = $this->encrypt ( $conn->Insert_ID () , $this->GetHash () );

            if ( $remember_me ) {
                setcookie ( "sessionID" , $_SESSION[ "sessionID" ] , time () + 3600000000000 , "/" , $_SERVER[ 'HTTP_HOST' ] );
            } else {
                setcookie ( "sessionID" , $_SESSION[ "sessionID" ] , time () + 3600 , "/" , $_SERVER[ 'HTTP_HOST' ] );
            }
            $member_info = $this->checkLogin ();
            return ( 1 );
        } elseif ( $member_rs->RecordCount () == 1 && $member_rs->fields[ 'status' ] == - 1 ) {
            return ( LOGIN_008 );
        } else {
            return ( LOGIN_009 );
        }
    }

    function logIn ( $username = '' , $password = '' , $reffer = '' )
    {

        global $conn , $member_info;

        if ( $username == '' ) {
            $username = handleData ( $_REQUEST[ "username" ] );
        }
        if ( $password == '' ) {
            $password = handleData ( $_REQUEST[ "password" ] );
        }
        if ( isset( $_POST[ 'remember_me' ] ) ) {
            $remember_me = $_POST[ 'remember_me' ];
        } else {
            $remember_me = 0;
        }
        if ( $username == "Email" || strlen ( $username ) > 40 || checkUser ( $username ) )
            $this->logInForm ( $redirect , LOGIN_005 );
        if ( $username == "" )
        $this->logInForm ( $redirect , LOGIN_005 );

        if ( $password == "" )
            $this->logInForm ( $redirect , LOGIN_006 );

        if ( strlen ( $password ) < 4 || strlen ( $password ) > 20 )
            $this->logInForm ( $redirect , ACCOUNT_025 );

        $sql = "DELETE FROM sessions WHERE last_access_time < (NOW()-3000000) ";
        $rs = $conn->Execute ( $sql );
        if ( !$rs ) {
            showErrorMsg ( $conn->ErrorMsg () );
        }

        $sql = "SELECT member_id,
		status FROM members where email='" . handleSQLData ( $username ) . "' AND password='" . md5 ( handleSQLData ( $password ) ) . "'";
        $member_rs = $conn->Execute ( $sql );
        if ( !$member_rs ) {
            showErrorMsg ( $conn->ErrorMsg () );
        }
        if ( $member_rs->RecordCount () == 1 && $member_rs->fields[ 'status' ] == 1 ) {
            $sql = "DELETE FROM sessions WHERE member_id='" . $member_rs->fields[ 'member_id' ] . "'";
            $rs = $conn->Execute ( $sql );
            if ( !$rs ) {
                $this->logInForm ( $redirect , LOGIN_007 );
            }

            $sql = "INSERT into sessions (member_id,
										remote_addr,login_type ,
										 last_access_time , 
										 remember_me) values (" . $member_rs->fields[ 'member_id' ] . ",'" . $_SERVER[ "REMOTE_ADDR" ]
                . "', '" . $member_rs->fields[ 'type' ] . "', '" . getDateTime () . "' , '" . $remember_me . "' )";

            $rs = $conn->Execute ( $sql );
            if ( !$rs ) {
                $this->logInForm ( $redirect , LOGIN_007 );
            }

            $_SESSION[ "sessionID" ] = $this->encrypt ( $conn->Insert_ID () , $this->GetHash () );

            if ( $remember_me ) {
                setcookie ( "sessionID" , $_SESSION[ "sessionID" ] , time () + 3600000000000 , "/" , $_SERVER[ 'HTTP_HOST' ] );
            } else {
                setcookie ( "sessionID" , $_SESSION[ "sessionID" ] , time () + 3600 , "/" , $_SERVER[ 'HTTP_HOST' ] );
            }
            if ( $reffer == "" ) {
                $reffer = RELA_DIR . "account.php";
            }

            define ( REDIRECT_ADDRESS , $reffer );
            $member_info = $this->checkLogin ();
            redirectPage ( REDIRECT_ADDRESS , LOGIN_010 );
        } elseif ( $member_rs->RecordCount () == 1 && $member_rs->fields[ 'status' ] == - 1 ) {
            $this->logInForm ( $redirect , LOGIN_008 );
        } else {
            $this->logInForm ( $redirect , LOGIN_009 );
        }
    }

    function checkLogin ()
    {
        global $conn;

        //print_r($_COOKIE["sessionID"]);
        if ( !isset( $_SESSION[ "sessionID" ] ) ) {
            if ( !isset( $_COOKIE[ "sessionID" ] ) ) {
                return - 1;
            } else {
                $sessionID = $this->decrypt ( $_COOKIE[ "sessionID" ] , $this->GetHash () );
            }
        } else {
            $sessionID = $this->decrypt ( $_SESSION[ "sessionID" ] , $this->GetHash () );
        }

        $sql = "select member_id from sessions where session_id='$sessionID'";
        $rs = $conn->Execute ( $sql );
        if ( !$rs ) {
            return - 1;
        }

        if ( $rs->RecordCount () != 1 ) {
            return - 1;
        }

        $sql = "select * from members where	member_id = " . $rs->fields[ 'member_id' ];
        $rs = $conn->Execute ( $sql );
        if ( !$rs ) {
            return - 1;
        }

        if ( $rs->EOF ) {
            return - 1;
        }

        $member_info = $rs->FetchRow ();

        $user_type = $this->_setUserType ( $member_info[ 'ibsng_user_type' ] , $member_info[ 'member_id' ] , $member_info[ 'accountant' ] );

        $member_info[ 'ctm_user_type' ] = $user_type;

        return $member_info;
    }

    /**
     * Set User Type
     *
     * @access private
     *
     *This function get User Type From DB and set it to $member_info
     */
    private function _setUserType ()
    {
        $temp = func_get_args ();

        $user_type = USER_TYPE;
        if ( $temp[ 0 ] == '0' ) {
            $user_type = $user_type | '10000';
        } elseif ( $temp[ 0 ] == '2' ) {
            $user_type = $user_type | '10000';
        } elseif ( $temp[ 0 ] == '3' ) {
            $user_type = $user_type | '11000';
        }

        $isVoucherSeller = $this->_isVoucherSeller ( $temp[ 1 ] );
        if ( $isVoucherSeller ) {
            $user_type = $user_type | '00100';
        }

        $isVoucherAgent = $this->_isVoucherAgent ( $temp[ 1 ] );
        if ( $isVoucherAgent ) {
            $user_type = $user_type | '00010';
        }

        if ( $temp[ 2 ] == '1' ) {
            $user_type = $user_type | '00001';
        }

        return $user_type;
    }

    /**
     * Is Voucher Seller
     *
     * @access private
     *
     *This function ceck this user is Voucher Seller or not
     */
    private function _isVoucherSeller ()
    {
        global $conn;

        $temp = func_get_args ();

        $Query = "SELECT 	member_id
					FROM	voucher_owner
					WHERE	member_id = '" . $temp[ 0 ] . "'
					";

        $DbResult = $conn->Execute ( $Query );
        if ( !$DbResult ) {
            return FALSE;
        }

        if ( $DbResult->RecordCount () > 0 ) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Is Voucher Agent
     *
     * @access private
     *
     *This function ceck this user is Voucher Agent or not
     */
    private function _isVoucherAgent ()
    {
        global $conn;

        $temp = func_get_args ();

        $Query = "SELECT 	member_id
					FROM	voucher_agent
					WHERE	member_id = '" . $temp[ 0 ] . "'
					";

        $DbResult = $conn->Execute ( $Query );
        if ( !$DbResult ) {
            return FALSE;
        }

        if ( $DbResult->RecordCount () > 0 ) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function forgotPassShow ( $message )
    {
        global $conn , $member_info;
        $pageTitle = 'Forgot Password';
        $help = 'forgot.php';
        include ( ROOT_DIR . "templates/" . CURRENT_SKIN . "/component.title.inc.php" );
        include ( ROOT_DIR . "templates/" . CURRENT_SKIN . "/forget.php" );
        include ( ROOT_DIR . "templates/" . CURRENT_SKIN . "/component.tail.inc.php" );

        die();
    }

    function forgotPassSuccess ( $message )
    {
        global $conn , $member_info;
        $pageTitle = 'Forgot Password ';
        //$help = 'forgotPass.php';
        include ( ROOT_DIR . "templates/" . CURRENT_SKIN . "/component.title.inc.php" );
        include ( ROOT_DIR . "templates/" . CURRENT_SKIN . "/forgot.pass.success.php" );
        include ( ROOT_DIR . "templates/" . CURRENT_SKIN . "/component.tail.inc.php" );
        die();
    }

    function sendPass ()
    {
        global $conn , $member_info;

        if ( $_POST[ 'email' ] == "Email" || strlen ( $_REQUEST[ 'email' ] ) > 40 || checkUser ( $_REQUEST[ 'email' ] ) )
            $this->forgotPassShow ( LOGIN_005 );
        if ( $_POST[ 'email' ] == "" )
            $this->forgotPassShow ( LOGIN_005 );
        $email = $_POST[ 'email' ];


        if ( !checkMail ( $email ) ) {
            $this->forgotPassShow ( LOGIN_011 );
        }

        $sql = "select * from members where email='$email'";
        $rs = $conn->Execute ( $sql );
        if ( !$rs ) {
            showErrorMsg ( $conn->ErrorMsg () );
        }

        if ( $rs->RecordCount () == 0 ) {
            $this->forgotPassShow ( LOGIN_012 );
        } else {
            $name = $rs->fields[ 'name' ];
            $username = $rs->fields[ 'email' ];
            $Key = mt_rand () . mt_rand () . mt_rand ();
            $sql = "insert into password_recovery (`key`,Date,email) values('$Key',NOW(),'$username')";
            $conn->Execute ( $sql );

            $subject = "Password recovery";
            $body = "<table align='center' dir='ltr' >
							<tr dir='ltr'>
								<td dir='ltr' style='border-bottom:1px solid #ccc; padding:0 0 20px 0'>
									<a href='http://www.ctm1.net' >
										<img src='http://ctm1.net/templates/template_en/images/ctm.jpg' align='right' width='100' border='0'/>
									</a>
									<font size='+1'>Dear customer $name</font>
									<br /><br />
									We recieved a request for changing your component area password.<br />If you approved, simply click on the below link : 
									<br />
									<a href=" . RELA_DIR . "login.php?action=changePass&key=" . $Key . ">" . RELA_DIR . "login/changePass/" . $Key . "</a>
									<br />
									<br />
									Otherwise, please remove this email for safety.
									<br /><br />
									Thank you,
									<br />
									<a href='http://www.ctm1.net' style='text-decoration:none;color:#09C;'>CTM internet provider</a>									
								</td>
							</tr>
						</table>";
            sendmail ( $email , $subject , $body , "" );
            $this->forgotPassSuccess ( LOGIN_013 . "<strong> $email</strong>" );
        }
    }

    function changePass ()
    {
        global $conn , $member_info;

        $key = handleData ( $_GET[ 'key' ] );

        $sql = "select * from password_recovery where `key`='$key' and `Date` >= (NOW()-86400) ";
        $rs = $conn->Execute ( $sql );

        if ( !$rs->RecordCount () ) {
            die( LOGIN_014 );
        } else {

            include ( ROOT_DIR . "templates/" . CURRENT_SKIN . "/component.title.inc.php" );
            include ( ROOT_DIR . "templates/" . CURRENT_SKIN . "/password.change.form.php" );
            include ( ROOT_DIR . "templates/" . CURRENT_SKIN . "/component.tail.inc.php" );

            die();
        }
    }

    function confirmChange ()
    {
        global $conn , $member_info;


        $password = handleData ( $_POST[ 'password' ] );
        $confirm_password = handleData ( $_POST[ 'confirm_password' ] );
        $key = handleData ( $_POST[ 'key' ] );

        if ( $key == "" )
            $this->showEditPassword ( LOGIN_015 );

        if ( $password == "" )
            $this->showEditPassword ( LOGIN_016 );

        if ( strlen ( $password ) > 20 || strlen ( $password ) < 6 )
            $this->showEditPassword ( LOGIN_017 );

        if ( $password != $confirm_password )
            $this->showEditPassword ( LOGIN_018 );

        $sql = "select * from password_recovery where `key`='$key' and `Date` >= (NOW()-86400) ";
        $rs = $conn->Execute ( $sql );

        if ( !$rs->RecordCount () ) {
            die( LOGIN_019 );
        } else {
            $username = $rs->fields[ 'email' ];
            $sql = "select * from members where email='$username'";
            $check = $conn->Execute ( $sql );
            if ( !$check->RecordCount () ) {
                $this->showEditPassword ( LOGIN_020 , '' );
            } else {
                $sql = "update members set change_pass='1', password='" . md5 ( $password ) . "' where email='$username'";
                $update_pass = $conn->Execute ( $sql );

                redirectPage ( RELA_DIR . "login.php" , LOGIN_021 );
            }
        }

    }

    function showEditPassword ( $message )
    {

        include ( ROOT_DIR . "templates/" . CURRENT_SKIN . "/component.title.inc.php" );
        include ( ROOT_DIR . "templates/" . CURRENT_SKIN . "/password.change.form.php" );
        include ( ROOT_DIR . "templates/" . CURRENT_SKIN . "/component.tail.inc.php" );

        die();
    }

    function logOut ()
    {
        global $conn , $member_info;
        $username = $member_info[ 'email' ];
        $sql = "update members set last_login='" . getDateTime () . "' where email='$username'";
        $update_last_login = $conn->Execute ( $sql );
        if ( !$update_last_login ) {
            $this->logInForm ( $redirect , LOGIN_007 );
        }

        if ( isset( $_SESSION[ "sessionID" ] ) ) {
            setcookie ( "sessionID" , '' , time () - 10000 , "/" , $_SERVER[ 'HTTP_HOST' ] );
            $sql = "delete from sessions where session_id ='" . handleData ( $this->decrypt ( $_SESSION[ "sessionID" ] , $this->GetHash () ) ) . "' ";
            $rs = $conn->Execute ( $sql );
            if ( !$rs ) {
                showErrorMsg ( $conn->ErrorMsg () );
            }
        } elseif ( isset( $_COOKIE[ "sessionID" ] ) ) {
            setcookie ( "sessionID" , '' , time () - 10000 , "/" , $_SERVER[ 'HTTP_HOST' ] );
            $sql = "delete from sessions where session_id = " . handleData ( $this->decrypt ( $_COOKIE[ "sessionID" ] , $this->GetHash () ) );
            $rs = $conn->Execute ( $sql );
            if ( !$rs ) {
                showErrorMsg ( $conn->ErrorMsg () );
            }
        }


        session_unset ();
        header ( "Location:" . RELA_DIR . "index2.php" );
    }

    private function memberPage ( $message )
    {
        header ( "Location:" . RELA_DIR );
        echo $message;
    }

}
