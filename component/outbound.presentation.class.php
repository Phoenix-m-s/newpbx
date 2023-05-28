<?php
include_once(ROOT_DIR . "component/outbound.operation.class.php");
include_once ROOT_DIR . "component/outbound/adminOutboundModel.php";

/**
 * @author Malekloo,Izadi,Sakhamanesh <Izadi@dabacenter.ir>
 * @version 0.0.1 this is the beta version of outbound
 * @copyright 2015 The Imen Daba Parsian Co.
 */
class

outbound_presentation
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
     * @date    05/09/2015
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
            array('db' => 'priority', 'dt' => 0),
            array('db' => 'outbound_name', 'dt' => 1),
            array('db' => 'sip_name', 'dt' => 2),
            array('db' => 'outbound_status', 'dt' => 3),
            array('db' => 'outbound_id', 'dt' => 4),
            array('db' => 'comp_name', 'dt' => 5)
        );

        //$primaryKey = 'id';
        $convert = new convertDatatableIO();
        $convert->input = $get;
        $convert->columns = $columns;
        $searchFields = $convert->convertInput();
        $operation = new outbound_operation();
        $operationSearchFields = $searchFields;
        unset($operationSearchFields['showFields']);
        $operationSearchFields['filter']['trash'] = 0;
        $operation->getOutboundList($operationSearchFields);

        $list['list'] = $operation->outboundList;

        $list['paging'] = $operation->paging;


        $other['3'] = array(

            'formatter' => function($list) {

                $st = ($list['outbound_status'] == 0 ? DISABLED_01 : ENABLE_01);

                return $st;

            }
        );

        $other['4'] = array(

            'formatter' => function($list) {

                //$st = '<div class="nice-checkbox"><input type="checkbox" class="checkbox-o" name="box[' . $list['news_id'] . ']" value="' . $list['Title'] . '" id="checkbox-o-' . $i . '"><label for="checkbox-o-' . $i . '"></label></div>';

                $st = '<a href="' . RELA_DIR . 'outbound.php?action=showDialPattern&id=' . $list['outbound_id'] . '"  rel="tooltip" data-original-title="' . DETAILS . '">
                                            <i class="fa fa-tasks text-orange"></i>
                                        </a>';


                return $st;
            }
        );
        $other['6'] = array(

            'formatter' => function($list) {

                //$st = '<div class="nice-checkbox"><input type="checkbox" class="checkbox-o" name="box[]' . $list['outbound_id'] . ']" value="' . $list['Title'] . '" id="checkbox-o-' . $i . '"><label for="checkbox-o-' . $i . '"></label></div>';

                $st = '<a href="' . RELA_DIR . 'outbound.php?action=editOutbound&id=' . $list['outbound_id'] . '"  rel="tooltip" data-original-title="' . EDIT_01 . '">
                                            <i class="fa fa-pencil text-green"></i>
                                        </a>
                                        <a href="' . RELA_DIR . 'outbound.php?action=trashOutbound&id=' . $list['outbound_id'] . '"  rel="tooltip" data-original-title="' . DELETE_01 . '">
                                            <i class="fa fa-trash text-red"></i>
                                        </a>';

                return $st;
            }
        );


        $other['0'] = array(

            'formatter' => function($list) {

                $st = '<input type="checkbox" name="outboundID[]" id="outboundID[]" value="' . $list['outbound_id'] . '">';

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
     * Shows the detail of each Outbound based on its ID
     *
     * @param $id
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    05/09/2015
     */
    public function showOutboundDetail($id)
    {
        global $conn, $lang;

        $operation = new news_operation();
        $news_result = $operation->getNewsListById($id);
        $this->exportType = 'html';
        $this->fileName = 'newsdetail.tpl';
        $this->template($operation->newsList);
        die();

    }

    /**
     * Shows all the Outbound
     *
     * @param   $list
     * @param   $msg
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    05/09/2015
     */
    public function showAllOutbound($list, $msg)
    {


        global $conn, $lang;
        $operation = new outbound_operation();
        $operationSearchFields['filter']['trash'] = 0;
        $operation->getOutboundList($operationSearchFields);
        $list['list'] = $operation->outboundList;
        $this->exportType = 'html';
        $this->fileName = 'outbound.show.php';
        $this->template($list, $msg);
        die();
    }

    /**
     * Add Outbound
     *
     * @param   $fields
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    05/09/2015
     */
    public function addOutbound($fields)
    {
        $token_list = array_keys($fields['token']);
        $token = $token_list['0'];
        if (isset($_SESSION['token'][$token]) and $_SESSION['token'][$token] == '1') {
            unset($_SESSION['token'][$token]);
        } else {
            $this->addOutboundForm($fields, '');
        }

        /*include_once(ROOT_DIR . "component/package.db.class.php");
        $package = new Package_db;
        $packageResult = $package->checkExtensionCount();

        if ($packageResult['result'] != '1') {
            $this->exportType = 'html';
            $this->fileName = 'outbound.show.php';
            $this->template('', $packageResult['msg']);
            die();
        }*/

        global $conn, $lang;
        $operation = new outbound_operation();

        foreach ($operation->addForm as $key => $val) {
            $input_fields[$key] = $fields[$key];
        }

        $result = $operation->set_OutboundInfo($input_fields);

        if ($result['result'] != 1) {
            $this->addOutboundForm($fields, $result['msg']);
        }

        $result = $operation->set_dialPatternInfo($fields);

        if ($result['result'] != 1) {
            $this->addOutboundForm($fields, $result['msg']);
        }

        $outboundInfo = $operation->outboundInfo['outbound_name'];
        $compID = $operation->outboundInfo['comp_id'];
        $nameResult = $operation->checkIfNameExists($outboundInfo, $compID);

        if ($nameResult['rowCount'] >= 1) {
            $msg = ModelANNOUNCE_01;
            $this->addOutboundForm($fields, $msg);
        }

        $result = $operation->insertOutbound();

        if ($result['result'] != 1) {
            $this->addOutboundForm($fields, $result['msg']);
        } else {
            $result = $operation->insertOutboundToDialPattern($operation->outboundInfo['outbound_id']);
            if ($result == - 1) {
                return $result['msg'];
            }
        }
        redirectPage(RELA_DIR . "outbound.php", ModelANNOUNCE_02);

        die();
    }

    public static function updateReload()
    {
        global $company_info;
        $conn = dbConn::getConnection();

        $sql = "
                UPDATE tbl_company
                SET
                reload_alert =   '1'
                WHERE comp_id = '" . $company_info['comp_id'] . "' ";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result['result'] = '1';

        return $result;
    }

    /**
     * Add outbound form
     *
     * @param $fields
     * @param $msg
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    05/09/2015
     */
    public function addOutboundForm($fields, $msg)
    {

        global $conn, $lang;
        $fields['DSTList'] = $this->getAllDstOption();
        $fields['sipList'] = $this->getSipList();
        $this->exportType = 'html';
        $this->fileName = 'outbound.add.form.php';

        //*****
        $uniqid = uniqid();
        $_SESSION['token'][$uniqid] = '1';
        $fields['token'] = 'token[' . $uniqid . ']';
        $fields['priority'] = $this->checkPriority();
        //*****

        $this->template($fields, $msg);
        die();

    }

    /**
     * Add Outbound form
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    05/09/2015
     */
    public function getAllDstOption()
    {
        include_once(ROOT_DIR . "component/dstOption.operation.class.php");
        $operation = new dstOption_operation();
        $result = $operation->getDstOptionList();

        if ($result['result'] == - 1) {
            return $result['msg'];
        }

        return $operation->dstOptionList;

    }

    /**
     * Edit outbound based on its ID
     *
     * @param $fields
     * @param $msg
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    05/09/2015
     */
    public function editOutbound($fields, $msg)
    {
        global $conn, $lang;
        $operation = new outbound_operation();

        foreach ($operation->editForm as $key => $val) {
            $input_fields[$key] = $fields[$key];
        }
        $result = $operation->set_OutboundInfo($input_fields);

        if ($result['result'] != 1) {
            $this->editOutboundForm($fields['outbound_id'], $result['msg']);
        }
        $result = $operation->set_dialPatternInfo($fields);

        if ($result['result'] == - 1) {
            $this->editOutboundForm($fields['outbound_id'], $result['msg']);
            die();
        }

        $outboundInfo = $operation->outboundInfo['outbound_name'];
        $compID = $operation->outboundInfo['comp_id'];
        $nameResult = $operation->checkIfNameExists($outboundInfo, $compID);

        if ($nameResult['rowCount'] >= 2) {
            $msg = ModelINBOUND_13;
            $this->addOutboundForm($fields, $msg);
        }

        $result = $operation->updateOutbound();

        if ($result['result'] == - 1) {
            $this->editOutboundForm($fields['outbound_id'], $result['msg']);
            die();
        }

        $result = $operation->updateOutboundToDialPattern($operation->outboundInfo['outbound_id']);

        if ($result == - 1) {
            $this->editOutboundForm($fields['outbound_id'], $result['msg']);
            die();
        }

        redirectPage(RELA_DIR . "outbound.php", ModelINBOUND_14);
        die();
    }

    /**
     * Show edit outbound form based on its ID
     *
     * @param   $outboundID
     * @param   $msg
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    05/09/2015
     */
    public function editOutboundForm($outboundID, $msg)
    {

        global $conn, $lang;
        $operation = new outbound_operation();
        $result = $operation->getOutboundListById($outboundID);

        if ($result['result'] == '0') {
            return $result['msg'];

        }

        $list['outboundInfo'] = $operation->outboundInfo;
        $list['outboundDialPatternInfo'] = $operation->outboundDialPatternInfo;
        $list['sipList'] = $this->getSipList();
        $this->exportType = 'html';
        $list['priority'] = $this->checkPriority();
        //print_r_debug($list);
        $this->fileName = 'outbound.edit.form.php';
        $this->template($list, $msg);
        die();
    }


    /**
     * Shows all the Dial Pattern
     *
     * @return  mixed
     *
     * @param $outboundID
     *
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function showAllDialPattern($outboundID)
    {
        global $conn, $lang;
        $operation = new outbound_operation();
        $result = $operation->getOutboundListById($outboundID);


        if ($result['result'] != 1) {
            return $result['msg'];
        }

        $this->exportType = 'html';
        $this->fileName = 'outbound.dialpattern.show.php';

        $list['outboundDialPatternInfo'] = $operation->outboundDialPatternInfo;

        $this->template($list);
        die();

    }

    /**
     * Deletes outbound based on its ID
     *
     * @param $outboundID
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    05/09/2015
     */
    public function deleteOutbound($outboundID)
    {
        global $conn, $lang;
        $operation = new outbound_operation();
        $result = $operation->deleteOutbound($outboundID);



        if ($result['result'] == - 1) {
            return $result;
        } else {
            $msg = ModelEXTENSION_11;
            redirectPage(RELA_DIR . "outbound.php?action=showOutbound", $msg);
        }
    }


    /**
     * changeStatus Outbound based on its ID
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

        $operation = new outbound_operation();

        $result = $operation->set_IDs($fields['outboundID']);
        if ($result['result'] == - 1) {
            return $result;
        }
        $result = $operation->changeStatus($fields['status']);

        if ($result['result'] == - 1) {
            return $result;
        } else {
            $this->showAllOutbound('', '');
        }
    }

    /**
     * Add Outbound form
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    05/09/2015
     */
    public function getSipList()
    {
        include_once(ROOT_DIR . "component/sip.operation.class.php");
        $operation = new sip_operation();
        $result = $operation->getSipList();

        if ($result['result'] == - 1) {
            return $result['msg'];
        }

        return $operation->sipList;

    }


    /**
     * Recycles outbound based on its ID
     *
     * @param $outboundID
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function recycleOutbounds($outboundID)
    {
        global $conn, $lang;
        $operation = new outbound_operation();
        $result = $operation->getOutboundListById($outboundID);

        if ($result['result'] == - 1) {
            return $result;
        }

        $outboundName = $operation->outboundInfo['outbound_name'];
        $compID = $operation->outboundInfo['comp_id'];
        $nameResult = $operation->checkIfNameExists($outboundName, $compID);

        if ($nameResult['rowCount'] >= 1) {
            $msg = "This name exists";
            include_once(ROOT_DIR . "component/trash.presentation.class.php");
            $operation = new trash_presentation();
            $result = $operation->showOutboundTrash('', $msg);
            if ($result['result'] == - 1) {
                return $result;
            }
        }

        $result = $operation->recycleOutbound($outboundID);


        if ($result['result'] == - 1) {
            return $result;
        } else {
            $msg = ModelANNOUNCE_07;
            redirectPage(RELA_DIR . "outbound.php", $msg);
        }
    }

    /**
     * Trashes outbounds based on its ID
     *
     * @param $outboundID
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function trashOutbounds($outboundID)
    {
        //global $conn, $lang;
        $operation = new outbound_operation();

        $result = $operation->trashOutbound($outboundID);

        if ($result['result'] == - 1) {
            return $result;
        } else {
            $msg = ModelANNOUNCE_06;
            redirectPage(RELA_DIR . "outbound.php", $msg);
        }
    }
    /**
     * this method outbounds based on checkPriority
     *
     *
     *
     * @return  mixed
     * @author  Sakhamanesh,
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function checkPriority(){

        $queueDirty = AdminOutboundModel::getAll()->getList();

        $OutboundClean = $queueDirty['export']['list'];
        $cnt=0;
        foreach ($OutboundClean as $key => $value) {
            $res[ $cnt ]['priorityNum'] = $value['priority'];
            $a[ $value['priority'] ]['outbound_name'] = $value['outbound_name'];
            $a[ $value['priority'] ]['priority'] = $value['priority'];
        }

        for ($i = 1; $i < 11 ; $i++){
            if (array_key_exists($i,$a)){
                $list[$i]['priorityNum'] =  $i;
                $list[$i]['isUsed'] = $a[$i]['priority'] != '0' ? '1' : '0';
                $list[$i]['usedBy'] = $a[$i]['outbound_name'];

            }else{
                $list[$i]['priorityNum'] =  $i;
                $list[$i]['isUsed'] = '';
                $list[$i]['usedBy'] = '';
            }
        }
        return $list;
    }


}

