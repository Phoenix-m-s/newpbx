<?php
include_once ROOT_DIR . "services/CdrService.php";


/**
 * @author VeRJiL
 * @version 0.0.1
 * @copyright 2017 The Imen Daba Parsian Co.
 */
class cdrController extends Controller
{
    public function __construct(){

    }


    /**
     * @param array $list
     * @param string $message
     */
    public function template($list = [], $message = '')
    {
        switch ($this->exportType) {
            case 'html':
                include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_start.tpl");
                include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_header.tpl");
                include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_rightMenu.tpl.php");
                include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/$this->fileName");
                include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_footer.tpl");
                include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_end.tpl");
                break;

            case 'json':
                //$json_response = json_encode($response);

                echo json_encode($list);
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
     * show all cdr with extentionno
     *
     * @author m.sakhamanesh@googlemail.com
     * @param
     * @version 0.0.1
     * date 23/6/2020
     */
    public function showAllCdr($extentionNo)
    {
        die('z');
        $cdrService = new CdrService();
        $list = $cdrService->getInfoCdr($extentionNo);

        $list['success']=true;
        Response::json($list,200);
    }


}