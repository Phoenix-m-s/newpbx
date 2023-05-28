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
        $ExtensionTimeConditionList = AdminNewNameExstionModel::getBy_extension_id($id)->get();
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