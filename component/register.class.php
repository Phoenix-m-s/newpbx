<?php

class MemberRegister extends getProduct
{

    function showRegisterForm($message)
    {
        global $conn, $member_info;

        $sql = "select Name,ID from city ORDER BY Name";
        //echo'<pre>';
        //print_r($sql);
        //die();
        $rs = $conn->Execute($sql);

        if (!$rs) {
            showErrorMsg($conn->ErrorMsg());
        }

        $help = "register.php";

        include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/register.php");

    }

    function registerForm($message)
    {
        global $conn, $member_info;

        $sql = "select Name,ID from city ORDER BY Name";
        //echo'<pre>';
        //print_r($sql);
        //die();
        $rs = $conn->Execute($sql);

        if (!$rs) {
            showErrorMsg($conn->ErrorMsg());
        }
        $help = "register.php";

        include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/component.title.inc.php");
        include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/register.php");
        include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/component.tail.inc.php");
        die();
    }

    function registerFormTower($message)
    {
        global $conn, $member_info;

        $sql = "select Name,ID from city ORDER BY Name";
        //echo'<pre>';
        //print_r($sql);
        //die();
        $rs = $conn->Execute($sql);

        if (!$rs) {
            showErrorMsg($conn->ErrorMsg());
        }
        $help = "register.tower.php";
        $pageTitle = ModelREGISTER_01;
        include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/component.title.inc.php");
        include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/register.tower.php");
        include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/component.tail.inc.php");
        die();
    }

