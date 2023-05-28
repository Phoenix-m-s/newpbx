<?php

class dbConn{

    protected static $db=array();

    public function __construct($mysqlInfo,$CONNECTION_NAME) {

        // echo '<pre/>';

        $DB_HOST=$mysqlInfo['connections'][$CONNECTION_NAME]['DB_HOST'];
        $DB_DATABASE=$mysqlInfo['connections'][$CONNECTION_NAME]['DB_DATABASE'];
        $DB_USER=$mysqlInfo['connections'][$CONNECTION_NAME]['DB_USER'];
        $DB_PASSWORD=$mysqlInfo['connections'][$CONNECTION_NAME]['DB_PASSWORD'];


        try {

            self::$db[$CONNECTION_NAME] = new PDO("mysql:host=".$DB_HOST.";dbname=".$DB_DATABASE."", $DB_USER, $DB_PASSWORD);

       

        }
        catch (PDOException $e) {
             "Connection Error: " . $e->getMessage();
        }

    }

    public static function getConnection($CONNECTION_NAME='default')
    {
        global $mysql;

        if($CONNECTION_NAME=='')
        {
            $CONNECTION_NAME='default';
        }


        if($CONNECTION_NAME=='default')
        {
            $CONNECTION_NAME=$mysql['default'];
        }


        if (!isset(self::$db[$CONNECTION_NAME]))
        {
            //if(count(self::$db)==0)
            //{
                new dbConn($mysql,$CONNECTION_NAME);

            //}
        }

        boxLogin::boxController();
        //print_r(self::$db[$CONNECTION_NAME]);


        return self::$db[$CONNECTION_NAME];
    }


}


class boxLogin
{

    public static function boxController()
    {
        global $db, $db2;

        $server = constant("SERVER");
        if (!strlen($server) or $server == 'cloud') {
            $db2 = $db;
            return;
        } else {
            $db2 = dbConn2::getConnection();
        }

        if ($_GET['action'] == 'loginByBox') {
            $_SESSION["sessionAdminID"] = $_GET['id'];
            header("Location: " . RELA_DIR );
        } else if ($_SERVER['SCRIPT_NAME'] == '/login.php') {
            header("Location: " . RELA_DIR_BOX);
        } else if ($_SERVER['SCRIPT_NAME'] == '/logout.php') {
            /*global $member_info;
            print_r_debug($member_info);

            header("Location: " . RELA_DIR_BOX . 'login/logout');*/
        }

    }

}



class dbConn2{

    protected static $db;

    public function __construct() {

        try {
            self::$db = new PDO("mysql:host=".DB_HOST2.";dbname=".DB_DATABASE2."", DB_USER2, DB_PASSWORD2);
        }
        catch (PDOException $e) {
            echo "Connection Error: " . $e->getMessage();
        }

    }

    public static function getConnection() {


        if (!self::$db) {
            new dbConn2();
        }
        return self::$db;
    }

}
//ado
// include(ROOT_DIR . "common/lib/adodb.inc.php");
//
// function connectDB()
// {
//     $conn = &ADONewConnection(DB_TYPE);
//
//     $conn->Connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
//
//     return $conn;
// }
