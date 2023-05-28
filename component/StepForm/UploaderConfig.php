<?php

/**
 * Class Uploader
 * createBy:MOJTABA SAKHAMANESH
 */
class UploaderConfig
{
    /**
     * @var
     */
    protected $uploadOk;

    public function upload($file)
    {

        if ($file['error'] > 0) {
            $result['result'] = -1;
            $result['msg'] = "file is require";
            return $result;
        }

        $newFileName = basename(uniqid() . '-' . $file["name"]);
        $target_file = TARGET_DIR_Config . $newFileName;
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

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
            $result['msg'] = "Sorry, only csv, xls, xlsx files are allowed.";
            return $result;
        } else {
            if (move_uploaded_file($file["name"], $target_file)) {
                $result['result'] = 1;
                $result['main_name'] = $file['name'];
                $result['upload_name'] = $newFileName;
                $result['msg'] = "The file " . basename($file["name"]) . " has been uploaded.";
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

       /* if ($fileType != "csv" && $fileType != "xls" && $fileType != "xlsx") {
            return false;
        }*/

        return true;
    }

}

/*$upload = new Uploader();
$upload->upload($_FILES);
print_r($upload);
die('111');
*/ ?>