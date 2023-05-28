<?php

include_once ROOT_DIR . "common/init.inc.php";
include_once ROOT_DIR . "common/func.inc.php";
include_once ROOT_DIR . "common/looeic.php";
include_once ROOT_DIR . "services/RoutingService.php";
include_once ROOT_DIR . "services/CompanyService.php";

/**
 * Class ConferenceController
 */
class RoutingController
{
    private $fileName;
    private $exportType;

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
    public function showAllRouting($message = '')
    {
        global $company_info;
        $routing = new RoutingService();
        $list = $routing->getAllRouting();

        $company = new CompanyService();
        $list['companies'] = $company->getAllCompanies();

        $this->exportType = 'html';
        $this->fileName = 'routing.show.php';
        $this->template($list, $message);
        die();
    }

    /**
     * @param $fields
     */
    public function addRouting($fields)
    {
        global $company_info;
        $routing = new RoutingService();
        $result = $routing->addRouting($fields);

        if ($result['result'] != 1) {
            $result['result'] = -1;
            echo json_encode($result,JSON_PRETTY_PRINT);
        }
        else{
            $company = new companyService();
            $result = $company->activeRelaod($company_info['comp_id']);
            echo json_encode($result,JSON_PRETTY_PRINT);
            die();
        }


    }

}
