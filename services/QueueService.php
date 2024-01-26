<?php
include_once ROOT_DIR . "component/queue/adminQueueModel.php";
include_once ROOT_DIR . "services/ExtensionService.php";
include_once ROOT_DIR . "services/TblDstOptionService.php";
include_once ROOT_DIR . "services/UploadService.php";

/**
 * Class QueueService
 */
class QueueService
{
    public $QueueObj;

    /**
     *
     *getAllSip()
     * @author:Mojtaba Sakhamanesh & Shabihi
     * @Email:sakhamanesh@dabacenter.ir
     * @return mixed
     * @version:0.0.1
     * @return mixed
     *
     */
    public function getAllQueue()
    {
        global $admin_info;
        $queueList = adminQueueModel::getAll()
            ->where('comp_id', '=', $admin_info['comp_id'])->get();
        $result['0'] = array('name' => 'choose from list', 'id' => '');
        $i = 1;
        foreach ($queueList['export']['list'] as $key => $value) {
            $result[$i]['name'] = $value->fields['queue_name'];
            $result[$i]['id'] = $value->fields['queue_id'];
            $i++;

        }
        return $result;

    }

    public function addQueueForm()
    {
        //////////////get extensionList////////////
        $extensionNameList = new ExtensionService();
        $fields['agents_no'] = $extensionNameList->getAllExteحnsionName();

        //////////////get dialExtensionDetail////////////
        $queueOption = new TblDstOptionService();
        $dialExtension_list = $queueOption->getQueueOption();
        $fields['dst_option_id'] = $queueOption->getDialExtensionDetailByName($dialExtension_list);
        $fields['action'] = 'addQueue';
        $list = json_encode($fields, JSON_PRETTY_PRINT);
        return $list;
    }

    public function showEditQueueForm($fields)
    {
        $fields = $this->setFieldsSelected($fields);
        $upload = new UploadService();
        $fields['upload_id'] = $upload->getUploadList();
        $fields['agents_no_selected'] = explode(',', $fields['agents_no']);
        $extensionNameList = new ExtensionService();
        $fields['agents_no'] = $extensionNameList->getAllExtensionName();
        $ivrOption = new TblDstOptionService();
        $dialExtension_list = $ivrOption->getIvrOption();
        $fields['dst_option_id'] = $ivrOption->getDialExtensionDetailByName($dialExtension_list);
        $fields['action'] = 'editQueue';
        $list = json_encode($fields, JSON_PRETTY_PRINT);
        return $list;
    }

    public function addQueue($fields)
    {
        global $admin_info, $company_info;
        $fields['comp_id'] = $company_info['comp_id'];
        $queueName = $this->checkQueueName($fields);
        if ($queueName['export']['recordsCount'] >= 1) {
            $result['result'] = -1;
            $result['msg'] = 'this queue name is exist';
            return $result;
        }

        $queueNumber = $this->checkQueueNumber($fields);
        if ($queueNumber['export']['recordsCount'] >= 1) {
            $result['result'] = -1;
            $result['msg'] = 'this queue number is exist';
            return $result;
        }

        $extension = new ExtensionService();
        $extensionNumberCheck = $extension->checkExtensionNumber($fields);
        if ($extensionNumberCheck['export']['recordsCount'] >= 1) {
            $result['result'] = -1;
            $result['msg'] = 'this extension number is exist';
            return $result;
        }

        $this->QueueObj = new adminQueueModel();
        $this->QueueObj->comp_id = $admin_info['comp_id'];
        $this->QueueObj->setFields($fields);
        $this->resetData($fields);

        if ($this->QueueObj->dst_option_id != '' and $this->QueueObj->dst_option_sub_id == '') {
            if (!in_array($this->QueueObj->dst_option_id, ['7', '10', '11'])) {
                $result['msg'] = 'Please fill required items';
                $result['result'] = -1;
                return $result;
            }
        }

        $checkExternal = new TblDstOptionService();
        $result = $checkExternal->checkDstSubOptioptionId($this->QueueObj->dst_option_id, $this->QueueObj->dst_option_sub_id, $this->QueueObj->DSTOption);
        if ($result['result'] == -1) {
            return $result;
        }

        $validate = $this->QueueObj->validator();
        if ($validate['result'] == -1) {
            $result['msg'] = $validate['msg'];
            $result['result'] = -1;
            return $result;
        }

        $result = $this->QueueObj->save();
        if ($result['result'] != 1) {
            $result['result'] = -1;
            $result['msg'] = 'Failed To Updated';
            return $result;
        }
        return $result;
    }

