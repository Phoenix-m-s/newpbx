<?php
class AstMan {

    public $socket;
    public $error;
    public $amiHost = "";
    public $amiPort = "";
    public $amiUsername = "";
    public $amiPassword = "";

    function __constructor() {
        $this -> socket = false;
        $this -> error = "";
    }
    function logAMI($message, $isSuccessful) {
        global $company_info;
        // مسیر فایل لاگ
        if (!file_exists('voip/'.$company_info['comp_name'].'/log/')) {
            mkdir('voip/'.$company_info['comp_name'].'/'.'log/', 0777, true);

        }
        $logFilePath =  'voip/'.$company_info['comp_name'].'/'.'log/ami.txt';;

        // سطح لاگ‌گذاری: INFO برای موفقیت و ERROR برای خطا
        $logLevel = $isSuccessful ? 'INFO' : 'ERROR';

        // تاریخ و زمان کنونی
        $dateTime = date('Y-m-d H:i:s');

        // متن کامل لاگ (تاریخ و زمان + سطح + پیام)
        $logMessage = "[$dateTime] [$logLevel] $message\n";

        // ایجاد یا باز کردن فایل لاگ
        $fileHandle = fopen($logFilePath, 'a');


        // نوشتن لاگ در فایل
        fwrite($fileHandle, $logMessage);

        // بستن فایل لاگ
        fclose($fileHandle);
    }


    function Login() {
        $this -> socket = @fsockopen($this -> amiHost,$this -> amiPort, $errno, $errstr, 1);
        if (!$this -> socket) {
            $this -> error =  "Could not connect: $errstr ($errno)";
            $this->logAMI(  $this -> error ,false);
            return false;
        } else {

            stream_set_timeout($this->socket, 1);
            $amiUsername = $this->amiUsername;
            $amiPassword = $this->amiPassword;
            $wrets = $this->Query("Action: Login\r\nUserName: $amiUsername\r\nSecret: $amiPassword\r\nEvents: off\r\n\r\n");
            if (strpos($wrets, "Message: Authentication accepted") !== false) {
                $this->logAMI('Message: Authentication accepted',true);
                return true;
            } else {
                $this->error = ModelPHP_AMI_01;
                $this->logAMI(ModelPHP_AMI_01, false);
                fclose($this -> socket);
                $this->socket = false;
                return false;
            }
        }
    }

    function Logout() {
        if ($this->socket) {
            fputs($this->socket, "Action: Logoff\r\n\r\n");
            while (!feof($this->socket)) {
                $wrets .= fread($this->socket, 8192);
            }
            $this->logAMI($this->socket,true);
            fclose($this->socket);
            $this->socket = false;
        }
        return;
    }

    function Query($query) {
        $wrets = "";
        if ($this->socket === false) {
            $this->error = ModelPHP_AMI_02;
            $this->logAMI($this->error,false);
            return false;
        }

        fputs($this->socket, $query);

        do {
            $line = fgets($this->socket, 4096);
            $wrets .= "<br>".$line;
            $info = stream_get_meta_data($this->socket);
        } while ($line != "\r\n" && $info["timed_out"] === false );
        return $wrets;
    }

    function quesStatus()
    {

        $query = "Action: Command\r\nCommand: queue show\r\n\r\n";
        //$query = "Action: QueueStatus\r\n\r\n";

        $wrets = "";

        if ($this->socket === false) {
            //print_r($this->error );
            //die();

            $this->error = ModelPHP_AMI_02;
            $this->logAMI(ModelPHP_AMI_02,false);
            return false;
        }

        // die('ok');


        fputs($this->socket, $query);
        // fputs($this->socket, "queue: 100\r\n\r\n");


        do {
            $line = fgets($this->socket, 4096);
            //print_r($line);
            //echo '<br/>1<br/>';
            $wrets[]= $line;
            $info = stream_get_meta_data($this->socket);

        } while ($line != "\r\n" && $info["timed_out"] === false );

        echo '<pre/>';
        unset($wrets[0]);
        unset($wrets[1]);
        print_r($wrets);

        $start=1;
        $startMember=0;
        foreach ($wrets as $key => $val)
        {

            if(trim($val)=='')
            {
                $start=1;
                continue;
            }
            if($start==1)
            {
                $temp=explode(' ',$val);
                $list[$temp[0]]='';
                $start=0;

            }
            if(trim($val)=='Members:')
            {
                $startmember=1;
                continue;
            }
            if($startmember==1){

            }

        }
        print_r_debug($list);

        die();
        $myList=explode('\n',$wrets);
        print_r_debug($myList);
        die();
        return $wrets;




    }

