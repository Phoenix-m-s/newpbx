<?php
include_once ROOT_DIR . "component/company/AdminCompanyModel.php";
class CompanyService
{
    public function activeRelaod($id)
    {

        $companyObj = new AdminCompanyModel();
        $company = $companyObj->find($id);
        $company->reload_alert = 1;
        $result = $company->save();
        if ($result['result'] == 1) {
            $result['msg'] = 'Successfully Updated';
        }
        return $result;
    }

    public function getAllCompanies()
    {

        $routingList = AdminCompanyModel::getAll()->get();
        $result['0'] = array('name' => 'choose from list', 'id' => '');
        $i = 1;
        foreach ($routingList['export']['list'] as $key => $value) {
            $result[$i]['name'] = $value->fields['comp_name'];
            $result[$i]['id'] = $value->fields['comp_id'];
            $i++;
        }
        return $result;

    }
    public function getCompanylistApi()
    {
        $company = new AdminCompanyModel();
        $companyList = $company->getAll()
            ->paginate(10)
            ->getList();
        $data['export']=$companyList;
        return $data;
    }

    public function getCompanyUsers($searchFields)
    {
        $company = AdminCompanyModel::getAll();

        if (isset($searchFields['filter'])) {
            foreach ($searchFields['filter'] as $filter => $value) {
                if ($filter == 'status') {
                    $company->where($filter, '=', $value);
                } else {
                    $company->where($filter, 'like', '%' . $value . '%');
                }
            }
        }

        if (isset($searchFields['order'])) {
            foreach ($searchFields['order'] as $filter => $value) {
                $company->orderBy($filter, $value);
            }
        } else {
            $company->orderBy('comp_id', 'DESC');
        }

        $obj = clone $company;
        $totalRecords = $obj->getList()['export']['recordsCount'];
        $company->limit($searchFields['limit']['start'], $searchFields['limit']['length']);
        //$c = $adminUser->getList(); dd($company);

        $result['company'] = $company->getList();
        $result['totalRecord'] = $totalRecords;
        return $result;
    }
    public function checkCompanyName($fields)
    {
        return AdminCompanyModel::getBy_comp_name_and_comp_id($fields['comp_name'],$fields['comp_id'])->getList();
    }
    public function checkCompanyNameApi($fields)
    {
        return AdminCompanyModel::getBy_comp_name($fields['comp_name'])->getList();
    }
    public function checkAdminName($fields)
    {
        return AdminUser::getBy_admin_id_and_username_and_not_admin_id($fields['comp_id'], $fields['user_name'], $fields['comp_id'])->getList();
    }
    public function checkAdminNameApi($fields)
    {
        return AdminUser::getBy_username($fields)->getList();
    }
    public function checkExtensionName($fields)
    {
        global $company_info;
        return AdminExstionNewModel::getBy_comp_id_and_username($company_info['comp_id'], $fields['username'])->getList();
    }
    public function checkExtensionNameApi($fields)
    {
        return AdminExstionNewModel::getBy_username($fields)->getList();
    }
    /**
     * Add company
     * @param $fields
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function addCompany($fields)
    {
        //print_r_debug($fields);
        global  $company_info;

        looeic::beginTransaction();

        $fields['comp_id'] = $company_info['comp_id'];

        $companyObj = new AdminCompanyModel();

        //$companyObj->comp_id = $company_info['comp_id'];

        $companyObj->comp_name = $fields['comp_name'];

        $companyObj->manager_name = $fields['manager_name'];

        $companyObj->address = $fields['address'];

        $companyObj->phone_number = $fields['phone_number'];

        $companyObj->email = $fields['email'];

        $companyObj->support_name = "0";

        $companyObj->support_phone = "0";

        $companyObj->support_email = "0";

        $companyObj->comp_status = 1;




        $validate = $companyObj->validator();

        if ($validate['result'] == -1) {
            looeic::rollback();
            $result['msg'] = $validate['msg'];
            $result['result'] = -1;
            return $result;
        }

        $checkCompanyName= $this->checkCompanyName($fields);

        if ($checkCompanyName['export']['recordsCount'] >= 1) {
            looeic::rollback();
            $result['result'] = -1;
            $result['msg'] = 'this comp_name is exist';
            return $result;
        }

        $result = $companyObj->save();





        if ($result['result'] == -1) {
            looeic::rollback();
            $result['msg'] = 'Failed To Updated';
            return $result;
        }
        if($fields['password_new']!=$fields['confirm_password']){
            looeic::rollback();
            $result['result'] = -1;
            $result['msg']= 'this password not match';
            return $result;
        }

        //***********************
        //save admin name
        $user = new AdminUser();
        //$user->setFields($fields);
        $user->password=md5($fields['password_new']);
        $user->username=$fields['manager_name'];
        $user->name=$fields['name'];
        $user->family=$fields['family'];
        $user->compid=$companyObj->comp_id;
        $user->comp_id=$companyObj->comp_id;
        $user->type=$fields['type'];
        $user->status = 1;
        $user->permission_pbx='100000000000000000011100000000000000111100000000000000111100000000000000111100000000000000111100000000000000111100000000000000111100000000000000111100000000000000111100000000000000111100000000000000111100000000000000111100000000000000111100000000000000100000000000000000111100000000000000100000000000000000100000000000000000';
        //$user->creation_date=date("m.d.y");


        //***********************
        //check admin name
        $adminCheckName = $this->checkAdminName($fields);
        if ($adminCheckName['export']['recordsCount'] >= 1) {
            looeic::rollback();
            $result['result'] = -1;
            $result['msg'] ='this username name is exist';
            return $result;
        }
        //***********************
        //check extension name
        $extensionCheckName = $this->checkExtensionName($fields);
        if ($extensionCheckName['export']['recordsCount'] >= 1) {
            looeic::rollback();
            $result['result'] = -1;
            $result['msg']= 'this username extension is exist';
            return $result;
        }
        //***********************
        //check validator
        $validate = $user->validator();
        if ($validate['result'] == -1) {
            looeic::rollback();
            $result['msg'] = $validate['msg'];
            $result['result'] = -1;
            return $result;
        }

        $result = $user->save();

        if ($result['result'] == -1) {
            looeic::rollback();
            $result['msg'] = 'Failed To Updated';
            return $result;
        }

        looeic::commit();
        $result['msg'] = 'Successfully Update';
        return $result;
    }
    public function addCompanyApi($fields) {
        looeic::beginTransaction();

        $requiredFields = ['comp_name', 'manager_name', 'address', 'phone_number', 'email', 'name', 'password', 'family', 'type'];
        $errorMessages = [];

        foreach ($requiredFields as $field) {
            if (empty($fields[$field])) {
                $errorMessages[] = $field;
            }
        }

        if (!empty($errorMessages)) {
            looeic::rollback();
            $result = [
                'result' => -1,
                'msg' => 'فیلدهای زیر ضروری هستند و نمی‌توانند خالی باشند',
                'data' => [
                    'missingFields' => $errorMessages
                ]
            ];
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            return $result;
        }

        // ادامه‌ی سایر کدها

        $companyObj = new AdminCompanyModel();
        $companyObj->comp_name = $fields['comp_name'];
        $companyObj->manager_name = $fields['manager_name'];
        $companyObj->address = $fields['address'];
        $companyObj->phone_number = $fields['phone_number'];
        $companyObj->email = $fields['email'];
        $companyObj->support_name = "0";
        $companyObj->support_phone = "0";
        $companyObj->support_email = "0";
        $companyObj->container_comp_id = "1";
        $companyObj->comp_status = 1;

        $validate = $companyObj->validator();

        if ($validate['result'] == -1) {
            looeic::rollback();
            $result = [
                'result' => -1,
                'msg' => $validate['msg'],
                'data' => null
            ];
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            return $result;
        }

        $checkCompanyName = $this->checkCompanyNameApi($fields);

        if ($checkCompanyName['recordsCount'] >= 1) {
            looeic::rollback();
            $result = [
                'result' => -1,
                'msg' => 'This company name already exists',
                'data' => null
            ];
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            return $result;
        }

        $result = $companyObj->save();

        if ($result['result'] == -1) {
            looeic::rollback();
            $result = [
                'result' => -1,
                'msg' => 'Failed to update company',
                'data' => null
            ];
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            return $result;
        }

        // ادامه‌ی ذخیره‌ی کاربر (User)
        $user = new AdminUser();
        $username = substr($fields['email'], 0, strpos($fields['email'], '@'));

        $user->password = md5($fields['password']);
        $user->username = $username;
        $user->name = $fields['name'];
        $user->family = $fields['family'];
        $user->compid = $companyObj->comp_id;
        $user->comp_id = $companyObj->comp_id;
        $user->type = $fields['type'];
        $user->status = 1;

        $adminCheckName = $this->checkAdminNameApi($username);

        if ($adminCheckName['recordsCount'] >= 1) {
            looeic::rollback();
            $result = [
                'result' => -1,
                'msg' => 'This username already exists',
                'data' => null
            ];
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            return $result;
        }

        $extensionCheckName = $this->checkExtensionNameApi($username);

        if ($extensionCheckName['recordsCount'] >= 1) {
            looeic::rollback();
            $result = [
                'result' => -1,
                'msg' => 'This username extension already exists',
                'data' => null
            ];
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            return $result;
        }

        $result = $user->save();

        if ($result['result'] == -1) {
            looeic::rollback();
            $result = [
                'result' => -1,
                'msg' => 'Failed to update user',
                'data' => null
            ];
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            return $result;
        }

        looeic::commit();
        $result = [
            'result' => 1,
            'msg' => 'Successfully updated',
            'data' => null
        ];
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
        return $result;
    }

    /**
     * @param $AdminID
     * @param $fields
     * @param $message
     */
    public function editCompany($fields, $message)
    {
        //print_r_debug($fields);

        global $company_info;
        looeic::beginTransaction();

        $companyObj = AdminCompanyModel::find($fields['comp_id']);

        $companyObj->comp_id = $fields['comp_id'];
        $companyObj->comp_name = $fields['comp_name'];

        $companyObj->manager_name = $fields['manager_name'];

        $companyObj->address = $fields['address'];

        $companyObj->phone_number = $fields['phone_number'];

        $companyObj->email = $fields['email'];

        $companyObj->support_name = "0";

        $companyObj->support_phone = "0";

        $companyObj->support_email = "0";

        $companyObj->comp_status = 1;


        $validate = $companyObj->validator();

        if ($validate['result'] == -1) {
            looeic::rollback();
            $result['msg'] = $validate['msg'];
            $result['result'] = -1;
            return $result;
        }

        $checkCompanyName= $this->checkCompanyName($fields);

        if ($checkCompanyName['export']['recordsCount'] >= 2) {
            looeic::rollback();
            $result['result'] = -1;
            $result['msg'] = 'this comp_name is exist';
            return $result;
        }
        //print_r_debug($fields);


        $result = $companyObj->save();

        if ($result['result'] == -1) {
            looeic::rollback();
            $result['msg'] = 'Failed To Updated';
            return $result;
        }

        if($fields['password_new']!=$fields['confirm_password']){
            looeic::rollback();
            $result['result'] = -1;
            $result['msg']= 'this password not match';
            return $result;
        }

        $user = AdminUser::getAll()
            ->where('comp_id','=',$fields['comp_id'])->getList()['export']['list'][0];
        //echo $user['admin_id'].'<br/>';
        $user = AdminUser::find($user['admin_id']);

        if(!is_object($user)){
            looeic::rollback();
            $result['msg']= 'this admin not exsist';
        }
        //***********************
        //save admin name
        if(!empty($fields['password_new']))
        {
            $user->password=md5($fields['password_new']);
        }

        $user->compid=$fields['comp_id'];
        $user->username=$fields['manager_name'];
        $user->comp_id=$fields['comp_id'];
        $user->name=$fields['name'];
        $user->family=$fields['family'];
        $user->type=$fields['type'];
        $user->status = 1;
        $user->cell_phone = 1;
        $user->member_id = 0;
        //***********************
        //check admin name
        $adminCheckName = $this->checkAdminName($fields);
        if ($adminCheckName['export']['recordsCount'] >= 1) {
            looeic::rollback();
            $result['result'] = -1;
            $result['msg'] ='this username name is exist';
            return $result;
        }
        //***********************
        //check extension name
        $extensionCheckName = $this->checkExtensionName($fields);
        if ($extensionCheckName['export']['recordsCount'] >= 1) {
            looeic::rollback();
            $result['result'] = -1;
            $result['msg']= 'this username extension is exist';
            return $result;
        }
        //***********************
        //check validator
        $validate = $user->validator();
        if ($validate['result'] == -1) {
            looeic::rollback();
            $result['msg'] = $validate['msg'];
            $result['result'] = -1;
            return $result;
        }
        //print_r_debug($user);
        $result = $user->save();

        if ($result['result'] == -1) {
            looeic::rollback();
            $result['msg'] = 'Failed To Updated';
            return $result;
        }
        looeic::commit();
        $result['msg'] = 'Successfully Update';
        return $result;
    }

    public function deleteCompany($compid)
    {

        looeic::beginTransaction();

        $company = AdminCompanyModel::find($compid);
        //print_r_debug($company);
        if (!is_object($company)) {
            looeic::rollback();
            $user['msg']= 'this $compid not exist';
            return $company;
        }
        $result = $company->delete();
        if($result['result'] !=-1) {
            $user = AdminUser::getAll()->where('comp_id','=',$compid)->first()->getList()['export']['list'][0];

            $user = AdminUser::find($user['admin_id']);

            if (!is_object($user)) {
                looeic::rollback();
                $user['msg'] = 'this compid not exist';
                return $user;
            } else {
                $result = $user->delete();
                looeic::commit();
                $result['msg'] = 'Successfully Update';
                return $result;
            }
        }

    }


}
