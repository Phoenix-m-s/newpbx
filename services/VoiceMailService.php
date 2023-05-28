<?php
include_once ROOT_DIR . "component/extension/AdminExstionNewModel.php";

/**
 * Class VoiceMailService
 */
class VoiceMailService
{
    /**
     *getAllVoiceMail
     * @author:Mojtaba Sakhamanesh & Shabihi
     * @Email:sakhamanesh@dabacenter.ir
     * @return mixed
     * @version:0.0.1
     */
    public function getAllVoiceMail($id=0)
    {

        global $admin_info,$member_info;
        
        if($admin_info !=-1){
            $voiceMailList = AdminExstionNewModel::getAll()
                ->where('voicemail_status', '=', 1)
                ->where('comp_id', '=', $admin_info['comp_id']);
        }
        else{
            $voiceMailList = AdminExstionNewModel::getAll()
                ->where('voicemail_status', '=', 1)
                ->where('comp_id', '=', $member_info['comp_id']);
        }

        if ($id != 0) {
            $voiceMailList->where('extension_id', '=', $id);
        }

        $voiceMailList = $voiceMailList->get();
       // print_r_debug($voiceMailList);

        $result["0"] = array('name' => 'choose from list', 'id' => '');
        $i = 1;
        foreach ($voiceMailList['export']['list'] as $key => $value) {
            $result[$i]['name'] = $value->fields['extension_no'];
            $result[$i]['id'] = $value->fields['extension_id'];
            $i++;
        }
        return $result;
    }

}