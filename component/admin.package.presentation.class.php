<?php
include_once(ROOT_DIR . "component/admin.package.operation.class.php");
include_once(ROOT_DIR . "component/company.operation.class.php");

/**
 * @author Malekloo,Izadi,Sakhamanesh <Izadi@dabacenter.ir>
 * @version 0.0.1 this is the beta version of sip
 * @copyright 2015 The Imen Daba Parsian Co.
 */
class admin_package_presentation
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
        $operation = new admin_Package_operation();


        $operationSearchFields = $searchFields;
        unset($operationSearchFields['showFields']);
        $operation->getGroupPackageList($operationSearchFields);

        $list['list'] = $operation->PackageList;

        $list['paging'] = $operation->paging;
        $other['3'] = array(

            'formatter' => function($list) {

                //$st = '<div class="nice-checkbox"><input type="checkbox" class="checkbox-o" name="box[' . $list['news_id'] . ']" value="' . $list['Title'] . '" id="checkbox-o-' . $i . '"><label for="checkbox-o-' . $i . '"></label></div>';

                $st = '<a href="' . RELA_DIR . 'admin.package.php?action=editGroupPackage&id=' . $list['package_group_id'] . '"  rel="tooltip" data-original-title="' . EDIT_01 . '">
                                            <i class="fa fa-pencil text-green"></i>
                                        </a>
                                        <a href="' . RELA_DIR . 'admin.package.php?action=deleteGroupPackage&id=' . $list['package_group_id'] . '"  rel="tooltip" data-original-title="' . DELETE_01 . '">
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

                $st = ($list['package_group_status'] == 0 ? 'Disable' : 'Enable');

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
        $operation = new admin_Package_operation();


        $operationSearchFields = $searchFields;
        unset($operationSearchFields['showFields']);
        $operation->getPackageList($operationSearchFields);

        $list['list'] = $operation->PackageList;

        $list['paging'] = $operation->paging;

        $other['6'] = array(

            'formatter' => function($list) {

                //$st = '<div class="nice-checkbox"><input type="checkbox" class="checkbox-o" name="box[' . $list['news_id'] . ']" value="' . $list['Title'] . '" id="checkbox-o-' . $i . '"><label for="checkbox-o-' . $i . '"></label></div>';

                $st = ($list['package_status'] == 0 ? 'Disable' : 'Enable');

                return $st;
            }
        );

        $other['7'] = array(

            'formatter' => function($list) {

                //$st = '<div class="nice-checkbox"><input type="checkbox" class="checkbox-o" name="box[' . $list['news_id'] . ']" value="' . $list['Title'] . '" id="checkbox-o-' . $i . '"><label for="checkbox-o-' . $i . '"></label></div>';

                $st = '<a href="' . RELA_DIR . 'admin.package.php?action=editPackage&id=' . $list['id'] . '"  rel="tooltip" data-original-title="' . EDIT_01 . '">
                                            <i class="fa fa-pencil text-green"></i>
                                        </a>
                                        <a href="' . RELA_DIR . 'admin.package.php?action=deletePackage&id=' . $list['id'] . '"  rel="tooltip" data-original-title="' . DELETE_01 . '">
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
     * Shows all the Group Packages
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
     * Shows all the packages
     *
     * @param  mixed
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    public function showAllPackages($msg)
    {

        $this->exportType = 'html';
        $this->fileName = 'package.show.php';
        $this->template($msg);
        die();

    }

    /**
     * Add add Group Package
     *
     * @param $fields
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    public function addGroupPackage($fields)
    {
        //******
        $token_list = array_keys($fields['token']);
        $token = $token_list['0'];
        if (isset($_SESSION['token'][$token]) and $_SESSION['token'][$token] == '1') {
            unset($_SESSION['token'][$token]);
        } else {
            $this->addGroupPackageForm($fields, '');
        }
        //******

        global $conn, $lang;
        $operation = new admin_Package_operation();
        $result = $operation->set_groupPackagesInfo($fields);
        if ($result['result'] != 1) {
            $this->addGroupPackageForm($fields, $result['msg']);
        }

        $groupName = $operation->PackageInfo['package_group_name'];
        $compID = $operation->PackageInfo['comp_id'];
        $nameResult = $operation->checkIfGroupNameExists($groupName, $compID);

        if ($nameResult['rowCount'] >= 1) {
            $msg = "This name exists";
            $this->addGroupPackageForm($fields, $msg);
        }

        $result = $operation->insertGroupPackages();

        if ($result == - 1) {
            return $result['msg'];
        } else {
            redirectPage(RELA_DIR . "admin.package.php?action=showGroupPackage", "Successfully added.");
        }
        die();
    }


    /**
     * Add Package
     *
     * @param $fields
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    public function addPackage($fields)
    {

        //******
        $token_list = array_keys($fields['token']);
        $token = $token_list['0'];
        if (isset($_SESSION['token'][$token]) and $_SESSION['token'][$token] == '1') {
            unset($_SESSION['token'][$token]);
        } else {
            $this->addPackageForm($fields, '');
        }
        //******

        $operation = new admin_Package_operation();

        foreach ($operation->addForm as $key => $val) {
            $result = $operation->set_groupPackagesInfo($fields);
            if ($result['result'] != 1) {
                $this->addPackageForm($fields, $result['msg']);
            }
        }

        $packageName = $operation->PackageInfo['package_name'];
        $compID = $operation->PackageInfo['comp_id'];
        $nameResult = $operation->checkIfNameExists($packageName, $compID);

        if ($nameResult['rowCount'] >= 1) {
            $msg = "This name exists";
            $this->addPackageForm($fields, $msg);
        }

        $result = $operation->insertPackages();


        if ($result == - 1) {
            return $result['msg'];
        } else {
            $result = $operation->insertPackageToGroup();
            if ($result == - 1) {
                return $result['msg'];
            } else {
                redirectPage(RELA_DIR . "admin.package.php?action=showPackage", "Successfully added.");
            }

        }
        die();
    }

    /**
     * Add Group Package Form
     *
     * @param $fields
     * @param $msg
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    public function addGroupPackageForm($fields, $msg)
    {
        $this->exportType = 'html';
        $this->fileName = 'package.group.add.form.php';

        //*****
        $uniqid = uniqid();
        $_SESSION['token'][$uniqid] = '1';
        $fields['token'] = 'token[' . $uniqid . ']';
        //*****

        $this->template($fields, $msg);
        die();
    }

    /**
     * Add Package Form
     *
     * @param $fields
     * @param $msg
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    public function addPackageForm($fields, $msg)
    {
        $operation = new admin_Package_operation();
        $operation->getGroupPackageList();
        $fields['GroupList'] = $operation->PackageList;
        $this->exportType = 'html';
        $this->fileName = 'package.add.form.php';

        //*****
        $uniqid = uniqid();
        $_SESSION['token'][$uniqid] = '1';
        $fields['token'] = 'token[' . $uniqid . ']';
        //*****

        $this->template($fields, $msg);
        die();
    }

    /**
     * Edit Group Package
     *
     * @param $fields
     * @param $msg
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    public function editGroupPackage($fields, $msg)
    {

        global $conn, $lang;

        $operation = new admin_Package_operation();
        $result = $operation->set_groupPackagesInfo($fields);


        if ($result['result'] != 1) {
            $this->editGroupPackageForm($fields['id'], $result['msg']);

        }
        $result = $operation->updateGroupPackages();

        if ($result['result'] == 1) {
            redirectPage(RELA_DIR . "admin.package.php", "Successfully updated.");
        } else {
            $this->editGroupPackageForm($fields['id'], $msg);
        }
        die();
    }

    /**
     * Edit Package
     *
     * @param $fields
     * @param $msg
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    public function editPackage($fields, $msg)
    {
        global $conn, $lang;

        $operation = new admin_Package_operation();
        $result = $operation->set_groupPackagesInfo($fields);

        if ($result['result'] != 1) {
            $this->editPackageForm($fields['id'], $result['msg']);

        }
        $result = $operation->updatePackages();

        if ($result['result'] == 1) {
            redirectPage(RELA_DIR . "admin.package.php?action=showPackage", "Successfully updated.");
        } else {
            $this->editPackageForm($fields['id'], $msg);
        }
        die();
    }

    /**
     * Edit Group Package Form
     *
     * @param $GroupPackageID
     * @param $msg
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    public function editGroupPackageForm($GroupPackageID, $msg)
    {
        global $conn, $lang;
        $operation = new admin_Package_operation();
        $result = $operation->getGroupPackageListById($GroupPackageID);


        if ($result['result'] == '0') {
            return $result['msg'];

        }
        $list = $operation->PackageInfo;

        $this->exportType = 'html';
        $this->fileName = 'package.group.edit.form.php';
        $this->template($list, $msg);
        die();
    }

    /**
     * Edit Package Form
     *
     * @param $PackageID
     * @param $msg
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    public function editPackageForm($PackageID, $msg)
    {
        global $conn, $lang;
        $operation = new admin_Package_operation();

        $result = $operation->getPackageListById($PackageID);


        if ($result['result'] == '0') {
            return $result['msg'];

        }
        $list['PackageInfo'] = $operation->PackageInfo;

        $operation = new admin_Package_operation();

        $result = $operation->getGroupPackageList();
        if ($result == - 1) {
            return $result['msg'];
        } else {
            $list['GroupList'] = $operation->PackageList;
        }

        $this->exportType = 'html';
        $this->fileName = 'package.edit.form.php';
        $this->template($list, $msg);
        die();
    }

    /**
     * Deletes Group Package based on its ID
     *
     * @param $GroupPackageID
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    public function deleteGroupPackage($GroupPackageID)
    {

        global $conn, $lang;
        $operation = new admin_Package_operation();
        $result = $operation->deleteGroupPackage($GroupPackageID);

        if ($result['result'] == - 1) {
            return $result;
        } else {
            $msg = 'Successfully deleted.';
            $this->showAllGroupPackages($msg);
        }
    }

    /**
     * Deletes package based on its ID
     *
     * @param $PackageID
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    public function deletePackage($PackageID)
    {

        global $conn, $lang;
        $operation = new admin_Package_operation();
        $result = $operation->deletePackage($PackageID);

        if ($result['result'] == - 1) {
            return $result;
        } else {
            $msg = 'Successfully deleted.';
            $this->showAllPackages($msg);
        }
    }


    /**
     * changeStatus of Package based on its ID
     *
     * @return  mixed
     *
     * @param  mixed
     *
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    public function changeStatus($fields)
    {
        global $conn, $lang;
        $operation = new admin_Package_operation();

        $result = $operation->set_IDs($fields['groupPackageID']);

        if ($result['result'] == - 1) {
            return $result;
        }
        $result = $operation->changeStatus($fields['status']);

        if ($result['result'] == - 1) {
            return $result;
        } else {
            $msg = 'Changed status successfully.';
            $this->showAllGroupPackages($msg);
        }
    }

    /**
     * change Status of Package based on its ID
     *
     * @return  mixed
     *
     * @param  mixed
     *
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    public function changePackageStatus($fields)
    {

        global $conn, $lang;
        $operation = new admin_Package_operation();

        $result = $operation->set_IDs($fields['ID']);

        if ($result['result'] == - 1) {
            return $result;
        }
        $result = $operation->changePackageStatus($fields['status']);

        if ($result['result'] == - 1) {
            return $result;
        } else {
            $msg = 'Changed status successfully.';
            $this->showAllPackages($msg);
        }
    }


    /**
     * Add add Group Package to company
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    public function addGroupPackageToCompanyForm()
    {
        $list['CompanyList'] = $this->showAllCompany();


        $operation = new admin_Package_operation();
        $result = $operation->getGroupPackageList();
        if ($result == - 1) {
            return $result['msg'];
        } else {
            $list['GroupList'] = $operation->PackageList;
        }
        $this->exportType = 'html';
        $this->fileName = 'package.group.add.to.company.php';
        $this->template($list);
        die();
    }

    /**
     * Add add Group Package to company
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    public function removeGroupPackageFromCompanyForm()
    {
        $list['CompanyList'] = $this->showAllCompany();


        $operation = new admin_Package_operation();
        $result = $operation->getGroupPackageList();
        if ($result == - 1) {
            return $result['msg'];
        } else {
            $list['GroupList'] = $operation->PackageList;
        }
        $this->exportType = 'html';
        $this->fileName = 'package.group.remove.from.company.php';
        $this->template($list);
        die();
    }

    /**
     * Add addGroupPackage to company
     *
     * @param  $list
     * @param  $msg
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    public function addPackageToCompanyForm($list, $msg)
    {
        $list['CompanyList'] = $this->showAllCompany();


        $operation = new admin_Package_operation();
        $result = $operation->getPackageList();
        if ($result == - 1) {
            return $result['msg'];
        } else {
            $list['PackageList'] = $operation->PackageList;
        }

        $this->exportType = 'html';
        $this->fileName = 'package.add.to.company.php';
        $this->template($list, $msg);
        die();
    }

    /**
     * Add add Group Package to company
     *
     * @param  $fields
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    public function addGroupPackageToCompany($fields)
    {
        global $conn, $lang;
        $operation = new admin_Package_operation();
        $result = $operation->set_groupPackagesInfo($fields);
        if ($result['result'] != 1) {
            $this->addGroupPackageToCompanyForm($fields, $result['msg']);
        }

        $result = $operation->insertGroupPackagesToCompany();


        if ($result == - 1) {
            return $result['msg'];
        } else {
            redirectPage(RELA_DIR . "package.php?action=buyPackage", "Successfully added.");
        }

        die();
    }

    /**
     * Add add Group Package to company
     *
     * @param  $fields
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    public function removeGroupPackageFromCompany($fields)
    {
        global $conn, $lang;
        $operation = new admin_Package_operation();
        $result = $operation->set_groupPackagesInfo($fields);
        if ($result['result'] != 1) {
            $this->removeGroupPackageFromCompanyForm($fields, $result['msg']);
        }

        $result = $operation->removeGroupPackagesFromCompany();


        if ($result == - 1) {
            return $result['msg'];
        } else {
            redirectPage(RELA_DIR . "admin.package.php?action=buyPackage", "Successfully removed.");
        }

        die();
    }


    /**
     * Add add Group Package to company
     *
     * @param  $fields
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   01.01.01
     * @date    08/08/2015
     */
    public function addPackageToCompany($fields)
    {

        global $conn, $lang;
        $operation = new admin_Package_operation();

        $result = $operation->getPackageListById($fields['package_id']);

        if ($result == - 1) {
            return $result['msg'];
        }

        $result = $operation->set_groupPackagesInfo($fields);

        if ($result['result'] != 1) {
            $this->addPackageToCompanyForm($fields, $result['msg']);
        }

        $result = $operation->insertPackagesToCompany();


        if ($result == - 1) {
            return $result['msg'];
        } else {
            redirectPage(RELA_DIR . "package.php?action=showCompanyPackage", "Successfully added.");
        }

        die();
    }


    /**
     * Shows all the companies
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function showAllCompany()
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
     *
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function calculate()
    {
        global $conn, $lang;

        $operation = new admin_Package_operation();
        $result = $operation->calculatePackage();

        if ($result['result'] != 1) {
            return $result['msg'];
        }

    }

}