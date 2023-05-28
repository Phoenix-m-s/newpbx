<?php
include_once ROOT_DIR . "component/conference/model/ConferenceModel.php";
include_once ROOT_DIR . "component/conference/model/ConferencePivoteModel.php";
include_once ROOT_DIR . "component/conference/model/PhoneModel.php";
include_once ROOT_DIR . "services/ExtensionService.php";
/**
 * Class ConferenceService
 * @author:Mojtaba Sakhamanesh & Jahanabakhsh
 * @Email:sakhamanesh@dabacenter.ir
 */
class ConferenceService
{
    public function getAllConference()
    {
        global $admin_info, $member_info;

        $conferenceDirty = ConferenceModel::getAll()
        ->where('comp_id', '=', $admin_info['comp_id']);

        if (is_array($member_info)) {
            $conferenceDirty->where('creator_id', '=', $member_info['extension_id']);
        }

        $result = $conferenceDirty->getlist();
        $result = $result['export']['list'];
        for($i=0; $i < sizeof($result); $i++){
            $result[$i]['name'] = $result[$i]['conf_name'];
            $result[$i]['id'] = $result[$i]['conf_id'];
        }
       /* array_unshift($result,array('name' => 'choose from list', 'id' => ''));*/

        /*  $result['0'] = array('name' => 'choose from list', 'id' => '');
          $i = 1;*/


        return $result;
    }


    //check Conference Name and Number _zj
    public function checkConferenceName($conferenceObj)
    {
        //select * from ConferenceModel where comp_id='1'
        // and (conf_name='test' or conf_number='555')
        // and conf_id<> $conferenceObj->conf_id )
        $conference=ConferenceModel::getAll()
            ->where('comp_id','=',$conferenceObj->comp_id)
            ->whereOpen('conf_name','=',$conferenceObj->conf_name)
            ->orWhereClose('conf_number','=',$conferenceObj->conf_number);

        if($conferenceObj->conf_id!='')
        {
            $conference->where('conf_id','<>',$conferenceObj->conf_id);
        }
        //dd($conference->first());

        return $conference->first();
    }


    public function checkpermission(ConferenceModel $conference)
    {
        global $admin_info,$member_info;

        $res['result']=1;

        if(is_array($member_info) and  $conference->creator_id!=$member_info['extension_id'])
        {
            $res['result']=-1;
            $res['no']=101;

        }
        return $res;

    }
    public function checkQueueNumber($fields)
    {

        return adminQueueModel::getBy_queue_ext_no_and_comp_id_and_not_queue_id($fields['conf_number'], $fields['comp_id'], $fields['conf_id'])->getList();
    }



