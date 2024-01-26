<?php
//use \Firebase\JWT\JWT;

class handle_input_data
{
    public function handle_array($_input)
    {
        $input_array = Array();
        if (is_array($_input)) {
            foreach ($_input as $key => $val) {
                $input_array[$key] = $this->handle_array($val);
            }
        } else {
            $input_array = trim(($_input));
        }
        return $input_array;
    }
}

function print_r_debug($string)
{
    echo "<pre>";
    print_r($string);
    echo "</pre>";
    die();
}

function stripSlashesDeep($value)
{
    $value = is_array($value) ? array_map('stripSlashesDeep', $value) : stripslashes($value);
    return $value;
}

function checkUppercase($string)
{

    if (preg_match("/[A-Z]/", $string) === 0) {
        return 0;
    }
    return 1;
}

function checkDateFormat($date)
{
    //match the format of the date
    if (preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $date, $parts)) {
        //check weather the date is valid of not
        if (checkdate($parts[2], $parts[3], $parts[1])) {
            return true;
        } else {
            return false;
        }

    } else {
        return false;
    }

}

function isValidDateTime($dateTime)
{
    if (preg_match("/^(\d{4})-(\d{2})-(\d{2}) ([01][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/", $dateTime, $matches)) {
        if (checkdate($matches[2], $matches[3], $matches[1])) {
            return true;
        }
    }

    return false;
}

function checkBoxValue($value)
{
    if ($value == 'on') {
        $value = 1;
    } else {
        $value = 0;
    }

    return $value;
}

function serialNoCreator($prefix_serial_number)
{
    $serial_number = $prefix_serial_number . uniqid();

    return $serial_number;
}

function dateCreator()
{
    $creation_date = getdate();
    $creation_date = $creation_date['year'] . "-" . $creation_date['mon'] . "-" . $creation_date['mday'] . " " . $creation_date['hours'] . ":" . $creation_date['minutes'] . ":" . $creation_date['seconds'];

    return $creation_date;
}
function changeLang($lang)
{

    session_start();
    $conn = dbConn::getConnection();

    $sql = " UPDATE web_config SET value='$lang' WHERE id=32";

    $stmt = $conn->query($sql);

    $stmt->execute();

    $_SESSION['lang']=$lang;

    header("location:" . RELA_DIR .'index.php');
}

function voucherCodeCreator()
{
    //$chars = strtoupper(substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 16))

    $guid = '';
    $uid = uniqid("", true);
    $data = '';
    $data .= $_SERVER['REQUEST_TIME'];
    $data .= $_SERVER['HTTP_USER_AGENT'];
    $data .= $_SERVER['LOCAL_ADDR'];
    $data .= $_SERVER['LOCAL_PORT'];
    $data .= $_SERVER['REMOTE_ADDR'];
    $data .= $_SERVER['REMOTE_PORT'];
    $hash = strtoupper(hash('ripemd128', $uid . $guid . md5($data)));

    if (substr($hash, 0, 1) == '0') {
        voucherCodeCreator();
    }

    $guid = substr($hash, 0, 4) .
        substr($hash, 8, 4) .
        substr($hash, 24, 4) .
        substr($hash, 20, 4);
    return $guid;
}

function display_filesize($filesize)
{

    if (is_numeric($filesize)) {
        $decr = 1024;
        $step = 0;
        $prefix = array('بایت', 'کیلو بایت', 'مگا بایت', 'گیگا بایت', 'ترا بایت', 'پارا بایت');

        while (($filesize / $decr) > 0.9) {
            $filesize = $filesize / $decr;
            $step++;
        }

        return round($filesize, 2) . ' ' . $prefix[$step];

    } else {
        return 'NaN';
    }

}

function generatePassword($length = 9)
{
    // start with a blank password

    $password = "";

    /*
    | ------------------------------------------------------------------------------------------------------------------
    | define possible characters - any character in
    | this string can be picked for use in the
    | password, so if you want to put vowels
    | back in or add special characters
    | such as exclamation marks, this
    | is where you should do it
    | ------------------------------------------------------------------------------------------------------------------
    */
    $possible = "BCDFGHJKLMNPQRTVWXYZ";
    // we refer to the length of $possible a few times, so let's grab it now
    $maxlength = strlen($possible);
    // check for length overflow and truncate if necessary
    if ($length > $maxlength) {
        $length = $maxlength;
    }
    // set up a counter for how many characters are in the password so far
    $i = 0;
    // add random characters to $password until $length is reached
    while ($i < $length) {

        // pick a random character from the possible ones
        $char = substr($possible, mt_rand(0, $maxlength - 1), 1);
        // have we already used this character in $password?
        if (!strstr($password, $char)) {
            // no, so it's OK to add it onto the end of whatever we've already got...
            $password .= $char;
            // ... and increase the counter by one
            $i++;
        }
    }
    // done!
    return $password;
}

