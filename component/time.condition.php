<?php

class adminTimeConditionModel extends looeic
{
    protected $TABLE_NAME = "time_condition";

    public function SetFieldsAndSave($fields)
    {
        for ($i = 0; $i < count($fields['hourStart']); $i ++) {
            $model = new adminTimeConditionModel();
            $model->extension_id = $fields[ 'id' ];
            $model->weekDayStart = $fields[ 'weekDayStart' ][ $i ];
            $model->weekDayEnd = $fields[ 'weekDayEnd' ][ $i ];
            $model->dayStart = $fields[ 'dayStart' ][ $i ];
            $model->dayEnd = $fields[ 'dayEnd' ][ $i ];
            $model->monthStart = $fields[ 'monthStart' ][ $i ];
            $model->monthEnd = $fields[ 'monthEnd' ][ $i ];
            $model->hourStart = $fields[ 'hourStart' ][ $i ];
            $model->hourEnd = $fields[ 'hourEnd' ][ $i ];
            $model->status = $fields[ 'status' ];
            $model->FDialExtension = $fields[ 'status' ];
            $model->FForward = $fields[ 'status' ];
            $model->FDSTOption = $fields[ 'status'];

    //------------------------------ success dial destination in time condition ------------------------------//
            if(isset($fields[ 'dialExtension' ][ $i ]) & !empty($fields[ 'dialExtension' ][ $i ])) {
                $model->dialExtension = $fields[ 'dialExtension' ][ $i ];
            }
            if(isset($fields[ 'forward' ][ $i ]) & !empty($fields[ 'forward' ][ $i ])) {
                $model->forward = $fields[ 'forward' ][ $i ];
            }
            if(isset($fields[ 'DSTOption' ][ $i ]) & !empty($fields[ 'DSTOption' ][ $i ])) {
                $model->DSTOption = $fields[ 'DSTOption' ][ $i ];
            }
    //------------------------------ failed dial destination in time condition ------------------------------//
            if(isset($fields[ 'FDialExtension' ]) & !empty($fields[ 'FDialExtension' ])) {
                $model->FDialExtension = $fields[ 'FDialExtension' ];
            }
            if(isset($fields[ 'FForward' ]) & !empty($fields[ 'FForward' ])) {
                $model->FForward = $fields[ 'FForward' ];
            }
            if(isset($fields[ 'FDSTOption' ]) & !empty($fields[ 'FDSTOption' ])) {
                $model->FDSTOption = $fields[ 'FDSTOption' ];
            }
            $result = $model->save();
        }
        return $result;
    }

    public function SetFieldsAndSaveApi($fields)
    {
        $results = [];

        foreach ($fields['tc'] as $i => $tc) {
            $model = new adminTimeConditionModel();
            $model->extension_id = $fields['extension_id'];
            $model->comp_id = $fields['comp_id'];
            $model->time_condtion_name_id=$fields['time_condtion_name_id'];

            // تنظیم فیلدها با مقادیر پیش‌فرض در صورت نبود آنها
            $tc['dayStart'] = $tc['dayStart'];
            $tc['dayEnd'] = $tc['dayEnd'];
            $tc['monthStart'] = $tc['monthStart'];
            $tc['monthEnd'] = $tc['monthEnd'];

            // تنظیم مقادیر
            $model->weekDayStart = $tc['weekDayStart'];
            $model->weekDayEnd = $tc['weekDayEnd'];
            $model->dayStart = $tc['dayStart'];
            $model->dayEnd = $tc['dayEnd'];
            $model->monthStart = $tc['monthStart'];
            $model->monthEnd = $tc['monthEnd'];
            $model->hourStart = $tc['hourStart'];
            $model->hourEnd = $tc['hourEnd'];
            $model-> dst_option_id  = $tc['dst_option_id'];
            $model-> dst_option_sub_id  = $tc['dst_option_sub_id'];
            $model->DSTOption = $tc['DSTOption'];
            $model->status = 0;
            $model->FDialExtension = $fields['status'];
            $model->FForward = $fields['status'];
            $model->FDSTOption = $fields['status'];

            // ذخیره و بررسی موفقیت‌آمیز بودن
            if (!$model->save()) {
                $results[] = [
                    'result' => -1,
                    'msg' => 'Failed to save model',
                    'errors' => $model->getErrors(),
                ];
                continue;
            }

            $results[] = [
                'result' => 1,
                'msg' => 'Model saved successfully',
            ];
        }

        if (empty($results)) {
            return [
                'result' => -1,
                'msg' => 'No time conditions were saved',
            ];
        }

        return [
            'result' => 1,
            'msg' => 'Time conditions saved successfully',
            'details' => $results,
        ];
    }
}