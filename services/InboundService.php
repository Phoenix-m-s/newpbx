<?php
include_once ROOT_DIR . "component/inbound/adminInboundModel.php";
include_once ROOT_DIR . "services/CompanyService.php";

/**
 * Class InboundService
 */
class InboundService
{
    /**
     *
     *getAllInbound()
     * @author:Mojtaba Sakhamanesh & Shabihi
     * @Email:sakhamanesh@dabacenter.ir
     * @return mixed
     * @version:0.0.1
     * @return mixed
     *
     */
    public function getAllInbound()
    {
        global $admin_info;
        $inboundList = AdminInboundModel::getAll()
            ->where('comp_id', '=', $admin_info['comp_id'])->get();
        $result['0'] = array('name' => 'choose from list', 'id' => '');
        $i = 1;
        foreach ($inboundList['export']['list'] as $key => $value) {
            $result[$i]['name'] = $value->fields['inbound_name'];
            $result[$i]['id'] = $value->fields['inbound_id'];
            $i++;

        }

        return $result;

    }


    /**
     * @param $fields
     * @return mixed
     */
    public function checkInboundName($fields)
    {
        return AdminInboundModel::getBy_comp_id_and_inbound_name_and_not_inbound_id($fields['comp_id'], $fields['inbound_name'], $fields['inbound_id'])->getList();
    }

    /**
     * @param $fields
     * @return mixed
     */
    public function checkInboundValueAny($fields)
    {
        return AdminInboundModel::getBy_not_inbound_id_and_comp_id_and_cid_name_and_did_name($fields['inbound_id'], $fields['comp_id'], '', '')->getList();

    }/**
 * @param $fields
 * @return mixed
 */
    public function checkInboundValueAnyAddForm($fields)
    {
        return AdminInboundModel::getBy_comp_id_and_cid_name_and_did_name($fields['comp_id'], '', '')->getList();

    }

    /**
     * @author:Mojtaba Sakhamanesh & Shabihi
     * @Email:sakhamanesh@dabacenter.ir
     * @return mixed
     * @version:0.0.1
     * @return mixed
     * @param $fields
     * @return mixed
     */
    public function editInbound($fields)
    {
        /*-for test-*/
        //$fields= $this->TestInput();
        global $company_info;
        $fields['comp_id'] = $company_info['comp_id'];
        $inboundObj = AdminInboundModel::find($fields['inbound_id']);
        if (!is_object($inboundObj)) {
            $result['msg'] = 'this inbound not exsist';
        }
        $this->comp_id = $company_info['comp_id'];
        $this->resetData($inboundObj);
        $inboundObj->addValidate($fields);
        if ($inboundObj->cid_name != '') {
            $fields['check_cid_name'] = "0";
        } else {
            $fields['check_cid_name'] = "1";
        }
        if ($inboundObj->did_name != '') {
            $fields['check_did_name'] = "0";
        } else {
            $fields['check_did_name'] = "1";
        }

        if ($fields['check_fax_ext'] == 0) {
            $fields['fax_email'] = '';
        }

        $result = $inboundObj->setFields($fields);
        if ($result['result'] != 1) {
            $result['result'] = -1;
            $result['msg'] = 'Failed To Updated';

            return $result;
        }

        $inboundObj->dst_option_id = $fields['dst_option_id_selected'][0]['dst_option_id'];
        $inboundObj->dst_option_sub_id = $fields['dst_option_id_selected'][0]['dst_option_sub_id'];
        $inboundObj->DSTOption = $fields['dst_option_id_selected'][0]['DSTOption'];

        if ($inboundObj->dst_option_id != '' and $inboundObj->dst_option_sub_id == '') {
            if (!in_array($inboundObj->dst_option_id, ['7', '10', '11'])) {
                $result['msg'] = 'Please fill required items';
                $result['result'] = -1;
                return $result;
            }
        }

        $checkExternal = new TblDstOptionService();
        $result = $checkExternal->checkDstSubOptioptionId($inboundObj->dst_option_id, $inboundObj->dst_option_sub_id, $inboundObj->DSTOption);
        if ($result['result'] == -1) {
            return $result;
        }

//        $result = $inboundObj->setFields($fields);


        $inboundName = $this->checkInboundName($fields);

        if ($inboundName['export']['recordsCount'] >= 1) {
            $result['result'] = -1;
            $result['msg'] = 'this inbound name is exist';

            return $result;
        }

        if ($fields['cid_name'] == '' and $fields['did_name'] == '') {
            $inboundValueCheck = $this->checkInboundValueAny($fields);
            if ($inboundValueCheck['export']['recordsCount'] >= 1) {
                $result['result'] = -1;
                $result['msg'] = 'An Inbound Route With Any/Any Did/Cid Is Exist';
                return $result;
            }
        }
        $validate = $inboundObj->validator();
        if ($validate['result'] == -1) {
            $result['msg'] = $validate['msg'];
            $result['result'] = -1;

            return $result;
        }

        $result = $inboundObj->save();
        if ($result['result'] == -1) {
            $result['msg'] = 'Failed To add';

            return $result;
        }
        $company = new companyService();
        $result = $company->activeRelaod($company_info['comp_id']);

        return $result;
    }


