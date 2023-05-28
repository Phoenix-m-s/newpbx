<?php
/**
 * Created by PhpStorm.
 * User: VeRJiL
 * Date: 4/12/2017
 * Time: 8:25 AM
 */


class AdminOutboundModel extends looeic
{
    protected $TABLE_NAME = 'tbl_outbound';
    protected $rules = array(
        'outbound_name' => 'required*' . 'please fill in the outbound_name'
    );

}