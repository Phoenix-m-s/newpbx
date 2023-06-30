<?php

include_once ROOT_DIR . "component/ivr/adminIVRModel.php";
include_once ROOT_DIR . "services/IvrDstService.php";
include_once ROOT_DIR . "services/UploadService.php";
include_once ROOT_DIR . "services/TblDstOptionService.php";
include_once ROOT_DIR . 'services/ConferenceService.php';

/**
 * Class IvrService
 */
class IvrService
{
    /**
     *getAllIvr
     *author:Mojtaba Sakhamanesh & Shabihi
     *Email:sakhamanesh@dabacenter.ir
     * @return mixed
     *version:0.0.1
     */
    public function getAllIvr()
    {
        global $admin_info;
        $ivrList = AdminIVRModel::getAll()
            ->where('comp_id', '=', $admin_info['comp_id'])->get();
        $result['0'] = array('name' => 'choose from list', 'id' => '');
        $i = 1;
        foreach ($ivrList['export']['list'] as $key => $value) {
            $result[$i]['name'] = $value->fields['ivr_name'];
            $result[$i]['id'] = $value->fields['ivr_id'];
            $i++;
        }

        return $result;
    }

    public function checkIvrName($fields)
    {
        return AdminIVRModel::getBy_comp_id_and_ivr_name_and_not_ivr_id($fields['comp_id'], $fields['ivr_name'], $fields['ivr_id'])->getList();
    }

    public function addIvrForm()
    {
        $uniId = uniqid();
        $_SESSION['token'][$uniId] = '1';
        $fields['token'] = 'token[' . $uniId . ']';

        //////////////get uploadList////////////
        $upload = new UploadService();
        $fields['upload_id'] = $upload->getUploadList();

        //////////////get dialExtensionDetail////////////
        $ivrOption = new TblDstOptionService();
        $dialExtension_list = $ivrOption->getIvrOption();
        $fields['dst_option_id'] = $ivrOption->getDialExtensionDetailByName($dialExtension_list);
        $fields['action'] = 'addIvr';
        $fields['direct_dial'] = 1;

        $ivr_menu = array('Invalid', 'TimeOut');
        for ($i = 0; $i < 2; $i++) {
            $fields['dst_option_id_selected'][$i]['dst_option_id'] = '';
            $fields['dst_option_id_selected'][$i]['dst_option_sub_id'] = '';
            $fields['dst_option_id_selected'][$i]['DSTOption'] = '';
            $fields['dst_option_id_selected'][$i]['description'] = '';
            $fields['dst_option_id_selected'][$i]['ivr_menu_no'] = $ivr_menu[$i];
        }
        $list = json_encode($fields, JSON_PRETTY_PRINT);
        return $list;
    }

    public function addIvr($fields)
    {
        global $admin_info, $company_info;
        looeic::beginTransaction();
        $fields['comp_id'] = $company_info['comp_id'];

        $ivr = new AdminIVRModel();
        $ivr->comp_id = $admin_info['comp_id'];
        $validate = $ivr->validator();
        if ($validate['result'] == -1) {
            looeic::rollback();
            $result['msg'] = $validate['msg'];
            $result['result'] = -1;
            return $result;
        }

        $ivrName = $this->checkIvrName($fields);
        if ($ivrName['export']['recordsCount'] >= 1) {
            looeic::rollback();
            $result['result'] = -1;
            $result['msg'] = 'this ivr name is exist';
            return $result;
        }

        $result = $ivr->save();
        if ($result['result'] == -1) {
            looeic::rollback();
            $result['msg'] = 'Failed To Updated';
            return $result;
        }

        $fields['ivr_id'] = $ivr->fields['ivr_id'];
        $IvrDst = new IvrDstService();
        $checkNumberIvr=$IvrDst->checkNumberIvr($fields);
        if ($checkNumberIvr['export']['recordsCount'] >= 1) {
            looeic::rollback();
            $result['msg'] = ' Ivr number exists';
            $result['result'] = -1;
            return $result;
        }

        if ($result['result'] != 1) {
            looeic::rollback();
            $result['result'] = -1;
            return $result;
        }
        $result = $IvrDst->setFieldsAndSaveIvrDst($fields);
        if ($result['result'] != 1) {
            looeic::rollback();
            $result['result'] = -1;
            return $result;
        }
        looeic::commit();
        return $result;
    }

