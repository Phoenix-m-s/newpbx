<?php

session_start();
define("DS", DIRECTORY_SEPARATOR);

define("DB_TYPE", "mysql");
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASSWORD", "");
define("DB_DATABASE", "newpbx");

define("JWT_KEY", "pbxAmirreza");
define("COUNT_PERMISSION",10);

$mysql = array(
    'default' => 'mysql',
    'connections' => array(
        # Primary/Default database connection
        'mysql' => array(
            'DB_TYPE' => 'mysql',
            'DB_HOST' => 'localhost',
            'DB_DATABASE' => 'newpbx',
            'DB_USER' => 'root',
            'DB_PASSWORD' => '',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ),
        # Secondary database connection
        'mysql3' => array(
            'DB_TYPE' => 'mysql',
            'DB_HOST' => 'localhost',
            'DB_DATABASE' => 'newpbx',
            'DB_USER' => 'root',
            'DB_PASSWORD' => '',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',

        ),
        'cdr' => array(
            'DB_TYPE' => 'mysql',
            'DB_HOST' => 'localhost',
            'DB_DATABASE' => 'newpbx',
            'DB_USER' => 'root',
            'DB_PASSWORD' => '',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',

        ),
    ),
);


define("SERVER", "cloud");//for use login box set database server ip //for cloud login set "cloud"
define("DB_HOST2", "localhost");
define("DB_USER2", "root");
define("DB_PASSWORD2", "");
define("DB_DATABASE2", "login_box");
define("RELA_DIR_BOX", "http://boxlogin.local/");


define("ROOT_DIR", dirname(__FILE__) .DS);
define("RELA_DIR", "http://" . $_SERVER['HTTP_HOST'] . "/");
define("PRODUCT_IMAGE", RELA_DIR . "templates/images/product/product_image/");
define("PRODUCT_IMAGE_ROOT", ROOT_DIR . "templates/images/product/product_image/");
define("STATIC_ROOT_DIR", ROOT_DIR . "statics");
define("SMTP_PASSWORD", "");
define("SMTP_SERVER", "mail.zi-tel.com");
define("SMTP_SENDER", "Zitel");
define("SMTP_USERNAME", "cto@zi-tel.com");
date_default_timezone_set('Asia/Tehran');
define("GAPI_KEY", "AIzaSyByLaTkeVQQX6Tuxn7gIFAVpCFHYfZAbEU");
define("ROOT_CHANEL", dirname(__FILE__) .DS."monitor".DS."");
define("RELA_CHANEL", "http://" . $_SERVER['HTTP_HOST'] .DS."monitor".DS."");
define("AMI_HOST", "127.0.0.1");
define("AMI_USER_NAME", "tandis");
define("AMI_PASSWORD", "tandiss@");
define("AMI_Port", "5038");

define("RECORD_PATH", "/var".DS."www".DS);
define("VOICEMAIL_PATH", "var".DS."www".DS."camp".DS."voiceMail".DS."");
define("UPLOAD_IVR_DIR", RELA_DIR . "statics".DS."files".DS."");
define("UPLOAD_IVR_ROOT", ROOT_DIR . "statics".DS."files".DS."");
define("TARGET_DIR_Config", ROOT_DIR . "statics".DS."temp".DS."");
define("SERVER_IP", "127.0.0.1");


//voipConfig

define("UPLOAD_VOIPCONFIG_DIR", ROOT_DIR . "component/voip_config/admin/model/");
//uploader
define("SIZE_UPLOAD_FILE", 50000000);
define("TARGET_DIR", ROOT_DIR . "voip/");



$otherServer[1]['dbName'] = '';


