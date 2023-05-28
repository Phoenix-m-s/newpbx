<?php
include_once ROOT_DIR . 'component/admin/AdminUser.php';
include_once ROOT_DIR . "services/AdminUserService.php";
include_once ROOT_DIR . "services/datatable.converter.php";
include_once ROOT_DIR . "component/company/AdminCompanyModel.php";
include_once ROOT_DIR . 'services/CompanyService.php';


/**
 * Class AdminAdminController
 */
class AdminUserController
{
    /**
     * @var
     */
    private $error;
    /**
     * @var
     */
    private $fileName;
    /**
     * @var
     */
    private $exportType;


    /**
     * @param $list
     * @param string $message
     */
    private function template($list, $message = '')
    {

        switch ($this->exportType) {
            case 'html':
                include ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_start.tpl";
                include ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_header.tpl";
                include ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_rightMenu.tpl.php";
                include ROOT_DIR . "templates/" . CURRENT_SKIN . "/$this->fileName";
                include ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_footer.tpl";
                include ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_end.tpl";
                break;
            case 'json':
                return;
                break;
            case 'array' :
                echo $list;
                break;
            case 'serialize' :
                echo serialize($list);
                break;
            default:
                break;
        }
    }

    /**
     * @param string $message
     */
    public function showAllAdmin($message = '')
    {
        global $company_info;
        //uncomment by zjb
        $AdminDirty = AdminUser::getAll()
            ->where("comp_id","=",$company_info['comp_id'])->getList();
        $AdminClean = $AdminDirty['export']['list'];

        //
        $this->exportType = 'html';

        $this->fileName = 'admin.adminlist.show.php';
        //$AdminClean  by zjb
        $this->template($AdminClean, $message);

//        $this->template('', $message);
    }

    public function filterUser($fields)
    {
        global $company_info;
        $i = 0;
        $columns = [
            ['db' => 'username', 'dt' => $i++],
            ['db' => 'name', 'dt' => $i++],
            ['db' => 'family', 'dt' => $i++],
            ['db' => 'comp_name', 'dt' => $i++],
            ['db' => 'type', 'dt' => $i++],
            ['db' => 'status', 'dt' => $i++]

        ];

        $convert = new convertDatatableIO();
        $convert->input = $fields;
        $convert->columns = $columns;

        $searchFields = $convert->convertInput();
        $adminNewService = new AdminUserService();
        $adminUser = $adminNewService->getUsers($searchFields);


        $list['list'] =  $adminUser['users']['export']['list'];
        $list['paging'] = $adminUser['totalRecord'];

        $other['5'] = array('formatter' => function ($list) {
            return '<div class="table-action">
                    <a style="color:black;" href="' . RELA_DIR . 'admin.list.php?action=permissionAdmin&id=' . $list['admin_id'] . '">
                        <i class="fa fa-lock text-warning"></i>
                    </a>
                    <a style="color:black;" href="' . RELA_DIR . 'admin.list.php?action=editAdmin&id=' . $list['admin_id'] . '">
                        <i class="fa fa-pencil text-success"></i>
                    </a>
                    <a style="color:black;" class="remove-item" data-url="' . RELA_DIR . 'admin.list.php?action=deleteAdmin&id=' . $list['admin_id'] . '">
                        <i class="fa fa-trash text-danger"></i>
                    </a>
                  </div>';
        });



        $other['4'] = array('formatter' => function ($list) {
            if ($list['type'] == 1) {
                $st = 'Admin';
            } else if($list['type']==2) {
                $st = 'Member';
            }
            else{
                $st='unknown';
            }
            return $st;
        });

        $internalVariable['showstatus'] = $fields['status'];

        $export = $convert->convertOutput($list, $columns, $other, $internalVariable);
        if($export[4]==1){
            $export[4]='Admin';
        }
        else{
            $export[4]='Member';
        }

        echo json_encode($export);
        die();
    }


    /**
     * @param array $fields
     * @param $message
     */
    public function addAdminForm($fields = [], $message)
    {
        $this->exportType = 'html';
        $this->fileName = 'admin.adminlist.form.php';
        $this->template($fields, $message);
        die();
    }

    /**
     * @param $fields
     */
    public function addAdmin($fields)
    {
        global $company_info;
        $Admin = new AdminUserService();
        $result = $Admin->add($fields);
        if ($result['result'] != 1) {
            $this->addAdminForm($fields,$result['msg']);
        }
        $company = new companyService();
        $company->activeRelaod($company_info['comp_id']);
        redirectPage(RELA_DIR . 'admin.list.php', 'Successfully Updated');
        die();

    }

    /**
     * @param $AdminID
     * @param $fields
     * @param $message
     */
    public function editAdminForm($AdminID, $fields, $message)
    {

        $adminDirty = AdminUser::find($AdminID);
        $list = $adminDirty->fields;

        $this->exportType = 'html';

        $this->fileName = 'admin.adminlist.form.php';
        $this->template($list, $message);
        die();
    }

    /**
     * @Email M.sakhamanesh@googlemail.com
     * @param $fields
     */
    public function editAdmin($fields)
    {
        global $company_info;
        $adminDirty = new AdminUserService();
        $result = $adminDirty->edit($fields);

        if ($result['result'] != 1) {
            $this->editAdminForm($fields['admin_id'],'',$result['msg']);
        }
        $company = new companyService();
        $company->activeRelaod($company_info['comp_id']);
        redirectPage(RELA_DIR . 'admin.list.php', 'Successfully Updated');
        die();

    }


    /**
     * @Email M.sakhamanesh@googlemail.com
     * @param $AdminID
     */
    public function deleteAdmin($AdminID)
    {
        global $company_info;
        $adminDirty = new AdminUserService();
        $result = $adminDirty->delete($AdminID);

        if ($result['result'] != 1) {
            $result['msg'][] = 'Failed To Delete';
            $this->showAllAdmin($result['msg']);
            die();
        } else {

            $company = new CompanyService();
            $company->activeRelaod($company_info['comp_id']);
            redirectPage(RELA_DIR . 'admin.list.php', 'Successfully Deleted');
            die();
        }

    }

    public function permissionAdmin($adminID)
    {
        $adminDirty = new AdminUserService();
        $list = [];
        $list['admin_permission'] = AdminUser::find($adminID)->permission_pbx;
        //dd($list);

        $list['permissions'] = $adminDirty->getAllPermissions();
        $list['submit_action'] = 'addPermissionAdmin';
        $list['form_action'] = 'edit';
        $list['url'] = 'admin.list.php';
        $list['id'] = $_GET['id'];
        $this->exportType = 'html';
        $this->fileName = 'admin.adminlist.settask.php';
        $this->template($list);

    }


    public function addPermissionAdmin($fields)
    {

        $adminDirty = new AdminUserService();
        $PagePermission=$adminDirty->getAllPermissions();
        $permissionCode='';
        $countAllPermission=count($PagePermission)*COUNT_PERMISSION-1;
        //print_r_debug(COUNT_PERMISSION);

        for($i=0;$i<=$countAllPermission;$i++)
        {
            $permissionCode=$permissionCode.'0';
        }

        foreach($fields['permission'] as  $no =>$status)
        {
            if($status==1)
            {
                $permissionCode[$no-1]='1';
            }
        }

        $array = [];
        $array['permission_pbx'] = $permissionCode;

        $result =$adminDirty->editPermission($array , $fields['admin_id']);
        $result['msg']='success';
        echo json_encode($result);

        die();


    }

}
