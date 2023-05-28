<?php
/**
 * Created by PhpStorm.
 * User: VeRJiL
 * Date: 2/4/2017
 * Time: 11:05 AM
 */

class AdminIVRModel extends looeic
{
    protected $TABLE_NAME = 'tbl_ivr';
    protected $rules = array(
        'ivr_name' => 'required*' . 'please fill in the ivr_name'
    );
}

class AdminIVRDSTModel extends looeic
{
    protected $TABLE_NAME = 'tbl_ivr_dst_menu';
    /*protected $rules = array(
        'dst_option_id' => 'required*' . 'please fill in the dst_option_id',
        'dst_option_sub_id' => 'required*' . 'please fill in the dst_option_sub_id'
    );*/

}