function generatePasswordNumber($length = 9)
{
    // start with a blank password
    $password = "";

    /*
    | ------------------------------------------------------------------------------------------------------------------
    | define possible characters - any character in
    | this string can be  picked for use in the
    | password, so if you want to put vowels
    | back in or add special characters
    | such as exclamation marks, this
    | is where you should do it
    | ------------------------------------------------------------------------------------------------------------------
    */
    $possible = "21346789";

    /*
    | ------------------------------------------------------------------------------------------------------------------
    | we refer to the length of $possible
    | a few times, so let's grab it now
    | ------------------------------------------------------------------------------------------------------------------
    */
    $maxlength = strlen($possible);

    /*
    | ------------------------------------------------------------------------------------------------------------------
    | check for length overflow and truncate if necessary
    | ------------------------------------------------------------------------------------------------------------------
    */
    if ($length > $maxlength) {
        $length = $maxlength;
    }

    /*
    | ------------------------------------------------------------------------------------------------------------------
    | set up a counter for how many characters
    | are in the password so far
    | ------------------------------------------------------------------------------------------------------------------
    */
    $i = 0;

    /*
    | ------------------------------------------------------------------------------------------------------------------
    | add random characters to $password until $length is reached
    | ------------------------------------------------------------------------------------------------------------------
    */
    while ($i < $length) {

        /*
        | ------------------------------------------------------------------------------------------------------------------
        | pick a random character from the possible ones
        | ------------------------------------------------------------------------------------------------------------------
        */
        $char = substr($possible, mt_rand(0, $maxlength - 1), 1);

        /*
        | ------------------------------------------------------------------------------------------------------------------
        | have we already used this character in $password?
        | ------------------------------------------------------------------------------------------------------------------
        */
        if (!strstr($password, $char)) {

            /*
            | ------------------------------------------------------------------------------------------------------------------
            | no, so it's OK to add it onto the end
            | of whatever we've already got...
            | ------------------------------------------------------------------------------------------------------------------
            */
            $password .= $char;

            /*
            | ------------------------------------------------------------------------------------------------------------------
            | ... and increase the counter by one
            | ------------------------------------------------------------------------------------------------------------------
            */
            $i++;
        }

    }
    // done!
    return $password;

}

function redirectPage($page, $message = [], $timer = 500)
{

    global $conn, $messageStack; ?>
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <script language="javascript">
            setTimeout("window.location='<?=$page ?>'",<?=$timer?>);
        </script>
        <style>
            body {
                font-family: sans-serif;
                background: url(<?=TEMPLATE_DIR?>images/background.png);
                line-height: 30px;
            }

            .a {
                background: url(<?=TEMPLATE_DIR?>images/back_light.png) bottom repeat-x #fff;
                border: 3px solid #ccc;
                width: 500px;
                margin-top: 10%;
                position: relative;
                padding-left: 200px;
                text-align: left;
                border-radius: 5px;
                -moz-border-radius: 5px;
                -o-border-radius: 5px;
                -webkit-border-radius: 5px;
            }

            a {
                color: #903;
                font-size: 14px
            }
        </style>
    </head>
    <body style="text-align: center;">
    <div class="a" style="margin-left: auto; margin-right: auto">
        <br>

        <?php //if($message!=''){echo $message['manager_name'];}else{ echo 'logout';} ?>
        <img src="<?= RELA_DIR . 'templates/' . CURRENT_SKIN . '/images/logo.png' ?> " align="left"
             style="position:absolute; left:40px; padding-bottom:20px; top: 15px" height="60">
        <div style="clear:both"></div>
        <a href="<?=$page ?>">If the browser did not redirect automatically click here</a>
        <small>(Loading ...)</small>
        <div style="clear:both"></div>
        <br>
    </div>
    </body>
    </html>
    <?php
    die();
}

function GetExtension($str)
{
    $i = strrpos($str, ".");

    if (!$i) {
        return "";
    }

    $l = strlen($str) - $i;
    $ext = substr($str, $i + 1, $l);
    return $ext;
}