    function showSuccess($message)
    {
        global $conn, $member_info;

        include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/component.title.inc.php");
        include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/registerSuccess.php");
        include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/component.tail.inc.php");
        die();
    }

//***********************************************************************************
    function getUsersByEmail($email)
    {

        global $conn;
        $conn->SetFetchMode(ADODB_FETCH_ASSOC);
        $sql = "select * from members where email='$email'";
        $rs = $conn->Execute($sql);
        if (!$rs) {
            showErrorMsg($conn->ErrorMsg());
        }

        return $rs;
    }


//******************************alizadeh****************************************		
    function newRegisteration($email = "", $name = "", $family = "", $password = "", $mobile = "", $register_date = "", $address = "", $city = "", $status = "")
    {

        global $conn, $member_info;


        if ($email == "") {
            $ret['result'] = -1;
            $ret['msg'] = ModelREGISTER_02;
            $ret['err'] = 1;
            return $ret;

        }


        if (!checkMail($email)) {
            $ret['result'] = -1;
            $ret['msg'] = ModelREGISTER_03;
            $ret['err'] = 2;
            return $ret;

        }


        $check = $this->getUsersByEmail($email);

        if ($check->RecordCount() != 0) {

            $ret['result'] = -1;
            $ret['id'] = $check->fields['member_id'];
            $ret['msg'] = ModelREGISTER_04;
            $ret['err'] = 3;
            return $ret;

        }


        if ($password == "") {

            $passemail = generatePassword();
            $password = md5($passemail);

        }
        if ($status == '') {
            $status = 0;
        }
        $sql = "INSERT INTO members 
				(name
				,family	
				,email
				,password
				,mobile
				,register_date
				,address
				,city_id
				,status) 
			VALUES 
				('$name'
				,'$family'
				,'$email'
				,'" . md5($password) . "'
				,'$mobile'
				,NOW()
				,'$address'
				,'$city'
				,'$status')";

        $add_reg_rs = $conn->Execute($sql);
        if (!$add_reg_rs) {
            $ret['result'] = -1;
            $ret['msg'] = ModelREGISTER_05;
            $ret['err'] = 4;
            return $ret;
        }

        //************************************Group Points********************************************//
        include_once(ROOT_DIR . "component/group.points.class.php");
        $setGroupPoints = new setGroupPoints();

        $setGroupPoints->_userType = '110000';
        $setGroupPoints->_memberID = $conn->INSERT_ID();
        $setGroupPoints->_groupAction = 'Register';
        $Result = $setGroupPoints->setPoints();
        //************************************Group Points********************************************//

        include_once(ROOT_DIR . "component/mail.class.php");
        $mail = new clsEmail();
        $mail->variable = array('username' => $email
        , 'password' => $passemail);

        $email_html = $mail->parse('email.register.template.php');

        $subject = ModelREGISTER_06;
        sendmail($email, $subject, $email_html, "");

        $ret['result'] = 1;
        $ret['msg'] = ModelREGISTER_07;
        $ret['err'] = 5;
        return $ret;
    }

//**********************************************************************************
    function registration()
    {

        global $conn;
        $name = handleData($_POST['name']);
        $family = handleData($_POST['family']);
        $email = handleData($_POST['email']);
        $password = handleData($_POST['password']);
        $confirm_password = handleData($_POST['confirm_password']);
        $mobile = handleData($_POST['mobile']);
        $address = handleData($_POST['address']);
        $city = handleData($_POST['city']);
        $captcha = handleData($_POST['captcha']);
        $agree = handleData($_REQUEST['agree']);


        //$phone = '+1 (801) 555-1212 begin_of_the_skype_highlighting              +1 (801) 555-1212      end_of_the_skype_highlighting';
        /*		$phone = preg_replace('/\D/', '', $phone);  # remove non-digits
                $regex = '/^(?:1)?(?(?!(37|96))[2-9][0-8][0-9](?<!(11)))?[2-9][0-9]{2}(?<!(11))[0-9]{4}(?<!(555(01([0-9][0-9])|1212)))$/';
                if(preg_match($regex, $phone)){
                    echo 'Valid!';
                }else{
                    echo 'Invalid!';
                }
                die();*/

        if ($name == "") {
            $this->registerForm(ModelREGISTER_08);
            die();
        }
        if (strlen($name) > 20 || strlen($name) < 3) {
            $this->registerForm(ModelREGISTER_09);
        }
        if (is_numeric($name)) {
            $this->registerForm(ModelREGISTER_10);
        }
        if ($family == "") {
            $this->registerForm(ModelREGISTER_11);
            die();
        }
        if (strlen($family) > 20 || strlen($family) < 3) {
            $this->registerForm(ModelREGISTER_12);
        }
        if (is_numeric($family)) {
            $this->registerForm(ModelREGISTER_13);
        }

        $result = mobileChecker($_POST['prefixMob'], $mobile);
        if ($result['result'] == '-1')
            $this->registerForm($result['msg']);

        if (checkMail($email) == 0) {
            $this->registerForm(ModelREGISTER_14);
        }

        $sql = "select email from members where email='$email'";
        $rs = $conn->Execute($sql);
        if ($rs->RecordCount() != 0) {
            $this->registerForm(ModelREGISTER_15);
        }

        if ($password == '' || $confirm_password == '') {
            $this->registerForm(ModelREGISTER_16);
        }
        if (strlen($password) > 20 || strlen($password) < 4) {
            $this->registerForm(ModelREGISTER_17);
        }
        if ($password != $confirm_password) {
            $this->registerForm(ModelREGISTER_18);
        }

        if ($email == "") {
            $this->registerForm(ModelREGISTER_19);
            die();
        }
        if ($city == "") {
            $this->registerForm(ModelREGISTER_20);
            die();
        }
        if (!is_numeric($mobile) && $mobile != '') {
            $this->registerForm(ModelREGISTER_21);
            die();
        }
        if ($captcha == "") {
            $this->registerForm(ModelREGISTER_22);
            die();
        }
        if ($captcha != $_SESSION['random_code']) {
            $this->registerForm(ModelREGISTER_23);
            die();
        }

        $sql = "INSERT INTO members (name,family,email,password,status,mobile,register_date,address,city_id) VALUES ('$name','$family','$email','" . md5($password) . "','1','$mobile',NOW(),'$address','$city')";
        //die();
        $add_rs = $conn->Execute($sql);
        if (!$add_rs) {
            showErrorMsg($conn->ErrorMsg());
        }

        //************************************Group Points********************************************//
        include_once(ROOT_DIR . "component/group.points.class.php");
        $setGroupPoints = new setGroupPoints();

        $setGroupPoints->_userType = '110000';
        $setGroupPoints->_memberID = $conn->INSERT_ID();
        $setGroupPoints->_groupAction = 'Register';
        $setGroupPoints->setPoints();
        //************************************Group Points********************************************//

        //***************************************EMAIL********************************************************

        include_once(ROOT_DIR . "component/mail.class.php");
        $mail = new clsEmail();
        $mail->variable = array('name' => $name
        , 'family' => $family
        , 'username' => $email
        , 'password' => $password);

        $email_html = $mail->parse('email.register.template.php');
        $subject = MEMBER_AREA_0091;
        sendmail($email, $subject, $email_html, "");

        $login = new memberLogIn();
        $login->login($email, $password, $reffer);

        die();

    }

