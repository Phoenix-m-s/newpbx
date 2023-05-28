<?php
/**
 * Created by PhpStorm.
 * User: VeRJiL
 * Date: 1/16/2017
 * Time: 11:56 AM
 */


class AdminExstionNewModel extends looeic
{
    protected $TABLE_NAME = 'tbl_extension';
    protected $rules = array(
        'extension_name' => 'required*'   . 'please fill in the extension_name',
        'secret' => 'required*'   . 'please fill in the secret',
        'username' => 'required*'   . 'please fill in the username',
        'extension_no' => 'required*'   . 'please fill in the extension_no',
        'password' => 'required*'   . 'please fill in the password',
        'caller_id_number' => 'required*'     . 'please fill in the caller_id_number',
        'ring_number' => 'required*'     . 'please fill in the ring_number'
    );
    public static $extensionFillable=array(
        'comp_id',
        'extension_name',
        'extension_no',
        'caller_id_number',
        'username',
        'extension_type',
        'extension_id',
        'timezone'
        )
        ;

    public function getFields()
    {
        return $this->TABLE_FIELD;

    }



    public function SetFieldsAndSave($fields)
    {

        $model = new AdminExstionNewModel();

        $model->extension_status         = $fields['tc'][0]['extension_status'];
        $model->voicemail_status         = $fields['tc'][0]['voicemail_status'] ;
        $model->voicemail_email          = $fields['tc'][0]['voicemail_email'] ;
        $model->voicemail_pass           = $fields['tc'][0]['voicemail_pass'] ;
        $model->extension_name           = $fields['tc'][0]['extension_name'] ;
        $model->extension_no             = $fields['tc'][0]['extension_no']  ;
        $model->secret                   = $fields['tc'][0]['secret'] ;
        $model->extension_date           = $fields['tc'][0]['extension_date'] ;
        $model->internal_recording       = $fields['tc'][0]['internal_recording'];
        $model->extension_date           = strftime('%Y-%m-%d %H:%M:%S', time());
        $model->external_recording       = $fields['tc'][0]['external_recording'];
        $model->extension_status         = 1;
        $model->caller_id_number         = $fields['tc'][0]['caller_id_number'];
        $model->ring_number              = $fields['tc'][0]['ring_number'];
        $model->username                 = $fields['tc'][0]['username'];
        $model->password                 = $fields['tc'][0]['password'];
        $model->dst_option_id            = $fields['tc'][0]['dst_option_id_selected']['dst_option_id'];
        $model->dst_option_sub_id        = $fields['tc'][0]['dst_option_id_selected']['dst_option_sub_id'];
        $model->DSTOption                = $fields['tc'][0]['dst_option_id_selected']['DSTOption'];
        $model->mac_address              = strtoupper($fields['tc'][0]['mac_address']);
        $model->protocol                 = $fields['tc'][0]['protocol'];
        $model->fdst_option_id           = $fields['failTc'][0]['fdst_option_id'];
        $model->fdst_option_sub_id       = $fields['failTc'][0]['fdst_option_sub_id'];
        $model->fDSTOption               = $fields['failTc'][0]['fDSTOption'];
        $model->comp_id                  = $fields['comp_id'];
        $model->extension_type           = $fields['tc'][0]['extension_type'];

        $model->timezone                 = $fields['tc'][0]['timezone'];

        if ($fields['tc'][0]['forward']    ==='customMessageByList') {
            $model->DSTOption    = $fields['tc'][0]['dst_option_id_selected']['DSTOption'];
        }
        if ($fields['tc'][0]['forward']    ==='internal') {
            $model->DSTOption    = $fields['tc'][0]['dst_option_id_selected']['DSTOption'];
        }
        if ($fields['tc'][0]['forward']    ==='external') {
            $model->DSTOption    =$fields['tc'][0]['dst_option_id_selected']['DSTOption'];
        }
        if($model->internal_recording==''){
            $model->internal_recording=0;
        }
        if($model->external_recording==''){
            $model->external_recording=0;
        }
        //print_r_debug($component);
        /*$validate = $component->validator($rules, $fields);
        if ($validate['result'] == -1) {
            $result = $validate;
            $result['result']=-1;
            echo json_encode($result);
            die();
        }*/
        //print_r_debug($component);
        $result = $model->save();
        return $result;
    }
}
