<?php

class admin
{

    private static function GetHash ()
    {
        return '%%1^^@@REWcmv21))--';
    }

    function encrypt ( $string, $key )
    {
        $result = '';
        for ($i = 0; $i < strlen ($string); $i ++) {
            $char = substr ($string, $i, 1);
            $keychar = substr ($key, ( $i % strlen ($key) ) - 1, 1);
            $char = chr (ord ($char) + ord ($keychar));
            $result .= $char;
        }
        return base64_encode ($result);
    }

    function decrypt ( $string, $key )
    {
        $result = '';
        $string = base64_decode ($string);

        for ($i = 0; $i < strlen ($string); $i ++) {
            $char = substr ($string, $i, 1);
            $keychar = substr ($key, ( $i % strlen ($key) ) - 1, 1);
            $char = chr (ord ($char) - ord ($keychar));
            $result .= $char;
        }
        return $result;
    }

    function getSession_id()
    {
        $session[ 'decrypt' ] = $this->decrypt ($_SESSION[ "sessionAdminID" ], $this->GetHash ());
        $session[ 'encrypt' ] = $_SESSION[ "sessionAdminID" ];
        return $session;
    }

    function loginform ( $message = '' )
    {
        global $conn, $messageStack;
        include ( ROOT_DIR . "templates/" . CURRENT_SKIN . "/admin.login.php" );
        die();
    }
    
    function login ()
    {
        global $admin_info, $messageStack, $company_info,$db2;


        $username = handleData ($_REQUEST[ "username" ]);
        $password = handleData ($_REQUEST[ "password" ]);


        if ( $username == "" || strlen ($username) > 20 )
            $messageStack->add_session ('login', ModelADMIN_41, 'error');

        if ( $password == "" || strlen ($password) > 20 )
            $messageStack->add_session ('login', ModelADMIN_42, 'error');

        if ( $messageStack->size ('login') > 0 ) {
            //redirectPage($_SERVER['HTTP_REFERER'],"");
        }

        $sql = "DELETE FROM sessions_admin WHERE last_access_time < (NOW()-3000000)";


        $db2->query ( $sql );

        $password = md5 ( $password );

        $sql = "SELECT `admin_id` ,`comp_id` , `name`, `family` FROM `admin` where `comp_id` = '" . $company_info[ 'comp_id' ] . "' AND `username` = '" . $username . "' AND password = '" . $password . "'";

        $admin_rs = $db2->query ( $sql );

        $obj = $admin_rs->fetch ( PDO::FETCH_OBJ );


        if ( !$admin_rs ) {
            print_r ( $db2->errorInfo () );
        }

        $count = $admin_rs->rowCount ();

        if ( $count == 0 ) {
            $messageStack->add_session ( 'login', ModelADMIN_43, 'error' );
            redirectPage ($_SERVER[ 'HTTP_REFERER' ], "" );
        } elseif ( $count ) {

            $sql = "DELETE FROM sessions_admin WHERE admin_id='" . $obj->admin_id . "'";
            $db2->exec ( $sql );
            $sql = "DELETE FROM login_as WHERE admin_id='" . $obj->admin_id . "'";
            $db2->exec ( $sql );

            $sql = "
					  insert into sessions_admin( admin_id, compid, remote_addr, last_access_time )
			  values
			  		  (" . $obj->admin_id . ",'" . $obj->comp_id . "', '" . $_SERVER[ "REMOTE_ADDR" ] . "', '" . getDateTime () . "')";
            $rs = $db2->query ( $sql );

            if ( !$rs ) {
                print_r ( $db2->errorInfo () );
            }


            $_SESSION[ "sessionAdminID" ] = $this->encrypt ( $db2->lastInsertId (), $this->GetHash () );
            $_SESSION[ "adminUsername" ] = $obj->name . " " . $obj->family;


            if ( isset( $remember_me ) ) {
                setcookie ( "sessionAdminID", $_SESSION[ "sessionAdminID" ], time () + 3600000000000, "/", $_SERVER[ 'HTTP_HOST' ]);
            } else {
                setcookie ( "sessionAdminID", $_SESSION[ "sessionAdminID" ], time () + 3600, "/", $_SERVER[ 'HTTP_HOST' ]);
            }
            $admin_info = $this->checkLogin ();
            $resultLog = $this->_setAdminLog ( $admin_info[ 'admin_id' ] );
            if ( !$resultLog ) {
                ///set notification
            }
            $messageStack->add_session ( 'redirect', ModelADMIN_44, 'success' );

            if ($admin_info['type'] == 2) {
                redirectPage ( RELA_DIR . "queue.php?action=showLiveQueue","");
            } else {
                redirectPage ( RELA_DIR, $company_info );
            }
        }
    }

