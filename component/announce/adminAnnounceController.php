<?php

include_once ROOT_DIR . "component/announce/adminAnnounceModel.php";
include_once ROOT_DIR . "component/package_company/adminPackageCompanyModel.php";
include_once ROOT_DIR . "component/checkdependency/adminCheckDependency.php";
include_once ROOT_DIR . "component/ivr/adminIVRModel.php";
include_once ROOT_DIR . "component/queue/adminQueueModel.php";
include_once ROOT_DIR . "services/UploadService.php";
include_once ROOT_DIR . "component/upload/AdminUploadModel.php";
include_once ROOT_DIR . "component/sip/adminSIPModel.php";
include_once ROOT_DIR . "component/company/AdminCompanyModel.php";
include_once ROOT_DIR . "component/extension.model.php";
include_once ROOT_DIR . "common/init.inc.php";
include_once ROOT_DIR . "common/func.inc.php";
include_once ROOT_DIR . "common/looeic.php";
include_once ROOT_DIR . 'services/dependency/DependencyService.php';
include_once ROOT_DIR . 'services/AnnouncementService.php';
include_once ROOT_DIR . 'services/CompanyService.php';
include_once ROOT_DIR . "services/TblDstOptionService.php";
include_once ROOT_DIR . "services/UploadService.php";

/**
 * Class AdminAnnounceController
 */
