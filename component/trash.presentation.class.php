<?php
include_once(ROOT_DIR . "component/trash.operation.class.php");


/**
 * @author Malekloo Izadi Sakhamanesh <Izadi@dabacenter.ir>
 * @version 0.0.1 this is the beta version of News
 * @copyright 2015 The Imen Daba Parsian Co.
 */
class trash_presentation
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
     * Search Company Trash
     * @param $get
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */


    public function searchCompanyTrash($get)
    {
        include_once(ROOT_DIR . "component/datatable.converter.php");

        $columns = array(
            array('db' => 'comp_id', 'dt' => 0),
            array('db' => 'Comp_Name', 'dt' => 1),
            array('db' => 'Manager_Name', 'dt' => 2),
            array('db' => 'Address', 'dt' => 3),
            array('db' => 'Phone_Number', 'dt' => 4),
            array('db' => 'Email', 'dt' => 5),
            array('db' => 'Comp_Status', 'dt' => 6)
        );
        //$primaryKey = 'id';
        $convert = new convertDatatableIO();
        $convert->input = $get;
        $convert->columns = $columns;
        $searchFields = $convert->convertInput();
        include_once(ROOT_DIR . "component/company.operation.class.php");
        $operation = new company_operation();


        $operationSearchFields = $searchFields;
        unset($operationSearchFields['showFields']);
        $operationSearchFields['filter']['trash'] = 1;
        $operation->getCompanyList($operationSearchFields);

        $list['list'] = $operation->companyList;
        //print_r($list['list']);


        $list['paging'] = $operation->paging;

        $other['7'] = array(

            'formatter' => function ($list) {

                //$st = '<div class="nice-checkbox"><input type="checkbox" class="checkbox-o" name="box[' . $list['news_id'] . ']" value="' . $list['Title'] . '" id="checkbox-o-' . $i . '"><label for="checkbox-o-' . $i . '"></label></div>';

                $st = '<a href="' . RELA_DIR . 'company.php?action=recycleCompany&id=' . $list['comp_id'] . '"  rel="tooltip" data-original-title="' . DELETE_01 . '">
                                            <i class="fa fa-recycle text-green"></i>
                                             <a href="' . RELA_DIR . 'company.php?action=deleteCompany&id=' . $list['comp_id'] . '"  rel="tooltip" data-original-title="' . DELETE_01 . '">
                                            <i class="fa fa-trash text-red"></i>
                                        </a>';


                return $st;
            }
        );

        $other['0'] = array(

            'formatter' => function ($list) {

                $st = '<input type="checkbox" name="compID[]" id="compID[]" value="' . $list['comp_id'] . '"/>';


                return $st;
            }
        );

        $other['6'] = array(

            'formatter' => function ($list) {

                $st = ($list['Comp_Status'] == 0 ? DISABLED_01 : ENABLE_01);


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
     * @param $get
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    10/09/2015
     */
    public function searchQueueTrash($get)
    {
        include_once(ROOT_DIR . "component/datatable.converter.php");

        $columns = array(
            array('db' => 'queue_id', 'dt' => 0),
            array('db' => 'queue_name', 'dt' => 1),
            array('db' => 'queue_ext_no', 'dt' => 2),
            array('db' => 'queue_pass', 'dt' => 3),
            array('db' => 'max_wait_time', 'dt' => 4),
            array('db' => 'agents_no', 'dt' => 5),
            array('db' => 'position_announcement', 'dt' => 6),
            array('db' => 'hold_time_announcement', 'dt' => 7),
            array('db' => 'frequency', 'dt' => 8),
            array('db' => 'recording', 'dt' => 9),
            array('db' => 'ring_strategy', 'dt' => 10),
            array('db' => 'option_value', 'dt' => 11),
            array('db' => 'queue_status', 'dt' => 12),
            array('db' => 'comp_name', 'dt' => 13),
            array('db' => 'queue_id', 'dt' => 14)
        );

        //$primaryKey = 'id';
        $convert = new convertDatatableIO();
        $convert->input = $get;
        $convert->columns = $columns;
        $searchFields = $convert->convertInput();
        include_once(ROOT_DIR . "component/queue.operation.class.php");
        $operation = new queue_operation();


        $operationSearchFields = $searchFields;
        unset($operationSearchFields['showFields']);
        $operationSearchFields['filter']['trash'] = 1;
        $operation->getQueueList($operationSearchFields);

        $list['list'] = $operation->queueList;
        //print_r($list['list']);

        $list['paging'] = $operation->paging;


        $other['14'] = array(

            'formatter' => function ($list) {
                //$st = '<div class="nice-checkbox"><input type="checkbox" class="checkbox-o" name="box[' . $list['news_id'] . ']" value="' . $list['Title'] . '" id="checkbox-o-' . $i . '"><label for="checkbox-o-' . $i . '"></label></div>';
                $st = '<a href="' . RELA_DIR . 'queue.php?action=recycleQueue&queue_id=' . $list['queue_id'] . '"  rel="tooltip" data-original-title="' . EDIT_01 . '">
                         <i class="fa fa-recycle text-green"></i>
                      </a>
                      <a href="' . RELA_DIR . 'queue.php?action=deleteQueue&queue_id=' . $list['queue_id'] . '"  rel="tooltip" data-original-title="' . DELETE_01 . '">
                         <i class="fa fa-trash text-red"></i>
                      </a>';
                return $st;
            }
        );

        $other['12'] = array(
            'formatter' => function ($list) {
                $st = ($list['queue_status'] == 0 ? DISABLED_01 : ENABLE_01);
                return $st;
            }
        );

        $other['9'] = array(
            'formatter' => function ($list) {
                $st = ($list['recording'] == 0 ? DISABLED_01 : ENABLE_01);
                return $st;
            }
        );

        $other['7'] = array(
            'formatter' => function ($list) {
                $st = ($list['hold_time_announcement'] == 0 ? DISABLED_01 : ENABLE_01);
                return $st;
            }
        );

        $other['6'] = array(
            'formatter' => function ($list) {
                $st = ($list['position_announcement'] == 0 ? DISABLED_01 : ENABLE_01);
                return $st;
            }
        );

        $other['5'] = array(
            'formatter' => function ($list) {
                $st = ' <a href="' . RELA_DIR . 'queue.php?action=showAgents&queue_id=' . $list['queue_id'] . '"  rel="tooltip" data-original-title="' . DELETE_01 . '">
                         <i class="fa fa-tasks text-orange"></i>
                      </a>';
                return $st;
            }
        );

        $other['0'] = array(
            'formatter' => function ($list) {
                $st = '<input type="checkbox" name="queueID[]" id="queueID[]" value="' . $list['queue_id'] . '">';
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
     * Gets all IVRs
     * @param  $get
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */


    public function searchIvrTrash($get)
    {
        include_once(ROOT_DIR . "component/datatable.converter.php");

        $columns = array(
            array('db' => 'ivr_id', 'dt' => 0),
            array('db' => 'ivr_name', 'dt' => 1),
            array('db' => 'title', 'dt' => 2),
            array('db' => 'timeout', 'dt' => 3),
            array('db' => 'direct_dial', 'dt' => 4),
            array('db' => 'ivr_status', 'dt' => 5),
            array('db' => 'ivr_id', 'dt' => 6),
            array('db' => 'comp_name', 'dt' => 7),
            array('db' => 'ivr_id', 'dt' => 8)

        );
        //$primaryKey = 'id';
        $convert = new convertDatatableIO();
        $convert->input = $get;
        $convert->columns = $columns;
        $searchFields = $convert->convertInput();
        include_once(ROOT_DIR . "component/ivr.operation.class.php");
        $operation = new ivr_operation();


        $operationSearchFields = $searchFields;
        unset($operationSearchFields['showFields']);
        $operationSearchFields['filter']['trash'] = 1;
        $operation->getIvrList($operationSearchFields);

        $list['list'] = $operation->ivrList;
        //print_r($list['list']);


        $list['paging'] = $operation->paging;

        $other['8'] = array(

            'formatter' => function ($list) {

                //$st = '<div class="nice-checkbox"><input type="checkbox" class="checkbox-o" name="box[' . $list['news_id'] . ']" value="' . $list['Title'] . '" id="checkbox-o-' . $i . '"><label for="checkbox-o-' . $i . '"></label></div>';

                $st = '<a href="' . RELA_DIR . 'ivr.php?action=recycleIvr&id=' . $list['ivr_id'] . '"  rel="tooltip" data-original-title="' . EDIT_01 . '">
                                            <i class="fa fa-recycle text-green"></i>
                                        </a>
                                        <a href="' . RELA_DIR . 'ivr.php?action=deleteIvr&id=' . $list['ivr_id'] . '"  rel="tooltip" data-original-title="' . DELETE_01 . '">
                                            <i class="fa fa-trash text-red"></i>
                                        </a>';

                return $st;
            }
        );

        $other['6'] = array(

            'formatter' => function ($list) {

                //$st = '<div class="nice-checkbox"><input type="checkbox" class="checkbox-o" name="box[' . $list['news_id'] . ']" value="' . $list['Title'] . '" id="checkbox-o-' . $i . '"><label for="checkbox-o-' . $i . '"></label></div>';

                $st = '<a href="' . RELA_DIR . 'ivr.php?action=showDST&id=' . $list['ivr_id'] . '"  rel="tooltip" data-original-title="' . DETAILS . '">
                                            <i class="fa fa-tasks text-orange"></i>
                                        </a>';


                return $st;
            }
        );

        $other['5'] = array(

            'formatter' => function ($list) {

                $st = ($list['ivr_status'] == 0 ? DISABLED_01 : ENABLE_01);
                return $st;

            }
        );

        $other['3'] = array(

            'formatter' => function ($list) {

                $st = ($list['invalid'] == 0 ? DISABLED_01 : ENABLE_01);
                return $st;

            }
        );

        $other['0'] = array(

            'formatter' => function ($list) {

                $st = '<input type="checkbox" name="ivrID[]" id="ivrID[]" value="' . $list['ivr_id'] . '"/>';


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
     * @param $get
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    10/09/2015
     */
    public function searchSipTrash($get)
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
        include_once(ROOT_DIR . "component/sip.operation.class.php");
        $operation = new sip_operation();


        $operationSearchFields = $searchFields;
        unset($operationSearchFields['showFields']);
        $operationSearchFields['filter']['trash'] = 1;
        $operation->getSipList($operationSearchFields);

        $list['list'] = $operation->sipList;
        //print_r($list['list']);

        $list['paging'] = $operation->paging;


        $other['9'] = array(

            'formatter' => function ($list) {

                //$st = '<div class="nice-checkbox"><input type="checkbox" class="checkbox-o" name="box[' . $list['news_id'] . ']" value="' . $list['Title'] . '" id="checkbox-o-' . $i . '"><label for="checkbox-o-' . $i . '"></label></div>';

                $st = '<a href="' . RELA_DIR . 'sip.php?action=recycleSip&id=' . $list['sip_id'] . '"  rel="tooltip" data-original-title="' . EDIT_01 . '">
                                            <i class="fa fa-recycle text-green"></i>
                                        </a>
                                        <a href="' . RELA_DIR . 'sip.php?action=deleteSip&id=' . $list['sip_id'] . '"  rel="tooltip" data-original-title="' . DELETE_01 . '">
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
     * Shows all the extensions
     * @param  $get
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */


    public function searchExtensionTrash($get)
    {
        include_once(ROOT_DIR . "component/datatable.converter.php");

        $columns = array(
            array('db' => 'Extension_ID', 'dt' => 0),
            array('db' => 'Extension_Name', 'dt' => 1),
            array('db' => 'Extension_No', 'dt' => 2),
            array('db' => 'Secret', 'dt' => 3),
            array('db' => 'Voicemail_Email', 'dt' => 4),
            array('db' => 'Voicemail_Pass', 'dt' => 5),
            array('db' => 'Internal_Recording', 'dt' => 6),
            array('db' => 'External_Recording', 'dt' => 7),
            array('db' => 'Extension_Status', 'dt' => 8),
            array('db' => 'comp_name', 'dt' => 9),
            array('db' => 'Extension_ID', 'dt' => 10)

        );
        //$primaryKey = 'id';
        $convert = new convertDatatableIO();
        $convert->input = $get;
        $convert->columns = $columns;
        $searchFields = $convert->convertInput();
        include_once(ROOT_DIR . "component/extension.operation.class.php");
        $operation = new extension_operation();


        $operationSearchFields = $searchFields;
        unset($operationSearchFields['showFields']);
        $operationSearchFields['filter']['trash'] = 1;
        $operation->getExtensionList($operationSearchFields);

        $list['list'] = $operation->extensionList;
        //print_r($list['list']);


        $list['paging'] = $operation->paging;

        $other['10'] = array(

            'formatter' => function ($list) {

                //$st = '<div class="nice-checkbox"><input type="checkbox" class="checkbox-o" name="box[' . $list['news_id'] . ']" value="' . $list['Title'] . '" id="checkbox-o-' . $i . '"><label for="checkbox-o-' . $i . '"></label></div>';

                $st = '<a href="' . RELA_DIR . 'extension.php?action=recycleExtension&id=' . $list['Extension_ID'] . '"  rel="tooltip" data-original-title="' . EDIT_01 . '">
                                            <i class="fa fa-recycle text-green"></i>
                                        </a>
                                        <a href="' . RELA_DIR . 'extension.php?action=deleteExtension&id=' . $list['Extension_ID'] . '"  rel="tooltip" data-original-title="' . DELETE_01 . '">
                                            <i class="fa fa-trash text-red"></i>
                                        </a>';

                return $st;
            }
        );

        $other['8'] = array(

            'formatter' => function ($list) {

                $st = ($list['Extension_Status'] == 0 ? DISABLED_01 : ENABLE_01);
                return $st;

            }
        );


        $other['7'] = array(

            'formatter' => function ($list) {

                $st = ($list['External_Recording'] == 0 ? DISABLED_01 : ENABLE_01);
                return $st;

            }
        );

        $other['6'] = array(

            'formatter' => function ($list) {

                $st = ($list['Internal_Recording'] == 0 ? DISABLED_01 : ENABLE_01);
                return $st;

            }
        );

        $other['0'] = array(

            'formatter' => function ($list) {

                $st = '<input type="checkbox" name="extensionID[]" id="extensionID[]" value="' . $list['Extension_ID'] . '"/>';


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
     * @param $get
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    10/09/2015
     */
    public function searchAnnounceTrash($get)
    {
        include_once(ROOT_DIR . "component/datatable.converter.php");

        $columns = array(
            array('db' => 'announce_id', 'dt' => 0),
            array('db' => 'announce_name', 'dt' => 1),
            array('db' => 'repeat_input', 'dt' => 2),
            array('db' => 'announce_date', 'dt' => 3),
            array('db' => 'title', 'dt' => 4),
            array('db' => 'option_value', 'dt' => 5),
            array('db' => 'announce_status', 'dt' => 6),
            array('db' => 'comp_name', 'dt' => 7)
        );

        //$primaryKey = 'id';
        $convert = new convertDatatableIO();
        $convert->input = $get;
        $convert->columns = $columns;
        $searchFields = $convert->convertInput();
        include_once(ROOT_DIR . "component/announce.operation.class.php");
        $operation = new announce_operation();
        $operationSearchFields = $searchFields;
        unset($operationSearchFields['showFields']);
        $operationSearchFields['filter']['trash'] = 1;
        $operation->getAnnounceList($operationSearchFields);

        $list['list'] = $operation->announceList;

        //print_r($list['list']);
        //$list['upload']= $this->getUploadList($operationSearchFields);


        $list['paging'] = $operation->paging;


        $other['8'] = array(

            'formatter' => function ($list) {

                // $st = '<div class="nice-checkbox"><input type="checkbox" class="checkbox-o" name="box[' . $list['news_id'] . ']" value="' . $list['Title'] . '" id="checkbox-o-' . $i . '"><label for="checkbox-o-' . $i . '"></label></div>';

                $st = '<a href="' . RELA_DIR . 'announce.php?action=recycleAnnounce&id=' . $list['announce_id'] . '"  rel="tooltip" data-original-title="' . DELETE_01 . '">
                                            <i class="fa fa-recycle text-green"></i>
                                        </a>
                                        <a href="' . RELA_DIR . 'announce.php?action=deleteAnnounce&id=' . $list['announce_id'] . '"  rel="tooltip" data-original-title="' . DELETE_01 . '">
                                            <i class="fa fa-trash text-red"></i>
                                        </a>';
                return $st;
            }
        );

        $other['6'] = array(

            'formatter' => function ($list) {

                $st = ($list['announce_status'] == 0 ? DISABLED_01 : ENABLE_01);
                return $st;

            }
        );

        /*  $other['3']=array(

               'formatter' =>function($list)
               {


           $st =    $list['Title'] ;
                   return $st;
                   // $st = '<input type="checkbox" name="announceID[]" id="announceID[]" value="'. $list['announce_id'].'">';

               }
           );*/


        $other['0'] = array(

            'formatter' => function ($list) {

                $st = '<input type="checkbox" name="announceID[]" id="announceID[]" value="' . $list['announce_id'] . '">';


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
     * Shows all the news
     * @author  Malekloo, Sakhamanesh, Izadi
     * @param  $get
     * @version 01.01.01
     * @date    08/08/2015
     */


    public function searchUploadTrash($get)
    {
        include_once(ROOT_DIR . "component/datatable.converter.php");

        $columns = array(
            array('db' => 'Upload_ID', 'dt' => 0),
            array('db' => 'Title', 'dt' => 1),
            array('db' => 'File_Name', 'dt' => 2),
            array('db' => 'File_Extension', 'dt' => 3),
            array('db' => 'comp_name', 'dt' => 4),
            array('db' => 'Upload_ID', 'dt' => 5)

        );
        //$primaryKey = 'id';
        $convert = new convertDatatableIO();
        $convert->input = $get;
        $convert->columns = $columns;
        $searchFields = $convert->convertInput();
        include_once(ROOT_DIR . "component/upload.operation.class.php");
        $operation = new upload_operation();
        $operationSearchFields = $searchFields;
        unset($operationSearchFields['showFields']);
        $operationSearchFields['filter']['trash'] = 1;
        $operation->getUploadList($operationSearchFields);

        $list['list'] = $operation->uploadList;
        //print_r($list['list']);


        $list['paging'] = $operation->paging;

        $other['5'] = array(

            'formatter' => function ($list) {

                //$st = '<div class="nice-checkbox"><input type="checkbox" class="checkbox-o" name="box[' . $list['news_id'] . ']" value="' . $list['Title'] . '" id="checkbox-o-' . $i . '"><label for="checkbox-o-' . $i . '"></label></div>';

                $st = '<a href="' . RELA_DIR . 'upload.php?action=deleteFile&id=' . $list['Upload_ID'] . '"  rel="tooltip" data-original-title="' . DELETE_01 . '">
                                            <i class="fa fa-trash text-red"></i>
                                        </a>';


                return $st;
            }
        );

        $other['0'] = array(

            'formatter' => function ($list) {

                $st = '<input type="checkbox" name="uploadID[]" id="uploadID[]" value="' . $list['Upload_ID'] . '"/>';


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
     * @param $get
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    10/09/2015
     */
    public function searchOutboundTrash($get)
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
        include_once(ROOT_DIR . "component/outbound.operation.class.php");
        $operation = new outbound_operation();


        $operationSearchFields = $searchFields;
        unset($operationSearchFields['showFields']);
        $operationSearchFields['filter']['trash'] = 1;
        $operation->getOutboundList($operationSearchFields);

        $list['list'] = $operation->outboundList;

        $list['paging'] = $operation->paging;

        $other['3'] = array(

            'formatter' => function ($list) {

                $st = ($list['outbound_status'] == 0 ? DISABLED_01 : ENABLE_01);
                return $st;

            }
        );

        $other['4'] = array(

            'formatter' => function ($list) {

                //$st = '<div class="nice-checkbox"><input type="checkbox" class="checkbox-o" name="box[' . $list['news_id'] . ']" value="' . $list['Title'] . '" id="checkbox-o-' . $i . '"><label for="checkbox-o-' . $i . '"></label></div>';

                $st = '<a href="' . RELA_DIR . 'outbound.php?action=showDialPattern&id=' . $list['outbound_id'] . '"  rel="tooltip" data-original-title="'.DETAILS.'">
                                            <i class="fa fa-tasks text-orange"></i>
                                        </a>';


                return $st;
            }
        );
        $other['6'] = array(

            'formatter' => function ($list) {

                //$st = '<div class="nice-checkbox"><input type="checkbox" class="checkbox-o" name="box[]' . $list['outbound_id'] . ']" value="' . $list['Title'] . '" id="checkbox-o-' . $i . '"><label for="checkbox-o-' . $i . '"></label></div>';

                $st = '<a href="' . RELA_DIR . 'outbound.php?action=recycleOutbound&id=' . $list['outbound_id'] . '"  rel="tooltip" data-original-title="' . EDIT_01 . '">
                                            <i class="fa fa-recycle text-green"></i>
                                        </a>
                                        <a href="' . RELA_DIR . 'outbound.php?action=deleteOutbound&id=' . $list['outbound_id'] . '"  rel="tooltip" data-original-title="' . DELETE_01 . '">
                                            <i class="fa fa-trash text-red"></i>
                                        </a>';
                return $st;
            }
        );


        $other['0'] = array(

            'formatter' => function ($list) {

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
     * search
     * @param $get
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    10/09/2015
     */
    public function searchInboundTrash($get)
    {
        //die('dfgsdfg');
        include_once(ROOT_DIR . "component/datatable.converter.php");

        $columns = array(
            array('db' => 'inbound_id', 'dt' => 0),
            array('db' => 'inbound_name', 'dt' => 1),
            array('db' => 'did_name', 'dt' => 2),
            array('db' => 'cid_name', 'dt' => 3),
            array('db' => 'fax_email', 'dt' => 4),
            array('db' => 'priority', 'dt' => 5),
            array('db' => 'option_value', 'dt' => 6),
            array('db' => 'inbound_status', 'dt' => 7),
            array('db' => 'comp_name', 'dt' => 8),
            array('db' => 'inbound_id', 'dt' => 9)
        );

        //$primaryKey = 'id';
        $convert = new convertDatatableIO();
        $convert->input = $get;
        $convert->columns = $columns;
        $searchFields = $convert->convertInput();
        include_once(ROOT_DIR . "component/inbound.operation.class.php");
        $operation = new inbound_operation();
        $operationSearchFields = $searchFields;
        unset($operationSearchFields['showFields']);
        $operationSearchFields['filter']['trash'] = 1;
        $operation->getInboundList($operationSearchFields);

        $list['list'] = $operation->inboundList;

        //print_r($list['list']);

        $list['paging'] = $operation->paging;


        $other['9'] = array(

            'formatter' => function ($list) {

                //$st = '<div class="nice-checkbox"><input type="checkbox" class="checkbox-o" name="box[' . $list['news_id'] . ']" value="' . $list['Title'] . '" id="checkbox-o-' . $i . '"><label for="checkbox-o-' . $i . '"></label></div>';

                $st = '<a href="' . RELA_DIR . 'inbound.php?action=recycleInbound&id=' . $list['inbound_id'] . '"  rel="tooltip" data-original-title="' . EDIT_01 . '">
                                            <i class="fa fa-recycle text-green"></i>
                                        </a>
                                        <a href="' . RELA_DIR . 'inbound.php?action=deleteInbound&id=' . $list['inbound_id'] . '"  rel="tooltip" data-original-title="' . DELETE_01 . '">
                                            <i class="fa fa-trash text-red"></i>
                                        </a>';
                return $st;
            }
        );

        $other['7'] = array(

            'formatter' => function ($list) {

                $st = ($list['inbound_status'] == 0 ? DISABLED_01 : ENABLE_01);
                return $st;

            }
        );

        $other['0'] = array(

            'formatter' => function ($list) {

                $st = '<input type="checkbox" name="inbound_id[]" id="inbound_id[]" value="' . $list['inbound_id'] . '">';
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
     * Shows all the companies
     * @return  mixed
     * @param  $msg
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function showAllQueues($msg)
    {
        global $conn, $lang;

        $this->exportType = 'html';
        $this->fileName = 'queue.show.php';
        $this->template(/*$list,*/
            $msg);

        die();

    }

    /**
     * Shows all the companies
     * @param  $QueueID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function trashQueue($QueueID)
    {
        global $conn, $lang;

        $operation = new trash_operation();
        $result = $operation->trashQueue($QueueID);

        if ($result['result'] != 1) {
            return $result['msg'];
        } else {
            redirectPage(RELA_DIR . "trash.php", ModelTRASH_02);
        }
        die();

    }

    /**
     * Shows all the companies
     * @param  $AnnounceID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function trashAnnounce($AnnounceID)
    {
        global $conn, $lang;

        $operation = new trash_operation();
        $result = $operation->trashAnnounce($AnnounceID);

        if ($result['result'] != 1) {
            return $result['msg'];
        } else {
            redirectPage(RELA_DIR . "trash.php", ModelTRASH_02);
        }
        die();

    }

    /**
     * Add extension
     * @param $fields
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function addQueue($fields)
    {
        global $conn, $lang;
        $operation = new queue_operation();
        $result = $operation->set_info($fields);
        if ($result['result'] != 1) {

            $this->addQueueForm($fields, $result['msg']);
        }

        $result = $operation->set_queueInfo($fields);

        if ($result['result'] != 1) {
            $this->addQueueForm($fields, $result['msg']);
        }

        $operation->insertQueue();

        if ($result == -1) {
            return $result['msg'];
        } else {
            redirectPage(RELA_DIR . "queue.php", ModelANNOUNCE_02);
        }

        die();
    }

    /**
     * Add extension form
     * @param $fields
     * @param $msg
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function addQueueForm($fields, $msg = '')
    {

        global $conn, $lang;
        $operation = new queue_operation();
        $fields['DSTList'] = $this->getAllDstOption();

        $fields['ExtensionList'] = $operation->getAllExtensionList();

        $this->exportType = 'html';
        $this->fileName = 'queue.add.form.php';
        $this->template($fields, $msg);
        die();

    }

    /**
     * Edit extension based on its ID
     * @param $fields
     * @param $msg
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function editQueue($fields, $msg)
    {
        global $conn, $lang;
        $operation = new queue_operation();

        $result = $operation->set_queueInfo($fields);

        if ($result['result'] != 1) {
            $this->editQueueForm($fields['id'], $result['msg']);

        }

        $result = $operation->updateQueue();

        if ($result['result'] == 1) {
            redirectPage(RELA_DIR . "queue.php", ModelINBOUND_14);
        } else {
            $this->editQueueForm($fields['id'], $msg);
        }

        die();
    }

    /**
     * Show edit extension form based on its ID
     * @param $queueID
     * @param $msg
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function editQueueForm($queueID, $msg)
    {
        global $conn, $lang;
        $operation = new queue_operation();
        $DSTList = $this->getAllDstOption();
        $ExtensionList = $operation->getAllExtensionList();
        $result = $operation->getQueueListById($queueID);

        if ($result['result'] == '0') {
            return $result['msg'];

        }
        $queueList = $operation->queueInfo;

        $list['Agents_No'] = $ExtensionList;
        $list['DSTList'] = $DSTList;
        $list['QueueList'] = $queueList;
        /*     echo '<pre>';
                print_r($list);
                die();*/
        $this->exportType = 'html';
        $this->fileName = 'queue.edit.form.php';
        $this->template($list, $msg);
        die();
    }

    /**
     * Deletes extension based on its ID
     * @param $queueID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function deleteQueues($queueID)
    {
        global $conn, $lang;
        $operation = new queue_operation();
        $result = $operation->deleteQueue($queueID);


        if ($result['result'] == -1) {
            return $result;
        } else {
            $msg = ModelTRASH_03;
            $this->showAllQueues($msg);
        }
    }

    /**
     * Trashes queues based on its ID
     * @param $queueID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function trashQueues($queueID)
    {
        global $conn, $lang;
        $operation = new queue_operation();
        $result = $operation->trashQueue($queueID);


        if ($result['result'] == -1) {
            return $result;
        } else {
            $msg = ModelTRASH_04;
            $this->showAllQueues($msg);
        }
    }

    /**
     * Trashes queues based on its ID
     * @param $queueID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function unTrashQueues($queueID)
    {
        global $conn, $lang;
        $operation = new queue_operation();
        $result = $operation->unTrashQueue($queueID);


        if ($result['result'] == -1) {
            return $result;
        } else {
            $msg = ModelQUEUE_21;
            $this->showAllTrashes($msg);
        }
    }

    /**
     * Add extension form
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function getAllDstOption()
    {
        global $conn, $lang;
        include_once(ROOT_DIR . "component/dstOption.operation.class.php");
        $operation = new dstOption_operation();
        $result = $operation->getDstOptionList();
        if ($result['result'] != 1) {
            return $result['msg'];
        }


        return $operation->dstOptionList;

    }

    /**
     * changeStatus Sip based on its ID
     * @param  $fields
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function changeStatus($fields)
    {
        global $conn, $lang;
        $operation = new queue_operation();
        $result = $operation->set_IDs($fields['queueID']);
        if ($result['result'] == -1) {
            return $result;
        }
        $result = $operation->changeStatus($fields['status']);
        if ($result['result'] == -1) {
            return $result;
        } else {
            $msg = ModelCOMPANY_19;
            $this->showAllQueues($msg);
        }
    }


    /**
     * changeStatus Sip based on its ID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function showAllTrash()
    {
        /* global $conn, $lang;
         $operation = new trash_operation();
         $result = $operation->showAllTrashes();
         if ($result['result'] == -1)
         {
             return $result;
         }
         else
         {
             $list = $operation->trashList;*/
        $this->exportType = 'html';
        $this->fileName = 'trash.show.php';
        $this->template($msg);
        /* }*/

    }

    /**
     * Shows all the companies
     * @return  mixed
     * @param  $list
     * @param  $msg
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function showQueueTrash($list, $msg)
    {
        global $conn, $lang;
        $this->exportType = 'html';
        $this->fileName = 'trash.queue.show.php';
        $this->template('', $msg);

        die();

    }

    /**
     * Shows all the companies
     * @return  mixed
     * @param  $list
     * @param  $msg
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function showIvrTrash($list, $msg)
    {
        global $conn, $lang;
        $this->exportType = 'html';
        $this->fileName = 'trash.ivr.show.php';
        $this->template('', $msg);
        die();
    }

    /**
     * Shows all the companies
     * @return  mixed
     * @param  $list
     * @param  $msg
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function showSipTrash($list, $msg)
    {
        global $conn, $lang;
        $this->exportType = 'html';
        $this->fileName = 'trash.sip.show.php';
        $this->template('', $msg);
        die();
    }

    /**
     * Shows all the companies
     * @return  mixed
     * @param  $msg
     * @param  $list
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function showAnnounceTrash($list, $msg)
    {
        global $conn, $lang;

        $this->exportType = 'html';
        $this->fileName = 'trash.announce.show.php';
        $this->template($list, $msg);

        die();

    }

    /**
     * Shows all the companies
     * @return  mixed
     * @param  $list
     * @param  $msg
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function showExtensionTrash($list, $msg)
    {
        global $conn, $lang;

        $this->exportType = 'html';
        $this->fileName = 'trash.extension.show.php';
        $this->template('', $msg);

        die();

    }

    /**
     * Shows all the companies
     * @return  mixed
     * @param  $list
     * @param  $msg
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function showInboundTrash($list, $msg)
    {
        global $conn, $lang;

        $this->exportType = 'html';
        $this->fileName = 'trash.inbound.show.php';
        $this->template('', $msg);

        die();

    }

    /**
     * Shows all the companies
     * @return  mixed
     * @param  $list
     * @param  $msg
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function showOutboundTrash($list, $msg)
    {
        global $conn, $lang;

        $this->exportType = 'html';
        $this->fileName = 'trash.outbound.show.php';
        $this->template('', $msg);

        die();

    }

    /**
     * Shows all the companies
     * @return  mixed
     * @param  $list
     * @param  $msg
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function showUploadTrash($list, $msg)
    {
        global $conn, $lang;

        $this->exportType = 'html';
        $this->fileName = 'trash.upload.show.php';
        $this->template('', $msg);

        die();

    }

    /**
     * Shows all the companies
     * @return  mixed
     * @param  $msg
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function showCompanyTrash($msg)
    {
        global $conn, $lang;

        $this->exportType = 'html';
        $this->fileName = 'trash.company.show.php';
        $this->template($msg);

        die();

    }

}
