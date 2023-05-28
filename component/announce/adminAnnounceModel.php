<?php

class AdminAnnounceModel extends looeic
{
    protected $TABLE_NAME = 'tbl_announce';
    protected $rules = array(
        'announce_name' => 'required*'   . 'please fill in the announce_name'
    );
}