function sendmail($email, $subject, $body, $header = '')
{
    include_once(ROOT_DIR . "common/phpmailer/class.phpmailer.php");
    //set_time_limit(3000);
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=utf-8\r\n";
    $headers .= "$header\r\n" . "Reply-To: " . SMTP_USERNAME . "\r\n" . "X-Mailer: PHP/" . phpversion();

    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->Host = SMTP_SERVER;
    $mail->SMTPAuth = true;     // turn on SMTP authentication
    $mail->Username = SMTP_USERNAME;  // SMTP username
    $mail->Password = SMTP_PASSWORD; // SMTP password
    $mail->From = SMTP_USERNAME;
    $mail->FromName = SMTP_SENDER;
    $mail->IsHTML(true);
    $mail->SetLanguage("en", ROOT_DIR . "common/phpmailer/");
    $mail->Subject = $subject;
    $mail->Body = $body;
    $mail->AltBody = $body;
    $mail->ClearAddresses();
    $mail->AddAddress($email);

    if (!$mail->Send()) {
        //echo "<div class='fadeout'>Message was not sent";
        // echo "Mailer Error: " . $mail->ErrorInfo . "</div>";
        return 0;
    }

    return 1;
}

function sendmails($email, $bcc, $subject, $body, $orderID, $header = '')
{
    include_once(ROOT_DIR . "common/phpmailer/class.phpmailer.php");

    //set_time_limit(3000);
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=utf-8\r\n";
    $headers .= "$header\r\n" . "Reply-To: " . SMTP_USERNAME . "\r\n" . "X-Mailer: PHP/" . phpversion();

    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->Host = SMTP_SERVER;
    $mail->SMTPAuth = true;     // turn on SMTP authentication
    $mail->Username = SMTP_USERNAME;  // SMTP username
    $mail->Password = SMTP_PASSWORD; // SMTP password
    $mail->From = SMTP_USERNAME;
    $mail->FromName = SMTP_SENDER;
    $mail->IsHTML(true);
    $mail->SetLanguage("en", ROOT_DIR . "common/phpmailer/");
    $mail->Subject = $subject;
    $mail->Body = $body;
    $mail->AltBody = $body;
    $mail->ClearAddresses();
    $mail->AddAddress($email);

    // foreach to bcc emails to add address
    foreach ($bcc as $mails) {
        $mail->AddBCC($mails);
    }

    // attach pdf file
    $mail->AddAttachment(ROOT_DIR . "pdf/" . $orderID . ".pdf", "orderNo_" . $orderID . ".pdf");

    if (!$mail->Send()) {
        return 0;
    }
    return 1;
}

function convertDate($date)
{
    include_once("jdf.php");
    list($date, $time) = explode(" ", $date);
    list($g_y, $g_m, $g_d) = explode("-", $date);
    list($j_y, $j_m, $j_d) = gregorian_to_jalali($g_y, $g_m, $g_d);
    list($h, $m, $s) = explode(":", $time);

    $date = "$j_y/$j_m/$j_d";
    return $date;
}

function convertJToGDate($date)
{
    include_once("jdf.php");
    $dateTime = explode("/", $date);
    $g_y = $dateTime[0];
    $g_m = $dateTime[1];
    $g_d = $dateTime[2];
    list($j_y, $j_m, $j_d) = jalali_to_gregorian($g_y, $g_m, $g_d);

    $date = "$j_y-$j_m-$j_d";
    return $date;
}

function round_func($x)
{
    $len = strlen($x);
    if (substr($x, $len - ($len - 1), 1) < 5) {
        return (substr($x, 0, $len - ($len - 1)) . 5) * pow(10, $len - 2);
    } else {
        return round($x, ((strlen($x)) * -1));
    }
}

function handleData($data)
{
    return stripslashes(trim($data));
}

function checkSite($site)
{
    if (eregi("^[a-z\-\.]+[a-z0-9_\-]+\.[a-z0-9_\-\.]+$", $site)) {
        return 0;
    } else {
        return 1;
    }
}

function handleSQLData($data)
{
    $myData = str_replace("'", "''", $data);
    if (DB_TYPE == "mysql") {
        $myData = str_replace("\\", "\\\\", $myData);
    }

    return $myData;
}

function handleSql($theValue)
{
    if (PHP_VERSION < 6) {
        $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
    }

    $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);
    return $theValue;
}

function checkSystemStatus()
{
    if (SYSTEM_STATUS == 1) {
        include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/system.stop.php");
        die();
    }
}

function checkMail($email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return 0;
    } else {
        return 1;
    }
}

function inputCheckNumericId($ascii)
{
    if (preg_match("/^[0-9,]+$/i", $ascii)) {
        return 1;
    } else {
        return 0;
    }
}

