<?php
include_once ROOT_DIR . "component/outbound/adminOutboundModel.php";
include_once ROOT_DIR . "component/dialpattern/adminDialPattrenModel.php";
include_once ROOT_DIR . "component/outbound_siptrunk/adminOutboundSiptrunkModel.php";
include_once ROOT_DIR . "services/SipService.php";


/**
 * Class OutBoundService
 */
class OutBoundService
{
    /**
     * @return mixed
     * @Email:sakhamanesh@dabacenter.ir
     */
    public function getAllOutBound()
    {
        $OutBoundList = adminOutboundModel::getAll()->get();
        foreach ($OutBoundList['export']['list'] as $key => $value) {
            $result[$key]['name'] = $value->fields['outbound_name'];
            $result[$key]['id'] = $value->fields['outbound_id'];
        }

        return $result;

    }


    /**
     * @param $fields
     * @return mixed
     * @Email:sakhamanesh@dabacenter.ir
     *
     */
    public function checkOutBoundName($fields)
    {
        return adminOutboundModel::getBy_comp_id_and_outbound_name_and_not_outbound_id($fields['comp_id'], $fields['outbound_name'], $fields['outbound_id'])->get();
    }

    /**
     * @author:Mojtaba Sakhamanesh & Shabihi
     * @Email:sakhamanesh@dabacenter.ir
     * @return mixed
     * @param $fields
     * @return mixed
     */
    public function editOutBound($fields)
    {
        global $company_info;

        looeic::beginTransaction();

        $fields['comp_id'] = $company_info['comp_id'];

        $dailPattern = adminDialPattrenModel::getBy_outbound_id($fields['outbound_id'])->get();


        if (!is_object($dailPattern['export']['list']['0'])) {
            $dailPattern['msg'] = 'this outbound not exsist';
            return $dailPattern;
        }
        $result = $dailPattern['export']['list']['0']->delete();
        if ($result['result'] != 1) {
            looeic::rollback();
            $result['result'] = -1;
            return $result;
        }
        $result = $this->EditDialPattern($fields);

        if ($result['result'] != 1) {
            looeic::rollback();
            $result['result'] = -1;
            return $result;
        }

        $OutBoundObj = adminOutboundModel::find($fields['outbound_id']);

        $OutBoundObj->siptrunk_id = $fields['sip_id_selected'];
        $OutBoundObj->priority = $fields['priority_selected'];

        $result = $OutBoundObj->setFields($fields);

        if ($result['result'] != 1) {
            looeic::rollback();
            $result['result'] = -1;
            $result['msg'] = 'Failed To Updated';
            return $result;
        }

        if (isset($fields['sip_id'])) {
            $result = $this->editSiptrunkId($fields);
            if ($result['result'] == -1) {
                looeic::rollback();
                $result['msg'] = 'fail to add information';
                return $result;
            }
        }

        $outboundBName = $this->checkOutBoundName($fields);
        if ($outboundBName['export']['recordsCount'] >= 1) {
            looeic::rollback();
            $result['result'] = -1;
            $result['msg'] = 'this outbound name is exist';
            return $result;
        }

        /* $validate = $OutBoundObj->validator();
         if ($validate['result'] == -1) {
             looeic::rollback();
             $result['msg'] = $validate['msg'];
             $result['result'] = -1;
             return $result;
         }*/
        $result = $OutBoundObj->save();
        if ($result['result'] == -1) {
            $result['msg'] = 'Failed To Updated';
            return $result;
        }
        looeic::commit();
        return $result;

    }

    /**
     * @author:Mojtaba Sakhamanesh & Shabihi
     * @Email:sakhamanesh@dabacenter.ir
     * @param $fields
     * @return mixed
     */
    public function addOutBound($fields)
    {
        global $company_info;
        looeic::beginTransaction();

        $fields['comp_id'] = $company_info['comp_id'];

        $OutBound = new adminOutboundModel();
        $OutBound->setFields($fields);
        $OutBound->priority = $fields['priority_selected'];

        $outboundBName = $this->checkOutBoundName($fields);
        if ($outboundBName['export']['recordsCount'] >= 1) {
            looeic::rollback();
            $result['result'] = -1;
            $result['msg'] = 'this outbound name is exist';
            return $result;
        }

        $validate = $OutBound->validator();
        if ($validate['result'] == -1) {
            $result['fields'] = $validate;
            $result['msg'] = 'this outbound name is not valid';
            return $result;
        }
        $OutBound->save();

        $fields['outbound_id'] = $OutBound->outbound_id;
        $result = $this->SetFieldsAndSave($fields);
        if ($result == -1) {
            looeic::rollback();
            $result['msg'] = 'fail to add information';
            return $result;
        }

        if (isset($fields['sip_id'])) {
            $result = $this->saveSiptrunkId($fields);
            if ($result['result'] == -1) {
                looeic::rollback();
                $result['msg'] = 'fail to add information';
                return $result;
            }
        }


        looeic::commit();

        $result['fields'] = $fields;
        $result['result'] = 1;
        $result['msg'] = 'add information';
        return $result;
        //return json_encode($result,JSON_PRETTY_PRINT));
        die();
    }

