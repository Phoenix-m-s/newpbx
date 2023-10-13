<?php
/**
 * Created by PhpStorm.
 * User: VeRJiL
 * Date: 2/9/2017
 * Time: 10:09 AM
 */
require_once ROOT_DIR . 'component/upload/AdminUploadModel.php';
require_once ROOT_DIR . 'component/upload/Uploader.php';
include_once ROOT_DIR . "component/company/AdminCompanyModel.php";
include_once ROOT_DIR . "component/package_company/adminPackageCompanyModel.php";
include_once ROOT_DIR . 'services/CompanyService.php';
require_once ROOT_DIR . 'component/company/AdminCompanyModel.php';
include_once ROOT_DIR . "common/looeic.php";

/** @author: VeRJiL
 * @version: 0.0.2
 * @copyright: Imen Daba Parsian
 */
class AdminUploadController
{
    public $exportType;
    public $fileName;
    public $errors;
    private $temp_path;
    private $extensionID;
    private $companyID;
    private $text = '';

    protected $uploadDir;
    protected $upload_errors = array(
        // http://www.php.net/manual/en/features.file-upload.errors.php
        UPLOAD_ERR_OK => "No errors.",
        UPLOAD_ERR_INI_SIZE => "Larger than upload_max_filesize.",
        UPLOAD_ERR_FORM_SIZE => "Larger than form MAX_FILE_SIZE.",
        UPLOAD_ERR_PARTIAL => "Partial upload.",
        UPLOAD_ERR_NO_FILE => "No file.",
        UPLOAD_ERR_NO_TMP_DIR => "No temporary directory.",
        UPLOAD_ERR_CANT_WRITE => "Can't write to disk.",
        UPLOAD_ERR_EXTENSION => "File upload stopped by extension."
    );

    /**
     * renders the related template
     *
     * @var $list
     * @var $msg
     * @var $message
     */
    public function template($list = [], $message = '')
    {
        //print_r_debug($message);
        switch ($this->exportType) {
            case 'html':
                include ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_start.tpl";
                include ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_header.tpl";
                include ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_rightMenu.tpl.php";
                include ROOT_DIR . "templates/" . CURRENT_SKIN . "/$this->fileName";
                include ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_footer.tpl";
                include ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_end.tpl";
                break;
            case 'json':
                return;
                break;
            case 'array' :
                echo $list;
                break;
            case 'serialize' :
                echo serialize($list);
                break;
            default:
                break;
        }
        die();
    }

    /** shows the list of all the uploaded files */
    public function showAllUploads($message)
    {

        global $company_info,$admin_info, $member_info;
        if ($admin_info != -1) {
            $company_id = $admin_info['comp_id'];
            $uploadDirty = AdminUploadModel::getBy_comp_id($company_info['comp_id'])->getList();

        } elseif ($member_info != -1) {
            $company_id = $member_info['comp_id'];
            $extension_id = $member_info['Extension_ID'];
            $uploadDirty = AdminUploadModel::getBy_company_id_and_extension_id($company_id, $extension_id)->getList();
        }
        $uploadDirty = $uploadDirty['export']['list'];
        $list = $uploadDirty;
        $this->exportType = 'html';
        $this->fileName = 'upload.show.php';
        $this->template($list, $message);


    }

    /**
     * shows the upload form page
     *
     * @var $msg
     */
    public function addUploadForm($fields, $msg)
    {
        //print_r_debug($msg);
        //print_r_debug("");
        $this->exportType = 'html';
        $this->fileName = 'upload.add.form.php';
        //print_r_debug($msg);
        $this->template($fields, $msg);
        die();
    }

