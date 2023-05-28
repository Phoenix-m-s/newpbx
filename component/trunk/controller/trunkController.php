<?php

/**
 * Created by PhpStorm.
 * User: VeRJiL
 * Date: 4/4/2017
 * Time: 2:56 AM
 */

/**
 * @Email M.sakhamanesh@googlemail.com
 * @param $fields
 */

include_once ROOT_DIR . "common/func.inc.php";
include_once ROOT_DIR . "common/init.inc.php";
include_once ROOT_DIR . "common/looeic.php";
include_once ROOT_DIR . "component/company/AdminCompanyModel.php";
include_once ROOT_DIR . "services/TrunkService.php";
include_once ROOT_DIR . 'services/CompanyService.php';

/**
 * Class ConferenceController
 */
class TrunkController
{
    private $error;
    private $fileName;
    private $exportType;
    private $msg = [];
    private $DSTList = [
        2 => 'Queue',
        3 => 'Extension',
        4 => 'Announce',
        5 => 'IVR',
        6 => 'Voice Mail',
        7 => 'Hang Up',
        8 => 'Time Condition'
    ];

    private $forwardList = [
        'defaultMessage' => 'Default Message',
        'customMessage' => 'Custom Message',
        'customMessageByList' => 'Custom Message By List',
        'customMessageByRecord' => 'Custom Message By Record'
    ];

    /**
     * @param $list
     * @param string $message
     */
    private function template($list, $message = '')
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
    }

    /**
     * @param string $message
     */
    public function showAllTrunk($message = '')
    {

        $trunk= new TrunkService();
        $list = $trunk->getAllTrunk();
        $this->exportType = 'html';
        $this->fileName = 'trunk.show.php';
        $this->template($list, $message);
        die();
    }

    /**
     * @param $fields
     */
    public function addTrunk($fields)
    {
        global $company_info;
        $trunk = new TrunkService();
        $result = $trunk->service_AddTrunk($fields);

        if ($result['result'] != 1) {
            $result['result'] = -1;
        } else {
            $company = new CompanyService();
            $result = $company->activeRelaod($company_info['comp_id']);
        }
        echo json_encode($result);
        die();
    }

    /**
     * @param array $fields
     * @param $message
     */
    public function addTrunkForm($fields, $msg)
    {
        global $conn, $lang;
        $trunk = new TrunkService();
        $result = $trunk->addTrunkForm();
        $this->exportType = 'html';
        $this->fileName = 'trunk.form.php';
        $this->template($result, $msg);
        die();

    }

    /**
     * Edit trunk based on its ID
     *
     * @param $fields
     * @param $msg
     *
     * @return  mixed
     * @author  Husin Sajjadi
     * @version 01.01.01
     * @date    08/08/2020
     */


    public function editTrunk($fields, $msg)
    {
        global $company_info;
        $trunk = new TrunkService();
        $result = $trunk->service_editTrunk($fields);
        if ($result['result'] != 1) {
            $result['result'] = -1;
        } else {
            $company = new CompanyService();
            $result = $company->activeRelaod($company_info['comp_id']);
        }
        echo json_encode($result);
        die();
    }


    /**
     * Show edit trunk form based on its ID
     *
     * @param $trunkID
     * @param $msg
     *
     * @return  mixed
     * @author  Husin Sajjadi
     * @version 01.01.01
     * @date    08/08/2020
     */
    public function editTrunkForm($trunkID, $msg)
    {
        $trunk = new TrunkService();
        $result = $trunk->editTrunkForm($trunkID);
        $this->exportType = 'html';
        $this->fileName = 'trunk.form.php';
        $this->template($result, $msg);
        die();
    }

    public function checkErrorNo($result)
    {
        if ($result['result'] != 1) {
            if (isset($result['no']) and $result['no'] = '101') {
                redirectPage(RELA_DIR . 'trunk.php?action=showTrunk', "You don't have the permission to this page");

            }
        }

    }

    public function deleteTrunk($trunkID)
    {
        global $company_info;

        $trunk = new TrunkService();
        $result = $trunk->deleteTrunkByTrunkId($trunkID);

        if ($result['result'] != 1) {
            $this->checkErrorNo($result);
            $result['result'] = -1;
            $result['msg'] = 'Failed To Delete';
            $this->showAllTrunk($result['msg']);
            die();
        } else {
            $company = new CompanyService();
            $company->activeRelaod($company_info['comp_id']);
            $result['msg'] = 'Successfully Deleted';
            redirectPage(RELA_DIR . 'trunk.php?action=showTrunk', 'Successfully Deleted');
            die();
        }
    }


}