    /**
     * @Email:sakhamanesh@dabacenter.ir
     * @param $fields
     * @return mixed
     */
    public function SetFieldsAndSave($fields)
    {
        $model = new adminDialPattrenModel();
        foreach ($fields['outbound_list'] as $k => $v) {

            $model->outbound_id = $fields['outbound_id'];
            $model->prepend .= ',' . $v['prepend'];
            $model->match_pattern .= ',' . $v['match_pattern'];
            $model->prefix .= ',' . $v['prefix'];
            $model->caller_id .= ',' . $v['caller_id'];

            //$component->setFields($v);
            //$validate = $component->validator();
            /*if ($validate['result'] == -1) {
                $result = $validate;
                $result['result'] = -1;
                return $result;
            }*/
        }
        $model->prepend .= ',';
        $model->match_pattern .= ',';
        $model->prefix .= ',';
        $model->caller_id .= ',';
        $model->save();

        $result['result'] = 1;
        return $result;
    }

    public function saveSiptrunkId($fields)
    {
        if (! $this->checkSipId($fields)) {
            $result['result'] = -1;
            return $result;
        }

        if (! $this->checkSipCount($fields)) {
            $result['result'] = -1;
            return $result;
        }

        foreach ($fields['sip_id'] as $id) {
            $model = new adminOutboundSiptrunkModel();
            $model->outbound_id = $fields['outbound_id'];
            $model->siptrunk_id = $id;
            $model->save();
        }

        $result['result'] = 1;
        return $result;
    }

    public function checkSipCount($fields)
    {
        $sips = (new SipService())->getAllSip();
        $countSips = count($sips) - 1;
        $countRequestSips = count($fields['sip_id']);

        if ($countRequestSips > $countSips) {
            return false;
        }

        return true;
    }

    public function checkSipId($fields)
    {
        $sips = (new SipService())->getAllSip();

        foreach ($sips as $sip) {
            if (! empty($sip['id'])) {
                $sipIds[] = $sip['id'];
            }
        }

        foreach ($fields['sip_id'] as $sip_id) {
            if (! in_array($sip_id, $sipIds)) {
                return false;
            }
        }

        return true;
    }

    public function editSiptrunkId($fields)
    {
        if (! $this->checkSipCount($fields)) {
            $result['result'] = -1;
            return $result;
        }

        if (! $this->checkSipId($fields)) {
            $result['result'] = -1;
            return $result;
        }

        $siptrunks = adminOutboundSiptrunkModel::getAll()
            ->where('outbound_id', '=', $fields['outbound_id'])
            ->get();

        if ($siptrunks['export']['recordsCount'] >= 1) {
            foreach ($siptrunks['export']['list'] as $siptrunk) {
                $siptrunk->delete();
            }
        }

        foreach ($fields['sip_id'] as $id) {
            $model = new adminOutboundSiptrunkModel();
            $model->outbound_id = $fields['outbound_id'];
            $model->siptrunk_id = $id;
            $model->save();
        }

        $result['result'] = 1;
        return $result;
    }

    public function deleteSiptrunks($outbound_id)
    {
        $siptrunks = adminOutboundSiptrunkModel::getAll()
            ->where('outbound_id', '=', $outbound_id)
            ->get();

        if ($siptrunks['export']['recordsCount'] >= 1) {
            foreach ($siptrunks['export']['list'] as $siptrunk) {
                $siptrunk->delete();
            }
        }

        $result['result'] = 1;
        return $result;
    }

    /**
     * @param $fields
     * @return mixed
     */
    public function EditDialPattern($fields)
    {
        $model = adminDialPattrenModel::getBy_outbound_id($fields['outbound_id']);
        foreach ($fields['outbound_list'] as $k => $v) {

            $model->outbound_id = $fields['outbound_id'];
            $model->prepend .= ',' . $v['prepend'];
            $model->match_pattern .= ',' . $v['match_pattern'];
            $model->prefix .= ',' . $v['prefix'];
            $model->caller_id .= ',' . $v['caller_id'];

            //$component->setFields($v);
            //$validate = $component->validator();
            /*if ($validate['result'] == -1) {
                $result = $validate;
                $result['result'] = -1;
                return $result;
            }*/
        }
        $model->prepend .= ',';
        $model->match_pattern .= ',';
        $model->prefix .= ',';
        $model->caller_id .= ',';
        $result = $model->save();
        return $result;
    }

