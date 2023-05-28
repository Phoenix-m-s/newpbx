<?php
/**
 * Created by PhpStorm.
 * User: VeRJiL
 * Date: 2/4/2017
 * Time: 1:35 PM
 */

class AdminQueueModel extends looeic
{
    protected $TABLE_NAME = 'tbl_queue';
    protected $rules = array(
        'queue_name' => 'required*'   . 'please fill in the queue_name',
        'queue_ext_no' => 'required*'   . 'please fill in the queue_ext_no',
        'queue_pass' => 'required*'   . 'please fill in the queue_pass',
        'max_wait_time' => 'required*'   . 'please fill in the max_wait_time'
    );

}