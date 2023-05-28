<?php
include_once(ROOT_DIR . "component/package.operation.class.php");
include_once(ROOT_DIR . "component/company.operation.class.php");
/**
 * @author Malekloo,Izadi,Sakhamanesh <Izadi@dabacenter.ir>
 * @version 0.0.1 this is the beta version of sip
 * @copyright 2015 The Imen Daba Parsian Co.
 */
class package_presentation
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
    public function template($list = [], $msg = '')
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
    public function searchSalable($get)
    {
        include_once(ROOT_DIR . "component/datatable.converter.php");
        $compID =   $get['comp_id'];
        unset($get['comp_id']);
        $columns = array(
            array( 'db' => 'id', 'dt' =>0 ),
            array( 'db' => 'package_name',   'dt' => 1),
            array( 'db' => 'price',   'dt' => 2),
            array( 'db' => 'extension_count', 'dt' => 3 ),
            array( 'db' => 'expire_date', 'dt' => 4 ),
            array( 'db' => 'start_date', 'dt' => 5 ),
            array( 'db' => 'new_expire_date', 'dt' => 6 ),
            array( 'db' => 'duration', 'dt' => 7 ),
            array( 'db' => 'package_group_name', 'dt' => 8 ),
            array( 'db' => 'package_status', 'dt' => 9 ),
            array( 'db' => 'comp_id', 'dt' => 10 )
        );
        // array( 'db' => 'expire_date', 'dt' => 4 ),
        //$primaryKey = 'id';
        $convert=new convertDatatableIO();
        $convert->input=$get;
        $convert->columns=$columns;
        $searchFields= $convert->convertInput();
        $operation=new Package_operation();
        $operationSearchFields = $searchFields;
        unset($operationSearchFields['showFields']);
        $operation->getSalablePackageList($operationSearchFields,$compID);
        $list['list']=$operation->PackageList;
        $list['paging']=$operation->paging;

        $other['9']=array(

            'formatter' =>function($list)
            {

                //$st = '<div class="nice-checkbox"><input type="checkbox" class="checkbox-o" name="box[' . $list['news_id'] . ']" value="' . $list['Title'] . '" id="checkbox-o-' . $i . '"><label for="checkbox-o-' . $i . '"></label></div>';

                $st = ($list['package_status'] == 0 ? DISABLED_01 : ENABLE_01);
                return $st;
            }
        );

        $other['10']=array(

            'formatter' =>function($list)
            {

                //$st = '<div class="nice-checkbox"><input type="checkbox" class="checkbox-o" name="box[' . $list['news_id'] . ']" value="' . $list['Title'] . '" id="checkbox-o-' . $i . '"><label for="checkbox-o-' . $i . '"></label></div>';

                $st ='
                    <a href="'.RELA_DIR.'basket.php?action=addToBasket&comp_id='. $list['comp_id'].'&package_id='. $list['id'].'"  rel="tooltip" data-original-title="'. DELETE_01 .'">
                        <i class="fa fa-shopping-cart text-orange"></i>
                    </a>
                    ';
                return $st;
            }
        );

        $other['0']=array(

            'formatter' =>function($list)
            {

                $st = '<input type="checkbox" name="ID[]" id="ID[]" value="'. $list['id'].'">';


                return $st;
            }
        );

        //$other[2]='news={$news_id}';
        //$other[2]='<div class="nice-checkbox"><input type="checkbox" class="checkbox-o" name="box[{$news_id}]" value="{$Title}" id="checkbox-o-'.$i.'"><label for="checkbox-o-'.$i.'"></label></div>';
        $export= $convert->convertOutput($list,$columns,$other);
        echo json_encode($export);
        die();
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
    public function searchBuyPackageForCompany($get)
    {
        include_once(ROOT_DIR . "component/datatable.converter.php");

        $columns = array(
            array( 'db' => 'comp_id', 'dt' =>0 ),
            array( 'db' => 'Comp_Name',   'dt' => 1),
            array( 'db' => 'Manager_Name',   'dt' => 2),
            array( 'db' => 'Address', 'dt' => 3 ),
            array( 'db' => 'Phone_Number', 'dt' => 4 ),
            array( 'db' => 'Email', 'dt' => 5 ),
            array( 'db' => 'Comp_Status', 'dt' => 6 ),
            array( 'db' => 'comp_id', 'dt' => 7 )
        );
       // array( 'db' => 'expire_date', 'dt' => 4 ),
        //$primaryKey = 'id';
        $convert=new convertDatatableIO();
        $convert->input=$get;
        $convert->columns=$columns;
        $searchFields= $convert->convertInput();
        $operation=new Package_operation();
        $operationSearchFields = $searchFields;
        unset($operationSearchFields['showFields']);
        $operation->getCompanyList($operationSearchFields);
        $list['list']=$operation->PackageList;
        $list['paging']=$operation->paging;

        $other['6']=array(

            'formatter' =>function($list)
            {
                //$st = '<div class="nice-checkbox"><input type="checkbox" class="checkbox-o" name="box[' . $list['news_id'] . ']" value="' . $list['Title'] . '" id="checkbox-o-' . $i . '"><label for="checkbox-o-' . $i . '"></label></div>';
                $st = ($list['Comp_Status'] == 0 ? DISABLED_01 : ENABLE_01);
                return $st;
            }
        );

        $other['7']=array(

            'formatter' =>function($list)
            {
                //$st = '<div class="nice-checkbox"><input type="checkbox" class="checkbox-o" name="box[' . $list['news_id'] . ']" value="' . $list['Title'] . '" id="checkbox-o-' . $i . '"><label for="checkbox-o-' . $i . '"></label></div>';
                $st ='
                    <a href="'.RELA_DIR.'package.php?action=buyPackageForCompany&comp_id='. $list['comp_id'].'"  rel="tooltip" data-original-title="'. DELETE_01 .'">
                        <i class="fa fa-shopping-cart text-orange"></i>
                    </a>
                    ';
                return $st;
            }
        );

        $other['0']=array(

            'formatter' =>function($list)
            {
                $st = '<input type="checkbox" name="ID[]" id="ID[]" value="'. $list['comp_id'].'">';
                return $st;
            }
        );

        //$other[2]='news={$news_id}';

        //$other[2]='<div class="nice-checkbox"><input type="checkbox" class="checkbox-o" name="box[{$news_id}]" value="{$Title}" id="checkbox-o-'.$i.'"><label for="checkbox-o-'.$i.'"></label></div>';
        $export= $convert->convertOutput($list,$columns,$other);
        echo json_encode($export);
        die();
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
    public function searchCompanyPackage($get)
    {

        include_once(ROOT_DIR . "component/datatable.converter.php");

        $columns = array(
            array( 'db' => 'id', 'dt' =>0 ),
            array( 'db' => 'comp_name',   'dt' => 1),
            array( 'db' => 'package_name',   'dt' => 2),
            array( 'db' => 'price',   'dt' => 3),
            array( 'db' => 'extension_count', 'dt' => 4 ),
            array( 'db' => 'package_usage', 'dt' => 5 ),
            array( 'db' => 'package_usage', 'dt' => 6 ),
            array( 'db' => 'duration', 'dt' => 7 ),
            array( 'db' => 'assign_date', 'dt' => 8 ),
            array( 'db' => 'start_date', 'dt' => 9 ),
            array( 'db' => 'expire_date', 'dt' => 10 )
        );

        //$primaryKey = 'id';
        $convert=new convertDatatableIO();
        $convert->input=$get;
        $convert->columns=$columns;
        $searchFields= $convert->convertInput();
        $operation=new Package_operation();
        $operationSearchFields = $searchFields;
        unset($operationSearchFields['showFields']);
        $operation->getCompanyPackageList($operationSearchFields);
        $list['list']=$operation->PackageList;
        $list['paging']=$operation->paging;
        
        $other['6']=array(

            'formatter' =>function($list)
            {


                $st = ($list['extension_count'] - $list['package_usage']);
                return $st;
            }
        );

        $other['0']=array(

            'formatter' =>function($list)
            {

                $st = '<input type="checkbox" name="ID[]" id="ID[]" value="'. $list['id'].'">';


                return $st;
            }
        );

        //$other[2]='news={$news_id}';
        //$other[2]='<div class="nice-checkbox"><input type="checkbox" class="checkbox-o" name="box[{$news_id}]" value="{$Title}" id="checkbox-o-'.$i.'"><label for="checkbox-o-'.$i.'"></label></div>';
        $export= $convert->convertOutput($list,$columns,$other);
        echo json_encode($export);
        die();
    }

    /**
     * Shows all the Salable Packages
     * @param  $id
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    public function buyPackageForCompany($id)
    {
        $this->exportType = 'html';
        $this->fileName = 'package.company.salable.show.php';
        $this->template($id);
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
    public function showAllCompanyPackages($msg)
    {
        $this->exportType = 'html';
        $this->fileName = 'package.company.show.php';
        $this->template($msg, '');
        die();
    }

  /**
     * Shows all the invoices
     * @param  mixed
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    public function showAllInvoice($msg)
    {
        global $conn, $lang;
        $operation = new Package_operation();
        $result = $operation->showInvoice();

        if ($result['result'] == -1)
        {
            return $result;
        }
        $list = $operation->PackageList;
        $this->exportType = 'html';
        $this->fileName = 'package.invoice.show.php';
        $this->template($list, $msg);
        die();
    }

    /**
     * Shows all the companies
     * @param  mixed
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    public function showAllCompanies()
    {
        $this->exportType = 'html';
        $this->fileName = 'package.buyFor.company.show.php';
        $this->template('', '');
        die();
    }

}

