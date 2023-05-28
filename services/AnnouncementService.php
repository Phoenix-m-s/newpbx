<?php
include_once ROOT_DIR . "component/announce/adminAnnounceModel.php";

/**
 * Class AnnouncementService
 */
class AnnouncementService
{
    /**
     * @return mixed
     */
    public function getAllAnnouncement()
    {
        global $admin_info;
        $announceList = adminAnnounceModel::getAll()->
         where('comp_id', '=', $admin_info['comp_id'])->get();
        $result['0'] = array('name' => 'choose from list', 'id' => '');
        $i = 1;
        foreach ($announceList['export']['list'] as $key => $value) {
            $result[$i]['name'] = $value->fields['announce_name'];
            $result[$i]['id'] = $value->fields['announce_id'];
            $i++;
        }

        return $result;

    }


    /**
     * @param $fields
     * @return mixed
     */
    public function checkAnnouncementName($fields)
    {
        return AdminAnnounceModel::getBy_comp_id_and_announce_name_and_not_announce_id($fields['comp_id'], $fields['announce_name'], $fields['announce_id'])->getList();
    }

    /**
     * @author:Mojtaba Sakhamanesh & Shabihi
     * @Email:sakhamanesh@dabacenter.ir
     * @return mixed
     * @param $fields
     * @return mixed
     */
    public function editAnnouncement($fields)
    {
        global $company_info;
        $announceObj = AdminAnnounceModel::find($fields['announce_id']);

        /*-for test-*/
        //$fields= $this->TestInput();
        if (!is_object($announceObj)) {
            $result['msg'] = 'this announce not exsist';
        }
        $this->comp_id = $company_info['comp_id'];
        $this->resetData($announceObj);
        $announceObj->addValidate($fields);
        $result = $announceObj->setFields($fields);
        if ($result['result'] != 1) {
            $result['result'] = -1;
            $result['msg'] = 'Failed To Updated';
            return $result;
        }

        $announceObj->dst_option_id = $fields['dst_option_id_selected'][0]['dst_option_id'];
        $announceObj->dst_option_sub_id = $fields['dst_option_id_selected'][0]['dst_option_sub_id'];
        $announceObj->DSTOption = $fields['dst_option_id_selected'][0]['DSTOption'];

        $checkExternal = new TblDstOptionService();
        $result = $checkExternal->checkDstSubOptioptionId($announceObj->dst_option_id, $announceObj->dst_option_sub_id, $announceObj->DSTOption);
        if ($result['result'] == -1) {
            return $result;
        }

        if ($announceObj->dst_option_id != '' and $announceObj->dst_option_sub_id == '') {
            if (!in_array($announceObj->dst_option_id, ['7', '10', '11'])) {
                $result['msg'] = 'Please fill required items';
                $result['result'] = -1;
                return $result;
            }
        }

        $validate = $announceObj->validator();
        if ($validate['result'] == -1) {
            $result['msg'] = $validate['msg'];
            $result['result'] = -1;
            return $result;
        }

        $announceName = $this->checkAnnouncementName($fields);

        if ($announceName['export']['recordsCount'] >= 1) {
            $result['result'] = -1;
            $result['msg'] = 'this announce name is exist';
            return $result;
        }

        $result = $announceObj->save();

        if ($result['result'] == -1) {
            $result['msg'] = 'Failed To add';
            return $result;
        }
        return $result;
    }


    /**
     * @Email:sakhamanesh@dabacenter.ir
     * @param $fields
     * @return mixed
     */
    public function addAnnouncement($fields)
    {

        global $admin_info, $company_info;
        /*-for test-*/
        /* $fields= $this->TestInput();*/

        $fields['comp_id'] = $company_info['comp_id'];

        $announceObj = new AdminAnnounceModel($fields);
        $this->resetData($announceObj);

        $announceObj->repeat_input = 0;
        $announceObj->comp_id = $admin_info['comp_id'];

        $announceObj->setFields($fields);

        $announceObj->dst_option_id = $fields['dst_option_id_selected'][0]['dst_option_id'];
        $announceObj->dst_option_sub_id = $fields['dst_option_id_selected'][0]['dst_option_sub_id'];
        $announceObj->DSTOption = $fields['dst_option_id_selected'][0]['DSTOption'];

        if ($announceObj->dst_option_id != '' and $announceObj->dst_option_sub_id == '') {
            if (!in_array($announceObj->dst_option_id, ['7', '10', '11'])) {
                $result['msg'] = 'Please fill required items';
                $result['result'] = -1;
                return $result;
            }
        }

        $checkExternal = new TblDstOptionService();
        $result = $checkExternal->checkDstSubOptioptionId($announceObj->dst_option_id, $announceObj->dst_option_sub_id, $announceObj->DSTOption);
        if ($result['result'] == -1) {
            return $result;
        }

        $validate = $announceObj->validator();
        if ($validate['result'] == -1) {
            $result['msg'] = $validate['msg'];
            $result['result'] = -1;
            return $result;
        }

        $announceName = $this->checkAnnouncementName($fields);


        if ($announceName['export']['recordsCount'] >= 1) {
            $result['result'] = -1;
            $result['msg'] = 'this announce name is exist';
            return $result;
        }
        $result = $announceObj->save();


        if ($result['result'] == -1) {
            $result['msg'] = 'Failed To add';
            return $result;
        }
        $fields['announce_id'] = $announceObj->fields['announce_id'];
        $company = new companyService();
        $result = $company->activeRelaod($company_info['comp_id']);
        return $result;
    }

    /**
     * @Email:sakhamanesh@dabacenter.ir
     * @param $announceObj
     */
    public function resetData($announceObj)
    {
        $announceObj->dst_option_id = '';
        $announceObj->dst_option_sub_id = '';
        $announceObj->DSTOption = '';
        $announceObj->forward = '';
    }

    /**
     * @Email:sakhamanesh@dabacenter.ir
     * @param $id
     * @return mixed
     */
    public function deleteAnnouncementByAnnouncementId($id)
    {
        $announceObj = AdminAnnounceModel::find($id);
        if (!is_object($announceObj)) {
            $announceObj['msg'] = 'this announce not exsist';
            return $announceObj;
        } else {
            $result = $announceObj->delete();
            return $result;
        }
    }

    /**
     * @return mixed
     */
    public function TestInput()
    {
        $fields['announce_name'] = 'omid';
        $fields['upload_id'] = 6;
        $fields['repeat_input'] = 6;
        $fields['dst_option_id'] = 5;
        $fields['dst_option_sub_id'] = 5;
        $fields['forward'] = '';
        $fields['DSTOption'] = '';
        $fields['action'] = 'editAnnounce';
        return $fields;

    }

}