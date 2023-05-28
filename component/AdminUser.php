<?php

class AdminUser extends looeic
{

    protected $TABLE_NAME = 'admin';
    protected $rules = array(
        'password' => 'required*'   .'please fill in the password',
        'username' => 'required*'   . 'please fill in the username'

    );
}

