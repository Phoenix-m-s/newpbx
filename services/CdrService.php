<?php
include_once ROOT_DIR . "component/cdr/component/model/cdrModel.php";


/**
 * Class CdrService
 * add by Sakhamanesh
 */
class CdrService
{

    /*public $cdrServiceVar;

    public function __construct($cdrServiceVar)
    {

        $this->$cdrServiceVar = new  AdminCdrModel();
    }*/

    public function getInfoCdr($extensionNo)
    {
        global $admin_info;
        $cdrList = cdrModel::getAll()
            ->select(cdrModel::$cdrFillable)
            ->where('src', '=', $extensionNo)
            ->orWhere('dst', '=', $extensionNo)
            ->orWhere('comp_id', '=', $admin_info['comp_id'])
            ->orderBy('calldate','desc')
            ->paginate(20)
            ->getList();

        print_r_debug($cdrList);

        return $cdrList;

    }

}