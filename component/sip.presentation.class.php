<?php
include_once(ROOT_DIR . "component/sip.operation.class.php");
include_once ROOT_DIR . "component/sip/adminSIPModel.php";
include_once ROOT_DIR . "component/company/AdminCompanyModel.php";
include_once ROOT_DIR . "services/CompanyService.php";
include_once ROOT_DIR . "services/SipService.php";


/**
 * @author Malekloo,Izadi,Sakhamanesh <Izadi@dabacenter.ir>
 * @version 0.0.1 this is the beta version of News
 * @copyright 2015 The Imen Daba Parsian Co.
 */
class sip_presentation
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
     * @date    08/08/2015
     */
    public function template($list = [], $msg = '', $message = '')
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
     * @param $get
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    10/09/2015
     */
    public function search($get)
    {
        include_once(ROOT_DIR . "component/datatable.converter.php");

        $columns = array(
            array('db' => 'sip_id', 'dt' => 0),
            array('db' => 'sip_name', 'dt' => 1),
            array('db' => 'codec', 'dt' => 2),
            array('db' => 'host', 'dt' => 3),
            array('db' => 'nat', 'dt' => 4),
            array('db' => 'pass', 'dt' => 5),
            array('db' => 'sip_type', 'dt' => 6),
            array('db' => 'sip_status', 'dt' => 7),
            array('db' => 'comp_name', 'dt' => 8),
            array('db' => 'sip_id', 'dt' => 9)

        );

        //$primaryKey = 'id';
        $convert = new convertDatatableIO();
        $convert->input = $get;
        $convert->columns = $columns;
        $searchFields = $convert->convertInput();
        $operation = new sip_operation();
        $operationSearchFields = $searchFields;
        unset($operationSearchFields['showFields']);
        $operationSearchFields['filter']['trash'] = 0;
        $operation->getSipList($operationSearchFields);

        $list['list'] = $operation->sipList;
        //print_r($list['list']);

        $list['paging'] = $operation->paging;


        $other['9'] = array(

            'formatter' => function ($list) {

                //$st = '<div class="nice-checkbox"><input type="checkbox" class="checkbox-o" name="box[' . $list['news_id'] . ']" value="' . $list['Title'] . '" id="checkbox-o-' . $i . '"><label for="checkbox-o-' . $i . '"></label></div>';

                $st = '<a href="' . RELA_DIR . 'sip.php?action=editSip&id=' . $list['sip_id'] . '"  rel="tooltip" data-original-title="' . EDIT_01 . '">
                                            <i class="fa fa-pencil text-green"></i>
                                        </a>
                                        <a href="' . RELA_DIR . 'sip.php?action=trashSip&id=' . $list['sip_id'] . '"  rel="tooltip" data-original-title="' . DELETE_01 . '">
                                            <i class="fa fa-trash text-red"></i>
                                        </a>';

                return $st;
            }
        );


        $other['7'] = array(

            'formatter' => function ($list) {

                $st = ($list['sip_status'] == 0 ? DISABLED_01 : ENABLE_01);

                return $st;

            }
        );

        $other['4'] = array(

            'formatter' => function ($list) {

                $st = ($list['nat'] == 0 ? DISABLED_01 : ENABLE_01);

                return $st;

            }
        );

        $other['0'] = array(

            'formatter' => function ($list) {

                $st = '<input type="checkbox" name="sipID[]" id="sipID[]" value="' . $list['sip_id'] . '">';


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
     * Shows all the sip
     *
     * @param  $list
     * @param  $msg
     * @param  $message
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function showAllSip($list, $msg, $message)
    {
      
        global  $lang;
        $operation = new sip_operation();
        $operationSearchFields['filter']['trash'] = 0;
        $operation->getSipList($operationSearchFields);
        $list['list'] = $operation->sipList;
        $this->exportType = 'html';
        $this->fileName = 'sip.show.php';
        $this->template($list, $msg, $message);
        die();

    }

    /**
     * Add sip
     *
     * @param $fields
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function addSip($fields)
    {
        global $admin_info, $company_info;
        $checharacter = checkForPersianWordsInMultiDimensionalKeyValueArray($fields);
        if ($checharacter==-1) {
            $result['result'] = -1;
            $result['msg'] = 'You used an illegal character';
            echo json_encode($result);
            die();
        }
        $sip = new SipService();
        $result = $sip->service_AddSip($fields);
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
     * Add Sip form
     *
     * @param $fields
     * @param $msg
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function addSipForm($fields, $msg)
    {
        global $conn, $lang;
        $sip = new SipService();
        $result = $sip->addSipForm();
        $this->exportType = 'html';
        $this->fileName = 'sip.form.php';
        $this->template($result, $msg);
        die();

    }

    /**
     * Edit sip based on its ID
     *
     * @param $fields
     * @param $msg
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */


    public function editSip($fields, $msg)
    {
        global $admin_info, $company_info;
        $checharacter = checkForPersianWordsInMultiDimensionalKeyValueArray($fields);
        if ($checharacter==-1) {
            $result['result'] = -1;
            $result['msg'] = 'You used an illegal character';
            echo json_encode($result);
            die();
        }
        $sip = new SipService();
        $result = $sip->service_editSip($fields);
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
     * Show edit sip form based on its ID
     *
     * @param $sipID
     * @param $msg
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function editSipForm($sipID, $msg)
    {
        global $conn, $lang;
        $sip = new SipService();
        $result = $sip->editSipForm($sipID);
        $this->exportType = 'html';
        $this->fileName = 'sip.form.php';
        $this->template($result, $msg);
        die();
    }

    /**
     * Deletes Sip based on its ID
     *
     * @param $sipID
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function deleteSip_temp($sipID)
    {
        global $conn, $lang;
        $operation = new sip_operation();
        $result = $operation->deleteSip($sipID);


        if ($result['result'] == -1) {
            return $result;
        } else {
            $msg = ModelEXTENSION_11;
            redirectPage(RELA_DIR . "trash.php?action=showSipTrash", $msg);
        }
    }


    /**
     * changeStatus Sip based on its ID
     *
     * @param  $fields
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function changeStatus($fields)
    {
        global $conn, $lang;
        $operation = new sip_operation();
        $result = $operation->set_IDs($fields['sipID']);
        if ($result['result'] == -1) {
            return $result;
        }
        $result = $operation->changeStatus($fields['status']);
        if ($result['result'] == -1) {
            return $result;
        } else {
            $this->showAllSip('', '');
        }
    }

    /**
     * Trashes SIP based on its ID
     *
     * @param $sipID
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function deleteSip($sipID)
    {
        global $conn, $lang, $company_info;
        $operation = new sip_operation();
        $found = 0;
        include_once ROOT_DIR . 'services/dependency/DependencyService.php';
        $checkDependency = new DependencyService;
        $input['id'] = $sipID;
        $input['comp_id'] = $company_info['comp_id'];
        $input['name'] = 'Sip';
        $input['dst_option_id'] = '1';

        $result = $checkDependency->checkDependency($input);
        if ($result['msg'] != '') {
            $this->showAllSip('', $result['msg'], '');
            die();
        }

        if ($found == 1) {
            $this->exportType = 'html';
            $this->fileName = 'sip.show.php';
            $this->showAllSip('', '', $result);
            die();
        }

        $result = $operation->deleteSip($sipID);


        if ($result['result'] == -1) {
            return $result;
        } else {
            $msg = ModelEXTENSION_11;
            redirectPage(RELA_DIR . "sip.php", $msg);
        }
    }

    /**
     * Recycles SIP based on its ID
     *
     * @param $sipID
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function recycleSips($sipID)
    {
        global $conn, $lang;
        $operation = new sip_operation();
        $result = $operation->getSipListById($sipID);

        if ($result['result'] == -1) {
            return $result;
        }

        $sipName = $operation->sipInfo['sip_name'];
        $compID = $operation->sipInfo['comp_id'];
        $nameResult = $operation->checkIfNameExists($sipName, $compID);

        if ($nameResult['rowCount'] >= 1) {
            $msg = ModelINBOUND_13;
            include_once(ROOT_DIR . "component/trash.presentation.class.php");
            $operation = new trash_presentation();
            $result = $operation->showSipTrash('', $msg);
            if ($result['result'] == -1) {
                return $result;
            }
        }
        $result = $operation->recycleSips($sipID);


        if ($result['result'] == -1) {
            return $result;
        } else {
            $msg = ModelANNOUNCE_07;
            redirectPage(RELA_DIR . "sip.php", $msg);
        }
    }


    /**
     * Checks if extensions exists based on comp ID
     *
     * @param $sipID
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function checkAnnounceDependency($sipID)
    {
        $operation = new sip_operation();
        $result = $operation->checkAnnounceDependency($sipID);

        return $result;
    }

    /**
     * Checks if extensions exists based on comp ID
     *
     * @param $sipID
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function checkInboundDependency($sipID)
    {
        $operation = new sip_operation();
        $result = $operation->checkInboundDependency($sipID);

        return $result;
    }

    /**
     * Checks if extensions exists based on comp ID
     *
     * @param $sipID
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function checkQueueDependency($sipID)
    {
        $operation = new sip_operation();
        $result = $operation->checkQueueDependency($sipID);

        return $result;
    }

    /**
     * Checks if extensions exists based on comp ID
     *
     * @param $sipID
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function checkIvrDependency($sipID)
    {
        $operation = new sip_operation();
        $result = $operation->checkIvrDependency($sipID);

        return $result;
    }

    /**
     * Checks if extensions exists based on comp ID
     *
     * @param $sipID
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function checkOutboundDependency($sipID)
    {
        $operation = new sip_operation();
        $result = $operation->checkOutboundDependency($sipID);

        return $result;
    }

}


