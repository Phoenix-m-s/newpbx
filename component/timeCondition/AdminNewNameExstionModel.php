<?php

class AdminNewNameExstionModel extends looeic
{
    protected $TABLE_NAME = 'time_condition_name';
    protected $rules = array(
        'name' => 'required*' . EXTENSION_40
    );

    public function SetFieldsAndSave($fields)
    {
        $model = new AdminNewNameExstionModel();
        $model->name = $fields['name'];
        $model->comp_id = $fields['comp_id'];
        $model->extension_id = $fields['extension_id'];

        $validate = $model->validator();

        if ($validate['result'] == -1) {
            $validate['result'] = -1;
            return $validate;
        }

        $timeConditionName = AdminNewNameExstionModel::getBy_comp_id_and_name_and_extension_id($fields['comp_id'], $fields['name'], $fields['extension_id'])->getList();
        if ($timeConditionName['export']['recordsCount'] >= 1) {
            $result['result'] = -1;
            $result['msg'] = 'this timeCondition name is exist';
            return $result;
        }

        $result = $model->save();
        if ($result['result'] == -1) {
            $result['result'] = -1;
            return $result;
        }
        $result['result'] = 1;
        $result['id'] = $model->id;
        return $result;
    }
}

?>