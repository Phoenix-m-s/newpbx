<?php
include_once ROOT_DIR . "component/sip/adminSIPModel.php";

/**
 * Class SipService
 */
class SipService
{
    /**
     *getAllSip
     * @author:Mojtaba Sakhamanesh & Shabihi
     * @Email:sakhamanesh@dabacenter.ir
     * @return mixed
     * @version:0.0.1
     */
    public function getAllSip()
    {
        global $admin_info;
        $sipList = AdminSIPModel::getAll()
            ->where('comp_id', '=', $admin_info['comp_id'])->get();
        $result['0'] = array('name' => 'choose from list', 'id' => '');
        $i = 1;
        foreach ($sipList['export']['list'] as $key => $value) {
            $result[$i]['name'] = $value->fields['sip_name'];
            $result[$i]['id'] = $value->fields['sip_id'];
            $i++;
        }
        return $result;

    }

    public function addSipForm()
    {
        global $company_info;
        $list['comp_id'] = $company_info['comp_id'];
        $list['sip_type'] = $this->setFieldsSipType();
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
        $list['action'] = 'addSip';
        // print_r_debug($list);
        $result = json_encode($list, JSON_PRETTY_PRINT);
        return $result;
    }

    public function service_AddSip($fields)
    {
        global $conn, $lang, $company_info;
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
        $modelCheck = AdminSIPModel::getBy_comp_id_and_sip_name($fields['comp_id'], $fields['sip_name'])->getList();
        if ($modelCheck['export']['recordsCount'] >= 1) {
            $result['result'] = -1;
            $result['msg'] = 'this sip name is exist';
            return $result;
        }


        $model = new AdminSIPModel;

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

    public function editSipForm($sipID)
    {
        $sipModel = AdminSIPModel::find($sipID);
        $list = $sipModel->fields;
        $list['id'] = $list['sip_id'];
        unset($list['sip_id']);
        $list['sip_type_selected'] = $list['sip_type'];
        $list['dtmfmode_selected'] = $list['dtmfmode'];

        $list['sip_type'] = $this->setFieldsSipType();
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
        $list['action'] = 'editSip';

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

    public function service_editSip($fields)
    {
        global $conn, $lang, $company_info;
        $fields['comp_id'] = $company_info['comp_id'];

        $fields['sip_id'] = $fields['id'];
        if ($fields['codecList_selected'] != '') {
            $fields['codec'] = ',' . implode(',', $fields['codecList_selected']) . ',';
        } else {
            $fields['codec'] = '';
        }

        $modelCheck = AdminSIPModel::getBy_comp_id_and_sip_name_and_not_sip_id($fields['comp_id'], $fields['sip_name'], $fields['sip_id'])->getList();
        if ($modelCheck['export']['recordsCount'] >= 1) {
            $result['result'] = -1;
            $result['msg'] = 'this sip name is exist';
            return $result;
        }

        $model = AdminSIPModel::find($fields['sip_id']);
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

    public function setFieldsSipType()
    {
        $list = array(array('id' => 'Peer', 'name' => 'Peer'), array('id' => 'Friend', 'name' => 'Friend'));
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

    public function setFieldsCodecList()
    {
        $list[0] = array('id' => 'g729', 'name' => 'g729');
        $list[1] = array('id' => 'alaw', 'name' => 'alaw');
        $list[2] = array('id' => 'ulaw', 'name' => 'ulaw');
        return $list;
    }
}