    function checkLogin ()
    {

        global $db,$db2, $company_info;

        if ( !isset( $_SESSION[ "sessionAdminID" ] ) ) {
            if ( !isset( $_COOKIE[ "sessionAdminID" ] ) ) {
                return - 1;
            } else {
                $sessionAdminID = $this->decrypt ($_COOKIE[ "sessionAdminID" ], $this->GetHash ());
            }
        } else {
            $sessionAdminID = $this->decrypt ($_SESSION[ "sessionAdminID" ], $this->GetHash ());
        }

        $sql="SELECT admin_id FROM sessions_admin WHERE session_id = '$sessionAdminID' AND `compid` = '" . $company_info[ 'comp_id' ] . "' ";

        $row = $db2->query ($sql);

        $row = $row->fetch (PDO::FETCH_OBJ);
        if ( !$row ) {
            return - 1;
        }

        $rs = $db2->query ("select * from admin where admin_id='" . $row->admin_id . "'");

        if ( !$rs or !$rs->rowCount() ) {
            return - 1;
        }

        $obj = $rs->fetch (PDO::FETCH_ASSOC);

        if ( $obj[ 'comp_id' ] != $company_info[ 'comp_id' ] ) {
            $obj[ 'loginAs' ] = $company_info[ 'comp_id' ];
        } else {
            $obj[ 'loginAs' ] = '';
        }

        return $obj;
    }




    function userLogout ()
    {
        $db = new dbConn();
        $db = $db->getConnection ();


        global $member_info;


        if ( isset( $_SESSION[ "sessionAdminID" ] ) ) {
            $sessionID = $this->decrypt ($_SESSION[ "sessionAdminID" ], $this->GetHash ());

            setcookie ("sessionAdminID", $sessionID, time () - 10000, "/", $_SERVER[ 'HTTP_HOST' ]);

            $sql = "delete from sessions_admin where session_id='$sessionID'";
            $rs = $db->query ($sql);

            $sql = "delete from login_as where session_id='$sessionID'";
            $rs = $db->query ($sql);

            if ( !$rs ) {
                print_r ($db->errorInfo ());
            }
        } elseif ( isset( $_COOKIE[ "sessionAdminID" ] ) ) {
            $sessionID = $this->decrypt ($_COOKIE[ "sessionAdminID" ], $this->GetHash ());

            setcookie ("sessionAdminID", $sessionID, time () - 10000, "/", $_SERVER[ 'HTTP_HOST' ]);

            $sql = "delete from sessions_admin where session_id='$sessionID'";
            $rs = $db->query ($sql);

            $sql = "delete from login_as where session_id='$sessionID'";
            $rs = $db->query ($sql);

            if ( !$rs ) {
                print_r ($db->errorInfo ());
            }
        }

        session_unset ();
        redirectPage (RELA_DIR.'user.php', ModelADMIN_45);
    }

    function logout ()
    {
        $db = new dbConn();
        $db = $db->getConnection ();


        global $member_info,$admin_info;

        if ($admin_info==-1)
        {
            redirectPage (RELA_DIR);
            die();
        }

        $server = constant("SERVER");
        if (strlen($server) and $server != 'cloud') {
            header("Location: " . RELA_DIR_BOX . 'login/logout');
            die();

        }

        if ( isset( $_SESSION[ "sessionAdminID" ] ) ) {
            $sessionID = $this->decrypt ($_SESSION[ "sessionAdminID" ], $this->GetHash ());

            setcookie ("sessionAdminID", $sessionID, time () - 10000, "/", $_SERVER[ 'HTTP_HOST' ]);

            $sql = "delete from sessions_admin where session_id='$sessionID'";
            $rs = $db->query ($sql);

            $sql = "delete from login_as where session_id='$sessionID'";
            $rs = $db->query ($sql);

            if ( !$rs ) {
                print_r ($db->errorInfo ());
            }
        } elseif ( isset( $_COOKIE[ "sessionAdminID" ] ) ) {
            $sessionID = $this->decrypt ($_COOKIE[ "sessionAdminID" ], $this->GetHash ());

            setcookie ("sessionAdminID", $sessionID, time () - 10000, "/", $_SERVER[ 'HTTP_HOST' ]);

            $sql = "delete from sessions_admin where session_id='$sessionID'";
            $rs = $db->query ($sql);

            $sql = "delete from login_as where session_id='$sessionID'";
            $rs = $db->query ($sql);

            if ( !$rs ) {
                print_r ($db->errorInfo ());
            }
        }

        session_unset ();
        redirectPage (RELA_DIR, ModelADMIN_45);
    }

