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
        $timeConditionList = AdminMainTimeConditionModel::getAll()->get();
        $result['0'] = array('name' => 'choose from list', 'id' => '');
        $i = 1;
        foreach ($timeConditionList['export']['list'] as $key => $value) {
            $result[$i]['name'] = $value->fields['name'];
            $result[$i]['id'] = $value->fields['id'];
            $i++;
        }

        return $result;

    }

}