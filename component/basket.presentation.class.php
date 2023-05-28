<?php
include_once(ROOT_DIR . "component/basket.operation.class.php");

/**
 * @author Malekloo,Izadi,Sakhamanesh <Izadi@dabacenter.ir>
 * @version 0.0.1 this is the beta version of sip
 * @copyright 2015 The Imen Daba Parsian Co.
 */
class basket_presentation
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

        $columns = array(
            array('db' => 'package_group_id', 'dt' => 0),
            array('db' => 'package_group_name', 'dt' => 1),
            array('db' => 'package_group_status', 'dt' => 2)
        );

        //$primaryKey = 'id';
        $convert = new convertDatatableIO();
        $convert->input = $get;
        $convert->columns = $columns;
        $searchFields = $convert->convertInput();
        $operation = new Package_operation();
        $operationSearchFields = $searchFields;
        unset($operationSearchFields['showFields']);
        $operation->getGroupPackageList($operationSearchFields);
        $list['list'] = $operation->PackageList;
        $list['paging'] = $operation->paging;
        $other['3'] = array(

            'formatter' => function($list) {

                //$st = '<div class="nice-checkbox"><input type="checkbox" class="checkbox-o" name="box[' . $list['news_id'] . ']" value="' . $list['Title'] . '" id="checkbox-o-' . $i . '"><label for="checkbox-o-' . $i . '"></label></div>';

                $st = '<a href="' . RELA_DIR . 'package.php?action=editGroupPackage&id=' . $list['package_group_id'] . '"  rel="tooltip" data-original-title="' . EDIT_01 . '">
                                            <i class="fa fa-pencil text-green"></i>
                                        </a>
                                        <a href="' . RELA_DIR . 'package.php?action=deleteGroupPackage&id=' . $list['package_group_id'] . '"  rel="tooltip" data-original-title="' . DELETE_01 . '">
                                            <i class="fa fa-trash text-red"></i>
                                        </a>';

                return $st;
            }
        );

        $other['0'] = array(

            'formatter' => function($list) {

                $st = '<input type="checkbox" name="groupPackageID[]" id="groupPackageID[]" value="' . $list['package_group_id'] . '">';


                return $st;
            }
        );

        $other['2'] = array(

            'formatter' => function($list) {

                $st = ($list['package_group_status'] == 0 ? DISABLED_01 : ENABLE_01);

                return $st;

            }
        );

        //$other[2]='news={$news_id}';

        //$other[2]='<div class="nice-checkbox"><input type="checkbox" class="checkbox-o" name="box[{$news_id}]" value="{$Title}" id="checkbox-o-'.$i.'"><label for="checkbox-o-'.$i.'"></label></div>';
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
    public function searchPackage($get)
    {
        include_once(ROOT_DIR . "component/datatable.converter.php");

        $columns = array(
            array('db' => 'id', 'dt' => 0),
            array('db' => 'package_name', 'dt' => 1),
            array('db' => 'price', 'dt' => 2),
            array('db' => 'extension_count', 'dt' => 3),
            array('db' => 'duration', 'dt' => 4),
            array('db' => 'package_group_name', 'dt' => 5),
            array('db' => 'package_status', 'dt' => 6),
            array('db' => 'id', 'dt' => 7)
        );

        //$primaryKey = 'id';
        $convert = new convertDatatableIO();
        $convert->input = $get;
        $convert->columns = $columns;
        $searchFields = $convert->convertInput();
        $operation = new Package_operation();
        $operationSearchFields = $searchFields;
        unset($operationSearchFields['showFields']);
        $operation->getPackageList($operationSearchFields);
        $list['list'] = $operation->PackageList;
        $list['paging'] = $operation->paging;

        $other['6'] = array(

            'formatter' => function($list) {

                //$st = '<div class="nice-checkbox"><input type="checkbox" class="checkbox-o" name="box[' . $list['news_id'] . ']" value="' . $list['Title'] . '" id="checkbox-o-' . $i . '"><label for="checkbox-o-' . $i . '"></label></div>';

                $st = ($list['package_status'] == 0 ? DISABLED_01 : ENABLE_01);

                return $st;
            }
        );

        $other['7'] = array(

            'formatter' => function($list) {

                //$st = '<div class="nice-checkbox"><input type="checkbox" class="checkbox-o" name="box[' . $list['news_id'] . ']" value="' . $list['Title'] . '" id="checkbox-o-' . $i . '"><label for="checkbox-o-' . $i . '"></label></div>';

                $st = '<a href="' . RELA_DIR . 'package.php?action=editPackage&id=' . $list['id'] . '"  rel="tooltip" data-original-title="' . EDIT_01 . '">
                                            <i class="fa fa-pencil text-green"></i>
                                        </a>
                                        <a href="' . RELA_DIR . 'package.php?action=deletePackage&id=' . $list['id'] . '"  rel="tooltip" data-original-title="' . DELETE_01 . '">
                                            <i class="fa fa-trash text-red"></i>
                                        </a>';

                return $st;
            }
        );

        $other['0'] = array(

            'formatter' => function($list) {

                $st = '<input type="checkbox" name="ID[]" id="ID[]" value="' . $list['id'] . '">';


                return $st;
            }
        );

        //$other[2]='news={$news_id}';
        //$other[2]='<div class="nice-checkbox"><input type="checkbox" class="checkbox-o" name="box[{$news_id}]" value="{$Title}" id="checkbox-o-'.$i.'"><label for="checkbox-o-'.$i.'"></label></div>';
        $export = $convert->convertOutput($list, $columns, $other);
        echo json_encode($export);
        die();
    }

    /**
     * Shows All Group Packages
     *
     * @param  mixed
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    public function showAllGroupPackages($msg)
    {
        $this->exportType = 'html';
        $this->fileName = 'package.group.show.php';
        $this->template($msg);
        die();
    }

    /**
     * Show Basket
     *
     * @param  mixed
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    public function showBasket($msg)
    {
        global $conn, $lang, $admin_info, $company_info;
        $operation = new basket_operation();
        $comp_id = $company_info['comp_id'];
        $input['comp_id'] = $comp_id;
        $result = $operation->getBasketList($input);

        if ($result['result'] != 1) {
            return $result['msg'];
        }

        $list = $operation->basketList;
        $this->exportType = 'html';
        $this->fileName = 'basket.show.php';
        $this->template($list, $msg);
        die();
    }


    /**
     * Delete Basket based on ID
     *
     * @param $BasketID
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    public function deleteBasket($BasketID)
    {
        global $conn, $lang;
        $operation = new basket_operation();
        $result = $operation->removeInvoice($BasketID);

        if ($result['result'] == - 1) {
            return $result;
        } else {
            $msg = ModelBASCKET_16;
            redirectPage(RELA_DIR . "basket.php", $msg);
        }
    }


    /**
     * Add To Basket
     *
     * @param $input
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    public function addToBasket($input)
    {
        global $conn, $lang;

        $fields = $this->getSalablePackageByID($input);
        $fields['order_for'] = $input['comp_id'];
        $fields['package_id'] = $input['package_id'];
        $operation = new basket_operation();

        $result = $operation->set_basketInfo($fields);

        if ($result['result'] != 1) {
            return $result['msg'];

        }

        $result = $operation->addPackageToBasket();

        if ($result['result'] == - 1) {
            return $result;
        } else {
            $msg = ModelBASCKET_17;
            redirectPage(RELA_DIR . "basket.php", $msg);
        }
    }


    /**
     * Get Salable Package By packageID
     *
     * @param $packageID
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    public function getSalablePackageByID($packageID)
    {
        global $conn, $lang;
        $operation = new basket_operation();

        $result = $operation->getSalablePackageListById($packageID);

        if ($result['result'] == '0') {
            return $result['msg'];

        }

        return $operation->basketInfo;
    }


    /**
     * Send Invoice
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    public function sendInvoice()
    {
        global $conn, $lang, $admin_info, $company_info;
        $operation = new basket_operation();
        $compID = $company_info['comp_id'];
        $result = $operation->sendInvoice($compID);
        $keys = array_keys($operation->basketInfo);
        $invoice_id = $operation->basketInfo[$keys['0']]['invoice_id'];

        if ($result['result'] == '0') {
            return $result['msg'];
        } else {
            redirectPage(RELA_DIR . "payment.php?action=onlinePayment&InvoiceID=" . $invoice_id . "", ModelBASCKET_18);
        }
    }
}