    function checkAdminTask ( $admin_id, $task_id )
    {
        global $conn;
        if ( $admin_id == 100 ) {
            return 0;
        }

        $sql = "select * from admin_task a, tasks b	where a.admin_id = " . $admin_id . " and a.task_id = b.task_id and b.task_id = '" . $task_id . "'";
        $rs = $conn->Execute ($sql);
        if ( !$rs ) {
            return - 1;
        }
        if ( $rs->RecordCount () != 1 ) {
            return - 2;
        }
        return 0;
    }

    private function _setAdminLog ()
    {
        $db = new dbConn();
        $db = $db->getConnection ();

        $temp = func_get_args ();
        $adminID = $temp[ 0 ];
        $IP = $_SERVER[ 'REMOTE_ADDR' ];

        $Query = $db->exec ("INSERT INTO admin_log(admin_id,ip,access_time) VALUES ('$adminID','$IP',NOW())");

        if ( !$Query ) {
            return FALSE;
        }
        return TRUE;
    }

    function getCompanyBysessionID ( $sessionID )
    {
        $conn = dbConn::getConnection ();
        $sessionID = $this->decrypt ($sessionID, $this->GetHash ());

        $sql = "

			SELECT
			  `tbl_company`.`comp_name`
			FROM
			  `sessions`
			  LEFT JOIN `tbl_company` ON `sessions`.`comp_id` = `tbl_company`.`comp_id`
			WHERE
			  `sessions`.`session_id` = '$sessionID'";

        $stmt = $conn->prepare ($sql);
        $stmt->execute ();
        $stmt->setFetchMode (PDO::FETCH_ASSOC);

        if ( !$stmt ) {
            $result[ 'result' ] = - 1;
            $result[ 'Number' ] = 1;
            $result[ 'msg' ] = $conn->errorInfo ();
            return $result;
        }
        if ( $stmt->rowCount () ) {
            $result = $stmt->fetch ();
            $comp_name = $result[ 'comp_name' ];
        } else {
            $comp_name = - 1;
        }
        return $comp_name;
    }

    function loginas ( $_input )
    {
        global $admin_info, $messageStack, $company_info;
        $db = dbConn::getConnection ();

        $sessionID = $_input[ 's' ];
        //$sessionID='2471';
        //$sessionID=$this->encrypt($sessionID,$this->GetHash());
        $sessionID = $this->decrypt ($sessionID, $this->GetHash ());

        $sql = "DELETE FROM login_as WHERE last_access_time < (NOW()-3000000)";

        $db_rs = $db->query ($sql);

        $sql = "SELECT `admin_id` ,`comp_id`,`ascomp_id` FROM `login_as` where `ascomp_id` = '" . $company_info[ 'comp_id' ] . "' AND `session_id` = '" . $sessionID . "' ";

        $admin_rs = $db->query ($sql);

        if ( !$admin_rs ) {
            print_r ($db->errorInfo ());
        }

        $obj = $admin_rs->fetch (PDO::FETCH_OBJ);

        $count = $admin_rs->rowCount ();

        if ( $count == 0 ) {
            $messageStack->add_session ('login', ModelADMIN_43, 'error');
            return;
        } elseif ( $count ) {
            $sql = "DELETE FROM sessions_admin WHERE admin_id='" . $obj->admin_id . "'";
            $rs = $db->query ($sql);

            $sql = "DELETE FROM login_as WHERE admin_id='" . $obj->admin_id . "'
			 AND  `session_id` <> '" . $sessionID . "'";
            $rs = $db->query ($sql);

            $getDateTime = date ("Y-m-d H:i:s");
            $sql = "
					  insert into sessions_admin(`admin_id`,`compid`,`comp_id`,`remote_addr`,`last_access_time`)
			  values
					(
					'" . $obj->admin_id . "',
					'" . $obj->ascomp_id . "',
					'" . $obj->ascomp_id . "',
					'" . $_SERVER[ "REMOTE_ADDR" ] . "',
					'" . $getDateTime . "'
					)";
            $rs = $db->query ($sql);

            //print_r($rs);
            //die($sql);
            if ( !$rs ) {
                print_r ($db->errorInfo ());
            }

            $_SESSION[ "sessionAdminID" ] = $this->encrypt ($db->lastInsertId (), $this->GetHash ());
            //$_SESSION["adminUsername"] = $obj->name . " " . $obj->family;

            setcookie ("sessionAdminID", $_SESSION[ "sessionAdminID" ], time () + 36000, "/", $_SERVER[ 'HTTP_HOST' ]);


            $admin_info = $this->checkLogin ();

            //print_r($admin_info);

            //print_r($admin_info);
            //die();
            //$resultLog  = $this->_setAdminLog($admin_info['admin_id']);

            //$messageStack->add_session('redirect', "Welcome to Admin Panel", 'success');

            redirectPage (RELA_DIR . 'loginAs.php', "");
        }
    }

}