    function registrationTower()
    {
        global $conn;

        $tower_owner = handleData($_POST['tower_owner']);
        $contact_person = handleData($_POST['contact_person']);
        $tower_name = handleData($_POST['tower_name']);
        $telephone = handleData($_POST['telephone']);
        $email = handleData($_POST['email']);
        $city = handleData($_POST['city']);
        $tower_location = handleData($_POST['tower_location']);
        $service_type = handleData($_POST['service_type']);
        if ($service_type == 'dedicate') {
            $speed = handleData($_POST['speed']);
            $IP = handleData($_POST['IP']);
        }

        $captcha = handleData($_POST['captcha']);


        if ($tower_owner == "") {
            $this->registerFormTower(ModelREGISTER_24);
            die();
        }

        if ($contact_person == "") {
            $this->registerFormTower(ModelREGISTER_25);
            die();
        }
        if ($tower_name == "") {
            $this->registerFormTower(ModelREGISTER_26);
            die();
        }
        if ($telephone == "") {
            $this->registerFormTower(ModelREGISTER_27);
            die();
        }


        if (checkMail($email) == 0) {
            $this->registerFormTower(ModelREGISTER_14);
        }

        $sql = "select email from members where email='$email'";
        $rs = $conn->Execute($sql);
        if ($rs->RecordCount() != 0) {
            $this->registerFormTower(ModelREGISTER_15);
        }

        if ($email == "") {
            $this->registerFormTower(ModelREGISTER_19);
            die();
        }

        if ($city == "") {
            $this->registerFormTower(ModelREGISTER_20);
            die();
        }

        if ($tower_location == "") {
            $this->registerFormTower(ModelREGISTER_28);
            die();
        }
        if ($service_type == "") {
            $this->registerFormTower(ModelREGISTER_29);
            die();
        }

        if ($service_type == 'dedicate') {
            if ($speed == "") {
                $this->registerFormTower(ModelREGISTER_30);
                die();
            }
            if ($IP == "") {
                $this->registerFormTower(ModelREGISTER_31);
                die();
            }

        }

        if ($captcha == "") {
            $this->registerFormTower(ModelREGISTER_22);
            die();
        }
        if ($captcha != $_SESSION['random_code']) {
            $this->registerFormTower(ModelREGISTER_23);
            die();
        }

        $temp['service_type'][] = $service_type;
        if ($service_type == 'dedicate') {
            $temp['service_type']['speed'] = $speed;
            $temp['service_type']['IP'] = $IP;
        }
        $service_type = serialize($temp);
        $sql = "INSERT INTO tower_register (tower_owner,contact_person,select_tower_name,telephone,customer_email,city,tower_location,service_type,date) VALUES ('$tower_owner','$contact_person','$tower_name','$telephone','$email','$city','$tower_location','$service_type',NOW())";

        $rs = $conn->Execute($sql);
        if (!$rs) {
            showErrorMsg($conn->ErrorMsg());
        }

        $this->registerFormTower(ModelREGISTER_32);

        die();

    }
    //************************************************************************************
    /*	function memVerification()
        {
            global $conn;
            $id  = handleData($_REQUEST['key']);
            $sql = "delete from member_confirmation where date <(NOW()-86400) ";
            $rs  = $conn->Execute($sql);
            if (!$rs)
            {
                showErrorMsg($conn->ErrorMsg());
            }
                    
            $sql = "select username,activation_key,date from member_confirmation where activation_key='$id '  ";
            $rs  = $conn->Execute($sql);
            
            if (!$rs)
            {
                showErrorMsg($conn->ErrorMsg());
            }
            $username = $rs->fields['username'];
            if ($rs->RecordCount()!=0)
            {
                $sql = "delete from member_confirmation where username='$username'";
                $rs  = $conn->Execute($sql);
                if (!$rs)
                {
                    showErrorMsg($conn->ErrorMsg());
                }
                $sql = "update members set status='1' where username='$username' ";
                $rs  = $conn->Execute($sql);
                if (!$rs)
                {
                    showErrorMsg($conn->ErrorMsg());
                }
                
                $sql = "select member_id from members where username='$username'";
                $member_rs  = $conn->Execute($sql);
                if (!$member_rs)
                {
                    showErrorMsg($conn->ErrorMsg());
                }
                
                include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/title.inc.php");
                include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/verify.form.php");
                include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/tail.inc.php");
                die();
            }
                    
            else 
            {		
                include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/title.inc.php");
                include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/fail.confirm.php");
                include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/tail.inc.php");
                die();
            }	 
        }*/
}
