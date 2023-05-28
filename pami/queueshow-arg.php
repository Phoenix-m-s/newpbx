<?php

    $num = $_GET['qnum'];

    exec("asterisk -rx \"queue show $num\"|sed -r \"s/\x1B\[([0-9];)?([0-9]{1,2}(;[0-9]{1,2})?)?[mGK]//g\"",$out1);
    $array=$out1;
    $start=1;
    $start_members=0;
    $start_callers=0;
    $count=0;
    $count_member=0;

    foreach ($array as $key=>$val)
    {

        $val=trim($val);
        //echo '<br/>***<br/>';
        //print_r($val);
        //echo '<br/>***<br/>';

       if($val=='')
       {

           $start=1;
          // echo '<br/>alan<br/>';
           continue;
       }elseif($val=='Members:')
       {
           $start_members=1;
           continue;

       }else if($start_members==1 and $val=='No Callers')
       {


           $export[$count-1]['member'][$count_member]['3']='No Callers';
           $count_member=0;
           $start_members=2;
           continue;
       }else if($start_members==1 and $val=='Callers:')
       {
           $start_callers=1;
           $start_members=2;
           continue;
       }
        if($start_callers==1)
        {
            $start_callers=2;
            $export[$count-1]['member'][$count_member]['3']=$val;

        }
        if($start_members==1)
        {

            $start=2;
            $temp=explode(' ',$val);
            $export[$count]['member'][$count_member]['0']=$temp['0'];
            $temp2=explode('(',$val);
            $pointer=count($temp2)-1;

            //print_r($val);
             if(strpos($val,'In use')!=false)
            {
                $export[$count]['member'][$count_member]['1']='In use';
            }else if(strpos($val,'Unavailable'))
            {
                $export[$count]['member'][$count_member]['1']='Unavailable';
            } else if(strpos($val,'Not in use'))
            {
                $export[$count]['member'][$count_member]['1']='Not in use';
            }

            if(strpos('has taken no calls yet',$val))
            {
                $export[$count]['member'][$count_member]['2']='no';
            }
            else
            {
                //$export[$count]['member'][$count_member]['1']=substr($pointer,1);
                $export[$count]['member'][$count_member]['2']=substr($temp2[count($temp2)-1],0,-1);
                $mystring =$temp2[$pointer] ;
                $findme   = 'last was';
                $pos = strpos($mystring, $findme);

                if($pos === false)
                {

                }else
                {
                    $pointer--;
                }
                $count++;
                //echo 'pointer= ';
                //print_r($pointer);
               // echo '<br/>';


            }


        }

        if($start==1)
        {

            $start=2;
            $temp=explode(' ',$val);
            //print_r($temp);
            $export[$count]['queue name']=$temp[0];
            $export[$count]['online-calls']=$temp[2];
            $export[$count]['call Strategy']=$temp[7];
            $export[$count]['holdtime']= substr($temp[9],1);

            $export[$count]['talktime']=$temp[11];
            //$findme   = 'strategy (';
            //$pos = strpos($val, $findme);
            //print_r($export);
           // die();
        }
    }

  //  print_r($export);
    $out2=json_encode($export);
    print_r($out2);


s

?>
