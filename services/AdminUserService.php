<?php
include_once ROOT_DIR . 'component/admin/admin/model/AdminUser.php';
include_once ROOT_DIR . 'component/extension/AdminExstionNewModel.php';
include_once ROOT_DIR . 'component/admin.permission.class.php';


/**
 * Class AdminUserService
 */
class AdminUserService
{
    //checkExtensionName for adminname
    /**
     * @param $fields
     * @return mixed
     */
    public function checkAdminName($fields)
    {
        global $company_info;
        return AdminUser::getBy_comp_id_and_username_and_not_admin_id($company_info['comp_id'], $fields['username'], $fields['admin_id'])->getList();
    }

    //checkExtensionName for username

    /**
     * @param $fields
     * @return mixed
     */
    public function checkExtensionName($fields)
    {
        global $company_info;
        return AdminExstionNewModel::getBy_comp_id_and_username($company_info['comp_id'], $fields['username'])->getList();
    }

    /**
     * @param $searchFields
     * @return mixed
     */
    public function getUsers($searchFields)
    {

        $adminUser = AdminUser::getAll()
            ->select('admin.*', 'tbl_company.comp_name')
            ->where("status","=",0)
            ->leftJoin('tbl_company', 'tbl_company.comp_id', '=', 'admin.comp_id');

        if (isset($searchFields['filter'])) {
            foreach ($searchFields['filter'] as $filter => $value) {
                if ($filter == 'status') {
                    $adminUser->where($filter, '=', $value);
                } else {
                    $adminUser->where($filter, 'like', '%' . $value . '%');
                }
            }
        }

        if (isset($searchFields['order'])) {
            foreach ($searchFields['order'] as $filter => $value) {
                $adminUser->orderBy($filter, $value);
            }
        } else {
            $adminUser->orderBy('admin_id', 'DESC');
        }

        $obj = clone $adminUser;
        $totalRecords = $obj->getList()['export']['recordsCount'];
        $adminUser->limit($searchFields['limit']['start'], $searchFields['limit']['length']);
        //        $c = $adminUser->getList(); dd($adminUser);

        $result['users'] = $adminUser->getList();
        $result['totalRecord'] = $totalRecords;
        return $result;
    }

    /**
     * @param $fields
     * @return mixed
     */
    public function add($fields)
    {
        global $company_info;

        if($fields['password_new']!=$fields['confirm_password']){
            $result['result'] = -1;
            $result['msg'][] = 'this password not match';
            return $result;
        }

        $user = new AdminUser();
        //$user->setFields($fields);
        if($user->type==''){
            $user->type=1;
        }
        $user->username=$fields['username'];
        $user->password=md5($fields['password_new']);
        $user->name=$fields['name'];
        $user->family=$fields['family'];
        $user->compid=$company_info['comp_id'];
        $user->comp_id=$company_info['comp_id'];
        $user->permission_pbx='100000000011100000001111000000111100000011110000001111000000111100000011110000001111000000111100000011110000001111000000110000000011100000001000000000111100000010000000001000000000';
        $user->status = 0;





        //***********************
        //check admin name
        $adminCheckName = $this->checkAdminName($fields);
        if ($adminCheckName['export']['recordsCount'] >= 1) {
            $result['result'] = -1;
            $result['msg'][] = 'this username name is exist';
            return $result;
        }
        //***********************
        //check extension name
        $extensionCheckName = $this->checkExtensionName($fields);
        if ($extensionCheckName['export']['recordsCount'] >= 1) {
            $result['result'] = -1;
            $result['msg'][] = 'this username extension is exist';
            return $result;
        }



        $validate = $user->validator();
        if ($validate['result'] == -1) {
            $result['msg'][] = $validate['msg'];
            $result['result'] = -1;
            return $result;
        }
        $result = $user->save();


        if ($result['result'] == -1) {
            $result['msg'][] ='the data has been error!!!';
            return $result;
        }

        return $result;
    }

    /**
     * @param $fields
     * @param $user
     * @return mixed
     */
    public function edit($fields, $user)
    {

        global $company_info;
        if($fields['password_new']!=$fields['confirm_password']){
            $result['result'] = -1;
            $result['msg'][] = 'this password not match';
            return $result;
        }
        $user = AdminUser::find($fields['admin_id']);


        if (!is_object($user)) {
            $result['msg'][] = 'this admin not exsist';
        }

        //$user->setFields($fields);
        if($fields['password_new']!=''){
            $user->password=md5($fields['password_new']);
        }
        $user->username=$fields['username'];
        $user->status = 0;
        $user->cell_phone = 1;
        $user->member_id = 0;
        $user->compid=$company_info['comp_id'];
        $user->comp_id=$company_info['comp_id'];
        //$user->permission_pbx='100000000011100000001111000000111100000011110000001111000000111100000011110000001111000000111100000011110000001111000000110000000011100000001000000000111100000010000000001000000000';
        $user->permission_pbx='100000000011100000001111000000111100000011110000001111000000111100000011110000001111000000111100000011110000001111000000110000000011100000001000000000111100000010000000001000000000';

        //***********************
        //check checkAdminName name
        $adminCheckName = $this->checkAdminName($fields);
        if ($adminCheckName['export']['recordsCount'] >= 1) {
            $result['result'] = -1;
            $result['msg'][] = 'this username name is exist';
            return $result;
        }


        //***********************
        //check extension name
        $extensionCheckName = $this->checkExtensionName($fields);
        if ($extensionCheckName['export']['recordsCount'] >= 1) {
            $result['result'] = -1;
            $result['msg'][] = 'this username extension is exist';
            return $result;
        }


        $validate = $user->validator();
        if ($validate['result'] == -1) {
            $result['msg'][] = $validate['msg'];
            $result['result'] = -1;
            return $result;
        }
        $result = $user->save();
        if ($result['result'] == -1) {
            $result['msg'][] = 'this username name is exist';
            return $result;
        }
        $result['result']=1;

        return $result;
    }

    /**
     * @param $fields
     * @param $user
     * @return mixed
     */
    public function editPermission($fields, $adminId)
    {
        $user = AdminUser::find($adminId);
        $result = $user->setFields($fields);

        $user->save();
        $user = AdminUser::find($adminId);
        //dd($user);
        return $result;
    }

    /**
     * @param $AdminID
     * @return mixed
     */
    public function delete($AdminID)
    {
        $user = AdminUser::find($AdminID);
        if (!is_object($user)) {
            $user['msg'][]= 'this AdminUser not exsist';
            return $user;
        } else {
            $result = $user->delete();
            return $result;
        }
    }
    public function getAllPermissions()
    {
        return getAllPermisssion();
    }


}

