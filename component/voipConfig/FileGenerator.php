<?php
/**
 * Created by PhpStorm.
 * User: ali
 * Date: 1/23/2019
 * Time: 2:34 PM
 */

class FileGenerator
{
    private $list = array();
    private $config = array();

    function __construct($width = "1240", $height = "744", $viewBox = "0 0 252 144", $tile = 'created by svg designer')
    {
        /*$this->config['width'] = $width;
        $this->config['width'] = $height;
        $this->config['viewBox'] = $viewBox;
        $this->config['tile'] = $tile;*/
    }


    public function add($data)
    {
        $this->list[] = $data;
    }


    public function create($filename = '')
    {
        $voipContent = '';
        foreach ($this->list as $key => $value) {
            $voipContent .= PHP_EOL.$value;

        }

        if (file_put_contents($filename, $voipContent)) {
            $result['result'] = 1;
            $svgContent ='';
            $result['content'] = $svgContent;
            return $result;
        }


    }
   /* public function create($filename = '')
    {
        $voipContent = '';
        foreach ($this->list as $key => $value) {
            $voipContent .= PHP_EOL.$value;

        }

        if (file_put_contents($filename, $voipContent)) {
            $result['result'] = 1;
            $result['content'] = $svgContent;
            $ftp_user_name='daba';
            $ftp_user_pass='daba123';
            $server='192.168.110.160';
            $this->uploadFTP($server, $ftp_user_name, $ftp_user_pass, $filename, str_replace(":","",$uploadName));


            return $result;
        }


    }
    public function uploadFTP($server, $username, $password, $local_file, $remote_file){
        // connect to server
        $connection = ftp_connect($server);

        // login
        if (@ftp_login($connection, $username, $password)){
            // successfully connected
        }else{
            return false;
        }

        ftp_put($connection, $remote_file, $local_file, FTP_BINARY);

        ftp_close($connection);
        return true;
    }*/
}
