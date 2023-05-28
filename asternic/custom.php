<?php

function test_format($valor,$base=5) {
    $valores_return = Array();
    $width1 = 16 * $base;
    $valores[] = $base;
    $valores[] = $valor;
    $width2 = min($valores) * 16;
    $valores_return[] = "<span class='stars helptop' title='$valor' style='width: ${width1}px'><span style='width: ${width2}px'></span></span>";
    $valores_return[] = $valor;
    return $valores_return;
}

function encuesta_format($valor) {
    $valores_return = Array();
    if($valor==1) {
        $valores_return[] = "<span class='label label-success'><i class='icon-star icon-white'></i></span>";
    } else if($valor==2) {
        $valores_return[] = "<span class='label label-important'><i class='icon-star icon-white'></i></span>";
    } else {
        $valores_return[] = "<i class='icon-star-empty'></i>";
    }
    $valores_return[] = $valor;
    return $valores_return;
}

function realtime_clidnum_filter($clid) {
    return $clid;
}

function realtime_clidname_filter($clidname) {
    return $clidname;
}

function realtime_agent_availability_override(&$color) {
    global $db;
    $result = array();
    return $result;
    $query = "select agent from workschedule left join qagent on qagent=agent_id where day=dayofweek(now()) and start <= ceil(time_to_sec(now())/60) and end >= ceil(time_to_sec(now())/60)";
    $res = $db->consulta($query);
    $color['fault']='#a93';
    while($row=$db->fetch_assoc($res)) {
        $result[agent_name($row['agent'])]='fault';
    }
    return $result;
}

function custom_distribution_style($idx,$field,$value) {
      $idx=$idx-2;
      $res = ceil($idx/3);
      $gradient=array();
      $gradient[1]='#CCFFCC';
      $gradient[2]='#A4EE92';
      $gradient[3]='#00FF00';
      $gradient[4]='#FFFF00';
      $gradient[5]='#FFBB22';
      $gradient[6]='#FFAA55';
      if(isset($gradient[$res])) {
          $return="style='background-color: $gradient[$res];'";
      } else {
          $return="";
      }
      return $return;
}

