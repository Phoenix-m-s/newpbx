<?php
/**
 * Created by PhpStorm.
 * User: VeRJiL
 * Date: 2/4/2017
 * Time: 1:42 PM
 */

include_once ROOT_DIR . "component/upload/AdminUploadModel.php";
include_once ROOT_DIR . "services/TblDstOptionService.php";
include_once ROOT_DIR . "component/extension/AdminExstionNewModel.php";
include_once ROOT_DIR . "component/company/AdminCompanyModel.php";
include_once ROOT_DIR . "component/voipConfig/AdminVoipConfigModel.php";
include_once ROOT_DIR . "component/voipConfig/FileGenerator.php";
include_once ROOT_DIR . "common/init.inc.php";
include_once ROOT_DIR . "common/func.inc.php";
include_once ROOT_DIR . "component/StepForm/StepForm.php";
include_once ROOT_DIR . "component/StepForm/UploaderConfig.php";
include_once ROOT_DIR . "common/GUMP-master/gump.class.php";



/**
 * @author VeRJiL
 * @version 0.0.1
 * @copyright 2017 The Imen Daba Parsian Co.
 */
class adminNewVoipConfigController
{
    /**
     * @var
     */
    private $error;
    /**
     * @var
     */
    private $fileName;
    /**
     * @var
     */
    private $exportType;

    /**
     * @var array
     */
    private $msg = [];


    /**
     * @var StepForm
     */
    protected $stepForm;
    protected $uploader;


    /**
     * adminNewVoipConfigController constructor.
     * @param StepForm $stepForm
     */
    public function __construct()
    {
        $this->stepForm = new StepForm();
        $this->uploader = new UploaderConfig();

    }
    public function index()
    {
        $input['step']=1;
        $this->stepForm($input);

    }

    public function stepForm($_input)
    {

        $stepForm = $this->stepForm->object('step', 2);

        $stepForm->setTemplate('voipconfig.step');

        if (isset($_input['step'])) {

            if ($_input['step'] > $stepForm->getStep()) {
                $stepForm->setData($_input);
            }
            $stepForm->setStep($_input['step']);
        }

        $stepForm->save();
        //dd($stepForm);
        //        print_r_debug(unserialize($_SESSION['step']));


        switch ($_input['step']) {
            case 2 :
                $export = $this->stepTwo($stepForm, $_input);
                break;
            default:
                $export = $this->stepOne($stepForm);
                break;
        }

        $fileName = $stepForm->getTemplate();

        if (empty($export['data'])) {
            $export['data'] = $stepForm->getData();
        }

        $this->exportType = 'html';
        $this->fileName = $stepForm->getTemplate().'.php';
        $this->template($export, $message='');
        die();
    }
    public function stepOne($stepForm)
    {
        $stepForm->setStep(1);
        $stepForm->save();
        $export['file_name'] = is_object($stepForm->file) ? $stepForm->file->main_name : '';
        return $export;
    }
    public function validateStepOne($input)
    {
        $validator = new GUMP();
        $rules = [
            'bran_name' => 'required*' . 'bran_name name is require',
            'component' => 'required*' . 'model_name is require',
        ];
        $validator->validate($input, $rules);
        $errors = $validator->get_errors_array();

        return $errors;
    }





    public function stepTwo($stepForm,$input)
    {


        if (isset($input['file'])) {
            if (file_exists(TARGET_DIR_Config . $stepForm->file->upload_name)) {
                unlink(TARGET_DIR_Config . $stepForm->file->upload_name);
            }
            $result = $this->uploader->upload($input['file']);

            if ($result['result'] == -1) {
                $errors = $result;
            }
            $export['configContent'] = file_get_contents(TARGET_DIR_Config . $result['upload_name']);

            //$headers = $this->file->readHeader(TARGET_DIR . $result['upload_name']);
            //$tenFirstRows = $this->file->getFirstRow(TARGET_DIR . $result['upload_name'], 10);
        } else if (!is_object($stepForm->file)) {
            $errors['msg'] = "file is require";
        }

        if (!empty($errors)) {
            //$stepForm->setStep($input['step'] - 1);
            $stepForm->save();
            $export['errors'] = $errors;
            print_r_debug($export);
            return $export;
        }

        /*if (!empty($result['upload_name'])) {
            if (!$this->file->checkHeader(TARGET_DIR . $result['upload_name'])) {
                $stepForm->setStep($input['step'] - 1);
                $stepForm->save();
                $export['errors']['msg'] = 'Your file has no email field';
                return $export;
            }
        }*/
        die('2');
        $stepForm->setStep(2);
        $stepForm->save();
        return $export;
        
    }



    /**
     * @param $list
     * @param $message
     */
    private function template( $list, $message)
    {
        switch ($this->exportType) {
            case 'html':
                include ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_start.tpl";
                include ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_header.tpl";
                include ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_rightMenu.tpl.php";
                include ROOT_DIR . "templates/" . CURRENT_SKIN . "/$this->fileName";
                include ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_footer.tpl";
                include ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_end.tpl";
                break;
        }
    }





}