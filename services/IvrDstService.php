<?php
include_once ROOT_DIR . "component/ivr/adminIVRModel.php";

/**
 * Created by PhpStorm.
 * User: Shabihi
 * Date: 10/14/2018
 * Time: 4:03 PM
 */
class IvrDstService
{
    public function setFieldsAndSaveIvrDst($fields)
    {
        $limit = count($fields['dst_option_id_selected']);
        for ($i = 0; $i < $limit; $i++) {
            $model = new AdminIVRDSTModel();
            $model->ivr_id = $fields['ivr_id'];
            $model->dst_option_id = $fields['dst_option_id_selected'][$i]['dst_option_id'];
            $model->dst_option_sub_id = $fields['dst_option_id_selected'][$i]['dst_option_sub_id'];
            $model->ivr_menu_no = $fields['dst_option_id_selected'][$i]['ivr_menu_no'];
            $model->description = $fields['dst_option_id_selected'][$i]['description'];
            $model->trash = 0;

            if (isset($fields['dst_option_id_selected'][$i]['DSTOption']) & !empty($fields['dst_option_id_selected'][$i]['DSTOption'])) {
                $model->DSTOption = $fields['dst_option_id_selected'][$i]['DSTOption'];
            }

            if ($fields['dst_option_id_selected'][$i]['dst_option_id'] != '' and $fields['dst_option_id_selected'][$i]['dst_option_sub_id'] == '') {
                if (!in_array($fields['dst_option_id_selected'][$i]['dst_option_id'], ['7', '10', '11'])) {
                    $result['msg'] = 'Please fill required items';
                    $result['result'] = -1;
                    return $result;
                }
            }

            $checkExternal = new TblDstOptionService();
            $result = $checkExternal->checkDstSubOptioptionId($fields['dst_option_id_selected'][$i]['dst_option_id'], $fields['dst_option_id_selected'][$i]['dst_option_sub_id'], $fields['dst_option_id_selected'][$i]['DSTOption']);
            if ($result['result'] == -1) {
                return $result;
            }

            $validate = $model->validator();
            if ($validate['result'] == -1) {
                $result['msg'] = $validate['msg'];
                $result['result'] = -1;
                return $result;
            }

            $result = $model->save();
        }
        return $result;
    }

    public function deleteIvrDstByIvrId($id)
    {
        $ivrDSTObj = AdminIVRDSTModel::getBy_ivr_id($id)->get();
        if ($ivrDSTObj['export']['recordsCount'] >= 1) {
            foreach ($ivrDSTObj['export']['list'] as $ivr) {
                $result = $ivr->delete();
                if ($result['result'] != 1) {
                    return $result;
                }
            }
        }
        $result['msg'] = 'this ivr not any dst_option';
        $result['result'] = 1;
        return $result;
    }
}