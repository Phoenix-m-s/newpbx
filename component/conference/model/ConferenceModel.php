<?php

class ConferenceModel extends looeic
{
    protected $TABLE_NAME = 'conference';
    protected $rules = array(
        'conf_name' => 'required*'   . 'please fill in the conf_label' ,
        'conf_number' => 'required*'   . 'please fill in the conf_number'
    );
}