    public function editConference($fields)
    {

        //$a['result']=1;
        //$a['msg']='gggg';

        //return $a;
        global $company_info, $admin_info, $member_info;

        $conferenceObj = ConferenceModel::find($fields['conf_id']);

        /*$checkPermission = $this->checkpermission($conferenceObj);
        if ($checkPermission['result'] == -1) {
            return $checkPermission;
        }*/

        /*-for test-*/
        //$fields= $this->TestInput();
        if (!is_object($conferenceObj)) {
            $result['msg'] = 'this conference not exist';
        }


        $checkQueueNumber = $this->checkQueueNumber($fields);
        if (is_object($checkQueueNumber)) {
            $result['result'] = -1;
            $result['msg'] = 'this queue number is exist';
            return $result;
        }
        //

        $this->comp_id = $company_info['comp_id'];


        $conferenceObj->setFields($fields);

        //get data
        if (is_array($admin_info)) {
            $conferenceObj->comp_id = $admin_info['comp_id'];
            $conferenceObj->creator_type = '1';
            $conferenceObj->creator_id = $admin_info['admin_id'];
        } else {
            $conferenceObj->comp_id = $member_info['comp_id'];
            $conferenceObj->creator_type = '2';
            $conferenceObj->creator_id = $member_info['extension_id'];
        }

        $validate = $conferenceObj->validator();
        if ($validate['result'] == -1) {
            $result['msg'] = $validate['msg'];
            $result['result'] = -1;
            return $result;
        }

        //checkConferenceName
        $checkConference = $this->checkConferenceName($conferenceObj);

        if (is_object($checkConference)) {
            $result['result'] = -1;
            $result['msg'] = 'this conference name is exist';
            return $result;
        }
        //checkqueueNumber


        //save tbl:conference
        $result = $conferenceObj->save();

        if ($result['result'] == -1) {
            $result['msg'] = 'Failed To add';
        }

        //delete tbl:conference_pivote
        $ConferencePivoteModel = new ConferencePivoteModel();
        $model = $ConferencePivoteModel::getBy_conf_id($fields['conf_id'])->get();

        if ($model['export']['recordsCount'] >= 1) {

            foreach ($model['export']['list'] as $value) {
                $result = $value->delete();

            }

        }


        if (($fields['all_extension_list'] == 1)) {
            $extentionList = new ExtensionService();
            $fields['extentionList'] = $extentionList->getAllExtensionName();

            $confExtention = new ConferencePivoteModel();
            $confExtention->conf_id = $fields['conf_id'];
            $confExtention->number_id = 0;
            $confExtention->number_type = 3;
            $result = $confExtention->save();
            if ($result['result'] == -1) {
                $result['msg'] = 'Failed To add';
                return $result;
            }
            $company = new companyService();
            $result = $company->activeRelaod($company_info['comp_id']);

            return $result;

        }else {


            if ((count($fields['extention_id'])==0) && empty($fields['phone_number'])){
                $result['result'] = -1;
                if ($result['result'] == -1) {
                    $result['msg'] = 'Please select Phone Number and extention';
                    return $result;
                }

            }

                //extention
            foreach ($fields['extention_id'] as $key => $value) {
                $confExtention = new ConferencePivoteModel();
                $confExtention->conf_id = $fields['conf_id'];
                $confExtention->number_id = $value;
                $confExtention->number_type = 1;

//            $confExtention->setFields($confExtention);

                $result = $confExtention->save();
                if ($result['result'] == -1) {
                    $result['msg'] = 'Failed To add';
                    return $result;
                }

            }
            //tbl:phone
            //save tbl:phone
            if (isset($fields['phone_number']) && !empty($fields['phone_number'])) {


                $phoneList = explode(',', $fields['phone_number']);
                foreach ($phoneList as $key => $value) {
                    $conference_pivote = new ConferencePivoteModel();

                    $phone = PhoneModel::getAll()
                        ->where('phone_number', '=', $value)
                        ->first();

                    if (!is_object($phone)) {
                        $phone = new PhoneModel();
                        $phone->phone_number = $value;
                        $phone->save();
                    }
                    $conference_pivote->number_id = $phone->phone_id;

                    /*if(is_object($checkPhoneExist)){

                        $conference_pivote->number_id =$checkPhoneExist->phone_id;
                    }else
                    {
                        $phone= new PhoneModel();
                        $phone->number_id=$value;
                        $phone->save();
                        $conference_pivote->number_id =$phone->phone_id;

                    }*/

                    $conference_pivote->number_type = 2;
                    $conference_pivote->conf_id = $conferenceObj->conf_id;

                    $result = $conference_pivote->save();
                    if ($result['result'] == -1) {
                        $result['msg'] = 'Failed To add';
                        return $result;
                    }

                }

                //tbl: conference_pivote
                //add phone_number
                // $phoneList=explode(',',$fields['phone_number']);


            }


//        if (isset($fields['phone_number']))
//        {
//            $phoneList=explode(',',$fields['phone_number']);
//
//            foreach ($phoneList as $key => $value) {
//                $conference_pivote = new ConferencePivoteModel.php();
//                $conference_pivote->number_id = $value;
//                $conference_pivote->number_type = 2;
//                $conference_pivote->conf_id = $fields['conf_id'];
//
//                $result = $conference_pivote->save();
//                if ($result['result'] == -1) {
//                    $result['msg'] = 'Failed To add';
//                    return $result;
//                }
//
//            }
//
//            //tbl: conference_pivote
//            //add phone_number
//            $phoneList=explode(',',$fields['phone_number']);
//
//            //************delete record and again save
//            $PhoneModel = new PhoneModel();
//            //$PhoneAll = $PhoneModel::getAll();
//
//            $component = $PhoneModel::getBy_phone_number($fields['phone_number'])->get();
//
//            //**********select * from phone where phone_number = $fields['phone_number']
//            //$fields['phone_number'] array
////            print_r_debug(($component));
//
//            ////////////////
////            $timeCondition = $timeConditionModel::getBy_timeConditionID($fields['timeConditionID'])->get();
////                        foreach ($timeCondition['export']['list'] as $timeCondition) {
////                            $timeCondition->delete();
////                        }
//
//
//            if ($component['export']['recordsCount'] >= 1) {
//
//                foreach ($component['export']['list'] as $value) {
//                    $result = $value->delete();
//                    if ($result['result'] != 1) {
//                        return $result;
//                    }
//                }
//            }
//
//            //************delete record and again save
//
//            foreach ($phoneList as $key => $value) {
//                $confExtention = new PhoneModel();
//                $confExtention->phone_number = $value;
//                $confExtention->setFields($confExtention);
//
//                $result = $confExtention->save();
//                if ($result['result'] == -1) {
//                    $result['msg'] = 'Failed To add';
//                    return $result;
//                }
//
//            }
//
//        }


            $company = new companyService();
            $result = $company->activeRelaod($company_info['comp_id']);

            return $result;

        }
    }