    function addForward($data)
    {
        //Command("Action: Command\r\nCommand: database put Ext $exten/Dst/ $value_opt\r\n\r\n");
        //Command("Action: Command\r\nCommand: database put Ext extension_no/Dst/Finternal|Fexternal $value_opt\r\n\r\n");
        //Ext/201/Dst/Fexternal/09123063658
        //Ext/201/Dst/Finternal/201
        //$extensionData = $extension->getAllSipInfo();
        $query = "Action: Command\r\nCommand: database deltree Ext\r\n\r\n";
        $wrets = "";

        if ($this->socket === false) {
            $this->error = ModelPHP_AMI_02;
            $this->logAMI($this->error,false);
            return false;
        }

        fputs($this->socket, $query);

        do {
            $line = fgets($this->socket, 4096);
            $wrets .= $line;
            $info = stream_get_meta_data($this->socket);
        } while ($line != "\r\n" && $info["timed_out"] === false );



        echo 'responce delete:';
        print_r($wrets);
        echo '<br/> <br/>';
        $wrets = "";

        foreach ($data as $k=>$fields)
        {


            //print_r_debug($fields);
            if($fields['dst_option_id']=='9')
            {
                if ($this->socket === false) {
                    $this->error = ModelPHP_AMI_02;
                    $this->logAMI($this->error,false);
                    return false;
                }
                $query = "Action: Command\r\nCommand: database put Ext ".$fields['extension_no'].'-'.$fields['comp_name'];
                //continue;
                if($fields['dst_option_sub_id']=='1')
                {
                    $extension = new Extention_fileGenerator(1);

                    $resultForward = $extension->getExtensionById($fields['DSTOption'])['rs']->fetch();

                    $query=$query."/Dst/Finternal ".$resultForward['extension_no']."\r\n\r\n";

                }elseif($fields['dst_option_sub_id']=='2')
                {
                    $query=$query."/Dst/Fexternal ".$fields['DSTOption']."\r\n\r\n";
                }

                fputs($this->socket, $query);

                $wrets = "";

                do {
                    $line = fgets($this->socket, 4096);
                    $wrets .= $line;
                    $info = stream_get_meta_data($this->socket);
                } while ($line != "\r\n" && $info["timed_out"] === false );

                echo '$query-'.$k.': ';
                print_r($query);
                echo '';
                echo 'responce $query:';
                print_r($wrets);
                echo '<br/> <br/>';
            }
            $wrets = "";





            if($fields['internal_recording']=='1')
            {
                if ($this->socket === false) {
                    $this->error = ModelPHP_AMI_02;
                    $this->logAMI($this->error,false);
                    return false;
                }
                $query = "Action: Command\r\nCommand: database put Ext ".$fields['extension_no'].'-'.$fields['comp_name']."/Rec/Internal yes\r\n\r\n";
                fputs($this->socket, $query);
                $wrets = "";

                do {
                    $line = fgets($this->socket, 4096);
                    $wrets .= $line;
                    $info = stream_get_meta_data($this->socket);
                } while ($line != "\r\n" && $info["timed_out"] === false );

                echo '$query-'.$k.': ';
                print_r($query);
                echo '';
                echo 'responce $query:';
                print_r($wrets);
                echo '<br/> <br/>';

                //print_r($info);


            }

            if($fields['external_recording']=='1')
            {
                if ($this->socket === false) {
                    $this->error = ModelPHP_AMI_02;
                    $this->logAMI($this->error,false);
                    return false;
                }
                $query = "Action: Command\r\nCommand: database put Ext ".$fields['extension_no'].'-'.$fields['comp_name']."/Rec/External yes\r\n\r\n";
                fputs($this->socket, $query);
                $wrets = "";

                do {
                    $line = fgets($this->socket, 4096);
                    $wrets .= $line;
                    $info = stream_get_meta_data($this->socket);
                } while ($line != "\r\n" && $info["timed_out"] === false );

                echo '$query-'.$k.': ';
                print_r($query);
                echo '';
                echo 'responce $query:';
                print_r($wrets);
                echo '<br/> <br/>';
                //print_r($info);
            }



        }
        $this->logAMI($wrets,true);
        return $wrets;


    }

