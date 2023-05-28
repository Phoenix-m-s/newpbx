<?php


include_once ROOT_DIR . "component/trunk/model/trunk.php";

/**
 * Class TrunkService
 */
class TrunkService
{
    /**
     *getAllTrunk
     * @return mixed
     * @author:Mojtaba Sakhamanesh & Shabihi
     * @Email:sakhamanesh@dabacenter.ir
     * @version:0.0.1
     */
    public function getAllTrunk()
    {

        global $member_info;

        $trunkDirty = trunk::getAll();
        if (is_array($member_info)) {
            $trunkDirty->where('creator_id', '=', $member_info['extension_id']);
        }
        $result = $trunkDirty->getlist();
        $result = $result['export']['list'];
        for ($i = 0; $i < sizeof($result); $i++) {
            $result[$i]['name'] = $result[$i]['sip_name'];
            $result[$i]['id'] = $result[$i]['sip_id'];
        }
        array_unshift($result, array('name' => 'choose from list', 'id' => ''));
        return $result;

    }

    public function getByTrunkid($id)
    {
        return trunk::getBy_sip_id($id)->get();

    }

    public function addTrunkForm()
    {
        global $company_info;
        $list['comp_id'] = $company_info['comp_id'];
        $list['sip_type'] = $this->setFieldsTrunkType();
        $list['codecList'] = $this->setFieldsCodecList();
        $list['dtmfmode'] = $this->setFieldsDtmfmode();
        $checked = ',alaw,ulaw,';
        $checked = explode(',', $checked);
        $checked = array_filter($checked, 'strlen');
        $i = 0;
        foreach ($checked as $key => $value) {
            $list['codecList_selected'][$i]['id'] = $key;
            $list['codecList_selected'][$i]['name'] = $value;
            $i++;
        }
        $list['action'] = 'addTrunk';
        // print_r_debug($list);
        $result = json_encode($list, JSON_PRETTY_PRINT);
        return $result;
    }

    public function service_AddTrunk($fields)
    {
        global $company_info;

        $fields['comp_id'] = $company_info['comp_id'];

        $fields['sip_id'] = $fields['id'];
        if ($fields['codecList_selected'] != '') {
            $fields['codec'] = ',' . implode(',', $fields['codecList_selected']) . ',';
        }

        if ($fields['checkHost'] == 1) {
            $fields['host'] = 'Dynamic';
        }
        if ($fields['Relaxdtmf'] == 1) {
            $fields['Relaxdtmf'] = 'Yes';
        }
        $modelCheck = trunk::getBy_comp_id_and_sip_name($fields['comp_id'], $fields['sip_name'])->getList();

        if ($modelCheck['export']['recordsCount'] >= 1) {
            $result['result'] = -1;
            $result['msg'] = 'this trunk-sip name is exist';
            return $result;
        }
        //include sip
        include_once ROOT_DIR . "component/sip/adminSIPModel.php";
        $modelCheck = adminSIPModel::getBy_comp_id_and_sip_name($fields['comp_id'], $fields['sip_name'])->getList();
        if ($modelCheck['export']['recordsCount'] >= 1) {
            $result['result'] = -1;
            $result['msg'] = 'this sip name is exist';
            return $result;
        }

        $model = new trunk;

        $model->setFields($fields);
        $validate = $model->validator();
        if ($validate['result'] == -1) {
            $result['result'] = -1;
            $result['msg'] = $validate['msg'];
            return $result;
        }

        $result = $model->save();

        if ($result['result'] != 1) {
            $result['result'] = -1;
            $result['msg'] = 'Failed To Updated';
            return $result;
        }
        return $result;
    }

