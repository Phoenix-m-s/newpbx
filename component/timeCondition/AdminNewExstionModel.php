<?php

/**
 * Created by PhpStorm.
 * User: VeRJiL
 * Date: 1/16/2017
 * Time: 11:56 AM
 */
class AdminNewExstionModel extends looeic
{
    protected $TABLE_NAME = 'time_condition';
    protected $rules = array(
        'hourStart' => 'required*' . 'please fill in the hourStart',
        'hourEnd' => 'required*' . 'please fill in the hourEnd'

    );

    public function checkStartAndEnd($nameStart, $nameEnd)
    {
        if ($this->$nameStart != '' && $this->$nameEnd == '') {
            $result['msg'] = 'Please fill ' . $nameEnd . ' item';
            $result['result'] = -1;
            return $result;

        } elseif ($this->$nameEnd != '' && $this->$nameStart == '') {
            $result['msg'] = 'Please fill ' . $nameStart . ' item';
            $result['result'] = -1;
            return $result;
        }
        if ($nameStart == 'hourStart') {
            if (strtotime($this->$nameStart) > strtotime($this->$nameEnd)) {
                $result['msg'] = $nameEnd . ' must be greater than ' . $nameStart;
                $result['result'] = -1;
                return $result;
            }
        } else if ($this->$nameStart > $this->$nameEnd) {
            $result['msg'] = $nameEnd . ' must be greater than ' . $nameStart;
            $result['result'] = -1;
            return $result;
        }
    }

    public function validateCondition()
    {
        $conditionList = array('hour', 'weekDay', 'day', 'month');
        foreach ($conditionList as $conditionFields) {
            $result['result'] = 1;
            $nameStart = $conditionFields . 'Start';
            $nameEnd = $conditionFields . 'End';
            $result = $this->checkStartAndEnd($nameStart, $nameEnd);
            if ($result['result'] == -1) {
                return $result;
            }
        }
    }

    public function SetFieldsAndSave($fields)
    {
        if (count($fields['tc']) < 1) {
            $result['result'] = -1;
            $result['msg'] = 'One item required';
            echo json_encode($result);
            die();
        }
        foreach ($fields['tc'] as $k => $v) {
            $model = new AdminNewExstionModel();
            $model->setFields($v);
            $model->comp_id = $fields['comp_id'];
            $model->time_condtion_name_id = $fields['timeConditionID'];
            $model->extension_id = $fields['extension_id'];
            $model->dst_option_id = $v['dst_option_id_selected']['dst_option_id'];
            $model->dst_option_sub_id = $v['dst_option_id_selected']['dst_option_sub_id'];
            $model->DSTOption = $v['dst_option_id_selected']['DSTOption'];
            $model->fdst_option_id = $fields['failTc'][0]['fdst_option_id'];
            $model->fdst_option_sub_id = $fields['failTc'][0]['fdst_option_sub_id'];
            $model->fDSTOption = $fields['failTc'][0]['fDSTOption'];
            $validate = $model->validator();
            if ($validate['result'] == -1) {
                looeic::rollback();
                $result = $validate;
                $result['result'] = -1;
                echo json_encode($result);
                die();
            } else {
                $result = $model->validateCondition();
                if ($result['result'] == -1) {
                    looeic::rollback();
                    echo json_encode($result);
                    die();
                }
            }

            $result = $model->save();
        }

        $result['result'] = 1;
        return $result;
    }
}