function inputCheckEmails($ascii)
{
    if (preg_match("/^[a-zA-Z0-9@_.,\-]+$/i", $ascii)) {
        return 1;
    } else {
        return 0;
    }
}

function checkJoinMail($email)
{
    if (preg_match("/^[A-Z0-9._%-]+@[A-Z0-9][A-Z0-9.-]{0,61}[A-Z0-9]\.[A-Z]{2,6}$/i", $email)) {
        return 0;
    } else {
        return 1;
    }
}

function checkAscii($ascii)
{
    if (ereg("^[a-zA-Z0-9\.\,\+\!\@\#\$\%\^\&\*\(\)\:\~\/]+$", $ascii)) {
        return 0;
    } else {
        return 1;
    }
}

function checkUser($ascii)
{
    if (ereg("^[a-zA-Z0-9\-\_]+$", $ascii)) {
        return 0;
    } else {
        return 1;
    }

}

function checkDescription($alpha)
{
    if (ereg("^[a-zA-Z0-9\s ]+$", $alpha)) {
        return 1;
    } else {
        return 0;
    }

}

function checkAlpha($alpha)
{
    if (ereg("^[a-zA-Z ]+$", $alpha)) {
        return 0;
    } else {
        return 1;
    }
}

function checkLength($str, $length)
{
    if (strlen($str) > $length) {
        return -1;
    }
    return 0;
}

function checkNumeric($num)
{
    if (ereg("^[0-9]+$", $num)) {
        return 0;
    } else {
        return 1;
    }
}

function getDatetime()
{
    return date("Y-m-d H:i:s");
}

function getDateo()
{
    return date("Y-m-d");
}

function generate_password()
{
    $fillers = "1234567890!@#$%&*-_=+^";
    $fillers .= date('h-i-s, j-m-y, it is w Day z ');
    $fillers .= "123!@#$%&*-_4567!@#$%&*-_890=+^";
    $temp = md5($fillers);
    $temp = substr($temp, 5, 10);

    return $temp;
}

/*
| ------------------------------------------------------------------------------------------------------------------
| Interface operation
| ------------------------------------------------------------------------------------------------------------------
*/

function initPage($rs, $pageSize, &$currentPage, &$pageCount, &$totalRecord)
{
    $totalRecord = $rs->RecordCount();
    $pageCount = $totalRecord / $pageSize;

    if (!is_int($pageCount)) {
        $pageCount = intval($pageCount);
        $pageCount += 1;
    }

    $currentPage = intval($currentPage);

    if ($currentPage < 1) {
        $currentPage = 1;
    }

    if ($currentPage > $pageCount) {
        $currentPage = $pageCount;
    }

}

