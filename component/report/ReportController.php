<?php
include_once ROOT_DIR . "common/init.inc.php";
include_once ROOT_DIR . "common/func.inc.php";
include_once ROOT_DIR . "common/looeic.php";
include_once ROOT_DIR . "component/report/Report.php";
include_once ROOT_DIR . "component/extension/AdminExstionNewModel.php";


/**
 * Class AdminReportController
 */
class ReportController
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
    public function showAllReport($message = '')
    {

        $ReportDirty = Report::getAll()->getList();
        $ReportClean = $ReportDirty['export']['list'];
        $this->exportType = 'html';
        $this->fileName = 'Report.show.php';
        $this->template($ReportClean, $message);
    }


    /**
     * @param array $fields
     * @param $message
     */
    public function addReportForm($fields = [], $message)
    {

        /* $uniId = uniqid();
         $_SESSION['token'][$uniId] = '1';
         $fields['token'] = 'token[' . $uniId . ']';*/


        //////////////get uploadList////////////
        $upload = new UploadService();
        $fields['upload_id'] = $upload->getUploadList();

        //////////////get dialExtensionDetail////////////
        $ivrOption = new TblDstOptionService();
        $dialExtension_list = $ivrOption->getReportmentOption();
        $fields['dst_option_id'] = $ivrOption->getDialExtensionDetailByName($dialExtension_list);
        $fields['action'] = 'addReport';
        $fields['direct_dial'] = 1;
        $list = json_encode($fields, JSON_PRETTY_PRINT);
        $this->exportType = 'html';
        $this->fileName = 'Report.form.php';
        $this->template($list, $message);
        die();
    }


    /**
     * @param $fields
     */
    public function addReport($fields)
    {
        $Report = new ReportmentService();
        $result = $Report->addReportment($fields);

        if ($result['result'] != 1) {
            $result['result'] = -1;
        }
        echo json_encode($result);
        die();
    }

    /**
     * @param $ReportID
     * @param $fields
     * @param $message
     */
    public function editReportForm($ReportID, $fields, $message)
    {

        $ReportDirty = AdminReportModel::find($ReportID);
        $fields = $ReportDirty->fields;

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
        $dialExtension_list = $ivrOption->getReportmentOption();
        $fields['dst_option_id'] = $ivrOption->getDialExtensionDetailByName($dialExtension_list);
        $fields['action'] = 'editReport';
        $list = json_encode($fields, JSON_PRETTY_PRINT);
        $this->exportType = 'html';
        $this->fileName = 'Report.form.php';
        $this->template($list, $message);
        die();

    }

    /**
     * @Email M.sakhamanesh@googlemail.com
     * @param $fields
     */
    public function editReport($fields)
    {
        global $company_info;
        $Report = new ReportmentService();
        $result = $Report->editReportment($fields);
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
     * @param $ReportID
     */
    public function deleteReport($ReportID)
    {
        global $company_info;
        $input['id'] = $ReportID;
        $input['comp_id'] = $company_info['comp_id'];
        $input['name'] = 'Report';
        $input['dst_option_id'] = '4';
        $checkDependency = new DependencyService;
        $result = $checkDependency->checkDependency($input);

        if ($result['msg'] != '') {
            $this->showAllReport($result['msg']);
            die();
        }

        $Report = new ReportmentService();
        $result = $Report->deleteReportmentByReportmentId($ReportID);

        if ($result['result'] != 1) {
            $result['result'] = -1;
            $result['msg'] = 'Failed To Delete';
            $this->showAllReport($result['msg']);
            die();
        } else {
            $company = new CompanyService();
            $company->activeRelaod($company_info['comp_id']);
            $result['msg'] = 'Successfully Deleted';
            redirectPage(RELA_DIR . 'Report.php?action=showReport', 'Successfully Deleted');
            die();
        }
    }

    public function showReport($msg='')
    {

        $this->exportType = 'html';
        $this->fileName = 'report.show.php';
        $this->template($msg, '');
        die();
    }

    private function _getReport($fields='')
    {

        global $company_info;
        $company_name=$company_info['comp_name'];
        $this->_checkPermission();
        $conn = parent::getConnection();
        $fields['useTrash']='false';
        $filter=$this->filterBuilder($fields);
        $length=$filter['length'];
        $filter=$filter['list'];
        if($filter['order'] =='')
        {
            $filter['order']= 'ORDER BY `calldate` DESC';
        }
        $sql = "
                  SELECT  `t1`.* FROM (SELECT `cdr`.* FROM `cdr` WHERE `cdr`.`dcontext` like '%-$company_name') as t1

        ".$filter['WHERE'] .$filter['filter'].$filter['order'].$filter['limit'];

        //or WHERE    news_id='$id' ");
        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        if (!$stmt)
        {
            $result['result'] = -1;
            $result['no'] = 1;
            $result['msg'] = $conn->errorInfo();
            return $result;
        }

        $sql="

                SELECT
                  Count(`t1`.`cdr_id`) AS `recCount`
                FROM
                  (SELECT *
                  FROM `cdr_view`
                  WHERE `cdr`.`dcontext` LIKE '%-$company_name') AS `t1`

             ".$filter['WHERE'] .$filter['filter'];
        //echo $stmt->rowCount();

        $stmTp = $conn->prepare($sql);
        $stmTp->setFetchMode(PDO::FETCH_ASSOC);
        $stmTp->execute();

        $rowP = $stmTp->fetch();
        $rowFound=$rowP['recCount'];
        $this->_paging['recordsFiltered']=$rowP['recCount'];
        $this->_paging['recordsTotal']= $rowFound['found'];

        while($row = $stmt->fetch())
        {
            $callDate=$row['calldate'];
            list($date, $time) = explode(" ",$callDate);
            list($year, $month, $day) = explode("-", $date);
            list($extension, $compName) = explode("-", $row['dcontext']);
            $row['filename']=RELA_CHANEL.$company_name.'/'.$year.'/'.$month.'/'.$day.'/'.$row['src'].'-'.$row['dst'].'-'.$row['uniqueid'].'.'.'wav';
            $this->_set_reportListDb($row['cdr_id'], $row);
        }


        $result['result'] = 1;
        $result['no'] = 2;
        return $result;
    }

    public function search($get)
    {

        global $company_info;
        include_once(ROOT_DIR . "component/datatable.converter.php");
        $i = 0;
        $columns = array(
            array('db' => 'cdr_id', 'dt' => $i ++),
            array('db' => 'calldate', 'dt' => $i ++),
            array('db' => 'clid', 'dt' => $i ++),
            array('db' => 'src', 'dt' => $i ++),
            array('db' => 'dst', 'dt' => $i ++),
            array('db' => 'channel', 'dt' => $i ++),
            array('db' => 'dstchannel', 'dt' => $i ++),
            array('db' => 'lastapp', 'dt' => $i ++),
            array('db' => 'lastdata', 'dt' => $i ++),
            array('db' => 'duration', 'dt' => $i ++),
            array('db' => 'billsec', 'dt' => $i ++),
            array('db' => 'disposition', 'dt' => $i ++),
            array('db' => 'userfield', 'dt' => $i ++),
            array('db' => 'filename', 'dt' => $i ++)
        );

        //$primaryKey = 'id';
        $convert = new convertDatatableIO();
        $convert->input = $get;
        $convert->columns = $columns;
        $searchFields = $convert->convertInput();
        $operationSearchFields = $searchFields;
        //unset($operationSearchFields['showFields']);

        $reportFilter = $get['filter'];
        $reportResult=$this->getReport($operationSearchFields,$reportFilter);


        $list['list'] = $reportResult['report']['export']['list'];

        $list['paging'] = $reportResult['totalRecord'];
        $j=0;
        foreach ($list['list'] as $key=>$value)
        {
            $j++;
            $company_name=$company_info['comp_name'];
            $list['list'][$key]['counter']=$j;
            $callDate=$list['list'][$key]['calldate'];
            list($date, $time) = explode(" ",$callDate);
            list($year, $month, $day) = explode("-", $date);
            $list['list'][$key]['path']=ROOT_DIR.$company_name.'/'.$year.'/'.$month.'/'.$day.'/'.$list['list'][$key]['uniqueid'].'.'.'wav';
            //$list['list'][$key]['path']= ROOT_DIR.'zitel/monitor/zitel/'.$company_info['comp_id'].'/'.$list['list'][$key]['uniqueid'].'wav';;
        }
        $other['0'] = array(
            'formatter' => function ($list) {
                $st = $list['counter'];
                return $st;
            }
        );
        $other[$i - 1] = array(
            'formatter' => function($list) {
                $st = '<a href="'. $list['path'].'"><i class="fa fa-volume-down text-orange"></i></a>';

                return $st;
            }
        );

        $export = $convert->convertOutput($list, $columns, $other);

        echo json_encode($export);
        die();
    }

    public function getReport($searchFields,$reportFilter)
    {
        global $company_info;
        $company_name=$company_info['comp_name'];
        //print_r_debug($searchFields);
        $report=Report::getAll();
        //$campaigns = Stocks::getAll();
        $report->where('dcontext', 'like', '%-'.$company_name);
        //print_r_debug($report);
        /*if(($reportFilter['startDate']!='') and ($reportFilter['endDate']!=''))
        {
            $report->where('date', '>=', $reportFilter['startDate']) and $report->where('date', '<=', $reportFilter['endDate']);
            //$sql = $report->build();
        }

        else if(isset($reportFilter['startDate']) and $reportFilter['startDate']!='')
        {
            $report->where('date', '>=', $reportFilter['startDate']);
        }

        else if(isset($reportFilter['endDate']) and $reportFilter['endDate']!='')
        {
            $report->where('date', '<=', $reportFilter['endDate']);
        }

        if(($reportFilter['hourStart']!='') and ($reportFilter['hourEnd']!=''))
        {
            $report->where('time', '>=', $reportFilter['hourStart']) and $report->where('time', '<=', $reportFilter['hourEnd']);
            $sql = $report->build();
        }

        else if(isset($reportFilter['hourStart']) and $reportFilter['hourStart']!='')
        {
            $report->where('time', '>=', $reportFilter['hourStart']);
        }
        else if(isset($recordFilter['hourEnd']) and $reportFilter['hourEnd']!='')
        {
            $report->where('time', '<=', $reportFilter['hourEnd']);
        }

        if(isset($reportFilter['src']) and $reportFilter['src']!='')
        {
            $report->where('src', '=', $reportFilter['src']);
        }
        if(isset($reportFilter['dst']) and $reportFilter['dst']!='')
        {
            $report->where('dst', '=', $reportFilter['dst']);
        }



        if(isset($reportFilter['billsec_select']) and $reportFilter['billsec']!='')
        {
            $report->where('billsec', $reportFilter['billsec_select'],$reportFilter['billsec']);
        }
        elseif(isset($reportFilter['billsec']) and $reportFilter['billsec']!='')
        {
            $report->where('billsec', '=', $reportFilter['billsec']);
        }

        $sql = $report->build();
        /*print_r_debug($sql);
        if (isset($searchFields['filter'])) {
            foreach ($searchFields['filter'] as $filter => $value) {
                if ($filter == 'status') {
                    $report->where($filter, '=', $value);
                } else {
                    $report->where($filter, 'like', '%' . $value . '%');
                }

            }
        }*/

        $obj = clone $report;
        //echo '<pre/>';
        $sql = $obj->build('');
        //print_r_debug($sql);

        $sql = str_replace('SELECT *', 'SELECT count(*)', $sql);
        $rs = $obj->query($sql)->getList();

        if (isset($searchFields['order'])) {
            foreach ($searchFields['order'] as $filter => $value) {
                $report->orderBy($filter, $value);
            }
        } else {
            //$report->orderBy('status', 'desc');
            // $report->orderBy('name', 'ASC');

        }

        //$obj = clone $campaigns;

        //$totalRecords = $obj->getList()['export']['recordsCount'];
        $report->limit($searchFields['limit']['start'], $searchFields['limit']['length']);
        //$c = $campaigns->getList();

        $result['report'] = $report->getList();

        $result['totalRecord'] = $rs['export']['list'][0]['count(*)'];
        return $result;
    }


}