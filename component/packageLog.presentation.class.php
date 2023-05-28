<?php
include_once(ROOT_DIR . "component/packageLog.operation.class.php");
include_once(ROOT_DIR . "component/company.operation.class.php");
/**
 * @author Malekloo,Izadi,Sakhamanesh <Izadi@dabacenter.ir>
 * @version 0.0.1 this is the beta version of sip
 * @copyright 2015 The Imen Daba Parsian Co.
 */
class packageLog_presentation
{
    /**
     * Contains file type
     * @var
     */
    public $exportType;

    /**
     * Contains file name
     * @var
     */
    public $fileName;

    /**
     * Specifies the type of output
     * @param $list
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    public function template($list = [],$msg = '')
    {
        global $conn, $lang;
        switch($this->exportType)
        {
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
     * @param   $get
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    10/09/2015
     */
    public function searchPackageLog($get)
    {

        include_once(ROOT_DIR . "component/datatable.converter.php");

        $columns = array(
            array( 'db' => 'id', 'dt' =>0 ),
            array( 'db' => 'package_name', 'dt' =>1 ),
            array( 'db' => 'comp_name', 'dt' =>2 ),
            array( 'db' => 'issue_date',   'dt' => 3),
            array( 'db' => 'start_date',   'dt' => 4),
            array( 'db' => 'expire_date', 'dt' => 5 ),
            array( 'db' => 'extension_count', 'dt' => 6 ),
            array( 'db' => 'package_type', 'dt' => 7 ),
            array( 'db' => 'price', 'dt' => 8 ),
            array( 'db' => 'pay_date', 'dt' => 9 ),
            array( 'db' => 'payment_type', 'dt' => 10 )
        );

        //$primaryKey = 'id';
        $convert=new convertDatatableIO();
        $convert->input=$get;
        $convert->columns=$columns;
        $searchFields= $convert->convertInput();
        $operation=new packageLog_operation();
        $operationSearchFields = $searchFields;
        unset($operationSearchFields['showFields']);
        $operation->showPackageLog($operationSearchFields);
        $list['list']=$operation->InvoiceList;
        $list['paging']=$operation->paging;

        $other['0']=array(

            'formatter' =>function($list)
            {

                $st = '<input type="checkbox" name="ID[]" id="ID[]" value="'. $list['id'].'">';


                return $st;
            }
        );

        $export= $convert->convertOutput($list,$columns,$other);
        echo json_encode($export);
        die();
    }


    /**
     * Shows all the sip
     * @param  mixed
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    public function showAllPackageLog($msg)
    {
        $this->exportType = 'html';
        $this->fileName = 'packageLog.show.php';
        $this->template('',$msg);
        die();
    }

    /**
     * Shows all the sip
     * @param  $CompID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    public function getLastPackage($CompID)
    {
        global $conn, $lang;
        $operation = new packageLog_operation();
        $result = $operation->getLastPackage($CompID);

        if ($result['result'] == -1)
        {
            return $result;
        }

        $list = $operation->InvoiceList;
        $this->exportType = 'html';
        $this->fileName = 'package.invoice.show.php';
        $this->template($list,'');
        die();

    }

    /**
     * Shows all the sip
     * @param  $CompID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    public function getLastPackageByOrderFor($CompID)
    {
        global $conn, $lang;
        $operation = new packageLog_operation();
        $result = $operation->getLastPackageByOrderFor($CompID);

        if ($result['result'] == -1)
        {
            return $result;
        }

        $list = $operation->InvoiceList;
        $this->exportType = 'html';
        $this->fileName = 'package.invoice.show.php';
        $this->template($list,'');
        die();

    }

    /**
     * Shows all the sip
     * @param  $invoiceID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    public function addInvoiceToLog($invoiceID)
    {
        global $conn, $lang;
        $operation = new packageLog_operation();

        $result = $operation->addInvoiceToLog($invoiceID);

        if ($result['result'] == -1)
        {
            return $result;
        }

        $list = $operation->InvoiceList;
        $this->exportType = 'html';
        $this->fileName = 'package.invoice.show.php';
        $this->template($list);
        die();
    }

    /**
     * Checks start date for all packages in package Log to see if one should be inserted in package company
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    public function checkStartDate()
    {
        global $conn, $lang;
        $operation = new packageLog_operation();
        $result = $operation->checkStartDateInLog();

        if ($result['result'] == -1)
        {
            return $result;
        }

    }

}