class AdminAnnounceController
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
     * @var array
     */
    private $DSTList = [
        2 => 'Queue',
        3 => 'Extension',
        4 => 'Announce',
        5 => 'IVR',
        6 => 'Voice Mail',
        7 => 'Hang Up',
        8 => 'Time Condition'
    ];
    /**
     * @var array
     */
    private $forwardList = [
        'defaultMessage' => 'Default Message',
        'customMessage' => 'Custom Message',
        'customMessageByList' => 'Custom Message By List',
        'customMessageByRecord' => 'Custom Message By Record'
    ];

    /**
     * @param $list
     * @param string $messagehttps://wp-parsi.com/support/topic/29113-%D8%B9%D9%88%D8%B6-%DA%A9%D8%B1%D8%AF%D9%86-favicon-%D9%88%D8%B1%D8%AF%D9%BE%D8%B1%D8%B3/
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
    public function excelAnnounce()
    {
        global $company_info;
        $queueDirty = AdminAnnounceModel::getAll()->where('comp_id', '=', $company_info['comp_id'])->getList();

        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=Announce_Reoprt.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        echo '<table border="1">';
//make the column headers what you want in whatever order you want
        echo '<tr>
                    <th>announce_id</th>
                    <th>comp_id</th>
                    <th>dst_option_id</th>
                    <th>dst_option_sub_id</th>
                    <th>upload_id</th>
                    <th>announce_name</th>
                    <th>repeat_input</th>
                    <th>announce_date</th>
                    <th>announce_status</th>
                    <th>forward</th>
                    <th>DSTOption</th>
              </tr>';
//loop the query data to the table in same order as the headers
        foreach ($queueDirty['export']['list'] as $key=>$value){
            echo "<tr>
                      <td>".$value['announce_id']."</td>
                      <td>".$value['comp_id']."</td>
                      <td>".$value['dst_option_id']."</td>
                      <td>".$value['dst_option_sub_id']."</td>
                      <td>".$value['upload_id']."</td>
                      <td>".$value['announce_name']."</td>
                      <td>".$value['repeat_input']."</td>
                      <td>".$value['announce_date']."</td>
                      <td>".$value['announce_status']."</td>
                      <td>".$value['forward']."</td>
                      <td>".$value['DSTOption']."</td>
                  </tr>";
        }
        echo '</table>';

    }

    /**
     * @param string $message
     */
    public function showAllAnnounce($message = '')
    {
        global $company_info;
        $announceDirty = AdminAnnounceModel::getAll()
        ->where('comp_id', '=', $company_info['comp_id'])
        ->where('repeat_input', '=', 1)->getList();
        //print_r_debug($announceDirty);
        $announceClean = $announceDirty['export']['list'];
        $this->exportType = 'html';
        $this->fileName = 'announce.show.php';
        $this->template($announceClean, $message);
    }


    /**
     * @param array $fields
     * @param $message
     */
    public function addAnnounceForm($fields = [], $message)
    {

        /* $uniId = uniqid();
         $_SESSION['token'][$uniId] = '1';
         $fields['token'] = 'token[' . $uniId . ']';*/


        //////////////get uploadList////////////
        $upload = new UploadService();
        $fields['upload_id'] = $upload->getUploadList();


        //////////////get dialExtensionDetail////////////
        $ivrOption = new TblDstOptionService();
        $dialExtension_list = $ivrOption->getAnnouncementOption();
        $fields['dst_option_id'] = $ivrOption->getDialExtensionDetailByName($dialExtension_list);

        $fields['action'] = 'addAnnounce';
        $fields['direct_dial'] = 1;
        $list = json_encode($fields, JSON_PRETTY_PRINT);
        $this->exportType = 'html';
        $this->fileName = 'announce.form.php';
        $this->template($list, $message);
        die();
    }


    /**
     * @param $fields
     */
    public function addAnnounce($fields)
    {
        $announce = new AnnouncementService();
        $result = $announce->addAnnouncement($fields);

        if ($result['result'] != 1) {
            $result['result'] = -1;
        }
        echo json_encode($result);
        die();
    }

    /**
     * @param $announceID
     * @param $fields
     * @param $message
     */
    public function editAnnounceForm($announceID, $fields, $message)
    {

        $announceDirty = AdminAnnounceModel::find($announceID);
        $fields = $announceDirty->fields;

        //////////////get uploadList////////////
        $fields['upload_id_selected'] = $fields['upload_id'];
        unset($fields['upload_id']);
        $upload = new UploadService();
        $fields['upload_id'] = $upload->getUploadList();

        //////////////get dialExtensionDetail////////////
        $fields['dst_option_id_selected'][0]['dst_option_id'] = $fields['dst_option_id'];
        $fields['dst_option_id_selected'][0]['dst_option_sub_id'] = $fields['dst_option_sub_id'];
        $fields['dst_option_id_selected'][0]['DSTOption'] = $fields['DSTOption'];
        unset($fields['dst_option_id']);
        unset($fields['dst_option_sub_id']);
        unset($fields['DSTOption']);
        unset($fields['forward']);
        //////////////get dialExtensionDetail////////////
        $ivrOption = new TblDstOptionService();
        $dialExtension_list = $ivrOption->getAnnouncementOption();
        $fields['dst_option_id'] = $ivrOption->getDialExtensionDetailByName($dialExtension_list);
        $fields['action'] = 'editAnnounce';
        $list = json_encode($fields, JSON_PRETTY_PRINT);
        $this->exportType = 'html';
        $this->fileName = 'announce.form.php';
        $this->template($list, $message);
        die();

    }

    /**
     * @Email M.sakhamanesh@googlemail.com
     * @param $fields
     */
    public function editAnnounce($fields)
    {
        global $company_info;
        $announce = new AnnouncementService();
        $result = $announce->editAnnouncement($fields);
        if ($result['result'] != 1) {
            $result['result'] = -1;
        }
        $company = new companyService();
        $result = $company->activeRelaod($company_info['comp_id']);
        echo json_encode($result);
        die();

    }


    /**
     * @Email M.sakhamanesh@googlemail.com
     * @param $announceID
     */
    public function deleteAnnounce($announceID)
    {
        global $company_info;
        $input['id'] = $announceID;
        $input['comp_id'] = $company_info['comp_id'];
        $input['name'] = 'Announce';
        $input['dst_option_id'] = '4';
        $checkDependency = new DependencyService;
        $result = $checkDependency->checkDependency($input);

        if ($result['msg'] != '') {
            $this->showAllAnnounce($result['msg']);
            die();
        }

        $announce = new AnnouncementService();
        $result = $announce->deleteAnnouncementByAnnouncementId($announceID);

        if ($result['result'] != 1) {
            $result['result'] = -1;
            $result['msg'] = 'Failed To Delete';
            $this->showAllAnnounce($result['msg']);
            die();
        } else {
            $company = new CompanyService();
            $company->activeRelaod($company_info['comp_id']);
            $result['msg'] = 'Successfully Deleted';
            redirectPage(RELA_DIR . 'announce.php?action=showAnnounce', 'Successfully Deleted');
            die();
        }
    }

}