    /**
     * @Email:sakhamanesh@dabacenter.ir
     * @param $id
     * @return array|mixed
     */
    public function showEditOutBoundForm($id)
    {
        global $company_info;

        $fields = [];
        $OutBoundDirty = adminOutboundModel::find($id);
        $OutBoundID = $OutBoundDirty->outbound_id;
        $OutBound = adminDialPattrenModel::getBy_outbound_id($OutBoundID)->getList();

        $OutBoundClean = $OutBound['export']['list'][0];
        $sipTrunk = new SipService();

        $fields = $this->reArrangeData($OutBoundClean);
//        unset($fields['outbound_list'][0]);
        //unset($fields['outbound_list'][count($fields['outbound_list'])]);
        $fields['comp_id'] = $company_info['comp_id'];
        $fields['outbound_name'] = $OutBoundDirty->outbound_name;
        $fields['outbound_id'] = $OutBoundDirty->outbound_id;
        $fields['sip_id'] = $sipTrunk->getAllSip();
        $fields['sip_id_selected'] = $this->getSiptrunkId($OutBoundDirty->outbound_id);
        $fields['priority_id_selected'] = $OutBoundDirty->priority;

        $fields['caller_id_number'] = $OutBoundDirty->caller_id_number;
        $fields['caller_id_name'] = $OutBoundDirty->caller_id_name;
        $fields['form_action'] = 'edit';
        $fields['action'] = 'editOutbound';
        $fields['priority']=$this->checkPriority($fields['outbound_name']);
        return $fields;

    }

    public function getSiptrunkId($outbound_id)
    {
        $siptrunks =  adminOutboundSiptrunkModel::getAll()
            ->where('outbound_id', '=', $outbound_id)
            ->getList();

        $siptrunkIds = array();
        foreach ($siptrunks['export']['list'] as $siptrunk) {
            array_push($siptrunkIds, $siptrunk['siptrunk_id']);
        }

        return $siptrunkIds;
    }


    /**
     * @Email:sakhamanesh@dabacenter.ir
     * @param $OutBoundClean
     * @return mixed
     */
    private function reArrangeData($OutBoundClean)
    {

        $fields['caller_id'] = explode(",", substr($OutBoundClean['caller_id'], "1", strlen($OutBoundClean['caller_id']) - 2));
        $fields['prepend'] = explode(",", substr($OutBoundClean['prepend'], "1", strlen($OutBoundClean['prepend']) - 2));
        $fields['prefix'] = explode(",", substr($OutBoundClean['prefix'], "1", strlen($OutBoundClean['prefix']) - 2));
        $fields['match_pattern'] = explode(",", substr($OutBoundClean['match_pattern'], "1", strlen($OutBoundClean['match_pattern']) - 2));

        foreach ($fields['match_pattern'] as $key => $val) {
            $newFields['outbound_list'][$key]['caller_id'] = $fields['caller_id'][$key];
            $newFields['outbound_list'][$key]['prepend'] = $fields['prepend'][$key];
            $newFields['outbound_list'][$key]['prefix'] = $fields['prefix'][$key];
            $newFields['outbound_list'][$key]['match_pattern'] = $fields['match_pattern'][$key];
        }
        return $newFields;
    }


    /**
     * @author:Mojtaba Sakhamanesh & Shabihi
     * @Email:sakhamanesh@dabacenter.ir
     * @param $id
     * @return mixed
     */
    public function deleteOutBoundId($id)
    {
        $OutBoundObj = adminOutboundModel::find($id);

        if (!is_object($OutBoundObj)) {
            $OutBoundObj['msg'] = 'this outbound not exsist';
            return $OutBoundObj;
        } else {
            $result = $OutBoundObj->delete();
            return $result;
        }

    }

    /**
     * @Email:sakhamanesh@dabacenter.ir
     * @param $id
     * @return mixed
     */
    public function deleteOutBoundIdDaialPattern($id)
    {
        $dialPattern = adminDialPattrenModel::getBy_outbound_id($id)->get();

        if (!is_object($dialPattern)) {
            $dialPattern['msg'] = 'this outbound not exsist';
            return $dialPattern;
        } else {
            $result = $dialPattern->delete();
            return $result;
        }
    }


    /**
     * @return mixed
     * @Email:sakhamanesh@dabacenter.ir
     */
    public function checkPriority($outboundName = ''){

        $OutBoundDirty = AdminOutboundModel::getAll()->getList();
        $list[0]['name']='chose form list';
        $OutboundClean = $OutBoundDirty['export']['list'];
        $cnt=1;
        foreach ($OutboundClean as $key => $value) {
            $res[$cnt]['id'] = $value['priority'];
            $res[$cnt]['name'] = $value['priority'];
            $a[$value['priority']]['outbound_name'] = $value['outbound_name'];
            $a[$value['priority']]['priority'] = $value['priority'];
        }


        for ($i = 1; $i < 11; $i++) {
            if (array_key_exists($i, $a)) {
                $list[$i]['id'] = $i;
                $list[$i]['name'] = $i;
                $list[$i]['isUsed'] = $a[$i]['priority'] != '0' ? $a[$i]['outbound_name'] : '0';

            } else {
                $list[$i]['id'] = $i;
                $list[$i]['name'] = $i;
                $list[$i]['isUsed'] = '0';
            }
        }

        if ($outboundName !== '') {
            $key = array_search($outboundName, array_column($list, 'isUsed'));
            $list[$key + 1]['isUsed'] = '0';
        }

        return $list;
    }
}