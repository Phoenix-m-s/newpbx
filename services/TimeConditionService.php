<?php

include_once ROOT_DIR . "component/timeCondition/mainTimeConditionModel.php";

/**
 * Class TimeConditionService
 */
class TimeConditionService
{
    /**
     *getAllTimeCondition
     * @author:Mojtaba Sakhamanesh & Shabihi
     * @Email:sakhamanesh@dabacenter.ir
     * @return mixed
     * @version:0.0.1
     */
    public function getAllTimeCondition()
    {

        global $company_info;

        $timeConditionList = AdminMainTimeConditionModel::getAll()
            ->where('comp_id', '=', $company_info['comp_id'])->get();


        $result['0'] = array('name' => 'choose from list', 'id' => '');
        $i = 1;
        foreach ($timeConditionList['export']['list'] as $key => $value) {
            $result[$i]['name'] = $value->fields['name'];
            $result[$i]['id'] = $value->fields['id'];
            //print_r_debug($result);
            $i++;
        }
       // print_r_debug($result);
        return $result;

    }
    public function getAllTimeConditionExtension()
    {

        global $company_info;

        $timeConditionList = AdminNewNameExstionModel::getAll()
            ->where('comp_id', '=', $company_info['comp_id'])->get();


        $result['0'] = array('name' => 'choose from list', 'id' => '');
        $i = 1;
        foreach ($timeConditionList['export']['list'] as $key => $value) {
            $result[$i]['name'] = $value->fields['name'];
            $result[$i]['id'] = $value->fields['id'];
            //print_r_debug($result);
            $i++;
        }
       // print_r_debug($result);
        return $result;

    }

}