    /**
     * @author:Mojtaba Sakhamanesh & Shabihi
     * @Email:sakhamanesh@dabacenter.ir
     * @return mixed
     * @version:0.0.1
     * @param $fields
     * @return mixed
     */
    public function addInbound($fields)
    {

        /*-for test-*/
        //$fields= $this->TestInput();
        global $admin_info, $company_info;

        $fields['comp_id'] = $company_info['comp_id'];

        $inboundObj = new AdminInboundModel();
        $this->resetData($inboundObj);
        $inboundObj->repeat_input = 0;
        $inboundObj->comp_id = $admin_info['comp_id'];

        $inboundObj->addValidate($fields);
        $fields['check_cid_name'] = "0";
        $fields['check_did_name'] = "0";
        $fields['check_fax_ext'] = "0";
        if ($fields['check_did_name'] == "1") {
            $fields['did_name'] = '';
        }
        if ($fields['check_cid_name'] == "1") {
            $fields['cid_name'] = '';
        }
        if ($fields['check_fax_ext'] == "0") {
            $fields['fax_email'] = '';
        }
        $inboundObj->setFields($fields);

        $inboundObj->dst_option_id = $fields['dst_option_id_selected'][0]['dst_option_id'];
        $inboundObj->dst_option_sub_id = $fields['dst_option_id_selected'][0]['dst_option_sub_id'];
        $inboundObj->DSTOption = $fields['dst_option_id_selected'][0]['DSTOption'];

        if ($inboundObj->dst_option_id != '' and $inboundObj->dst_option_sub_id == '') {
            if (!in_array($inboundObj->dst_option_id, ['7', '10', '11'])) {
                $result['msg'] = 'Please fill required items';
                $result['result'] = -1;
                return $result;
            }
        }

        $checkExternal = new TblDstOptionService();
        $result = $checkExternal->checkDstSubOptioptionId($inboundObj->dst_option_id, $inboundObj->dst_option_sub_id, $inboundObj->DSTOption);
        if ($result['result'] == -1) {
            return $result;
        }

        $validate = $inboundObj->validator();
        if ($validate['result'] == -1) {
            $result['msg'] = $validate['msg'];
            $result['result'] = -1;

            return $result;
        }

        $inboundName = $this->checkInboundName($fields);

        if ($inboundName['export']['recordsCount'] >= 1) {
            $result['result'] = -1;
            $result['msg'] = 'this inbound name is exist';

            return $result;
        }
//        print_r_debug($fields)
        if ($fields['cid_name'] == '' and $fields['did_name'] == '') {
            $inboundValueCheck = $this->checkInboundValueAnyAddForm($fields);

            if ($inboundValueCheck['export']['recordsCount'] >= 1) {
                $result['result'] = -1;
                $result['msg'] = 'An Inbound Route With Any/Any Did/Cid Is Exist';
                return $result;
            }
        }

        $result = $inboundObj->save();
        if ($result['result'] == -1) {
            $result['msg'] = 'Failed To add';

            return $result;
        }

        $fields['inbound_id'] = $inboundObj->fields['inbound_id'];
        $company = new companyService();
        $result = $company->activeRelaod($company_info['comp_id']);

        return $result;
    }

    /**
     * @author:Mojtaba Sakhamanesh & Shabihi
     * @Email:sakhamanesh@dabacenter.ir
     * @return mixed
     * @version:0.0.1
     * @param $inboundObj
     */
    public function resetData($inboundObj)
    {
        $inboundObj->did_name = '';
        $inboundObj->cid_name = '';
        $inboundObj->repeat_input = 0;
        $inboundObj->dst_option_id = '';
        $inboundObj->dst_option_sub_id = '';
        $inboundObj->DSTOption = '';
        $inboundObj->forward = '';
        $inboundObj->fax_email = '';
    }

    /**
     * @author:Mojtaba Sakhamanesh & Shabihi
     * @Email:sakhamanesh@dabacenter.ir
     * @return mixed
     * @version:0.0.1
     * @param $id
     * @return mixed
     */
    public function deleteInboundByInboundId($id)
    {
        $inboundObj = AdminInboundModel::find($id);
        if (!is_object($inboundObj)) {
            $inboundObj['msg'] = 'this inbound not exsist';

            return $inboundObj;
        } else {
            $result = $inboundObj->delete();

            return $result;
        }
    }
}