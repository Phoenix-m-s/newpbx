<?php
// Connection details
$DBHOST = 'localhost';
$DBNAME = 'qstats';
$DBUSER = 'qstatsUser';
$DBPASS = 'qstatsPassw0rd';

// Manager details (for realtime tab)
$MANAGER_HOST   = "localhost";
$MANAGER_USER   = "tandis";
$MANAGER_SECRET = "tandiss@";

// Asternic user & pass for getting Scheduled reports and alerts
$REST_USER = "restUser";
$REST_PASS = "NICpgxdP0MmFLNq7aKu9CQrk8PfW8xC9";
//$REST_URL  = "http://localhost";


// Uncomment to register via proxy server
// $PROXY = "your.proxy.com:3128";

// Application title & logo
$ReportTitle = "Asternic Call Center Stats";
$ReportLogo  = "images/asternic_logo.png";

define('DEBUG',       false );
define('SQLDEBUG',    false );
define('ACTIONDEBUG', false );
define('MAILDEBUG',   false );