function showPageButton($currentPage, $pageCount, $totalRecord, $webaddress, $n = '')
{
    ?>
    <div class="pagination">
        <?php
        if ($currentPage > 1) {
            if ($currentPage < $pageCount) {
                ?>
                <a href="<?= $webaddress ?>&currentPage<?= $n ?>=1" title="">&laquo; First</a>
                <a href="<?= $webaddress ?>&currentPage<?= $n ?>=<?= $currentPage - 1 ?>" title="">&laquo; pre</a>
                <?php
                for ($i = $currentPage - 2; $i < $currentPage + 3; $i++) {
                    if ($i < 1 || $i > $pageCount) continue;
                    ?>
                    <a href="<?= ($i != $currentPage ? $webaddress . '&currentPage' . $n . '=' . $i : 'javascript:;') ?>"
                       class="number <?= ($i != $currentPage ? '' : 'current') ?>"><?= $i ?></a>
                    <?php
                }
                ?>
                <a href="<?= $webaddress ?>&currentPage<?= $n ?>=<?= $currentPage + 1 ?>" title="">Next Page &raquo;</a>
                <a href="<?= $webaddress ?>&currentPage<?= $n ?>=<?= $pageCount ?>" title="">Last &raquo;</a>
                <?php
            } else {
                ?>
                <a href="<?= $webaddress ?>&currentPage<?= $n ?>=1" title="">&laquo; First</a>
                <a href="<?= $webaddress ?>&currentPage<?= $n ?>=<?= $currentPage - 1 ?>" title="">&laquo; Previous
                    Page</a>

                <?php
                for ($i = $currentPage - 2; $i < $currentPage + 3; $i++) {
                    if ($i < 1 || $i > $pageCount) continue;
                    ?>
                    <a href="<?= ($i != $currentPage ? $webaddress . '&currentPage' . $n . '=' . $i : 'javascript:;') ?>"
                       class="number <?= ($i != $currentPage ? '' : 'current') ?>" title=""><?= $i ?></a>
                    <?php
                }
                ?>
                <a href="javascript:" title="">Next Page &raquo;</a>
                <a href="javascript:" title="">Last &raquo;</a>
                <?php
            }
        } else {
            if ($currentPage < $pageCount) {
                ?>
                <a href="javascript:" title="">&laquo; First</a>
                <a href="javascript:" title="">&laquo; Previous Page</a>
                <?php
                for ($i = $currentPage - 2; $i < $currentPage + 3; $i++) {
                    //die('1');
                    if ($i < 1 || $i > $pageCount) continue;
                    ?>
                    <a href="<?= ($i != $currentPage ? $webaddress . '&currentPage' . $n . '=' . $i : 'javascript:;') ?>"
                       class="number <?= ($i != $currentPage ? '' : 'current') ?>"><?= $i ?></a>
                    <?php
                }
                ?>
                <a href="<?= $webaddress ?>&currentPage<?= $n ?>=<?= $currentPage + 1 ?>" title="">Next Page &raquo;</a>

                <a href="<?= $webaddress ?>&currentPage<?= $n ?>=<?= $pageCount ?>" title="">Last &raquo;</a>
                <?php
            } else {
                ?>
                <a href="javascript:" title="">&laquo; First</a>
                <a href="javascript:" title="">&laquo; Previous Page</a>
                <?php
                for ($i = $currentPage - 2; $i < $currentPage + 3; $i++) {
                    if ($i < 1 || $i > $pageCount) continue;
                    ?>
                    <a href="<?= ($i != $currentPage ? $webaddress . '&currentPage' . $n . '=' . $i : 'javascript:;') ?>"
                       class="number <?= ($i != $currentPage ? '' : 'current') ?>"><?= $i ?></a>
                    <?php
                }
                ?>
                <a href="javascript:" title="">Next Page &raquo;</a>
                <a href="javascript:" title="">Last &raquo;</a>
                <?php
            }
        }
        ?>
    </div> <!-- End .pagination -->
    <div class="clear"></div>
    <?php

}

function showPageButtonSeo($currentPage, $pageCount, $totalRecord, $webaddress)
{
    ?>
    <div class="pagination">
        <?php
        if ($currentPage > 1) {

            if ($currentPage < $pageCount) {
                ?>
                <a href="<?= $webaddress ?>PG-1" title="ابتدا">&laquo; ابتدا</a>
                <a href="<?= $webaddress ?>PG-<?= $currentPage - 1 ?>" title="صفحه قبلی">&laquo; صفحه قبلی</a>
                <?php
                for ($i = $currentPage - 2; $i < $currentPage + 3; $i++) {
                    if ($i < 1 || $i > $pageCount) continue;
                    ?>
                    <a href="<?= ($i != $currentPage ? $webaddress . 'PG-' . $i : 'javascript:;') ?>"
                       class="number <?= ($i != $currentPage ? '' : 'current') ?>" title="<?= $i ?>"><?= $i ?></a>
                    <?php
                }
                ?>
                <a href="<?= $webaddress ?>PG-<?= $currentPage + 1 ?>" title="صفحه بعدی">صفحه بعدی &raquo;</a>
                <a href="<?= $webaddress ?>PG-<?= $pageCount ?>" title="انتها">انتها &raquo;</a>
                <?php
            } else {
                ?>
                <a href="<?= $webaddress ?>PG-1" title="ابتدا">&laquo; ابتدا</a>
                <a href="<?= $webaddress ?>PG-<?= $currentPage - 1 ?>" title="صفحه قبلی">&laquo; صفحه قبلی</a>
                <?php
                for ($i = $currentPage - 2; $i < $currentPage + 3; $i++) {
                    if ($i < 1 || $i > $pageCount) continue;
                    ?>
                    <a href="<?= ($i != $currentPage ? $webaddress . 'PG-' . $i : 'javascript:;') ?>"
                       class="number <?= ($i != $currentPage ? '' : 'current') ?>" title="<?= $i ?>"><?= $i ?></a>
                    <?php
                }
                ?>
                <a href="javascript:" title="صفحه بعدی">صفحه بعدی &raquo;</a>
                <a href="javascript:" title="انتها">انتها &raquo;</a>
                <?php
            }
        } else {
            if ($currentPage < $pageCount) {
                ?>
                <a href="javascript:" title="ابتدا">&laquo; ابتدا</a>
                <a href="javascript:" title="صفحه قبلی">&laquo; صفحه قبلی</a>
                <?php
                for ($i = $currentPage - 2; $i < $currentPage + 3; $i++) {
                    if ($i < 1 || $i > $pageCount) continue;
                    ?>
                    <a href="<?= ($i != $currentPage ? $webaddress . 'PG-' . $i : 'javascript:;') ?>"
                       class="number <?= ($i != $currentPage ? '' : 'current') ?>" title="<?= $i ?>"><?= $i ?></a>
                    <?php
                }
                ?>
                <a href="<?= $webaddress ?>PG-<?= $currentPage + 1 ?>" title="صفحه بعدی">صفحه بعدی &raquo;</a>
                <a href="<?= $webaddress ?>PG-<?= $pageCount ?>" title="انتها">انتها &raquo;</a>
                <?php
            } else {
                ?>
                <a href="javascript:" title="ابتدا">&laquo; ابتدا</a>
                <a href="javascript:" title="صفحه قبلی">&laquo; صفحه قبلی</a>
                <?php
                for ($i = $currentPage - 2; $i < $currentPage + 3; $i++) {
                    if ($i < 1 || $i > $pageCount) continue;
                    ?>
                    <a href="<?= ($i != $currentPage ? $webaddress . 'PG-' . $i : 'javascript:;') ?>"
                       class="number <?= ($i != $currentPage ? '' : 'current') ?>" title="<?= $i ?>"><?= $i ?></a>
                    <?php
                }
                ?>
                <a href="javascript:" title="صفحه بعدی">صفحه بعدی &raquo;</a>
                <a href="javascript:" title="انتها">انتها &raquo;</a>
                <?php
            }
        }
        ?>
    </div> <!-- End .pagination -->
    <div class="clear"></div>
    <?php
}

