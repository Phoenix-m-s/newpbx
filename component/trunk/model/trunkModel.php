<?php

/**
 * Created by PhpStorm.
 * User: VeRJiL
 * Date: 4/4/2017
 * Time: 2:56 AM
 */

class trunkModel extends looeic
{
    protected $TABLE_NAME = 'trunk';
    protected $rules = array(
        'trunk_name' => 'required*' . 'please fill in the name',
        'host' => 'required*' . 'please fill the host'
        /*'weekDayStart' => 'required*'   . 'please fill in the monthStart',
        'weekDayEnd' => 'required*'   . 'please fill in the monthEnd',
        'dayStart' => 'required*'   . 'please fill in the dayStart',
        'dayEnd' => 'required*'     . 'please fill in the dayEnd'*/

    );

}