    public function editQueue($fields)
    {
        global $company_info;
        $fields['comp_id'] = $company_info['comp_id'];
        $this->QueueObj = AdminQueueModel::find($fields['queue_id']);
        $result = $this->QueueObj->setFields($fields);
        $this->resetData($fields);

        if ($this->QueueObj->dst_option_id != '' and $this->QueueObj->dst_option_sub_id == '') {
            if (!in_array($this->QueueObj->dst_option_id, ['7', '10', '11'])) {
                $result['msg'] = 'Please fill required items';
                $result['result'] = -1;
                return $result;
            }
        }

        $checkExternal = new TblDstOptionService();
        $result = $checkExternal->checkDstSubOptioptionId($this->QueueObj->dst_option_id, $this->QueueObj->dst_option_sub_id, $this->QueueObj->DSTOption);
        if ($result['result'] == -1) {
            return $result;
        }

        $validate = $this->QueueObj->validator();
        if ($validate['result'] == -1) {
            $result['msg'] = $validate['msg'];
            $result['result'] = -1;
            return $result;
        }

        $queueName = $this->checkQueueName($fields);
        if ($queueName['export']['recordsCount'] >= 1) {
            $result['result'] = -1;
            $result['msg'] = 'this queue name is exist';
            return $result;
        }

        $queueNumber = $this->checkQueueNumber($fields);
        if ($queueNumber['export']['recordsCount'] >= 1) {
            $result['result'] = -1;
            $result['msg'] = 'this queue number is exist';
            return $result;
        }

        $extension = new ExtensionService();
        $extensionNumberCheck = $extension->checkExtensionNumber($fields);
        if ($extensionNumberCheck['export']['recordsCount'] >= 1) {
            $result['result'] = -1;
            $result['msg'] = 'this extension number is exist';
            return $result;
        }
        $result = $this->QueueObj->save();
        if ($result['result'] != 1) {
            $result['result'] = -1;
            $result['msg'] = 'Failed To Updated';
            return $result;
        }
        return $result;
    }

    public function checkQueueName($fields)
    {
        return adminQueueModel::getBy_comp_id_and_queue_name_and_not_queue_id($fields['comp_id'], $fields['queue_name'], $fields['queue_id'])->getList();
    }

    public function checkQueueNumber($fields)
    {
        return adminQueueModel::getBy_queue_ext_no_and_comp_id_and_not_queue_id($fields['queue_ext_no'], $fields['comp_id'], $fields['queue_id'])->getList();
    }

    public function resetData($fields)
    {
        $this->QueueObj->dst_option_id = $fields['dst_option_id_selected']['0']['dst_option_id'];
        $this->QueueObj->dst_option_sub_id = $fields['dst_option_id_selected']['0']['dst_option_sub_id'];
        $this->QueueObj->DSTOption = $fields['dst_option_id_selected']['0']['DSTOption'];
        $this->QueueObj->agents_no = implode(',', $fields['agents_no']);

        if ($fields['ring_strategy'] == 'Memory') {
            $this->QueueObj->ring_strategy = 'rrmemory';
        } elseif ($fields['ring_strategy'] == 'Random') {
            $this->QueueObj->ring_strategy = 'random';
        } elseif ($fields['ring_strategy'] == 'Ring_all') {
            $this->QueueObj->ring_strategy = 'ringall';
        } elseif ($fields['ring_strategy'] == 'Fewest_call') {
            $this->QueueObj->ring_strategy = 'fewestcalls';
        } elseif ($fields['ring_strategy'] == 'Round_Robin') {
            $this->QueueObj->ring_strategy = 'roundrobin';
        }
    }

    public function setFieldsSelected($fields)
    {
        $fields['dst_option_id_selected'][0]['dst_option_id'] = $fields['dst_option_id'];
        $fields['dst_option_id_selected'][0]['dst_option_sub_id'] = $fields['dst_option_sub_id'];
        $fields['dst_option_id_selected'][0]['DSTOption'] = $fields['DSTOption'];

        unset($fields['dst_option_id']);
        unset($fields['dst_option_sub_id']);
        unset($fields['forward']);
        unset($fields['DSTOption']);

        if ($fields['ring_strategy'] == 'rrmemory') {
            $fields['ring_strategy'] = 'Memory';
        } elseif ($fields['ring_strategy'] == 'random') {
            $fields['ring_strategy'] = 'Random';
        } elseif ($fields['ring_strategy'] == 'ringall') {
            $fields['ring_strategy'] = 'Ring_all';
        } elseif ($fields['ring_strategy'] == 'fewestcalls') {
            $fields['ring_strategy'] = 'Fewest_call';
        } elseif ($fields['ring_strategy'] == 'roundrobin') {
            $fields['ring_strategy'] = 'Round_Robin';
        }
        return $fields;
    }
}