        public function addConference($fields)
    {
        global $admin_info, $company_info, $member_info;

        //conditions for  extention OR phone is empty  zjb
        /*     if (($fields['extention_id']=='') && ($fields['phone_number']==''))
             {
                 $result['result'] = -1;
                 $result['msg'] = 'select extention  Or phone is required!';
                 return $result;
             }*/

        $checkQueueNumber = $this->checkQueueNumber($fields);
        if (is_object($checkQueueNumber)) {
            $result['result'] = -1;
            $result['msg'] = 'this queue number is exist';
            return $result;
        }

        /*-for test-*/
        /* $fields= $this->TestInput();*/


        //tbl conference
        $conferenceObj = new ConferenceModel();
        $conferenceObj->setFields($fields);

        //get data
        if (is_array($admin_info)) {
            $conferenceObj->comp_id = $admin_info['comp_id'];
            $conferenceObj->creator_type = '1';
            $conferenceObj->creator_id = $admin_info['admin_id'];
        }
        else {
            $conferenceObj->comp_id = $member_info['comp_id'];
            $conferenceObj->creator_type = '2';
            $conferenceObj->creator_id = $member_info['extension_id'];
        }


        //validator
        $validate = $conferenceObj->validator();
        if ($validate['result'] == -1) {
            $result['msg'] = $validate['msg'];
            $result['result'] = -1;
            return $result;
        }



        //check Conference Name and Number _zj
        $checkConference = $this->checkConferenceName($conferenceObj);
        if (is_object($checkConference)) {
            $result['result'] = -1;
            $result['msg'] = 'this conference Name Or conference Number is exist';
            return $result;
        }





        //save tbl:conference
        $result = $conferenceObj->save();
        $fields['conf_id'] = $conferenceObj->conf_id;

        if ($result['result'] == -1) {
            $result['msg'] = 'Failed To add';
            return $result;
        }



        //tbl: conference_pivote
        if (($fields['all_extension_list']==1)){
            $extentionList = new ExtensionService();
            $fields['extentionList'] = $extentionList->getAllExtensionName();

            $confExtention = new ConferencePivoteModel();
            $confExtention->conf_id = $conferenceObj->conf_id;
            $confExtention->number_id = 0;
            $confExtention->number_type = 3;
            //$confExtention->setFields($confExtention);
            $result = $confExtention->save();
            if ($result['result'] == -1) {
                $result['msg'] = 'Failed To add';
                return $result;
            }

        }
        else{
            //tbl:phone
            foreach ($fields['extention_id'] as $key => $value) {
                $confExtention = new ConferencePivoteModel();
                $confExtention->conf_id = $conferenceObj->conf_id;
                $confExtention->number_id = $value;
                $confExtention->number_type = 1;

                //$confExtention->setFields($confExtention);

                $result = $confExtention->save();
                if ($result['result'] == -1) {
                    $result['msg'] = 'Failed To add';
                    return $result;
                }

            }




            if (isset($fields['phone_number']) && !empty($fields['phone_number'])) {
                $phoneList = explode(',', $fields['phone_number']);
                foreach ($phoneList as $key => $value) {
                    $conference_pivote = new ConferencePivoteModel();

                    $phone = PhoneModel::getAll()
                        ->where('phone_number', '=', $value)
                        ->first();

                    if (!is_object($phone)) {
                        $phone = new PhoneModel();
                        $phone->phone_number = $value;
                        $phone->save();
                    }
                    $conference_pivote->number_id = $phone->phone_id;

                    /*if(is_object($checkPhoneExist)){

                        $conference_pivote->number_id =$checkPhoneExist->phone_id;
                    }else
                    {
                        $phone= new PhoneModel();
                        $phone->number_id=$value;
                        $phone->save();
                        $conference_pivote->number_id =$phone->phone_id;

                    }*/

                    $conference_pivote->number_type = 2;
                    $conference_pivote->conf_id = $conferenceObj->conf_id;

                    $result = $conference_pivote->save();
                    if ($result['result'] == -1) {
                        $result['msg'] = 'Failed To add';
                        return $result;
                    }

                }

                //tbl: conference_pivote
                //add phone_number
                // $phoneList=explode(',',$fields['phone_number']);


            }
        }


        $company = new companyService();
        $result = $company->activeRelaod($company_info['comp_id']);
        return $result;
    }


        public function deleteConferenceByConferenceId($id)
    {
        global $admin_info,$member_info;

        $conferenceObj = ConferenceModel::find($id);


        if (!is_object($conferenceObj)) {
            $conferenceObj['msg'] = 'this conference not exist';
            return $conferenceObj;
        }
        $checkPermission =$this->checkpermission($conferenceObj);

        if($checkPermission['result']==-1)
        {
            return $checkPermission;
        }


        $result = $conferenceObj->delete();
        /// ConferencePivoteModel.php

        $ConferencePivoteModel = new ConferencePivoteModel();
        $model = $ConferencePivoteModel::getBy_conf_id($id)->get();
        if ($model['export']['recordsCount'] >= 1) {
            foreach ($model['export']['list'] as $value) {
                $result = $value->delete();
                /*if ($result['result'] != 1) {
                    return $result;
                }*/
            }
        }

        return $result;

        ///

    }

    }