    public function editIvrForm($ivrID)
    {
        $ivrDirty2 = AdminIVRModel::find($ivrID);
        $fields = $ivrDirty2->fields;

        $fields['upload_id_selected'] = $fields['upload_id'];
        unset($fields['upload_id']);
        $sql =
            'SELECT b.dst_option_id, b.dst_option_sub_id, b.forward, b.DSTOption, b.description, b.ivr_menu_no 
            FROM tbl_ivr AS a 
            JOIN tbl_ivr_dst_menu AS b 
            ON a.ivr_id=b.ivr_id 
            WHERE a.ivr_id=' . $ivrID;

        $ivrDirty = AdminIVRModel::query($sql)->getList();

        foreach ($ivrDirty['export']['list'] as $key => $list) {
            $fields['dst_option_id_selected'][$key]['dst_option_id'] = $list['dst_option_id'];
            $fields['dst_option_id_selected'][$key]['dst_option_sub_id'] = $list['dst_option_sub_id'];
            $fields['dst_option_id_selected'][$key]['DSTOption'] = $list['DSTOption'];
            $fields['dst_option_id_selected'][$key]['description'] = $list['description'];
            $fields['dst_option_id_selected'][$key]['ivr_menu_no'] = $list['ivr_menu_no'];
        }

        //////////////get uploadList////////////
        $upload = new UploadService();
        $fields['upload_id'] = $upload->getUploadList();

        //////////////get dialExtensionDetail////////////
        $ivrOption = new TblDstOptionService();
        $dialExtension_list = $ivrOption->getIvrOption();
        $fields['dst_option_id'] = $ivrOption->getDialExtensionDetailByName($dialExtension_list);
        $fields['action'] = 'editIvr';
        $list = json_encode($fields, JSON_PRETTY_PRINT);
        return $list;
    }

    public function editIvr($fields)
    {

        global $company_info;
        looeic::beginTransaction();
        $fields['comp_id'] = $company_info['comp_id'];
        $ivr = AdminIVRModel::find($fields['ivr_id']);
        //print_r_debug($ivr->getList());
        if (!is_object($ivr)) {
            $ivr['msg'] = 'this ivr not exsist';
            return $ivr;
        }

        $IvrDst = new IvrDstService();


        $result = $IvrDst->deleteIvrDstByIvrId($fields['ivr_id']);
        if ($result['result'] != 1) {
            looeic::rollback();
            $result['result'] = -1;
            return $result;
        }

        $result = $IvrDst->setFieldsAndSaveIvrDst($fields);
        if ($result['result'] != 1) {
            looeic::rollback();
            $result['result'] = -1;
            return $result;
        }

        $result = $ivr->setFields($fields);
        if ($result['result'] != 1) {
            looeic::rollback();
            $result['result'] = -1;
            $result['msg'] = 'Failed To Updated';
            return $result;
        }

        $ivrName = $this->checkIvrName($fields);
        if ($ivrName['export']['recordsCount'] >= 1) {
            looeic::rollback();
            $result['result'] = -1;
            $result['msg'] = 'this ivr name is exist';
            return $result;
        }

        $checkNumberIvr=$IvrDst->checkNumberIvr($fields);
        if ($checkNumberIvr['export']['recordsCount'] >= 1) {
            looeic::rollback();
            $result['msg'] = ' Ivr number exists';
            $result['result'] = -1;
            return $result;
        }

        $validate = $ivr->validator();
        if ($validate['result'] == -1) {
            looeic::rollback();
            $result['msg'] = $validate['msg'];
            $result['result'] = -1;
            return $result;
        }

        $result = $ivr->save();
        if ($result['result'] == -1) {
            $result['msg'] = 'Failed To Updated';
            return $result;
        }
        looeic::commit();
        return $result;
    }

    public function deleteIvrByIvrId($id)
    {
        $ivrObj = AdminIVRModel::find($id);
        if (!is_object($ivrObj)) {
            $ivr['msg'] = 'this ivr not exsist';
            return $ivr;
        } else {
            $result = $ivrObj->delete();
            return $result;
        }
    }
}