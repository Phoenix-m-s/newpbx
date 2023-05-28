<?php

/**
 * Created by PhpStorm.
 * User: malek
 * Date: 4/25/2016
 * Time: 10:19 AM
 */

class InboundSort
{

     private $index;
     static function sort($array)
     {

          global $index;
          $obj=new InboundSort();
          $sort_step0=$obj->sortWithDot($array);
          $result['0']=$obj->sortInbound($sort_step0['WithOutDot']);
          $obj->index='';
          $result['1']=$obj->sortInbound($sort_step0['WithDot']);
          $array=array_merge($result['0'],$result['1']);
          return $array;


     }

     function sortInbound($array)
     {

          $sort_step1 = $this->sortByStrlen($array);


          foreach ($sort_step1 as $key => $val)
          {
               $sort_step2[$key] = $this->sortByStrlendigit($val);
          }

          /*echo '<pre/>';
          print_r($sort_step2);
          echo '<br/>**********************************<br/>';*/

          foreach ($sort_step2 as $key => $val) {

               foreach ($val as $arrayListKey => $arrayListVal) {

                    foreach ($arrayListVal as $finalKey => $finalVal)
                    {
                         $sortByStrlenXNZ[$key][$arrayListKey][$this->convertinbooundToLoo($finalVal['did_name'])] = $finalVal;
                    }
                    ksort($sortByStrlenXNZ[$key][$arrayListKey]);
               }

          }

          ///print_r($sortByStrlenXNZ);
          $bindArray = $this->bindArray($sortByStrlenXNZ, '');
          //echo '<pre/><br/>********************$bindArray***************************<br/>';
          //print_r($bindArray);
          //die();

          return $bindArray;

     }

     function sortWithDot($array)
     {


          foreach ($array as $key => $val)
          {
               //echo '<pre/><br/>********************$bindArray***************************<br/>';
               if (strpos($val['did_name'], '.') == true)
               {
                    $sort_step0['WithDot'][] = $val;
               } else
               {
                    $sort_step0['WithOutDot'][] = $val;
               }
          }

          krsort($sort_step0, 0);
          return $sort_step0;
     }

     function sortByStrlen($array)
     {

          foreach ($array as $key => $val) {
               $count = strlen($val['did_name']);
               $sort_step1[$count][] = $val;
          }

          krsort($sort_step1, 0);
          return $sort_step1;
     }

     function sortByStrlendigit($array)
     {

          foreach ($array as $key => $val) {
               $newVal = str_replace('X', '', $val['did_name']);
               $newVal = str_replace('Z', '', $newVal);
               $newVal = str_replace('N', '', $newVal);

               $count = strlen($newVal);
               $sort_step2[$count][] = $val;
          }

          krsort($sort_step2, 0);
          return $sort_step2;
     }

     function sortByStrlenXNZ($array)
     {

          foreach ($array as $key => $val) {
               $newVal = str_replace('X', '500', $val);
               $newVal = str_replace('Z', '600', $newVal);
               $newVal = str_replace('N', '7000', $newVal);
               $count = strlen($newVal);
               $sort_step3[$newVal] = $val;
          }
          krsort($sort_step3);
          return $sort_step3;
     }

     function bindArray($_input)
     {

          //echo '<br/>****************************<br/>';


          $input_array = Array();
          $temp=array_keys($_input);

          if (is_array($_input) and !array_key_exists('did_name',$_input))
          {
               foreach ($_input as $key => $val)
               {
                    $this->bindArray($val);
               }
          } else {
               $this->index[] = $_input;

          }
          return $this->index;
     }


     function convertinbooundToLoo($c)
     {
          $len = strlen($c) - 1;
          $p = 1;
          $temp = 0;


          for ($i = $len; $i >= 0; $i--) {
               $t = $c[$i];
               //echo $t.'<br/>';

               switch ($t) {
                    case 'N':
                         $temp += 10 * $p;
                         break;
                    case 'Z':
                         $temp += 11 * $p;
                         break;
                    case 'X':
                         $temp += 12 * $p;
                         break;
                    default:
                         $temp += (int)$t * (int)$p;
                         break;
               }
               $p = $p * 13;
          }
          return $temp;

     }
}

/*$a['2']['0']['comp_name']='sean1';
$a['2']['0']['did_name']='24NX.';

$a['2']['1']['comp_name']='sean2';
$a['2']['1']['did_name']='22XXXXXX';

$a['2']['2']['comp_name']='sean3';
$a['2']['2']['did_name']='22XXXXX';

$a['2']['3']['comp_name']='sean4';
$a['2']['3']['did_name']='242XXXX';

$a['2']['4']['comp_name']='sean5';
$a['2']['4']['did_name']='232XXXX';
$result=InboundSort::sort($a['2']);
echo '<pre/>';
print_r($result);
die('');*/
/*$array['0']='111';//1
$array['1']='11X';//2//
$array['2']='1X1';//2//
$array['3']='X11.';//2//
$array['8']='N11';//2//

$array['4']='1XX.';//3
$array['5']='XXX';//4
$array['6']='XX1.';//3
$array['7']='X1X';//3

$array['9']='X11X';//3
$array['10']='X111X';//3*/
echo '<pre/>';
//$result=InboundSort::sort($array);

print_r($result);