    /**
     * add a file from upload page
     *
     * @var $file
     * @var $fields
     */
    public function addFile($file, $fields)
    {

        global $admin_info, $member_info,$company_info;
        $checharacter = checkForPersianWordsInMultiDimensionalKeyValueArray($fields);
        if ($checharacter==-1) {
            $result['result'] = -1;
            $result['msg'] = 'You used an illegal character';
            echo json_encode($result);
            die();
        }
        $uploadName = AdminUploadModel::getBy_comp_id_and_title($admin_info['comp_id'], $fields['Title'])->getList();

        $uploadObj = new AdminUploadModel();
        $uploadObj->comp_id = $admin_info['comp_id'];
        $uploadObj->extension_id = 0;
        $uploadObj->title =  $fields['Title'];
        $uploadObj->upload_date = date("Y-m-d H:i:s");
        $uploadObj->trash = 0;
        $uploadObj->save();
        if ($uploadName['export']['recordsCount'] >= 1) {
            $result['result'] = -1;
           $message[] = 'this user uploadName is exist';
           $this->addUploadForm($fields, $message);
        }
        $filename=$uploadObj->upload_id;

        $uploaderFile = new  Uploader();
        $directoryName=UPLOAD_IVR_ROOT.$admin_info['comp_id'].DS;

        $res =$uploaderFile->upload($file,$filename,$directoryName);

        if ($res['result']== -1) {
            $uploadObj->delete();
            $message[] = $res['msg'];
            $this->addUploadForm($fields, $message);
            die();
        }

        $uploadObj->file_name =  $res['file_name'];

        $uploadObj->file_extension = $res['file_extension'];
        $uploadObj->save();
        $company = new CompanyService();
        $company->activeRelaod($company_info['comp_id']);

        $result['msg'] = 'Successfully Deleted';
        redirectPage(RELA_DIR . 'upload.php', 'Successfully added');
        die();
    }

    /**
     * deletes a specific file from the directory
     *
     * @var $id
     */
    public function deleteFiles($id)
    {
        global $admin_info, $member_info,$company_info;
        include_once ROOT_DIR . "component/announce/adminAnnounceModel.php";
        include_once ROOT_DIR . "component/ivr/adminIVRModel.php";
        $uploadObj = AdminUploadModel::find($id);

        $result = $this->dependencyUpload($id);
        if ($result['result'] == -1) {
            $this->showAllUploads($result);
        }
        if ($admin_info != -1) {
            $filePath = ROOT_DIR . "voip" . "/" . $admin_info['comp_id'] . "/";
        } elseif ($member_info != -1) {
            $filePath = ROOT_DIR . "voip" . "/" . $member_info['comp_id'] . "/";
        } else {
            redirectPage(RELA_DIR . 'upload.php', 'There is no proper user logged in');
        }

        $originalName = $filePath . $uploadObj->title . '.mp3';
        if (file_exists($originalName)) {
            if (unlink($originalName)) {
                if ($uploadObj->delete($id)) {
                    redirectPage(RELA_DIR . 'upload.php', 'Deleted Successfully');
                }
            } else {
                redirectPage(RELA_DIR . 'upload.php', 'Failed To Delete The File');
            }
        } else {
            $uploadObj->delete($id);
            $company = new CompanyService();
            $company->activeRelaod($company_info['comp_id']);

            $result['msg'] = 'Successfully Deleted';
            redirectPage(RELA_DIR . 'upload.php',$result['msg']);
        }

    }


    public function dependencyUpload($id)
    {
        $usedAnnounce = AdminAnnounceModel::getBy_upload_id($id)->getList();

        if ($usedAnnounce['export']['recordsCount'] >= 1) {
            foreach ($usedAnnounce['export']['list'] as $key => $value) {
                $result['msg'][] = 'This file has been used by this Announce : ' . " <span style='font: italic bold 15px Georgia; color: red;'>" . $usedAnnounce['export']['list']['0']['announce_name'] . "</span>";
            }
            $result['result'] = -1;
        }
        $usedIvr = AdminIVRModel::getBy_upload_id($id)->getList();
        if ($usedIvr['export']['recordsCount'] >= 1) {
            foreach ($usedIvr['export']['list'] as $key => $value) {
                $result['msg'][] = 'This file has been used by this Ivr : ' . " <span style='font: italic bold 15px Georgia; color: red;'>" . $usedIvr['export']['list']['0']['ivr_name'] . "</span>";
            }
            $result['result'] = -1;
        }

        return $result;
    }


    /**
     * attaches the file to temporary folder and checks if there is no error
     *
     * @var $file
     * @return true if success and false if there is an error
     */
    private function attachFile($file)
    {
        if (!$file || empty($file) || !is_array($file)) {
            $this->errors = 'No File Was Uploaded';

            return false;
        } elseif ($file['error'] != 0) {
            $this->errors = $this->upload_errors[$file['error']];

            return false;
        } else {
            return true;
        }
    }

