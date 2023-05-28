<?php
include_once ROOT_DIR . "component/extension/AdminExstionNewModel.php";
//include_once ROOT_DIR . "component/extension/ExtensionService.php";
include_once ROOT_DIR . "services/ExtensionService.php";


/**
 * Class ExtensionService
 */
class ForwardService
{
    public $result;

    /**
     *getAllForward
     *author:Mojtaba Sakhamanesh & Shabihi
     *Email:sakhamanesh@dabacenter.ir
     * @return mixed
     *version:0.0.1
     */
    public function getAllForward($id)
    {

        $result['0'] = array('name' => 'choose from list', 'id' => '');
        $result['1'] = array('name' => 'Internal', 'id' => '1');
        $result['2'] = array('name' => 'External', 'id' => '2');

        $extensionList = new ExtensionService();
        $result['1']['child'] = $extensionList->getAllExtension($id);
        $result['2']['child'] = [];
        return $result;


    }
}