    public function editTrunkForm($trunkID)
    {
        $trunkModel = trunk::find($trunkID);
        $list = $trunkModel->fields;
        $list['id'] = $list['sip_id'];
        unset($list['sip_id']);
        $list['trunk_type_selected'] = $list['sip_type'];
        $list['dtmfmode_selected'] = $list['dtmfmode'];

        $list['sip_type'] = $this->setFieldsTrunkType();
        $list['codecList'] = $this->setFieldsCodecList();
        $list['dtmfmode'] = $this->setFieldsDtmfmode();
        if ($list['host'] == 'Dynamic') {
            $list['checkHost'] = 1;
        } else {
            $list['checkHost'] = 0;
        }
        if ($list['Relaxdtmf'] == 'Yes') {
            $list['Relaxdtmf'] = 1;
        } else {
            $list['Relaxdtmf'] = 0;
        }
        $list['action'] = 'editTrunk';

        $checked = $list['codec'];
        $checked = explode(',', $checked);
        $checked = array_filter($checked, 'strlen');
        if ($list['codec'] == '') {
            $list['codecList_selected'] = [];
        }
        $i = 0;
        foreach ($checked as $key => $value) {
            $list['codecList_selected'][$i]['id'] = $key;
            $list['codecList_selected'][$i]['name'] = $value;
            $i++;
        }

        $result = json_encode($list, JSON_PRETTY_PRINT);
        return $result;
    }

    public function service_editTrunk($fields)
    {
        global $conn, $lang, $company_info;

        $fields['comp_id'] = $company_info['comp_id'];
        $fields['sip_id'] = $fields['id'];
        if ($fields['codecList_selected'] != '') {
            $fields['codec'] = ',' . implode(',', $fields['codecList_selected']) . ',';
        } else {
            $fields['codec'] = '';
        }

        $modelCheck = trunk::getBy_comp_id_and_sip_name_and_not_sip_id($fields['comp_id'], $fields['sip_name'], $fields['sip_id'])->getList();
        if ($modelCheck['export']['recordsCount'] >= 1) {
            $result['result'] = -1;
            $result['msg'] = 'this sip name is exist';
            return $result;
        }
        //include sip
        include_once ROOT_DIR . "component/sip/adminSIPModel.php";
        $modelCheck = adminSIPModel::getBy_comp_id_and_sip_name($fields['comp_id'], $fields['sip_name'])->getList();
        if ($modelCheck['export']['recordsCount'] >= 1) {
            $result['result'] = -1;
            $result['msg'] = 'this sip name is exist';
            return $result;
        }
        $model = trunk::find($fields['sip_id']);
        $model->setFields($fields);
        $validate = $model->validator();
        if ($validate['result'] == -1) {
            $result['result'] = -1;
            $result['msg'] = $validate['msg'];
            return $result;
        }
        $result = $model->save();

        if ($result['result'] != 1) {
            $result['result'] = -1;
            $result['msg'] = 'Failed To Updated';
            return $result;
        }
        return $result;
    }

    public function checkpermission(trunk $trunkModel)
    {
        global $member_info;

        $res['result'] = 1;

        if (is_array($member_info) and $trunkModel->creator_id != $member_info['extension_id']) {
            $res['result'] = -1;
            $res['no'] = 101;

        }
        return $res;

    }

    public function deleteTrunkByTrunkId($id)
    {
        global $admin_info, $member_info;

        $trunkObj = trunk::find($id);


        if (!is_object($trunkObj)) {
            $trunkObj['msg'] = 'this conference not exist';
            return $trunkObj;
        }
        $checkPermission = $this->checkpermission($trunkObj);

        if ($checkPermission['result'] == -1) {
            return $checkPermission;
        }

        $result = $trunkObj->delete();

        return $result;

    }

    public function setFieldsTrunkType()
    {
        $list = array(array('id' => 'Peer', 'name' => 'Peer'), array('id' => 'Friend', 'name' => 'Friend'));
        return $list;
    }

    public function setFieldsCodecList()
    {
        $list[0] = array('id' => 'g729', 'name' => 'g729');
        $list[1] = array('id' => 'alaw', 'name' => 'alaw');
        $list[2] = array('id' => 'ulaw', 'name' => 'ulaw');
        return $list;
    }
    public function setFieldsDtmfmode()
    {
        $list = array
        (array('id' => 'rfc2833', 'name' => 'rfc2833'),
            array('id' => 'auto', 'name' => 'auto'),
            array('id' => 'info', 'name' => 'info'),
            array('id' => 'shortinfo', 'name' => 'shortinfo'),
            array('id' => 'inband', 'name' => 'inband'));
        return $list;
    }
}
