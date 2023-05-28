<?php
include_once ROOT_DIR . "component/routing/model/routingModel.php";
include_once ROOT_DIR . "services/InboundService.php";
include_once ROOT_DIR . "component/inbound/admin/model/adminInboundModel.php";
/**
 * Class RoutingService
 */
class RoutingService
{
    /**
     *getAllRouting
     * @return mixed
     * @author:Mojtaba Sakhamanesh & Shabihi
     * @Email:sakhamanesh@dabacenter.ir
     * @version:0.0.1
     */
    public function getAllRouting()
    {
        global $company_info;
        $routingList = routingModel::getAll()->get();
        $result['0'] = array('name' => 'choose from list', 'id' => '');
        $i = 1;
        foreach ($routingList['export']['list'] as $key => $value) {
            //$result[$i]['id'] = $value->fields['routing_id'];
            $result[$i]['comp_id'] = $value->fields['comp_id'];
            $result[$i]['phone'] = $value->fields['phone'];
            $i++;
        }
        return $result;

    }

    public function addRouting($fields)
    {
        $result = adminInboundModel::getAll()->where('inbound_status','=',2)->get();
        foreach ($result['export']['list'] as $key =>$obj)
        {
            $obj->delete();
        }

        $check = true;
        $result = array(
            "result" => -1,
            "msg" => "error"
        );


        looeic::beginTransaction();


        $list=routingModel::getAll()->get();
        foreach ($list['export']['list'] as $key =>$obj)
        {
            $obj->delete();
        }
        $this->insertInbound($fields);
        $data=array();
        foreach ($fields['data'] as $item) {

            if (isset($data[$item['comp_id']][$item['phone']])) {
                looeic::rollback();
                return array(
                    "result" => -1,
                    "msg" => 'The Phone Number "'.$item['phone'].'" Is Exist'
                );
            }

            if ($item['comp_id']=='' || $item['phone']=='') {

                //looeic::rollback();
                return array(
                    "result" => -1,
                    "msg" => 'Please Enter PhoneNumber or Company'
                )
                ;

            }
            $data[$item['comp_id']][$item['phone']]=1;

            $model = new routingModel();
            $model->setFields($item);
            $result = $model->save($item);
            if ($result['result'] != 1) {
                $check = false;
                looeic::rollback();
            }

        }

        if (!$check) {
            $result['result'] = -1;
            looeic::rollback();
        } else {
            looeic::commit();

            $result = array(
                "result" => 1,
                "msg" => "Successfully Updated"
            );
        }

        return $result;
    }

    public function insertInbound($fields)
    {

        $i=0;
        foreach ($fields['data'] as $value){

            $value[$i]['inbound_name'] = $value['phone'];
            $value[$i]['did_name'] = $value['phone'];
            $value[$i]['inbound_status'] = 2;
            $value[$i]['dst_option_id'] = 7;
            $value[$i]['comp_id'] = $value['comp_id'];
            $inboundObj = new AdminInboundModel();
            unset($value['phone']);
            unset($value['comp_id']);
            $inboundObj->setFields($value[$i]);
            $result = $inboundObj->save();
            if ($result['result'] != 1) {
                $check = false;
                looeic::rollback();
            }
            $i++;
        }
        return $result;
    }


}
