<?php

include_once(ROOT_DIR . "common/looeic.php");

class memberLoginModel extends looeic
{
        protected $TABLE_NAME = 'tbl_extension';
}

$memberModel = new memberLoginModel();
