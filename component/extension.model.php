<?php

class AdminExtensionModel extends looeic
{
    protected $TABLE_NAME = 'tbl_extension';

   /* protected $rules = array(
        'extension_name' => 'required*'.ModelEXTENSION_02.'|min_len,9|max_len,20'
    );*/
}
class AdminExtensionModel2 extends looeic
{
    protected $TABLE_NAME = 'tbl_extension';
    protected $CONNECTION_NAME = 'mysql2';

    /* protected $rules = array(
         'extension_name' => 'required*'.ModelEXTENSION_02.'|min_len,9|max_len,20'
     );*/
}