function showErrorMsg($msg)
{
    global $conn;
    include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/title.inc.php");
    include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/system.error.php");
    include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/tail.inc.php");
    die();
}

function showAdminErrorMsg($msg)
{
    include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/admin.title.inc.php");
    include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/system.error.php");
    include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/admin.tail.inc.php");
    die();
}

function showAlertMsg($msg)
{
    if ($msg != "") {
        ?>
        <div class="alert border">
            <a href="#" class="close" style="display:block"><img
                        src="<?php echo RELA_DIR ?>templates/<?php echo CURRENT_SKIN ?>/images/alert.png" align="left"
                        title="Close this notification" alt="close"/></a>
            <span><?= $msg ?></span>
        </div>
        <?php
    }
}

function showWarningMsg($msg)
{
    if ($msg) {
        ?>
        <div class="notification error png_bg">
            <a class="close" href="#"><img alt="close" title="Close this notification"
                                           src="<?= TEMPLATE_DIR ?>admin/images/cross_grey_small.png"></a>
            <div>
                <?= $msg ?>
            </div>
        </div>
        <?php
    }
}

function showMsg($redirect)
{
    if ($redirect) {
        ?>
        <div class="notification png_bg">
            <div class="success">
                <a href="#" class="close"><img
                            src="<?php echo RELA_DIR ?>templates/<?php echo CURRENT_SKIN ?>/admin/images/icons/cross_grey_small.png"
                            title="Close this notification" alt="close"/></a>
                <div>
                    <?= $redirect ?>
                </div>
            </div>
        </div>
        <?php
    }
}

function showWarningMsg1($msg)
{
    if ($msg) {
        ?>
        <div class="fadeout"><?php echo $msg ?></div>
        <?php
    }

}

//*********************************************Alizadeh***************************************************************

function monthToYear($month)
{
    if ($month >= 12) {
        $year = intval($month / 12);
        $month = $month % 12;
        $result = $year . ' Year ';
        if ($month != 0) {
            $result = $result . ' .  ' . $month . ' Month ';
        }
    } else {
        $result = $month . ' Month ';
    }

    return ($result);
}

function mobileChecker($prefix, $number)
{

    if ($prefix == '+964') {
        if (strlen($number) != 10) {
            $return['result'] = -1;
            $return['msg'] = 'Please enter your mobile number correctly.';
        }
    } else {
        $return['result'] = 1;
        $return['msg'] = 'ok';
    }

    return $return;
}

function ipChecker($ip)
{
    if (!filter_var($ip, FILTER_VALIDATE_IP)) {
        $return['result'] = -1;
        $return['msg'] = 'IP is not valid.';

    } else {
        $return['result'] = 1;
        $return['msg'] = 'IP is valid';
    }

    return $return;
}

//************************************************************************************************************

