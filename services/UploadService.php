<?php
include_once ROOT_DIR . "component/upload/AdminUploadModel.php";

/**
 * Created by PhpStorm.
 * User: Shabihi
 * Date: 10/15/2018
 * Time: 10:38 AM
 */
class UploadService
{
    public function getUploadList()
    {
        global $admin_info;

        $uploadDirty = AdminUploadModel::getAll()
            ->where('comp_id', '=', $admin_info['comp_id'])->get();
        $fields[0]['name'] = 'Choose from list';
        $fields[0]['id'] = '';

        foreach ($uploadDirty['export']['list'] as $key => $value) {
            $fields[$key+1]['name'] = $value->fields['title'];
            $fields[$key+1]['id'] = $value->fields['upload_id'];
        }
        return $fields;
    }
}