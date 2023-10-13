<?php
/**
 * Created by PhpStorm.
 * User: VeRJiL
 * Date: 2/4/2017
 * Time: 1:42 PM
 */

include_once ROOT_DIR . "component/timeCondition/mainTimeConditionModel.php";
include_once ROOT_DIR . "component/announce/adminAnnounceModel.php";
include_once ROOT_DIR . "component/package_company/adminPackageCompanyModel.php";
include_once ROOT_DIR . "component/checkdependency/adminCheckDependency.php";
include_once ROOT_DIR . "component/ivr/adminIVRModel.php";
include_once ROOT_DIR . "component/queue/adminQueueModel.php";
include_once ROOT_DIR . "component/extension/AdminExstionNewModel.php";
include_once ROOT_DIR . "component/upload/AdminUploadModel.php";
include_once ROOT_DIR . "component/sip/adminSIPModel.php";
include_once ROOT_DIR . "component/extension.model.php";
include_once ROOT_DIR . "common/init.inc.php";
include_once ROOT_DIR . "common/func.inc.php";
include_once ROOT_DIR . "services/QueueService.php";


/**
 * @author VeRJiL
 * @version 0.0.1
 * @copyright 2017 The Imen Daba Parsian Co.
 */
class AdminQueueController
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

    private function template($list, $message)
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
    public function excelQueue()
    {
        global $company_info;
        $queueDirty = AdminQueueModel::getAll()->where('comp_id', '=', $company_info['comp_id'])->getList();

        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=Queue_Reoprt.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        echo '<table border="1">';
//make the column headers what you want in whatever order you want
        echo '<tr>
                    <th>queue_id</th>
                    <th>comp_id</th>
                    <th>dst_option_id</th>
                    <th>dst_option_sub_id</th>
                    <th>queue_status</th>
                    <th>queue_name</th>
                    <th>queue_ext_no</th>
                    <th>queue_pass</th>
                    <th>max_wait_time</th>
                    <th>agents_no</th>
                    <th>position_announcement</th>
                    <th>hold_time_announcement</th>
                    <th>frequency</th>
                    <th>recording</th>
                    <th>ring_strategy</th>
                    <th>trash</th>
                    <th>instead</th>
                    <th>forward</th>
                    <th>timeout</th>
              </tr>';
//loop the query data to the table in same order as the headers
        foreach ($queueDirty['export']['list'] as $key=>$value){
            echo "<tr>
                      <td>".$value['queue_id']."</td>
                      <td>".$value['comp_id']."</td>
                      <td>".$value['dst_option_id']."</td>
                      <td>".$value['dst_option_sub_id']."</td>
                      <td>".$value['queue_status']."</td>
                      <td>".$value['queue_name']."</td>
                      <td>".$value['queue_ext_no']."</td>
                      <td>".$value['queue_pass']."</td>
                      <td>".$value['agents_no']."</td>
                      <td>".$value['position_announcement']."</td>
                      <td>".$value['hold_time_announcement']."</td>
                      <td>".$value['frequency']."</td>
                      <td>".$value['recording']."</td>
                      <td>".$value['ring_strategy']."</td>
                      <td>".$value['trash']."</td>
                      <td>".$value['instead']."</td>
                      <td>".$value['forward']."</td>
                      <td>".$value['timeout']."</td>
                  </tr>";
        }
        echo '</table>';

    }


    public function showAllQueues($message)
    {
        global $company_info;
        $queueDirty = AdminQueueModel::getAll()
            ->where('comp_id', '=', $company_info['comp_id'])->getList();
        $queueClean = $queueDirty['export']['list'];
        $this->exportType = 'html';
        $this->fileName = 'queue.show.php';
        $this->template($queueClean, $message);
    }


    public function addQueueForm($fields, $message)
    {
        $queue = new QueueService();
        $list = $queue->addQueueForm();
        $this->exportType = 'html';
        $this->fileName = 'queue.form.php';
        $this->template($list, $message);
        die();
    }

    public function addQueue($fields)
    {
        global $admin_info, $company_info;
        $checharacter = checkForPersianWordsInMultiDimensionalKeyValueArray($fields);
        if ($checharacter==-1) {
            $result['result'] = -1;
            $result['msg'] = 'You used an illegal character';
            echo json_encode($result);
            die();
        }
        $queue = new QueueService();
        $result = $queue->addQueue($fields);
        if ($result['result'] != 1) {
            $result['result'] = -1;
        } else {
            $company = new CompanyService();
            $result = $company->activeRelaod($company_info['comp_id']);
        }
        echo json_encode($result);
        die();
    }

    public function showEditQueueForm($fields, $msg)
    {
        $queue = new QueueService();
        $list = $queue->showEditQueueForm($fields);
        $this->exportType = 'html';
        $this->fileName = 'queue.form.php';
        $this->template($list, $msg);
        die();
    }

    public function editQueueForm($queueID, $msg)
    {
        $queueDirty = AdminQueueModel::find($queueID);
        $fields = $queueDirty->fields;
        $this->showEditQueueForm($fields);
    }

    public function editQueue($fields)
    {
        global $company_info;
        $checharacter = checkForPersianWordsInMultiDimensionalKeyValueArray($fields);
        if ($checharacter==-1) {
            $result['result'] = -1;
            $result['msg'] = 'You used an illegal character';
            echo json_encode($result);
            die();
        }
        $queue = new QueueService();
        $result = $queue->editQueue($fields);
        if ($result['result'] != 1) {
            $result['result'] = -1;
        } else {
            $company = new CompanyService();
            $result = $company->activeRelaod($company_info['comp_id']);
        }
        echo json_encode($result);
        die();
    }

    public function deleteQueues($queueID)
    {
        global $company_info;
        include_once ROOT_DIR . 'services/dependency/DependencyService.php';
        $checkDependency = new DependencyService;
        $input['id'] = $queueID;
        $input['comp_id'] = $company_info['comp_id'];
        $input['name'] = 'Queue';
        $input['dst_option_id'] = '2';

        $result = $checkDependency->checkDependency($input);

        if ($result['msg'] != '') {
            $this->showAllQueues($result['msg']);
            die();
        } else {
            $announce = AdminQueueModel::find($queueID);
            $announce->delete();
            $companyObj = new AdminCompanyModel();
            $company = $companyObj->find($company_info['comp_id']);
            $company->reload_alert = 1;
            $company->save();

            redirectPage(RELA_DIR . 'queue.php?action=showQueue', 'Successfully Deleted');
        }

    }

    public function showLiveQueue()
    {
        $list = AdminQueueModel::getAll()->keyBy('queue_name')->getList()['export']['list'];
        foreach ($list as $key => $files) {
            $list[$key]['countOnline'] = 0;
            $list[$key]['onlineList'] = array();
        }
        $this->fileName = "queue.live.php";

        include ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_start.tpl";
        include ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_header.tpl";
        include ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_rightMenu.tpl.php";
        include ROOT_DIR . "templates/" . CURRENT_SKIN . "/adminQueueController.php";
        include ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_footer.tpl";
        include ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_end.tpl";

        //include ROOT_DIR . "templates/" . CURRENT_SKIN . "/$this->fileName";
    }

}