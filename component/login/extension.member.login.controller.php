<?php
include_once ROOT_DIR . "common" . DS . "func.inc.php";
require_once  ROOT_DIR . "component" . DS . "login" . DS . "extension.member.login.model.php";
require_once ROOT_DIR . "component" . DS . "session" . DS . "admin.session.controller.php";

class adminLoginController
{
    private $exportType ;
    private $fileName;

    public function __construct()
    {
        $this->exportType = 'html';
    }

    private function template($list = '')
    {
        switch ($this->exportType) {
            case 'html' :
                include ROOT_DIR . 'templates/' . CURRENT_SKIN . '/template_start.tpl';
                include ROOT_DIR . 'templates/' . CURRENT_SKIN . '/template_header.tpl';
                include ROOT_DIR . 'templates/' . CURRENT_SKIN . "/$this->fileName";
                include ROOT_DIR . 'templates/' . CURRENT_SKIN . '/template_footer.tpl';
                include ROOT_DIR . 'templates/' . CURRENT_SKIN . '/template_end.tpl';
                break;
            case 'json' :
                echo json_encode($list);
                break;
            case 'array' :
                return $list;
                break;
            case 'serialize' :
                echo serialize($list);
                break;
            default :
                break;
        }
    }

    private function GetHash()
    {
        return '%%1^^@@REWcmv21))--';
    }

