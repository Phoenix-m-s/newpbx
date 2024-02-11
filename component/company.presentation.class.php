<?php
include_once(ROOT_DIR . "component/company.operation.class.php");
include_once(ROOT_DIR . "services/AdminUserService.php");
include_once(ROOT_DIR . "component/queue.operation.class.php");
/**
 * @author Malekloo Izadi Sakhamanesh <Izadi@dabacenter.ir>
 * @version 0.0.1 this is the beta version of News
 * @copyright 2015 The Imen Daba Parsian Co.
 */



class company_presentation
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
     * @param $msg
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    function template($list='',$msg)
    {
        // global $conn, $lang;
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
                echo serialize($list);
                return;
                break;
            default:
                break;
        }

    }

    /**
     * Shows all the news
     * @param $get
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */


    public function search($get)
    {
        include_once(ROOT_DIR . "component/datatable.converter.php");

        $columns = array(
            array( 'db' => 'comp_id', 'dt' => 0 ),
            array( 'db' => 'Comp_Name', 'dt' => 1 ),
            array( 'db' => 'Manager_Name',   'dt' => 2 ),
            array( 'db' => 'Address',  'dt' => 3 ),
            array( 'db' => 'Phone_Number',  'dt' => 4 ),
            array( 'db' => 'Email',  'dt' => 5 ),
            array( 'db' => 'Comp_Status',  'dt' => 6 )
        );

        //$primaryKey = 'id';
        $convert=new convertDatatableIO();
        $convert->input=$get;
        $convert->columns=$columns;
        $searchFields= $convert->convertInput();
        $operation=new company_operation();
        $operationSearchFields = $searchFields;
        unset($operationSearchFields['showFields']);
        $operationSearchFields['filter']['trash']= 0;
        $operation->getCompanyList($operationSearchFields);
        $list['list']=$operation->companyList;

        $list['paging']=$operation->paging;

        $other['7']=array(

            'formatter' =>function($list)
            {

                //$st = '<div class="nice-checkbox"><input type="checkbox" class="checkbox-o" name="box[' . $list['news_id'] . ']" value="' . $list['Title'] . '" id="checkbox-o-' . $i . '"><label for="checkbox-o-' . $i . '"></label></div>';

                $st ='<a href="'.RELA_DIR.'company.php?action=editCompany&id=' . $list['comp_id'].'"  rel="tooltip" data-original-title="'. EDIT_01 .'">
                                            <i class="fa fa-pencil text-green"></i>
                                        </a>
                                        <a href="'.RELA_DIR.'company.php?action=deleteCompany&id='. $list['comp_id'].'"  rel="tooltip" data-original-title="'. DELETE_01 .'">
                                            <i class="fa fa-trash text-red"></i>
                                        </a>';
                return $st;
            }
        );

        $other['0']=array(

            'formatter' =>function($list)
            {
                $st = '<input type="checkbox" name="compID[]" id="compID[]" value="'. $list['comp_id'].'"/>';
                return $st;
            }
        );

        $other['6']=array(

            'formatter' =>function($list)
            {
                $st = ($list['Comp_Status']== 0 ? DISABLED_01 : ENABLE_01);
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
     * Shows all the news
     * @param $get
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function searchGroupCompany($get)
    {
        include_once(ROOT_DIR . "component/datatable.converter.php");

        $columns = array(
            array( 'db' => 'comp_group_id', 'dt' => 0 ),
            array( 'db' => 'Group_Name', 'dt' => 1 ),
            array( 'db' => 'Group_Status',   'dt' => 2 ),
            array( 'db' => 'comp_group_id', 'dt' => 3 )

        );
        //$primaryKey = 'id';
        $convert=new convertDatatableIO();
        $convert->input=$get;
        $convert->columns=$columns;
        $searchFields= $convert->convertInput();
        $operation=new company_operation();
        $operationSearchFields = $searchFields;
        unset($operationSearchFields['showFields']);
        $operation->getCompanyGroupList($operationSearchFields);
        $list['list']=$operation->companyList;
        //print_r($list['list']);
        $list['paging']=$operation->paging;
        $other['3']=array(

            'formatter' =>function($list)
            {

                //$st = '<div class="nice-checkbox"><input type="checkbox" class="checkbox-o" name="box[' . $list['news_id'] . ']" value="' . $list['Title'] . '" id="checkbox-o-' . $i . '"><label for="checkbox-o-' . $i . '"></label></div>';


                $st ='<a href="'.RELA_DIR.'company.php?action=editCompanyGroup&id=' . $list['comp_group_id'].'" rel="tooltip" data-original-title="'. EDIT_01 .'">
                                                <i class="fa fa-pencil text-orange"></i>
                                            </a>
                                            <a href="'.RELA_DIR.'company.php?action=ShowCompanyGroupMembers&id=' . $list['comp_group_id'].'"  rel="tooltip" data-original-title="View members">
                                                <i class="fa fa-users text-blue"></i>
                                            </a>
                                            <a href="'.RELA_DIR.'company.php?action=AddCompanyToGroup&id=' . $list['comp_group_id'].'" rel="tooltip" data-original-title="Add a company in this group">
                                                <i class="fa fa-plus text-green"></i>
                                            </a>';

                return $st;
            }
        );

        $other['0']=array(

            'formatter' =>function($list)
            {
                $st = '<input type="checkbox" name="compGroupID[]" id="compGroupID[]" value="'. $list['comp_group_id'].'"/>';
                return $st;
            }
        );

        $other['2']=array(

            'formatter' =>function($list)
            {
                $st = ($list['Group_Status']== 0 ? DISABLED_01 : ENABLE_01);
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
     * Shows all the news
     * @param  $get
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */


    public function searchMember($get)
    {
        include_once(ROOT_DIR . "component/datatable.converter.php");
        $GroupID=$get['groupID'];
        $columns = array(
            array( 'db' => 'comp_id', 'dt' => 0 ),
            array( 'db' => 'comp_name', 'dt' => 1 ),
            array( 'db' => 'is_admin', 'dt' => 2 ),
            array( 'db' => 'comp_id', 'dt' => 3 )

        );
        //$primaryKey = 'id';
        $convert=new convertDatatableIO();
        $convert->input=$get;
        $convert->columns=$columns;
        $searchFields= $convert->convertInput();
        $operation=new company_operation();
        $operationSearchFields = $searchFields;
        unset($operationSearchFields['showFields']);
        $operation->getGroupMembersList($operationSearchFields,$GroupID);
        $list['list']=$operation->companyList;
        //print_r($list['list']);

        $list['paging']=$operation->paging;


        $other['0']=array(

            'formatter' =>function($list)
            {
                $st = '<input type="checkbox" name="compGroupID[]" id="compGroupID[]" value="'. $list['comp_group_id'].'"/>';
                return $st;
            }
        );


        $other['2']=array(

            'formatter' =>function($list)
            {
                $st = ($list['is_admin']== 0 ? 'Not admin' : 'Admin');
                return $st;
            }
        );

        $other['3']=array(

            'formatter' =>function($list)
            {
                $st ='<a href="'.RELA_DIR.'company.php?action=RemoveCompanyFromGroup&group_id=' . $list['comp_group_id'].'&comp_id=' . $list['comp_id'].'" rel="tooltip" data-original-title="Delete">
                                                <i class="fa fa-minus text-red"></i>
                      </a>';
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
     * Shows all the companies
     * @param  $msg
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function showAllCompany($msg)
    {
        //global $conn, $lang;
        $this->exportType = 'html';
        $this->fileName = 'company.show.php';
        $this->template($msg);
        die();
    }

    /**
     * Shows all the companies
     * @param  $GroupID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function showCompanyGroupMembers($GroupID)
    {
        //global $conn, $lang;
        $this->exportType = 'html';
        $this->fileName = 'company.group.members.php';
        $list['GroupID']= $GroupID;
        $this->template($list);
        die();
    }

    /**
     * Shows all the companies
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function getAllCompany()
    {
        global $conn, $lang;

        $operation = new company_operation();
        $result = $operation->getCompanyList();

        if ($result['result'] != 1) {
            return $result['msg'];
        }

        return $operation->companyList;

    }

    /**
     * Shows all the companies
     * @param  $msg
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function showAllCompanyGroup($msg)
    {
        global $conn, $lang;

        $this->exportType='html';
        $this->fileName='company.group.show.php';
        $this->template($msg);
        die();

    }
    /**
     * Shows all the companies
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function getAllCompanyGroup()
    {
        global $conn, $lang;

        $operation=new company_operation();
        $result=$operation->getCompanyGroupList();

        if($result['result']!=1)
        {
            return $result['msg'];
        }

        return $operation->companyList;

    }

    /**
     * Add company
     * @param $fields
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function addCompany($fields)
    {
        global $comp_id;

        global $conn, $lang;
        //******
        $token_list=array_keys($fields['token']);
        $token=$token_list['0'];
        if(isset($_SESSION['token'][$token]) and $_SESSION['token'][$token]=='1')
        {
            unset($_SESSION['token'][$token]);
        }else
        {
            $this->addCompanyForm($fields,'');
        }
        //******

        $operation=new company_operation();

        foreach($operation->addForm as $key=>$val)
        {

            $input_fields[$key]=$fields[$key];

        }

        $result=$operation->set_companyInfo($input_fields);

        if ($result['result'] != 1)
        {
            $this->addCompanyForm($fields, $result['msg']);
        }

        $result = $operation->insertCompany();
       


        if($result==-1)
        {
            return $result['msg'];
        }
        else if(isset($fields['GroupID']))
        {
            $group[$operation->companyInfo['comp_id']] = $fields['GroupID'];

            $result=$operation->set_companyGroupInfo($group);

            if($result['result']!=1)
            {
                $this->addCompanyForm($fields,$result['msg']);
            }
            $operation->insertCompanyToGroup();

            if($result==-1)
            {
                return $result['msg'];
            }

        }
        $fields['comp_id']=$comp_id;

        $adminUserService = new AdminUserService();

        $adminUserService->saveToAdmin($fields);


        $msg = "Company has been successfully added.";
        redirectPage(RELA_DIR . "company.php", $msg);
        die();
    }

    /**
     * Add company form
     * @param $msg
     * @param $fields
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function addCompanyForm($fields,$msg)
    {
        global $conn, $lang;
        $fields['CompanyGroup'] = $this->getAllCompanyGroup($msg);
        $this->exportType='html';
        $this->fileName='company.add.form.php';

        //*****
        $uniqid=uniqid();
        $_SESSION['token'][$uniqid]='1';
        $fields['token']='token['.$uniqid.']';
        //*****

        $this->template($fields,$msg);
        die();

    }


    /**
     * Add company
     * @param $fields
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function addCompanyGroup($fields)
    {
        global $conn, $lang;
        $operation=new company_operation();

        $result = $operation->checkIfNameExists($fields['Group_Name']);

        if($result['result']!=1)
        {
            $this->addCompanyGroupForm($fields,$result['msg']);
        }

        $result=$operation->set_companyInfo($fields);

        if($result['result']!=1)
        {
            $this->addCompanyGroupForm($fields,$result['msg']);
        }

        $operation->insertCompanyGroup();

        if($result==-1)
        {
            return $result['msg'];
        }
        else
        {
            $msg = 'Successfully added.';
            $this->showAllCompanyGroup($msg);
        }

        die();

    }

    /**
     * Add company form
     * @param $msg
     * @param $fields
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function addCompanyGroupForm($fields,$msg)
    {
        global $conn, $lang;
        $this->exportType='html';
        $this->fileName='company.group.add.form.php';
        $this->template($fields,$msg);
        die();

    }

    /**
     * Add company
     * @param $fields
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function addCompanyToGroup($fields)
    {
        global $conn, $lang;
        $operation=new company_operation();
        $group[$fields['CompID']] = $fields['GroupID'];

        $result=$operation->set_companyGroupInfo($group);

        if($result['result']!=1)
        {
            $this->addCompanyToGroupForm($fields['id'],$result['msg']);
        }


        $keys = array_keys($fields['GroupID']);

        $result=$operation->checkIfMemberExists($fields['CompID'],$keys['0']);

        if($result['result']!=1)
        {
            $this->addCompanyToGroupForm($fields['id'],$result['msg']);
        }


        $operation->insertCompanyToGroup();

        if($result==-1)
        {
            return $result['msg'];
        }
        else
        {
            $msg = ModelCOMPANY_18;
            $this->showAllCompanyGroup($msg);
        }

        die();

    }

    /**
     * Add company form
     * @param $msg
     * @param $GroupID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function addCompanyToGroupForm($GroupID,$msg)
    {
        //global $conn, $lang;
        $list['id'] =$GroupID;
        $list['CompanyList']= $this->getAllCompany($msg);
        $this->exportType='html';
        $this->fileName='company.add.to.group.form.php';
        $this->template($list,$msg);
        die();
    }

    /**
     * Edit company based on its ID
     * @param $fields
     * @param $msg
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function editCompany($fields,$msg)
    {

        global $conn, $lang,$company_info;
        $operation=new company_operation();

        foreach($operation->editForm as $key=>$val)
        {

            $input_fields[$key]=$fields[$key];

        }

        $result=$operation->set_companyInfo($input_fields);

        if($result['result']!=1)
        {
            $this->editCompanyForm($fields['id'],$result['msg']);

        }

        $result = $operation->updateCompany();


        if($result==-1)
        {
            return $result['msg'];
        }

        $result=$operation->removeAllCompanyFromGroup($fields['id']);


        if($result['result']!=1)
        {
            $this->editCompanyForm($fields,$result['msg']);
        }

        if(isset ($fields['GroupID']))
        {

            $group[$operation->companyInfo['id']] = $fields['GroupID'];

            $result=$operation->set_companyGroupInfo($group);

            if($result['result']!=1)
            {
                $this->editCompanyForm($fields,$result['msg']);
            }

            $operation->insertCompanyToGroup();

            if($result==-1)
            {
                return $result['msg'];
            }
        }
            $this->showAllCompany('');
            die();

    }

    /**
     * Edit company based on its ID
     * @param $fields
     * @param $msg
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function editCompanyGroup($fields,$msg)
    {
        //global $conn, $lang;
        $operation      =new company_operation();
        $result = $operation->set_companyInfo($fields);

        if($result['result']!=1)
        {
            $this->editCompanyGroupForm($fields['id'],$result['msg']);

        }
        $result = $operation->updateCompanyGroup();

        if($result['result']==1)
        {
            $this->showAllCompanyGroup('');
        }
        else
        {
            $this->editCompanyGroupForm($fields['id'],$msg);
        }
        die();
    }

    /**
     * Show edit company form based on its ID
     * @param $compID
     * @param $msg
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function editCompanyForm($compID,$msg)
    {
        //global $conn, $lang;
        $operation      =new company_operation();
        $result    =$operation->getCompanyListById($compID);

        if($result['result']=='0')
        {
            return $result['msg'];

        }

        $list = $operation->companyInfo;
        $list['CompanyGroup'] = $this->getAllCompanyGroup($msg);

        $this->exportType='html';
        $this->fileName='company.edit.form.php';
        $this->template($list,$msg);
        die();
    }

    /**
     * Show edit company form based on its ID
     * @param $compID
     * @param $msg
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function editCompanyGroupForm($compID,$msg)
    {
        global $conn, $lang;
        $operation      =new company_operation();
        $result    =$operation->getCompanyGroupListById($compID);

        if($result['result']=='0')
        {
            return $result['msg'];

        }
        $list = $operation->companyInfo;
        $this->exportType='html';
        $this->fileName='company.group.edit.form.php';
        $this->template($list,$msg);
        die();
    }

    /**
     * Deletes company based on its ID
     * @param $compID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function deleteCompanies($compID)
    {
        // global $conn, $lang;
        $operation = new company_operation();
        $result = $operation->deleteCompany($compID);


        if ($result['result'] == -1) {
            return $result;
        }
        else
        {
            $msg = ModelCOMPANY_18;
            redirectPage(RELA_DIR . "trash.php?action=showCompanyTrash", $msg);
        }
    }

    /**
     * Deletes company based on its ID
     * @param $compID
     * @param $groupID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function deleteCompanyFromGroup($groupID,$compID)
    {
        global $conn, $lang;
        $operation = new company_operation();
        $result = $operation->deleteFromGroup($groupID,$compID);


        if ($result['result'] == -1) {
            return $result;
        }
        else
        {
            $this->showCompanyGroupMembers($groupID);
            return $result;
        }
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
        $operation = new company_operation();
        $result = $operation->set_IDs($fields['compID']);
        if ($result['result'] == -1)
        {
            return $result;
        }
        $result = $operation->changeStatus($fields['status']);
        if ($result['result'] == -1)
        {
            return $result;
        }
        else
        {
            $msg = ModelCOMPANY_19;
            $this->showAllCompany($list,$msg);
        }
    }

    /**
     * changeStatus Sip based on its ID
     * @param  $fields
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function changeGroupStatus($fields)
    {
        // global $conn, $lang;
        $operation = new company_operation();
        $result = $operation->set_IDs($fields['compGroupID']);
        if ($result['result'] == -1)
        {
            return $result;
        }
        $result = $operation->changeGroupStatus($fields['status']);
        if ($result['result'] == -1)
        {
            return $result;
        }
        else
        {
            $msg = ModelCOMPANY_19;
            $this->showAllCompanyGroup($msg);
            return $result;
        }
    }

    /**
     * Trashes queues based on its ID
     * @param $companyID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function trashCompanies($companyID)
    {
         global $conn, $lang;
        $found = 0;
        /////////checkAnnounceTrashDependency////////
/*        $resultAnnounce = $this->checkAnnounceDependency($companyID);

        if ($resultAnnounce['result'] != 1)
        {
            $message = $resultAnnounce['msg'];
            $this->exportType = 'html';
            $this->fileName = 'company.show.php';
            $this->template($resultAnnounce,$message);
            die();
        }

        if ($resultAnnounce['rowCount'] >= 1)
        {
            $found = 1;
            $result['list']['announce'] = $resultAnnounce['list'];
            $result['label']['announce'] = ModelCOMPANY_20;
        }

        /////////end checkAnnounceTrashDependency/////////

        /////////checkExtensionTrashDependency/////////
        $resultExt = $this->checkExtensionDependency($companyID);

        if ($resultExt['result'] != 1)
        {
            $message = $resultExt['msg'];
            $this->exportType = 'html';
            $this->fileName = 'company.show.php';
            $this->template($resultExt,$message);
            die();
        }

        if ($resultExt['rowCount'] >= 1)
        {
            $found = 1;
            $result['list']['extension'] = $resultExt['list'];
            $result['label']['extension'] = ModelCOMPANY_21;
        }

        ///////end checkExtensionTrashDependency////


        /////////checkUploadTrashDependency/////////
        $resultFile = $this->checkUploadDependency($companyID);

        if ($resultFile['result'] != 1)
        {
            $message = $resultFile['msg'];
            $this->exportType = 'html';
            $this->fileName = 'company.show.php';
            $this->template($resultFile,$message);
            die();
        }

        if ($resultFile['rowCount'] >= 1)
        {
            $found = 1;
            $result['list']['upload'] = $resultFile['list'];
            $result['label']['upload'] = ModelCOMPANY_22;
        }

        ///////end checkUploadTrashDependency////


        /////////checkIVRTrashDependency/////////
        $resultIVR = $this->checkIVRDependency($companyID);

        if ($resultIVR['result'] != 1)
        {
            $message = $resultIVR['msg'];
            $this->exportType = 'html';
            $this->fileName = 'company.show.php';
            $this->template($resultIVR,$message);
            die();
        }

        if ($resultIVR['rowCount'] >= 1)
        {
            $found = 1;
            $result['list']['ivr'] = $resultIVR['list'];
            $result['label']['ivr'] = ModelCOMPANY_23;
        }

        ///////end checkIVRTrashDependency////


        /////////checkQueueTrashDependency/////////
        $resultQ = $this->checkQueueDependency($companyID);

        if ($resultQ['result'] != 1)
        {
            $message = $resultQ['msg'];
            $this->exportType = 'html';
            $this->fileName = 'company.show.php';
            $this->template($resultQ,$message);
            die();
        }

        if ($resultQ['rowCount'] >= 1)
        {
            $found = 1;
            $result['list']['queue'] = $resultQ['list'];
            $result['label']['queue'] = ModelCOMPANY_24;
            //$message = $message.'<br/>Please delete Queues that have been defined for this company before deleting it.';
        }

        ///////end checkQueueTrashDependency////


        /////////checkSIPTrashDependency/////////
        $resultSIP = $this->checkSIPDependency($companyID);

        if ($resultSIP['result'] != 1)
        {
            $message = $resultSIP['msg'];
            $this->exportType = 'html';
            $this->fileName = 'company.show.php';
            $this->template($resultIVR,$message);
            die();
        }

        if ($resultSIP['rowCount'] >= 1)
        {
            $found = 1;
            $result['list']['sip'] = $resultSIP['list'];
            $result['label']['sip'] = ModelCOMPANY_25;
            // $message = $message.'<br/>Please delete SIPs that have been defined for this company before deleting it.';
        }

        ///////end checkSIPTrashDependency////

        /////////checkInboundTrashDependency/////////
        $resultInbound = $this->checkInboundDependency($companyID);

        if ($resultInbound['result'] != 1)
        {
            $message = $resultInbound['msg'];
            $this->exportType = 'html';
            $this->fileName = 'company.show.php';
            $this->template($resultInbound,$message);
            die();
        }

        if ($resultInbound['rowCount'] >= 1)
        {
            $found = 1;
            $result['list']['inbound'] = $resultInbound['list'];
            $result['label']['inbound'] = ModelCOMPANY_26;
        }

        ///////end checkInboundTrashDependency////

        /////////checkOutboundTrashDependency/////////
        $resultOutbound = $this->checkOutboundDependency($companyID);

        if ($resultOutbound['result'] != 1)
        {
            $message = $resultOutbound['msg'];
            $this->exportType = 'html';
            $this->fileName = 'company.show.php';
            $this->template($result,$message);
            die();
        }

        if ($resultOutbound['rowCount'] >= 1)
        {
            $found = 1;
            $result['list']['outbound'] = $resultOutbound['list'];
            $result['label']['outbound'] = ModelCOMPANY_27;
        }

        ///////end checkOutboundTrashDependency////


        if($found == 1)
        {
            $this->exportType = 'html';
            $this->fileName = 'company.show.php';
            $this->template($result,$message);
            die();
        }*/

        $operation = new company_operation();
        $result = $operation->trashCompany($companyID);

        if ($result['result'] == -1)
        {
            return $result;
        }
        else
        {
            $msg = ModelANNOUNCE_06;
            redirectPage(RELA_DIR . "company.php", $msg);
            return $result;
        }
    }

    /**
     * Trashes queues based on its ID
     * @param $companyID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function recycleCompanies($companyID)
    {
        // global $conn, $lang;
        $operation = new company_operation();
        $result = $operation->recycleCompany($companyID);

        if ($result['result'] == -1)
        {
            return $result;
        }

        else
        {
            $msg = ModelANNOUNCE_07;
            redirectPage(RELA_DIR . "trash.php?action=showCompanyTrash", $msg);
            return $result;
        }
    }

    /**
     * Checks if announces exists based on comp ID
     * @param $companyID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function checkAnnounceDependency($companyID)
    {
        $operation = new company_operation();
        $result = $operation->checkAnnounceDependency($companyID);
        return $result;
    }

    /**
     * Checks if IVRs exists based on comp ID
     * @param $companyID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function checkIVRDependency($companyID)
    {
        $operation = new company_operation();
        $result = $operation->checkIVRDependency($companyID);
        return $result;
    }

    /**
     * Checks if queues exists based on comp ID
     * @param $companyID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function checkQueueDependency($companyID)
    {
        $operation = new company_operation();
        $result = $operation->checkQueueDependency($companyID);
        return $result;
    }

    /**
     * Checks if extensions exists based on comp ID
     * @param $companyID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function checkExtensionDependency($companyID)
    {
        $operation = new company_operation();
        $result = $operation->checkExtensionDependency($companyID);
        return $result;
    }

    /**
     * Checks if extensions exists based on comp ID
     * @param $companyID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function checkUploadDependency($companyID)
    {
        $operation = new company_operation();
        $result = $operation->checkUploadDependency($companyID);
        return $result;
    }

    /**
     * Checks if extensions exists based on comp ID
     * @param $companyID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function checkSIPDependency($companyID)
    {
        $operation = new company_operation();
        $result = $operation->checkSIPDependency($companyID);
        return $result;
    }

    /**
     * Checks if extensions exists based on comp ID
     * @param $companyID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function checkOutboundDependency($companyID)
    {
        $operation = new company_operation();
        $result = $operation->checkOutboundDependency($companyID);
        return $result;
    }

    /**
     * Checks if extensions exists based on comp ID
     * @param $companyID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function checkInboundDependency($companyID)
    {
        $operation = new company_operation();
        $result = $operation->checkInboundDependency($companyID);
        return $result;
    }

}



