<?php
include_once ROOT_DIR . "component/ivr/adminIVRModel.php";
include_once ROOT_DIR . "component/queue/adminQueueModel.php";
include_once ROOT_DIR . "component/announce/adminAnnounceModel.php";
include_once ROOT_DIR . "component/inbound/adminInboundModel.php";
include_once ROOT_DIR . "component/timeCondition/mainTimeConditionModel.php";
include_once ROOT_DIR . "component/outbound/adminOutboundModel.php";
include_once ROOT_DIR . "component/extension/AdminExstionNewModel.php";
include_once ROOT_DIR . "component/timeCondition/AdminNewExstionModel.php";
include_once ROOT_DIR . "component/timeCondition/AdminNewNameExstionModel.php";

/**
 * Created by PhpStorm.
 * User: Shabihi
 * Date: 8/14/2018
 * Time: 3:51 PM
 */
class DependencyService
{
    public function checkDependency($input, $result, $exportType = 'html')
    {
        $result['result']=1;

        $resultExtension = AdminExstionNewModel::getBy_dst_option_sub_id_and_dst_option_id_and_comp_id($input['id'], $input['dst_option_id'], $input['comp_id'])->getList();

        if ($resultExtension['export']['recordsCount'] >= 1) {
            foreach ($resultExtension['export']['list'] as $key => $value) {
                $result['msg'][] = 'This ' . $input['name'] . ' has been used by this Success Extension : ' . $value['extension_name'];
            }
        }

        $resultExtension = AdminExstionNewModel::getBy_fdst_option_sub_id_and_fdst_option_id_and_comp_id($input['id'], $input['dst_option_id'], $input['comp_id'])->getList();
        if ($resultExtension['export']['recordsCount'] >= 1) {
            foreach ($resultExtension['export']['list'] as $key => $value) {
                $result['msg'][] = 'This ' . $input['name'] . ' has been used by this Faild Extension : ' . $value['extension_name'];
            }
        }

        $resultTimeCondition = AdminNewExstionModel::getBy_dst_option_sub_id_and_dst_option_id_and_comp_id($input['id'], $input['dst_option_id'], $input['comp_id'])->getList();
        if ($resultTimeCondition['export']['recordsCount'] >= 1) {
            foreach ($resultTimeCondition['export']['list'] as $key => $value) {
                $timeConditonName = AdminNewNameExstionModel::getBy_id($value['time_condtion_name_id'])->getList();
                $result['msg'][] = 'This ' . $input['name'] . ' has been used by this Timecondition : ' . $timeConditonName['export']['list']['0']['name'];
            }
        }

        $resultTimeCondition = AdminNewExstionModel::getBy_fdst_option_sub_id_and_fdst_option_id_and_comp_id($input['id'], $input['dst_option_id'], $input['comp_id'])->getList();
        if ($resultTimeCondition['export']['recordsCount'] >= 1) {
            foreach ($resultTimeCondition['export']['list'] as $key => $value) {
                $timeConditonName = AdminNewNameExstionModel::getBy_id($value['time_condtion_name_id'])->getList();
                $result['msg'][] = 'This ' . $input['name'] . ' has been used by this Faild Timecondition : ' . $timeConditonName['export']['list']['0']['name'];
            }
        }

        $resultTimeCondition = AdminMainTimeConditionDetailModel::getBy_dst_option_sub_id_and_dst_option_id_and_comp_id($input['id'], $input['dst_option_id'], $input['comp_id'])->getList();
        if ($resultTimeCondition['export']['recordsCount'] >= 1) {
            foreach ($resultTimeCondition['export']['list'] as $key => $value) {
                $timeConditonName = AdminMainTimeConditionModel::getBy_id($value['timeConditionID'])->getList();
                $result['msg'][] = 'This ' . $input['name'] . ' has been used by this Timecondition : ' . $timeConditonName['export']['list']['0']['name'];
            }
        }

        $resultTimeCondition = AdminMainTimeConditionDetailModel::getBy_fdst_option_sub_id_and_fdst_option_id_and_comp_id($input['id'], $input['dst_option_id'], $input['comp_id'])->getList();
        if ($resultTimeCondition['export']['recordsCount'] >= 1) {
            foreach ($resultTimeCondition['export']['list'] as $key => $value) {
                $timeConditonName = AdminMainTimeConditionModel::getBy_id($value['timeConditionID'])->getList();
                $result['msg'][] = 'This ' . $input['name'] . ' has been used by this Faild Timecondition : ' . $timeConditonName['export']['list']['0']['name'];
            }
        }

        $resultAnnounce = AdminAnnounceModel::getBy_dst_option_sub_id_and_dst_option_id_and_comp_id($input['id'], $input['dst_option_id'], $input['comp_id'])->getList();
        if ($resultAnnounce['export']['recordsCount'] >= 1) {
            foreach ($resultAnnounce['export']['list'] as $key => $value) {
                $result['msg'][] = 'This ' . $input['name'] . ' has been used by this Announcement : ' . $value['announce_name'];
            }
        }

        $resultQueue = AdminQueueModel::getBy_dst_option_sub_id_and_dst_option_id_and_comp_id($input['id'], $input['dst_option_id'], $input['comp_id'])->getList();
        if ($resultQueue['export']['recordsCount'] >= 1) {
            foreach ($resultQueue['export']['list'] as $key => $value) {
                $result['msg'][] = 'This ' . $input['name'] . ' has been used by this Queue : ' . $value['queue_name'];
            }
        }

        $resultInbound = AdminInboundModel::getBy_dst_option_sub_id_and_dst_option_id_and_comp_id($input['id'], $input['dst_option_id'], $input['comp_id'])->getList();
        if ($resultInbound['export']['recordsCount'] >= 1) {
            foreach ($resultInbound['export']['list'] as $key => $value) {
                $result['msg'][] = 'This ' . $input['name'] . ' has been used by this Inbound : ' . $value['inbound_name'];
            }
        }

        $resultIvr = AdminIVRDSTModel::getBy_dst_option_sub_id_and_dst_option_id($input['id'], $input['dst_option_id'])->getList();
        if ($resultIvr['export']['recordsCount'] >= 1) {
            foreach ($resultIvr['export']['list'] as $key => $value) {
                $ivrId = AdminIVRModel::getBy_ivr_id_and_comp_id($value['ivr_id'], $input['comp_id'])->getList();
                $result['msg'][] = 'This ' . $input['name'] . ' has been used by this Ivr : ' . $ivrId['export']['list']['0']['ivr_name'];
            }
        }

        if ($input['name'] == 'Sip') {
            $resultSip = AdminOutboundModel::getBy_siptrunk_id_and_comp_id($input['id'], $input['comp_id'])->getList();
            if ($resultSip['export']['recordsCount'] >= 1) {
                foreach ($resultSip['export']['list'] as $key => $value) {
                    $result['msg'][] = 'This ' . $input['name'] . ' has been used by this Outbound : ' . $value['outbound_name'];
                }
            }
        }

        if ($input['name'] == 'voiceMail') {
            $resultExtension = AdminExstionNewModel::getBy_dialExtension_and_sub_dst_and_comp_id($input['name'], $input['id'], $input['comp_id'])->getList();
            if ($resultExtension['export']['recordsCount'] >= 1) {
                foreach ($resultExtension['export']['list'] as $key => $value) {
                    $result['msg'][] = 'This ' . $input['name'] . ' has been used by this Extension : ' . $value['extension_name'];
                }

            }
            $resultTimeCondition = AdminMainTimeConditionDetailModel::getBy_dialExtension_and_sub_dst_and_comp_id($input['name'], $input['id'], $input['comp_id'])->getList();
            if ($resultTimeCondition['export']['recordsCount'] >= 1) {
                foreach ($resultTimeCondition['export']['list'] as $key => $value) {
                    $timeConditonName = AdminMainTimeConditionModel::getBy_id($value['timeConditionID'])->getList();
                    $result['msg'][] = 'This ' . $input['name'] . ' has been used by this Timecondition : ' . $timeConditonName['export']['list']['0']['name'];
                }
            }
        }
        if ($input['dst_option_id'] == 9) {
            $resultExtension = AdminExstionNewModel::getBy_DSTOption_and_dst_option_id_and_comp_id($input['id'], $input['dst_option_id'], $input['comp_id'])->getList();
            if ($resultExtension['export']['recordsCount'] >= 1) {
                foreach ($resultExtension['export']['list'] as $key => $value) {
                    $result['msg'][] = 'This ' . $input['name'] . ' has been used by this Success Extension : ' . $value['extension_name'];
                }
            }

            $resultExtension = AdminExstionNewModel::getBy_DSTOption_and_dst_option_id_and_comp_id($input['id'], $input['dst_option_id'], $input['comp_id'])->getList();
            if ($resultExtension['export']['recordsCount'] >= 1) {
                foreach ($resultExtension['export']['list'] as $key => $value) {
                    $result['msg'][] = 'This ' . $input['name'] . ' has been used by this Faild Extension : ' . $value['extension_name'];
                }
            }

            $resultTimeCondition = AdminNewExstionModel::getBy_DSTOption_and_dst_option_id_and_comp_id($input['id'], $input['dst_option_id'], $input['comp_id'])->getList();
            if ($resultTimeCondition['export']['recordsCount'] >= 1) {
                foreach ($resultTimeCondition['export']['list'] as $key => $value) {
                    $timeConditonName = AdminNewNameExstionModel::getBy_id($value['time_condtion_name_id'])->getList();
                    $result['msg'][] = 'This ' . $input['name'] . ' has been used by this Timecondition : ' . $timeConditonName['export']['list']['0']['name'];
                }
            }


            $resultTimeCondition = AdminNewExstionModel::getBy_fDSTOption_and_fdst_option_id_and_comp_id($input['id'], $input['dst_option_id'], $input['comp_id'])->getList();
            if ($resultTimeCondition['export']['recordsCount'] >= 1) {
                foreach ($resultTimeCondition['export']['list'] as $key => $value) {
                    $timeConditonName = AdminNewNameExstionModel::getBy_id($value['time_condtion_name_id'])->getList();
                    $result['msg'][] = 'This ' . $input['name'] . ' has been used by this Faild Timecondition : ' . $timeConditonName['export']['list']['0']['name'];
                }
            }

            $resultTimeCondition = AdminMainTimeConditionDetailModel::getBy_DSTOption_and_dst_option_id_and_comp_id($input['id'], $input['dst_option_id'], $input['comp_id'])->getList();
            if ($resultTimeCondition['export']['recordsCount'] >= 1) {
                foreach ($resultTimeCondition['export']['list'] as $key => $value) {
                    $timeConditonName = AdminMainTimeConditionModel::getBy_id($value['timeConditionID'])->getList();
                    $result['msg'][] = 'This ' . $input['name'] . ' has been used by this Timecondition : ' . $timeConditonName['export']['list']['0']['name'];
                }
            }

            $resultTimeCondition = AdminMainTimeConditionDetailModel::getBy_fDSTOption_and_fdst_option_id_and_comp_id($input['id'], $input['dst_option_id'], $input['comp_id'])->getList();
            if ($resultTimeCondition['export']['recordsCount'] >= 1) {
                foreach ($resultTimeCondition['export']['list'] as $key => $value) {
                    $timeConditonName = AdminMainTimeConditionModel::getBy_id($value['timeConditionID'])->getList();
                    $result['msg'][] = 'This ' . $input['name'] . ' has been used by this Faild Timecondition : ' . $timeConditonName['export']['list']['0']['name'];
                }
            }

            $resultAnnounce = AdminAnnounceModel::getBy_DSTOption_and_dst_option_id_and_comp_id($input['id'], $input['dst_option_id'], $input['comp_id'])->getList();
            if ($resultAnnounce['export']['recordsCount'] >= 1) {
                foreach ($resultAnnounce['export']['list'] as $key => $value) {
                    $result['msg'][] = 'This ' . $input['name'] . ' has been used by this Announcement : ' . $value['announce_name'];
                }
            }

            $resultQueue = AdminQueueModel::getBy_DSTOption_and_dst_option_id_and_comp_id($input['id'], $input['dst_option_id'], $input['comp_id'])->getList();
            if ($resultQueue['export']['recordsCount'] >= 1) {
                foreach ($resultQueue['export']['list'] as $key => $value) {
                    $result['msg'][] = 'This ' . $input['name'] . ' has been used by this Queue : ' . $value['queue_name'];
                }
            }

            $resultInbound = AdminInboundModel::getBy_DSTOption_and_dst_option_id_and_comp_id($input['id'], $input['dst_option_id'], $input['comp_id'])->getList();
            if ($resultInbound['export']['recordsCount'] >= 1) {
                foreach ($resultInbound['export']['list'] as $key => $value) {
                    $result['msg'][] = 'This ' . $input['name'] . ' has been used by this Inbound : ' . $value['inbound_name'];
                }
            }

            $resultIvr = AdminIVRDSTModel::getBy_DSTOption_and_dst_option_id($input['id'], $input['dst_option_id'])->getList();
            if ($resultIvr['export']['recordsCount'] >= 1) {
                foreach ($resultIvr['export']['list'] as $key => $value) {
                    $ivrId = AdminIVRModel::getBy_ivr_id_and_comp_id($value['ivr_id'], $input['comp_id'])->getList();
                    $result['msg'][] = 'This ' . $input['name'] . ' has been used by this Ivr : ' . $ivrId['export']['list']['0']['ivr_name'];
                }
            }
        }
        return $result;
    }
}