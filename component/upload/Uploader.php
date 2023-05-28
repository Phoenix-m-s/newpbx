<?php

require_once ROOT_DIR . 'component/company/AdminCompanyModel.php';
/**
 * Class Uploader
 * createBy:MOJTABA SAKHAMANESH
 */
class Uploader
{

    /**
     * @var
     */
    protected $uploadOk;

    public function upload($file,$filename='',$directoryName='')
    {
        global $admin_info, $member_info;
        if ($file['error'] > 0) {
            $result['result'] = -1;
            $result['msg'] = "file is require";
            return $result;
        }

        $newFileName = basename(uniqid() . '-' . $file['PlayBackFile']["name"]);

       /* if($directoryName=='')
        {
            $directoryName=ROOT_DIR . "voip" . DS.$admin_info['comp_id'].DS ;
        }*/
        if (!file_exists($directoryName)) {
            $path=ROOT_DIR . "statics" . DS."files".DS.$admin_info['comp_id'].DS ;
            mkdir($path, 0777,true );
        }
        clearstatcache();

        $target_file = $directoryName.$newFileName;

        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if($filename!='')
        {
            $newFileName=$filename.'.'.$fileType;
            $target_file = $directoryName.$newFileName;
        }


        if (!file_exists($directoryName)) {

            mkdir($directoryName);
        }

        if (!$this->checkSizeFile($file["size"])) {
            $result['result'] = -1;
            $result['msg'] = "Sorry, your file is too large.";
            return $result;
        }

        if ($this->checkFileExists($target_file)) {
            $result['result'] = -1;
            $result['msg'] = "Sorry, file already exists.";
            return $result;
        }

        if (!$this->checkAllowCertain($fileType)) {

            $result['result'] = -1;
            $result['msg'] = "Sorry, only mp3, wave files are allowed.";
            return $result;
        } else {

         /*   $structure = ROOT_DIR . "voip" . DS . $admin_info['comp_id'];

            if (!mkdir($structure, 0777, true)) {
                $result['msg'] = 'Failed to create folders...';
            }*/


            if (move_uploaded_file($file['PlayBackFile']["tmp_name"], $target_file)) {
                $result['result'] = 1;
                $result['file_name'] =  $newFileName;
                $result['file_extension'] =  $fileType;
                $result['msg'] = "The file " . basename($file['PlayBackFile']["name"]) . " has been uploaded.";
                return $result;
            } else {
                $result['result'] = -1;
                $result['msg'] = "Sorry, there was an error uploading your file.";
                return $result;
            }
        }
    }

    /**
     * @param $fileSize
     * @param $size
     * @return mixed
     */
    private function checkSizeFile($fileSize)
    {

        if ($fileSize > SIZE_UPLOAD_FILE) {
            return false;
        }

        return true;
    }

    /**
     * @param $target_file
     * @return mixed
     */
    private function checkFileExists($target_file)
    {

        if (!file_exists($target_file)) {
            return false;
        }

        return true;
    }

    /**
     * @param $fileType
     * @return mixed
     */
    private function checkAllowCertain($fileType)
    {
        $fileType = strtolower($fileType);
        if ($fileType != "mp3" && $fileType != "wav") {
            return false;
        }

        return true;
    }

}

/*$upload = new Uploader();
$upload->upload($_FILES);
print_r($upload);
die('111');
*/ ?>