function encrypt($string, $key)
{
    $result = '';
    for ($i = 0; $i < strlen($string); $i++) {
        $char = substr($string, $i, 1);
        $keychar = substr($key, ($i % strlen($key)) - 1, 1);
        $char = chr(ord($char) + ord($keychar));
        $result .= $char;
    }

    return base64_encode($result);
}

function decrypt($string, $key)
{
    $result = '';
    $string = base64_decode($string);

    for ($i = 0; $i < strlen($string); $i++) {
        $char = substr($string, $i, 1);
        $keychar = substr($key, ($i % strlen($key)) - 1, 1);
        $char = chr(ord($char) - ord($keychar));
        $result .= $char;
    }

    return $result;
}

function showAccessError()
{
    //$path=$_SERVER['HTTP_REFERER'];
    $path = RELA_DIR;
    ?>
    <script type="text/javascript">
        alert('You do not have the proper permission to view his page.');
        window.location = '<?php echo $path ?>';
    </script>
    <?php
    die();
}
function dd($input,$die=1)
{
    echo '<pre/>';
    print_r($input);
    echo '*****************************';
    if($die==1)
    {
        die();
    }
}
function middleware()
{
    global $jwt_info;

    $headers=getallheaders();
    $headers['Authorization'];
    $result = jwtChecker($headers['Authorization']);
    if(!is_object($result))
    {
        Response::json('',401);
        die();
    }
    $jwt_info=$result->data->data;
    return;
}


function jwtChecker($authorization)
{

    $jwt=substr($authorization,7,strlen($authorization));
    require_once('../vendor/autoload.php');

    $key = 'hr123';
    //$key = JWT_KEY;
    /*$payload = array(
        "iss" => "http://example.org",
        "aud" => "http://example.com",
        "iat" => 1356999524,
        "nbf" => 1357000000
    );*/

    /**
     * IMPORTANT:
     * You must specify supported algorithms for your application. See
     * https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40
     * for a list of spec-compliant algorithms.
     */
    //$jwt = JWT::encode($payload, $key);
    //$jwt = 'eyJhbGc1iOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOnsiaWQiOjEsIm5hbWUiOiJhZG1pbiIsImVtYWlsIjoiYWRtaW5AYWRtaW4uY29tIiwiZW1haWxfdmVyaWZpZWRfYXQiOm51bGwsImNyZWF0ZWRfYXQiOiIyMDIwLTA0LTI1VDA2OjM5OjAwLjAwMDAwMFoiLCJ1cGRhdGVkX2F0IjoiMjAyMC0wNC0yNVQwNjozOTowMC4wMDAwMDBaIn0sImlhdCI6MTU5MTc5MjExMH0.3M4rxpF59kI_b7ke4uAVqYG-Qytm3rnc0zFO9NvZK90';
    //$check='eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJuYW1lIjoiYWRtaW4iLCJlbWFpbCI6ImFkbWluQGFkbWluLmNvbSIsImlhdCI6MTM1Njk5OTUyNCwibmJmIjoxMzU3MDAwMDAwfQ.I4jY1qWoCcLW_HOLrLoADcNdOtjKou68LUwMQQGc3aA';
    //$key='project123';

    $decoded = JWT::decode($jwt, $key, array('HS256'));
    //$decoded = JWT::decode($jwt,"project123", ['HS256']);
    return $decoded;
}

function checkPermissions($action, $file_name = '')
{

    global $admin_info, $member_info;



    if ($admin_info['type'] == 2 and $_SERVER['REQUEST_URI']!="/queue.php?action=showLiveQueue") {
        redirectPage (RELA_DIR . "queue.php?action=showLiveQueue", "");
    }

    //return 1;

    include_once(ROOT_DIR . "component/admin.permission.class.php");
    //$newob = clsPermissionsPage::getByName($file_name);
    $PagePermission=getAllPermisssion();
    //print_r_debug($PagePermission);


    $script				=	pathinfo($_SERVER['SCRIPT_NAME'],PATHINFO_FILENAME);
    //print_r_debug($script);
    $admin_permission	=	$admin_info['permission_pbx'];//'101111101';
    //print_r_debug($admin_permission);

    //$newObj=unserialize($PagePermission[$script]);
    $newObj=$PagePermission[$script];
    //print_r_debug($PagePermission[$script]);

    //print_r_debug($newObj);
    // print_r_debug($PagePermission);
    if (!is_object($newObj)) {
        die($newObj['msg']);
    }
// /print_r($newObj);die();
    unset($PagePermission);
    //echo $action;
    //print_r_debug($action);

    $return	= $newObj->check($action,$admin_permission);
    //print_r_debug($return);
    //$return['result']  =1;


    if ($return['result'] != 1) {
        showAccessError();
        return -1;
    }

    return 1;
}

