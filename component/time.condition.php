<?php

class adminTimeConditionModel extends looeic
{
    protected $TABLE_NAME = "time_condition";

    public function SetFieldsAndSave($fields)
    {
        for ($i = 0; $i < count($fields[ 'hourStart' ]); $i ++) {
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
            $model->FDSTOption = $fields[ 'status' ];
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
            $result = $model->save ();
        }
        return $result;
    }


}