    private function encrypt($string, $key)
    {
        $result = '';
        for ($i = 0; $i < strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key)) - 1, 1);
            $char = chr(ord($char) + ord($keychar));
            $result .= $char;
        }
        return base64_encode($result);
    }

    private function decrypt($string, $key)
    {
        $result = '';
        $string = base64_decode($string);

        for ($i = 0; $i < strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key)) - 1, 1);
            $char = chr(ord($char) - ord($keychar));
            $result .= $char;
        }
        return $result;
    }

    /*
     | ---------------------------------------------------------------------------------------------------------
     | loginByToken with Oauth Server(SSO) ,
     | loginByRefreshToken (refresh_token)
     | add by Jahanbakhsh
     | ---------------------------------------------------------------------------------------------------------
    */

    public function get_headers_from_curl_response($response)
    {
        $headers = array();

        $header_text = substr($response, 0, strpos($response, "\r\n\r\n"));

        foreach (explode("\r\n", $header_text) as $i => $line)
            if ($i === 0)
                $headers['http_code'] = $line;
            else {
                list ($key, $value) = explode(': ', $line);

                $headers[$key] = $value;
            }

        return $headers;
    }
    public function loginByToken($_input)
    {
        global $memberModel, $member_info;


       /***
        user :jahan@msn.com
        pass:1111
        $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIyIiwianRpIjoiMmM0ZGI2YTQ1Y2UzNjBhYmM0OWRhNDQ1NGUyNWVjNTgyNTg4OWI1ODQ3ZGE2ZGRkMjA3MzllMjZkZTNkMWQyMjkwNzIyMDEzYjllM2FlZGEiLCJpYXQiOjE1OTEwMTM5MjUsIm5iZiI6MTU5MTAxMzkyNSwiZXhwIjoxNjIyNTQ5OTI1LCJzdWIiOiI0MiIsInNjb3BlcyI6W119.T1v_EL0Xnw4DxZhSRL034fbxgeRcu8GHf7fBHXaEwkYx5EvdsJWdfcOsBJuigOXKCT4RGo2RWf4AvjSv-4f73R_t5RFr4kh9KrU5AP9vZiRSEIuaZVIeuopiAnNGsidEdKWFKx4XAubv4Hp19PoIPI-hY8neD7hSA0emJNBtN8Yb2ojrrCRBUnMu-coO34xxHywEQF8IxrQiR8nxpq2RHXeOl59a6kDE21eLYcaHKG_u4DNCpirgRi0fYZJCHAHcxGKkeI2oY_KEzF2UkspYuDNDqmmm-EdAxE-LehNNulX_qYLDVmvLVTdC5A1WzWiVon-pGilUq3aGqBkGimApnxBEgRY_AetaO7Ue2raf9cvtrvjUV34ToQq1S5TxVY5g2Pq4dOUEv80hCGNmHdV-C-L3xvzg9QRqPCBCtfU3Tc7mR9E5JVQPD2BwPUIQp3BdGnluolgjdI79PRQsMiXO9f1re4eYkFcHjp4hBoAIw4SRRL3qgtwWulFAyvML6l7IdAXbdp7dXA8rS7L9Rc6YubTHVdNC63ePjg3u9xtFMefIiNniSzZw7s2z7MXxeorAYQfSdwV5IIRwC3s6i91s492afmjcuMJpqx08mBWPnhtwbze9l8YOCEDSN7QbfjyMMRpR9A_qpD7viqO6qg1TEn9Pjwj_ErCSJBzwxQOR8fU";
       ***/

       /***
        user :1dmin@admin.com
        pass:123456789
        $token ="eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIyIiwianRpIjoiZTU2MGQ4Mzg2NmEwYTBkYjQ4MWYxMGU3Yzg2MDY5ZWJiYmFmY2ExMTM4NTk1NTNjYTk1ODlkMjczYzZkMDIxNzJlYWY5MTExNGNkMDFkNzAiLCJpYXQiOjE1OTA5OTAwNDUsIm5iZiI6MTU5MDk5MDA0NSwiZXhwIjoxNjIyNTI2MDQ1LCJzdWIiOiIyNCIsInNjb3BlcyI6W119.R707oTe-663-qk4GxIaDLY61lR2iuu4aDpUJpaiNaTBcarJzIztKNd25yXlLUWdUdLeMsTKUanKzVa932Zqwjp5KltFYIw9EE3Jy4w_BSMkV0BJ7Iuw6vZkdjOiyKRX_sWLM0BINQGmy9BgI_5s0WogBT7sdBpe8ps-dhrPAfs7tQ1N2z21mSZsGBa_zHBUV-9OIYdp1bDo74-f03Sb0B9ULqjXxXD_M_naXZ-5YmzGehpF-iWBV5B2fLNf1sBPIcHpqNBKVo7txc5ms_uugmdhHCBUqOqVI3iCFYimUZErhzvdmvUVgyoyx12xLfoI6Rxrk4vJHlyDQTycemwBilqRj8KVEc3tqeU63fn3q3e7-LzfGJwpNoUC2tTvZ1sr6BvyXWmbfQ6kg8kJ1ZY5hLseZD1_YBjE489_y9kUh6S0ZVC2UmsfuKTBonWNLmWaUuq9DsefYLI72Lz8RuuZHwjSezsK4I8MisKoEBYhQAW4LnbwQRvsq3uD71LUZuDU3e-7n8KSra7ovYt_AG0YqnrqQ-0xPuDuni6u1tS9WpCb78LHLpqUv2WnK6Vm6bM3byeZPnq1twa_RBc_qtBJlS9B2saxccPb4dd9ib3yoFcLohivs96-c94_6YT3k6fMQKxSqP4_WFhgCwabYEUqwMOP1AlzVy4Hdb0wwUO3c51A";
        ***/

         $token = $_GET['token'];

         // curl
         $curl = curl_init();
         curl_setopt_array($curl, array(
             CURLOPT_URL => "http://logincontainer.dabacenter.ir/api/checklogin",
             CURLOPT_RETURNTRANSFER => true,
             CURLOPT_ENCODING => "",
             CURLOPT_MAXREDIRS => 10,
             CURLOPT_TIMEOUT => 0,
             CURLOPT_FOLLOWLOCATION => true,
             CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
             CURLOPT_CUSTOMREQUEST => "GET",
             CURLOPT_HTTPHEADER => array(
                 "accept: application/json",
                 "cache-control: no-cache",
                 "content-type: application/json",
                 //"Authorization: Bearer " . $token,
             ),

         ));

         $response = curl_exec($curl);

         /*$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
         $header = substr($a, 0, $header_size);
         $headers=$this->get_headers_from_curl_response($header);*/

        curl_close($curl);

        $fields=json_decode($response);

        //info extention
        //dd($fields);

        if(is_object($fields) and !isset($fields->id))
        {
            $msg = "Try aging!";
            redirectPage (RELA_DIR, $msg);
        }

        // curl

        $username = $fields->email;

        $remember_me = 0;


        /*
        | ---------------------------------------------------------------------------------------------------------
        | Hashing the Password that user has been entered
        | due to compare it with the existing one at
        | the database $password = md5($password)
        | if the user exists in the database
        | ---------------------------------------------------------------------------------------------------------
        */
        $memberDirty = memberLoginModel::getBy_username($username)->first();


        if(!is_object($memberDirty)) {
            redirectPage (RELA_DIR, "User Name Or Password Is Wrong");
        }

        $memberClean = $memberDirty->fields;

        /*
        | ---------------------------------------------------------------------------------------------------------
        | delete the users that had been stored
        | more than $time in session table
        | ---------------------------------------------------------------------------------------------------------
        */
        $sessionController = new adminSessionController(3000000);

        /*
        | ---------------------------------------------------------------------------------------------------------
        | if there is a user in the session already
        | then delete it, so we can renew it.
        | ---------------------------------------------------------------------------------------------------------
        */
        //$result = $sessionController->deleteSessionById($memberClean['extension_id']);

        /*if($result['result'] != 1){
            die('Error deleting session');
        }*/

        /*
        | ---------------------------------------------------------------------------------------------------------
        | set his attributes and His ID(Hashed) in session table
        | ---------------------------------------------------------------------------------------------------------
        */
        $fields = array(
            'login_type' => 2,
            'member_id' => $memberClean['extension_id'],
            'remote_addr' => $_SERVER["REMOTE_ADDR"],
            'last_access_access' => getDatetime(),
            'remember_me' => $remember_me
        );

        $sessionController->addSession($fields);

        /*
        | ---------------------------------------------------------------------------------------------------------
        | finding the user in session class and store
        | his hashed id in the $_SESSION['id'].
        | ---------------------------------------------------------------------------------------------------------
        */
        $_SESSION["sessionAdminID"] = $this->encrypt($memberClean['extension_id'], $this->GetHash());
        //$_SESSION["memberUsername"] = $memberClean['extension_name'] ;

        /*
        | ---------------------------------------------------------------------------------------------------------
        | if he activated the "REMEMBER ME"  option then
        | add 36 * pow( 10, 11 ) to his life time in
        | database( so he will be removed in
        | a long time )
        | ---------------------------------------------------------------------------------------------------------
        */
        if (isset($remember_me)) {
            setcookie("sessionAdminID", $_SESSION["sessionAdminID"], time() + 3600000000000, "/", $_SERVER['HTTP_HOST']);
        } else {
            /*
            | ---------------------------------------------------------------------------------------------------------
            | else: add just 3600 to his life time in database;
            | ---------------------------------------------------------------------------------------------------------
            */
            setcookie ("sessionAdminID", $_SESSION["sessionAdminID"], time() + 3600, "/", $_SERVER['HTTP_HOST']);
        }

        $member_info = $this->checkLogin();

        //        $resultLog = $this->_setAdminLog ( $member_info[ 'admin_id' ] );
        //        if ( !$resultLog ) {
        //            ///set notification
        //        }


        redirectPage(RELA_DIR, "");
        die();
    }
    //***************** refresh_token
    //We MUST, use from new token ,any time generate token and refresh_token , for loginByToken()
    public function loginByRefreshToken($_input)
    {
        global $memberModel, $member_info;

         $token = $_GET['refresh_token'];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://logincontainer.dabacenter.ir/oauth/token",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\n\t\"client_id\"\t: 2 ,
            \n\t\"client_secret\" : \"KtYS6AHdg6eVnXTjUq51iipMHZ2DFFLbzneP6xy9\" ,
             \n\t\n\t\"grant_type\" : \"refresh_token\" , 
             \n\t\"refresh_token\" : \"def5020009c13b927930dac82d61604021fd6b9726bba135b4e293c86e378d8d8a03bac801226e98435b8440e818e8573e62f58205a3d3e0defaad53acb16849b51ec4eb45e037554dfbe22263b43ff8c8ab775fadc97299092c6d2ce9312bc90e46637232c285fb83ccc125e93a8c4c60dae7e2ccf6c371592c1763a3738c1ff00f4430f3972b993a6c5a414e19ceb6ddf4df0b74163938f44883c7b51814d8f876031186a5f95b8346790328ceaba11b821259944a05f6e179fcb9a2da3b32b8bb66ee39f82fc72b4e96e90c35fd420a43b6c8647340b05f5fea5640bb12076e2fdc9df53fa376f94e926fbe9f172a4504681d509eeaf63a3d6f92dbd7b6daaf8f2d72c3a6e00572a348a1e92ac42b9e25f34a19ce32e4604286f6e4ed0bca914d83c4256a96ee2909eef62a4ebbfa913b8168580487e5a1d6d1301ab34324c892483be064ade3ded4a8f3059627f5404f9a6ac004912706778f6fcfc2f30c5c99\"\n}",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json"
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;

        $fields=json_decode($response);
        //token & refresh_token
        //dd($fields);


        if(is_object($fields) and !isset($fields->id))
        {
            $msg = "Try aging!";
            redirectPage (RELA_DIR, $msg);
        }


        /*
        | ---------------------------------------------------------------------------------------------------------
        | checking the length of the username and password
        | and to make sure they are empty so redirect
        | to the login page with an proper error.
        | ---------------------------------------------------------------------------------------------------------
        */
        /*if (($username == '' || strlen($username) > 20) and ($password == '' || strlen($password) > 20)) {
            $msg = "طول نام کاربری و رمز عبور باید کمتر از 20 حرف باشد.";
            redirectPage ('', $msg);
            die();
        }*/
        // curl



        /*
        | ---------------------------------------------------------------------------------------------------------
        | strip the slashes from variables
        | ---------------------------------------------------------------------------------------------------------
        */
        $username = $fields->email;

        /*
        | ---------------------------------------------------------------------------------------------------------
        | checking if the user choose the remember me !
        | ---------------------------------------------------------------------------------------------------------
        */

        $remember_me = 0;


        /*
        | ---------------------------------------------------------------------------------------------------------
        | Hashing the Password that user has been entered
        | due to compare it with the existing one at
        | the database $password = md5($password)
        | if the user exists in the database
        | ---------------------------------------------------------------------------------------------------------
        */
        $memberDirty = memberLoginModel::getBy_username($username)->first();


        if(!is_object($memberDirty)) {
            redirectPage (RELA_DIR, "User Name Or Password Is Wrong");
        }

        $memberClean = $memberDirty->fields;

        /*
        | ---------------------------------------------------------------------------------------------------------
        | delete the users that had been stored
        | more than $time in session table
        | ---------------------------------------------------------------------------------------------------------
        */
        $sessionController = new adminSessionController(3000000);

        /*
        | ---------------------------------------------------------------------------------------------------------
        | if there is a user in the session already
        | then delete it, so we can renew it.
        | ---------------------------------------------------------------------------------------------------------
        */
        //$result = $sessionController->deleteSessionById($memberClean['extension_id']);

        /*if($result['result'] != 1){
            die('Error deleting session');
        }*/

        /*
        | ---------------------------------------------------------------------------------------------------------
        | set his attributes and His ID(Hashed) in session table
        | ---------------------------------------------------------------------------------------------------------
        */
        $fields = array(
            'login_type' => 2,
            'member_id' => $memberClean['extension_id'],
            'remote_addr' => $_SERVER["REMOTE_ADDR"],
            'last_access_access' => getDatetime(),
            'remember_me' => $remember_me
        );

        $sessionController->addSession($fields);

        /*
        | ---------------------------------------------------------------------------------------------------------
        | finding the user in session class and store
        | his hashed id in the $_SESSION['id'].
        | ---------------------------------------------------------------------------------------------------------
        */
        $_SESSION["sessionAdminID"] = $this->encrypt($memberClean['extension_id'], $this->GetHash());
        //$_SESSION["memberUsername"] = $memberClean['extension_name'] ;

        /*
        | ---------------------------------------------------------------------------------------------------------
        | if he activated the "REMEMBER ME"  option then
        | add 36 * pow( 10, 11 ) to his life time in
        | database( so he will be removed in
        | a long time )
        | ---------------------------------------------------------------------------------------------------------
        */
        if (isset($remember_me)) {
            setcookie("sessionAdminID", $_SESSION["sessionAdminID"], time() + 3600000000000, "/", $_SERVER['HTTP_HOST']);
        } else {
            /*
            | ---------------------------------------------------------------------------------------------------------
            | else: add just 3600 to his life time in database;
            | ---------------------------------------------------------------------------------------------------------
            */
            setcookie ("sessionAdminID", $_SESSION["sessionAdminID"], time() + 3600, "/", $_SERVER['HTTP_HOST']);
        }

        $member_info = $this->checkLogin();

        //        $resultLog = $this->_setAdminLog ( $member_info[ 'admin_id' ] );
        //        if ( !$resultLog ) {
        //            ///set notification
        //        }


        redirectPage(RELA_DIR, "");
        die();
    }
    public function login($_input)
    {

        global $memberModel, $member_info;

        /*
        | ---------------------------------------------------------------------------------------------------------
        | strip the slashes from variables
        | ---------------------------------------------------------------------------------------------------------
        */
        $username = $_input["username"];
        $password = $_input["password"];

        /*
        | ---------------------------------------------------------------------------------------------------------
        | checking if the user choose the remember me !
        | ---------------------------------------------------------------------------------------------------------
        */
        if (isset($_input['remember_me'])) {
            $remember_me = $_input['remember_me'];
        } else {
            $remember_me = 0;
        }

        /*
        | ---------------------------------------------------------------------------------------------------------
        | checking the length of the username and password
        | and to make sure they are empty so redirect
        | to the login page with an proper error.
        | ---------------------------------------------------------------------------------------------------------
        */
        if (($username == '' || strlen($username) > 20) and ($password == '' || strlen($password) > 20)) {
            $msg = "طول نام کاربری و رمز عبور باید کمتر از 20 حرف باشد.";
            redirectPage ('', $msg);
            die();
        }


        /*
        | ---------------------------------------------------------------------------------------------------------
        | Hashing the Password that user has been entered
        | due to compare it with the existing one at
        | the database $password = md5($password)
        | if the user exists in the database
        | ---------------------------------------------------------------------------------------------------------
        */
        $memberDirty = memberLoginModel::getBy_username_and_password($username, $password)->first();

        if(!is_object($memberDirty)) {
            redirectPage (RELA_DIR, "User Name Or Password Is Wrong");
        }

        $memberClean = $memberDirty->fields;

        /*
        | ---------------------------------------------------------------------------------------------------------
        | delete the users that had been stored
        | more than $time in session table
        | ---------------------------------------------------------------------------------------------------------
        */
        $sessionController = new adminSessionController(3000000);

        /*
        | ---------------------------------------------------------------------------------------------------------
        | if there is a user in the session already
        | then delete it, so we can renew it.
        | ---------------------------------------------------------------------------------------------------------
        */
        //$result = $sessionController->deleteSessionById($memberClean['extension_id']);

        /*if($result['result'] != 1){
            die('Error deleting session');
        }*/

        /*
        | ---------------------------------------------------------------------------------------------------------
        | set his attributes and His ID(Hashed) in session table
        | ---------------------------------------------------------------------------------------------------------
        */
        $fields = array(
            'login_type' => 2,
            'member_id' => $memberClean['extension_id'],
            'remote_addr' => $_SERVER["REMOTE_ADDR"],
            'last_access_access' => getDatetime(),
            'remember_me' => $remember_me
        );

        $sessionController->addSession($fields);

        /*
        | ---------------------------------------------------------------------------------------------------------
        | finding the user in session class and store
        | his hashed id in the $_SESSION['id'].
        | ---------------------------------------------------------------------------------------------------------
        */
        $_SESSION["sessionAdminID"] = $this->encrypt($memberClean['extension_id'], $this->GetHash());
        //$_SESSION["memberUsername"] = $memberClean['extension_name'] ;

        /*
        | ---------------------------------------------------------------------------------------------------------
        | if he activated the "REMEMBER ME"  option then
        | add 36 * pow( 10, 11 ) to his life time in
        | database( so he will be removed in
        | a long time )
        | ---------------------------------------------------------------------------------------------------------
        */
        if (isset($remember_me)) {
            setcookie("sessionAdminID", $_SESSION["sessionAdminID"], time() + 3600000000000, "/", $_SERVER['HTTP_HOST']);
        } else {
            /*
            | ---------------------------------------------------------------------------------------------------------
            | else: add just 3600 to his life time in database;
            | ---------------------------------------------------------------------------------------------------------
            */
            setcookie ("sessionAdminID", $_SESSION["sessionAdminID"], time() + 3600, "/", $_SERVER['HTTP_HOST']);
        }

        $member_info = $this->checkLogin();
        //print_r_debug($member_info);

        //        $resultLog = $this->_setAdminLog ( $member_info[ 'admin_id' ] );
        //        if ( !$resultLog ) {
        //            ///set notification
        //        }

        redirectPage(RELA_DIR, "");

        die();
    }
    public function checkLogin()
    {
        global $memberModel;
        $sessionController = new adminSessionController();

        /*
        | ---------------------------------------------------------------------------------------------------------
        | checking if the $_SESSION and $_COOKIE has been set or not
        | ---------------------------------------------------------------------------------------------------------
         */
        if (!isset($_SESSION['sessionAdminID'])) {
            if (!isset($_COOKIE['sessionAdminID'])) {
                return -1;
            } else {
                /*
                | ---------------------------------------------------------------------------------------------------------
                | if it has been set then find the session id
                | ---------------------------------------------------------------------------------------------------------
                 */
                $sessionAdminID = $this->decrypt($_COOKIE['sessionAdminID'], $this->GetHash());
            }
        } else {
            $sessionAdminID = $this->decrypt($_SESSION['sessionAdminID'], $this->GetHash());
        }

        /*
        | ---------------------------------------------------------------------------------------------------------
        | find the related admin from the session table
        | ---------------------------------------------------------------------------------------------------------
         */
        $user = $sessionController->getSessionByMemberId($sessionAdminID);

        /*
        | ---------------------------------------------------------------------------------------------------------
        | finding the related admin(his/her id has
        | been achieved from the session or
        | cookie) from the admin table
        | ---------------------------------------------------------------------------------------------------------
         */
        $user = $memberModel::getBy_extension_id($user['member_id'])->first();
        if (!is_object($user)) {
            return -1;
        }

        return $user->fields;
    }

    public function showLoginForm()
    {
        $this->fileName = ROOT_DIR . 'templates/' . CURRENT_SKIN . 'login.php';
        $this->template();
        die();
    }


}