function checkPermissionsUI($pageName,$action)
{
    global $admin_info;
    $admin_permission=$admin_info['permission_pbx'];
    include_once(ROOT_DIR . "component/admin.permission.class.php");

    $PagePermission=getAllPermisssion();


    $newObj=$PagePermission[$pageName];

    unset($PagePermission);
    $return	= $newObj->check($action,$admin_permission);

    if ($return['result'] != 1) {
        return 0;
    }

    return 1;
}

function applicationData()
{
    $contentType = explode(';', $_SERVER['CONTENT_TYPE']); // Check all available Content-Type
    $rawBody = file_get_contents("php://input"); // Read body

    $data = array(); // Initialize default data array

    if(in_array('application/json', $contentType)) { // Check if Content-Type is JSON

        if($_SERVER['REQUEST_METHOD']=="POST")
        {
            $_POST = (array) json_decode($rawBody); // Then decode it
        }

    }
}


function checkDisplayUi()
{
    $list= array();

    $list['trunk']=checkPermissionsUI('trunk','showAllTrunk');

    $list['routing']=checkPermissionsUI('routing','showAllRouting');

    $list['loginAs']=checkPermissionsUI('loginAs','showloginAs');

    $list['announce']=checkPermissionsUI('announce','showAllAnnounce');

    $list['report']=checkPermissionsUI('report','showReport');

    $list['extension']=checkPermissionsUI('extension','showAllExtensions');

    $list['conference']=checkPermissionsUI('conference','showAllConference');

    $list['sip']=checkPermissionsUI('sip','showAllSip');

    $list['queue']=checkPermissionsUI('queue','showAllQueues');

    $list['outbound']=checkPermissionsUI('outbound','showAllOutbound');

    $list['inbound']=checkPermissionsUI('inbound','showAllInbound');

    $list['ivr']=checkPermissionsUI('ivr','showAllIvr');

    $list['mainTimeCondition']=checkPermissionsUI('mainTimeCondition','showAllTimeCondition');

    $list['upload']=checkPermissionsUI('upload','showAllUpload');

    $list['adminList']=checkPermissionsUI('admin.list','showAllAdminList');

    $list['voipconfig']=checkPermissionsUI('voipconfig','showAllVoipconfig');

    $list['company']=checkPermissionsUI('company','showAllCompany');

    $list['record']=checkPermissionsUI('record','showAllRecord');

    $list['SuperAdmin']=checkPermissionsUI('SuperAdmin','showAllSuperAdmin');

    $list['extension']=checkPermissionsUI('extension','showAllExtensions');
    
    return $list;
}

function get_group_info_date($p_id)
{
    global $conn,$member_info,$lang;
    $sql = "select * from  internet_detail  where product_id ='$p_id' ";

    $internet_detail_rs = $conn->Execute($sql);
    if (!$internet_detail_rs) {
        $return['result'] = 0;
        $return['err'] = '400';
        $return['msg'] = 'DB Error';
        return $return;
    }

    $return['result'] = 1;
    $return['err'] = '0';
    $return['msg'] = 'successful';
    $return['rs'] = $internet_detail_rs->fields;
    return $return;
}
function convertPersianToEnglish($inputArray) {
    $persianChars = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
    $englishChars = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');

    foreach ($inputArray as &$input) {
        $input = str_replace($persianChars, $englishChars, $input);
    }

    return $inputArray;
}
function convertPersianNumbersToEnglish($input) {
    $persianNumbers = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
    $englishNumbers = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');

    $output = str_replace($persianNumbers, $englishNumbers, $input);
    return $output;
}
function checkForPersianWordsInMultiDimensionalKeyValueArray($inputArray) {
    foreach ($inputArray as $key => $value) {
        if (is_array($value)) {
            $result = checkForPersianWordsInMultiDimensionalKeyValueArray($value);
            if ($result == -1) {
                return -1; // حداقل یکی از مقادیر در ارایه چند بعدی حاوی کلمه‌های فارسی است
            }
        } else {
            // تقسیم مقدار به کلمات
            $words = preg_split('/\s+/', $value);

            foreach ($words as $word) {
                if (preg_match('/[\x{0600}-\x{06FF}\x{FB50}-\x{FDFF}\x{FE70}-\x{FEFF}]/u', $word)) {
                    return -1; // حداقل یکی از کلمات در مقادیر حاوی کلمه‌های فارسی است
                }
            }
        }
    }
    return 0; // هیچ کلمه‌ای فارسی در مقادیر ارایه نیست
}