    function Reload() {

        $query = "Action: Command\r\nCommand: Reload\r\n\r\n";
        $wrets = "";

        if ($this->socket === false) {
            //print_r($this->error );
            //die();

            $this->error = ModelPHP_AMI_02;
            $this->logAMI(ModelPHP_AMI_02,false);
            return false;
        }
        // die('ok');


        fputs($this->socket, $query);

        do {
            $line = fgets($this->socket, 4096);
            $wrets .= $line;
            $info = stream_get_meta_data($this->socket);

        } while ($line != "\r\n" && $info["timed_out"] === false );
        $this->logAMI($wrets,true);
        return $wrets;
    }

    function GetUsers() {
        $query = "Action: SIPpeers\r\n\r\n";
        $wrets = "";

        if ($this->socket === false) {
            $this->error = ModelPHP_AMI_02;
            $this->logAMI($this->error,false);
            return false;
        }

        fputs($this->socket, $query);

        do {
            $line = fgets($this->socket, 4096);
            $wrets .= $line;
            $info = stream_get_meta_data($this->socket);
        } while ($line != "Event: PeerlistComplete\r\n" && $info["timed_out"] === false);
        $this->logAMI($wrets,true);
        return $wrets;
    }
    function getOnlineSip() {
        $query = "Action: SIPpeers\r\n\r\n";
        $wrets = "";

        if ($this->socket === false) {
            $this->error = ModelPHP_AMI_02;
            $this->logAMI($this->error,false);
            return false;
        }

        fputs($this->socket, $query);

        do {
            $line = fgets($this->socket, 4096);
            $wrets[]= $line;
            //$wrets .= $line;
            $info = stream_get_meta_data($this->socket);
        } while ($line != "Event: PeerlistComplete\r\n" && $info["timed_out"] === false);
        $this->logAMI($wrets,true);
        return $wrets;
    }
    function getOnlineUserConference($number) {
        //$query = "Action: SIPpeers\r\n\r\n";
        $query = "Action: ConfbridgeList\r\nConference: ".$number."\r\n\r\n";
        //print_r_debug($query);

        $wrets = "";

        if ($this->socket === false) {
            $this->error = ModelPHP_AMI_02;
            $this->logAMI($this->error,false);
            return false;
        }

        fputs($this->socket, $query);

        do {

            $line = fgets($this->socket, 4096);

            $wrets[]= $line;

            //$wrets .= $line;
            $info = stream_get_meta_data($this->socket);
        } while ($line != "Event: PeerlistComplete\r\n" && $info["timed_out"] === false);

        return $wrets;
    }

    function AddUser($user, $type, $dir) {
        if ($user && $type && $dir) {
            echo $dir;
            if (!file_exists($dir)) {
                die('nist');
            }

            $file = fopen($dir, "a+");

            switch ($type) {
                case "webrtc":
                    $str = "[".$user."]\n type=peer\n username=".$user."\n host=dynamic\n secret=".$user."\n context=default\n hasiax = no\n hassip = yes\n encryption = yes\n avpf = yes\n icesupport = yes\n videosupport=no\n directmedia=no\n nat=yes\n qualify=yes\n\n";
                    break;
                case "sip":
                    $str = "[".$user."]\n type=peer\n username=".$user."\n host=dynamic\n secret=".$user."\n context=default\n hasiax = no\n hassip = yes\n nat=yes\n\n";
                    break;
            }

            $this->logAMI($str,true);
            fwrite($file, $str);
            fclose($file);
            return true;
        } else {
            $this->error = ModelPHP_AMI_03;
            $this->logAMI($this->error,false);
            return false;
        }
    }

    function AddExtension($user, $dir) {
        if ($user && $dir) {
            $file = fopen($dir, "a+");
            $str = "exten => " . $user . ",1,Dial(SIP/" . $user . ")\n";
            $this->logAMI($str,false);
            fwrite($file, $str);
            fclose($file);
            return true;
        } else {
            $this->error = ModelPHP_AMI_03;
            $this->logAMI($this->error,false);
            return false;
        }
    }

    function GetError() {
        $this->logAMI($this->error,false);
        return $this->error;
    }
}