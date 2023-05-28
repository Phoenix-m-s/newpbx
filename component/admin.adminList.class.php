<?php

class AdminList extends DataBase
{

    function showAdminList()
    {
        $conn = parent::getConnection();
        global $db2;

        include_once(ROOT_DIR . "component/company.operation.class.php");
        $company_operation = new company_operation;
        $result = $company_operation->getSubCompanies();

        $sql = "select * from admin
 				WHERE comp_id in (" . $result['list'] . ")
 				order by admin_id
				";

        $rs_admin_list = $db2->query($sql);
        //print_r_debug($rs_admin_list);

        if (!$rs_admin_list) {
            print_r($conn->errorInfo());
            die();
        }

        return $rs_admin_list;
    }

    public function addAdmin1()
    {
        global $db, $db2, $admin_info, $messageStack;


        $username = handleData($_REQUEST['username']);
        $name = handleData($_REQUEST['name']);
        $family = handleData($_REQUEST['family']);
        $phone = handleData($_REQUEST['cell_phone']);
        $password_new = handleData($_REQUEST['password_new']);
        $confirm_password = handleData($_REQUEST['confirm_password']);

        $sql = "select username from admin where username='$username' ";

        $rs = $db2->prepare($sql);
        $rs->setFetchMode(PDO::FETCH_ASSOC);
        $rs->execute();


        if ($rs->rowCount() >= 1) {
            $messageStack->add_session('admin.list', ModelADMIN_01, 'error');
            redirectPage(RELA_DIR . "admin.list.php");
        }


        if ($username == "") {

            $messageStack->add_session('admin.list', ModelADMIN_02, 'error');
            redirectPage(RELA_DIR . "admin.list.php");

        }
        /*if ($phone == "" || !is_numeric($phone)) {
            $messageStack->add_session('admin.list', ModelADMIN_03, 'error');
            redirectPage(RELA_DIR . "admin.list.php");

        }*/
        if (strlen($username) > 20 || strlen($username) < 4 || checkUser($username)) {
            $messageStack->add_session('admin.list', ModelADMIN_04, 'error');
            redirectPage(RELA_DIR . "admin.list.php");
        }


        if ($password_new == "") {
            $messageStack->add_session('admin.list', ModelADMIN_05, 'error');
            redirectPage(RELA_DIR . "admin.list.php");
        }

        if (strlen($password_new) > 20 || strlen($password_new) < 6) {
            $messageStack->add_session('admin.list', ModelADMIN_06, 'error');
            redirectPage(RELA_DIR . "admin.list.php");
        }

        global $company_info;
        $compID = $company_info['comp_id'];


        if ($confirm_password == $password_new) {

            $appendField = $appendValue = '';
            $server = constant("SERVER");
            if (!strlen($server) or $server != 'cloud') {
                $appendField = ' ,compid ';
                $appendValue = ' ,' . $compID . ' ';
            }


            $sql = "INSERT INTO admin (username
		                                    ,password
		                                    ,`name`
		                                    ,family
		                                    ,status
		                                    $appendField
		                                    ,comp_id)
		                                VALUES
		                                    ('$username'
		                                    ,'" . md5($password_new) . "'
		                                    ,'$name'
		                                    ,'$family'
		                                    ,1
		                                    $appendValue
		                                    ,'$compID')";



            $rs_add_adlist = $db2->prepare($sql);
            $rs_add_adlist->execute();
            if (!$rs_add_adlist) {
                $messageStack->add_session('admin.list', ModelADMIN_07, 'error');
                redirectPage(RELA_DIR . "admin.list.php");
                die();

            } else {
                $messageStack->add_session('admin.list', ModelADMIN_08, 'success');
                redirectPage(RELA_DIR . "admin.list.php");
                die();
            }

        } else {
            $messageStack->add_session('admin.list', ModelADMIN_09, 'error');
            redirectPage(RELA_DIR . "admin.list.php");
        }

    }
    public function addAdmin()
    {
        global $db, $db2, $admin_info, $messageStack;
        $adminUser = new Admin();
        $result = $announce->addAnnouncement($fields);

        if ($result['result'] != 1) {
            $result['result'] = -1;
        }
        echo json_encode($result);
        die();

    }

    function showEditAdminForm($message = "")
    {

        global $db,$db2;
        $admin_id = $_REQUEST['admin_id'];
        $sql = "select * from admin where admin_id='$admin_id'";
        $rs_list_admin = $db2->query($sql);
        if (!$rs_list_admin) {
            print_r($db2->errorInfo());
            die();
        }

        $result = $rs_list_admin->fetch(PDO::FETCH_ASSOC);

        $adminEdit['admin_id'] = $result['admin_id'];
        $adminEdit['username'] = $result['username'];
        $adminEdit['name'] = $result['name'];
        $adminEdit['family'] = $result['family'];
        $adminEdit['cellPhone'] = $result['cell_phone'];

        return $adminEdit;
    }

    function editAdmin()
    {
        $conn = parent::getConnection();
        global $admin_info, $messageStack,$db,$db2;

        $path = ROOT_DIR . "statics/adminPics/";


        $admin_id = handleData($_REQUEST['admin_id']);
        $username = handleData($_REQUEST['username']);
        $name = handleData($_REQUEST['name']);
        $family = handleData($_REQUEST['family']);
        $password_new = handleData($_REQUEST['password_new']);
        $confirm_password = handleData($_REQUEST['confirm_password']);
        $cell_phone = handleData($_REQUEST['cell_phone']);

        if ($password_new != "") {
            $sql1 = ",password='" . md5($password_new) . "'";
        } else {
            $sql1 = "";
        }

        $errors = 0;

        $type = $_REQUEST['type'];
        $image = $_FILES['imageForm']['name'];


        if ($confirm_password == $password_new) {

            $sql = "update admin set username='$username',name='$name',family='$family' " . $sql1 . " where admin_id='$admin_id'";

            $rs = $db2->prepare($sql);
            $rs->execute();

            if (!$rs) {
                $messageStack->add_session('admin.list', ModelADMIN_10, 'error');
                redirectPage(RELA_DIR . "admin.list.php?action=showeditadminform&admin_id=" . $admin_id);
            }

            $messageStack->add_session('admin.list', ModelADMIN_14, 'success');
            redirectPage(RELA_DIR . "admin.list.php");

            die();
        } else {
            die();
            $messageStack->add_session('admin.list', ModelADMIN_15, 'error');
            redirectPage(RELA_DIR . "admin.list.php");
        }
    }

    function removeAdmin()
    {
        $conn = parent::getConnection();
        global $messageStack;

        $admin_id = handleData($_REQUEST['admin_id']);
        $sql = "DELETE FROM admin WHERE admin_id=" . $admin_id . ";";
        $rs = $conn->exec($sql);
        if (!$rs) {
            $messageStack->add_session('admin.list', ModelADMIN_16, 'error');
            redirectPage(RELA_DIR . "admin.list.php");
        }
        $messageStack->add_session('admin.list', ModelADMIN_17, 'error');
        redirectPage(RELA_DIR . "admin.list.php");
    }

    function showSetTask($message = "")
    {


        global $admin_info,$db2, $messageStack;

        $admin_id = handleData($_REQUEST["admin_id"]);
        $admin_id = intval($admin_id);
        if ($admin_id == 0) {
            $messageStack->add_session('admin.list', ModelADMIN_18, 'error');
            redirectPage(RELA_DIR . "admin.list.php");
        }
        if ($admin_id == 100) {
            $messageStack->add_session('admin.list', ModelADMIN_18, 'error');
            redirectPage(RELA_DIR . "admin.list.php");
        }

        $sql = "select name, username,permission_pbx from admin where admin_id=" . $admin_id;

        $rs = $db2->query($sql);

        if (!$rs) {
            $messageStack->add_session('admin.list', ModelADMIN_20, 'error');
            redirectPage(RELA_DIR . "admin.list.php", "");
        }
        if ($rs->rowCount() != 1) {
            $messageStack->add_session('admin.list', ModelADMIN_21, 'error');
            redirectPage(RELA_DIR . "admin.list.php", "");
        }

        $result = $rs->fetch(PDO::FETCH_ASSOC);

        $adminPermission['admin_name'] = $result['name'];
        $adminPermission['admin_username'] = $result['username'];
        $adminPermission['admin_permission'] = $result['permission_pbx'];

        include_once(ROOT_DIR . "component/admin.permission.class.php");
        $adminPermission['PagePermission'] = getAllPermisssion();
        //echo "<pre>";
        // print_r($adminPermission);
        //die('asdfo');
        return $adminPermission;

    }

    function setAdminTask()
    {
        global $admin_info, $db2, $messageStack;


        $admin_id = $_REQUEST["admin_id"];

        include_once(ROOT_DIR . "component/admin.permission.class.php");
        $PagePermission = getAllPermisssion();
        $permissionCode = '';
        $countAllPermission = count($PagePermission) * Count_Permission;

        for ($i = 0; $i <= $countAllPermission; $i++) {
            $permissionCode = $permissionCode . '0';
        }

        foreach ($_POST['permission'] as $no) {

            $permissionCode[$no - 1] = '1';
        }

        $admin_id = intval($admin_id);
        if ($admin_id == 0) {
            $messageStack->add_session('admin.list', ModelADMIN_22, 'error');
            redirectPage(RELA_DIR . "admin.list.php", "");

        }
        if ($admin_id == 100) {
            $messageStack->add_session('admin.list', ModelADMIN_22, 'error');
            redirectPage(RELA_DIR . "admin.list.php", "");
        }


        $admin_id = $_REQUEST['admin_id'];
        $sql = "update admin set permission_pbx= :permissionCode WHERE admin_id='$admin_id' ";
        $q = $db2->prepare($sql);

        $q->bindParam(':permissionCode', $permissionCode, PDO::PARAM_STR);
        if ($q->execute()) {
            //echo 'saved';
        } else {
            print_r($db2->errorInfo());
            die();

        }

        $messageStack->add_session('admin.list', ModelADMIN_24, 'success');
        redirectPage(RELA_DIR . "admin.list.php", "");

        die();
    }

    public function showUserProfile()
    {
        global $admin_info, $conn;

        $sql = "SELECT * FROM `admin` WHERE `admin_id` = " . $admin_info['admin_id'] . "" . "";

        $profileUserRS = $conn->Execute($sql);

        if (!$profileUserRS) {
            echo $conn->ErrorMsg();
            die();
        }

        $profileUser['adminId'] = $admin_info['admin_id'];
        $profileUser['name'] = $profileUserRS->fields['name'];
        $profileUser['family'] = $profileUserRS->fields['family'];
        $profileUser['username'] = $profileUserRS->fields['username'];
        $profileUser['phone'] = $profileUserRS->fields['cell_phone'];
        $profileUser['date'] = $profileUserRS->fields['creation_date'];
        $profileUser['status'] = $profileUserRS->fields['status'];

        $profileUserRS->close();

        $result['profileUser'] = $profileUser;
        return $result;
    }
}
