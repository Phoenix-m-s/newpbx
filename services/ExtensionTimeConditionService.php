<?php
include_once ROOT_DIR . "component/timeCondition/AdminNewNameExstionModel.php";

/**
 * Created by PhpStorm.
 * User: Shabihi
 * Date: 10/22/2018
 * Time: 11:13 AM
 */
class ExtensionTimeConditionService
{
    public function getAllExtensionTimeCondition($id)
    {

        global $company_info;

        if(isset($id))
        {
            $ExtensionTimeConditionList = AdminNewNameExstionModel::getAll()
        ->where('comp_id', '=', $company_info['comp_id'])
        ->where('extension_id','=',$id)
        ->get();

        }
        else{

            $ExtensionTimeConditionList = AdminMainTimeConditionModel::getAll()
                ->where('comp_id', '=', $company_info['comp_id'])->get();
        }


        $result['0'] = array('name' => 'choose from list', 'id' => '');
        $i = 1;
        foreach ($ExtensionTimeConditionList['export']['list'] as $key => $value) {
            $result[$i]['name'] = $value->fields['name'];
            $result[$i]['id'] = $value->fields['id'];
            $i++;
        }
        return $result;
    }
}