    /**
     * create the directory depends on the admin or member user or extension
     *
     * @var $extension_id
     */
    private function dirPath($extension_id)
    {
        //print_r_debug($extension_id);
        global $admin_info, $member_info;

        if ($admin_info != -1) {
            $this->companyID = $admin_info['comp_id'];
            $this->extensionID = $extension_id;

            if (!file_exists(ROOT_DIR . "voip" . DS . $admin_info['comp_id'])) {
                mkdir(ROOT_DIR . "voip" . DS . $admin_info['comp_id']);
            }

            $this->uploadDir = ROOT_DIR . "voip" . DS . $admin_info['comp_id'];

            //creating folders dynamically for each extension if the member use is logged in
        } elseif ($member_info != -1) {
            $this->companyID = $member_info['comp_id'];
            $this->extensionID = $member_info['extension_id'];

            if (!file_exists(ROOT_DIR . "voip" . DS . $member_info['comp_id'])) {
                mkdir(ROOT_DIR . "voip" . DS . $member_info['comp_id']);
            }
            $this->uploadDir = ROOT_DIR . "voip" . DS . $member_info['comp_id'];
        } else {
            $this->errors[] = "There is no proper user re-login pls";
        }
    }

    /**
     * Creates select tag for when voice will saved after recording
     *
     * @var $status
     * @var $voiceClean
     * @var $voiceObject
     */
    private function createSelectTag($status, $voiceClean, $voiceObject)
    {
        switch ($status) {
            case 'DSTOption':
                $name = 'DSTOption[]';
                break;
            case 'FDSTOption':
                $name = 'FDSTOption';
                break;
            case 'successDSTOption':
                $this->text = "<label class='col-sm-6 col-md-3 col-lg-3'>Dial Destination</label>";
                $this->text .= "<div class='col-sm-6 col-md-5 col-lg-5'></div>";
                $name = 'successDSTOption';
                break;
            case 'failedDSTOption':
                $this->text = "<label class='col-sm-6 col-md-3 col-lg-3'>Dial Destination</label>";
                $this->text .= "<div class='col-sm-6 col-md-5 col-lg-5'></div>";
                $name = 'failedDSTOption';
                break;
            case 'IVRDSTOption':
                $name = 'DSTOption[]';
                break;
            case 'AnnounceDSTOption';
                $name = 'DSTOption';
                break;
            case 'QueueDSTOption';
                $name = 'DSTOption';
                break;
            case 'InboundDSTOption';
                $name = 'DSTOption';
                break;
        }

        $this->text = "<select name='$name'>";

        foreach ($voiceClean as $key => $value) {
            $this->text .= "<option value='{$key}'";
            if ($key == $voiceObject->upload_id) {
                $this->text .= ' selected ';
            }
            $this->text .= ">{$value}</option>";
        }

        $this->text .= "</select>";

        if ($status == 'successDSTOption') {
            $this->text .= "</div>";
        }

        if ($status == 'failedDSTOption') {
            $this->text .= "</div>";
        }

    }

    /**
     * Saving Voice Using Ajax to the Both DataBase and voip Folder
     *
     * @var $file
     */
    public function saveVoice($file)
    {
        global $admin_info, $member_info;

        $this->attachFile($file['file']);

        if (isset($file['extension_id']) and !empty($file['extension_id'])) {
            $this->dirPath($file['extension_id']);
        } else {
            $this->dirPath(0);
        }

        if (!empty($this->errors)) {
            echo $this->errors;
        } else {
            $voiceObject = new AdminUploadModel();
            $file_name = $file['voiceTitle'];
            $tmp_name = $file['file']['tmp_name'];
            //$voiceObject->file_name = uniqid();
            $voiceObject->title = $file_name;
            $voiceObject->comp_id = $this->companyID;
            $voiceObject->extension_id = $this->extensionID;
            $voiceObject->file_extension = 'mp3';
            $voiceObject->upload_date = date("Y-m-d H:m:s");
            $voiceObject->trash = 0;
            $voiceObject->save();

            $destination = $this->uploadDir . DS . $voiceObject->upload_id . '.mp3';

            if (move_uploaded_file($tmp_name, $destination)) {

                $result = $voiceObject->save();
                if ($result['result'] == 1) {
                    if ($admin_info != -1) {
                        $voiceDirty = AdminUploadModel::getBy_comp_id($this->companyID)->getList();
                    } elseif ($member_info != -1) {
                        $voiceDirty = AdminUploadModel::getBy_comp_id_and_extension_id($this->companyID, $this->extensionID)->getList();
                    }

                    foreach ($voiceDirty['export']['list'] as $key => $value) {
                        $voiceClean[$value['upload_id']] = $value['title'];
                    }

                    $this->createSelectTag($file['status'], $voiceClean, $voiceObject);
                    echo $this->text;
                }
            } else {
                $objerr = AdminUploadModel::find($voiceObject->upload_id);
                $objerr->delete();
                $this->errors[] = 'Cant Upload The File Probably Due To User Permission';
                echo $this->errors;

            }
            die();
        }
    }

}