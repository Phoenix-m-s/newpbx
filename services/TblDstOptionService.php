<?php

include_once ROOT_DIR . "component/dst_option/adminDstOptionModel.php";
include_once ROOT_DIR . "services/AnnouncementService.php";
include_once ROOT_DIR . "services/ExtensionService.php";
include_once ROOT_DIR . "services/SipService.php";
include_once ROOT_DIR . "services/QueueService.php";
include_once ROOT_DIR . "services/IvrService.php";
include_once ROOT_DIR . "services/InboundService.php";
include_once ROOT_DIR . "services/VoiceMailService.php";
include_once ROOT_DIR . "services/HangUpService.php";
include_once ROOT_DIR . "services/ForwardService.php";
include_once ROOT_DIR . "services/TimeConditionService.php";
include_once ROOT_DIR . "services/ExtensionTimeConditionService.php";
include_once ROOT_DIR . "services/DirectDialService.php";
include_once ROOT_DIR . "services/FaxService.php";
include_once ROOT_DIR . "services/TimezoneService.php";

/**
 * Class TblDstOptionService
 */
class TblDstOptionService
{


    /**
     * @var array
     */
    public $dstServiceList = array(
        1 => 'Sip',
        2 => 'Queue',
        3 => 'Extension',
        4 => 'Announcement',
        5 => 'Ivr',
        6 => 'VoiceMail',
        7 => 'HangUp',
        8 => 'TimeCondition',
        9 => 'Forward',
        10 => 'DirectDial',
        11 => 'Fax',
        12 => 'ExtensionTimeCondition',
        14 => 'Conference'

    );

    /**
     * @param $name
     * @return mixed
     */
    private function getDstOptionByname($name, $id)
    {
        $dstOptionList = AdminDstOptionModel::getAll()
            ->where($name . '_used', '=', '1')
            ->orderBy('priority')
            ->get();

        $i = 0;
        foreach ($dstOptionList['export']['list'] as $key => $value) {

            $list[$i]['name'] = $value->option_value;
            $list[$i]['dst_option_id'] = $value->dst_option_id;

            if ($value->dst_option_id == 12 or $value->dst_option_id == 9) {
                $list[$i]['id'] = $id;
            } else if ($value->dst_option_id == 13) {
                $list[$i]['dst_option_id'] = '';
            }

            $i++;
        }
        return $list;
    }

    /**
     * @return mixed
     */
    public function getAnnouncementOption()
    {
        return $this->getDstOptionByname('announce', '');
    }

    /**
     * @return mixed
     */
    public function getTimeConditionOption()
    {
        return $this->getDstOptionByname('time_condition', '');
    }

    /**
     * @return mixed
     */
    public function getExtensionSuccessOption($id)
    {
        return $this->getDstOptionByname('extension_success', $id);
    }

    public function getExtensionFailedOption($id)
    {
        return $this->getDstOptionByname('extension_failed', $id);
    }

    /**
     * @return mixed
     */
    public function getExtensionTimeConditionOption($id)
    {
        return $this->getDstOptionByname('extension_time_condition', $id);
    }

    /**
     * @return mixed
     */
    public function getIvrOption()
    {
        return $this->getDstOptionByname('ivr', '');
    }

    /**
     * @return mixed
     */
    public function getQueueOption()
    {
        return $this->getDstOptionByname('queue', '');
    }

    /**
     * @return mixed
     */
    public function getInboundOption()
    {
        return $this->getDstOptionByname('inbound', '');
    }

    public function checkDstSubOptioptionId($dst_option_id, $dst_option_sub_id, $DSTOption)
    {
        if ($dst_option_id == 9 and $dst_option_sub_id == 2 and $DSTOption == '') {
            $result['msg'] = 'Please fill required items';
            $result['result'] = -1;
            return $result;
        }
    }

    /**
     * @param $list
     * @return mixed
     */
    public function getDialExtensionDetailByName($list, $id)
    {
        //print_r_debug($list);


        /*$dstServiceList=array(
            1=>'Sip',
            2=>'Queue',
            3=>'Extension',
            4=>'Announcement',
            5=>'Ivr',
            6=>'VoiceMail',
            7=>'HangUp',
            8=>'TimeCondition',
            9=>'Forward',
            10=>'DirectDial',
            11=>'Fax'
        );*/

        $i = 1;
        foreach ($list as $key => $value) {

            if ($value['dst_option_id'] == '') {
                $list[$key]['child'] = array();
                continue;
            }
            $serviceName = $this->dstServiceList[$value['dst_option_id']] . 'Service';

            $className = new $serviceName();
            $funcName = 'getAll' . $this->dstServiceList[$value['dst_option_id']];



            if ($value['dst_option_id'] == 13 or $value['dst_option_id'] == 9) {

                $list[$key]['child'] = $className->$funcName($value['id']);
            } else if ($value['dst_option_id'] ==6) {
                $list[$key]['child'] = $className->$funcName($id);
                //print_r_debug($list[$key]['child'] = $className->$funcName($id));
               
            } else {

                $list[$key]['child'] = $className->$funcName();
            }

            if ($value['dst_option_id'] == 12){
                $serviceName = new TimeConditionService();
                $list[$key]['child'] = $serviceName->getAllTimeConditionExtension();

            }
            $i++;
            
        }
        //print_r_debug($list);
      
        return $list;
    }
    public function getDialExtensionDetailByNameExtension($list, $id)
    {
        //print_r_debug($list);


        /*$dstServiceList=array(
            1=>'Sip',
            2=>'Queue',
            3=>'Extension',
            4=>'Announcement',
            5=>'Ivr',
            6=>'VoiceMail',
            7=>'HangUp',
            8=>'TimeCondition',
            9=>'Forward',
            10=>'DirectDial',
            11=>'Fax'
        );*/

        $i = 1;
        foreach ($list as $key => $value) {

            if ($value['dst_option_id'] == '') {
                $list[$key]['child'] = array();
                continue;
            }
            $serviceName = $this->dstServiceList[$value['dst_option_id']] . 'Service';

            $className = new $serviceName();
            $funcName = 'getAll' . $this->dstServiceList[$value['dst_option_id']];



            if ($value['dst_option_id'] == 13 or $value['dst_option_id'] == 9) {

                $list[$key]['child'] = $className->$funcName($value['id']);
            } else if ($value['dst_option_id'] ==6) {
                $list[$key]['child'] = $className->$funcName($id);
                //print_r_debug($list[$key]['child'] = $className->$funcName($id));

            } else {

                $list[$key]['child'] = $className->$funcName();
            }

            if ($value['dst_option_id'] == 12){
                $serviceName = new TimeConditionService();
                $list[$key]['child'] = $serviceName->getAllTimeConditionExtension();

            }
            $i++;

        }
        //print_r_debug($list);

        return $list;
    }


}