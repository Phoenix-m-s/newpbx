<?php
class AdminInboundModel extends looeic
{
    protected $TABLE_NAME = 'tbl_inbound';
    protected $rules = array(
        'inbound_name' => 'required*' . 'please fill inbound_name',

    );

    function addValidate($fields)
    {
        if ($fields['check_did_name']=='0') {
            $this->rules['did_name']='required*' . 'please fill did number'.'|integer*'.'did number should have numerical value';
        }

        if ($fields['check_cid_name']=='0') {
            $this->rules['cid_name'] = 'required*' . 'please fill cid number'.'|integer*'.'cid number should have numerical value';;
        }

    }




}