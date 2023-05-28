<?php
include_once(ROOT_DIR . "component/report.operation.class.php");

/**
 * @author Malekloo,Izadi,Sakhamanesh <Izadi@dabacenter.ir>
 * @version 0.0.1 this is the beta version of sip
 * @copyright 2015 The Imen Daba Parsian Co.
 */
class report_presentation
{

    /**
     * Contains file type
     *
     * @var
     */
    public $exportType;

    /**
     * Contains file name
     *
     * @var
     */
    public $fileName;

    /**
     * Specifies the type of output
     *
     * @param $list
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    public function template($list = [], $msg = '')
    {
        global $conn, $lang;
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
                return;
                break;

            default:
                break;
        }
    }

    /**
     * search
     *
     * @param   $get
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    10/09/2015
     */
    public function search($get)
    {
        include_once(ROOT_DIR . "component/datatable.converter.php");
        $i = 0;

        /*$columns = array(
            array( 'db' => 'cdr_id', 'dt' =>0 ),
            array( 'db' => 'calldate', 'dt' =>1 ),
            array( 'db' => 'clid', 'dt' =>2 ),
            array( 'db' => 'src',   'dt' => 3),
            array( 'db' => 'dst', 'dt' => 4 ),
            array( 'db' => 'dcontext', 'dt' => 5 ),
            array( 'db' => 'channel', 'dt' => 6 ),
            array( 'db' => 'dstchannel', 'dt' => 7 ),
            array( 'db' => 'lastapp', 'dt' => 8 ),
            array( 'db' => 'lastdata', 'dt' => 9 ),
            array( 'db' => 'duration', 'dt' => 10 ),
            array( 'db' => 'billsec', 'dt' => 11 ),
            array( 'db' => 'disposition', 'dt' => 12 ),
            array( 'db' => 'amaflags', 'dt' => 13 ),
            array( 'db' => 'accountcode', 'dt' => 14 ),
            array( 'db' => 'uniqueid', 'dt' => 15 ),
            array( 'db' => 'userfield', 'dt' => 16 ),
            array( 'db' => 'filename', 'dt' => 17 )
        );*/

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
        $operation = new report_operation();
        $operationSearchFields = $searchFields;
        unset($operationSearchFields['showFields']);
        $operation->getReportList($operationSearchFields);

        $list['list'] = $operation->reportList;
        $list['paging'] = $operation->paging;

        $other[$i - 1] = array(
            'formatter' => function($list) {
                $st = '<a href="' . $list['filename'] . '"><i class="fa fa-volume-down text-orange"></i></a>';

                return $st;
            }
        );


        $export = $convert->convertOutput($list, $columns, $other);
        echo json_encode($export);
        die();
    }

    /**
     * search
     *
     * @param   $get
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    10/09/2015
     */
    public function searchPayment($get)
    {
        include_once(ROOT_DIR . "component/datatable.converter.php");

        $columns = array(
            array('db' => 'id', 'dt' => 0),
            array('db' => 'package_name', 'dt' => 1),
            array('db' => 'duration', 'dt' => 2),
            array('db' => 'extension_count', 'dt' => 3),
            array('db' => 'total_amount', 'dt' => 4),
            array('db' => 'ref_num', 'dt' => 5),
            array('db' => 'status ', 'dt' => 6)
        );

        //$primaryKey = 'id';
        $convert = new convertDatatableIO();
        $convert->input = $get;
        $convert->columns = $columns;
        $searchFields = $convert->convertInput();
        $operation = new report_operation();
        $operationSearchFields = $searchFields;
        unset($operationSearchFields['showFields']);
        $operation->getPaymentReportList($operationSearchFields);

        $list['list'] = $operation->reportList;
        $list['paging'] = $operation->paging;

        $other['0'] = array(

            'formatter' => function($list) {
                $st = '<input type="checkbox" name="reportID[]" id="reportID[]" value="' . $list['id'] . '"/>';

                return $st;
            }
        );

        $other['6'] = array(
            'formatter' => function($list) {
                $st = ($list['status'] == 3 ? SUCCESS : FAILED);

                return $st;
            }
        );

        $export = $convert->convertOutput($list, $columns, $other);
        echo json_encode($export);
        die();
    }

    /**
     * Shows all the reports
     *
     * @param  mixed
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    public function showReport($msg)
    {
        $this->exportType = 'html';
        $this->fileName = 'report.show.php';
        $this->template($msg, '');
        die();
    }

    /**
     * Shows all the reports
     *
     * @param  mixed
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    public function showPaymentReport($msg)
    {
        $this->exportType = 'html';
        $this->fileName = 'payment.report.show.php';
        $this->template($msg, '');
        die();
    }

}

